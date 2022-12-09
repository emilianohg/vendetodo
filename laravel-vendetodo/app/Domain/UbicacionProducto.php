<?php

namespace App\Domain;

class UbicacionProducto
{
    private PaqueteLote $paqueteLote;
    private int $orden;

    /**
     * @param PaqueteLote $paqueteLote
     * @param int $orden
     */
    public function __construct(
        PaqueteLote $paqueteLote,
        int $orden,
    )
    {
        $this->paqueteLote = $paqueteLote;
        $this->orden = $orden;
    }

    public function getPaqueteLote(): PaqueteLote
    {
        return $this->paqueteLote;
    }

    public function getOrden(): int
    {
        return $this->orden;
    }

}