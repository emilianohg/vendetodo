<?php

namespace App\Domain;

use App\Repositories\AlmacenRepository;
use App\Repositories\ReportesVentasRepository;
use App\Repositories\ReportesOrdenEstanteRepository;

class DominioEstante
{
  private AlmacenRepository $almacenRepository;
  private ReportesVentasRepository $reportesVentasRepository;
  private ReportesOrdenEstanteRepository $reportesOrdenEstanteRepository;

  public function _construct()
  {
    $this->almacenRepository = new AlmacenRepository();
    $this->reportesVentasRepository = new ReportesVentasRepository();
    $this->reportesOrdenEstanteRepository = new ReportesOrdenEstanteRepository();
  }

  public function obtenerOrdenProductos($estante_id): void
  {
     $estantes = $this->almacenRepository->obtenerEstantes();
  }
}
