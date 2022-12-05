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
    private int $cantidaBodega,
    private int $cantidadAlmacen,
    private ?int $estante = null,
    private ?int $secccion = null,
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

  public function getId(): int
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
    return $this->cantidaBodega;
  }

  public function getCantidadAlmacen(): int
  {
    return $this->cantidadAlmacen;
  }

  public function getEstante(): int
  {
    return $this->estante;
  }

  public function getSeccion(): int
  {
    return $this->secccion;
  }
}
