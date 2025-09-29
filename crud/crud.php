<?php
session_start();
require_once("../connection/connection.php");
require_once("../utils/storage.php");
require_once("../constants.php");
// Si no hay sesión
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}
// Si el rol no es admin
if ($_SESSION["rol"] !== "admin") {
    header("Location: index.php");
    exit();
}
$conexion = connect();


if (isset($_POST["id"]) && !empty($_POST["id"])) {
    update($_POST["id"]);
    header("Location: productos.php");
    exit();
} else if ($_SERVER["REQUEST_METHOD"] === "POST") {
    create();
    header("Location: productos.php");
    exit();
} else if (isset($_GET["id"]) && !empty($_GET["id"])) {
    delete($_GET["id"]);
    header("Location: productos.php");
    exit();
}

function get($id)
{
    global $conexion;
    $sql = "select * from productos where codigo = $id";
    $resultado = $conexion->query($sql) or die("Error en la consulta: " . $conexion->error);
    $data = null;
    if ($resultado && $resultado->num_rows > 0) {
        $data = $resultado->fetch_assoc();
    }
    return $data;
}


function all()
{
    global $conexion;
    $sql = "select P.*, avg(r.estrellas) as estrellas 
    FROM productos as p 
    LEFT JOIN detalles_pedidos as d on p.codigo = d.id_producto 
    LEFT JOIN resena as r on d.id = r.id_detalles_pedido 
    WHERE p.eliminado = 0
    GROUP BY p.codigo";
    $resultado = $conexion->query($sql) or die("Error en la consulta: " . $conexion->error);
    $data = [];
    if ($resultado && $resultado->num_rows > 0) {
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
    }
    return $data;
}

function delete($id)
{
    global $conexion;
    $sql = "update productos set eliminado = 1 where codigo = $id";
    $resultado = $conexion->query($sql) or die("Error en la consulta: " . $conexion->error);
    return $resultado;
}

function create()
{
    global $conexion;
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $descripcion = $_POST["descripcion"];
    $categoria = $_POST["categoria"];
    $imagen = $_FILES["imagen"]["name"];
    $imagen_tmp = $_FILES["imagen"]["tmp_name"];
    $ruta_destino = saveImage($imagen, $imagen_tmp, "products");

    try {
        $sql = "insert into productos (nombre, precio, descripcion, categoria, imagen) 
        values ('$nombre', $precio, '$descripcion', '$categoria', '$ruta_destino')";
        $resultado = $conexion->query($sql) or die("Error en la consulta: " . $conexion->error);
        return $resultado;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}
function update($id)
{
    global $conexion;

    $nombre = $_POST["nombre"];
    $precio = floatval($_POST["precio"]);
    $descripcion = $_POST["descripcion"];
    $categoria = $_POST["categoria"];

    $nueva_imagen = !empty($_FILES["imagen"]["name"]);

    if ($nueva_imagen) {
        global $ROOT_PATH, $APP_NAME;
        $old = get($id);
        $imagen_anterior = $old["imagen"];

        $imagen = $_FILES["imagen"]["name"];
        $imagen_tmp = $_FILES["imagen"]["tmp_name"];
        $ruta_destino = saveImage($imagen, $imagen_tmp, "products");
        $ruta_imagen = $ROOT_PATH . '/' . $APP_NAME . '/' . $imagen_anterior;
        if ($imagen_anterior && file_exists($ruta_imagen)) {
            echo "Eliminando imagen anterior: $imagen_anterior";
            unlink($ruta_imagen);
        }

        $sql = "UPDATE productos 
                SET nombre = ?, precio = ?, descripcion = ?, categoria = ?, imagen = ? 
                WHERE codigo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sdsssi", $nombre, $precio, $descripcion, $categoria, $ruta_destino, $id);
    } else {
        $sql = "UPDATE productos 
                SET nombre = ?, precio = ?, descripcion = ?, categoria = ? 
                WHERE codigo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sdssi", $nombre, $precio, $descripcion, $categoria, $id);
    }

    return $stmt->execute();
}
