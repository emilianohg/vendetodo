<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;

class EncargadoEstante extends DomainElement
{
    public function __construct(
        private int $estante_id,
        private int $usuario_id,
        private Usuario $usuario,
    ) { }

    /**
     * @param array $listValues
     * @return EncargadoEstante[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }

    public static function from(array $values): EncargadoEstante
    {
        return self::make(EncargadoEstante::class, $values);
    }


    public function getEstanteId(): int
    {
        return $this->estante_id;
    }

    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }

    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }

}