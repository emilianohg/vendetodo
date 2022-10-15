<?php

namespace Database\Seeders;

use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Database\Seeder;
use League\Csv\Reader;

class ProductosSeeder extends Seeder
{
    public function run()
    {
        $csvProductos = Reader::createFromPath(storage_path('csv/productos.csv'));
        $csvProductos->setHeaderOffset(0);

        $recordsProductos = $csvProductos->getRecords();

        $csvImagenes = Reader::createFromPath(storage_path('csv/imagenes.csv'));
        $csvImagenes->setHeaderOffset(0);

        $recordsImagenes = $csvImagenes->getRecords();
        $imagenes = collect($recordsImagenes)->keyBy('producto_id');

        foreach ($recordsProductos as $record) {
            $marca = Marca::query()->where('nombre', '=', $record['nombre'])->first();

            if ($marca == null) {
                $marca = Marca::query()->create([
                    'nombre' => $record['marca'],
                ]);
            }

            $imagenesDelProducto = isset($imagenes[$record['id']]) ? $imagenes[$record['id']] : null;

            $imagen_url = null;
            if ($imagenesDelProducto != null) {
                $imagen = isset($imagenesDelProducto[0]) ? $imagenesDelProducto[0] : $imagenesDelProducto;
                $imagen_url = $imagen['imagen_url'];
            }

            Producto::query()->create([
                'nombre' => $record['nombre'],
                'descripcion' => '',
                'precio' => $record['precio'],
                'marca_id' => $marca->id,
                'largo' => $record['largo'],
                'ancho' => $record['ancho'],
                'alto' => $record['alto'],
                'imagen_url' => $imagen_url,
            ]);
        }

    }
}
