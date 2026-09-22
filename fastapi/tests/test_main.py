from fastapi.testclient import TestClient

from app.main import app


client = TestClient(app)


def test_root_endpoint():
    response = client.get("/")

    assert response.status_code == 200
    assert response.json() == {
        "status": "FastAPI AI Engine is running"
    }


def test_app_title():
    assert app.title == "Stagiaire Matching & AI Engine"


def test_chat_endpoint_exists():
    response = client.post("/api/chat", json={"messages": []})

    assert response.status_code == 400
    assert response.json() == {
        "detail": "No user message provided"
    }


def test_cv_endpoint_exists():
    response = client.post("/api/parse-cv")

    assert response.status_code == 422


def test_match_endpoint_exists():
    response = client.post("/api/match", json={})

    assert response.status_code == 422