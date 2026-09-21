import os
import json
import re
from typing import Optional

import pymupdf  # Official PyMuPDF import
from fastapi import APIRouter, File, Form, UploadFile, HTTPException
from google import genai
from google.genai import types
from pydantic import BaseModel, Field

router = APIRouter(
    prefix="/api",
    tags=["CV Parsing"]
)


class CvExtractionResult(BaseModel):
    extracted_skills: list[str] = Field(
        default_factory=list,
        description="Technical and soft skills found in the CV"
    )
    summary: str = Field(
        default="",
        description="Brief professional summary"
    )
    education_level: Optional[str] = Field(
        default=None,
        description="Highest education level"
    )


def extract_pdf_text(file_bytes: bytes) -> str:
    """Extract raw text from PDF file bytes using PyMuPDF."""
    text = ""
    try:
        # Use pymupdf instead of legacy fitz
        doc = pymupdf.open(stream=file_bytes, filetype="pdf")
        for page in doc:
            text += page.get_text()
        doc.close()
        return text
    except Exception as e:
        raise HTTPException(
            status_code=400,
            detail=f"Failed to read PDF content: {str(e)}"
        )


@router.post("/parse-cv")
async def parse_cv(
    file: UploadFile = File(...),
    known_skills: Optional[str] = Form(None)
):
    if not file.filename:
        raise HTTPException(status_code=400, detail="Filename is required")

    if not file.filename.lower().endswith(".pdf"):
        raise HTTPException(status_code=400, detail="Only PDF files are allowed")

    contents = await file.read()
    if not contents:
        raise HTTPException(status_code=400, detail="Empty PDF file")

    extracted_text = extract_pdf_text(contents)

    # -------------------------------------------------
    # 1. Database Skills Decoding
    # -------------------------------------------------
    skills_db = []
    if known_skills:
        try:
            skills_db = json.loads(known_skills)
        except json.JSONDecodeError:
            skills_db = []

    # -------------------------------------------------
    # 2. Regex Skill Matching
    # -------------------------------------------------
    matched_db_skills = []
    normalized_text = " ".join(extracted_text.split()).lower()

    for skill in skills_db:
        if not skill:
            continue

        # Look for word boundaries around exact skill string
        pattern = r"(?<!\w)" + re.escape(skill.lower()) + r"(?!\w)"
        if re.search(pattern, normalized_text):
            matched_db_skills.append(skill)

    # -------------------------------------------------
    # 3. Gemini Structured AI Extraction
    # -------------------------------------------------
    ai_extracted_data = None
    api_key = os.getenv("GEMINI_API_KEY")

    if api_key and extracted_text.strip():
        try:
            client = genai.Client(api_key=api_key)
            prompt = (
                "Analyze this CV.\n"
                "Extract:\n"
                "1. Technical skills\n"
                "2. Soft skills\n"
                "3. Education level\n"
                "4. Short professional summary\n\n"
                "Return only structured JSON."
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
            ai_extracted_data = {"error": f"AI Parsing failed: {str(e)}"}

    # -------------------------------------------------
    # 4. Merge Unique Detected Skills
    # -------------------------------------------------
    ai_skills = []
    if isinstance(ai_extracted_data, dict):
        ai_skills = ai_extracted_data.get("extracted_skills", [])

    detected_skills = list(dict.fromkeys(matched_db_skills + ai_skills))

    return {
        "filename": file.filename,
        "extracted_text": extracted_text,
        "matched_db_skills": matched_db_skills,
        "detected_skills": detected_skills,
        "ai_analysis": ai_extracted_data
    }