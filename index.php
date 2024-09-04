<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Estilos básicos */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #000;
            font-family: Arial, sans-serif;
            color: #fff;
        }

        /* Contenedor del formulario y título */
        .login-container {
            text-align: center;
        }

        /* Estilo del título */
        h2 {
            margin-bottom: 20px;
            color: #fff;
            font-size: 24px;
        }

        /* Estilo del contenedor del formulario */
        form {
            background-color: #111;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
            width: 300px;
            text-align: center;
        }

        /* Estilo de las etiquetas */
        label {
            display: block;
            margin-bottom: 8px;
            color: #fff;
            font-size: 14px;
        }

        /* Estilo de los campos de entrada */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
            font-size: 16px;
            box-sizing: border-box;
            box-shadow: inset 0 0 5px rgba(255, 255, 255, 0.2);
        }

        /* Estilo del botón de envío */
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #fff;
            color: #000;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        /* Efecto hover del botón de envío */
        input[type="submit"]:hover {
            background-color: #ddd;
            transform: scale(1.05);
        }

        /* Ajustes en pantallas más pequeñas */
        @media (max-width: 400px) {
            form {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="login.php" method="POST">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" required>
            <br><br>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <input type="submit" value="Iniciar Sesión">
        </form>
    </div>
</body>
</html>
