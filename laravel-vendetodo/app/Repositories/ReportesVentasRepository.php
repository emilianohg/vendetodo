<?php

namespace App\Repositories;

use App\Domain\DetalleReporteVentasProducto;
use Illuminate\Support\Facades\DB;
use App\Domain\ReporteVentasProducto;
use App\Domain\Producto;
use App\Models\DetalleOrdenTable;
use App\Models\OrdenTable;

class ReportesVentasRepository
{

  /**
   * @param Producto[] $productosExcluidos
   * @return ReporteVentasProducto
   */
    public function generarReporteVentas(
        string $fechaInicial,
        string $fechaFinal,
        array $productosExcluidos,
        bool $conExistencia,
        int $limite,
    )
    {
        $productosExcluidosId = collect($productosExcluidos)->map(function ($producto) {
            return $producto->getId();
        });

        $subQuery = DB::table('proveedores_productos')->select([
            'producto_id',
            DB::raw('sum(cantidad) as cantidad')
        ]) ->groupBy('producto_id');
        
        $detalleQuery = DetalleOrdenTable::query()->select([
            'detalle_orden.producto_id',
            DB::raw('sum(detalle_orden.cantidad) as cantidad'),
            DB::raw('sum(detalle_orden.cantidad * detalle_orden.precio) as importe'),
        ])
        ->join('ordenes','ordenes.orden_id','=','detalle_orden.orden_id')
        ->joinSub($subQuery, 'p_p', function ($join) {
            $join->on('detalle_orden.producto_id', '=', 'p_p.producto_id');
        })
        ->whereNotIn('detalle_orden.producto_id', $productosExcluidosId->toArray())
        ->whereBetween('ordenes.fecha_creacion',[$fechaInicial,$fechaFinal])
        ->where('ordenes.status', '=', 'finalizada')
        ->with('producto')
        ->groupBy(['detalle_orden.producto_id'])
        ->orderByRaw('sum(detalle_orden.cantidad) desc');

        if($conExistencia){
            $detalleQuery->havingRaw('SUM(p_p.cantidad) > 0');
        }

        if($limite != null){
            $detalleQuery->limit($limite);
        }

        $detalle = $detalleQuery->get();

        $detalleReporteVentas = DetalleReporteVentasProducto::fromArray($detalle->toArray());

        return new ReporteVentasProducto(
            $fechaInicial,
            $fechaFinal,
            $productosExcluidosId->toArray(),
            $detalleReporteVentas,
        );
    }
}
