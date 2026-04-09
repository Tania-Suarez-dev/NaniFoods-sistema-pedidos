<?php
require_once("../connection/connection.php");
$conexion = connect();
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$resena = $_POST['resena'];
$estrellas = $_POST['estrellas'];
$nombre_cliente = $_POST['nombres'];
$tipo_resena = $_POST['tipo'];

$fecha = date("Y-m-d H:i:s");
require_once("../connection/connection.php");
$conexion = connect();
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$tipo_resena = $_POST['tipo'];
$resena = $_POST['resena'];
$estrellas = $_POST['estrellas'];
$nombre_cliente = $_POST['nombres'];
$fecha = date("Y-m-d H:i:s");

if ($tipo_resena == "pedido") {
    $id_pedido = $_POST['id_pedido'];

    $busqueda = $conexion->prepare("SELECT id FROM detalles_pedido WHERE id_pedido = ? LIMIT 1");
    $busqueda->bind_param("i", $id_pedido);
    $busqueda->execute();
    $resultado = $busqueda->get_result();
    $fila = $resultado->fetch_assoc();

    if ($fila) {
        $id_detalles_pedido = $fila['id'];

        $stmt = $conexion->prepare("INSERT INTO resena (estrellas, resena, tipo_resena, id_detalles_pedido, fecha, nombre_cliente)
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ississ", $estrellas, $resena, $tipo_resena, $id_detalles_pedido, $fecha, $nombre_cliente);

        if ($stmt->execute()) {
            echo "<script>alert('Reseña de pedido guardada con éxito'); window.location.href='reseñas.php';</script>";
        } else {
            echo "Error al guardar la reseña: " . $stmt->error;
        }
    } else {
        echo "No se encontró ningún detalle de ese pedido.";
    }
}

if ($tipo_resena == "producto") {
    $codigo = $_POST['codigo'];

    $busqueda = $conexion->prepare("SELECT id FROM detalles_pedido WHERE codigo = ? LIMIT 1");
    $busqueda->bind_param("i", $codigo);
    $busqueda->execute();
    $resultado = $busqueda->get_result();
    $fila = $resultado->fetch_assoc();

    if ($fila) {
        $id_detalles_pedido = $fila['id'];

        $stmt = $conexion->prepare("INSERT INTO resena (estrellas, resena, tipo_resena, id_detalles_pedido, fecha, nombre_cliente)
            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ississ", $estrellas, $resena, $tipo_resena, $id_detalles_pedido, $fecha, $nombre_cliente);

        if ($stmt->execute()) {
            echo "<script>alert('Reseña de producto guardada con éxito'); window.location.href='reseñas.php';</script>";
        } else {
            echo "Error al guardar la reseña: " . $stmt->error;
        }
    } else {
        echo "No se encontró ningún detalle para ese producto.";
    }
}
$stmt->close();
$conexion->close();
