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

    /**
     * @throws CarritoBloqueadoException
     */
    public function agregarProductoCarrito(int $usuario_id, int $producto_id, int $proveedor_id, int $cantidad)
    {
        $carrito = $this->carritosRepository->buscarCarrito($usuario_id);
        if($carrito->estaBloqueado())
        {
            throw new CarritoBloqueadoException();
        }
        $carrito->agregarLineaCarrito($producto_id, $proveedor_id, $cantidad);
    }

    public function obtenerCarrito(int $usuario_id): Carrito
    {
        return $this->carritosRepository->buscarCarrito($usuario_id);
    }

    /**
     * @throws CarritoBloqueadoException
     */
    public function borrarLineaCarrito(int $usuarioId, int $linea_carrito_id): void
    {
        $carrito = $this->carritosRepository->buscarCarrito($usuarioId);
        if ($carrito->estaBloqueado()) {
            throw new CarritoBloqueadoException();
        }
        $this->carritosRepository->borrarLineaCarrito($linea_carrito_id);
    }
}