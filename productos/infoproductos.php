
<?php

require_once "../constants.php";
$conexion = new mysqli("localhost", "root", "", "nanifoods");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");

$search = isset($_GET['search']) ? $_GET['search'] : '';
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$ofertas = isset($_GET['ofertas']) ? $_GET['ofertas'] : '';
$estrellas = isset($_GET['estrellas']) ? $_GET['estrellas'] : '';
$precio_min = isset($_GET['precio_min']) ? $_GET['precio_min'] : '';
$precio_max = isset($_GET['precio max']) ? $_GET['precio max'] : '';

$sql = "select P.*, avg(r.estrellas) as estrellas FROM productos as p LEFT JOIN detalles_pedidos as d on p.codigo = d.id_producto LEFT JOIN resena as r on d.id = r.id_detalles_pedido WHERE 1";
if ($search != '') {
    $sql .= " AND (p.nombre LIKE '%$search%' 
            OR p.descripcion LIKE '%$search%' 
            OR p.categoria LIKE '%$search%')";
}
if (!empty($_GET["categoria"])) {
    $sql .= " AND p.categoria = '$categoria'";
}

if (!empty($_GET['estrellas'])) {
    $estrellas = intval($_GET['estrellas']);
    $sql .= " AND d.estrellas = $estrellas";
}
if (!empty($_GET["precio_min"])) {
    $precio_min = intval($_GET['precio_min']);
    $sql .= " AND p.precio >= $precio_min";
}

if (!empty($_GET["precio_max"])) {
    $precio_max = intval($_GET['precio_max']);
    $sql .= " AND p.precio <= $precio_max";
}
$sql .= " group by p.codigo";

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
echo json_encode($data);
