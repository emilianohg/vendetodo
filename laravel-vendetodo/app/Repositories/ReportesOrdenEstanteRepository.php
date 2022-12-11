<?php

namespace App\Repositories;

use App\Domain\DetalleReporteOrdenEstante;
use App\Domain\PaqueteLote;
use App\Domain\ReporteOrdenEstante;
use Illuminate\Support\Facades\DB;

class ReportesOrdenEstanteRepository
{
  private LotesRepository $lotesRepository;

  public function __construct()
  {
    $this->lotesRepository = new LotesRepository();
  }

  public function obtenerOrdenProductosPorEstanteId(int $estanteId): ReporteOrdenEstante
  {
    $reporteOrdenEstanteRecord = DB::table('reportes_orden_estantes')
      ->where('estante_id', '=', $estanteId)
      ->first();

    $detallesReportesRecord = DB::table('detalles_reportes_orden_estantes')
      ->where('reporte_uuid', '=', $reporteOrdenEstanteRecord->reporte_uuid)
      ->get();

    $lotesId = collect($detallesReportesRecord)
      ->map(fn ($detalle) => $detalle->lote_id)
      ->values()
      ->toArray();

    $lotes = $this->lotesRepository->getLotes($lotesId);

    $detallesPorSeccion = $detallesReportesRecord->groupBy('seccion_id');

    $detalles = [];
    foreach ($detallesPorSeccion as $seccionId => $detallesRecord) {
      $paquetes = [];
      foreach ($detallesRecord as $detalle) {

        $lote = collect($lotes)
          ->filter(fn($_lote) => $_lote->getLoteId() == $detalle->lote_id)
          ->first();

        $paquetes[] = new PaqueteLote(
          lote_id: $detalle->lote_id,
          lote: $lote,
          cantidad: $detalle->cantidad,
          estante_id: $detalle->estante_origen_id,
          seccion_id: $detalle->seccion_origen_id,
        );
      }

      $detalles[] = new DetalleReporteOrdenEstante(
        seccion_id: $seccionId,
        producto: count($paquetes) > 0 ? $paquetes[0]->getLote()->getProducto() : null,
        paquetes: $paquetes,
      );
    }

    return new ReporteOrdenEstante(
      reporte_uuid: $reporteOrdenEstanteRecord->reporte_uuid,
      fecha: $reporteOrdenEstanteRecord->fecha,
      estante_id: $reporteOrdenEstanteRecord->estante_id,
      detalles: $detalles,
    );
  }

  public function guardar(ReporteOrdenEstante $reporteOrdenEstante)
    {
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

            if($paquete->estaEnAlmacen())
            {
                $esta_en_almacen = 1;
                $estante_origen_id = $paquete->getEstanteId();
                $seccion_origen_id = $paquete->getSeccionId();
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
