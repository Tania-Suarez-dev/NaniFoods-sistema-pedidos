<?php
$conn = new mysqli("localhost", "root", "", "nanifoods");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id_detalles_pedido = $_POST['id_detalles_pedido'];
$resena = $_POST['resena'];
$estrellas = $_POST['estrellas'];
$nombre_cliente = $_POST['nombres'];

$fecha = date("Y-m-d H:i:s");

$sql = "INSERT INTO resena (estrellas, resena, id_detalles_pedido, fecha, nombre_cliente) 
        VALUES ('$estrellas', '$resena', '$id_detalles_pedido', '$fecha', '$nombre_cliente')";


if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Reseña guardada con éxito');
            window.location.href='reseñas.php';
          </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
