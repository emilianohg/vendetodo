<?php

namespace App\Domain;

use App\Repositories\AlmacenRepository;
use App\Repositories\ReportesVentasRepository;
use App\Repositories\ReportesOrdenEstanteRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DominioEstante
{
  private AlmacenRepository $almacenRepository;
  private ReportesVentasRepository $reportesVentasRepository;
  private ReportesOrdenEstanteRepository $reportesOrdenEstanteRepository;
  private LotesManager $lotesManager;

  public function __construct()
  {
    $this->almacenRepository = new AlmacenRepository();
    $this->reportesVentasRepository = new ReportesVentasRepository();
    $this->reportesOrdenEstanteRepository = new ReportesOrdenEstanteRepository();
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

  public function obtenerOrdenProductos($estante_id): ReporteOrden
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
    
    $reporteOrden = new ReporteOrden(Str::uuid()->toString(), now()->toAtomString(), $estante_id);
    $detalles = $reporteVentas->getDetallesReporteVentasProducto();

    $estante = collect($estantes)
      ->filter(fn ($_estante) => $_estante->getEstanteId() == $estante_id)
      ->first();
    
    foreach($detalles as $detalle)
    {
      $producto = $detalle->getProducto();
      $seccion = $estante->getSeccionPorProductoId($producto->getId());

      if($seccion == null)
      {
        $cantidadProductosNecesarios = floor(config('almacen.volumen_seccion')*100 / $producto->getVolumen());
      }
      else
      {
        $cantidadProductosNecesarios = $seccion->getCantidadProductosNecesarios();
      }
      
      $paquetes = $this->lotesManager->getPaquetes($cantidadProductosNecesarios,$producto->getId());
        \Log::info('---------------------------');
        \Log::info('Producto: ' . $producto->getNombre());
        \Log::info('---------------------------');

      foreach ($paquetes as $paquete) {
          \Log::info('Lote: ' . $paquete->getLoteId());
          \Log::info('Cant: ' . $paquete->getCantidad());
          \Log::info('Est: ' . $paquete->getEstanteId());
          \Log::info('Secc: ' . $paquete->getSeccionId());
      }

    }

    return $reporteOrden;
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
