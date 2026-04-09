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

function confirmarPedido(e) {
    e.preventDefault();

    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    if (carrito.length === 0) {
        alert("Tu carrito está vacío.");
        return;
    }

    const direccion = document.getElementById("direccion").value.trim();
    const metodo_pago = document.getElementById("metodo-pago").value;
    const observaciones = document.getElementById("observaciones").value.trim();

    if (!direccion || !metodo_pago) {
        alert("Por favor completa la dirección y el método de pago.");
        return;
    }

    const datos = { carrito, direccion, metodo_pago, observaciones };


    console.log("Enviando al servidor:", datos);

    fetch("procesarpedido.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(datos)
    })
    .then(async res => {
        const texto = await res.text(); 
        console.log(" Respuesta cruda del servidor:", texto);

        let data;
        try {
            data = JSON.parse(texto);
        } catch (err) {
            console.error(" Error al parsear JSON:", err);
            alert("Error inesperado en la respuesta del servidor. Revisa la consola.");
            return;
        }

        console.log(" Respuesta interpretada:", data);

        if (data.success) {
            localStorage.removeItem("carrito");
            alert("Pedido confirmado correctamente!");
            window.location.href = "productos.php";
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(err => {
        console.error(" Error de conexión o fetch:", err);
        alert("Ocurrió un error al procesar el pedido. Revisa la consola (F12).");
    });
}

window.addEventListener("DOMContentLoaded", () => {
    mostrarCarritoCheckout();
    const boton = document.getElementById("confirmar-pedido");
    boton.replaceWith(boton.cloneNode(true)); 
    document.getElementById("confirmar-pedido").addEventListener("click", confirmarPedido);
});
