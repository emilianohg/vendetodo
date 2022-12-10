<?php

namespace App\Repositories;

use App\Domain\MetodoPago;
use App\Models\MetodoPago as MetodoPagoTable;

class MetodosPagoRepository
{
    public function obtenerTodos() {
        $metodosPago = MetodoPagoTable::query()->get();
        return MetodoPago::fromArray($metodosPago->toArray());
    }
}