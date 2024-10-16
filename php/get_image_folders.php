<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// Consultar las fechas únicas de las imágenes
$sql = "SELECT DISTINCT DATE_FORMAT(fecha, '%Y-%m-%d') AS fecha FROM imagenes ORDER BY fecha DESC";
$result = $conn->query($sql);

// Crear una lista de fechas
$fechas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fechas[] = $row['fecha'];
    }
}

// Devolver las fechas en formato JSON
header('Content-Type: application/json');
echo json_encode($fechas);

$conn->close();
?>
