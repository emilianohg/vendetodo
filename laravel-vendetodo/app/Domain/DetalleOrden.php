<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;

class DetalleOrden extends DomainElement
{
    public function __construct(
        private int $orden_id,
        private int $producto_id,
        private int $proveedor_id,
        private int $cantidad,
        private int $precio,
        private Producto $producto,
        private Proveedor $proveedor,
    ) { }

    /**
     * @param array $listValues
     * @return Pago[]
     * @return DetalleOrden[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }

    public static function from(array $values): DetalleOrden
    {
        return self::make(DetalleOrden::class, $values);
    }

    public function getOrdenId(): int
    {
        return $this->orden_id;
    }

    public function getProductoId(): int
    {
        return $this->producto_id;
    }

    public function getProveedorId(): int
    {
        return $this->proveedor_id;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function getPrecio(): int
    {
        return $this->precio;
    }

    public function getProducto(): Producto
    {
        return $this->producto;
    }

    public function getProveedor(): Proveedor
    {
        return $this->proveedor;
    }

}