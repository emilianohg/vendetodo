<?php

namespace App\Domain;

use App\Repositories\LotesRepository;

class LotesManager
{
    private LotesRepository $lotesRepository;
    public function __construct()
    {
        $this->lotesRepository = new LotesRepository();
    }

    /**
    * @return PaqueteLote[]
    */
    public function getPaquetes(int $cantidadProductosNecesarios, int $producto_id): array
    {
        $lotes = $this->lotesRepository->buscarPorProductoId($producto_id);
        $paquetes = $this->generarPaquetes($lotes,$cantidadProductosNecesarios);

        return $paquetes;
    }

    /**
    * @param Lote[] $lotes
    * @return PaqueteLote[]
    */
    public function generarPaquetes(array $lotes, int $cantidadProductosNecesarios)
    {
        
        return [];
    }

}