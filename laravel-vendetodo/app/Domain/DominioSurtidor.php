<?php

namespace App\Domain;

use App\Repositories\OrdenesPreasignadasRepository;
use App\Repositories\OrdenesRepository;

class DominioSurtidor
{
    private OrdenesPreasignadasRepository $ordenesPreasignadasRepository;
    private OrdenesRepository $ordenesRepository;

    public function __construct()
    {
        $this->ordenesPreasignadasRepository = new OrdenesPreasignadasRepository();
        $this->ordenesRepository = new OrdenesRepository();
    }

    public function obtenerOrdenPreasignada(int $surtidorId): ?PreasignacionOrden
    {
        return $this->ordenesPreasignadasRepository->obtener($surtidorId);
    }

    public function obtenerOrdenActiva(int $surtidorId): ?Orden
    {
        return $this->ordenesRepository->buscarOrdenActivaSurtidor($surtidorId);
    }

}