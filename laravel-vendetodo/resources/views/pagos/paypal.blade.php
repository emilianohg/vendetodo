@extends('layouts.payment')
@section('style')
  <link rel="stylesheet" href="/css/paypal.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
@endsection
@section('content')
  <div class="paypal-container">
    <div class="logo-container">
      <h1 class="tittle"><i class="uil uil-paypal"></i>Pay<span>Pal</span></h1>
    </div>
    <hr class="divider">
    <div class="payment-details-container">
      <div class="payment-id-container">
        <h2 class="sub-tittle">Folio:</h2>
        <h2 class="result">{{ $pago->getPagoId() }}</h2>
      </div>
      <div class="payment-reference-container">
        <h2 class="sub-tittle">Referencia:</h2>
        <h2 class="result">{{ $pago->getReferencia() }}</h2>
      </div>
      <div class="payment-amount-container">
        <h2 class="sub-tittle">Importe:</h2>
        <h2 class="result">${{ number_format($pago->getImporte(), 2) }}</h2>
      </div>
      <div class="payment-date-container">
        <h2 class="sub-tittle">Fecha:</h2>
        <h2 class="result">{{ $pago->getFechaSolicitud() }}</h2>
      </div>
      <hr>
      @if($pago->getStatus() == 'pendiente')
      <form method="POST" action="{{ route('ventas.confirmarPago') }}">
          @csrf
          <input type="hidden" name="referencia" value="{{ $pago->getReferencia() }}">
          <button class="btn-confirm" type="submit">Confirmar pago</button>
      </form>
    </div>
  </div>
@endif    
@endsection