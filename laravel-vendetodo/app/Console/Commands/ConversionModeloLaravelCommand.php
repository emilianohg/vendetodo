<?php

namespace App\Console\Commands;

use App\Domain\DominioEstante;

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


    $dominio = new DominioEstante();
    $dominio->obtenerOrdenProductos(1);
    return 0;
  }
}
