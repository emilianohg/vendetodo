<?php

namespace App\Console\Commands;

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

    $dominio = new DominioEstante();
    $dominio->obtenerOrdenProductos(1);
    
    return 0;
  }
}
