<?php

namespace App\Repositories;

class ReportesVentasRepository
{

  /**
   * @param Producto[]
   * @return ReporteVentasProducto 
   */
    public function generarReporteVentas(
        string $fechainicio,
        string $fechaFinal,
        $productosExcluidos,
        bool $conExistencia,
    )
    {
        
    }
}
