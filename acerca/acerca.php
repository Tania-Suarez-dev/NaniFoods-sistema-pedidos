<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="../img/favicon.png">
    <link rel="stylesheet" href="../index/estiloindex.css">
    <link rel="stylesheet" href="estilosAcerca.css">
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
                    echo
                    "<li><a id='inicio' class='nav-items' href='../index/index.php'>Inicio</a></li>
                <li><a class='nav-items' href='../productos/productos.php'>Carta</a></li>
                <li><a class='nav-items' href=''>Domicilios</a></li>
                <li><a class='nav-items' href='../reseñas/reseñas.php'>Reseñas</a></li>
                <li><a class='nav-items' href='../acerca/acerca.php'>Acerca de</a></li>";
                } elseif ($_SESSION["rol"] === "admin") {
                    echo
                    "<li><a id='inicio' class='nav-items' href='../index/index.php'>panel</a></li>
                <li><a class='nav-items' href='../productos/productos.php'>productos</a></li>
                <li><a class='nav-items' href=' '>reportes</a></li>
                <li><a class='nav-items' href='../acerca/acerca.php'>CRUDs</a></li>
                <li><a class='nav-items' href='../reseñas/reseñas.php'>reseñas</a></li>";
                };
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
                    <a class='vinculo nav-items' href='../login/login.php'>cerrar session</a>
                </div>";
        }
        ?>
    </header>
    <section class="principalAcerca">
        <div class="card" style="width: 18rem;">
            <img src="../img/uno.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Brayan Reyes</h5>
                <p class="card-text">Líder estratégico con experiencia en gestión empresarial y toma de decisiones. Apasionado por la innovación y el crecimiento.</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">director ejecutivo</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">Contacto</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="../img/uno.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Hamilton Soriano</h5>
                <p class="card-text">Apasionado por transformar ideas en experiencias impactantes mediante la combinación de arte, tecnología y estrategia</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">director tecnico de creatividad (señor pereza)</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">Contacto</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="../img/uno.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Tania Suarez</h5>
                <p class="card-text">Liderando la planificación y ejecución estratégica para el crecimiento y desarrollo eficiente de la empresa</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">jefe de operaciones de desarrollo</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">Contacto</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="../img/uno.jpg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Laura Escarraga</h5>
                <p class="card-text">Comprometida con la excelencia visual y la innovación para fortalecer la identidad y presencia de la empresa</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">directora de diseño grafico (señora no viene)</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">Contacto</a>
            </div>
        </div>
    </section>
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
</body>

</html>