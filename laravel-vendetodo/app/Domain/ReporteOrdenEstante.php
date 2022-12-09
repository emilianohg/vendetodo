<?php

namespace App\Domain;

use App\Repositories\ReportesOrdenEstanteRepository;
use Ramsey\Uuid\Uuid;

class ReporteOrdenEstante
{
    private ReportesOrdenEstanteRepository $reportesOrdenEstanteRepository;

    /**
    * @param DetalleReporteOrdenEstante[] $detalle
    **/
    public function __construct(
        private string $reporte_uuid,
        private string $fecha,
        private int $estante_id,
        private array $detalles = [],
    )
    {
        $this->reportesOrdenEstanteRepository = new ReportesOrdenEstanteRepository();
    }

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
    * @return DetalleReporteOrdenEstante[]
    */
    public function getDetalles(): array
    {
        return $this->detalles;
    }

    /**
     * @param PaqueteLote[] $paquetes
     */
    public function agregarPaquetes($seccion_id,$paquetes)
    {
        if(count($paquetes) == 0)
        {
            return;
        }
        $producto = $paquetes[0]->getLote()->getProducto();
        $detalle = new DetalleReporteOrdenEstante($seccion_id,$producto,$paquetes);
        $this->detalles[] = $detalle;
    }

    public function guardar()
    {
        $this->reportesOrdenEstanteRepository->guardar($this);
    }
}