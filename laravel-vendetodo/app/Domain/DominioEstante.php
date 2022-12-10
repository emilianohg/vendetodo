<?php

namespace App\Domain;

use App\Repositories\AlmacenRepository;
use App\Repositories\ReportesVentasRepository;
use Illuminate\Support\Str;

class DominioEstante
{
  private AlmacenRepository $almacenRepository;
  private ReportesVentasRepository $reportesVentasRepository;
  private LotesManager $lotesManager;

  public function __construct()
  {
    $this->almacenRepository = new AlmacenRepository();
    $this->reportesVentasRepository = new ReportesVentasRepository();
    $this->lotesManager = new LotesManager();
  }

  public function obtenerEstantePorEncargadoId(int $usuarioId): ?Estante
  {
    $encargado = $this->almacenRepository->obtenerEncargado($usuarioId);
    return $this->obtenerEstante($encargado->getEstanteId());
  }

  public function obtenerEstante(int $estanteId): ?Estante
  {
      $estantes = $this->almacenRepository->obtenerEstantes();
      return collect($estantes)
          ->filter(fn ($_estante) => $_estante->getEstanteId() == $estanteId)
          ->first();
  }

  public function comenzarOrdenamiento(int $estante_id)
  {
    $this->almacenRepository->bloquearEstante($estante_id);
  }

  public function terminarOrdenamiento(int $estante_id)
  {
    $this->almacenRepository->guardarCambios($estante_id);
    $this->almacenRepository->desbloquearEstante($estante_id);
  }

  public function cancelarOrdenamiento(int $estante_id)
  {
    $this->almacenRepository->descartarReporteOrdenEstante($estante_id);
  }

  public function obtenerOrdenProductos($estante_id): ReporteOrdenEstante
  {
    $estantes = $this->almacenRepository->obtenerEstantes();
    $productosExcluidos = $this->obtenerProductosExcluidos($estantes, $estante_id);
    $numeroSecciones = config('almacen.numero_secciones');

    $reporteVentas = $this->reportesVentasRepository->generarReporteVentas(
      now()->subDays(7)->toAtomString(),
      now()->toAtomString(),
      $productosExcluidos,
      true,
      $numeroSecciones,
    );
    
    $reporteOrdenEstante = new ReporteOrdenEstante(Str::uuid()->toString(), now(), $estante_id);
    
    $detalles = $reporteVentas->getDetallesReporteVentasProducto();

    foreach($detalles as $seccion_id => $detalle)
    {
      $producto = $detalle->getProducto();

      $cantidadProductosNecesarios = floor(Seccion::getVolumenSeccion() / $producto->getVolumen());

      $paquetes = $this->lotesManager->getPaquetes($cantidadProductosNecesarios, $producto->getId());

      $reporteOrdenEstante->agregarPaquetes($seccion_id+1,$paquetes);
    }
    $reporteOrdenEstante->guardar();

    return  $reporteOrdenEstante;
  }

  /**
   * @param Estante[] $estantes
   * @return Producto[]
   */
  public function obtenerProductosExcluidos( array $estantes, int $estante_id): array
  {
    $productosExcluidosId = [];
    foreach ($estantes as $estante) {
      if ($estante->getEstanteId() == $estante_id) {
        continue;
      }
      $secciones = $estante->getSecciones();
      foreach ($secciones as $seccion) {
        $producto = $seccion->getProducto();
        if ($producto == null) {
          continue;
        }
        $productosExcluidosId[] = $producto;
      }
    }
    return $productosExcluidosId;
  }
}
