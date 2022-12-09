<?php

namespace App\Domain;


class DetalleReporteOrdenEstante
{

    /**
    * @param PaqueteLote[] $paquetes
    */
    public Function __construct(
        private int $seccion_id,
        private Producto $producto,
        private array $paquetes = [],
    )
    {}

    public function getSeccionId(): int
    {
        return $this->seccion_id;
    }

    public function getProducto(): Producto
    {
        return $this->producto;
    }

    /**
     * @return PaqueteLote[]
     */
    public function getPaquetes(): array
    {
        return $this->paquetes;
    }

}