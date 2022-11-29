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

    public function actualizarLineaCarrito(int $usuario_id, LineaCarrito $lineaCarrito): void
    {
        
        LineaCarritoBD::where('linea_carrito_id', '=', $lineaCarrito->getId())
        ->update(['cantidad'=>$lineaCarrito->getCantidad()]);
        
    }

    public function buscarCarrito(int $usuario_id): Carrito
    {
        $lineasCarritoArray = LineaCarritoBD::query()
            ->where('usuario_id','=',$usuario_id)
            ->get();
        foreach ($lineasCarritoArray as $linea)
        {
            echo "<script>console.log('Console: " . $linea . "' );</script>";
        }
        
        $lineasCarritoObj = LineaCarrito::fromArray($lineasCarritoArray->toArray());
        $bloqueado = DB::table('usuarios_bloqueados')->where('usuario_id', $usuario_id)->exists();
        
        return  new Carrito($usuario_id, $lineasCarritoObj,$bloqueado);
    }
}