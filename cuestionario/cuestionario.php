<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link rel="icon" href="../img/logo.png">
    <link rel="stylesheet" href="../index/estiloindex.css">
    <link rel="stylesheet" href="estiloscuestionario.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <div class="boton">
            <button class="vinculo" onclick="location.href='../login/login.php'"><img src="../img/testp.png" class="perfil"></button>
        </div>
    </header>
    <section class="principalcuestionario">
        <section class="cajacuestionario">

            <div class="titulocuestionario">
                <h1>Haz tu pedido</h1>
            </div>
            <form action="infopedidos.php" method="POST">


                <div class="campo">
                    <label for="nombre">Ingresa tu nombre</label>
                    <input type="text" id="nombre" name= "nombre" class="camponombre" placeholder="Nombre" required>
                </div>

                <div class="campo">
                    <label for="direccion">Digita tu dirección</label>
                    <input type="text" id="direccion" name= "direccion"  class="campodireccion" placeholder="Dirección" required>
                </div>

                <div class="campo">
                    <label for="telefono">Ingresa tu número de teléfono</label>
                    <input type="tel" id="telefono" name= "telefono" class="campotelefono" placeholder="Número de teléfono" required>
                </div>

                <div class="campo">
                    <label for="correo">Ingresa tu correo</label>
                    <input type="email" id="correo" name= "correo" class="campocorreo" placeholder="Correo electrónico" required>
                </div>

                <div class="campo">
                    <label for="codigo-pedido">Código de verificacion</label>
                    <input type="text" id="codigo-pedido" name= "codigo" class="campocodigo" placeholder="codigo de verificacion" required>
                </div>

                <div class="checkboxcuestionario">
                    <label for="pedido"><input type="checkbox" id="pedido" name="instruccionespedido">
                        Tengo instrucciones o solicitudes especiales para mi pedido</label>

                    <label for="terminos"><input type="checkbox" id="terminos" name="aceptarterminos" required>
                        Acepto los terminos y condiciones y la politica de privacidad</label>

                    <label for="notificaciones"><input type="checkbox" id="notificaciones" name="aceptarnotificaciones">
                        Deseo recibir notificaciones y promociones</label>

                    <label for="recordarinf"><input type="checkbox" id="recordarinf" name="recordarinformacion">
                        Recordar mis datos de pedido</label>
                </div>

                <button type="submit" class="botoncuestionario">Enviar</button>

            </form>
        </section>
    </section>


    <footer>
        <div>
            <img src="../img/wsp.png" alt="" width="50px" height="50px">
            <img src="../img/fb.png" alt="" width="48px" height="48px">
        </div>
        <div class="flink">
            www.nanipets.com.co
        </div>
        <div>
            <img src="../img/logo.png" alt="" width="70px" height="70px">
        </div>
    </footer>
</body>

</html>