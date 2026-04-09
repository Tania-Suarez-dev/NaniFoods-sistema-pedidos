<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    http_response_code(403);
    exit('⛔ Acceso denegado. Solo el administrador puede exportar los pedidos.');
}

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "nanifoods";

$mysqli = new mysqli($host, $user, $pass, $dbname);
if ($mysqli->connect_error) die("Error de conexión: " . $mysqli->connect_error);
$mysqli->set_charset("utf8mb4");

$fecha_inicio = !empty($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
$fecha_fin = !empty($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;
$estado = !empty($_GET['estado']) ? $_GET['estado'] : null;

$stmt = $mysqli->prepare("CALL ConsultarPedidosConDetalles(?, ?, ?)");
$stmt->bind_param("sss", $fecha_inicio, $fecha_fin, $estado);
$stmt->execute();
$res = $stmt->get_result();

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=reporte_pedidos.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr style='background-color:#ffb001; color:black; font-weight:bold; text-align:center;'>
        <th>ID Pedido</th>
        <th>Fecha</th>
        <th>Estado</th>
        <th>ID Cliente</th>
        <th>ID Repartidor</th>
        <th>Direccion</th>
        <th>Metodo de Pago</th>
        <th>Observaciones</th>
        <th>Productos (detalle)</th>
        <th>Total</th>
      </tr>";

while ($r = $res->fetch_assoc()) {
    $productos_texto = $r['productos'] ?? 'Sin productos';
    $precio_total = $r['preciototal'] ?? 0;

    $total_detallado = 0;
    if (!empty($r['productos'])) {

        preg_match_all('/\(\$(\d+(?:\.\d+)?)\)/', $r['productos'], $precios);
        preg_match_all('/x(\d+)/', $r['productos'], $cantidades);

        $precios = $precios[1];
        $cantidades = $cantidades[1];

        for ($i = 0; $i < count($precios); $i++) {
            $total_detallado += (float)$precios[$i] * (int)($cantidades[$i] ?? 1);
        }
    }

    echo "<tr>
            <td>{$r['id_pedido']}</td>
            <td>" . date('d/m/Y', strtotime($r['fecha'])) . "</td>
            <td>{$r['estado']}</td>
            <td>{$r['id_cliente']}</td>
            <td>{$r['id_repartidor']}</td>
            <td>{$r['direccion']}</td>
            <td>{$r['metodo_pago']}</td>
            <td>{$r['observaciones']}</td>
            <td>{$productos_texto}</td>
            <td>$" . number_format($total_detallado, 0, ',', '.') . "</td>
          </tr>";
}

echo "</table>";

$stmt->close();
$mysqli->close();
exit;
?>
