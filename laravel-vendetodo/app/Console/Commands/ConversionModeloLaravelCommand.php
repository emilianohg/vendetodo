<?php

namespace App\Console\Commands;

use App\Domain\DominioOrden;
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


    return 0;
  }
}
