<?php

namespace App\Console\Commands;

use App\Repositories\OrdenesPreasignadasRepository;
use App\Repositories\OrdenesRepository;
use Illuminate\Console\Command;

class RepartirOrdenesASurtidoresCommand extends Command
{
    protected $signature = 'ordenes:surtir';

    protected $description = 'Asigna un surtidor a una orden';

    public function handle()
    {
        $ordenesRepository = new OrdenesRepository();
        $ordenesPreasignadasRepository = new OrdenesPreasignadasRepository();

        $ordenes = $ordenesRepository->getOrdenesPendientes();

        $resumenSurtidores = $ordenesRepository->getSurtidoresDisponibles(
            now()->startOfDay()->toISOString(),
            now()->toISOString(),
        );

        foreach ($resumenSurtidores as $i => $resumenSurtidor) {

            if (!isset($ordenes[$i])) {
                break;
            }

            $orden = $ordenes[$i];

            $ordenesPreasignadasRepository->registrar(
                $orden->getOrdenId(),
                $resumenSurtidor->getSurtidorId(),
            );
        }

    }
}
