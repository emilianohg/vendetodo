<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;
use stdClass;

class ResumenOrdenSurtidor extends DomainElement
{
    public function __construct(
        private int $cantidad_ordenes,
        private int $surtidor_id,
    ) { }

    public function getCantidadOrdenes(): int
    {
        return $this->cantidad_ordenes;
    }

    public function getSurtidorId(): int
    {
        return $this->surtidor_id;
    }

    /**
     * @param array $listValues
     * @return ResumenOrdenSurtidor[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }

    public static function from(array | stdClass $values): ResumenOrdenSurtidor
    {
        return self::make(ResumenOrdenSurtidor::class, $values);
    }

}