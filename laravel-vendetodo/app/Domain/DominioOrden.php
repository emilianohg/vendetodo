<?php

namespace App\Domain;

use App\Repositories\OrdenesPreasignadasRepository;
use App\Repositories\OrdenesRepository;

class DominioOrden
{
    private OrdenesRepository $ordenesRepository;
    private OrdenesPreasignadasRepository $ordenesPreasignadasRepository;
    private LotesManager $lotesManager;

    public function __construct()
    {
        $this->ordenesRepository = new OrdenesRepository();
        $this->ordenesPreasignadasRepository = new OrdenesPreasignadasRepository();
        $this->lotesManager = new LotesManager();
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

    public function generarRuta(int $ordenId)
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
        foreach ($paquetes as $paquete) {
            \Log::info($paquete->getCantidad());
            \Log::info($paquete->getLote()->getProveedorId());
            \Log::info($paquete->getLote()->getProducto()->getNombre());
        }
    }
}