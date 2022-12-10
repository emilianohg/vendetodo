<?php

namespace App\Domain;

class ProductoAgotadoException extends \Exception
{
    public function __construct(Producto $producto)
    {
        parent::__construct('No contamos con suficientes unidades del producto ' . $producto->getNombre(), 422);
    }
}