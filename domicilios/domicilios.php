<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento de tu pedido</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { height: 500px; width: 100%; }
        body { font-family: Arial, sans-serif; margin: 20px; }
        #estado { margin-top: 10px; font-weight: bold; color: #007bff; }
        #formulario { margin-bottom: 20px; }
        #debug { color: red; font-size: 12px; }
    </style>
</head> 
<?php
session_start();
require_once("../utils/header.php");
require_once("../utils/footer.php");

showheader()?>
<body>
    <h1>Seguimiento de tu pedido</h1>
    <div id="formulario">
        <label for="direccion">Tu dirección en Bogotá:</label>
        <input type="text" id="direccion" placeholder="Ej: Calle 100 #15-90, Bogotá">
        <button onclick="actualizarDestino()">Actualizar Destino</button>
    </div>
    <div id="estado">Estado: Esperando dirección</div>
    <div id="debug"></div>
    <div id="map"></div>
    <button onclick="iniciarSimulacion()">Iniciar Simulación</button>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="script.js"></script>
</body> 
<?php
showfooter()
?>
</html>