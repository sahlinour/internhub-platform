import os
import json
import re
import fitz  # PyMuPDF
from fastapi import APIRouter, File, Form, UploadFile, HTTPException
from typing import Optional
from google import genai
from google.genai import types
from pydantic import BaseModel, Field

router = APIRouter(prefix="/api", tags=["CV Parsing"])

# Gemini Pydantic Schema for structured extraction
class CvExtractionResult(BaseModel):
    extracted_skills: list[str] = Field(description="List of technical and soft skills identified in the CV")
    summary: str = Field(description="Brief professional summary of the candidate")
    education_level: Optional[str] = Field(description="Highest degree or education level detected")

def extract_pdf_text(file_bytes: bytes) -> str:
    """Extract raw text from PDF file bytes using PyMuPDF (fitz)."""
    text = ""
    try:
        doc = fitz.open(stream=file_bytes, filetype="pdf")
        for page in doc:
            text += page.get_text()
        return text
    except Exception as e:
        raise HTTPException(status_code=400, detail=f"Failed to read PDF content: {str(e)}")

@router.post("/parse-cv")
async def parse_cv(
    file: UploadFile = File(...),
    known_skills: Optional[str] = Form(None)  # Receives JSON array string from Laravel
):
    # 1. Validate extension
    if not file.filename.lower().endswith(".pdf"):
        raise HTTPException(status_code=400, detail="Only PDF files are allowed")

    # 2. Extract raw text from PDF
    contents = await file.read()
    extracted_text = extract_pdf_text(contents)

    # 3. Decode known skills sent from Laravel
    skills_db = []
    if known_skills:
        try:
            skills_db = json.loads(known_skills)
        except json.JSONDecodeError:
            skills_db = []

    # 4. Perform Regex matching against DB skills
    matched_db_skills = []
    normalized_text = " ".join(extracted_text.split()).lower()

    for skill in skills_db:
        pattern = r'\b' + re.escape(skill.lower()) + r'\b'
        if re.search(pattern, normalized_text):
            matched_db_skills.append(skill)

    # 5. Fallback/Enrichment: Use Gemini LLM if GEMINI_API_KEY is available
    ai_extracted_data = None
    api_key = os.getenv("GEMINI_API_KEY")

    if api_key:
        try:
            client = genai.Client(api_key=api_key)
            prompt = (
                "Analyze the following CV text and extract key candidate information. "
                "Focus on extracting skills, education level, and a brief summary."
            )

            response = client.models.generate_content(
                model="gemini-2.5-flash",
                contents=[prompt, extracted_text],
                config=types.GenerateContentConfig(
                    response_mime_type="application/json",
                    response_schema=CvExtractionResult,
                    temperature=0.1
                )
            )
            
            if response.text:
                ai_extracted_data = json.loads(response.text)
        except Exception as e:
            # Fallback gracefully if AI call fails
            ai_extracted_data = {"error": f"AI Parsing failed: {str(e)}"}

    return {
        "filename": file.filename,
        "extracted_text": extracted_text,
        "matched_db_skills": matched_db_skills,
        "ai_analysis": ai_extracted_data
    }