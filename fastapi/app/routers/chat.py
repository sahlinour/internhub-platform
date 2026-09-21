import httpx
from fastapi import APIRouter, HTTPException
from app.schemas import ChatRequest

router = APIRouter(prefix="/api", tags=["Chatbot"])

OLLAMA_URL = "http://ollama:11434/api/generate"
MODEL = "tinyllama"


@router.post("/chat")
async def chat(request: ChatRequest):

    # Get the last user message
    user_messages = [
        message.content.strip()
        for message in request.messages
        if message.role == "user" and message.content.strip()
    ]

    if not user_messages:
        raise HTTPException(
            status_code=400,
            detail="No user message provided"
        )

    prompt = user_messages[-1]

    try:
        async with httpx.AsyncClient(timeout=120.0) as client:

            response = await client.post(
                OLLAMA_URL,
                json={
                    "model": MODEL,
                    "prompt": prompt,
                    "stream": False,
                    "options": {
                        "num_predict": 100,
                        "temperature": 0.5,
                    },
                },
            )

            response.raise_for_status()

            data = response.json()

            reply = data.get("response", "").strip()

            if not reply:
                raise HTTPException(
                    status_code=500,
                    detail="Ollama returned an empty response"
                )

            return {
                "reply": reply
            }

    except httpx.TimeoutException:
        raise HTTPException(
            status_code=504,
            detail="Ollama took too long to respond"
        )

    except httpx.HTTPStatusError as e:
        raise HTTPException(
            status_code=500,
            detail=f"Ollama HTTP error: {e.response.text}"
        )

    except httpx.RequestError as e:
        raise HTTPException(
            status_code=503,
            detail=f"Cannot connect to Ollama: {str(e)}"
        )