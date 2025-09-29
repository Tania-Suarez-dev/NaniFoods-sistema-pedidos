<?php
session_start();
$host = "localhost";
$usuario = "root";
$bd = "nanifoods";
$conexion = new mysqli("$host", "$usuario", "", "$bd");
$categoria = "select distinct categoria from productos where 1=1";
$resultadocategoria = $conexion->query($categoria) or die("Error en la consulta: " . $conexion->error);
$precio = "select min(precio) AS precio_min, max(precio) AS precio_max FROM productos";
$resultadoprecio = $conexion->query($precio) or die("Error en la consulta: " . $conexion->error);
$filaprecio = $resultadoprecio->fetch_assoc()
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
  <link rel="stylesheet" href="./estilosproductos.css">
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
  <section class="principalcarta">
    <div class="filtros p-3">
      <form method="GET" action="productos.php">
        <input type="text" name="search" placeholder="Buscar..." class="form-control filtro mb-3"
          value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
        <select name="categoria" class="form-select mb-3">
          <option value="">Más relevantes</option>
          <?php if ($resultadocategoria && $resultadocategoria->num_rows > 0) {
            while ($filacategoria = $resultadocategoria->fetch_assoc()) {
              echo '<option value="' . $filacategoria['categoria'] . '">' . $filacategoria['categoria'] . '</option>';
            }
          } else {
            echo "<p class='text-light'>No hay categorias encontradas</p>";
          } ?>
        </select>

        <div class="row mb-3">
          <div class=" form-control form-check form-switch">
            <input class="form-check-input" type="checkbox" name="ofertas" role="switch" id="flexSwitchCheckChecked" checked>
            <label class="form-check-label" for="flexSwitchCheckChecked">ver ofertas</label>
          </div>
        </div>
        <select name="estrellas" class="form-select mb-3">
          <option value="">Por estrellas</option>
          <?php for ($i = 5; $i >= 1; $i--): ?>
            <option value="<?= $i ?>" <?= (isset($_GET['estrellas']) ? $_GET['estrellas'] : '') == $i ? 'selected' : '' ?>><?= $i ?> ★</option>
          <?php endfor; ?>
        </select>

        <div class="row mb-3">
          <div class="col">
            <input type="number" name="precio_min" class="form-control" placeholder="<?= $filaprecio["precio_min"] ?>">
          </div>
          <div class="col">
            <input type="number" name="precio_max" class="form-control" placeholder="<?= $filaprecio["precio_max"] ?>">
          </div>
        </div>
        <button type="submit" class="btn btn-warning w-100">Filtrar</button>
      </form>
    </div>

    <div class="productos">
      <div class="row justify-content-center" id="productos"></div>

      <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" id="modal-dialog"></div>
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

  <script type="module" src="./productos.js"></script>
  <script src="./modalContent.js" type="module"></script>
  <script src="./addToCartComponent.js" type="module"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>