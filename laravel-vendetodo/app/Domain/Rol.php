<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;

class Rol extends DomainElement
{
    public const ADMINISTRADOR = 1;
    public const SURTIDOR = 2;
    public const ENCARGADO_ALMACEN = 3;
    public const ENCARGADO_ESTANTE = 4;
    public const CLIENTE = 5;

    public function __construct(
        private int $rol_id,
        private string $nombre,
    ) { }

    /**
     * @param array $listValues
     * @return Rol[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }

    public static function from(array $values): Rol
    {
        return self::make(Rol::class, $values);
    }

    public function getRolId(): int
    {
        return $this->rol_id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }
}