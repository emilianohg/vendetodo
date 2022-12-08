<?php
namespace App\Domain;

use App\Domain\Common\DomainElement;

class Proveedor extends DomainElement {

    
    public function __construct(
        private int $proveedor_id,
        private string $nombre,
    ) { }

    /**
     * @param array $listValues
     * @return Proveedor[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }

    public static function from(array $values): Proveedor
    {
        return self::make(Proveedor::class, $values);
    }

    public function getId(): int
    {
        return $this->proveedor_id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

}