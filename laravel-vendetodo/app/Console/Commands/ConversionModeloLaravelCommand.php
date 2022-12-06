<?php

namespace App\Console\Commands;

use App\Domain\Common\Pagination;
use App\Domain\Usuario;
use App\Models\User as UsuarioTable;
use App\Repositories\AlmacenRepository;
use Illuminate\Console\Command;
use App\Domain\DominioEstante;

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

    $estante = new DominioEstante();
    $reporEstante = new AlmacenRepository();
    $estantes = $reporEstante->obtenerEstantes();
    $productosExcluidos = $estante->obtenerIdProductosExcluidos($estantes, 1);

    \Log::info($estantes);

    return 0;
  }
}
