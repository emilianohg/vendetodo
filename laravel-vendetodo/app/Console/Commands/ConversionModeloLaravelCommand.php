<?php

namespace App\Console\Commands;

use App\Domain\DominioEstante;
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


    $repository = new AlmacenRepository();
    $repository->guardarCambios(1);
    return 0;
  }
}
