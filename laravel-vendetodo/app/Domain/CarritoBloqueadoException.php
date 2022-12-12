<?php

namespace App\Domain;

class CarritoBloqueadoException extends \Exception
{
    public function __construct()
    {
        parent::__construct('El carrito esta bloqueado no puedes agregar o eliminar articulos mientras dura el proceso de compra.');
    }
}