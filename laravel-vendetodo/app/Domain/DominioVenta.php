<?php

namespace App\Domain;

use App\Repositories\CarritosRepository;
use App\Repositories\MetodosPagoRepository;
use App\Repositories\PagosRepository;
use App\Repositories\UsuariosRepository;
use App\Services\Pagos\PagosService;
use App\Services\Pagos\PaypalPagoStrategy;
use App\Services\Pagos\TarjeraPagoStrategy;
use Illuminate\Support\Facades\DB;

class DominioVenta
{
    private UsuariosRepository $usuariosRepository;
    private CarritosRepository $carritosRepository;
    private MetodosPagoRepository $metodosPagoRepository;
    private OrdenManager $ordenManager;
    private PagosService $pagosService;
    private PagosRepository $pagosRepository;

    public function __construct()
    {
        $this->usuariosRepository = new UsuariosRepository();
        $this->carritosRepository = new CarritosRepository();
        $this->metodosPagoRepository = new MetodosPagoRepository();
        $this->ordenManager = new OrdenManager();
        $this->pagosService = new PagosService();
        $this->pagosRepository = new PagosRepository();
    }

    public function visualizar(int $usuarioId)
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

    /**
     * @param int $usuarioId
     * @param int $metodoPagoId
     * @param int $direccionId
     * @return Pago
     * @throws ProductoAgotadoException
     */
    public function realizarVenta(int $usuarioId, int $metodoPagoId, int $direccionId): Pago
    {
        DB::beginTransaction();

        $carrito = $this->carritosRepository->buscarCarrito($usuarioId);

        try {
            $this->ordenManager->registrar($carrito);
        } catch (ProductoAgotadoException $e) {
            DB::rollBack();
            throw $e;
        }

        $strategy = match ($metodoPagoId) {
            MetodoPago::PAYPAL => new PaypalPagoStrategy(config('paypal.secret_key'), config('paypal.public_key')),
            MetodoPago::TARJETA => new TarjeraPagoStrategy(),
        };

        $this->pagosService->setStrategy($strategy);

        $pago = $this->pagosService->generar($usuarioId, $carrito->getTotal());

        DB::commit();

        return $pago;
    }

    /**
     * @throws PagoNoHabilitadoException
     */
    public function confirmar(string $referencia): Orden
    {
        $pago = $this->pagosRepository->buscarPorReferencia($referencia);

        if ($pago->getStatus() != Pago::PENDIENTE) {
            throw new PagoNoHabilitadoException($pago);
        }

        return DB::transaction(function () use ($referencia) {
            $pago = $this->pagosRepository->confirmar($referencia);
            $carrito = $this->carritosRepository->buscarCarrito($pago->getUsuarioId());
            return $this->ordenManager->generar($carrito, $pago);
        });
    }

}