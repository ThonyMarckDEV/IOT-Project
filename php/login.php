<?php
session_start();

// Incluir la conexión a la base de datos
include 'conexion.php';

// Obtener los datos del formulario
$nombre = $_POST['username'];
$pass = $_POST['password'];

// Consultar la base de datos para obtener el hash de la contraseña
$sql = "SELECT idUser, password, status FROM user WHERE nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si el usuario existe
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $idUser = $row['idUser'];
    $hashPassword = $row['password'];  // Contraseña hasheada almacenada en la base de datos
    $status = $row['status'];

    // Verificar la contraseña ingresada con la contraseña hasheada
    if (password_verify($pass, $hashPassword)) {
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
        // Mostrar mensaje de error si la contraseña es incorrecta
        echo "Usuario o contraseña incorrectos.";
    }
} else {
    // Mostrar mensaje de error si el usuario no existe
    echo "Usuario o contraseña incorrectos.";
}

$stmt->close();
$conn->close();
?>