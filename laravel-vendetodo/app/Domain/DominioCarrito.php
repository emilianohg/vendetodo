<?php

namespace App\Domain;

use App\Repositories\CarritosRepository;

class DominioCarrito
{
    private CarritosRepository $carritosRepository;

    public function __construct()
    {
        $this->carritosRepository = new CarritosRepository();
    }

    public function agregarProductoCarrito(int $usuario_id, int $producto_id, int $proveedor_id, int $cantidad)
    {
        $carrito = $this->carritosRepository->buscarCarrito($usuario_id);
        $estaBloqueado = $carrito->estaBloqueado();
        if($estaBloqueado == false)
        {
            $carrito->agregarLineaCarrito($producto_id, $proveedor_id, $cantidad);
        }
        //regresar mensaje al usuario de que no puede agregar mientras paga.
    }
}