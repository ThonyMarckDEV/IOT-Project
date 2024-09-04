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
    <title>Interfaz de Usuario</title>
    <link rel="stylesheet" href="/css/UiuserPC.css">
    <link rel="stylesheet" href="/css/UiuserMobile.css">
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
