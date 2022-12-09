<?php

namespace App\Repositories;

use App\Domain\Lote;
use App\Domain\PaqueteLote;
use App\Domain\Ruta;
use App\Domain\UbicacionProducto;
use App\Models\Lote as LoteTable;
use Illuminate\Support\Facades\DB;

class RutasRepository
{

    public function buscarPorId(int $ordenId)
    {
        $lotesList = LoteTable::query()->select([
            'lotes.lote_id',
            'lotes.producto_id',
            'lotes.fecha',
            'lotes.proveedor_id',
            'lotes.cantidad',
            DB::raw('COALESCE(bodega.cantidad_disponible, 0) as cantidadBodega'),
            DB::raw('COALESCE(control_almacen.cantidad_disponible, 0) as cantidadAlmacen'),
            'control_almacen.estante_id',
            'control_almacen.seccion_id',
            'rutas.orden_id',
            'rutas.orden',
            'rutas.esta_en_bodega',
            'rutas.fecha_recogido',
            'rutas.cantidad as cantidad_recoger',
            'rutas.estante_id as estante_id_recoger',
            'rutas.seccion_id as seccion_id_recoger',
        ])
            ->join('rutas', 'rutas.lote_id', '=', 'lotes.lote_id')
            ->with(['producto', 'producto.marca'])
            ->leftJoin('control_almacen', 'control_almacen.lote_id','=', 'lotes.lote_id')
            ->leftJoin('bodega', 'bodega.lote_id', '=', 'lotes.lote_id')
            ->where('rutas.orden_id','=',$ordenId)
            ->get();

        \Log::info($lotesList);

        $lotes = Lote::fromArray($lotesList->toArray());

        $ubicaciones = [];

        foreach ($lotesList as $i => $record) {
            $lote = $lotes[$i];
            \Log::info($lote->getLoteId());

            $paquete = new PaqueteLote(
                $lote->getLoteId(),
                $lote,
                $record->cantidad_recoger,
                $record->estante_id_recoger,
                $record->seccion_id_recoger,
            );

            $ubicaciones[] = new UbicacionProducto($paquete, $record->orden);
        }

        $reporteRuta = DB::table('reportes_rutas')
            ->where('orden_id', '=', $ordenId)
            ->first();

        return new Ruta($ordenId, $reporteRuta->fecha, $ubicaciones, $reporteRuta->camino);
    }

    public function guardar(Ruta $ruta): void
    {
        DB::transaction(function () use ($ruta) {
            DB::table('reportes_rutas')->insert([
                'orden_id' => $ruta->getOrdenId(),
                'fecha' => $ruta->getFecha(),
                'camino' => $ruta->getCamino(),
            ]);

            $ubicaciones = [];
            foreach ($ruta->getUbicaciones() as $ubicacion) {
                $ubicaciones[] = [
                    'orden_id' => $ruta->getOrdenId(),
                    'orden' => $ubicacion->getOrden(),
                    'estante_id' => $ubicacion->getPaqueteLote()->getEstanteId(),
                    'seccion_id' => $ubicacion->getPaqueteLote()->getSeccionId(),
                    'lote_id' => $ubicacion->getPaqueteLote()->getLoteId(),
                    'cantidad' => $ubicacion->getPaqueteLote()->getCantidad(),
                    'esta_en_bodega' => $ubicacion->getPaqueteLote()->estaEnBodega(),
                    'fecha_recogido' => null,
                ];
            }

            DB::table('rutas')->insert($ubicaciones);
        });
    }
}