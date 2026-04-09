<?php
session_start();
require_once("../utils/header.php");
require_once("../utils/footer.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reportes - NaniFoods</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../index/estiloindex.css">
</head>

<body style="background-color: var(--color5);">

  <?php showheader(); ?>


  <main class="min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold text-warning">📊 Reportes Administrativos</h2>
        <div class="title-line mx-auto mb-3"></div>
        <p class="text-light">Consulta o descarga los reportes en formato Excel</p>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card card-reportes shadow-lg border-0 p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
              <div class="text-center text-md-start mb-3 mb-md-0">
                <h5 class="fw-bold text-warning mb-1">📦 Reporte de Pedidos</h5>
                <p class="text-light mb-0">Descarga todos los pedidos realizados con sus detalles.</p>
              </div>
              <form action="exportar_reporte.php" method="POST" target="_blank">
                <button type="submit" class="btn btn-excel px-4 py-2">
                  <i class="bi bi-file-earmark-excel-fill me-2"></i> Exportar Excel
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php showfooter(); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
