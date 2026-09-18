# app/routers/cv.py
import json
import pymupdf as fitz
from typing import Optional
from fastapi import APIRouter, File, UploadFile, Form, HTTPException

from app.schemas import CVParseResponse
from app.utils import extract_skills_from_text

router = APIRouter(prefix="/api", tags=["CV Parser"])

@router.post("/parse-cv", response_model=CVParseResponse)
async def parse_cv(
    file: UploadFile = File(...),
    known_skills: Optional[str] = Form(None)
):
    if not file.filename.lower().endswith(".pdf"):
        raise HTTPException(status_code=400, detail="Only PDF files are supported")

    try:
        pdf_bytes = await file.read()
        doc = fitz.open(stream=pdf_bytes, filetype="pdf")
        
        extracted_text = ""
        for page in doc:
            extracted_text += page.get_text() + "\n"
        doc.close()

        parsed_known_skills = []
        if known_skills:
            try:
                parsed_known_skills = json.loads(known_skills)
            except Exception:
                parsed_known_skills = []

        detected_skills = extract_skills_from_text(extracted_text, parsed_known_skills)

        return CVParseResponse(
            filename=file.filename,
            extracted_text=extracted_text,
            detected_skills=detected_skills
        )

    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Failed to process PDF: {str(e)}")