<?php

namespace App\Console\Commands;

use App\Repositories\CarritosRepository;
use App\Repositories\LotesRepository;
use App\Repositories\PagosRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CancelarPagosPendientesCommand extends Command
{
    protected $signature = 'pagos:cancelar';

    protected $description = 'Cancela los pagos pendientes despues de un tiempo';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        return DB::transaction(function () {
            $carritosRepository = new CarritosRepository();
            $pagosRepository = new PagosRepository();
            $lotesRepository = new LotesRepository();

            $usuariosId = $carritosRepository->getUsuariosIdBloqueadosPorTiempo(3);

            foreach ($usuariosId as $usuarioId) {
                $carrito = $carritosRepository->buscarCarrito($usuarioId);

                foreach ($carrito->getLineasCarrito() as $lineaCarrito) {
                    $lotesRepository->desapartar(
                        $lineaCarrito->getProveedorId(),
                        $lineaCarrito->getProductoId(),
                        $lineaCarrito->getCantidad(),
                    );
                }

                $carrito->desbloquear();

                $pagosRepository->cancelarPagosPendientes($usuarioId);
            }

            return 0;
        });
    }
}
