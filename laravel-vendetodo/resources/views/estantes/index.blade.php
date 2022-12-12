@extends('layouts.dashboard')
@section('style')
  <link rel="stylesheet" href="/css/estante-dashboard.css">
@endsection

@section('content')
  <div class="rack-container">
    <h2 class="tittle">Estante {{$estante->getEstanteId()}}</h2>
    <h3 class="sub-tittle">Hola!, {{ auth()->user()->nombre }}</h3>
    <div class="controls">
      <form method="POST" action="{{ route('encargado.generarOrden', ['id' => $estante->getEstanteid()]) }}">
        @csrf
        <button class="btn btn-primary"><i class="fa-solid fa-list"></i> Ordenar</button>
      </form>
    </div>
    <div class="rack-details">
      @foreach($estante->getSecciones() as $seccion)
      <table class="tg">
        <tbody>
          <tr>
            <td class="tg-0pky" colspan="5">Seccion {{$seccion->getSeccionId()}}</td>
          </tr>
          <tr>
            <td class="tg-0pky" rowspan="{{count($seccion->getPaquetes())+2}}">
              @if($seccion->getProducto() == null || $seccion->getProducto()->getImagenUrl() == null)
              <div class="card-image card-image-not-found"></div>
              @else
              <img class="img-producto" src="{{ $seccion->getProducto()->getImagenUrl() }}" alt="{{ $seccion->getProducto()->getNombre() }}">
              @endif
            </td>
            <td class="tg-0pky">Nombre</td>
            <td class="tg-0pky">Cantidad</td>
            <td class="tg-0pky" colspan="2">Lotes</td>
          </tr>
          <tr>
            <td class="tg-0lax" rowspan="{{count($seccion->getPaquetes())+1}}">
              @if($seccion->getProducto() != null)
              {{ $seccion->getProducto()->getNombre() }}
              @else
                No existe producto
              @endif
            </td>
            <td class="tg-0lax" rowspan="{{count($seccion->getPaquetes())+1}}">{{ $seccion->getCantidadProductos() }}</td>
            <td class="tg-0lax">Cantidad</td>
            <td class="tg-0lax">Num. lotes</td>
          </tr>
            @foreach ($seccion->getPaquetes() as $paquete)
                <tr>
                  <td class="tg-0lax">{{$paquete->getCantidad()}}</td>
                  <td class="tg-0lax">{{$paquete->getLoteId()}}</td>
                </tr>
            @endforeach
          </tbody>
          @if($seccion->getProducto() != null)
          <tfoot>
            <tr>
              <td class="tg-0pky" colspan="5">Espacio disponible: {{$seccion->getCantidadProductosNecesarios()}} productos.</td>
            </tr>
          </tfoot>
          @endif
      </table>
      <br>
      @endforeach
    </div>
  </div>
@endsection