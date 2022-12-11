<?php

namespace App\Http\Controllers;

use App\Domain\DominioOrden;
use App\Domain\DominioSurtidor;
use App\Domain\OrdenNoAsignadaException;
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

        return redirect()->route('surtidor.orden', ['id' => $ordenId]);
    }

    public function generarRuta(int $ordenId){
        $ruta = $this->dominioOrden->generarRuta($ordenId);
        return back();
    }

    public function verRuta(int $ordenId){
        $ruta = $this->dominioOrden->verRuta($ordenId);
        return view('surtidor.ruta', [
            'ruta' => $ruta,
        ]);
    }
}
