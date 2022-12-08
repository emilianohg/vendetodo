<?php

namespace App\Console\Commands;

use App\Domain\Common\Pagination;
use App\Domain\Usuario;
use App\Models\User as UsuarioTable;
use App\Repositories\AlmacenRepository;
use App\Repositories\ReportesVentasRepository;
use Illuminate\Console\Command;
use App\Domain\DominioEstante;
use App\Domain\DominioOrden;
use App\Models\AlmacenTable;
use App\Repositories\LotesRepository;

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

    $dominio = new DominioEstante();
    $dominio->obtenerOrdenProductos(1);
    
    return 0;
  }
}
