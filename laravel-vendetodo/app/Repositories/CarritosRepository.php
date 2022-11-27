<?php
namespace App\Repositories;

use App\Domain\Carrito;
use App\Domain\LineaCarrito;
use Illuminate\Support\Facades\DB;
use App\Models\LineaCarrito as LineaCarritoBD;

class CarritosRepository 
{
    public function agregarLineaCarrito( int $usuario_id, LineaCarrito $lineaCarrito): void
    {
        LineaCarritoBD::query()->create([
            'usuario_id' => $usuario_id, 
            'producto_id' => $lineaCarrito->getProductoId(),
            'proveedor_id'=> $lineaCarrito->getProveedorId(),
            'cantidad' => $lineaCarrito->getCantidad()
        ]);
    }

    public function buscarCarrito($usuario_id): Carrito
    {
        $lineasCarritoArray = LineaCarritoBD::query()
            ->where('usuario_id','=',$usuario_id)
            ->get();

        $lineasCarritoObj = LineaCarrito::fromArray($lineasCarritoArray->toArray());
        return  new Carrito($usuario_id, $lineasCarritoObj);
    }
}