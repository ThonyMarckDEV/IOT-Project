<?php
if (!isset($_GET['fecha'])) {
    echo json_encode([]);
    exit();
}

// Incluir la conexión a la base de datos
include 'conexion.php';

// Obtener la fecha seleccionada
$fechaSeleccionada = $_GET['fecha'];

// Consultar las imágenes de esa fecha
$sql = "SELECT ruta_imagen AS ruta, DATE_FORMAT(fecha, '%Y-%m-%d') AS fecha, DATE_FORMAT(fecha, '%H:%i:%s') AS hora FROM imagenes WHERE DATE_FORMAT(fecha, '%Y-%m-%d') = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $fechaSeleccionada);
$stmt->execute();
$result = $stmt->get_result();

// Crear la lista de imágenes
$imagenes = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imagenes[] = $row;
    }
}

// Devolver la lista de imágenes en formato JSON
header('Content-Type: application/json');
echo json_encode($imagenes);

$stmt->close();
$conn->close();
?>
