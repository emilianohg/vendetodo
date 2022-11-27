<?php
namespace App\Domain;

use App\Domain\Common\DomainElement;
use App\Repositories\CarritosRepository;

class Carrito 
{
    private int $usuario_id;
    /**  
     * @var LineaCarrito[]
     */
    private array $lineasCarrito;
    private CarritosRepository $carritoRepository;

    public function __construct(
        int $usuario_id,
        array $lineasCarrito = [],
    )
    {
        $this->usuario_id = $usuario_id;
        $this->lineasCarrito = $lineasCarrito;
        $this->carritosRepository = new CarritosRepository();
    }

    public function agregarLineaCarrito(int $producto_id, int $proveedor_id, int $cantidad): void
    {
        $lineaCarrito = new LineaCarrito($producto_id,$proveedor_id,$cantidad);
        $this->lineasCarrito[] = $lineaCarrito;

        $this->carritosRepository->agregarLineaCarrito($this->usuario_id, $lineaCarrito);
    }
}