<?php

namespace App\Console\Commands;

use App\Domain\Common\Pagination;
use App\Domain\Usuario;
use App\Models\User as UsuarioTable;
use App\Repositories\AlmacenRepository;
use Illuminate\Console\Command;

class ConversionModeloLaravelCommand extends Command
{
    protected $signature = 'demo:conversion';

    protected $description = 'Demo Conversion';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $almacen = new AlmacenRepository();

        $estantes = $almacen->obtenerEstantes();

        \Log::info($estantes);

        return 0;
    }
}
