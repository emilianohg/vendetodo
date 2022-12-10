<?php

namespace App\Domain;

class OrdenManager
{
    private LotesManager $lotesManager;

    public function __construct()
    {
        $this->lotesManager = new LotesManager();
    }

    public function registrar(Carrito $carrito)
    {
        $carrito->bloquear();

    }

    /*
     * TABLA DE PAGOS
     *
     * pago_id
     * metodo_pago_id
     * referencia
     * fecha_solicitud
     *
     * usuario_id <-
     * status [pagada, no pagada] <- NO PAGADO
     * importe <-
     * fecha_pago null <-
     */
}