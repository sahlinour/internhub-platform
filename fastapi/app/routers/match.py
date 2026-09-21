import re
from fastapi import APIRouter, HTTPException
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

from app.schemas import MatchRequest, MatchResponse
from app.utils import (
    clean_text,
    calculate_level_weight,
    extract_skills_from_text,
)

router = APIRouter(
    prefix="/api",
    tags=["Matching Engine"]
)

vectorizer = TfidfVectorizer(ngram_range=(1, 2))

@router.post("/match", response_model=MatchResponse)
async def match_stagiaire(request: MatchRequest):
    stagiaire = request.stagiaire
    offre = request.offre

    # 1. Candidate skills extraction (normalized)
    candidate_skills = [
        c.nom_competence.strip()
        for c in stagiaire.competences
        if c.nom_competence
    ]
    candidate_skills_lower = {s.lower(): s for s in candidate_skills}

    # Corpus building
    stagiaire_corpus = (
        f"{stagiaire.filiere or ''} "
        f"{stagiaire.niveau or ''} "
        f"{stagiaire.cv_text or ''} "
        + " ".join(candidate_skills)
    )
    stagiaire_clean = clean_text(stagiaire_corpus)

    offre_corpus = f"{offre.titre or ''} {offre.description or ''}"
    offre_clean = clean_text(offre_corpus)

    if not stagiaire_clean or not offre_clean:
        raise HTTPException(
            status_code=400,
            detail="Insufficient profile or offer data to perform matching"
        )

    # 2. TF-IDF Similarity
    try:
        tfidf_matrix = vectorizer.fit_transform([stagiaire_clean, offre_clean])
        raw_similarity = float(cosine_similarity(tfidf_matrix[0:1], tfidf_matrix[1:2])[0][0])
    except Exception:
        raw_similarity = 0.0

    # 3. Required Skills Aggregation
    explicit_skills = offre.required_skills or []
    
    # Extract skills from offer text using known_skills passed from Laravel or candidate skills
    known = getattr(offre, 'known_skills', []) or candidate_skills
    extracted_skills = extract_skills_from_text(offre_corpus, known)

    required_offer_skills = list(set(explicit_skills + extracted_skills))

    matching_skills = []
    missing_skills = []
    weighted_skill_points = 0.0

    # 4. Matching Logic
    if required_offer_skills:
        for req_skill in required_offer_skills:
            req_lower = req_skill.strip().lower()
            
            # Substring / Exact match against candidate skills
            found_match = None
            for cand_lower, cand_original in candidate_skills_lower.items():
                if cand_lower == req_lower or cand_lower in req_lower or req_lower in cand_lower:
                    found_match = cand_original
                    break

            if found_match:
                matching_skills.append(found_match)
                weighted_skill_points += 25.0  # 25 points per matched skill
            else:
                missing_skills.append(req_skill)
    else:
        # Fallback: scan candidate skills in offer text
        for cand_lower, cand_original in candidate_skills_lower.items():
            pattern = r"(?<!\w)" + re.escape(cand_lower) + r"(?!\w)"
            if re.search(pattern, offre_corpus.lower()):
                matching_skills.append(cand_original)
                weighted_skill_points += 25.0

    # 5. Final Score Calculation (Percentage)
    base_tfidf = raw_similarity * 100
    
    if required_offer_skills:
        # Overlap ratio percentage
        skill_match_ratio = (len(matching_skills) / len(required_offer_skills)) * 100
        final_score = int((skill_match_ratio * 0.7) + (base_tfidf * 0.3))
    else:
        final_score = int((min(100.0, weighted_skill_points) * 0.6) + (base_tfidf * 0.4))

    # Boost score if at least 1 direct skill match was found
    if matching_skills and final_score < 30:
        final_score = 40 + (len(matching_skills) * 10)

    final_score = max(5, min(100, final_score))

    # 6. Reasoning Output
    reasoning = (
        f"Match percentage: {final_score}%. "
        f"Matched skills ({len(matching_skills)}): {', '.join(matching_skills) if matching_skills else 'None'}. "
        f"Missing skills: {', '.join(missing_skills) if missing_skills else 'None'}."
    )

    return MatchResponse(
        match_percentage=final_score,
        matching_skills=sorted(list(set(matching_skills))),
        missing_skills=sorted(list(set(missing_skills))),
        vector_similarity_score=round(raw_similarity, 4),
        reasoning=reasoning
    )