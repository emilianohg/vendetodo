<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;

class DetalleReporteVentasProducto extends DomainElement
{
    public function __construct(
        private int $producto_id,
        private int $cantidad,
        private Producto $producto,
        private float $importe,
    )
    {}

    /**
     * @param array $listValues
     * @return DetalleReporteVentasProducto[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }

    public static function from(array $values): DetalleReporteVentasProducto
    {
        return self::make(DetalleReporteVentasProducto::class, $values);
    }

    public function getProductoId(): int
    {
        return $this->producto_id;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function getProducto(): Producto
    {
        return $this->producto;
    }

    public function getImporte(): float
    {
        return $this->importe;
    }
}