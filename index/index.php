<?php
session_start()
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="../img/favicon.png">
    <link rel="stylesheet" href="./estiloindex.css">
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
    <section class="principal">
        <div class="slider">

            <button id="sliderIzquierda" class="slide">
                <i class='bx bx-chevron-left flecha'></i>
            </button>
            <div class="sliderInterno">
                <img src="../img/test1.2.jpg" alt="">
                <img src="../img/test2.jpg" alt="">
                <img src="../img/test3.jpg" alt="">
            </div>
            <button id="sliderDerecha" class="slide">
                <i class='bx bx-chevron-right flecha'></i>
            </button>
        </div>
    </section>
    <footer>
        <div>
            <img src="../img/wsp.png" alt="" width="50px" height="50px">
            <img src="../img/fb.png" alt="" width="48px" height="48px">
        </div>
        <div class="flink">
            www.naniFoods.com.co
        </div>
        <div>
            <img src="../img/logo.png" alt="" width="70px" height="70px">
        </div>
    </footer>

    <script src="./indexjs.js"></script>
</body>

</html>