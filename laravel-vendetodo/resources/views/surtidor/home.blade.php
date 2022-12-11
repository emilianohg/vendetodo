@extends('layouts.dashboard')
@section('style')
  <link rel="stylesheet" href="/css/surtidor-orden.css">
@endsection

@section('content')
    @if ($orden == null)
        @if ($preasignacionOrden == null)
            <h1>No tienes ordenes preasignadas</h1>
        @else
            <h1>Tienes una orden preasignada</h1>
            <div class="layout-inline move-right">
            <form method="POST" action="{{ route('surtidor.aceptarOrden') }}">
                @csrf
                <input type="hidden" name="orden_id" value="{{ $preasignacionOrden->getOrdenId() }}">
                <button type="submit" class="btn">Aceptar orden</button>
            </form>
            </div>
        @endif
    @else
        <h1>Tienes una orden activa</h1>
        <div class="layout-inline move-right">
            <a href="{{ route('surtidor.verRuta', ['id' => $orden->getOrdenId()]) }}">
                <button class="btn">Visualizar ruta</button>
            </a>
        </div>
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
    @endif
@endsection
