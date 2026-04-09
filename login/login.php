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
    <link href="./estilosLogin.css" rel="stylesheet">
    <link rel="stylesheet" href="../index/estiloindex.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
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
            <h1 class="textologin">Login</h1>
            <form action="./infologin.php" method="post">
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
                            <a href="../signUp/signup.php">Registrate acá</a>
                        </div>
                        <?php if (isset($_SESSION["error"])) {
                            echo "$_SESSION[error]";
                            unset($_SESSION["error"]);
                        };
                        ?>
                    </div>
            </form>
        </div>
    </section>
    <?php
    showfooter();
    ?>
</body>

</html>