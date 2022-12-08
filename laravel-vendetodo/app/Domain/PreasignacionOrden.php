<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;

class PreasignacionOrden extends DomainElement
{
    public function __construct(
        private int $orden_id,
        private int $surtidor_id,
        private int $intento,
        private string $fecha,
        private string $status,
    ) { }

    /**
     * @param array $listValues
     * @return PreasignacionOrden[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }

    public static function from(array $values): PreasignacionOrden
    {
        return self::make(PreasignacionOrden::class, $values);
    }


    public function getOrdenId(): int
    {
        return $this->orden_id;
    }

    public function getSurtidorId(): int
    {
        return $this->surtidor_id;
    }

    public function getIntento(): int
    {
        return $this->intento;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}