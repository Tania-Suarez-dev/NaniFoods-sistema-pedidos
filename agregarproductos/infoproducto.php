<?php
require_once("../utils/storage.php");
$conexion = new mysqli("localhost", "root", "", "nanifoods");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $categoria = $_POST['categoria'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen = $_FILES['imagen']['name'];
    $ruta_temporal = $_FILES['imagen']['tmp_name'];
    $carpeta_destino = saveImage($imagen, $ruta_temporal);

    if ($carpeta_destino) {
        $sql = "INSERT INTO productos (nombre, precio, descripcion, categoria, imagen) 
            VALUES ('$nombre', '$precio', '$descripcion', '$categoria', '$carpeta_destino')";


        if ($conexion->query($sql) === TRUE) {
            header("Location: agregarproductos.php?success=1");
            exit();
        } else {
            echo "Error al guardar en la base de datos: " . $conexion->error;
        }
    } else {
        echo "Error al subir la imagen.";
    }
}
