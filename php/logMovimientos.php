<?php
session_start();

// Incluir la conexión a la base de datos
include 'conexion.php';

// Incluir los archivos de PHPMailer
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Obtener la hora y fecha actual
$hora_actual = date("H:i:s");
$fecha_actual = date("Y-m-d");

// Insertar el reporte en la tabla logMovimiento
$sql = "INSERT INTO logMovimiento (Hora, Fecha, imagen) VALUES ('$hora_actual', '$fecha_actual', NULL)";

if ($conn->query($sql) === TRUE) {
    echo "Nuevo registro insertado correctamente";

    // Obtener el correo del usuario desde la tabla user
    $sql_correo = "SELECT correo FROM user WHERE idUser = '1'";
    $resultado = $conn->query($sql_correo);

    if ($resultado->num_rows > 0) {
        // Obtener el correo del primer resultado
        $fila = $resultado->fetch_assoc();
        $correo_destino = $fila['correo'];  // Aquí tienes el correo de la tabla user

        // Crear una instancia de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP de Gmail
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'domotics24@gmail.com';  // Correo desde el cual enviarás el mensaje
            $mail->Password = 'txcv eadu yiib mupv';  // Clave de aplicación de Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom('domotics24@gmail.com', 'Domotics 24');
            $mail->addAddress($correo_destino);  // Dirección del destinatario

            // Contenido del correo
            $mail->isHTML(true);  // Establecer formato HTML
            $mail->Subject = 'REPORTE DE MOVIMIENTO!!!!';
            $mail->Body = "Se ha registrado movimiento con la siguiente información:<br>";
            $mail->Body .= "Fecha: $fecha_actual<br>";
            $mail->Body .= "Hora: $hora_actual<br>";
            $mail->AltBody = "Se ha registrado movimiento y se insertó un reporte con la siguiente información:\nFecha: $fecha_actual\nHora: $hora_actual";

            // Enviar el correo
            $mail->send();
            echo "Correo enviado correctamente a $correo_destino.";
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "No se encontró ningún correo en la base de datos.";
    }

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
