<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NaniFoods</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../index/estiloindex.css">
    <link rel="stylesheet" href="estiloagregarpro.css">
    <link rel="icon" href="../img/favicon.png">
</head>

<body>
    <header>
        <div class="logo">
            <img src="../img/logo.png" alt="" class="logo">
        </div>
        <div class="navegador">
            <ul>
                <li><a id="inicio" class="nav-items" href="../index/index.php">Inicio</a></li>
                <li><a class="nav-items" href="../productos/productos.php">Carta</a></li>
                <li><a class="nav-items" href="">Descuentos</a></li>
                <li><a class="nav-items" href="">Domicilios</a></li>
                <li><a class="nav-items" href="../reseñas/reseñas.php">Reseñas</a></li>
                <li><a class="nav-items" href="../acerca/acerca.php">Acerca de</a></li>
                <li><a class="nav-items" href="../agregarproductos/agregarproductos.php">Agregar Producto</a></li>
            </ul>
        </div>
        <div class="boton">
            <button class="vinculo" onclick="location.href='../login/login.php'">
                <img src="../img/testp.png" class="perfil">
            </button>
        </div>
    </header>


   <section class="principalagregarpro">
    <div class="card cajaagregarpro">
        <div class="card-body">
            <div class="tituloagregarpro">
                <h1>Agrega un producto al menú</h1>
            </div>

            <form action="infoproducto.php" method="POST" enctype="multipart/form-data">
                <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                    <div class="alert alert-success text-center">
                        Producto agregado correctamente
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="categoriapro" class="form-label">Ingresa la categoría del producto</label>
                    <input type="text" id="categoriapro" name="categoria" class="form-control" placeholder="Categoría producto" required>
                </div>

                <div class="mb-3">
                    <label for="nombrepro" class="form-label">Ingresa el nombre del producto</label>
                    <input type="text" id="nombrepro" name="nombre" class="form-control" placeholder="Nombre producto" required>
                </div>

                <div class="mb-3">
                    <label for="descripcionpro" class="form-label">Ingresa una descripción del producto</label>
                    <input type="text" id="descripcionpro" name="descripcion" class="form-control" placeholder="Descripción del producto" required>
                </div>

                <div class="mb-3">
                    <label for="preciopro" class="form-label">Ingresa el precio del producto</label>
                    <input type="text" id="preciopro" name="precio" class="form-control" placeholder="Precio producto" required>
                </div>

                <div class="mb-3">
                    <label for="imgpro" class="form-label">Ingresa una imagen del producto</label>
                    <input type="file" id="imgpro" name="imagen" class="form-control" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn botoncuestionario">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</section>


    <footer class="d-flex justify-content-around align-items-center p-3 bg-dark text-white">
        <div>
            <img src="../img/wsp.png" alt="" width="50px" height="50px">
            <img src="../img/fb.png" alt="" width="48px" height="48px">
        </div>
        <div class="flink">
            www.naniFoods.com.co
        </div>
        <div>
            <img src="../img/logo.png" alt="" width="70px" height="70px">
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

