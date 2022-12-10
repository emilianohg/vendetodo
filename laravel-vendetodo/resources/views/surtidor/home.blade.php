@extends('layouts.dashboard')
@section('style')
  <link rel="stylesheet" href="/css/surtidor-orden.css">
@endsection

@section('content')
    @if ($preasignacionOrden == null)
        <h1>No tienes ordenes preasignadas</h1>
    @else
        <h1>Tienes ordenes preasignadas</h1>
        <div class="layout-inline move-right">
            <a href="{{ route('surtidor.orden', ['id' => $preasignacionOrden->getOrdenId()]) }}">
                <button class="btn">Revisar detalle de la orden</button>
            </a>
        <form method="POST" action="{{ route('surtidor.aceptarOrden') }}">
            @csrf
            <input type="hidden" name="orden_id" value="{{ $preasignacionOrden->getOrdenId() }}">
            <button type="submit" class="btn">Aceptar orden</button>
        </form>
        </div>
    @endif

    @if ($orden != null)
        <h1>Tienes una orden activa</h1>
        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orden->getDetalle() as $detalle)
                <tr>
                    <td>
                        @if($detalle->getProducto()->getImagenUrl() == null)
                            <div class="card-image card-image-not-found"></div>
                        @else
                            <div class="col-img">
                                <img class="col-img" src="{{ $detalle->getProducto()->getImagenUrl() }}" alt="{{ $detalle->getProducto()->getNombre() }}">
                            </div>
                        @endif
                    </td>
                    <td>{{ $detalle->getProducto()->getNombre() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    <div class="layout-inline move-right">
        <a href="{{ route('surtidor.generarRuta', ['id' => $orden->getOrdenId()]) }}">
            <button class="btn">Generar ruta</button>
        </a>
        <a href="{{ route('surtidor.verRuta', ['id' => $orden->getOrdenId()]) }}">
            <button class="btn">Visualizar ruta</button>
        </a>
    </div>
    @endif
@endsection
