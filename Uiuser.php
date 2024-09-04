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
    <title>Interfaz de Usuario</title>
    <style>
        /* Estilos básicos */
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #000;
            font-family: Arial, sans-serif;
            position: relative;
        }
        
        /* Contenedor de la cuadrícula */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 400px);
            grid-template-rows: repeat(2, 300px);
            gap: 20px;
        }
        
        /* Estilo de los botones */
        .grid-container a {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
            color: black;   
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
            transition: transform 0.2s, box-shadow 0.2s;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .grid-container a:hover {
            transform: scale(1.05);
            box-shadow: 0 0 40px rgba(255, 255, 255, 1);
        }
        
        /* Imagen de fondo del botón */
        .grid-container a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0.7;
            transition: opacity 0.3s;
        }
        
        /* Especificando las imágenes para cada botón */
        .grid-container a[href="UILeds.php"]::before {
            background-image: url('ledsimg.jpg');
        }
        
        .grid-container a[href="Dashboard.php"]::before {
            background-image: url('dashboardimg.jpg');
        }
        
        .grid-container a[href="#"]:nth-child(3)::before {
            background-image: url('option3-icon.png');
        }
        
        .grid-container a[href="#"]:nth-child(4)::before {
            background-image: url('option4-icon.png');
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
</head>
<body>

    <div class="grid-container">
        <a href="UILeds.php"></a>
        <a href="Dashboard.php"></a>
        <a href="#"></a>
        <a href="#"></a>
    </div>

    <a href="logout.php" class="logout">Cerrar Sesión</a>

</body>
</html>
