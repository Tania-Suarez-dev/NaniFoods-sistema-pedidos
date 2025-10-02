<?php
header('Content-Type: application/json');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
    exit;
}

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (!isset($data['carrito']) || empty($data['carrito'])) {
    echo json_encode(["success" => false, "message" => "Carrito vacío"]);
    exit;
}

$carrito = $data['carrito'];

$host = "localhost";
$usuario = "root";
$bd = "nanifoods";

$conexion = new mysqli($host, $usuario, "", $bd);
if ($conexion->connect_error) {
    echo json_encode(["success" => false, "message" => "Error de conexión: " . $conexion->connect_error]);
    exit;
}

$conexion->set_charset("utf8mb4");

$id_cliente = $_SESSION['usuario_id'] ?? 10; 
$id_repartidor = 10; 


$total = 0;
foreach ($carrito as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

$fecha = date("Y-m-d");
$hora = date("H:i:s");
$estado = "pendiente";


$stmt = $conexion->prepare("
    INSERT INTO pedidos (preciototal, fecha, hora, estado, id_cliente, id_repartidor) 
    VALUES (?, ?, ?, ?, ?, ?)
");
$stmt->bind_param("isssii", $total, $fecha, $hora, $estado, $id_cliente, $id_repartidor);

if (!$stmt->execute()) {
    echo json_encode(["success" => false, "message" => "Error al crear pedido"]);
    exit;
}

$id_pedido = $stmt->insert_id;
$stmt->close();

$stmt = $conexion->prepare("
    INSERT INTO detalles_pedidos (precio_unitario, observaciones, id_pedido, id_producto, cantidad) 
    VALUES (?, ?, ?, ?, ?)
");

foreach ($carrito as $item) {
    $precio_unitario = $item['precio'];
    $observaciones = "";
    $id_producto = $item['id'];
    $cantidad = $item['cantidad'];

    $stmt->bind_param("dsiii", $precio_unitario, $observaciones, $id_pedido, $id_producto, $cantidad);
    $stmt->execute();
}
$stmt->close();

$conexion->close();

echo json_encode(["success" => true, "message" => "Pedido procesado correctamente"]);
