<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user'])) {
    header("Location: index.php"); // Redirige al inicio de sesión si no hay sesión iniciada
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de LEDs ESP32</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            background-color: #000; /* Fondo negro */
            color: #fff; /* Texto blanco */
        }
        .btn { 
            border: none; 
            color: #fff; 
            padding: 0.5em 1em; 
            font-size: 1.5em; 
            text-decoration: none; 
            margin: 0.5em; 
            cursor: pointer; 
        }
        .btn.on { 
            background-color: #4CAF50; /* Verde para ON */ 
        }
        .btn.off { 
            background-color: #F44336; /* Rojo para OFF */ 
        }
        .led-indicator {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin: 0 auto 1em;
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.7);
        }
        .led-indicator.on {
            background-color: #4CAF50; /* Verde cuando está ON */
            box-shadow: 0 0 100px rgba(76, 175, 80, 1), 0 0 30px rgba(76, 175, 80, 0.7);
        }
        .led-indicator.off {
            background-color: #F44336; /* Rojo cuando está OFF */
            box-shadow: 0 0 100px rgba(244, 67, 54, 1), 0 0 30px rgba(244, 67, 54, 0.7);
        }

         /* Botón de Cerrar Sesión */
         .logout {
            position: absolute;
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: red;  
            color: white;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .logout:hover {
            transform: scale(1.05);
        }
    </style>
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
