<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="icon" href="../img/favicon.png">
  <link rel="stylesheet" href="../index/estiloindex.css">
  <link rel="stylesheet" href="./estiloscheckout.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NaniFoods</title>
</head>

<body>
 <header>
   <div class="logo">
    <a href="../index/index.php">
        <img src="../img/logo.png" alt="Logo" class="logo">
    </a>
</div>
    <div class="navegador">
      <ul>
        <li><a id="inicio" class="nav-items" href="../index/index.php">Inicio</a></li>
        <li><a class="nav-items" href="../productos/productos.php">Carta</a></li>
        <li><a class="nav-items" href="">Domicilios</a></li>
        <li><a class="nav-items" href="../reseñas/reseñas.php">Reseñas</a></li>
        <li><a class="nav-items" href="../acerca/acerca.php">Acerca de</a></li>
      </ul>
    </div>
    <div class="boton">
      <button class="vinculo" onclick="location.href='../login/login.php'"><img src="../img/testp.png" class="perfil"></button>
    </div>
  </header>

<body>
    <div class="checkout-container mt-5">
        <div class="checkout-header text-center mb-4">
            <h2>🛒 Confirmación 🛒 </h2>
            <p>Revisa tu carrito antes de confirmar tu pedido</p>
        </div>

        <div id="carrito-checkout"></div>

        <div class="total-section mt-4">
            <h4>Total: $<span id="total-carrito">0</span></h4>
        </div>

        <div class="d-grid gap-2 mt-4">
            <button class="btn btn-warning btn-lg" id="confirmar-pedido">Confirmar pedido</button>
        </div>
    </div>

  <footer>
    <div>
      <img src="../img/wsp.png" alt="" width="50px" height="50px">
      <img src="../img/fb.png" alt="" width="48px" height="48px">
    </div>
    <div class="flink">
      www.NaniFoods.com.co
    </div>
    <div>
      <img src="../img/logo.png" alt="" width="70px" height="70px">
    </div>
  </footer>

  <script src="./modalContent.js" type="module"></script>
  <script src="./addToCartComponent.js" type="module"></script>
  <script src="./productos.js" type="module"></script>
  <script src="./carrito.js" type="module"></script>
  <script src="./checkout.js" type="module"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>