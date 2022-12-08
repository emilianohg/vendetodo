<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;


class Lote extends DomainElement
{


  public function __construct(
    private int $lote_id,
    private int $producto_id,
    private string $fecha,
    private Producto $producto,
    private int $proveedor_id,
    private int $cantidad,
    private int $cantidadBodega,
    private int $cantidadAlmacen,
    private ?int $estante_id = null,
    private ?int $seccion_id = null,
  ) {
  }

  /**
   * @param array $listValues
   * @return Lote[]
   */
  public static function fromArray(array $listValues): array
  {
    $items = [];
    foreach ($listValues as $values) {
      $items[] = self::from($values);
    }
    return $items;
  }

  public static function from(array $values): Lote
  {
    return self::make(Lote::class, $values);
  }

  public function getLoteId(): int
  {
    return $this->lote_id;
  }

  public function getProductoId(): int
  {
    return $this->producto_id;
  }

  public function getFecha(): string
  {
    return $this->fecha;
  }

  public function getProducto(): Producto
  {
    return $this->producto;
  }

  public function getProveedorId(): int
  {
    return $this->proveedor_id;
  }

  public function getCantidad(): int
  {
    return $this->cantidad;
  }

  public function getCantidadBodega(): int
  {
    return $this->cantidadBodega;
  }

  public function getCantidadAlmacen(): int
  {
    return $this->cantidadAlmacen;
  }

  public function getEstanteId(): int
  {
    return $this->estante_id;
  }

  public function getSeccionId(): int
  {
    return $this->seccion_id;
  }
}
