<?php

namespace App\Domain;

class Rol
{
    public function __construct(
        private int $rol_id,
        private string $nombre,
    ) { }

    public function getRolId(): int
    {
        return $this->rol_id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }
}