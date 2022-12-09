@extends('layouts.dashboard')
@section('style')
  <link rel="stylesheet" href="/css/estante-dashboard.css">
@endsection

@section('content')
    <div class="sidenav">
      <form >
        <a class="sidevar-option" href="{{ route('encargado.obtenerOrden',['id' => $estante->getEstanteid()]) }}">Ordenar</i></a>
      </form>
        <a class="sidevar-option" href="{{ route('products.index') }}">Tienda</i></a>
    </div>
  <div class="rack-container">
    <h2 class="tittle">Encargado de estante</h2>
    <h3 class="sub-tittle">Hola!, {{ auth()->user()->nombre }}</h3>
    <div class="rack-details">
      @foreach($estante->getSecciones() as $seccion)
      <table class="tg">
        <thead>
          <tr>
            <th class="tg-0pky" colspan="5">Estante {{$estante->getEstanteId()}}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="tg-0pky" colspan="5">Seccion {{$seccion->getSeccionId()}}</td>
          </tr>
          <tr>
            <td class="tg-0pky" rowspan="{{count($seccion->getPaquetes())+2}}">
              @if($seccion->getProducto()->getImagenUrl() == null)
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
            <td class="tg-0lax" rowspan="{{count($seccion->getPaquetes())+1}}">{{ $seccion->getProducto()->getNombre() }}</td>
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
          <tfoot>
            <tr>
              <td class="tg-0pky" colspan="5">Espacio disponible: {{$seccion->getCantidadProductosNecesarios()}} productos.</td>
            </tr>
          </tfoot>   
        </tbody>
      </table>
      <br>
      @endforeach
    </div>
  </div>
@endsection