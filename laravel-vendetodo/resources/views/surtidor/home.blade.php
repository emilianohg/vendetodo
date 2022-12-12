@extends('layouts.dashboard')
@section('style')
  <link rel="stylesheet" href="/css/surtidor-orden.css">
@endsection

@section('content')
    <div class="container">
    @if ($orden == null)
            @if ($preasignacionOrden == null)
                <h1>No tienes ordenes preasignadas</h1>
            @else
                <h1>Tienes una orden preasignada</h1>
                <div class="card">
                    <p>Folio: <span>#{{ $preasignacionOrden->getOrdenId() }}</span></p>
                    <p>Fecha asignación: <span>{{ $preasignacionOrden->getFecha() }}</span></p>
                    <div class="controls">
                        <form method="POST" action="{{ route('surtidor.aceptarOrden') }}">
                            @csrf
                            <input type="hidden" name="orden_id" value="{{ $preasignacionOrden->getOrdenId() }}">
                            <button type="submit" class="btn">Aceptar orden</button>
                        </form>
                    </div>
                </div>
            @endif
    @else
        <h1>Tienes una orden activa</h1>
        <div class="controls">
            <a href="{{ route('surtidor.verRuta', ['id' => $orden->getOrdenId()]) }}">
                <button class="btn">Visualizar ruta</button>
            </a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Cant</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orden->getDetalle() as $detalle)
                <tr>
                    <td>
                        {{ $detalle->getCantidad() }}
                    </td>
                    <td>
                        @if($detalle->getProducto()->getImagenUrl() == null)
                            <div class="card-image card-image-not-found"></div>
                        @else
                            <img class="col-img" src="{{ $detalle->getProducto()->getImagenUrl() }}" alt="{{ $detalle->getProducto()->getNombre() }}">
                        @endif
                    </td>
                    <td>
                        <b>{{ $detalle->getProducto()->getNombre() }}</b>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    </div>

@endsection
