<?php
namespace App\Domain;

use App\Repositories\CarritosRepository;

class Carrito 
{
    private int $usuario_id;
    /**  
     * @var LineaCarrito[]
     */
    private array $lineasCarrito;
    private bool $bloqueado;
    private CarritosRepository $carritosRepository;

    public function __construct(
        int $usuario_id,
        array $lineasCarrito = [],
        bool $bloqueado = false,
    )
    {
        $this->usuario_id = $usuario_id;
        $this->lineasCarrito = $lineasCarrito;
        $this->bloqueado = $bloqueado;
        $this->carritosRepository = new CarritosRepository();
    }

    public function agregarLineaCarrito(int $producto_id, int $proveedor_id, int $cantidad): void
    {
        if(!$this->existe($producto_id,$proveedor_id))
        {
            $this->lineasCarrito[] = $this->carritosRepository->agregarLineaCarrito(
                $this->usuario_id,
                $producto_id, 
                $proveedor_id, 
                $cantidad,
            );
            return;
        }

        foreach($this->lineasCarrito as $linea)
        {
            if($linea->getProductoId() == $producto_id 
            && $linea->getProveedorId() == $proveedor_id)
            {
                $linea->sumarCantidad($cantidad);
                $this->carritosRepository->actualizarLineaCarrito($linea);
                break;
            }
        }

    }

    public function estaBloqueado(): bool
    {   
        return $this->bloqueado;
    }

    public function existe (int $producto_id, int $proveedor_id): bool
    {
        foreach($this->lineasCarrito as $linea)
        {
            if($linea->getProductoId() == $producto_id
            && $linea->getProveedorId() == $proveedor_id)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * @return LineaCarrito[]
     */
    public function getLineasCarrito()
    {
        return $this->lineasCarrito;
    }

    public function getTotal(): float
    {
        $total = 0;
        foreach($this->lineasCarrito as $linea)
        {
            $total += $linea->getSubtotal();
        }
        return $total;
    }
}