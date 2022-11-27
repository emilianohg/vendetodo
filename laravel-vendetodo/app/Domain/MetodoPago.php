<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;

class MetodoPago extends DomainElement
{
    public function __construct(
        private int $metodo_pago_id,
        private string $nombre,
    ) { }

    /**
     * @param array $listValues
     * @return MetodoPago[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }

    public static function from(array $values): MetodoPago
    {
        return self::make(MetodoPago::class, $values);
    }

    public function getMetodoPagoId(): int
    {
        return $this->metodo_pago_id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }
}