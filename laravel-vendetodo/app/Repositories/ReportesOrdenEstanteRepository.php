<?php

namespace App\Repositories;

use App\Domain\ReporteOrden\ReporteOrden;

class ReportesOrdenEstanteRepository
{

    public function generarReporte(): ReporteOrden
    {
        return new ReporteOrden();
    }
}
