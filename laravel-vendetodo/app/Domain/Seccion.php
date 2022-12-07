<?php

namespace App\Domain;

class Seccion
{
  private int $seccionId;
  private int $estanteId;
  /**  
   * @var PaqueteLote[]
   */
  private array $paquetes;
  private ?Producto $producto;

  public function __construct(
    int $seccionId,
    int $estanteId,
    ?Producto $producto = null,
    array $paquetes = [],
  ) {
    $this->seccionId = $seccionId;
    $this->estanteId = $estanteId;
    $this->producto = $producto;
    $this->paquetes = $paquetes;
  }

  public function getSeccionId(): int
  {
    return $this->seccionId;
  }

  public function getEstanteId(): int
  {
    return $this->estanteId;
  }

  /**
   * @return PaqueteLote[]
   */
  public function getPaquetes()
  {
    return $this->paquetes;
  }

  public function getProducto(): ?Producto
  {
    return $this->producto;
  }

  public function getCantidadProductos(): int
  {
    $cantidadProductos = 0;
    for ($paquete=0; $paquete < count($this->paquetes); $paquete++) { 
      $cantidadProductos += $this->paquetes[$paquete]->getCantidad() ;
    }
    return $cantidadProductos;
  }

}
