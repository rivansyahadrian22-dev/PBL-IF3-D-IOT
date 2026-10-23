from fastapi import FastAPI

app = FastAPI()

@app.get("/")
def cek():
    return {"status": "layanan AI berjalan"}