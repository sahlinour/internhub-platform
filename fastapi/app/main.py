from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
import httpx

app = FastAPI()

class ChatRequest(BaseModel):
    prompt: str

# Ollama container name service URL from docker-compose
OLLAMA_URL = "http://internhub-ollama:11434/api/generate"

@app.post("/api/chat")
async def chat_with_ollama(request: ChatRequest):
    payload = {
        "model": "llama3.2",
        "prompt": request.prompt,
        "stream": False
    }
    
    async with httpx.AsyncClient(timeout=60.0) as client:
        try:
            response = await client.post(OLLAMA_URL, json=payload)
            response.raise_for_status()
            data = response.json()
            return {"reply": data.get("response")}
        except httpx.RequestError as e:
            raise HTTPException(status_code=500, detail=f"Ollama service error: {str(e)}")