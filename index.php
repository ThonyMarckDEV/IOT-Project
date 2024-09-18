<?php
session_start();

// Incluir la conexión a la base de datos
include 'php/conexion.php';

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['user'])) {
    $nombre = $_SESSION['user'];

    // Actualizar el estado del usuario a 'loggedOff'
    $update_sql = "UPDATE user SET status = 'loggedOff' WHERE nombre = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("s", $nombre);
    $stmt->execute();

    // Cerrar la sesión
    session_unset();
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LOGIN</title>
        <link rel="stylesheet" href="/css/indexPC.css">
        <link rel="stylesheet" href="/css/indexMobile.css">
    </head>
    <body>
       <div id="notification" class="notification">
         <?php
           if (isset($_SESSION['error'])) {
           echo $_SESSION['error'];
           // Limpiar el mensaje de error después de mostrarlo
           unset($_SESSION['error']);
           }
          ?>
        </div>

        <h1>HOMEGUARD</h1>
        <div class="login-container">
            <h2>Iniciar Sesión</h2>
            <form action="php/login.php" method="POST">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
                <br><br>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <br><br>
                <input type="submit" value="Iniciar Sesión">
            </form>
        </div>

        <script>
           // Mostrar la notificación si existe un mensaje
           window.onload = function() {
           var notification = document.getElementById('notification');
            if (notification.innerHTML.trim() !== '') {
               notification.classList.add('show');
               // Ocultar la notificación después de 5 segundos
                setTimeout(function() {
                notification.classList.remove('show');
                }, 5000); // 5000 milisegundos = 5 segundos
            }
           }
        </script>
    </body>
</html>
