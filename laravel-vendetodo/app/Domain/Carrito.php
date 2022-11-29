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
        bool $bloqueado,
    )
    {
        $this->usuario_id = $usuario_id;
        $this->lineasCarrito = $lineasCarrito;
        $this->bloqueado = $bloqueado;
        $this->carritosRepository = new CarritosRepository();
    }

    public function agregarLineaCarrito(int $producto_id, int $proveedor_id, int $cantidad): void
    {
        $lineaCarrito = new LineaCarrito($producto_id,$proveedor_id,$cantidad);
        $existe = $this->existe($lineaCarrito);
        if(!$existe)
        {
            $this->lineasCarrito[] = $lineaCarrito; //agregarLineaCarrito(lineaCarrito)
            $this->carritosRepository->agregarLineaCarrito($this->usuario_id, $lineaCarrito);
        }
        else
        {
            foreach($this->lineasCarrito as $linea)
            {
                if($linea->getProductoId() == $producto_id 
                && $linea->getProveedorId() == $proveedor_id)
                {
                    $linea->sumarCantidad($cantidad); //actualizarLineaCarrito(lineaCarrito)
                    $this->carritosRepository
                    ->actualizarLineaCarrito($this->usuario_id,$linea);
                    break;
                }
            }
        }

    }

    public function estaBloqueado(): bool
    {   
        return $this->bloqueado == false ? false : true;
    }

    public function existe (LineaCarrito $lineaCarrito): bool
    {
        /*
        $lineasCarrito = collect($this->lineasCarrito);
        if($lineasCarrito->contains($lineaCarrito))
        {
            return true;
        }
        return false;
        */

        foreach($this->lineasCarrito as $linea)
        {
            if($linea->getProductoId() == $lineaCarrito->getProductoId()
            && $linea->getProveedorId() == $lineaCarrito->getProveedorId())
            {
                return true;
            }
        }

        return false;
    }
}