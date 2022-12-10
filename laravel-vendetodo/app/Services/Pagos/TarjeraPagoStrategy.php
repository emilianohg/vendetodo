<?php

namespace App\Services\Pagos;

use App\Domain\MetodoPago;
use App\Domain\Pago;
use Ramsey\Uuid\Uuid;

class TarjeraPagoStrategy extends PagosStrategy
{
    public function __construct() {
        parent::__construct();
    }

    public function generar(int $usuarioId, float $importe): Pago
    {
        $referencia = 'stripe-' . Uuid::uuid4();
        return $this->pagosRepository->registrar($usuarioId, MetodoPago::TARJETA, $importe, $referencia);
    }
}