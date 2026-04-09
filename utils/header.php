<?php

function showheader()
{


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="icon" href="../img/favicon.png">
        <link rel="stylesheet" href="../index/estiloindex.css">
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
                    <?php
                    if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
                    ?>
                        <li><a id='inicio' class='nav-items' href='../index/index.php'>Inicio</a></li>
                        <li><a class='nav-items' href='../productos/productos.php'>Carta</a></li>
                        <li><a class='nav-items' href='../domicilios/domicilios.php'>Domicilios</a></li>
                        <li><a class='nav-items' href='../reseñas/reseñas.php'>Reseñas</a></li>
                        <li><a class='nav-items' href='../acerca/acerca.php'>Acerca de</a></li>
                    <?php
                    } elseif ($_SESSION["rol"] === "admin") {
                    ?>

                        <li><a class='nav-items' href='../panel/panel.php'>panel</a></li>
                        <li><a class='nav-items' href='../productos/productos.php'>productos</a></li>
                        <li><a class='nav-items' href='../reportes/reportes.php'>reportes</a></li>
                        <li><a class='nav-items' href='../crud/productos.php'>CRUDs</a></li>
                        <li><a class='nav-items' href='../reseñas/reseñas.php'>reseñas</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <?php
            if (!isset($_SESSION["rol"])) {
                echo
                "<div class='boton'>
                    <button class='vinculo' onclick=\"location.href='../login/login.php'\">
                        <img src='../img/testp.png' class='perfil'>
                    </button>
                </div>";
            } else {
                echo
                "<div class='boton'>
                    <a class='vinculo nav-items' href='../logout.php'>cerrar session</a>
                </div>";
            }
            ?>
        </header>
    <?php
}
    ?>