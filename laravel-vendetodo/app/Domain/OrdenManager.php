<?php

namespace App\Domain;

use App\Repositories\OrdenesRepository;
use App\Repositories\UsuariosRepository;
use Illuminate\Support\Facades\DB;

class OrdenManager
{
    private LotesManager $lotesManager;
    private OrdenesRepository $ordenesRepository;
    private UsuariosRepository $usuariosRepository;

    public function __construct()
    {
        $this->lotesManager = new LotesManager();
        $this->ordenesRepository = new OrdenesRepository();
        $this->usuariosRepository = new UsuariosRepository();
    }

    /**
     * @throws ProductoAgotadoException
     */
    public function registrar(Carrito $carrito)
    {
        if ($carrito->estaBloqueado()) {
            return;
        }

        DB::beginTransaction();

        $carrito->bloquear();

        foreach ($carrito->getLineasCarrito() as $lineaCarrito) {
            $puedoComprar = $this->lotesManager->puedoComprar(
                $lineaCarrito->getProveedorId(),
                $lineaCarrito->getProductoId(),
                $lineaCarrito->getCantidad()
            );

            if (!$puedoComprar) {
                DB::rollBack();
                throw new ProductoAgotadoException($lineaCarrito->getProducto());
            }

            $this->lotesManager->apartar(
                $lineaCarrito->getProveedorId(),
                $lineaCarrito->getProductoId(),
                $lineaCarrito->getCantidad()
            );
        }

        DB::commit();

    }

    public function generar(Carrito $carrito, Pago $pago): Orden
    {
        $usuario = $this->usuariosRepository->obtenerPorId($carrito->getUsuarioId());
        $orden = $this->ordenesRepository->crear($usuario, $pago);
        foreach ($carrito->getLineasCarrito() as $lineaCarrito) {
            $orden->agregarDetalle($lineaCarrito);
        }
        $carrito->desbloquear();
        $carrito->limpiar();
        return $orden;
    }
}