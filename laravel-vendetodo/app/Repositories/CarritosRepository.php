<?php
namespace App\Repositories;

use App\Domain\Carrito;
use App\Domain\LineaCarrito;
use Illuminate\Support\Facades\DB;
use App\Models\LineaCarrito as LineaCarritoBD;

class CarritosRepository 
{
    public function agregarLineaCarrito( 
        int $usuario_id, 
        int $producto_id, 
        int $proveedor_id, 
        int $cantidad
    ): LineaCarrito
    {
        $lineaCarrito = LineaCarritoBD::query()->create([
            'usuario_id' => $usuario_id, 
            'producto_id' => $producto_id,
            'proveedor_id'=> $proveedor_id,
            'cantidad' => $cantidad,
        ])->load('producto','proveedor');

        return LineaCarrito::from($lineaCarrito->toArray());
    }

    public function actualizarLineaCarrito(LineaCarrito $lineaCarrito): void
    { 
        LineaCarritoBD::where('linea_carrito_id', '=', $lineaCarrito->getId())
        ->update(['cantidad'=>$lineaCarrito->getCantidad()]);
    }

    public function buscarCarrito(int $usuario_id): Carrito
    {
        $lineasCarritoArray = LineaCarritoBD::query()
            ->where('usuario_id', '=', $usuario_id)
            ->with(['producto','proveedor'])
            ->get();
        
        $lineasCarritoObj = LineaCarrito::fromArray($lineasCarritoArray->toArray());
        $bloqueado = DB::table('usuarios_bloqueados')->where('usuario_id', $usuario_id)->exists();
        
        return  new Carrito($usuario_id, $lineasCarritoObj, $bloqueado);
    }

    public function borrarLineaCarrito(int $linea_carrito_id): void
    {
        $linea_carrito = LineaCarritoBD::query()->findOrFail($linea_carrito_id);
        $linea_carrito->delete();
    }

    public function bloquear(int $usuarioId)
    {
        DB::table('usuarios_bloqueados')->insert([
            'usuario_id' => $usuarioId,
            'fecha' => now(),
        ]);
    }
}