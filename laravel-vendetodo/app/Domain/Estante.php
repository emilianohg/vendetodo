<?php

namespace App\Domain;

class Estante
{
  private int $estanteId;
  /**  
   * @var Seccion[]
   */
  private array $secciones;
  private bool $habilitado;

  public function __construct(
    int $estanteId,
    array $secciones = [],
    bool $habilitado = true,
  ) {
    $this->estanteId = $estanteId;
    $this->secciones = $secciones;
    $this->habilitado = $habilitado;
  }

  public function getEstanteId(): int
  {
    return $this->estanteId;
  }

  /**
   * @return Seccion[]
   */
  public function getSecciones()
  {
    return $this->secciones;
  }

  public function getHabilitado(): bool
  {
    return $this->habilitado;
  }

  public function getSeccionPorProductoId(int $productoId): ?Seccion
  {
    $seccion = collect($this->secciones)->filter(function ($_seccion) use($productoId) {
      return $_seccion->getProducto()->getId() == $productoId;
    })->first();
    return $seccion;
  }

}
