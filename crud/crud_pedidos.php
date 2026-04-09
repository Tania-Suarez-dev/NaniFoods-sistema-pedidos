<?php
require_once("../connection/connection.php");
$conexion = connect();

function all_pedidos() {
    global $conexion;

    $sql = "
        SELECT p.*, u.nombre AS cliente
        FROM pedidos p
        LEFT JOIN usuarios u ON u.id = p.id_cliente
        ORDER BY p.fecha DESC, p.hora DESC
    ";

    $resultado = $conexion->query($sql) or die("Error al consultar pedidos: " . $conexion->error);
    $pedidos = [];

    while ($p = $resultado->fetch_assoc()) {
        $id = $p['id'];
        $detallesRes = $conexion->query("
            SELECT d.*, pr.nombre 
            FROM detalles_pedidos d 
            LEFT JOIN productos pr ON pr.codigo = d.id_producto
            WHERE d.id_pedido = $id
        ");
        $detalles = [];
        while ($d = $detallesRes->fetch_assoc()) {
            $detalles[] = $d;
        }
        $p['detalles'] = $detalles;
        $pedidos[] = $p;
    }

    return $pedidos;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save') {
    $id = $_POST['id'] ?? '';
    $id_cliente = (int)($_POST['id_cliente'] ?? 0);
    $fecha = $conexion->real_escape_string($_POST['fecha']);
    $hora = $conexion->real_escape_string($_POST['hora']);
    $estado = $conexion->real_escape_string($_POST['estado']);
    $direccion = $conexion->real_escape_string($_POST['direccion']);
    $metodo_pago = $conexion->real_escape_string($_POST['metodo_pago']);
    $id_repartidor = !empty($_POST['id_repartidor']) ? (int)$_POST['id_repartidor'] : 'NULL';
    $observaciones = $conexion->real_escape_string($_POST['observaciones']);

    if (empty($id)) {
        $sql = "
            INSERT INTO pedidos (id_cliente, fecha, hora, estado, direccion, metodo_pago, id_repartidor, observaciones)
            VALUES ($id_cliente, '$fecha', '$hora', '$estado', '$direccion', '$metodo_pago', $id_repartidor, '$observaciones')
        ";
        if ($conexion->query($sql)) {
            echo "<script>
                alert('✅ Pedido creado correctamente');
                window.location.href = 'pedidos.php';
            </script>";
        } else {
            echo "<script>
                alert('❌ Error al crear el pedido: " . $conexion->error . "');
                window.location.href = 'pedidos.php';
            </script>";
        }
    } else {

        $sql = "
            UPDATE pedidos
            SET id_cliente = $id_cliente,
                fecha = '$fecha',
                hora = '$hora',
                estado = '$estado',
                direccion = '$direccion',
                metodo_pago = '$metodo_pago',
                id_repartidor = $id_repartidor,
                observaciones = '$observaciones'
            WHERE id = $id
        ";
        if ($conexion->query($sql)) {
            echo "<script>
                alert('✏️ Pedido actualizado correctamente');
                window.location.href = 'pedidos.php';
            </script>";
        } else {
            echo "<script>
                alert('❌ Error al actualizar el pedido: " . $conexion->error . "');
                window.location.href = 'pedidos.php';
            </script>";
        }
    }
    exit;
}

if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];

    $conexion->query("DELETE FROM detalles_pedidos WHERE id_pedido = $id");

    if ($conexion->query("DELETE FROM pedidos WHERE id = $id")) {
        echo "<script>
            alert('🗑️ Pedido eliminado correctamente');
            window.location.href = 'pedidos.php';
        </script>";
    } else {
        echo "<script>
            alert('❌ Error al eliminar el pedido: " . $conexion->error . "');
            window.location.href = 'pedidos.php';
        </script>";
    }
    exit;
}
?>
