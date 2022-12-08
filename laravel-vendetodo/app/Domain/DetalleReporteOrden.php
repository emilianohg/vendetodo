<?php

namespace App\Domain;


class DetalleReporteOrden
{

    /**
    * @param PaqueteLote[] $paquetes
    */
    public Function __construct(
        private int $seccion,
        private Producto $producto,
        private array $paquetes = [],
    )
    {}
}