<?php

namespace App\Repositories;

use App\Domain\ReporteOrdenEstante;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ReportesOrdenEstanteRepository
{

    public function guardar(ReporteOrdenEstante $reporteOrdenEstante)
    {
        if($reporteOrdenEstante->getDetalles() == null)
        {
            return;
        }

        DB::table('reportes_orden_estantes')
        ->insert([
            'reporte_uuid' => $reporteOrdenEstante->getReporteUuid(),
            'fecha' => $reporteOrdenEstante->getFecha(),
            'estante_id' => $reporteOrdenEstante->getEstanteId(),
        ]);
        foreach ($reporteOrdenEstante->getDetalles() as $detalle) {

            foreach ($detalle->getPaquetes() as $paquete) {
                $esta_en_almacen = 0;
                $estante_origen_id = null;
                $seccion_origen_id = null;
                $cantidadAlmacen = $paquete->getLote()->getCantidadAlmacen();
                if($cantidadAlmacen > 0)
                {
                    $esta_en_almacen = 1;
                    $estante_origen_id = $paquete->getLote()->getEstanteId();
                    $seccion_origen_id = $paquete->getLote()->getSeccionId();
                }
                DB::table('detalles_reportes_orden_estantes')
                ->insert([
                    'reporte_uuid' => $reporteOrdenEstante->getReporteUuid(),
                    'estante_id' => $reporteOrdenEstante->getEstanteId(),
                    'seccion_id' => $detalle->getSeccionId(),
                    'lote_id' =>    $paquete->getLoteId(),
                    'esta_en_almacen' => $esta_en_almacen,
                    'estante_origen_id' => $estante_origen_id,
                    'seccion_origen_id' => $seccion_origen_id,
                    'cantidad' => $paquete->getCantidad(),
                ]);
            }
        }
    }
}
