<?php

namespace App\Repositories;

use App\Domain\ResumenProductosProveedor;
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

    public function obtenerResumen(int $proveedorId, int $productoId): ResumenProductosProveedor
    {
        $proveedorProducto = DB::table('proveedores_productos')
            ->select([
                'proveedores_productos.proveedor_id',
                'proveedores.nombre as proveedor_nombre',
                'proveedores_productos.producto_id',
                'productos.nombre as producto_nombre',
                'proveedores_productos.cantidad',
                'proveedores_productos.cantidad_disponible',
            ])
            ->join('productos', 'productos.producto_id', '=', 'proveedores_productos.producto_id')
            ->join('proveedores', 'proveedores.proveedor_id', '=', 'proveedores_productos.proveedor_id')
            ->where('proveedores_productos.proveedor_id', '=', $proveedorId)
            ->where('proveedores_productos.producto_id', '=', $productoId)
            ->first();

        return new ResumenProductosProveedor(
            proveedor_id: $proveedorProducto->proveedor_id,
            proveedor_nombre: $proveedorProducto->proveedor_nombre,
            producto_id: $proveedorProducto->producto_id,
            producto_nombre: $proveedorProducto->producto_nombre,
            cantidad: $proveedorProducto->cantidad,
            cantidad_disponible: $proveedorProducto->cantidad_disponible,
        );
    }

    public function apartar(int $proveedorId, int $productoId, int $cantidad): void
    {
        DB::table('proveedores_productos')
            ->where('proveedores_productos.proveedor_id', '=', $proveedorId)
            ->where('proveedores_productos.producto_id', '=', $productoId)
            ->decrement('proveedores_productos.cantidad_disponible', $cantidad);
    }

    public function desapartar(int $proveedorId, int $productoId, int $cantidad): void
    {
        DB::table('proveedores_productos')
            ->where('proveedores_productos.proveedor_id', '=', $proveedorId)
            ->where('proveedores_productos.producto_id', '=', $productoId)
            ->increment('proveedores_productos.cantidad_disponible', $cantidad);
    }

}