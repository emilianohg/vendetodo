@extends('layouts.dashboard')

@section('style')
  <link rel="stylesheet" href="/css/surtidor-orden.css">
@endsection

@section('content')
<h1>
    Ruta para la orden {{ $ruta->getOrdenId() }}
</h1>
<table>
    <thead>
        <tr>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Lote</th>
            <th>Ubicación</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ruta->getUbicaciones() as $detalle)
        <tr>
            <td>
                <div class="col-img">
                    <img class="col-img" src=
                    "{{ $detalle->getPaqueteLote()->getLote()->getProducto()->getImagenUrl() }}"
                    alt="{{  $detalle->getPaqueteLote()->getLote()->getProducto()->getNombre() }}">
                </div>
            </td>
            <td>{{ $detalle->getPaqueteLote()->getLote()->getProducto()->getNombre() }}</td>
            <td>{{ $detalle->getPaqueteLote()->getCantidad() }}</td>
            <td>{{ $detalle->getPaqueteLote()->getLote()->getLoteId() }}</td>
            <td>@if ($detalle->getPaqueteLote()->getEstanteId()!=null)
                    <p>Estante: {{ $detalle->getPaqueteLote()->getEstanteId() }}</p>
                    <p>Sección: {{ $detalle->getPaqueteLote()->getSeccionId() }}</p>
                @else
                    <p> En bodega </p>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
