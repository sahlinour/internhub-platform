import io
import json

import pymupdf
from fastapi.testclient import TestClient

from app.main import app


client = TestClient(app)


def create_test_pdf(text: str) -> bytes:
    """Create a simple PDF containing the given text."""
    doc = pymupdf.open()

    page = doc.new_page()
    page.insert_text((50, 50), text)

    pdf_bytes = doc.tobytes()
    doc.close()

    return pdf_bytes


def test_parse_cv_success():
    pdf_content = create_test_pdf(
        "Nour Sahli - Python Laravel React"
    )

    response = client.post(
        "/api/parse-cv",
        files={
            "file": (
                "cv.pdf",
                io.BytesIO(pdf_content),
                "application/pdf"
            )
        },
        data={
            "known_skills": json.dumps(
                ["Python", "Laravel", "React", "Java"]
            )
        }
    )

    assert response.status_code == 200

    data = response.json()

    assert data["filename"] == "cv.pdf"
    assert "Python" in data["matched_db_skills"]
    assert "Laravel" in data["matched_db_skills"]
    assert "React" in data["matched_db_skills"]
    assert "Java" not in data["matched_db_skills"]
    assert "Python" in data["detected_skills"]
    assert data["ai_analysis"] is None


def test_parse_cv_rejects_non_pdf():
    response = client.post(
        "/api/parse-cv",
        files={
            "file": (
                "cv.txt",
                io.BytesIO(b"Python Laravel"),
                "text/plain"
            )
        }
    )

    assert response.status_code == 400
    assert response.json() == {
        "detail": "Only PDF files are allowed"
    }


def test_parse_cv_rejects_empty_file():
    response = client.post(
        "/api/parse-cv",
        files={
            "file": (
                "cv.pdf",
                io.BytesIO(b""),
                "application/pdf"
            )
        }
    )

    assert response.status_code == 400
    assert response.json() == {
        "detail": "Empty PDF file"
    }


def test_parse_cv_without_known_skills():
    pdf_content = create_test_pdf(
        "Python Laravel React"
    )

    response = client.post(
        "/api/parse-cv",
        files={
            "file": (
                "cv.pdf",
                io.BytesIO(pdf_content),
                "application/pdf"
            )
        }
    )

    assert response.status_code == 200

    data = response.json()

    assert data["filename"] == "cv.pdf"
    assert "Python" in data["extracted_text"]
    assert data["matched_db_skills"] == []
    assert data["detected_skills"] == []
    assert data["ai_analysis"] is None


def test_parse_cv_invalid_known_skills_json():
    pdf_content = create_test_pdf(
        "Python Laravel"
    )

    response = client.post(
        "/api/parse-cv",
        files={
            "file": (
                "cv.pdf",
                io.BytesIO(pdf_content),
                "application/pdf"
            )
        },
        data={
            "known_skills": "invalid-json"
        }
    )

    assert response.status_code == 200

    data = response.json()

    assert data["matched_db_skills"] == []
    assert data["detected_skills"] == []