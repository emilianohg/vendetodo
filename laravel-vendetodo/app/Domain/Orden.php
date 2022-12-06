<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;

class Orden extends DomainElement
{
    /**
     * @param int $orden_id
     * @param int $usuario_id
     * @param string $status
     * @param int $pago_id
     * @param string $fecha_creacion
     * @param int $direccion_envio_id
     * @param DetalleOrden[] $detalle
     * @param Pago $pago
     * @param Direccion $direccion
     * @param Usuario $cliente
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
        private array $detalle,
        private Pago $pago,
        private Direccion $direccion,
        private Usuario $cliente,
        private ?int $surtidor_id = null,
        private ?Usuario $surtidor = null,
    ) { }

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