@extends('layouts.dashboard')

@section('content')
<h1>Orden</h1>

{{ $orden->getOrdenId() }}

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
                        <img src="{{ $detalle->getProducto()->getImagenUrl() }}" alt="{{ $detalle->getProducto()->getNombre() }}" class="frameImg">
                    </div>
                @endif
            </td>
            <td>{{ $detalle->getProducto()->getNombre() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection