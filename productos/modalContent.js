
export function modalContent(product) {
  return `
    <div class="modal-content">
      <div class="modal-header">
          <h1 class="modal-title fs-5">${product.nombre}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modal-product-content">
          <div class="row">
              <div id="modal-product-image" class="col">
                <img src="${product.imagen}" alt="${product.nombre}" class="img-fluid rounded" style="max-height:300px; object-fit:cover;">
              </div>
              <div id="modal-product-description" class="col">
                <h1>${product.nombre}</h1>
                <p>${product.descripcion}</p>
                <p>Precio: ${product.precio}</p>
              </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          ${addToCartComponent()}
      </div>
    </div>
    `;
}

window.modalContent = modalContent;
