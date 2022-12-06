from typing import List
from pydantic import BaseModel


class Ubicacion(BaseModel):
    x: int
    y: int


class SolicitudRuta(BaseModel):
    orden_id: int
    total_secciones: int
    total_estantes: int
    inicio: Ubicacion
    ubicaciones: List[Ubicacion]