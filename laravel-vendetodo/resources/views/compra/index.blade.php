<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vende Todo</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
  <link rel="stylesheet" href="/css/compra.css">
  <title>Document</title>
</head>
<body>
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
          <tr>
            <td>Playsataion 5</td>
            <td>Sony MX</td>
            <td>2</td>
            <td>$ 19,000 MXN</td>
          </tr>
          <tr>
            <td>Nintendo Switch</td>
            <td>Nintento MX</td>
            <td>1</td>
            <td>$ 10,000 MXN</td>
          </tr>
          <tr>
            <tfoot>
              <td colspan="3">Total</td>
              <td>$ 29,000 MXN</td>
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
                <input type="radio" name="address" class="radioBtn-address" value="1">
                <label for="">omnis qui harum,Prohaska Park, #1040, 88599, Ensenada, Tijuana</label>
              </div>
              <div class="options">
                <input type="radio" name="address" class="radioBtn-address" value="1">
                <label for="">Girasoles, Molino de Flores, #4213, 80155, Culiacán, Sinaloa</label>
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
</body>
</html>
