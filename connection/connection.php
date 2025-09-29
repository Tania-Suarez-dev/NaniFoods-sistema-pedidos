<?php
function connect()
{
    static $conexion = null;
    if ($conexion === null) {
        $conexion = new mysqli("localhost", "root", "", "nanifoods");
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
        $conexion->set_charset("utf8mb4");
    }
    return $conexion;
}
