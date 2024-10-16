<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si se recibió el log
    if (isset($_POST['log'])) {
        $log = $_POST['log'];
        $logFile = 'logs.txt'; // Archivo donde se guardarán los logs
        
        // Abrir el archivo y escribir el log
        $file = fopen($logFile, 'a');
        if ($file) {
            fwrite($file, date('Y-m-d H:i:s') . " - " . $log . "\n");
            fclose($file);
            echo "Log recibido y guardado.";
        } else {
            echo "Error al abrir el archivo de logs.";
        }
    } else {
        echo "No se recibió ningún log.";
    }
} else {
    echo "Método no soportado.";
}
?>
