<?php

namespace App\Console\Commands;

use App\Domain\Common\Pagination;
use App\Domain\Usuario;
use App\Models\User as UsuarioTable;
use App\Repositories\AlmacenRepository;
use App\Repositories\ReportesVentasRepository;
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
    $estante->obtenerOrdenProductos(1);

    return 0;
  }
}
