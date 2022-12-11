<?php

namespace App\Domain;

class ProductoEnOtroEstanteException extends \Exception
{
  public function __construct(Producto $producto)
  {
    parent::__construct('El producto ' . $producto->getNombre(). ' ya se encuentra en otro estante', 422);
  }
}