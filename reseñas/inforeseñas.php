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

$sql = "select r.resena AS resena, d.observaciones,
            p.nombre AS producto,
            u.nombre AS cliente,
            pe.fecha AS fecha,
            rep.nombre AS repartidor,
            r.estrellas AS estrellas
        FROM detalles_pedidos d
        LEFT JOIN resena r ON d.id = r.id_detalles_pedido
        LEFT JOIN productos p ON d.id_producto = p.codigo
        LEFT JOIN pedidos pe ON d.id_pedido = pe.id
        LEFT JOIN usuarios u ON pe.id_cliente = u.id
        LEFT JOIN repartidores rep ON pe.id_repartidor = rep.id
        WHERE 1=1";

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
    $sql .= " AND d.id_producto IS NOT NULL";
}
if ($tipo == 'repartidores') {
    $sql .= " AND d.id_producto IS NULL AND pe.id_repartidor IS NOT NULL";
}

if ($orden == 'recientes') {
    $sql .= " ORDER BY pe.fecha DESC";
} elseif ($orden == 'valoracion') {
    $sql .= " ORDER BY r.estrellas DESC";
}

$resultado = $conexion->query($sql) or die("Error en la consulta: " . $conexion->error);

echo '<div class="row">';
if ($resultado && $resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        echo '<div class="col-md-4">
                <div class="card mb-3 shadow">
                    <div class="card-body">
                        <h5 class="card-title">'.
                            ($fila['producto'] ?? 'Reseña de Repartidor: '.$fila['repartidor']).
                        '</h5>
                        <h6 class="card-subtitle text-muted">Cliente: '.$fila['cliente'].'</h6>
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
