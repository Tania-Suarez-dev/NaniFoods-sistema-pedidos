<?php
session_start();

// Si no hay sesión
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

// Si el rol no es admin
if ($_SESSION["rol"] !== "admin") {
    header("Location: index.php");
    exit();
}
$host = "localhost";
$usuario = "root";
$bd = "nanifoods";
$conexion = new mysqli("$host", "$usuario", "", "$bd");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");
$sql = "select P.*, r.estrellas 
FROM productos as p 
LEFT JOIN detalles_pedidos as d on p.codigo = d.id_producto 
LEFT JOIN resena as r on d.id = r.id_detalles_pedido ";
$resultado = $conexion->query($sql) or die("Error en la consulta: " . $conexion->error);

$data = [];
if ($resultado && $resultado->num_rows > 0) {
    $data = $resultado->fetch_all(MYSQLI_ASSOC);
}
$totalfilas = $resultado->num_rows;
$jsonData = json_encode($data);
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

  <button type="button" class="btn btn-dark mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Registrarse
  </button>

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">REGISTRO</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <form id="formularioRegistro">

            <select class="form-select mb-3" id="tipoIdentificacion">
              <option value="Cédula">Cédula</option>
              <option value="Tarjeta de identidad">Tarjeta de identidad</option>
              <option value="Pasaporte">Pasaporte</option>
              <option value="PEP">PEP</option>
            </select>

            <input type="number" class="form-control mb-3" id="numeroIdentificacion" placeholder="Número de identificación">
            <input type="text" class="form-control mb-3" id="nombres" placeholder="Nombres completos">
            <input type="email" class="form-control mb-3" id="correo" placeholder="Correo electrónico">
            <input type="password" class="form-control mb-3" id="contrasena" placeholder="Contraseña">
            <input type="date" class="form-control mb-3" id="fechaNacimiento">

            <label class="form-label">Género</label>
            <div class="mb-3">
              <input type="radio" class="form-check-input me-2" name="genero" value="Masculino" checked> Masculino
              <input type="radio" class="form-check-input ms-4 me-2" name="genero" value="Femenino"> Femenino
              <input type="radio" class="form-check-input ms-4 me-2" name="genero" value="Otro"> Otro
            </div>

            <label for="colorFavorito" class="form-label">Color favorito</label>
            <input type="color" class="form-control form-control-color mb-3" id="colorFavorito" value="#c72261">

            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control mb-3" id="foto">

            <textarea class="form-control mb-3" id="hobbies" placeholder="Hobbies" rows="3"></textarea>

            <button type="submit" class="btn btn-dark">Enviar</button>
          </form>
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
      <th scope="col">descripcion</th>
      <th scope="col">categoria</th>
      <th scope="col">imagen</th>
      <th scope="col">estrellas</th>
      <th scope="col">ver</th>
      <th scope="col">editar</th>
      <th scope="col">eliminar</th>
    </tr>
  </thead>
  <tbody id="tablaProductos">
  </tbody>
</table>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
    crossorigin="anonymous"></script>
<script>
const data = <?php echo $jsonData; ?>; // traemos los datos de PHP como JS array
const tbody = document.getElementById("tablaProductos");

for (let i = 0; i < data.length; i++) {
    let fila = document.createElement("tr");

    fila.innerHTML = `
        <td>${data[i].codigo}</td>
        <td>${data[i].nombre}</td>
        <td>${data[i].precio}</td>
        <td>${data[i].descripcion}</td>
        <td>${data[i].categoria}</td>
        <td><img src='./NaniFoods/${data[i].imagen}' width='50' alt='Imagen'></td>
        <td>${data[i].estrellas ?? 'Sin calificación'}</td>
        <td><button class='btn btn-outline-info'>Info</button></td>
        <td><button class='btn btn-outline-warning'>Editar</button></td>
        <td><button class='btn btn-outline-danger'>Eliminar</button></td>
    `;
    tbody.appendChild(fila);
} </script>
  <script>
    bootstrap.Modal.getInstance(document.getElementById("exampleModal")).hide();
  </script>
</body>
</html>
