<?php

namespace App\Domain;

use App\Repositories\LotesRepository;

class LotesManager
{
    private LotesRepository $lotesRepository;
    public function __construct()
    {
        $this->lotesRepository = new LotesRepository();
    }

    /**
    * @return PaqueteLote[]
    */
    public function getPaquetes(int $cantidadProductosNecesarios, int $producto_id): array
    {
        $lotes = $this->lotesRepository->buscarPorProductoId($producto_id);
        $paquetes = $this->generarPaquetes($lotes,$cantidadProductosNecesarios);

        return $paquetes;
    }

    /**
    * @param Lote[] $lotes
    * @return PaqueteLote[]
    */
    public function generarPaquetes(array $lotes, int $cantidadProductosNecesarios)
    {
        //agrupando por proveedor
        $lotesAgrupadosPorProveedor = collect($lotes)->groupBy(function ($lote) {
            return $lote->getProveedorId();
        });
        //obtener cantidad por proveedor y traer lote
        $proveedoresProductoLotes = [];
        foreach($lotesAgrupadosPorProveedor as $proveedorId=> $lotesProveedor){
            $registro = ['proveedor_id' => $proveedorId, 'cantidad' => 0, 'lotes' => []];

            foreach($lotesProveedor as $lote){
                $registro['cantidad'] += $lote->getCantidadAlmacen() + $lote->getCantidadBodega();
                $registro['lotes'][] = $lote;
            }
            $proveedoresProductoLotes[] = $registro;
        }

        //ordenados por la cantidad de producto 
        $proveedoresProductoOrdenado = collect($proveedoresProductoLotes)->sortByDesc('cantidad');

        //ordenar los lotes por fecha del mas antiguo al menos antiguo
        $cantidadNecesaria = $cantidadProductosNecesarios;
        $paquetesLote = [];
        foreach($proveedoresProductoOrdenado as $proveedorProducto)
        {
            $lotes = $proveedorProducto['lotes'];
            $lotesOrdenado = collect($lotes)->sortBy(fn ($lote) => $lote->getFecha());

            foreach($lotesOrdenado as $lote){
                $cantidadProporcionadaAlmacen = min($cantidadNecesaria, $lote->getCantidadAlmacen());
                if($cantidadProporcionadaAlmacen > 0)
                {
                    //hay productos que tomar
                    $paquetesLote[] = new PaqueteLote(
                        $lote->getLoteId(),
                        $lote,
                        $cantidadProporcionadaAlmacen, 
                        $lote->getEstanteId(),
                        $lote->getSeccionId(),
                    );

                    $cantidadNecesaria -= $cantidadProporcionadaAlmacen;
                }

                $cantidadProporcionadaBodega = min($cantidadNecesaria, $lote->getCantidadBodega());
                if($cantidadProporcionadaBodega > 0)
                {
                    //hay productos que tomar
                    $paquetesLote[] = new PaqueteLote(
                        $lote->getLoteId(),
                        $lote,
                        $cantidadProporcionadaBodega, 
                        null,
                        null,
                    );

                    $cantidadNecesaria -= $cantidadProporcionadaBodega;
                }

                if($cantidadNecesaria == 0)
                {
                    return $paquetesLote;
                }
            }  
        }
        return $paquetesLote;
    }
}