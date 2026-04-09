<?php
session_start();
require_once("../utils/header.php");
require_once("../utils/footer.php");

showheader()
?>
<section class="principal">
    <div class="slider">

        <button id="sliderIzquierda" class="slide">
            <i class='bx bx-chevron-left flecha'></i>
        </button>
        <div class="sliderInterno">
            <img src="../img/test1.2.jpg" alt="">
            <img src="../img/test2.jpg" alt="">
            <img src="../img/test3.jpg" alt="">
        </div>
        <button id="sliderDerecha" class="slide">
            <i class='bx bx-chevron-right flecha'></i>
        </button>
    </div>
</section>
<?php
showfooter();
?>
<script src="./indexjs.js"></script>
</body>

</html>