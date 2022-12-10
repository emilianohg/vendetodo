<?php

namespace App\Domain;

use App\Repositories\CarritosRepository;
use App\Repositories\MetodosPagoRepository;
use App\Repositories\UsuariosRepository;
use Illuminate\Support\Facades\DB;

class DominioVenta
{
    private UsuariosRepository $usuariosRepository;
    private CarritosRepository $carritosRepository;
    private MetodosPagoRepository $metodosPagoRepository;
    private OrdenManager $ordenManager;

    public function __construct()
    {
        $this->usuariosRepository = new UsuariosRepository();
        $this->carritosRepository = new CarritosRepository();
        $this->metodosPagoRepository = new MetodosPagoRepository();
        $this->ordenManager = new OrdenManager();
    }

    public function confirmar(int $usuarioId)
    {
        $usuario = $this->usuariosRepository->obtenerPorId($usuarioId);
        $carrito = $this->carritosRepository->buscarCarrito($usuarioId);
        $metodosPago = $this->metodosPagoRepository->obtenerTodos();

        return [
            'usuario' => $usuario,
            'carrito' => $carrito,
            'metodos_pago' => $metodosPago,
        ];
    }

    public function realizarVenta(int $usuarioId, int $metodoPagoId, int $direccionId)
    {
        return DB::transaction(function () use ($usuarioId, $metodoPagoId, $direccionId) {
            $carrito = $this->carritosRepository->buscarCarrito($usuarioId);
            $this->ordenManager->registrar($carrito);
        });
    }


}