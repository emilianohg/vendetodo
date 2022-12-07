<?php

namespace App\Domain;
class ReporteVentasProducto
{
    /**
    * @param int[] $productoExcluidosId
    * @param DetalleReporteVentasProducto[] $detallesReporteVentasProducto
    */
    public function __construct(
        private string $fechaInicial,
        private string $fechaFinal,
        private array $productoExcluidosId,
        private array $detallesReporteVentasProducto,
    )
    {}

    public function getFechaInicial(): string
    {
        return $this->fechaInicial;
    }

    public function getFechaFinal(): string
    {
        return $this->fechaFinal;
    }

    /**
    * @return int[]
    */
    public function getProdcutosExcluidosId(): array
    {
        return $this->productoExcluidosId;
    }

    /**
    * @return DetalleReporteVentasProducto[]
    */
    public function getDetallesReporteVentasProducto(): array
    {
        return $this->detallesReporteVentasProducto;
    }
    
}
