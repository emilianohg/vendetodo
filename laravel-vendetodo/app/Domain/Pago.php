<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;

class Pago extends DomainElement
{
    public function __construct(
        private int $pago_id,
        private int $metodo_pago_id,
        private string $referencia,
        private string $fecha,
    ) { }

    /**
     * @param array $listValues
     * @return Pago[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }

    public static function from(array $values): Pago
    {
        return self::make(Pago::class, $values);
    }

    public function getPagoId(): int
    {
        return $this->pago_id;
    }

    public function getMetodoPagoId(): int
    {
        return $this->metodo_pago_id;
    }

    public function getReferencia(): string
    {
        return $this->referencia;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }
}