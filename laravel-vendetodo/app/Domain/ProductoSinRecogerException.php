<?php

namespace App\Domain;

class ProductoSinRecogerException extends \Exception
{
    public function __construct(Producto $producto)
    {
        parent::__construct('No se ha recogido el producto ' . $producto->getNombre() . ' de la orden', 422);
    }
}