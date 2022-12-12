@extends('layouts.dashboard')
@section('style')
  <link rel="stylesheet" href="/css/reporte.css">
@endsection
@section('content')
  <div class="report-container">
    <div class="head-report">
      <h2 class="tittle">Reporte de orden del estante #{{$reporte->getEstanteId()}}</h2>
      <h4 class="result">Fecha de generación: {{ $reporte->getFecha() }}</h4>
      @if ($reporte->estaComenzado() == 1)
        <h4 class="result">Estado: <span class="estado">En proceso</span></h4>
      @else
        <h4 class="result">Estado: <span class="estado">Pendiente</span></h4>           
      @endif
      <button></button>
    </div>

    <div class="controls">
      <a class="btn" href="{{ route('encargado-estante.home') }}"><i class="fa-solid fa-arrow-left"></i> Regresar</a>
      @if (!$reporte->estaComenzado())
        <form method="POST" action="{{ route('encargado.comenzar') }}">
          @csrf
          <button class="btn btn-primary" id="btnComenzar"><i class="fa-solid fa-play"></i> Comenzar</button>
        </form>
      @else
        <form method="POST" action="{{ route('encargado.terminar') }}" >
          @csrf
          <button class="btn btn-primary" id="btnTerminar"><i class="fa-solid fa-check"></i> Terminar</button>
        </form>
        <form method="POST" action="{{ route('encargado.cancelar') }}">
          @csrf
          <button class="btn" id="btnCancelar"><i class="fa-solid fa-xmark"></i> Cancelar</button>
        </form>
      @endif
    </div>

    <div class="report-details">

      @foreach($reporte->getDetalles() as $detalle)
      
      <table class="tg">
        <thead>
          <tr>
            <th class="tg-0pky" colspan="6">Seccion {{$detalle->getSeccionId()}}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="tg-0lax">Imagen</td>
            <td class="tg-0lax">Producto</td>
            <td class="tg-0lax">Cantidad</td>
            <td class="tg-0lax" colspan="3">Surtido de productos</td>
          </tr>
          <tr>
            <td class="tg-0lax" rowspan="{{count($detalle->getPaquetes())+2}}">
              <img class="img-producto" src="{{$detalle->getProducto()->getImagenUrl()}}" alt="">
            </td>
            <td class="tg-0lax" rowspan="{{count($detalle->getPaquetes())+2}}">{{$detalle->getProducto()->getNombre()}}</td>
            <td class="tg-0lax" rowspan="{{count($detalle->getPaquetes())+2}}">{{$detalle->getCantidadProductos()}}</td>
            <td class="tg-0lax">Cantidad</td>
            <td class="tg-0lax">Num. de Lote</td>
            <td class="tg-0lax">Ubicación</td>
          </tr>
          @foreach($detalle->getPaquetes() as $paquete)
            @if($paquete->getEstanteId()==null)
            <tr>
              <td class="tg-0lax">{{$paquete->getCantidad()}}</td>
              <td class="tg-0lax">{{$paquete->getLote()->getLoteId()}}</td>
              <td class="tg-0lax">Bodega</td>
            </tr>
            @else
            <tr>
              <td class="tg-0lax">{{$paquete->getCantidad()}}</td>
              <td class="tg-0lax">{{$paquete->getLote()->getLoteId()}}</td>
              <td class="tg-0lax">Estante: {{$paquete->getEstanteId()}} | Seccion: {{$paquete->getSeccionid()}}</td>
            @endif
          @endforeach

        </tbody>
      </table>
      <div class="divider"></div>
      @endforeach
    </div>
  </div>
@endsection