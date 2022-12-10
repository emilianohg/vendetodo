<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;
use App\Repositories\OrdenesPreasignadasRepository;
use App\Repositories\OrdenesRepository;
use Illuminate\Support\Facades\DB;

class Orden extends DomainElement
{
    public const PENDIENTE = 'pendiente';
    public const EN_PROCESO = 'en_proceso';
    public const SURTIDA = 'surtida';
    public const CANCELADA = 'cancelada';
    public const FINALIZADA = 'finalizada';

    private OrdenesRepository $ordenRepository;

    /**
     * @param int $orden_id
     * @param int $usuario_id
     * @param string $status
     * @param int $pago_id
     * @param string $fecha_creacion
     * @param int $direccion_envio_id
     * @param Pago $pago
     * @param Direccion $direccion
     * @param Usuario $cliente
     * @param \App\Domain\DetalleOrden[] $detalle
     * @param int|null $surtidor_id
     * @param Usuario|null $surtidor
     */
    public function __construct(
        private int $orden_id,
        private int $usuario_id,
        private string $status,
        private int $pago_id,
        private string $fecha_creacion,
        private int $direccion_envio_id,
        private Pago $pago,
        private Direccion $direccion,
        private Usuario $cliente,
        private array $detalle,
        private ?int $surtidor_id = null,
        private ?Usuario $surtidor = null,
    ) {
        $this->ordenRepository = new OrdenesRepository();
    }

    /**
     * @param array $listValues
     * @return Orden[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }

    public static function from(array $values): Orden
    {
        return self::make(Orden::class, $values);
    }

    public function agregarDetalle(LineaCarrito $linea):void
    {
        $this->detalle[] = $this->ordenRepository->agregarDetalle($this->getOrdenId(), $linea);
    }

    public function asignarSurtidor(int $surtidorId) {
        $this->surtidor_id = $surtidorId;
        $this->status = Orden::EN_PROCESO;

        $this->ordenRepository->asignarSurtidor($this->orden_id, $this->surtidor_id);
    }

    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getDetalle() as $detalleOrden) {
            $total += $detalleOrden->getCantidad() * $detalleOrden->getPrecio();
        }
        return $total;
    }

    public function getCantidadProductos(): int
    {
        $total = 0;
        foreach ($this->getDetalle() as $detalleOrden) {
            $total += $detalleOrden->getCantidad();
        }
        return $total;
    }

    public function getOrdenId(): int
    {
        return $this->orden_id;
    }

    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }

    public function getSurtidorId(): int
    {
        return $this->surtidor_id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getPagoId(): int
    {
        return $this->pago_id;
    }

    public function getFechaCreacion(): string
    {
        return $this->fecha_creacion;
    }

    public function getDireccionEnvioId(): int
    {
        return $this->direccion_envio_id;
    }

    public function getPago(): Pago
    {
        return $this->pago;
    }

    public function getDireccion(): Direccion
    {
        return $this->direccion;
    }

    public function getCliente(): Usuario
    {
        return $this->cliente;
    }

    public function getSurtidor(): ?Usuario
    {
        return $this->surtidor;
    }

    /**
     * @return DetalleOrden[]
     */
    public function getDetalle(): array
    {
        return $this->detalle;
    }

}