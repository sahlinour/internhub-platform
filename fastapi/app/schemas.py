from typing import List, Optional
from pydantic import BaseModel, Field


# =====================================================
# CHATBOT (DO NOT CHANGE)
# =====================================================

class ChatMessage(BaseModel):
    role: str
    content: str


class ChatRequest(BaseModel):
    messages: List[ChatMessage]
    user_id: Optional[int] = None


# =====================================================
# CV MATCHING
# =====================================================

class CompetenceItem(BaseModel):
    nom_competence: str
    niveau: Optional[str] = "Debutant"
    experience: Optional[str] = "0"


class StagiaireProfile(BaseModel):
    user_id: Optional[int] = 0
    universite: Optional[str] = None
    filiere: Optional[str] = None
    niveau: Optional[str] = None
    cv_text: Optional[str] = ""
    competences: List[CompetenceItem] = Field(default_factory=list)


class InternshipOffer(BaseModel):
    id: int
    titre: str
    description: str
    required_skills: Optional[List[str]] = []
    known_skills: Optional[List[str]] = []


class MatchRequest(BaseModel):
    stagiaire: StagiaireProfile
    offre: InternshipOffer


class MatchResponse(BaseModel):
    match_percentage: int = Field(..., ge=0, le=100)
    matching_skills: List[str]
    missing_skills: List[str]
    vector_similarity_score: float
    reasoning: str


class CVParseResponse(BaseModel):
    filename: str
    extracted_text: str
    detected_skills: List[str]