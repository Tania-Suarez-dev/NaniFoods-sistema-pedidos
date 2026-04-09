<?php
session_start();
require_once("../utils/header.php");
require_once("../utils/footer.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NaniFoods - Confirmación</title>


  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" href="../img/favicon.png">
  <link rel="stylesheet" href="../index/estiloindex.css">
  <link rel="stylesheet" href="./estiloscheckout.css">
</head>

<body style="background-color: var(--color5); min-height: 100vh;">

  <?php showheader(); ?>

  <main class="container py-5 mt-5">
    <div class="checkout-container bg-white text-dark p-4 rounded-4 shadow-lg">
      <div class="checkout-header text-center mb-4">
        <h2 class="text-dark fw-bold">🛒 Confirmación 🛒</h2>
        <p class="text-secondary">Revisa tu carrito antes de confirmar tu pedido</p>
      </div>

      <div id="carrito-checkout" class="mb-4"></div>

 
      <div class="total-section text-center mb-4">
        <h4 class="fw-bold">Total: $<span id="total-carrito">0</span></h4>
      </div>


      <div class="d-grid gap-3">

        <label for="direccion" class="form-label fw-bold text-center text-dark">📍 Dirección de entrega</label>
        <input type="text" id="direccion" class="form-control form-control-lg" placeholder="Ejemplo: Calle 10 #45-32, Bogotá">
        <div class="form-text text-center mb-2 text-secondary">
          Incluye barrio, número de casa o apartamento si aplica.
        </div>

        <label for="metodo-pago" class="form-label fw-bold text-center text-dark mt-3">💳 Método de pago</label>
        <select id="metodo-pago" class="form-select form-select-lg mb-2">
          <option value="">Seleccione...</option>
          <option value="efectivo">Efectivo</option>
          <option value="tarjeta">Tarjeta</option>
          <option value="transferencia">Transferencia</option>
        </select>

        <label for="observaciones" class="form-label fw-bold text-center text-dark mt-3">📝 Observaciones / especificaciones</label>
        <textarea id="observaciones" class="form-control" rows="3" placeholder="Instrucciones adicionales para tu pedido"></textarea>

        <div class="d-grid mt-4">
          <button class="btn btn-warning btn-lg fw-bold" id="confirmar-pedido">
            Confirmar pedido
          </button>
        </div>
      </div>
    </div>
  </main>

  <?php showfooter(); ?>

  <script src="./modalContent.js" type="module"></script>
  <script src="./addToCartComponent.js" type="module"></script>
  <script src="./productos.js" type="module"></script>
  <script src="./carrito.js" type="module"></script>
  <script src="./checkout.js" type="module"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
