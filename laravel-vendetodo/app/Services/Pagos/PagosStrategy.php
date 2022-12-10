<?php

namespace App\Services\Pagos;

use App\Domain\Pago;
use App\Repositories\PagosRepository;

abstract class PagosStrategy
{
    protected PagosRepository $pagosRepository;

    public function __construct()
    {
        $this->pagosRepository = new PagosRepository();
    }

    public abstract function generar(int $usuarioId, float $importe): Pago;
}