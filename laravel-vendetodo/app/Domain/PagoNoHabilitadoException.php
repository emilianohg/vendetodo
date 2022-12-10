<?php

namespace App\Domain;


class PagoNoHabilitadoException extends \Exception
{
    public function __construct(Pago $pago)
    {
        $message = match ($pago->getStatus()) {
            Pago::PAGADO => 'Pago ya realizado',
            Pago::CANCELADO => 'Intento de pago cancelado',
            default => 'El pago se encuentra inhabilitado',
        };
        parent::__construct($message, 422);
    }
}