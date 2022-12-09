<?php

namespace App\Domain;

use App\Repositories\AlmacenRepository;
use App\Repositories\OrdenesPreasignadasRepository;
use App\Repositories\OrdenesRepository;
use App\Repositories\RutasRepository;
use App\Services\RutasService;

class DominioOrden
{
    private OrdenesRepository $ordenesRepository;
    private OrdenesPreasignadasRepository $ordenesPreasignadasRepository;
    private AlmacenRepository $almacenRepository;
    private LotesManager $lotesManager;
    private RutasService $rutasService;
    private RutasRepository $rutasRepository;

    public function __construct()
    {
        $this->ordenesRepository = new OrdenesRepository();
        $this->ordenesPreasignadasRepository = new OrdenesPreasignadasRepository();
        $this->lotesManager = new LotesManager();
        $this->rutasService = new RutasService();
        $this->almacenRepository = new AlmacenRepository();
        $this->rutasRepository = new RutasRepository();
    }

    public function obtenerOrden(int $id): Orden
    {
        return $this->ordenesRepository->buscarPorId($id);
    }

    public function asignarOrdenes(): void
    {
        $resumenSurtidores = $this->ordenesRepository->getSurtidoresDisponibles(
            now()->startOfDay()->toISOString(),
            now()->toISOString(),
        );

        $ordenes = $this->ordenesRepository->getOrdenesPendientes();

        foreach ($resumenSurtidores as $i => $resumenSurtidor) {

            if (!isset($ordenes[$i])) {
                break;
            }

            $orden = $ordenes[$i];

            $this->ordenesPreasignadasRepository->registrar(
                $orden->getOrdenId(),
                $resumenSurtidor->getSurtidorId(),
            );
        }
    }

    public function aceptarOrden(int $surtidorId, int $ordenId): Orden
    {
        if(!$this->ordenesPreasignadasRepository->validarAsignacion($ordenId, $surtidorId)) {
            throw new OrdenNoAsignadaException();
        }

        $orden = $this->ordenesRepository->buscarPorId($ordenId);

        $orden->asignarSurtidor($surtidorId);

        return $orden;
    }

    public function generarRuta(int $ordenId): Ruta
    {
        $orden = $this->ordenesRepository->buscarPorId($ordenId);

        $paquetes = [];

        foreach ($orden->getDetalle() as $detalleOrden) {

            $paquetesDetalle = $this->lotesManager->getPaquetes(
                $detalleOrden->getCantidad(),
                $detalleOrden->getProductoId(),
                $detalleOrden->getProveedorId(),
            );

            $paquetes = array_merge($paquetes, $paquetesDetalle);
        }

        $estanteId = $this->almacenRepository->obtenerEstanteIdPorSurtidorId($orden->getSurtidorId());

        $ruta = $this->rutasService->generar(
            $orden->getOrdenId(),
            $estanteId,
            $paquetes
        );

        $this->rutasRepository->guardar($ruta);

        return $ruta;
    }

    public function verRuta(int $ordenId): Ruta
    {
        return $this->rutasRepository->buscarPorId($ordenId);
    }
}