<?php

namespace App\Console\Commands;

use App\Domain\Common\Pagination;
use App\Domain\Usuario;
use App\Models\User as UsuarioTable;
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

        $usuarioTable = UsuarioTable::with(['rol', 'direccion', 'metodo_pago'])->find(1);

        \Log::info($usuarioTable);

        $usuario = Usuario::from($usuarioTable->toArray());
        \Log::info((array) $usuario);

        return 0;
    }
}
