<?php

namespace App\Domain;


class DetalleReporteOrdenEstante
{

  /**
   * @param PaqueteLote[] $paquetes
   */
  public function __construct(
    private int $seccion_id,
    private Producto $producto,
    private array $paquetes = [],
  ) {
  }

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

  public function getCantidadProductos(): int
  {
    $cantidadProductos = 0;
    foreach ($this->paquetes as $paquete) {
      $cantidadProductos += $paquete->getCantidad();
    }
    return $cantidadProductos;
  }
}
