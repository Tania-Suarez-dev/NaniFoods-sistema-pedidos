export function addToCartComponent() {
  let num = 0;
  window.handleCounter = (count) => {
    num += count;
    document.getElementById("product-count").innerText = num;
  };

  window.addToCart = () => {
    alert(`${sessionStorage.getItem("id")} ha agregado ${num} productos al carrito`);
  }
  return `
      <button type="button" class="btn btn-warning" onclick="handleCounter(-1)">-</button>
      <div id="product-count">
          ${num}
      </div>
      <button type="button" class="btn btn-warning" onclick="handleCounter(1)">+</button>

      <button type="button" class="btn btn-warning" onclick="addToCart()"><i class="bi bi-cart"></i>Agregar al carrito</button>
    `;
}
window.addToCartComponent = addToCartComponent;