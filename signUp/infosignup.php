<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $usuario = "root";
    $bd = "nanifoods";
    $conn = new mysqli("$host", "$usuario", "", "$bd");

    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $id = $_POST["id"];
    $fechaNacimiento = $_POST["fechaNacimiento"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];

    $correo_repetida = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $correo_repetida->bind_param("s", $email);
    $correo_repetida->execute();
    $correo_repetida->store_result();
    if ($correo_repetida->num_rows > 0) {
        $_SESSION["error"] = "<div class='alert alert-danger' role='alert'>el correo ya existe</div>";
        header("location:./signup.php");
        $correo_repetida->close();
    } else {
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $consulta = $conn->prepare("insert into usuarios values (NULL,?,?,?,?,?,'user',?)");
        $consulta->bind_param("ssissi", $nombre, $email, $telefono, $fechaNacimiento, $hash, $id);
        $consulta->execute();
        $consulta->store_result();

        $conn->query($consulta);
        $ultimo_id = $conn->insert_id;
        $result = $conn->query("SELECT id, rol, nombre FROM usuarios WHERE id = $ultimo_id");
        if ($result && $fila = mysqli_fetch_assoc($result)) {
            $_SESSION["id"] = $fila['id'];
            $_SESSION["rol"] = $fila['rol'];
            $_SESSION["usuario"] = $fila['nombre'];
            header("Location: ../index/index.php");
            exit;
        } else {
            $_SESSION["error"] = "Usuario no encontrado o error en la consulta.";
            header("location:./signup.php");
        }
    }
}
