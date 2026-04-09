<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    http_response_code(403);
    exit('⛔ Acceso denegado. Solo el administrador puede ver este panel.');
}

require_once("../utils/header.php");
require_once("../utils/footer.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Panel - NaniFoods</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../index/estiloindex.css">
  <style>
    .card-highlight {
      color: #000;
    }
  </style>
</head>
<body style="background-color: var(--color5);">

<?php showheader(); ?>

<main class="container my-5">
  <h1 class="mb-4 display-6"><i class="bi bi-bar-chart-line-fill"></i> Panel de administración</h1>

  <div class="row g-3 mb-4 justify-content-center text-center" id="cards-container">
  </div>

  <div class="row g-3">
    <div class="col-12 col-lg-7">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-graph-up"></i> Ventas últimos 7 días</h5>
          <canvas id="salesChart" height="120"></canvas>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title"><i class="bi bi-box-seam"></i> Productos más vendidos (30d)</h5>
          <ul class="list-group" id="popular-products">
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="card shadow-sm mt-4">
    <div class="card-body">
      <h5 class="card-title"><i class="bi bi-receipt"></i> Últimos pedidos</h5>
      <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Precio Total</th>
              <th>Fecha</th>
              <th>Estado</th>
              <th>Dirección</th>
              <th>Método de Pago</th>
              <th>Observaciones</th>
              <th>ID Cliente</th>
              <th>ID Repartidor</th>
            </tr>
          </thead>
          <tbody id="orders-tbody">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

  <?php
  showfooter();
  ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
(async function(){
  try {
    const res = await fetch('infopanel.php');
    if (!res.ok) throw new Error('Error al pedir datos: ' + res.status);
    const data = await res.json();

    const root = getComputedStyle(document.documentElement);
    const color2 = root.getPropertyValue('--color2').trim() || 'rgb(255,176,1)';

    const cards = [
      {emoji: '🕒', title: 'Pedidos pendientes', value: data.pedidos_pendientes},
      {emoji: '📦', title: 'Pedidos hoy', value: data.pedidos_hoy},
      {emoji: '⭐', title: 'Reseñas nuevas (hoy)', value: data.resenas_hoy},
      {emoji: '💰', title: 'Ventas (últimos 7 días)', value: '$' + new Intl.NumberFormat().format(data.ventas_semana)},
      {emoji: '🧁', title: 'Productos más vendidos', value: data.productos_populares.length ? data.productos_populares[0].nombre + ' ('+data.productos_populares[0].vendido+')' : 'N/A'}
    ];

    const container = document.getElementById('cards-container');
    cards.forEach(c => {
      const col = document.createElement('div');
      col.className = 'col-12 col-sm-6 col-md-4 col-lg-2';
      col.innerHTML = `
        <div class="card card-highlight text-center h-100" style="background-color: var(--color2);">
          <div class="card-body">
            <div style="font-size:1.8rem">${c.emoji}</div>
            <h6 class="mt-2">${c.title}</h6>
            <h4 class="fw-bold">${c.value}</h4>
          </div>
        </div>
      `;
      container.appendChild(col);
    });

    const list = document.getElementById('popular-products');
    if (data.productos_populares.length === 0) {
      const li = document.createElement('li');
      li.className = 'list-group-item';
      li.textContent = 'No hay datos';
      list.appendChild(li);
    } else {
      data.productos_populares.forEach(p => {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.innerHTML = `<span>${p.nombre}</span><span class="badge bg-warning text-dark">${p.vendido}</span>`;
        list.appendChild(li);
      });
    }

    const tbody = document.getElementById('orders-tbody');
    if (data.ultimos_pedidos.length === 0) {
      const tr = document.createElement('tr');
      tr.innerHTML = `<td colspan="9" class="text-center small text-muted">No hay pedidos recientes</td>`;
      tbody.appendChild(tr);
    } else {
      data.ultimos_pedidos.forEach(o => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${o.id}</td>
          <td>$${new Intl.NumberFormat().format(o.preciototal)}</td>
          <td>${o.fecha}</td>
          <td>${o.estado}</td>
          <td>${o.direccion ?? ''}</td>
          <td>${o.metodo_pago ?? ''}</td>
          <td>${o.observaciones ?? ''}</td>
          <td>${o.id_cliente ?? ''}</td>
          <td>${o.id_repartidor ?? ''}</td>
        `;
        tbody.appendChild(tr);
      });
    }

    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: data.grafica.fechas,
        datasets: [{
          label: 'Ventas (COP)',
          data: data.grafica.valores,
          backgroundColor: color2,
          borderRadius: 6
        }]
      },
      options: {
        scales: {
          y: { beginAtZero: true }
        },
        plugins: {
          legend: { display: false }
        }
      }
    });

  } catch (err) {
    console.error(err);
    const main = document.querySelector('main');
    const alert = document.createElement('div');
    alert.className = 'alert alert-danger mt-3';
    alert.textContent = 'No se pudieron cargar los datos del panel. Revisa la consola.';
    main.prepend(alert);
  }
})();
</script>
</body>
</html>
