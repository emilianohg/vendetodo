<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;
use App\Repositories\PagosRepository;

class Pago extends DomainElement
{
    public const PAGADO = 'pagado';
    public const CANCELADO = 'cancelado';
    public const PENDIENTE = 'pendiente';

    private PagosRepository $pagosRepository;

    public function __construct(
        private int $pago_id,
        private int $metodo_pago_id,
        private string $referencia,
        private int $usuario_id,
        private string $status,
        private float $importe,
        private string $fecha_solicitud,
        private ?string $fecha_pago = null,
    ) {
        $this->pagosRepository = new PagosRepository();
    }

    /**
     * @param array $listValues
     * @return Pago[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }

    public static function from(array $values): Pago
    {
        return self::make(Pago::class, $values);
    }

    public function confirmar(): void
    {
        $this->pagosRepository->confirmar($this->referencia);
        $this->status = Pago::PAGADO;
    }

    public function getPagoId(): int
    {
        return $this->pago_id;
    }

    public function getMetodoPagoId(): int
    {
        return $this->metodo_pago_id;
    }

    public function getReferencia(): string
    {
        return $this->referencia;
    }

    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getFechaSolicitud(): string
    {
        return $this->fecha_solicitud;
    }

    public function getFechaPago(): ?string
    {
        return $this->fecha_pago;
    }

    public function getImporte(): float
    {
        return $this->importe;
    }

}