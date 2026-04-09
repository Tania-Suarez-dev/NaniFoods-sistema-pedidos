<?php 

require_once("../constants.php");

// ✅ Definimos $BASE_URL para las imágenes
$SERVER_ENDPOINT = $_SERVER['HTTP_HOST'];
$APP_NAME = 'NaniFoods';
$BASE_URL = "http://$SERVER_ENDPOINT/$APP_NAME/";

$conexion = new mysqli("localhost", "root", "", "nanifoods");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");

$search     = isset($_GET['search']) ? $_GET['search'] : '';
$categoria  = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$ofertas    = isset($_GET['ofertas']) ? $_GET['ofertas'] : '';
$estrellas  = isset($_GET['estrellas']) ? $_GET['estrellas'] : '';
$precio_min = isset($_GET['precio_min']) ? $_GET['precio_min'] : '';
$precio_max = isset($_GET['precio_max']) ? $_GET['precio_max'] : '';
$debug      = isset($_GET['debug']) ? true : false;

$sql = "SELECT P.*, AVG(r.estrellas) as estrellas_porm 
        FROM productos as p 
        LEFT JOIN detalles_pedidos as d ON p.codigo = d.id_producto 
        LEFT JOIN resena as r ON d.id = r.id_detalles_pedido 
        WHERE 1";

if ($search != '') {
    $sql .= " AND (p.nombre LIKE '%$search%' OR p.descripcion LIKE '%$search%' OR p.categoria LIKE '%$search%')";
}

if ($categoria != '') {
    $sql .= " AND p.categoria = '$categoria'";
}

if ($precio_min != '') {
    $precio_min = intval($precio_min);
    $sql .= " AND p.precio >= $precio_min";
}

if ($precio_max != '') {
    $precio_max = intval($precio_max);
    $sql .= " AND p.precio <= $precio_max";
}

$sql .= " GROUP BY p.codigo";

if ($estrellas != '') {
    $estrellas = intval($estrellas);
    $estrellas_min = $estrellas - 1;
    $sql .= " HAVING COALESCE(estrellas_porm, 0) BETWEEN $estrellas_min AND $estrellas";
}

$resultado = $conexion->query($sql) or die("Error en la consulta: " . $conexion->error);

$data = [];
if ($resultado && $resultado->num_rows > 0) {
    $data = $resultado->fetch_all(MYSQLI_ASSOC);
    foreach ($data as &$row) {
        $row["id"] = $row["codigo"];
        unset($row["codigo"]);
        $row["imagen"] = $BASE_URL . $row["imagen"];
    }
}

header('Content-Type: application/json; charset=utf-8');
if ($debug) {
    echo json_encode([
        "sql_debug" => $sql,
        "productos" => $data
    ], JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}
exit;
