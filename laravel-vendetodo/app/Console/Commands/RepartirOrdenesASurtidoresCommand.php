<?php

namespace App\Console\Commands;

use App\Repositories\OrdenesRepository;
use Illuminate\Console\Command;

class RepartirOrdenesASurtidoresCommand extends Command
{
    protected $signature = 'ordenes:surtir';

    protected $description = 'Asigna un surtidor a una orden';

    public function handle()
    {
        $ordenesRepository = new OrdenesRepository();
        $ordenes = $ordenesRepository->getOrdenesPendientes();
        \Log::info($ordenes);
        return 0;
    }
}
