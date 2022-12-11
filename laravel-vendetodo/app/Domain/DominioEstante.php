<?php

namespace App\Domain;

use App\Repositories\AlmacenRepository;
use App\Repositories\ReportesOrdenEstanteRepository;
use App\Repositories\ReportesVentasRepository;
use Illuminate\Support\Str;

class DominioEstante
{
  private AlmacenRepository $almacenRepository;
  private ReportesVentasRepository $reportesVentasRepository;
  private LotesManager $lotesManager;
  private ReportesOrdenEstanteRepository $reportesOrdenEstanteRepository;

  public function __construct()
  {
    $this->almacenRepository = new AlmacenRepository();
    $this->reportesVentasRepository = new ReportesVentasRepository();
    $this->lotesManager = new LotesManager();
    $this->reportesOrdenEstanteRepository = new ReportesOrdenEstanteRepository();
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

  public function comenzarOrdenamiento(int $usuarioId)
  {
    $encargado = $this->almacenRepository->obtenerEncargado($usuarioId);
    $estanteId = $encargado->getEstanteId();
    $this->almacenRepository->bloquearEstante($estanteId);
  }

  public function terminarOrdenamiento(int $usuarioId)
  {
    $encargado = $this->almacenRepository->obtenerEncargado($usuarioId);
    $estanteId = $encargado->getEstanteId();
    $this->almacenRepository->guardarCambios($estanteId);
    $this->almacenRepository->desbloquearEstante($estanteId);
  }

  public function cancelarOrdenamiento(int $usuarioId)
  {
    $encargado = $this->almacenRepository->obtenerEncargado($usuarioId);
    $estanteId = $encargado->getEstanteId();
    $this->almacenRepository->descartarReporteOrdenEstante($estanteId);
  }

  public function obtenerOrdenProductos(int $usuarioId): ReporteOrdenEstante
  {
      $encargado = $this->almacenRepository->obtenerEncargado($usuarioId);
      $estanteId = $encargado->getEstanteId();
      return $this->reportesOrdenEstanteRepository->obtenerOrdenProductosPorEstanteId($estanteId);
  }


  public function generarOrdenProductos(int $usuarioId): ReporteOrdenEstante
  {
    $estantes = $this->almacenRepository->obtenerEstantes();
    $encargado = $this->almacenRepository->obtenerEncargado($usuarioId);
    $estanteId = $encargado->getEstanteId();
    $estante = collect($estantes)->first(fn ($_estante) => $_estante->getEstanteId() == $estanteId);

    $this->almacenRepository->descartarReporteOrdenEstante($estanteId);

    $productosExcluidos = $this->obtenerProductosExcluidos($estantes, $estanteId);
    $numeroSecciones = config('almacen.numero_secciones');

    $reporteVentas = $this->reportesVentasRepository->generarReporteVentas(
      now()->subDays(7)->toAtomString(),
      now()->toAtomString(),
      $productosExcluidos,
      true,
      $numeroSecciones,
    );
    
    $reporteOrdenEstante = new ReporteOrdenEstante(Str::uuid()->toString(), now(), $estanteId);

    $detalles = $reporteVentas->getDetallesReporteVentasProducto();

    foreach($detalles as $seccion_id => $detalle)
    {
      $producto = $detalle->getProducto();

      $cantidadProductosNecesarios = floor(Seccion::getVolumenSeccion() / $producto->getVolumen());

      $paquetes = $this->lotesManager->getPaquetes($cantidadProductosNecesarios, $producto->getId());

      $reporteOrdenEstante->agregarPaquetes($seccion_id+1,$paquetes);
    }

    foreach ($estante->getSecciones() as $seccion) {
      $seccionesCubiertas = count($reporteOrdenEstante->getDetalles());

      if ($seccionesCubiertas >= $numeroSecciones) {
        break;
      }

      $producto = $seccion->getProducto();

      $coincidencias = collect($reporteOrdenEstante->getDetalles())
        ->filter(fn ($_detalleOrden) => $_detalleOrden->getProducto()->getId() == $producto->getId())
        ->count();

      if ($coincidencias > 0) {
        continue;
      }

      $cantidadProductosNecesarios = floor(Seccion::getVolumenSeccion() / $producto->getVolumen());

      $paquetes = $this->lotesManager->getPaquetes($cantidadProductosNecesarios, $producto->getId());

      $reporteOrdenEstante->agregarPaquetes($seccionesCubiertas + 1, $paquetes);
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
