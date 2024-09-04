<?php
session_start();

// Incluir la conexión a la base de datos
include 'conexion.php';

$sql = "SELECT id, TRIM(state) AS state FROM leds"; // Usamos TRIM para eliminar espacios en blanco y saltos de línea
$result = $conn->query($sql);

$states = array();
while ($row = $result->fetch_assoc()) {
    $states[$row['id']] = intval($row['state']); // Convertimos el estado a un número entero
}

$conn->close();

echo json_encode($states);
?>
