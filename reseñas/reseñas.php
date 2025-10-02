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
            <img src="../img/logo.png" alt="" class="logo">
        </div>
        <div class="navegador">
            <ul>
                <li><a id="inicio" class="nav-items" href="../index/index.php">Inicio</a></li>
                <li><a class="nav-items" href="../productos/productos.php">Carta</a></li>
                <li><a class="nav-items" href="">Descuentos</a></li>
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

        <div class="filtros p-3">
            <form method="GET" action="reseñas.php">
                <input type="text" name="search" placeholder="Buscar..." class="form-control filtro mb-3"
                    value="<?= $_GET['search'] ?? '' ?>">

                <select name="orden" class="form-select mb-3">
                    <option value="">Más relevantes</option>
                    <option value="valoracion" <?= ($_GET['orden']??'')=='valoracion'?'selected':'' ?>>Valoración</option>
                    <option value="recientes" <?= ($_GET['orden']??'')=='recientes'?'selected':'' ?>>Recientes</option>
                </select>

                <select name="estrellas" class="form-select mb-3">
                    <option value="">Por estrellas</option>
                    <?php for($i=5;$i>=1;$i--): ?>
                        <option value="<?= $i ?>" <?= ($_GET['estrellas']??'')==$i?'selected':'' ?>><?= $i ?> ★</option>
                    <?php endfor; ?>
                </select>

                <select name="tipo" class="form-select mb-3">
                    <option value="">Tipo de reseña...</option>
                    <option value="productos" <?= ($_GET['tipo']??'')=='productos'?'selected':'' ?>>Productos</option>
                    <option value="repartidores" <?= ($_GET['tipo']??'')=='repartidores'?'selected':'' ?>>Repartidores</option>
                </select>

                <button type="submit" class="btn btn-warning w-100">Filtrar</button>
            </form>
            <br>

            <button type="button" class="boton_reseña" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Deja tu reseña 
</button>


<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
<div class="modal-body">
  <form action="guardar_reseña.php" method="POST">
<?php
session_start();

if (!isset($_SESSION['id_cliente'])) {
    echo "<p class='text-danger'>Debes iniciar sesión para dejar una reseña.</p>";
} else {
    $conn = new mysqli("localhost", "root", "", "nanifoods");
    $id_cliente = $_SESSION['id_cliente'];

    $sql = "
        SELECT dp.id AS id_detalle, p.nombre AS producto, r.nombre AS repartidor
        FROM detalles_pedidos dp
        LEFT JOIN productos p ON dp.id_producto = p.codigo
        LEFT JOIN pedidos pe ON dp.id_pedido = pe.id
        LEFT JOIN repartidores r ON pe.id_repartidor = r.id
        WHERE pe.id_cliente = $id_cliente
    ";

    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        echo '<select class="form-select" name="id_detalles_pedido" required>';
        while ($fila = $resultado->fetch_assoc()) {
            if (!empty($fila['producto'])) {
                echo "<option value='{$fila['id_detalle']}'>Producto: {$fila['producto']}</option>";
            } elseif (!empty($fila['repartidor'])) {
                echo "<option value='{$fila['id_detalle']}'>Repartidor: {$fila['repartidor']}</option>";
            }
        }
        echo '</select>';
    } else {
        echo "<p class='text-warning'>No tienes pedidos para reseñar.</p>";
    }

    $conn->close();
}
?>


    <input class="form-control" type="text" name="nombres" placeholder="Nombres completos" required><br>

        <select class="form-select" name="estrellas" required>
      <option value="" disabled selected>Estrellas</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
    </select>
    <br>

    <div class="form-floating">
      <textarea class="form-control" id="floatingTextarea2" name="resena" placeholder="Descripción de la reseña" style="height: 100px" required></textarea>
      <label for="floatingTextarea2">Descripción de la reseña</label>
    </div> <br>

</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
  <button type="submit" class="btn btn-primary">Enviar reseña</button>
</div>
  </form>
    </div>
  </div>
</div>

        </div>



        <div class="reseñas p-4">
         
 <?php include "inforeseñas.php"?>
        

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
