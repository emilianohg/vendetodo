<?php
namespace App\Domain;

use App\Domain\Common\DomainElement;
use App\Domain\LineaCarrito as DomainLineaCarrito;
use App\Domain\Producto;

class LineaCarrito extends DomainElement
{
    public function __construct(
        private int $producto_id,
        private int $proveedor_id,
        private int $cantidad,
        private ?int $linea_carrito_id = null,
        private ?Producto $producto = null,
    )
    {}

    /**
     * @param array $listValues
     * @return LineaCarrito[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }

    public static function from(array $values): LineaCarrito
    {
        return self::make(LineaCarrito::class, $values);
    }

    public function sumarCantidad($cantidad): void
    {
        $this->cantidad = $this->cantidad + $cantidad;
    }

    public function getId(): ?int
    {
        return $this->linea_carrito_id;
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

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }
}