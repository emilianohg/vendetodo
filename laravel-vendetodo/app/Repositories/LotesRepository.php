<?php

namespace App\Repositories;

use App\Models\Lote as LoteTable;
use App\Domain\Lote;
use Illuminate\Support\Facades\DB;

class LotesRepository
{
    /**
     * @param int $productoId
     * @return Lote[]
     */
    public function buscarPorProductoId(int $productoId): array
    {
        return $this->buscarPorProductoProveedorId($productoId);
    }

    /**
     * @param int $productoId
     * @param int|null $proveedorId
     * @return Lote[]
     */
    public function buscarPorProductoProveedorId(int $productoId, ?int $proveedorId = null): array
    {
        $lotesQuery = LoteTable::query()->select([
            'lotes.lote_id',
            'lotes.producto_id',
            'lotes.fecha',
            'lotes.proveedor_id',
            'lotes.cantidad',
            DB::raw('COALESCE(bodega.cantidad_disponible, 0) as cantidadBodega'),
            DB::raw('COALESCE(control_almacen.cantidad_disponible, 0) as cantidadAlmacen'),
            'control_almacen.estante_id',
            'control_almacen.seccion_id',
        ])
            ->with(['producto', 'producto.marca'])
            ->leftJoin('control_almacen', 'control_almacen.lote_id','=', 'lotes.lote_id')
            ->leftJoin('bodega', 'bodega.lote_id', '=', 'lotes.lote_id')
            ->where('lotes.producto_id','=',$productoId)
            ->whereRaw('COALESCE(bodega.cantidad_disponible, 0) + COALESCE(control_almacen.cantidad_disponible, 0) > 0');

        if ($proveedorId != null) {
            $lotesQuery->where('lotes.proveedor_id', '=', $proveedorId);
        }

        $lotes = $lotesQuery->get();

        return Lote::fromArray($lotes->toArray());
    }

}