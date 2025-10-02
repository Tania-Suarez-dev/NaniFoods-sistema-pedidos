function actualizarIconoCarrito() {
  let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
  let total = carrito.reduce((sum, p) => sum + p.cantidad, 0);
  document.getElementById("carrito-count").innerText = total;
}

function abrirCarrito() {
  let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
  let body = document.getElementById("carrito-body");

  if (carrito.length === 0) {
    body.innerHTML = "<p>Tu carrito está vacío 🛒</p>";
    return;
  }

  body.innerHTML = `
    <div class="row">
      ${carrito.map(p => `
        <div class="col-12 mb-3">
          <div class="card shadow-sm">
            <div class="row g-0 align-items-center">
              <div class="col-3">
                <img src="${p.imagen}" class="img-fluid rounded-start" alt="${p.nombre}">
              </div>
              <div class="col-6">
                <div class="card-body py-2">
                  <h5 class="card-title mb-1">${p.nombre}</h5>
                  <p class="mb-1">Precio: $${Number(p.precio).toLocaleString()}</p>
                  <p class="mb-1">Cantidad: ${p.cantidad}</p>
                  <p class="fw-bold">Subtotal: $${(Number(p.precio) * p.cantidad).toLocaleString()}</p>
                </div>
              </div>
              <div class="col-3 text-end pe-3">
                <button class="btn btn-sm btn-danger" onclick="eliminarDelCarrito(${p.id})">
                  <i class="bi bi-trash"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      `).join("")}
    </div>
  `;
}

function eliminarDelCarrito(identificadorProducto) {
  let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
  let nuevoCarrito = carrito.filter(producto => producto.id !== identificadorProducto);

  localStorage.setItem("carrito", JSON.stringify(nuevoCarrito));
  actualizarIconoCarrito();
  abrirCarrito();
}

window.irAPagar = function () {
  const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasCarrito'));
  if (offcanvas) offcanvas.hide();

  setTimeout(() => {
    window.location.href = "checkout.php"; 
  }, 300);
};

window.actualizarIconoCarrito = actualizarIconoCarrito;
window.abrirCarrito = abrirCarrito;
window.eliminarDelCarrito = eliminarDelCarrito;

window.addEventListener("DOMContentLoaded", actualizarIconoCarrito);
