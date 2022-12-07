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
        //Partir de lote?
        $lotes = LoteTable::select([
            'lotes.lote_id',
            'lotes.producto_id',
            'lotes.fecha',
            'lotes.proveedor_id',
            'lotes.cantidad',
            'bodega.cantidad as cantidadBodega',
            DB::raw('COALESCE(control_almacen.cantidad, 0) as cantidadAlmacen'),
            'almacen.estante_id',
            'almacen.seccion_id',
          ])
            ->with(['producto', 'producto.marca'])
            ->leftJoin('control_almacen', 'control_almacen.lote_id','=', 'lotes.lote_id')
            ->leftJoin('almacen', function ($join) {
              $join->on('almacen.estante_id', '=', 'control_almacen.estante_id')
                ->on('almacen.seccion_id', '=', 'control_almacen.seccion_id');
            })
            ->join('bodega', 'bodega.lote_id', '=', 'lotes.lote_id')
            ->where('lotes.producto_id','=',$producto_id)
            ->get();

        $lotes = Lote::fromArray($lotes->toArray());

        

        return $lotes;
    }

}