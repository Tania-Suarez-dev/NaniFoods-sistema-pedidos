
async function cargarProductos() {
  const res = await fetch("infoproductos.php"); // <-- devuelve JSON
  const data = await res.json();

  const contenedor = document.getElementById("productos");
  contenedor.innerHTML = "";

  data.forEach(producto => {
    const card = document.createElement("div");
    card.className = "card col-lg-3 col-md-3 col-sm-4 col-xs-6 m-2";
    card.innerHTML = `
      <img class="card-img-top" src="${producto.imagen}" alt="...">
      <div class="card-body">
        <p class="card-text">${producto.nombre}</p>
        <p class="card-text">$ ${producto.precio}</p>
        <p class="card-text">${producto.descripcion}</p>
      </div>
    `;
    card.addEventListener("click", () => abrirModal(producto));
    contenedor.appendChild(card);
  });
}

function abrirModal(producto) {
  document.getElementById("modal-dialog").innerHTML = modalContent(producto);
  const modal = new bootstrap.Modal(document.getElementById("modal"));
  modal.show();
}

cargarProductos();
