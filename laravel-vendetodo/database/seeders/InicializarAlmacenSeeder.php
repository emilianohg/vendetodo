<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InicializarAlmacenSeeder extends Seeder
{
    public function run()
    {
        $proveedoresProductos = DB::table('proveedores_productos')
            ->where('cantidad_disponible', '>', 0)
            ->get();

        $productosId = [];

        foreach ($proveedoresProductos as $proveedoresProducto) {
            if(!collect($productosId)->search($proveedoresProducto->producto_id)) {
                $productosId[] = $proveedoresProducto->producto_id;
            }
        }

        $secciones = DB::table('almacen')->get();

        foreach ($secciones as $i => $seccion) {
            DB::table('almacen')
                ->where('estante_id', '=', $seccion->estante_id)
                ->where('seccion_id', '=', $seccion->seccion_id)
                ->update([
                    'producto_id' => $productosId[$i],
                ]);
        }

    }
}
