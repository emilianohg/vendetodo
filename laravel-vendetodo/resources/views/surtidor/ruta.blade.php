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
            <th></th>
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
            <td>
                @if($detalle->recogido())
                    Recogido
                @else
                <form
                    method="POST"
                    action="{{ route('surtidor.recogerProducto') }}"
                    data-lote="{{ $detalle->getPaqueteLote()->getLote()->getLoteId() }}"
                    onsubmit="return checkForm(this);"
                >
                    <input type="hidden" name="orden_id" value="{{ $ruta->getOrdenId() }}">
                    <input type="hidden" name="orden" value="{{ $detalle->getOrden() }}">
                    @csrf
                    <button type="submit" >+</button>
                </form>
                <script>
                    function checkForm(form) {
                        loteId = form.dataset.lote;
                        const value = prompt('Introduce el numero de lote para confirmar:');

                        if (value !== loteId) {
                            alert('El lote ingresado no coincide, asegurate que tomaste el artículo correcto');
                        }
                        return value === loteId;
                    }
                </script>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

    <div>
        <form method="POST" action="{{ route('surtidor.terminarSurtido') }}">
            <input type="hidden" name="orden_id" value="{{ $ruta->getOrdenId() }}">
            @csrf
            <button class="btn" type="submit">Terminar</button>
        </form>
    </div>

@endsection
