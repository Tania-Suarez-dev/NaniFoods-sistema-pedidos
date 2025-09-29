<?php
require_once 'crud.php';
require_once("../constants.php");
$data = all();
$data = json_encode($data);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>📝 Registro</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
    crossorigin="anonymous">
</head>

<body class="p-4">
  <button type="button" class="btn btn-dark mb-4" onclick="abrirModal()">
    Agregar Producto
  </button>
  <div class="modal fade" id="modalProductos" tabindex="-1" aria-labelledby="modalProductosLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalProductosLabel">Agregar Producto</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form id="product-form" action="crud.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="product-id" name="id">
            <div class="mb-3">
              <input placeholder="Nombre del producto" type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
              <input placeholder="Precio del producto" type="number" step="0.01" class="form-control" id="precio" name="precio" required>
            </div>
            <div class="mb-3">
              <textarea placeholder="Descripción del producto" class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="mb-3">
              <input placeholder="Categoría del producto" type="text" class="form-control" id="categoria" name="categoria" required>
            </div>

            <div class="mb-3">
              <label for=" imagen" class="form-label">Imagen del producto</label>
              <input type="file" class="form-control" id="imagen" name="imagen">
              <div id="imagen-contenedor" class="d-none w-100 text-center">
                <img id="imagen-actual" class="py-2" src="" width="200" alt="Imagen actual">
                <small class="d-block">Si no seleccionás nada, se mantiene la imagen actual</small>
              </div>
            </div>
            <button type=" submit" class="btn btn-primary">Guardar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- modal detalle -->
  <div class="modal modal-lg fade" id="modalDetalle" tabindex="-1" aria-labelledby="modalDetalleLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalDetalleLabel">Detalle del Producto</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
      </div>
    </div>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">codigo</i></th>
        <th scope="col">nombre</th>
        <th scope="col">precio</th>
        <th scope="col">categoria</th>
        <th scope="col">estrellas</th>
        <th scope="col">Activo</th>
        <th scope="col">ver</th>
        <th scope="col">editar</th>
        <th scope="col">eliminar</th>
      </tr>
    </thead>
    <tbody id="tabla">
    </tbody>
  </table>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
    crossorigin="anonymous"></script>
  <script>
    const data = <?php echo $data; ?>; // traemos los datos de PHP como JS array
    const BASE_URL = "<?= $BASE_URL ?>";
    const tbody = document.getElementById("tabla");

    for (let i = 0; i < data.length; i++) {
      let fila = document.createElement("tr");
      //TODO: HACER FUNCIONAL EL CHECKBOX DE ACTIVO

      fila.innerHTML = `
        <td>${data[i].codigo}</td>
        <td>${data[i].nombre}</td>
        <td>${data[i].precio}</td>
        <td>${data[i].categoria}</td>
        <td>${data[i].estrellas ?? 'Sin calificación'}</td>
        <td><input type="checkbox" ${data[i].activo === '1' ? 'checked' : ''} disabled></td>
        <td><button class='btn btn-outline-info' onclick="verDetalle(${data[i].codigo})">Info</button></td>
        <td><button class='btn btn-outline-warning' onclick="editarProducto(${data[i].codigo})">Editar</button></td>
        <td>
        <button class='btn btn-outline-danger' onclick="eliminarProducto(${data[i].codigo})">Eliminar</button></td>
    `;
      tbody.appendChild(fila);

      function editarProducto(id) {
        const product = data.find(p => p.codigo === String(id));

        const modal = new bootstrap.Modal(document.getElementById('modalProductos'));
        document.getElementById('nombre').value = product.nombre;
        document.getElementById('precio').value = product.precio;
        document.getElementById('descripcion').value = product.descripcion;
        document.getElementById('categoria').value = product.categoria;
        document.getElementById('imagen-actual').src = `${BASE_URL}${product.imagen}`;
        document.getElementById('imagen-contenedor').classList.remove('d-none');
        document.getElementById('product-id').value = product.codigo;

        document.getElementById('modalProductosLabel').innerText = 'Editar Producto';
        modal.show();

      }
    }

    function abrirModal() {
      const modal = new bootstrap.Modal(document.getElementById('modalProductos'));
      document.getElementById('product-form').reset();
      document.getElementById('imagen-contenedor').classList.add('d-none');
      document.getElementById('product-id').value = '';
      document.getElementById('modalProductosLabel').innerText = 'Agregar Producto';
      modal.show();
    }

    function eliminarProducto(id) {
      if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
        window.location.href = `crud.php?id=${id}`;
      }
    }

    function verDetalle(id) {
      const product = data.find(p => p.codigo === String(id));
      const modal = new bootstrap.Modal(document.getElementById('modalDetalle'));
      const modalBody = document.querySelector('#modalDetalle .modal-body');
      modalBody.innerHTML = `
       <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white text-center">
          <h4 class="mb-0">${product.nombre}</h4>
        </div>
        <div class="card-body">
          <div class="text-center mb-3">
            <img src="${BASE_URL}${product.imagen}" 
                alt="${product.nombre}" 
                class="img-fluid rounded" 
                style="max-height: 200px; object-fit: contain;">
          </div>
          <p><strong>💰 Precio:</strong> $${product.precio}</p>
          <p><strong>📂 Categoría:</strong> ${product.categoria}</p>
          <p><strong>📝 Descripción:</strong><br>${product.descripcion}</p>
          <p><strong>⭐ Estrellas:</strong> ${product.estrellas ?? 'Sin calificación'}</p>
          <p><strong>⚡ Activo:</strong> 
            <span class="badge ${product.activo === '1' ? 'bg-success' : 'bg-danger'}">
              ${product.activo === '1' ? 'Sí' : 'No'}
            </span>
          </p>
        </div>
      </div>
      `;
      modal.show();
    }
  </script>


</body>

</html>