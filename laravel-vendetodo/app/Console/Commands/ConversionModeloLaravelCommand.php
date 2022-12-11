<?php

namespace App\Console\Commands;

use App\Repositories\LotesRepository;
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


    $lotesRepository = new LotesRepository();
    $lotes = $lotesRepository->getLotes([1074, 1075]);
    foreach ($lotes as $lote) {
        \Log::info($lote->getLoteId());
        \Log::info($lote->getProducto()->getNombre());
    }
    return 0;
  }
}
