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
        $totalProductos = Producto::query()->count();
        if ($totalProductos > 0) {
          echo "Skipped: ProductosSeeder \n";
          return;
        }

        $csvProductos = Reader::createFromPath(storage_path('csv/productos.csv'));
        $csvProductos->setHeaderOffset(0);

        $recordsProductos = $csvProductos->getRecords();

        $csvImagenes = Reader::createFromPath(storage_path('csv/imagenes.csv'));
        $csvImagenes->setHeaderOffset(0);

        $recordsImagenes = $csvImagenes->getRecords();
        $imagenes = collect($recordsImagenes)->keyBy('producto_id');

        foreach ($recordsProductos as $record) {

            if ($record['largo'] == 0 || $record['ancho'] == 0 || $record['alto'] == 0) {
                continue;
            }

            $marca = Marca::query()->where('nombre', '=', $record['marca'])->first();

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

            echo $marca->id;

            Producto::query()->create([
                'nombre' => $record['nombre'],
                'descripcion' => '',
                'precio' => $record['precio'],
                'marca_id' => $marca->marca_id,
                'largo' => $record['largo'],
                'ancho' => $record['ancho'],
                'alto' => $record['alto'],
                'status' => 'libre',
                'imagen_url' => $imagen_url,
            ]);
        }

    }
}
