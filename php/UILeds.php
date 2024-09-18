<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php"); // Redirige al inicio de sesión si no hay sesión iniciada
    exit();
}

// Incluir la conexión a la base de datos
include 'conexion.php';

// Obtener el nombre de usuario de la sesión
$username = $_SESSION['user'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de LEDs ESP32</title>
    <link rel="stylesheet" href="../css/UILedsPC.css">
    <link rel="stylesheet" href="../css/UILedsMobile.css">
    <script>
        async function toggleLED(ledId, action) {
            const response = await fetch(`led_control.php?led=${ledId}&action=${action}`);
            const result = await response.text();
            if (result === "OK") {
                loadStatus();
            }
        }

        async function loadStatus() {
            const response = await fetch('get_led_status.php');
            const data = await response.json();

            const led1Button = document.getElementById('led1');
            const led1Indicator = document.getElementById('led1-indicator');
            const led2Button = document.getElementById('led2');
            const led2Indicator = document.getElementById('led2-indicator');

            // Update LED 1
            if (data[1] === 1) {
                led1Button.innerText = 'ON';
                led1Button.className = 'btn on';
                led1Indicator.className = 'led-indicator on';
            } else {
                led1Button.innerText = 'OFF';
                led1Button.className = 'btn off';
                led1Indicator.className = 'led-indicator off';
            }

            // Update LED 2
            if (data[2] === 1) {
                led2Button.innerText = 'ON';
                led2Button.className = 'btn on';
                led2Indicator.className = 'led-indicator on';
            } else {
                led2Button.innerText = 'OFF';
                led2Button.className = 'btn off';
                led2Indicator.className = 'led-indicator off';
            }
        }

        window.onload = function() {
            loadStatus();
            // Actualiza el estado cada 5 segundos (5000 ms)
            setInterval(loadStatus, 5000);
        };
    </script>
</head>
<body>
    <h1>Control de LEDs ESP32</h1>
    <div>
        <h2>LED 1</h2>
        <div id="led1-indicator" class="led-indicator off"></div>
        <button id="led1" class="btn" onclick="toggleLED(1, this.innerText === 'ON' ? 'off' : 'on')">Loading...</button>
    </div>
    <div>
        <h2>LED 2</h2>
        <div id="led2-indicator" class="led-indicator off"></div>
        <button id="led2" class="btn" onclick="toggleLED(2, this.innerText === 'ON' ? 'off' : 'on')">Loading...</button>
    </div>
    <script>
    // Variables para rastrear la inactividad
    let tiempoInactividad = 0;
    let sesionCerrada = false;  // Bandera para evitar múltiples redirecciones

    // Función para restablecer el temporizador de inactividad
    function reiniciarTiempoInactividad() {
        tiempoInactividad = 0;  // Restablecer el contador de inactividad
    }

    // Función para verificar el estado del usuario
    function verificarEstadoUsuario() {
        fetch('verificar_estado.php', {  // Verificar si la sesión sigue activa
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            cache: 'no-cache'
        })
        .then(response => response.text())
        .then(data => {
            if (data === "loggedOff" && !sesionCerrada) {
                // Redirigir a logout.php si el estado es "loggedOff"
                window.location.href = 'logout.php';
            }
        })
        .catch(error => console.error('Error al verificar el estado del usuario:', error));
    }

    // Función para redirigir a logout.php por inactividad
    function cerrarSesionPorInactividad() {
        if (!sesionCerrada) {  // Solo redirigir si no se ha cerrado la sesión aún
            sesionCerrada = true;  // Marcar la sesión como cerrada
            window.location.href = 'logout.php';  // Redirigir a logout.php
        }
    }

    // Incrementar el tiempo de inactividad cada segundo
    setInterval(() => {
        tiempoInactividad += 1;

        if (tiempoInactividad >= 10) { // 10 segundos de inactividad
            cerrarSesionPorInactividad();
        }
    }, 1000);

    // Escuchar eventos de actividad (teclado o mouse) y reiniciar el temporizador
    window.addEventListener('mousemove', reiniciarTiempoInactividad);
    window.addEventListener('keydown', reiniciarTiempoInactividad);

    // Ejecutar la verificación de sesión al cargar la página
    verificarEstadoUsuario();

    // Ejecutar la verificación de sesión cada 3 segundos
    setInterval(verificarEstadoUsuario, 3000);

</script>
    <a href="logout.php" class="logout">Cerrar Sesión</a>

</body>
</html>
