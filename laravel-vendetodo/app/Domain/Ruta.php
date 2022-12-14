<?php

namespace App\Domain;

class Ruta
{
    /**
     * @param int $orden_id
     * @param string $fecha
     * @param UbicacionProducto[] $ubicaciones
     * @param string|null $camino
     */
    public function __construct(
        private int $orden_id,
        private string $fecha,
        private array $ubicaciones,
        private ?string $camino = '',
    ) {}

    public function getOrdenId(): int
    {
        return $this->orden_id;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    /**
     * @return UbicacionProducto[]
     */
    public function getUbicaciones(): array
    {
        return $this->ubicaciones;
    }

    public function getCamino(): string
    {
        return $this->camino;
    }

    public function getUbicacionesAlmacen(): array
    {
        $ubicacionAlmacen = [];
        foreach ($this->ubicaciones as $ubicacion) {
            if($ubicacion->getPaqueteLote()->estaEnAlmacen()) {
                $ubicacionAlmacen[] = $ubicacion;
            }
        }
        return $ubicacionAlmacen;
    }

    public function getUbicacionesBodega(): array
    {
        $ubicacionBodega = [];
        foreach ($this->ubicaciones as $ubicacion) {
            if(!$ubicacion->getPaqueteLote()->estaEnAlmacen()) {
                $ubicacionBodega[] = $ubicacion;
            }
        }
        return $ubicacionBodega;
    }


}