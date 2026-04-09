import { addToCartComponent } from "./addToCartComponent.js";
import { modalContent } from "./modalContent.js";

async function cargarProductos(filtros = {}) {

  const params = new URLSearchParams(filtros);
  const res = await fetch("infoproductos.php?" + params.toString());
  const data = await res.json();

  console.log("Array recibido desde PHP:", data);

  const contenedor = document.getElementById("productos");
  contenedor.innerHTML = "";

  data.forEach(producto => {
    const card = document.createElement("div");

    card.className = "card col-lg-3 col-md-3 col-sm-4 col-xs-6 m-3 align-self-stretch";
    card.style.width = "18rem";
    card.style.cursor = "pointer";
    card.innerHTML = `
      <img class="card-img-top img-fixed" src="${producto.imagen}" alt="...">
      <div class="card-body">
          <h5 class="card-title">${producto.nombre}</h5>
        <p class="card-text multiline-truncate">${producto.descripcion}</p>
        <small class="text-muted d-flex justify-content-center mb-2">Precio: $${producto.precio}</small>
        ${addToCartComponent(producto, false)}
        </div>
    `
    card.addEventListener("click", () => abrirModal(producto));
    contenedor.appendChild(card);
  });
}

function abrirModal(producto) {
  document.getElementById("modal-dialog").innerHTML = modalContent(producto);
  const modal = new bootstrap.Modal(document.getElementById("modal"));
  modal.show();
}

document.getElementById("filtros").addEventListener("submit", (e) => {
  e.preventDefault();

  cargarProductos({
    search: document.querySelector('input[name="search"]').value,
    categoria: document.querySelector('select[name="categoria"]').value,
    estrellas: document.querySelector('select[name="estrellas"]').value,
    precio_min: document.querySelector('input[name="precio_min"]').value,
    precio_max: document.querySelector('input[name="precio_max"]').value
  });
});

cargarProductos();
