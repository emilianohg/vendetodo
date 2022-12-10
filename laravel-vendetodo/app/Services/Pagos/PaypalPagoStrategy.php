<?php

namespace App\Services\Pagos;


use App\Domain\MetodoPago;
use App\Domain\Pago;
use Ramsey\Uuid\Uuid;

class PaypalPagoStrategy extends PagosStrategy
{
    public function __construct(
        private string $privateKey,
        private string $publicKey
    ) {
        parent::__construct();
    }

    public function generar(int $usuarioId, float $importe): Pago
    {
        $referencia = 'paypal-' . Uuid::uuid4();
        return $this->pagosRepository->registrar($usuarioId, MetodoPago::PAYPAL, $importe, $referencia);
    }
}