<?php
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
        $correomalo = "<div class='alert alert-danger' role='alert'>el correo ya existe</div>";
        $correo_repetida->close();
    } else {
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $consulta = $conn->prepare("insert into usuarios values (NULL,?,?,?,?,?,'user',?)");
        $consulta->bind_param("ssissi", $nombre, $email, $telefono, $fechaNacimiento, $hash, $id);
        $consulta->execute();
        $consulta->store_result();

        $conn->query($consulta);
        $ultimo_id = $conn->insert_id;
        session_start();
        $result = $conn->query("SELECT id, rol, nombre FROM usuarios WHERE id = $ultimo_id");
        if ($result && $fila = mysqli_fetch_assoc($result)) {
            $_SESSION["id"] = $fila['id'];
            $_SESSION["rol"] = $fila['rol'];
            $_SESSION["usuario"] = $fila['nombre'];
            header("Location: ../index/index.php");
            exit;
        } else {
            echo "Usuario no encontrado o error en la consulta.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./estilossignup.css" rel="stylesheet">
    <link rel="stylesheet" href="../index/estiloindex.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link rel="icon" href="../img/favicon.png">
    <title>NaniFoods</title>
</head>

<body>
    <header>
        <div class="logo">
            <a href="../index/index.php">
                <img src="../img/logo.png" alt="Logo" class="logo">
            </a>
        </div>
        <div class="navegador">
            <ul>
                <li><a id="inicio" class="nav-items" href="../index/index.php">Inicio</a></li>
                <li><a class="nav-items" href="../productos/productos.php">Carta</a></li>
                <li><a class="nav-items" href="">Domicilios</a></li>
                <li><a class="nav-items" href="../reseñas/reseñas.php">Reseñas</a></li>
                <li><a class="nav-items" href="../acerca/acerca.php">Acerca de</a></li>
            </ul>
        </div>
    </header>
    <section class="principalLogin">
        <div class="login">
            <div class="lineatexto">
                <h1 class="textologin">SignUp</h1>
            </div>
            <form method="post" action="signup.php">
                <div class="formulario">
                    <?php if (isset($correomalo)) {
                        echo "$correomalo";
                    } ?>
                    <div>
                        <input type="text" class="campotext" placeholder="nombre y apellidos" name="nombre" required>
                    </div>
                    <div>
                        <input type="text" class="campotext" placeholder="telefono" name="telefono" required>
                    </div>
                    <div>
                        <input type="text" class="campotext" placeholder="identificación" name="id" name required>
                    </div>
                    <div>
                        <input type="date" class="campotext" placeholder="fecha de nacimiento" name="fechaNacimiento" required>
                    </div>
                    <div>
                        <input type="email" class="campotext" placeholder="Correo electronico" name="email" required>
                    </div>
                    <div>
                        <input type="password" class="campotext" placeholder="contraseña" name="contrasena" required>
                    </div>
                    <div>
                        <div class="recordar">
                            <input type="checkbox" id="recuerdame">
                            <label for="recuerdame">Recordar mi contrasena</label>
                        </div>
                        <button type="submit" class="botonlog">Registrarse</button>
                        <div class="vinculo-login">
                            ¿Ya tienes con cuenta?
                            <a href='../login/login.php'> Ingresa acá</button>
                        </div>
                    </div>
            </form>
    </section>
    </div>
    <footer>
        <div>
            <img src=" ../img/wsp.png " alt=" " width=" 50px " height=" 50px ">
            <img src=" ../img/fb.png " alt=" " width=" 48px " height=" 48px ">
        </div>
        <div class=" flink ">
            www.NaniFoods.com.co
        </div>
        <div>
            <img src="../img/logo.png " alt=" " width=" 70px " height=" 70px ">
        </div>
    </footer>
</body>

</html>