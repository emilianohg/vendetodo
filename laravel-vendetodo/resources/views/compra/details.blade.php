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
              <td colspan="3">Total</td>
              <td>{{$carrito->getTotal()}}</td>
          </tr>
        </table>
      </div>
      <form action="" method="post">
             <div class="address-container">
        <div class="subtittle-tittle-container">
          <h2 class="sub-tittle">Dirección de envío</h2>
        </div>
        <div class="address-details-container" class="form-address">
          <form action="" method="post" target="">
            <div class="address-options">
              <div class="options">
                <input type="radio" name="address" class="radioBtn-address" value="{{ $usuario->getDireccion()->getDireccionId()}} ">
                <label for="">{{ $usuario->getDireccion()->getColonia() }}</label>
              </div>                  
            </div>
          </form>
        </div>
      </div>
      <div class="payment-container">
        <div class="subtittle-tittle-container">
          <h2 class="subtittle-tittle">Método de pago</h2>
        </div>
        <div class="payment-details-container" class="form-payment">
            <div class="payment-options">
              <div class="options">
                <input type="radio" name="payment" class="radioBtn-payment" value="1">
                <label for="">Tarjeta de crédito / debito</label>
              </div>
              <div class="options">
                <input type="radio" name="payment" class="radioBtn-payment" value="1">
                <label for="">Paypal</label>
              </div>
            </div>
        </div>
        <div class="btn-container">
          <input type="submit" value="Confirmar compra" class="btnSubmit">
        </div>
      </form>
    </div>
@endsection