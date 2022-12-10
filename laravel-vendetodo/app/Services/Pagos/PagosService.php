<?php

namespace App\Services\Pagos;

use App\Domain\Pago;

class PagosService
{
    private PagosStrategy $pagosStrategy;

    public function setStrategy(PagosStrategy $pagosStrategy)
    {
        $this->pagosStrategy = $pagosStrategy;
    }

    public function generar(int $usuarioId, float $importe): Pago
    {
        return $this->pagosStrategy->generar($usuarioId, $importe);
    }
}