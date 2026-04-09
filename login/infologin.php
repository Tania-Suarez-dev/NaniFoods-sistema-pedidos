<?php
session_start();
require_once("../connection/connection.php");
$conexion = connect();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];

    $email = mysqli_real_escape_string($conexion, $email);
    $contrasena = mysqli_real_escape_string($conexion, $contrasena);

    $consulta = $conexion->prepare("select * from usuarios where correo =  ?");
    $consulta->bind_param("s", $email);
    $consulta->execute();
    $result  = $consulta->get_result();

    if ($fila = $result->fetch_assoc()) {
        if (password_verify($contrasena, $fila['contraseña'])) {
            $_SESSION["id"] = $fila['id'];
            $_SESSION["rol"] = $fila['rol'];
            $_SESSION["usuario"] = $fila['nombre'];
            header("location: ../index/index.php");
        } else {
            $_SESSION["error"] = "<div class='alert alert-danger' role='alert'>La contraseña es invalida</div>";
            header("location:./login.php");
        }
    } else {
        $_SESSION["error"] = "<div class='alert alert-danger'>El correo no está registrado</div>";
        header("location:./login.php");
    }
}
