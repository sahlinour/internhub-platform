import httpx
from fastapi.testclient import TestClient

from app.main import app
from app.routers import chat


client = TestClient(app)


def test_chat_success(monkeypatch):
    class MockResponse:
        def raise_for_status(self):
            pass

        def json(self):
            return {
                "response": "Hello! How can I help you?"
            }

    async def mock_post(*args, **kwargs):
        return MockResponse()

    class MockAsyncClient:
        def __init__(self, *args, **kwargs):
            pass

        async def __aenter__(self):
            return self

        async def __aexit__(self, exc_type, exc, tb):
            pass

        async def post(self, *args, **kwargs):
            return await mock_post(*args, **kwargs)

    monkeypatch.setattr(
        chat.httpx,
        "AsyncClient",
        MockAsyncClient
    )

    response = client.post(
        "/api/chat",
        json={
            "messages": [
                {
                    "role": "user",
                    "content": "Hello"
                }
            ]
        }
    )

    assert response.status_code == 200
    assert response.json() == {
        "reply": "Hello! How can I help you?"
    }


def test_chat_without_user_message():
    response = client.post(
        "/api/chat",
        json={
            "messages": [
                {
                    "role": "assistant",
                    "content": "Hello!"
                }
            ]
        }
    )

    assert response.status_code == 400
    assert response.json() == {
        "detail": "No user message provided"
    }


def test_chat_with_empty_user_message():
    response = client.post(
        "/api/chat",
        json={
            "messages": [
                {
                    "role": "user",
                    "content": "   "
                }
            ]
        }
    )

    assert response.status_code == 400
    assert response.json() == {
        "detail": "No user message provided"
    }


def test_chat_accepts_user_id(monkeypatch):
    class MockResponse:
        def raise_for_status(self):
            pass

        def json(self):
            return {
                "response": "Response for user"
            }

    class MockAsyncClient:
        def __init__(self, *args, **kwargs):
            pass

        async def __aenter__(self):
            return self

        async def __aexit__(self, exc_type, exc, tb):
            pass

        async def post(self, *args, **kwargs):
            return MockResponse()

    monkeypatch.setattr(
        chat.httpx,
        "AsyncClient",
        MockAsyncClient
    )

    response = client.post(
        "/api/chat",
        json={
            "user_id": 10,
            "messages": [
                {
                    "role": "user",
                    "content": "Tell me about internships"
                }
            ]
        }
    )

    assert response.status_code == 200
    assert response.json()["reply"] == "Response for user"