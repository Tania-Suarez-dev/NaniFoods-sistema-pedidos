<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    http_response_code(403);
    exit('⛔ Acceso denegado. Solo el administrador puede ver este recurso.');
}

require_once("../connection/connection.php");
$conexion = connect();

function last_n_days($n) {
    $days = [];
    for ($i = $n-1; $i >= 0; $i--) {
        $days[] = date('Y-m-d', strtotime("-{$i} days"));
    }
    return $days;
}

$q = "SELECT COUNT(*) AS total FROM pedidos WHERE estado = 'pendiente'";
$res = $conexion->query($q);
$pedidos_pendientes = ($res && $r = $res->fetch_assoc()) ? (int)$r['total'] : 0;

$q = "SELECT COUNT(*) AS total FROM pedidos WHERE DATE(fecha) = CURDATE()";
$res = $conexion->query($q);
$pedidos_hoy = ($res && $r = $res->fetch_assoc()) ? (int)$r['total'] : 0;

$q = "SELECT COUNT(*) AS total FROM resena WHERE DATE(fecha) = CURDATE()";
$res = $conexion->query($q);
$resenas_hoy = ($res && $r = $res->fetch_assoc()) ? (int)$r['total'] : 0;

$q = "SELECT COALESCE(SUM(preciototal),0) AS total FROM pedidos WHERE DATE(fecha) >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)";
$res = $conexion->query($q);
$ventas_semana = ($res && $r = $res->fetch_assoc()) ? (int)$r['total'] : 0;

$q = "
  SELECT p.nombre, SUM(dp.cantidad) AS vendido
  FROM detalles_pedidos dp
  JOIN productos p ON dp.id_producto = p.codigo
  JOIN pedidos pe ON dp.id_pedido = pe.id
  WHERE pe.fecha >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
  GROUP BY dp.id_producto
  ORDER BY vendido DESC
  LIMIT 5
";
$res = $conexion->query($q);
$productos_populares = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $productos_populares[] = [
            'nombre' => $row['nombre'],
            'vendido' => (int)$row['vendido']
        ];
    }
}

$q = "
  SELECT id, preciototal, fecha, estado, direccion, metodo_pago, observaciones, id_cliente, id_repartidor
  FROM pedidos
  ORDER BY fecha DESC
  LIMIT 20
";
$res = $conexion->query($q);
$ultimos_pedidos = [];
if ($res) {
    while ($r = $res->fetch_assoc()) {
        $ultimos_pedidos[] = [
            'id' => (int)$r['id'],
            'preciototal' => (int)$r['preciototal'],
            'fecha' => $r['fecha'],
            'estado' => $r['estado'],
            'direccion' => $r['direccion'],
            'metodo_pago' => $r['metodo_pago'],
            'observaciones' => $r['observaciones'],
            'id_cliente' => $r['id_cliente'] !== null ? (int)$r['id_cliente'] : null,
            'id_repartidor' => $r['id_repartidor'] !== null ? (int)$r['id_repartidor'] : null,
        ];
    }
}

$days = last_n_days(7); 
$q = "
  SELECT DATE(fecha) AS dia, COALESCE(SUM(preciototal),0) AS total
  FROM pedidos
  WHERE DATE(fecha) >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
  GROUP BY DATE(fecha)
  ORDER BY DATE(fecha) ASC
";
$res = $conexion->query($q);
$sales_map = [];
if ($res) {
    while ($r = $res->fetch_assoc()) {
        $sales_map[$r['dia']] = (int)$r['total'];
    }
}

$grafica_fechas = [];
$grafica_valores = [];
foreach ($days as $d) {
    $grafica_fechas[] = date('d M', strtotime($d));
    $grafica_valores[] = isset($sales_map[$d]) ? (int)$sales_map[$d] : 0;
}


header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'pedidos_pendientes' => $pedidos_pendientes,
    'pedidos_hoy' => $pedidos_hoy,
    'resenas_hoy' => $resenas_hoy,
    'ventas_semana' => $ventas_semana,
    'productos_populares' => $productos_populares,
    'ultimos_pedidos' => $ultimos_pedidos,
    'grafica' => [
        'fechas' => $grafica_fechas,
        'valores' => $grafica_valores
    ]
], JSON_UNESCAPED_UNICODE);
