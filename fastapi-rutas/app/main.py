from fastapi import FastAPI
from .request import SolicitudRuta
from .service import RutasService


app = FastAPI()


@app.get("/")
async def create_item():
    return {'message': 'Hola mundo!!!'}


@app.post("/rutas/")
async def create_item(req: SolicitudRuta):

    rutasService = RutasService(
        req.orden_id,
        req.total_estantes,
        req.total_secciones
    )

    ubicaciones = [
        {"x": coord.x, "y": coord.y}
        for coord
        in req.ubicaciones
    ]

    ruta, distancia = rutasService.get_min_path(
        {"x": req.inicio.x, "y": req.inicio.y},
        ubicaciones
    )

    return {
        "orden_id": req.orden_id,
        "inicio": req.inicio,
        "ubicaciones": req.ubicaciones,
        "ruta": ruta,
        "distancia": distancia
    }
