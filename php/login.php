<?php
session_start();

// Incluir la conexión a la base de datos
include 'conexion.php';

// Obtener los datos del formulario
$nombre = $_POST['username'];
$pass = $_POST['password'];

// Consultar la base de datos para validar las credenciales
$sql = "SELECT idUser, status FROM user WHERE nombre = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $nombre, $pass);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si las credenciales son correctas
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $idUser = $row['idUser'];
    $status = $row['status'];

    // Verificar si el usuario ya tiene una sesión activa
    if ($status === 'loggedOn') {
        // Redirigir a index.php con un mensaje de error
        $_SESSION['error'] = "Ya hay una sesión activa con este usuario.";
        header("Location: ../index.php");
        exit();
    } else {
        // Iniciar sesión y actualizar el estado del usuario
        $update_sql = "UPDATE user SET status = 'loggedOn' WHERE idUser = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $idUser);
        $update_stmt->execute();
        
        // Establecer la sesión
        $_SESSION['user'] = $nombre;
        header("Location: Uiuser.php");
        exit();
    }
} else {
    // Mostrar mensaje de error si las credenciales son incorrectas
    echo "Usuario o contraseña incorrectos.";
}

$stmt->close();
$conn->close();
?>
