<?php
session_start();

// Incluir la conexión a la base de datos
include 'conexion.php';

// Verifica si los parámetros existen
if (isset($_GET['led']) && isset($_GET['action'])) {
    $led = intval($_GET['led']);
    $action = $_GET['action'];

    $sql = "UPDATE leds SET state = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $state = ($action === 'on') ? 1 : 0;
        $stmt->bind_param("ii", $state, $led);
        $stmt->execute();
        $stmt->close();
    }
    
    echo "OK";
} else {
    echo "Error: Faltan parámetros 'led' y 'action'";
}

$conn->close();
?>
