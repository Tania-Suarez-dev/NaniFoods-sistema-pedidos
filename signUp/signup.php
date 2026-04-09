<?php
session_start();
require_once("../utils/header.php");
require_once("../utils/footer.php");

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
    <?php
    showheader();
    ?>
    <section class="principalLogin">
        <div class="login">
            <div class="lineatexto">
                <h1 class="textologin">SignUp</h1>
            </div>
            <form method="post" action="./infosignup.php">
                <div class="formulario">
                    <?php if (isset($_SESSION["error"])) {
                        echo "$_SESSION[error]";
                        unset($_SESSION["error"]);
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

    <?php
    showfooter();
    ?>
</body>

</html>