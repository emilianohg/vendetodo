<?php

namespace App\Domain;

class ReporteOrden
{

    /**
    * @param DetalleReporteOrden[] $detalle
    **/
    public function __construct(
        private string $reporte_uuid,
        private string $fecha,
        private int $estante_id,
        private array $detalles = [],
    )
    {}

    public function getReporteUuid(): string
    {
        return $this->reporte_uuid;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function getEstanteId(): int
    {
        return $this->estante_id;
    }

    /**
    * @return DetalleReporteOrden[]
    */
    public function getDetalles(): array
    {
        return $this->detalles;
    }
}