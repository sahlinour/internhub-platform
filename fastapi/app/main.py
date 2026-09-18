from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware

from app.routers import chat, cv, match

app = FastAPI(title="Stagiaire Matching & AI Engine")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

app.include_router(chat.router)
app.include_router(cv.router)
app.include_router(match.router)


@app.get("/")
async def root():
    return {"status": "FastAPI AI Engine is running"}