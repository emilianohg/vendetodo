<?php

namespace App\Domain;

class OrdenNoAsignadaException extends \Exception
{
    public function __construct()
    {
        parent::__construct('La orden no esta asignada a ti.', 422);
    }
}