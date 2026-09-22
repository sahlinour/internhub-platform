from fastapi.testclient import TestClient

from app.main import app


client = TestClient(app)


def test_match_with_matching_skill():
    response = client.post(
        "/api/match",
        json={
            "stagiaire": {
                "user_id": 1,
                "universite": "Université Mohammed V",
                "filiere": "Computer Science",
                "niveau": "Bac+4",
                "cv_text": "Experienced in Laravel and PHP development.",
                "competences": [
                    {
                        "nom_competence": "Laravel",
                        "niveau": "Intermediaire",
                        "experience": "2"
                    }
                ]
            },
            "offre": {
                "id": 1,
                "titre": "Laravel Developer Intern",
                "description": "Development of web applications with Laravel.",
                "required_skills": ["Laravel"],
                "known_skills": ["Laravel"]
            }
        }
    )

    assert response.status_code == 200

    data = response.json()

    assert data["match_percentage"] >= 40
    assert "Laravel" in data["matching_skills"]
    assert data["missing_skills"] == []
    assert 0 <= data["vector_similarity_score"] <= 1
    assert "Match percentage:" in data["reasoning"]


def test_match_with_missing_skill():
    response = client.post(
        "/api/match",
        json={
            "stagiaire": {
                "user_id": 2,
                "filiere": "Computer Science",
                "niveau": "Bac+4",
                "cv_text": "Experienced in PHP development.",
                "competences": [
                    {
                        "nom_competence": "PHP"
                    }
                ]
            },
            "offre": {
                "id": 2,
                "titre": "Laravel Developer Intern",
                "description": "Development of Laravel applications.",
                "required_skills": ["Laravel", "React"],
                "known_skills": ["Laravel", "React"]
            }
        }
    )

    assert response.status_code == 200

    data = response.json()

    assert data["match_percentage"] >= 5
    assert "Laravel" in data["missing_skills"]
    assert "React" in data["missing_skills"]


def test_match_rejects_empty_profile_and_offer():
    response = client.post(
        "/api/match",
        json={
            "stagiaire": {
                "user_id": 3,
                "cv_text": "",
                "competences": []
            },
            "offre": {
                "id": 3,
                "titre": "",
                "description": "",
                "required_skills": [],
                "known_skills": []
            }
        }
    )

    assert response.status_code == 400

    assert response.json() == {
        "detail": "Insufficient profile or offer data to perform matching"
    }


def test_match_response_structure():
    response = client.post(
        "/api/match",
        json={
            "stagiaire": {
                "user_id": 4,
                "filiere": "Data Science",
                "niveau": "Bac+4",
                "cv_text": "Python data analysis",
                "competences": [
                    {
                        "nom_competence": "Python"
                    }
                ]
            },
            "offre": {
                "id": 4,
                "titre": "Python Intern",
                "description": "Python data analysis internship.",
                "required_skills": ["Python"],
                "known_skills": ["Python"]
            }
        }
    )

    assert response.status_code == 200

    data = response.json()

    assert "match_percentage" in data
    assert "matching_skills" in data
    assert "missing_skills" in data
    assert "vector_similarity_score" in data
    assert "reasoning" in data