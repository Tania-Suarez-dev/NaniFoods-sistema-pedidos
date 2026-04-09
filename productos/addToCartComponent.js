export function addToCartComponent(product, isModal = false) {
  let num = 1;

  window.handleCounter = (count, id) => {
    num = Math.max(1, num + count);
    document.getElementById(`product-count-${id}`).innerText = num;
  };

  window.addToCart = (event, id) => {
    event.stopPropagation();
    let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    let existente = carrito.find(item => item.id === id);

    
    if (existente) {
      existente.cantidad += num;
    } else {
      carrito.push({
        id: id,
        codigo: product.codigo,
        nombre: product.nombre,
        precio: Number(product.precio),
        imagen: product.imagen,
        cantidad: num
      });
    }

    console.log("Carrito actualizado:", carrito);
    localStorage.setItem("carrito", JSON.stringify(carrito));
    actualizarIconoCarrito();

    let modalElement = document.getElementById("modal");
    let modalInstance = bootstrap.Modal.getInstance(modalElement);
    if (modalInstance) modalInstance.hide();

    num = 1;
  };

  return `
    <div class="d-flex gap-2 ${isModal ? 'justify-content-between' : 'justify-content-center'} align-items-center">
      ${isModal ? `
      <button type="button" class="btn btn-sm btn-warning" onclick="handleCounter(-1, ${product.id})">-</button>
      <div class="m-auto" id="product-count-${product.id}">
          ${num}
      </div>
      <button type="button" class="btn btn-sm btn-warning" onclick="handleCounter(1, ${product.id})">+</button>
      ` : ''}

      <button type="button" class="btn btn-sm btn-warning" onclick="addToCart(event,${product.id})">
        <i class="bi bi-cart"></i> Agregar al carrito
      </button>
    </div>
  `;
}

window.addToCartComponent = addToCartComponent;
