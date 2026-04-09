<?php
header('Content-Type: application/json');
session_start();

date_default_timezone_set('America/Bogota');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
    exit;
}

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

file_put_contents("debug_checkout.log", date("H:i:s") . " - RAW: " . $rawData . PHP_EOL, FILE_APPEND);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["success" => false, "message" => "Error al decodificar JSON: " . json_last_error_msg()]);
    exit;
}

if (empty($data['carrito'])) {
    echo json_encode(["success" => false, "message" => "Carrito vacío"]);
    exit;
}

$carrito = $data['carrito'];
$direccion = $data['direccion'] ?? '';
$metodo_pago = $data['metodo_pago'] ?? '';
$observaciones_pedido = $data['observaciones'] ?? '';

if (empty($direccion) || empty($metodo_pago)) {
    echo json_encode(["success" => false, "message" => "Faltan datos obligatorios"]);
    exit;
}

$conexion = new mysqli("localhost", "root", "", "nanifoods");
if ($conexion->connect_error) {
    echo json_encode(["success" => false, "message" => "Error de conexión: " . $conexion->connect_error]);
    exit;
}
$conexion->set_charset("utf8mb4");

$id_cliente = $_SESSION['id'] ?? null;

if (!$id_cliente) {
    echo json_encode(["success" => false, "message" => "Usuario no autenticado"]);
    exit;
}
$id_repartidor = 10;

$total = 0;
foreach ($carrito as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

$fecha = date("Y-m-d H:i:s");
$estado = "pendiente";

$stmt = $conexion->prepare("
    INSERT INTO pedidos (preciototal, fecha, estado, id_cliente, id_repartidor, direccion, metodo_pago, observaciones) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param("issiisss", $total, $fecha, $estado, $id_cliente, $id_repartidor, $direccion, $metodo_pago, $observaciones_pedido);

if (!$stmt->execute()) {
    echo json_encode(["success" => false, "message" => "Error al crear pedido: " . $stmt->error]);
    exit;
}

$id_pedido = $stmt->insert_id;
$stmt->close();

$stmt = $conexion->prepare("
    INSERT INTO detalles_pedidos (precio_unitario, id_pedido, id_producto, cantidad) 
    VALUES (?, ?, ?, ?)
");

foreach ($carrito as $item) {
    $precio_unitario = $item['precio'];
    $id_producto = $item['id'];
    $cantidad = $item['cantidad'];

    $stmt->bind_param("diii", $precio_unitario, $id_pedido, $id_producto, $cantidad);

    if (!$stmt->execute()) {
        file_put_contents("debug_checkout.log", date("H:i:s") . " - Error detalle: " . $stmt->error . PHP_EOL, FILE_APPEND);
    }
}

$stmt->close();
$conexion->close();

echo json_encode(["success" => true, "message" => "Pedido procesado correctamente"]);
