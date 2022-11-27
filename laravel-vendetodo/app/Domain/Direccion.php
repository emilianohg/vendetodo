<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;

class Direccion extends DomainElement
{
    public function __construct(
        private int $direccion_id,
        private string $colonia,
        private string $calle,
        private string $numero_ext,
        private string $codigo_postal,
        private int $usuario_id,
        private int $estado_id,
        private string $estado,
        private int $municipio_id,
        private string $municipio,
        private string $status,
    ) {}

    /**
     * @param array $listValues
     * @return Direccion[]
     */
    public static function fromArray(array $listValues): array
    {
        $items = [];
        foreach ($listValues as $values) {
            $items[] = self::from($values);
        }
        return $items;
    }

    public static function from(array $values): Direccion
    {
        return self::make(Direccion::class, $values);
    }

    public function getDireccionId(): int
    {
        return $this->direccion_id;
    }

    public function getColonia(): string
    {
        return $this->colonia;
    }

    public function getCalle(): string
    {
        return $this->calle;
    }

    public function getNumeroExt(): string
    {
        return $this->numero_ext;
    }

    public function getCodigoPostal(): string
    {
        return $this->codigo_postal;
    }

    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }

    public function getEstadoId(): int
    {
        return $this->estado_id;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function getMunicipioId(): int
    {
        return $this->municipio_id;
    }

    public function getMunicipio(): string
    {
        return $this->municipio;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

}