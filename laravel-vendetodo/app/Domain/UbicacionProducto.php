<?php

namespace App\Domain;

class UbicacionProducto
{
    private PaqueteLote $paqueteLote;
    private int $orden;
    private bool $recogido;

    /**
     * @param PaqueteLote $paqueteLote
     * @param int $orden
     */
    public function __construct(
        PaqueteLote $paqueteLote,
        int $orden,
        bool $recogido = false,
    )
    {
        $this->paqueteLote = $paqueteLote;
        $this->orden = $orden;
        $this->recogido = $recogido;
    }

    public function getPaqueteLote(): PaqueteLote
    {
        return $this->paqueteLote;
    }

    public function getOrden(): int
    {
        return $this->orden;
    }

    public function recogido(): bool
    {
        return $this->recogido;
    }

}