<?php
require_once 'crud_pedidos.php';
require_once("../constants.php"); 
$data = all_pedidos();
$data = json_encode($data);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>📦 Pedidos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
    crossorigin="anonymous">
</head>


  <div class="modal fade" id="modalPedido" tabindex="-1" aria-labelledby="modalPedidoLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalPedidoLabel">Agregar Pedido</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">

          <form id="pedido-form" action="crud_pedidos.php" method="POST">
            <input type="hidden" id="pedido-id" name="id">
            <input type="hidden" name="action" value="save">
            <div class="mb-3">
              <label class="form-label">Cliente (ID)</label>
              <input placeholder="ID cliente" type="number" class="form-control" id="id_cliente" name="id_cliente" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Fecha</label>
              <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Hora</label>
              <input type="time" class="form-control" id="hora" name="hora" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Estado</label>
              <select class="form-select" id="estado" name="estado" required>
                <option value="pendiente">pendiente</option>
                <option value="en_proceso">en_proceso</option>
                <option value="entregado">entregado</option>
                <option value="cancelado">cancelado</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Dirección</label>
              <input placeholder="Dirección" type="text" class="form-control" id="direccion" name="direccion">
            </div>

            <div class="mb-3">
              <label class="form-label">Método de pago</label>
              <input placeholder="Efectivo / Tarjeta / Nequi" type="text" class="form-control" id="metodo_pago" name="metodo_pago">
            </div>

            <div class="mb-3">
              <label class="form-label">ID Repartidor</label>
              <input placeholder="ID repartidor (opcional)" type="number" class="form-control" id="id_repartidor" name="id_repartidor">
            </div>

            <div class="mb-3">
              <label class="form-label">Observaciones</label>
              <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
            </div>

            <small class="text-muted d-block mb-2">Nota: El precio total no puede establecerse desde aquí.</small>

            <button type="submit" class="btn btn-primary">Guardar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal modal-lg fade" id="modalDetalle" tabindex="-1" aria-labelledby="modalDetalleLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalDetalleLabel">Detalle del Pedido</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">cliente</th>
        <th scope="col">fecha</th>
        <th scope="col">hora</th>
        <th scope="col">total</th>
        <th scope="col">estado</th>
        <th scope="col">direccion</th>
        <th scope="col">metodo_pago</th>
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
    const data = <?php echo $data; ?>;
    const tbody = document.getElementById("tabla");

    for (let i = 0; i < data.length; i++) {
      let fila = document.createElement("tr");

      fila.innerHTML = `
        <td>${data[i].id}</td>
        <td>${data[i].cliente ?? (data[i].id_cliente ?? '')}</td>
        <td>${data[i].fecha ?? ''}</td>
        <td>${data[i].hora ?? ''}</td>
        <td>$${(data[i].preciototal ?? 0).toLocaleString()}</td>
        <td>${data[i].estado ?? ''}</td>
        <td>${data[i].direccion ?? ''}</td>
        <td>${data[i].metodo_pago ?? ''}</td>
        <td><button class='btn btn-outline-info' onclick="verDetalle(${data[i].id})">Info</button></td>
        <td><button class='btn btn-outline-warning' onclick="editarPedido(${data[i].id})">Editar</button></td>
        <td><button class='btn btn-outline-danger' onclick="eliminarPedido(${data[i].id})">Eliminar</button></td>
      `;
      tbody.appendChild(fila);


      function editarPedido(id) {
        const pedido = data.find(p => String(p.id) === String(id));
        const modal = new bootstrap.Modal(document.getElementById('modalPedido'));
        document.getElementById('pedido-id').value = pedido.id;
        document.getElementById('id_cliente').value = pedido.id_cliente ?? '';
        document.getElementById('fecha').value = pedido.fecha ?? '';
        document.getElementById('hora').value = pedido.hora ?? '';
        document.getElementById('estado').value = pedido.estado ?? 'pendiente';
        document.getElementById('direccion').value = pedido.direccion ?? '';
        document.getElementById('metodo_pago').value = pedido.metodo_pago ?? '';
        document.getElementById('id_repartidor').value = pedido.id_repartidor ?? '';
        document.getElementById('observaciones').value = pedido.observaciones ?? '';
        document.getElementById('modalPedidoLabel').innerText = 'Editar Pedido';
        modal.show();
      }

    }


function eliminarPedido(id) {
  if (confirm("¿Estás seguro de que deseas eliminar este pedido?")) {
    window.location.href = `crud_pedidos.php?delete_id=${id}`;
  }
}


    function verDetalle(id) {
      const pedido = data.find(p => String(p.id) === String(id));
      const modal = new bootstrap.Modal(document.getElementById('modalDetalle'));
      const modalBody = document.querySelector('#modalDetalle .modal-body');

      let html = `
        <div class="card shadow-sm border-0">
          <div class="card-header bg-dark text-white text-center">
            <h4 class="mb-0">Pedido #${pedido.id}</h4>
          </div>
          <div class="card-body">
            <p><strong>Cliente:</strong> ${pedido.cliente ?? pedido.id_cliente ?? ''}</p>
            <p><strong>Fecha:</strong> ${pedido.fecha ?? ''} <strong>Hora:</strong> ${pedido.hora ?? ''}</p>
            <p><strong>Total:</strong> $${(pedido.preciototal ?? 0).toLocaleString()}</p>
            <p><strong>Estado:</strong> ${pedido.estado ?? ''}</p>
            <p><strong>Dirección:</strong> ${pedido.direccion ?? ''}</p>
            <p><strong>Método de pago:</strong> ${pedido.metodo_pago ?? ''}</p>
            <p><strong>Observaciones:</strong> ${pedido.observaciones ?? ''}</p>
            <hr>
            <h5>Productos</h5>
      `;

      if (pedido.detalles && pedido.detalles.length) {
        html += `<ul class="list-group">`;
        pedido.detalles.forEach(d => {
          html += `<li class="list-group-item">
            <strong>${d.nombre ?? ('#' + d.id_producto)}</strong>
            — Cant: ${d.cantidad} — Unit: $${(d.precio_unitario ?? 0).toLocaleString()} — Subtotal: $${((d.precio_unitario ?? 0) * (d.cantidad ?? 0)).toLocaleString()}
          </li>`;
        });
        html += `</ul>`;
      } else {
        html += `<p class="text-muted">No hay detalles registrados para este pedido.</p>`;
      }

      html += `
          </div>
        </div>
      `;
      modalBody.innerHTML = html;
      modal.show();
    }
  </script>

</body>

</html>
