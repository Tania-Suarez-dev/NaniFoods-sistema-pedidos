// Inicializar el mapa centrado en el restaurante
let map = L.map('map').setView([4.715324, -74.139251], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// === SECCIÓN PARA ÍCONOS PERSONALIZADOS ===
// Aquí defines las imágenes y su tamaño. Para cambiar el tamaño, ajusta 'iconSize' y 'iconAnchor'.
// Ejemplo: Para hacerlas más grandes, cambia [50, 50] a [70, 70] y [25, 50] a [35, 70].
function createIcon(url) {
    return new L.Icon({
        iconUrl: url,
        iconSize: [50, 50], // [ancho, alto] - Modifica aquí para cambiar tamaño
        iconAnchor: [25, 50] // [horizontal, vertical] - Ajusta para centrar
    });
}

let iconRestaurante, iconCliente, iconRepartidor;
try {
    iconRestaurante = createIcon('imagenes/logo2.png');    // Imagen del restaurante
    iconCliente = createIcon('imagenes/casita2.png');      // Imagen del cliente
    iconRepartidor = createIcon('imagenes/rapibara2.png'); // Imagen del repartidor
} catch (error) {
    console.error('Error cargando íconos:', error);
    iconRestaurante = L.Icon.Default; // Fallback a ícono predeterminado
    iconCliente = L.Icon.Default;
    iconRepartidor = L.Icon.Default;
    console.log('Usando íconos predeterminados de Leaflet como fallback.');
}
// === FIN DE SECCIÓN ÍCONOS ===

// Marcadores con iconos (popups desactivados inicialmente)
let markerRestaurante = L.marker([4.715324, -74.139251], { icon: iconRestaurante }).addTo(map);
let markerCliente = L.marker([4.715324, -74.139251], { icon: iconCliente }).addTo(map);
let markerRepartidor;
let rutaPolilinea;
let tiempoEstimado = 0;

// Función para geocodificar dirección con Nominatim
async function actualizarDestino() {
    const direccion = document.getElementById('direccion').value;
    const estadoDiv = document.getElementById('estado');
    const debugDiv = document.getElementById('debug');

    if (!direccion) {
        estadoDiv.innerText = 'Estado: Por favor, ingresa una dirección.';
        return;
    }

    estadoDiv.innerText = 'Estado: Buscando dirección...';
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(direccion + ', Bogotá, Colombia')}&format=json&limit=1`);
        if (!response.ok) throw new Error('Error en Nominatim: ' + response.status);
        const data = await response.json();
        console.log('Nominatim data:', data);

        if (data.length > 0) {
            const { lat, lon } = data[0];
            markerCliente.setLatLng([lat, lon]);
            map.panTo([lat, lon]);
            estadoDiv.innerText = 'Estado: Dirección actualizada';
            debugDiv.innerText = `Coordenadas: [${lat}, ${lon}]`;
        } else {
            throw new Error('Dirección no encontrada');
        }
    } catch (error) {
        console.error('Geocodificación error:', error);
        estadoDiv.innerText = 'Estado: Error al buscar dirección. Usa una dirección válida.';
        debugDiv.innerText = 'Error: ' + error.message;
    }
}

// Función para calcular ruta con OSRM
async function calcularRuta(origen, destino) {
    const estadoDiv = document.getElementById('estado');
    const debugDiv = document.getElementById('debug');
    const url = `http://router.project-osrm.org/route/v1/driving/${origen[1]},${origen[0]};${destino[1]},${destino[0]}?overview=full&geometries=geojson`;
    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error('Error en OSRM: ' + response.status);
        const data = await response.json();
        console.log('OSRM data:', data);

        if (data.routes && data.routes.length > 0) {
            const coordenadas = data.routes[0].geometry.coordinates.map(coord => [coord[1], coord[0]]);
            console.log('Coordenadas de la ruta:', coordenadas);
            tiempoEstimado = Math.round(data.routes[0].duration / 60);
            if (rutaPolilinea) rutaPolilinea.remove();
            rutaPolilinea = L.polyline(coordenadas, { color: 'red', weight: 5 }).addTo(map);
            map.fitBounds(rutaPolilinea.getBounds());
            estadoDiv.innerText = `Estado: Ruta lista. Tiempo estimado: ${tiempoEstimado} min`;
            debugDiv.innerText = `Ruta calculada con ${coordenadas.length} puntos`;
            return coordenadas;
        } else {
            throw new Error('No se pudo calcular la ruta');
        }
    } catch (error) {
        console.error('Ruta error:', error);
        estadoDiv.innerText = 'Estado: Error al calcular la ruta.';
        debugDiv.innerText = 'Error: ' + error.message;
        return [];
    }
}

// Función para simular el movimiento
async function iniciarSimulacion() {
    const origen = [4.715324, -74.139251];
    const destino = markerCliente.getLatLng();
    const estadoDiv = document.getElementById('estado');

    if (destino.lat === origen[0] && destino.lng === origen[1]) {
        estadoDiv.innerText = 'Estado: Actualiza una dirección primero.';
        return;
    }

    estadoDiv.innerText = 'Estado: Preparando pedido...';
    const coordenadas = await calcularRuta(origen, [destino.lat, destino.lng]);
    if (coordenadas.length === 0) return;

    if (markerRepartidor) markerRepartidor.remove();
    markerRepartidor = L.marker(origen, { icon: iconRepartidor }).addTo(map);

    estadoDiv.innerText = `Estado: En camino. Tiempo estimado: ${tiempoEstimado} min`;
    let indice = 0;
    const intervalo = setInterval(() => {
        if (indice < coordenadas.length) {
            markerRepartidor.setLatLng(coordenadas[indice]);
            map.panTo(coordenadas[indice]);
            indice++;
        } else {
            clearInterval(intervalo);
            estadoDiv.innerText = 'Estado: ¡Pedido entregado!';
            markerRepartidor.bindPopup('Repartidor: ¡Entregado!').openPopup(); // Popup solo al final
        }
    }, 1000);
}