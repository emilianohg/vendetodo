<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;

class Marca extends DomainElement
{
    public function __construct(
        private int $marca_id,
        private string $nombre,
    )
    {}

    public function getId(): int
    {
        return $this->marca_id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public static function from(array $values): Marca
    {
        return self::make(Marca::class, $values);
    }

    /**
     * @param array $listValues
     * @return Marca[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }
}