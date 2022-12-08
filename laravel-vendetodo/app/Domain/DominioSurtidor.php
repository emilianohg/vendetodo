<?php

namespace App\Domain;

use App\Repositories\OrdenesPreasignadasRepository;

class DominioSurtidor
{
    private OrdenesPreasignadasRepository $ordenesPreasignadasRepository;

    public function __construct()
    {
        $this->ordenesPreasignadasRepository = new OrdenesPreasignadasRepository();
    }

    public function obtenerOrdenPreasignada(int $surtidorId): ?PreasignacionOrden
    {
        return $this->ordenesPreasignadasRepository->obtener($surtidorId);
    }

}