<?php

namespace App\Repositories;

use App\Models\Lote as LoteTable;
use App\Domain\Lote;
use Illuminate\Support\Facades\DB;

class LotesRepository
{
    /**
     * @return Lote[]
     */
    public function buscarPorProductoId(int $producto_id): array
    {
        $lotes = LoteTable::select([
            'lotes.lote_id',
            'lotes.producto_id',
            'lotes.fecha',
            'lotes.proveedor_id',
            'lotes.cantidad',
            DB::raw('COALESCE(bodega.cantidad, 0) as cantidadBodega'),
            DB::raw('COALESCE(control_almacen.cantidad, 0) as cantidadAlmacen'),
            'control_almacen.estante_id',
            'control_almacen.seccion_id',
          ])
            ->with(['producto', 'producto.marca'])
            ->leftJoin('control_almacen', 'control_almacen.lote_id','=', 'lotes.lote_id')
            ->leftJoin('bodega', 'bodega.lote_id', '=', 'lotes.lote_id')
            ->where('lotes.producto_id','=',$producto_id)
            ->whereRaw('COALESCE(bodega.cantidad, 0) + COALESCE(control_almacen.cantidad, 0) > 0')
            ->get();

        $lotes = Lote::fromArray($lotes->toArray());
   
        return $lotes;
    }

}