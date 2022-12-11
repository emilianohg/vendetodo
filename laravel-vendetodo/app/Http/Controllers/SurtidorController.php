<?php

namespace App\Http\Controllers;

use App\Domain\DominioOrden;
use App\Domain\DominioSurtidor;
use App\Domain\OrdenNoAsignadaException;
use App\Domain\ProductoSinRecogerException;
use App\Repositories\OrdenesRepository;
use Illuminate\Http\Request;

class SurtidorController extends Controller
{
    private DominioSurtidor $dominioSurtidor;
    private DominioOrden $dominioOrden;

    public function __construct()
    {
        $this->dominioSurtidor = new DominioSurtidor();
        $this->dominioOrden = new DominioOrden();
    }

    public function home() {
        $usuarioId = auth()->user()->getAuthIdentifier();

        $preasignacionOrden = $this->dominioSurtidor->obtenerOrdenPreasignada($usuarioId);

        $orden = $this->dominioSurtidor->obtenerOrdenActiva($usuarioId);

        \Log::info((array) $orden);

        return view('surtidor.home', [
            'preasignacionOrden' => $preasignacionOrden,
            'orden' => $orden,
        ]);
    }

    public function orden(int $ordenId) {
        $orden = $this->dominioOrden->obtenerOrden($ordenId);
        return view('surtidor.orden', ['orden' => $orden]);
    }

    public function aceptarOrden(Request $request) {
        $ordenId = $request->get('orden_id');
        $usuarioId = auth()->user()->getAuthIdentifier();

        try {
            $this->dominioOrden->aceptarOrden($usuarioId, $ordenId);
        } catch (OrdenNoAsignadaException $e) {
            return redirect()->back()->with('message-error', $e->getMessage());
        }

        return redirect()->route('surtidor.home');
    }

    public function verRuta(int $ordenId){
        $ruta = $this->dominioOrden->verRuta($ordenId);
        return view('surtidor.ruta', [
            'ruta' => $ruta,
        ]);
    }

    public function recogerProducto(Request $request)
    {
        $ordenId = $request->get('orden_id');
        $orden = $request->get('orden');
        $this->dominioOrden->recogerProducto($ordenId, $orden);
        return redirect()->route('surtidor.verRuta', ['id' => $ordenId]);
    }

    public function terminarSurtido(Request $request)
    {
        $ordenId = $request->get('orden_id');
        try {
            $orden = $this->dominioOrden->terminarSurtido($ordenId);
            return redirect()->route('surtidor.home')
                ->with('message-info', 'Terminaste exitosamente la orden #' . $orden->getOrdenId());
        } catch (ProductoSinRecogerException $e) {
            return redirect()->back()->with('message-error', $e->getMessage());
        }
    }
}
