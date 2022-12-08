@extends('layouts.app')
@section('content')
    <form action="">
        <button type="submit">Obtener Ordenamiento</button>
    </form>
    <hr>
    <div class="estantes-content">
        <div class="estante">
            <div>Estante 1</div>
            @foreach($estante->getSecciones() as $seccion)
                <div>Seccion {{ $seccion->getSeccionId() }}</div>
                <div class="info-seccion">
                    <div class="content-image">
                        @if($seccion->getProducto()->getImagenUrl() == null)
                            <div class="card-image card-image-not-found"></div>
                        @else
                            <div class="card-image">
                                <img
                                    src="{{ $seccion->getProducto()->getImagenUrl() }}"
                                    alt="{{ $seccion->getProducto()->getNombre() }}"
                                >
                            </div>
                        @endif
                    </div>
                    <div class="table-info">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Cantidad</td>
                                    <td>Lotes</td>
                                </tr>
                                <tr>
                                    <td>{{ $seccion->getProducto()->getNombre() }}</td>
                                    <td>20</td>
                                    <td>20</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection