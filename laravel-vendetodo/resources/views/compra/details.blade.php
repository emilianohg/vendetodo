@extends('layouts.dashboard')
@section('style')
  <link rel="stylesheet" href="/css/compra-detalle.css">
@endsection

@section('content')
  <div class="order-container">
      <div class="tittle-container">
        <h2 class="order-tittle">Detalle de la compra </h2>
      </div>
      <div class="order-details-container">
        <table>
          <tr>
            <th>Producto</th>
            <th>Provedor</th>
            <th>Cantidad</th>
            <th>Precio</th>
          </tr>
          @foreach($carrito?->getLineasCarrito() as $lineaCarrito) 
          <tr>
            <td>{{$lineaCarrito->getProducto()->getNombre()}}</td>
            <td>{{$lineaCarrito->getProveedor()->getNombre()}}</td>
            <td>{{$lineaCarrito->getCantidad()}}</td>
            <td>{{number_format($lineaCarrito->getSubtotal(),2)}}</td>
          </tr>
          @endforeach
            <tfoot>
                <tr>
                  <td colspan="3">Total</td>
                  <td>{{$carrito->getTotal()}}</td>
                </tr>
            </tfoot>
        </table>
      </div>
      <form action="{{ route('ventas.realizar') }}" method="post">
        @csrf
        <div class="address-container">
          <div class="subtittle-tittle-container">
            <h2 class="sub-tittle">Dirección de envío</h2>
          </div>
          <div class="address-details-container" class="form-address">
              @foreach($usuario->getDirecciones() as $direccion)
              <div class="address-options">
                <div class="options">
                  <input
                    type="radio"
                    name="direccion_id"
                    class="radioBtn-address"
                    id="direccion-{{$direccion->getDireccionId()}}"
                    value="{{$direccion->getDireccionId()}}"
                    @if ($direccion->getDireccionId() == $usuario->getDireccion()->getDireccionId())
                      checked
                    @endif
                  >
                  <label for="direccion-{{$direccion->getDireccionId()}}">
                    C. {{ $direccion->getCalle() }} # {{ $direccion->getNumeroExt() }}
                    COL. {{ $direccion->getColonia() }} C.P. {{ $direccion->getCodigoPostal() }}
                    {{ $direccion->getMunicipio() }}, {{ $direccion->getEstado() }}.
                  </label>
                </div>
              </div>
              @endforeach
          </div>
        </div>
        <div class="payment-container">
          <div class="subtittle-tittle-container">
            <h2 class="subtittle-tittle">Método de pago</h2>
          </div>
          <div class="payment-details-container" class="form-payment">
              <div class="payment-options">
                @foreach($metodos_pago as $metodo_pago)
                <div class="options">
                  <input
                    type="radio"
                    name="metodo_pago_id"
                    class="radioBtn-payment"
                    value="{{$metodo_pago->getMetodoPagoId()}}"
                    @if($usuario->getMetodoPago()->getMetodoPagoId()) checked @endif
                  >
                  <label for="">{{$metodo_pago->getNombre()}}</label>
                </div>
                @endforeach
              </div>
          </div>
          <div class="btn-container">
            <input type="submit" value="Confirmar compra" class="btnSubmit">
          </div>
        </div>
      </form>
    </div>
@endsection