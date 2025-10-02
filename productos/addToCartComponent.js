export function addToCartComponent(product) {
  let num = 1;

  window.handleCounter = (count, id) => {
    num = Math.max(1, num + count);
    document.getElementById(`product-count-${id}`).innerText = num;
  };

  window.addToCart = (id) => {
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
      <button type="button" class="btn btn-warning" onclick="handleCounter(-1, ${product.id})">-</button>
      <div id="product-count-${product.id}">
          ${num}
      </div>
      <button type="button" class="btn btn-warning" onclick="handleCounter(1, ${product.id})">+</button>

      <button type="button" class="btn btn-warning" onclick="addToCart(${product.id})">
        <i class="bi bi-cart"></i>Agregar al carrito
      </button>
  `;
}

window.addToCartComponent = addToCartComponent;
