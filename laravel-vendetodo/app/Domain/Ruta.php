<?php

namespace App\Domain;

class Ruta
{
    /**
     * @param int $orden_id
     * @param int $surtidor_id
     * @param UbicacionProducto[] $ubicaciones
     * @param array|null $camino
     */
    public function __construct(
        private int $orden_id,
        private int $surtidor_id,
        private array $ubicaciones,
        private ?array $camino = [],
    ) { }

    public function getOrdenId(): int
    {
        return $this->orden_id;
    }

    public function getSurtidorId(): int
    {
        return $this->surtidor_id;
    }

    /**
     * @return UbicacionProducto[]
     */
    public function getUbicaciones(): array
    {
        return $this->ubicaciones;
    }

    public function getCamino(): ?array
    {
        return $this->camino;
    }

}