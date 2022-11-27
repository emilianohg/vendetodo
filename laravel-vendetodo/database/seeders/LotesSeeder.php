<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LotesSeeder extends Seeder
{
    public function run()
    {
        $proveedoresProductos = DB::table('proveedores_productos')->get();

        for ($i = 0; $i < count($proveedoresProductos); $i += 2) {

          $vendedorProducto = $proveedoresProductos[$i];
          $cantidad = 50 + rand(0, 25) * 5;

          $loteId = DB::table('lotes')->insertGetId([
            'proveedor_id' => $vendedorProducto->proveedor_id,
            'producto_id' => $vendedorProducto->producto_id,
            'cantidad' => $cantidad,
            'fecha' => now()->subDays(rand(1, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59))->setSecond(0),
          ]);

          DB::table('bodega')->insertGetId([
            'lote_id' => $loteId,
            'cantidad' => $cantidad,
            'cantidad_disponible' => $cantidad,
          ]);

        }

        $sumaCantidadProveedorProducto = DB::table('lotes')
          ->select([
            'proveedor_id',
            'producto_id',
            DB::raw('SUM(cantidad) as cantidad'),
          ])
          ->groupBy([
            'proveedor_id',
            'producto_id',
          ])
          ->get();

        foreach ($sumaCantidadProveedorProducto as $resumen) {
          DB::table('proveedores_productos')
            ->where([
              'proveedor_id' => $resumen->proveedor_id,
              'producto_id' => $resumen->producto_id,
            ])
            ->update([
              'cantidad' => $resumen->cantidad,
              'cantidad_disponible' => $resumen->cantidad,
            ]);

        }

    }
}
