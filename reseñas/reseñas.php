<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../index/estiloindex.css">
    <link rel="stylesheet" href="estilosreseñas.css">
    <link rel="icon" href="../img/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NaniFoods
    </title>
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
    <section class="principal">

        <div class="filtros p-3">
            <form method="GET" action="reseñas.php">
                <input type="text" name="search" placeholder="Buscar..." class="form-control filtro mb-3"
                    value="<?= $_GET['search'] ?? '' ?>">

                <select name="orden" class="form-select mb-3">
                    <option value="">Más relevantes</option>
                    <option value="valoracion" <?= ($_GET['orden'] ?? '') == 'valoracion' ? 'selected' : '' ?>>Valoración</option>
                    <option value="recientes" <?= ($_GET['orden'] ?? '') == 'recientes' ? 'selected' : '' ?>>Recientes</option>
                </select>

                <select name="estrellas" class="form-select mb-3">
                    <option value="">Por estrellas</option>
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <option value="<?= $i ?>" <?= ($_GET['estrellas'] ?? '') == $i ? 'selected' : '' ?>><?= $i ?> ★</option>
                    <?php endfor; ?>
                </select>

                <select name="tipo" class="form-select mb-3">
                    <option value="">Tipo de reseña...</option>
                    <option value="productos" <?= ($_GET['tipo'] ?? '') == 'productos' ? 'selected' : '' ?>>Productos</option>
                    <option value="repartidores" <?= ($_GET['tipo'] ?? '') == 'repartidores' ? 'selected' : '' ?>>Repartidores</option>
                </select>

                <button type="submit" class="btn btn-warning w-100">Filtrar</button>
            </form>
        </div>


        <div class="reseñas p-4">

            <?php include "inforeseñas.php" ?>


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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>