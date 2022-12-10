@extends('layouts.dashboard')
@section('style')
<link rel="stylesheet" href="/css/compra-success.css">
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endsection

@section('content')
<div class="divider"></div>
<div class="tittle-container">
  <h2 class="tittle">Compra satisfactoria.</h2>
</div>
<h4>Detalle de la compra:</h4>
<div class="sale-head-container">
  <p>Folio de compra: <span>{{ $orden->getOrdenId() }}</span></p>
</div>
<div class="sale-container">
  <table class="sale-table">
    <thead>
      <tr>
        <th>Dirección de envío:</th>
        <th>Método de pago:</th>
        <th>Resumen de compra:</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          C. {{ $orden->getDireccion()->getCalle() }} # {{ $orden->getDireccion()->getNumeroExt() }}
          COL. {{ $orden->getDireccion()->getColonia() }} C.P. {{ $orden->getDireccion()->getCodigoPostal() }}
          {{ $orden->getDireccion()->getMunicipio() }}, {{ $orden->getDireccion()->getEstado() }}.
        </td>
        <td>
          @if($orden->getPago()->getMetodoPagoId() == 1)
            <i class="ri-paypal-fill"></i>
          @else
            <i class="ri-bank-card-2-fill"></i>
          @endif
          <span>**** 9999</span>
        </td>
        <td>
          <div class="amount-sale">
            <p>Subtotal: <span>${{ number_format($orden->getTotal(), 2) }}</span></p>
            <p>Envío: <span>$ 0.00</span></p>
            <p>Total: <span>${{ number_format($orden->getTotal(), 2) }}</span></p>
          </div>
        </td>
      </tr>
      <table class="sale-table">
        <thead>
          <tr>
            <th>Producto:</th>
            <th>Descripción:</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orden->getDetalle() as $detalle)
          <tr>
            <td>
              <img src="{{ $detalle->getProducto()->getImagenUrl() }}" alt="{{ $detalle->getProducto()->getNombre() }}">
            </td>
            <td>
              <ul>
                <li>{{ $detalle->getProducto()->getNombre() }}</li>
                <li class="price">${{ number_format($detalle->getProducto()->getPrecio(), 2) }}</li>
                <li>Cantidad: {{ $detalle->getCantidad() }}</li>
                <li>Proveedor: {{ $detalle->getProducto()->getMarca()->getNombre() }}</li>
              </ul>
            </td>
          </tr>
          @endforeach
      </table>
      <div class="btn-container">
        <a class="btn-return" href="{{ route('products.index') }}">Regresar a tienda</a>
      </div>
</div>
@endsection