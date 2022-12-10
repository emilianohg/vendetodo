@extends('layouts.dashboard')
@section('style')
  <link rel="stylesheet" href="/css/surtidor-orden.css">
@endsection
@section('content')
<p>
    Orden {{ $orden->getOrdenId() }}
</p>
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
                        <img class="col-img" src="{{ $detalle->getProducto()->getImagenUrl() }}"
                        alt="{{ $detalle->getProducto()->getNombre() }}" >
                    </div>
                @endif
            </td>
            <td>{{ $detalle->getProducto()->getNombre() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
