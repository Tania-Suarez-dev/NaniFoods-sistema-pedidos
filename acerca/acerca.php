<?php
require_once("../utils/header.php");
require_once("../utils/footer.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="../img/favicon.png">
    <link rel="stylesheet" href="../index/estiloindex.css">
    <link rel="stylesheet" href="estilosAcerca.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NaniFoods</title>
</head>

<body>
    <?php
    showheader()
    ?>
    <section class="principalAcerca">
        <div class="card" style="width: 18rem;">
            <img src="../img/perfiles_acerca.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Brayan Reyes</h5>
                <p class="card-text">Líder estratégico con enfoque en gestión empresarial y toma de decisiones. Apasionado por la innovación y el crecimiento.</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">director ejecutivo</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">Contacto</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="../img/perfiles_acerca.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Hamilton Soriano</h5>
                <p class="card-text">Apasionado por transformar ideas en experiencias impactantes mediante la combinación de arte, tecnología y estrategia</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">director tecnico de creatividad</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">Contacto</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="../img/perfiles_acerca.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Tania Suarez</h5>
                <p class="card-text">Liderando la planificación y ejecución estratégica para el crecimiento y desarrollo eficiente de la empresa</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">jefe de operaciones de desarrollo</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">Contacto</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="../img/perfiles_acerca.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Laura Escarraga</h5>
                <p class="card-text">Comprometida con la excelencia visual y la innovación para fortalecer la identidad y presencia de la empresa</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">directora de diseño grafico</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">Contacto</a>
            </div>
        </div>
    </section>
    <?php
    showfooter();
    ?>
</body>

</html>