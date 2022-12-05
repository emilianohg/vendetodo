<?php

namespace App\Repositories;

use App\Domain\Producto;
use Illuminate\Support\Facades\DB;
use App\Domain\ResumenProductosProveedor;
use App\Models\Producto as ProductoBaseDatos;


class ProductosRepository
{

  /**
   * @param int $proveedorId
   * @return ResumenProductosProveedor[]
   */
  public function getResumenProveedores(int $productoId): array
  {
    $resumen = DB::table('proveedores_productos')->select([
      'proveedores_productos.proveedor_id',
      'proveedores.nombre as proveedor_nombre',
      'proveedores_productos.producto_id',
      'productos.nombre as producto_nombre',
      'proveedores_productos.cantidad',
      'proveedores_productos.cantidad_disponible'
    ])->join('proveedores', 'proveedores_productos.proveedor_id', '=', 'proveedores.proveedor_id')
      ->join('productos', 'proveedores_productos.producto_id', '=', 'productos.producto_id')
      ->where('proveedores_productos.producto_id', '=', $productoId)
      ->where('proveedores_productos.cantidad_disponible', '>', 0)
      ->get();

    return ResumenProductosProveedor::fromArray(collect($resumen)->toArray());
  }

  public function consultarPorId($id)
  {
    $producto = ProductoBaseDatos::with(['marca'])->findOrFail($id);
    return Producto::from($producto->toArray());
  }

  //TODO: Hacer uno para movil
}
