<?php

namespace Database\Seeders;

use App\Domain\LotesManager;
use App\Repositories\AlmacenRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InicializarAlmacenSeeder extends Seeder
{
    public function run()
    {
        $almacenRepository = new AlmacenRepository();
        $lotesManager = new LotesManager();

        $proveedoresProductos = DB::table('proveedores_productos')
            ->where('cantidad_disponible', '>', 0)
            ->get();

        $productosId = [];

        foreach ($proveedoresProductos as $proveedoresProducto) {
            if(!collect($productosId)->search($proveedoresProducto->producto_id)) {
                $productosId[] = $proveedoresProducto->producto_id;
            }
        }

        $estantes = $almacenRepository->obtenerEstantes();

        $contador = 0;
        foreach ($estantes as $estante) {
            foreach ($estante->getSecciones() as $seccion) {
                DB::table('almacen')
                    ->where('estante_id', '=', $estante->getEstanteId())
                    ->where('seccion_id', '=', $seccion->getSeccionId())
                    ->update([
                        'producto_id' => $productosId[$contador],
                    ]);

                $contador++;
            }
        }

        $estantes = $almacenRepository->obtenerEstantes();

        foreach ($estantes as $estante) {
            \Log::info('===========================');
            \Log::info('Estante: ' . $estante->getEstanteId());
            foreach ($estante->getSecciones() as $seccion) {
                \Log::info('Seccion: ' . $seccion->getSeccionId());
                $cantidad = $seccion->getCantidadProductosNecesarios();
                \Log::info('Cantidad: ' . $seccion->getCantidadProductosNecesarios());

                $paquetes = $lotesManager->getPaquetes(
                    $cantidad,
                    $seccion->getProducto()->getId(),
                );

                \Log::info('===========================');
                \Log::info('PAQUETES PROPORCIONADOS');
                \Log::info('===========================');

                foreach ($paquetes as $paquete) {

                    \Log::info($paquete->getLoteId());
                    \Log::info($paquete->getLote()->getProducto()->getNombre());
                    \Log::info($paquete->getCantidad());

                    DB::table('control_almacen')->insert([
                        'estante_id' => $seccion->getEstanteId(),
                        'seccion_id' => $seccion->getSeccionId(),
                        'lote_id' => $paquete->getLoteId(),
                        'cantidad' => $paquete->getCantidad(),
                        'cantidad_disponible' => $paquete->getCantidad(),
                        'status' => 'libre',
                    ]);

                    DB::table('bodega')
                        ->where('lote_id', '=', $paquete->getLoteId())
                        ->decrement('cantidad', $paquete->getCantidad());


                    DB::table('bodega')
                        ->where('lote_id', '=', $paquete->getLoteId())
                        ->decrement('cantidad_disponible', $paquete->getCantidad());
                }
            }
        }
    }
}
