<?php

namespace App\Domain;

use App\Repositories\AlmacenRepository;
use App\Repositories\OrdenesPreasignadasRepository;
use App\Repositories\OrdenesRepository;
use App\Repositories\RutasRepository;
use App\Services\RutasService;
use Illuminate\Support\Facades\DB;

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

        DB::beginTransaction();

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

        foreach ($ruta->getUbicaciones() as $ubicacion) {
            $this->lotesManager->reservarParaSurtir($ubicacion->getPaqueteLote());
        }

        $this->rutasRepository->guardar($ruta);

        DB::commit();

        return $ruta;
    }

    public function verRuta(int $ordenId): Ruta
    {
        $ruta = $this->rutasRepository->buscarPorId($ordenId);
        if ($ruta == null) {
            $ruta = $this->generarRuta($ordenId);
        }
        return $ruta;
    }

    public function recogerProducto(int $ordenId, int $orden)
    {
        $this->rutasRepository->recogerProducto($ordenId, $orden);
    }

    public function regresarProducto(int $ordenId, int $orden)
    {
        $this->rutasRepository->recogerProducto($ordenId, $orden);
    }

    /**
     * @param int $ordenId
     * @return Orden
     * @throws ProductoSinRecogerException
     */
    public function terminarSurtido(int $ordenId): Orden
    {
        $orden = $this->ordenesRepository->buscarPorId($ordenId);
        $ruta = $this->rutasRepository->buscarPorId($ordenId);
        DB::beginTransaction();
        foreach ($ruta->getUbicaciones() as $ubicacion) {
            if (!$ubicacion->recogido()) {
                DB::rollBack();
                throw new ProductoSinRecogerException($ubicacion->getPaqueteLote()->getLote()->getProducto());
            }
            $this->lotesManager->surtir($ubicacion->getPaqueteLote());
        }
        $orden->surtida();
        DB::commit();
        return $orden;
    }
}