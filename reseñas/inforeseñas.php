<?php
require_once("../connection/connection.php");
require_once("../utils/utils.php");
$conexion = connect();
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");

$sql = "
SELECT 
    r.ID_resena,
    r.estrellas,
    r.resena,
    r.fecha,
    r.tipo_resena,
    r.nombre_cliente AS nombre_cliente_manual,
    p.nombre AS producto,
    rep.nombre AS repartidor,
    u.nombre AS cliente
FROM resena r
LEFT JOIN detalles_pedidos dp ON r.id_detalles_pedido = dp.id
LEFT JOIN pedidos pe ON dp.id_pedido = pe.id
LEFT JOIN usuarios u ON pe.id_cliente = u.id
LEFT JOIN productos p ON dp.id_producto = p.codigo
LEFT JOIN repartidores rep ON pe.id_repartidor = rep.id
WHERE 1=1
";


$search = isset($_GET['search']) ? $_GET['search'] : '';
$orden = isset($_GET['orden']) ? $_GET['orden'] : '';
$estrellas = isset($_GET['estrellas']) ? $_GET['estrellas'] : '';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

if ($search != '') {
    $sql .= " AND (r.resena LIKE '%$search%' 
            OR p.nombre LIKE '%$search%' 
            OR u.nombre LIKE '%$search%' 
            OR rep.nombre LIKE '%$search%')";
}

if (!empty($_GET['estrellas'])) {
    $estrellas = intval($_GET['estrellas']);
    $sql .= " AND r.estrellas = $estrellas";
}

if ($tipo == 'productos') {
    $sql .= " AND dp.id_producto IS NOT NULL";
}
if ($tipo == 'repartidores') {
    $sql .= " AND dp.id_producto IS NULL AND pe.id_repartidor IS NOT NULL";
}

if ($orden == 'recientes') {
    $sql .= " ORDER BY r.fecha DESC";
} elseif ($orden == 'valoracion') {
    $sql .= " ORDER BY r.estrellas DESC";
}

$resultado = $conexion->query($sql) or die("Error en la consulta: " . $conexion->error);

echo '<div class="row g-1 mt-4 gap-3 ">';
if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo '<div class="card shadow col-lg-3 col-md-3 col-sm-4 col-xs-6 m-1" style="width:18rem " >
                <div class="card-body">
                <p class="mt-0"><span class="badge bg-warning"> ' . formatDateTime($fila['fecha']) . ' </span></p>
                <h5 class="card-title">' . ($fila['tipo_resena'] == 'producto' ? $fila['producto'] : 'Reseña de pedido: ') . '</h5>
                <h6 class="card-subtitle text-muted">Cliente: ' . (isset($fila['nombre_cliente']) ? $fila['cliente'] : '') . '</h6>
                ';
        showstars($fila['estrellas']);
        echo '
                    <p class="card-text mt-0">' . $fila['resena'] . '</p>
                    <small class="text-muted">' . ($fila['observaciones'] ?? '') . '</small>
            </div>
            </div>';
    }
} else {
    echo "<p class='text-light'>No hay reseñas encontradas</p>";
}
echo '</div>';
