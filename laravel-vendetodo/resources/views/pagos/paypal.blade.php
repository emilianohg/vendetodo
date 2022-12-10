<h1>PAYPAL</h1>
<h2>${{ number_format($pago->getImporte(), 2) }}</h2>
<h3>Status: {{ $pago->getStatus() }}</h3>
@if($pago->getStatus() == 'pendiente')
<form method="POST" action="{{ route('ventas.confirmarPago') }}">
    @csrf
    <input type="hidden" name="referencia" value="{{ $pago->getReferencia() }}">
    <button type="submit">Confirmar pago</button>
</form>
@endif