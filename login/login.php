<?php
session_start();
if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $host = "localhost";
    $usuario ="root";
    $bd= "nanifoods";
    $conn = new mysqli("$host", "$usuario", "", "$bd");
    
$conn->set_charset("utf8mb4");
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];

$email = mysqli_real_escape_string($conn, $email);
$contrasena = mysqli_real_escape_string($conn, $contrasena);

    $consulta = $conn->prepare("select * from usuarios where correo =  ?");
    $consulta->bind_param("s", $email );
    $consulta->execute();
    $result  = $consulta->get_result();

if ($fila =$result ->fetch_assoc()) {
        if (password_verify($contrasena, $fila['contraseña'])){
            $_SESSION["id"] = $fila['id'];
            $_SESSION["rol"] = $fila['rol'];
            $_SESSION["usuario"] = $fila['nombre']; 
            header("location: ../index/index.php");
        }
        else{
            $nocontrasena ="<div class='alert alert-danger' role='alert'>La contraseña es invalida</div>";
        }   
    }
    else{
            $nocorreo = "<div class='alert alert-warning'>El correo no está registrado</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./estilosLogin.css" rel="stylesheet">
    <link rel="stylesheet" href="../index/estiloindex.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
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
            <h1 class="textologin">Login</h1>
            <form action="login.php", method="post">
                <div class="formulario">
                    <div class="correo">
                        <input type="email" class="campotext" placeholder="Correo electronico" name="email" required>
                    </div>
                    <div class="contrasena">
                        <input type="password" class="campotext" placeholder="contraseña" name="contrasena" required>
                    </div>
                    <div>
                        <div class="recordar">
                            <input type="checkbox" id="recuerdame">
                            <label for="recuerdame">Recordar mi contrasena</label>
                        </div>
                        <button id="submit" type="submit" class="botonlog">ingresar</button>
                        <div class="vinculo-login">
                            ¿No tienes una cuenta?
                            <a href="../signUp/signup.php">Registrate acá</button>
                        </div>
            <?php if (isset($nocontrasena)){ echo "$nocontrasena";}?>
            <?php if (isset($nocorreo)){ echo "$nocorreo";}?>
                    </div>
            </form>
        </div>
    </section>
    <footer>
        <div>
            <img src="../img/wsp.png" alt="" width="50px" height="50px">
            <img src="../img/fb.png" alt="" width="48px" height="48px">
        </div>
        <div class="flink">
            www.NaniFoods.com.co
        </div>
        <div>
            <img src="../img/logo.png" alt="" width="70px" height="70px">
        </div>
    </footer>
    <script src="./index.js"></script>

</body>

</html>