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
    $productosExcluidos = $this->obtenerIdProductosExcluidos($estantes, $estante_id);
  }

  /**
   * @param Estante[]
   * @return int [] 
   */
  public function obtenerIdProductosExcluidos($estantes, int $estante_id)
  {
    $productosExcluidosId = [];
    for ($numEstante = 0; $numEstante < count($estantes); $numEstante++) {
      if ($estantes[$numEstante]->getEstanteId() == $estante_id) {
        continue;
      }
      $secciones = $estantes[$numEstante]->getSecciones();
      for ($numSeccion = 0; $numSeccion < count($secciones); $numSeccion++) {
        $producto = $secciones[$numSeccion]->getProducto();
        if ($producto == null) {
          continue;
        }
        $productosExcluidosId[] = $producto->getId();
      }
    }
    return $productosExcluidosId;
  }
}
