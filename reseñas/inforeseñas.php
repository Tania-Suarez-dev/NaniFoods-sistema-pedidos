<?php
$conexion = new mysqli("localhost", "root", "", "nanifoods");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");

$search = $_GET['search'] ?? '';
$orden = $_GET['orden'] ?? '';
$estrellas = $_GET['estrellas'] ?? '';
$tipo = $_GET['tipo'] ?? '';

$sql = $sql = "
SELECT 
    r.ID_resena,
    r.estrellas,
    r.resena,
    r.fecha,
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


if ($search != '') {
    $sql .= " AND (resena.resena LIKE '%$search%' 
            OR productos.nombre LIKE '%$search%' 
            OR usuarios.nombre LIKE '%$search%' 
            OR repartidores.nombre LIKE '%$search%')";
}

if (!empty($_GET['estrellas'])) {
    $estrellas = intval($_GET['estrellas']);
    $sql .= " AND resena.estrellas = $estrellas";
}

if ($tipo == 'productos') {
    $sql .= " AND detalles_pedidos.id_producto IS NOT NULL";
}
if ($tipo == 'repartidores') {
    $sql .= " AND detalles_pedidos.id_producto IS NULL AND pedidos.id_repartidor IS NOT NULL";
}

if ($orden == 'recientes') {
    $sql .= " ORDER BY resena.fecha DESC";
} elseif ($orden == 'valoracion') {
    $sql .= " ORDER BY resena.estrellas DESC";
}

$resultado = $conexion->query($sql) or die("Error en la consulta: " . $conexion->error);

echo '<div class="row">';
if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo '<div class="col-md-4">
                <div class="card mb-3 shadow">
                    <div class="card-body">
                        <h5 class="card-title">'.
                            ($fila['producto'] ?? 'Reseña de Repartidor: '.$fila['repartidor']).
                        '</h5>
                        <h6 class="card-subtitle text-muted">Cliente: '.($fila['nombre_cliente'] ?? $fila['cliente']).'</h6>
                        <p class="card-text mt-2">'.$fila['resena'].'</p>
                        <small class="text-muted">'.($fila['observaciones'] ?? '').'</small>
                        <p class="mt-2"><span class="badge bg-warning">'.$fila['fecha'].'</span></p>
                    </div>
                </div>
            </div>';
    }
} else {
    echo "<p class='text-light'>No hay reseñas encontradas</p>";
}
echo '</div>';
?>
