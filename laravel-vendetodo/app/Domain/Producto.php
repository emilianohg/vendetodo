<?php
namespace App\Domain;

use App\Domain\Common\DomainElement;

class Producto extends DomainElement {

    public function __construct(
        private int $producto_id,
        private string $nombre,
        private float $precio,
        private int $marca_id,
        private float $largo,
        private float $ancho,
        private float $alto,
        private string $created_at,
        private string $updated_at,
        private ?string $descripcion = null,
        private ?string $imagen_url = null,
        private ?Marca $marca = null
    )
    {}

    /**
     * @param array $listValues
     * @return Producto[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }

    public static function from(array $values): Producto
    {
        return self::make(Producto::class, $values);
    }

    public function getId(): int
    {
        return $this->producto_id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function getMarcaId(): int
    {
        return $this->marca_id;
    }

    public function getLargo(): float
    {
        return $this->largo;
    }

    public function getAncho(): float
    {
        return $this->ancho;
    }

    public function getAlto(): float
    {
        return $this->alto;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function getImagenUrl(): ?string
    {
        return $this->imagen_url;
    }

    public function getMarca(): ?Marca
    {
        return $this->marca;
    }

    public function getVolumen(): float
    {   
        $volumen = $this->largo* $this->ancho * $this->alto;
        return ($volumen) == 0 ? 0.001 : $volumen;
    }
    
}