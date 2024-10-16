<?php
// Verificar si se recibió el enlace
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['link'])) {
    $link = $_POST['link'];

    // Guardar el enlace en un archivo o en la base de datos
    // Ejemplo: guardarlo en un archivo de texto
    $file = 'stream_link.txt';
    file_put_contents($file, $link);

    // Responder con éxito
    echo "Enlace recibido: $link";
} else {
    echo "No se recibió ningún enlace.";
}
?>
