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
  <p>Folio de compra: <span>XXXXXXXXXXXXXXXXXX</span></p>
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
        <td>Girasoles #4213, Molino de Flores, Culiacán, Sinaloa</td>
        <td><i class="ri-paypal-fill"></i> ****9999</td>
        <td>
          <div class="amount-sale">
            <p>Subtotal: <span>$ 17,000.00</span></p>
            <p>Envío: <span>$ 0.00</span></p>
            <p>Total: <span>$ 17,000.00</span></p>
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
          <tr>
            <td><img src="https://assets.sams.com.mx/image/upload/f_auto,q_auto:eco,w_350,c_scale,dpr_auto/mx/images/product-images/img_medium/980023266m.jpg" alt=""></td>
            <td>
              <ul>
                <li>Xbox series X consola de videojuegos en alta definición.</li>
                <li class="price">$17,000</li>
                <li>Cantidad: 1</li>
                <li>Proveedor: Microsoft México</li>
              </ul>
            </td>
          </tr>
          <tr>
            <td><img src="https://assets.sams.com.mx/image/upload/f_auto,q_auto:eco,w_350,c_scale,dpr_auto/mx/images/product-images/img_medium/980023266m.jpg" alt=""></td>
            <td>
              <ul>
                <li>Xbox series X consola de videojuegos en alta definición.</li>
                <li class="price">$17,000</li>
                <li>Cantidad: 1</li>
                <li>Proveedor: Microsoft México</li>
              </ul>
            </td>
          </tr>
          <tr>
            <td><img src="https://assets.sams.com.mx/image/upload/f_auto,q_auto:eco,w_350,c_scale,dpr_auto/mx/images/product-images/img_medium/980023266m.jpg" alt=""></td>
            <td>
              <ul>
                <li>Xbox series X consola de videojuegos en alta definición.</li>
                <li class="price">$17,000</li>
                <li>Cantidad: 1</li>
                <li>Proveedor: Microsoft México</li>
              </ul>
            </td>
          </tr>
      </table>
      <div class="btn-container">
        <a class="btn-return" href="{{ route('products.index') }}">Regresar a tienda</a>
      </div>
</div>
@endsection