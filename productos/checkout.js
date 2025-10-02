function mostrarCarritoCheckout() {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    let carritoDiv = document.getElementById("carrito-checkout");
    carritoDiv.innerHTML = "";

    if (carrito.length === 0) {
        carritoDiv.innerHTML = "<p class='text-center'>Tu carrito está vacío 🛒</p>";
        return;
    }

    let total = 0;
    let html = "";

    carrito.forEach(producto => {
        let subtotal = producto.precio * producto.cantidad;
        total += subtotal;

        html += `
            <div class="product-card p-3">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <img src="${producto.imagen}" class="img-fluid" alt="${producto.nombre}">
                    </div>
                    <div class="col-md-9">
                        <h5>${producto.nombre}</h5>
                        <p>Precio unitario: $${producto.precio.toLocaleString()}</p>
                        <p>Cantidad: ${producto.cantidad}</p>
                        <p>Subtotal: $${subtotal.toLocaleString()}</p>
                    </div>
                </div>
            </div>
        `;
    });

    carritoDiv.innerHTML = html;
    document.getElementById("total-carrito").innerText = total.toLocaleString();
}

function confirmarPedido() {
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    if (carrito.length === 0) {
        alert("Tu carrito está vacío.");
        return;
    }

    fetch("procesarPedido.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ carrito })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            localStorage.removeItem("carrito");
            alert("Pedido confirmado correctamente!");
            window.location.href = "productos.php";
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(err => console.error(err));
}

window.addEventListener("DOMContentLoaded", mostrarCarritoCheckout);
document.getElementById("confirmar-pedido").addEventListener("click", confirmarPedido);
