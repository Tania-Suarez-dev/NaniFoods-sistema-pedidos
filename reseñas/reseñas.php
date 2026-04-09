<?php
session_start();
require("../utils/utils.php");
require_once("../utils/header.php");
require_once("../utils/footer.php");
?>
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
    <?php
    showheader();
    ?>

    <section class="principalResena">

        <div class="filtros p-3 pt-5">
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
            <br>

            <button type="button" class="btn btn-warning w-100 mb-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Deja tu reseña del pedido
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

                                if (!isset($_SESSION['id'])) {
                                    echo "<p class='text-danger'>Debes iniciar sesión para dejar una reseña.</p>";
                                } else {
                                    $conn = new mysqli("localhost", "root", "", "nanifoods");
                                    $id_cliente = $_SESSION['id'];
                                    $sql = "
                                        SELECT 
                                            pe.id AS id_pedido,
                                            pe.fecha AS fecha,
                                            GROUP_CONCAT(p.nombre SEPARATOR ', ') AS productos
                                        FROM pedidos pe
                                        JOIN detalles_pedidos dp ON pe.id = dp.id_pedido
                                        JOIN productos p ON dp.id_producto = p.codigo
                                        WHERE pe.id_cliente = $id_cliente
                                        GROUP BY pe.id, pe.fecha
                                        ORDER BY pe.fecha DESC
                                        ";

                                    $resultado = $conn->query($sql);

                                    if ($resultado->num_rows <= 0) {
                                        echo "<p class='text-warning'>No tienes pedidos para reseñar.</p>";
                                    }

                                    $conn->close();
                                }
                                ?>


                                <input class="form-control" type="text" name="nombres" placeholder="Nombres completos" required><br>

                                <select class="form-select" name="pedido" required>
                                    <option value="" disabled selected>Pedido</option>
                                    <?php
                                    foreach ($resultado as $producto) {
                                        echo "<option value='{$producto['id_pedido']}'>Fecha del pedido: " . formatDateTime($producto['fecha']) . ", con Productos: {$producto['productos']}</option>";
                                    }
                                    ?>
                                </select>

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
                            <button type="submit" class="btn btn-primary" name="tipo" value="pedido">Enviar reseña</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>



            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#staticBackdrop_producto">
                Deja tu reseña del producto
            </button>

            <div class="modal fade" id="staticBackdrop_producto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="guardar_reseña.php" method="POST">
                                <?php

                                if (!isset($_SESSION['id'])) {
                                    echo "<p class='text-danger'>No hay productos que hayas probado.</p>";
                                } else {
                                    $conn = new mysqli("localhost", "root", "", "nanifoods");
                                    $id_cliente = $_SESSION['id'];
                                    $sql = " 
                                        SELECT 
                                            p.codigo as codigo,
                                            p.nombre AS productos
                                        FROM detalles_pedidos dp 
                                        join pedidos pe on dp.id_pedido = pe.id
                                        JOIN productos p ON dp.id_producto = p.codigo
                                        WHERE pe.id_cliente = $id_cliente
                                        GROUP BY p.codigo, p.nombre
                                        ORDER BY p.nombre DESC
                                        ";

                                    $resultado = $conn->query($sql);

                                    if ($resultado->num_rows <= 0) {
                                        echo "<p class='text-warning'>No tienes pedidos para reseñar.</p>";
                                    }

                                    $conn->close();
                                }
                                ?>


                                <input class="form-control" type="text" name="nombres" placeholder="Nombres completos" required><br>

                                <select class="form-select" name="codigo" required>
                                    <option value="" disabled selected>producto</option>
                                    <?php
                                    foreach ($resultado as $producto) {
                                        echo "<option value='{$producto['codigo']}'>Producto: {$producto['productos']}</option>";
                                    }
                                    ?>
                                </select>

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
                            <button type="submit" class="btn btn-primary" name="tipo" value="producto">Enviar reseña</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>



        <div class="reseñas p-4">
            <?php include "inforeseñas.php" ?>

        </div>
    </section>
    <?php
    showfooter();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>