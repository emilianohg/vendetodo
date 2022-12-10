<?php

namespace App\Domain;

use App\Repositories\PagosRepository;

class DominioPago
{
    private PagosRepository $pagosRepository;

    public function __construct()
    {
        $this->pagosRepository = new PagosRepository();
    }

    public function consultar(string $referencia): Pago
    {
        return $this->pagosRepository->buscarPorReferencia($referencia);
    }

    public function confirmar(string $referencia): Pago
    {
        return $this->pagosRepository->confirmar($referencia);
    }
}