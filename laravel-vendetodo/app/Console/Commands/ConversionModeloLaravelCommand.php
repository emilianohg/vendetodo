<?php

namespace App\Console\Commands;

use App\Domain\Common\Pagination;
use App\Domain\Producto;
use App\Models\Producto as ProductoBaseDatos;
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
        /*
        $productoModel = ProductoBaseDatos::with(['marca'])->find(1);

        \Log::info($productoModel);

        $producto = Producto::from($productoModel->toArray());
        \Log::info((array) $producto);
        */

        $paginacionModel = ProductoBaseDatos::query()->paginate(24);

        $paginacion = Pagination::fromPaginator($paginacionModel, Producto::class);

        \Log::info((array) $paginacion);
        \Log::info($paginacion->getData());

        return 0;
    }
}
