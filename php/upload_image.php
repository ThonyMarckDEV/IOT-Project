<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// Recibir los datos binarios de la imagen
$imageData = file_get_contents("php://input");

if ($imageData) {
    // Crear un nombre único para la imagen
    $imageName = uniqid() . '.jpg';

    // Definir la ruta donde se guardará la imagen
    $imagePath = 'uploads/' . $imageName;

    // Asegurarse de que la carpeta uploads exista
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);  // Crear la carpeta con permisos 777 si no existe
    }

    // Guardar la imagen en el servidor
    if (file_put_contents($imagePath, $imageData)) {
        echo "Imagen guardada correctamente.";

        // Registrar la imagen en la base de datos
        $sql = "INSERT INTO imagenes (ruta_imagen) VALUES ('$imagePath')";
        if ($conn->query($sql) === TRUE) {
            echo "Registro guardado en la base de datos.";
        } else {
            echo "Error al guardar el registro: " . $conn->error;
        }
    } else {
        echo "Error al guardar la imagen.";
    }
} else {
    echo "No se recibió ninguna imagen.";
}

$conn->close();
?>
