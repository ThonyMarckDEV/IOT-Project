<?php
$servername = "localhost";
$username = "root"; // Ajusta según sea necesario
$password = ""; // Ajusta según sea necesario
$dbname = "leddb"; // Nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
