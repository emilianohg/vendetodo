<?php

namespace App\Console\Commands;

use App\Domain\DominioOrden;
use Illuminate\Console\Command;

class RutaCommand extends Command
{
    protected $signature = 'demo:ruta';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $dominioOrden = new DominioOrden();
        $ruta = $dominioOrden->verRuta(4);
        \Log::info((array) $ruta);
        return 0;
    }
}
