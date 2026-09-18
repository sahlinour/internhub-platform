from typing import List, Optional
from pydantic import BaseModel, Field

# --- Add Chat Schemas ---
class ChatMessage(BaseModel):
    role: str  # "user" or "assistant"
    content: str

class ChatRequest(BaseModel):
    messages: List[ChatMessage]
    user_id: Optional[int] = None

# --- Existing Matching & CV Schemas ---
class CompetenceItem(BaseModel):
    nom_competence: str
    niveau: Optional[str] = "Debutant"
    experience: Optional[str] = "0"

class StagiaireProfile(BaseModel):
    user_id: int
    universite: Optional[str] = None
    filiere: Optional[str] = None
    niveau: Optional[str] = None
    cv_text: Optional[str] = ""
    competences: List[CompetenceItem] = []

class InternshipOffer(BaseModel):
    id: int
    titre: str
    description: str
    required_skills: Optional[List[str]] = []

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