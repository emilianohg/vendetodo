<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;

class Usuario extends DomainElement
{

    /**
     * Usuario constructor.
     * @param int $usuario_id
     * @param string $nombre
     * @param string $email
     * @param int $rol_id
     * @param int $metodo_pago_id
     * @param int $direccion_id
     * @param string $created_at
     * @param string $updated_at
     * @param Rol $rol
     * @param \App\Domain\Direccion[] $direcciones
     * @param Direccion|null $direccion
     * @param MetodoPago|null $metodo_pago
     */
    public function __construct(
        private int $usuario_id,
        private string $nombre,
        private string $email,
        private int $rol_id,
        private int $metodo_pago_id,
        private int $direccion_id,
        private string $created_at,
        private string $updated_at,
        private Rol $rol,
        private ?array $direcciones = [],
        private ?Direccion $direccion = null,
        private ?MetodoPago $metodo_pago = null,
    ) {}

    /**
     * @param array $listValues
     * @return Usuario[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }

    public static function from(array $values): Usuario
    {
        return self::make(Usuario::class, $values);
    }

    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRolId(): int
    {
        return $this->rol_id;
    }

    public function getMetodoPagoId(): int
    {
        return $this->metodo_pago_id;
    }

    public function getDireccionId(): int
    {
        return $this->direccion_id;
    }

    public function getCreatedAt(): int
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): int
    {
        return $this->updated_at;
    }

    public function getRol(): Rol
    {
        return $this->rol;
    }

    public function getDireccion(): ?Direccion
    {
        return $this->direccion;
    }

    public function getMetodoPago(): ?MetodoPago
    {
        return $this->metodo_pago;
    }

    /**
     * @return Direccion[]|null
     */
    public function getDirecciones(): ?array
    {
        return $this->direcciones;
    }

}