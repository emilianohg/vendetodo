<?php

namespace App\Domain;

use App\Domain\Common\DomainElement;

class PaqueteLote
{
  public function __construct(
    private int $lote_id,
    private Lote $lote,
    private int $cantidad,
    private ?int $estante_id = null,
    private ?int $seccion_id = null,
  ) {
  }

  public function getLoteId(): int
  {
    return $this->lote_id;
  }

  public function getLote(): Lote
  {
    return $this->lote;
  }

  public function getCantidad(): int
  {
    return $this->cantidad;
  }

  public function getEstanteId(): ?int
  {
    return $this->estante_id;
  }

  public function getSeccionId(): ?int
  {
    return $this->seccion_id;
  }
}
