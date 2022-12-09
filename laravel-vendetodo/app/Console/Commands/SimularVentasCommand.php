<?php

namespace App\Console\Commands;

use App\Domain\Orden;
use App\Models\OrdenTable;
use App\Models\PagoTable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class SimularVentasCommand extends Command
{
    protected $signature = 'simular:ventas {--ordenes=10 : Numero de ordenes a crear}';

    protected $description = 'Agrega ordenes';

    public function handle()
    {
        $totalVentas = $this->option('ordenes');

        $status = null;
/*
        if ($this->hasOption('status')) {
            $statusValido = collect([
                Orden::EN_PROCESO,
                Orden::PENDIENTE,
                Orden::SURTIDA,
                Orden::FINALIZADA,
                Orden::CANCELADA,
            ])
                ->search($this->option('status'));

            if (!$statusValido) {
                $this->error('ESCRIBE BIEN!!! Ese status no es valido');
                return 1;
            }

            $status = $this->option('status');
        }
* */

        $surtidores = DB::table('surtidores')->get();

        $productoslist = DB::table('proveedores_productos')
            ->select([
                'proveedores_productos.producto_id',
                'proveedores_productos.proveedor_id',
                'proveedores_productos.cantidad',
                'proveedores_productos.cantidad_disponible',
                'productos.precio',
            ])
            ->join('productos', 'proveedores_productos.producto_id', '=', 'productos.producto_id')
            ->where('cantidad_disponible', '>', 0)
            ->get();

        $usuarios = DB::table('usuarios')
            ->where('rol_id', '=', 5)
            ->whereNotNull('direccion_id')
            ->get();

        for ($i = 0; $i < $totalVentas; $i++) {

            DB::transaction(function () use ($usuarios, $productoslist, $status, $surtidores) {

                $statusList = [Orden::EN_PROCESO, Orden::PENDIENTE, Orden::SURTIDA, Orden::FINALIZADA];

                $cliente = $usuarios->random();
                $numeroProductos = rand(1, 10);
                $productos = $productoslist->random($numeroProductos);

                if ($status == null) {
                    $status = $statusList[rand(0, count($statusList) - 1)];

                    $probCancelada = rand(0, 100);
                    if ($probCancelada > 95) {
                        $status = Orden::CANCELADA;
                    }
                }

                $surtidorId = null;
                if ($status != Orden::PENDIENTE) {
                    $surtidorId = $surtidores->random()->surtidor_id;
                }

                $detallesOrdenes = $productos->map(function ($producto) {

                    $cantidad = rand(1, min($producto->cantidad_disponible, 10));

                    return [
                        'producto_id' => $producto->producto_id,
                        'proveedor_id' => $producto->proveedor_id,
                        'cantidad' => $cantidad,
                        'precio' => $producto->precio,
                    ];
                });

                $pago = PagoTable::query()->create([
                    'metodo_pago_id' => 1,
                    'referencia' => Uuid::uuid4(),
                    'fecha' => now(),
                ]);

                $orden = OrdenTable::query()->create([
                    'usuario_id' => $cliente->usuario_id,
                    'surtidor_id' => $surtidorId,
                    'status' => $status,
                    'pago_id' => $pago->pago_id,
                    'fecha_creacion' => now(),
                    'direccion_envio_id' => $cliente->direccion_id,
                ]);

                $orden->detalle()->createMany($detallesOrdenes);

            });

        }

        return 0;
    }
}
