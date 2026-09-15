from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
import httpx

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

OLLAMA_URL = "http://ollama:11434/api/generate"
MODEL = "tinyllama"


class ChatRequest(BaseModel):
    prompt: str


@app.get("/")
async def root():
    return {"status": "FastAPI AI is running"}


@app.post("/api/chat")
async def chat(request: ChatRequest):

    prompt = request.prompt.strip()

    if not prompt:
        raise HTTPException(
            status_code=400,
            detail="Prompt cannot be empty"
        )

    try:
        async with httpx.AsyncClient(timeout=60.0) as client:

            response = await client.post(
                OLLAMA_URL,
                json={
                    "model": MODEL,
                    "prompt": prompt,
                    "stream": False,
                    "options": {
                        "num_predict": 80,
                        "temperature": 0.5,
                    }
                }
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

    except httpx.HTTPError as e:
        raise HTTPException(
            status_code=500,
            detail=f"Ollama error: {str(e)}"
        )