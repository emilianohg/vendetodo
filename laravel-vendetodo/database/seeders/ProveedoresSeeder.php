<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedoresSeeder extends Seeder
{
    public function run()
    {
      $totalProveedores = 300;
      $proveedoresPorProducto = 3;

      Proveedor::factory()
        ->count($totalProveedores)
        ->create();

      $totalProductos = Producto::query()->count();

      for ($i = 0; $i < $totalProductos; $i++) {
        $productoId = $i + 1;
        $count = 0;

        while ($count < $proveedoresPorProducto) {

          $proveedorId = rand(1, $totalProveedores);

          $existe = DB::table('proveedores_productos')
            ->where('proveedor_id', '=', $proveedorId)
            ->where('producto_id', '=', $productoId)
            ->exists();

          if (!$existe) {
            DB::table('proveedores_productos')->insert([
              'proveedor_id' => $proveedorId,
              'producto_id' => $productoId,
              'cantidad' => 0,
              'cantidad_disponible' => 0,
            ]);

            $count++;
          }
        }

      }

    }
}
