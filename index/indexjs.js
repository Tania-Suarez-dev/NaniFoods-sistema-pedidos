let slider = document.querySelector('.sliderInterno');
let index = 0;

function slideIzq() {
    index--;
    let porcentajeizq = index * -100;
    slider.style.transform = "translateX(" + porcentajeizq + "vw)";
}

function slideDer() {
    index++
    if (index > 2) {
        index = 0;
        slider.style.transform = "translateX(0vw)";
    }
    let porcentaje = index * -100;
    slider.style.transform = "translateX(" + porcentaje + "vw)";
}
setInterval(slideDer, 8000);

document.getElementById("sliderDerecha").onclick = function () {
    if (index < 2) {
        slideDer();
    }
};

document.getElementById("sliderIzquierda").onclick = function () {
    if (index > 0) {
        slideIzq();
    }
};