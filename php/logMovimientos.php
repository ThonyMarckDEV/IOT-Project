<?php
session_start();

// Incluir la conexión a la base de datos
include 'conexion.php';

// Obtener la hora y fecha actual
$hora_actual = date("H:i:s");
$fecha_actual = date("Y-m-d");

// Insertar el reporte en la tabla
$sql = "INSERT INTO logMovimiento (Hora, Fecha, imagen) VALUES ('$hora_actual', '$fecha_actual', NULL)";

if ($conn->query($sql) === TRUE) {
    echo "Nuevo registro insertado correctamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>