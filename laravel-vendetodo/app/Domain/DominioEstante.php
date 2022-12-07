<?php

namespace App\Domain;

use App\Repositories\AlmacenRepository;
use App\Repositories\ReportesVentasRepository;
use App\Repositories\ReportesOrdenEstanteRepository;
use Illuminate\Support\Str;

class DominioEstante
{
  private AlmacenRepository $almacenRepository;
  private ReportesVentasRepository $reportesVentasRepository;
  private ReportesOrdenEstanteRepository $reportesOrdenEstanteRepository;

  public function __construct()
  {
    $this->almacenRepository = new AlmacenRepository();
    $this->reportesVentasRepository = new ReportesVentasRepository();
    $this->reportesOrdenEstanteRepository = new ReportesOrdenEstanteRepository();
  }

  public function obtenerOrdenProductos($estante_id): void
  {
    $estantes = $this->almacenRepository->obtenerEstantes();
    $productosExcluidos = $this->obtenerIdProductosExcluidos($estantes, $estante_id);
    $reporteVentas = $this->reportesVentasRepository->generarReporteVentas(
      now()->subDays(7)->toAtomString(),
      now()->toAtomString(),
      $productosExcluidos,
      true,
      config('almacen.numero_secciones'),
    );
    $reporteOrden = new ReporteOrden(Str::uuid()->toString(), now()->toAtomString(), $estante_id);
    
  }

  /**
   * @param Estante[] $estantes
   * @return Producto[]
   */
  public function obtenerIdProductosExcluidos( array $estantes, int $estante_id): array
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
        $productosExcluidosId[] = $producto;
      }
    }
    return $productosExcluidosId;
  }
}
