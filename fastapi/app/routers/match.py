# app/routers/match.py
import re
from fastapi import APIRouter, HTTPException
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

from app.schemas import MatchRequest, MatchResponse
from app.utils import clean_text, calculate_level_weight, extract_skills_from_text

router = APIRouter(prefix="/api", tags=["Matching Engine"])

vectorizer = TfidfVectorizer(ngram_range=(1, 2))

@router.post("/match", response_model=MatchResponse)
async def match_stagiaire(request: MatchRequest):
    stagiaire = request.stagiaire
    offre = request.offre

    # 1. Prepare raw text and cleaned corpus
    candidate_skills = [c.nom_competence.strip() for c in stagiaire.competences]
    stagiaire_corpus = (
        f"{stagiaire.filiere or ''} {stagiaire.niveau or ''} "
        f"{stagiaire.cv_text or ''} " + " ".join(candidate_skills)
    )
    stagiaire_clean = clean_text(stagiaire_corpus)

    offre_corpus = f"{offre.titre} {offre.description}"
    offre_clean = clean_text(offre_corpus)

    if not stagiaire_clean.strip() or not offre_clean.strip():
        raise HTTPException(
            status_code=400, 
            detail="Insufficient profile or offer data to perform matching"
        )

    # 2. Vector Similarity
    try:
        tfidf_matrix = vectorizer.fit_transform([stagiaire_clean, offre_clean])
        raw_similarity = float(cosine_similarity(tfidf_matrix[0:1], tfidf_matrix[1:2])[0][0])
    except ValueError:
        raw_similarity = 0.0

    # 3. Detect Required Offer Skills
    explicit_skills = offre.required_skills or []
    extracted_skills = extract_skills_from_text(offre_corpus, candidate_skills)
    required_offer_skills = list(set(explicit_skills + extracted_skills))

    # 4. Compare Candidate Competences vs Required Skills
    candidate_skills_map = {c.nom_competence.strip().lower(): c for c in stagiaire.competences}
    matching_skills = []
    missing_skills = []
    weighted_skill_points = 0.0

    if required_offer_skills:
        for skill in required_offer_skills:
            skill_clean = skill.strip().lower()
            if skill_clean in candidate_skills_map:
                matching_skills.append(skill)
                comp = candidate_skills_map[skill_clean]
                weight = calculate_level_weight(comp.niveau)
                weighted_skill_points += (15.0 * weight)
            else:
                missing_skills.append(skill)
    else:
        for comp in stagiaire.competences:
            s_name = comp.nom_competence.strip()
            pattern = r'(?<!\w)' + re.escape(s_name.lower()) + r'(?!\w)'
            if re.search(pattern, offre_corpus.lower()):
                matching_skills.append(s_name)
                weight = calculate_level_weight(comp.niveau)
                weighted_skill_points += (15.0 * weight)

    # 5. Score Calculation
    base_tfidf = raw_similarity * 100
    final_score = int((base_tfidf * 0.4) + min(60.0, weighted_skill_points))
    final_score = max(5, min(100, final_score))

    reasoning = (
        f"Profile matched at {final_score}%. Found {len(matching_skills)} direct skill match(es) "
        f"({', '.join(matching_skills) if matching_skills else 'None'}). "
        f"Missing skills: ({', '.join(missing_skills) if missing_skills else 'None'}). "
        f"TF-IDF content similarity: {round(base_tfidf, 1)}%."
    )

    return MatchResponse(
        match_percentage=final_score,
        matching_skills=sorted(list(set(matching_skills))),
        missing_skills=sorted(list(set(missing_skills))),
        vector_similarity_score=round(raw_similarity, 4),
        reasoning=reasoning
    )