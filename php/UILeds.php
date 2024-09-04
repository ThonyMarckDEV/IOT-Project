<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php"); // Redirige al inicio de sesión si no hay sesión iniciada
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de LEDs ESP32</title>
    <link rel="stylesheet" href="/css/UILedsPC.css">
    <link rel="stylesheet" href="/css/UILedsMobile.css">
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

    <a href="logout.php" class="logout">Cerrar Sesión</a>

</body>
</html>
