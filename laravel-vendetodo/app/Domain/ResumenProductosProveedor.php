<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;
use stdClass;

class ResumenProductosProveedor extends DomainElement{

    public function __construct(
        private int $proveedor_id,
        private string $proveedor_nombre,
        private int $producto_id,
        private string $producto_nombre,
        private int $cantidad,
        private int $cantidad_disponible,
    )
    {
        
    }

    /**
     * @param array $listValues
     * @return ResumenProductosProveedor[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }

    public static function from(array | stdClass $values): ResumenProductosProveedor
    {
        return self::make(ResumenProductosProveedor::class, $values);
    }

    public function getProveedorId(): int
    {
        return $this->proveedor_id;
    }

    public function getProveedorNombre(): string
    {
        return $this->proveedor_nombre;
    }

    public function getProductoId(): int
    {
        return $this->producto_id;
    }

    public function getProductoNombre(): string
    {
        return $this->producto_nombre;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function getCantidadDisponible(): int
    {
        return $this->cantidad_disponible;
    }
}
