<?php
// Conexión a la base de datos
$host = "localhost";
$db = "nanifoods";
$user = "root";

$conn = new mysqli($host, $user, "", $db);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$codigo = $_POST['codigo'];
$instrucciones = isset($_POST['instruccionespedido']) ? 1 : 0;
$terminos = isset($_POST['aceptarterminos']) ? 1 : 0;
$notificaciones = isset($_POST['aceptarnotificaciones']) ? 1 : 0;
$recordar = isset($_POST['recordarinformacion']) ? 1 : 0;

// Insertar de manera segura usando prepared statements
$stmt = $conn->prepare("INSERT INTO pedidos (id_cliente, direccion, telefono, correo, codigo_verificacion, estado)
                        VALUES (?, ?, ?, ?, ?, ?)");
$id_cliente = 10; // ejemplo: id del cliente (podrías tomarlo de sesión si hay login)
$estado = 'pendiente';
$stmt->bind_param("isssss", $id_cliente, $direccion, $telefono, $correo, $codigo, $estado);

if ($stmt->execute()) {
    $pedido_id = $stmt->insert_id; // id del pedido recién creado
    // Aquí podrías guardar detalles adicionales en detalles_pedidos si hay productos
    echo "Pedido guardado correctamente. ID: ".$pedido_id;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
