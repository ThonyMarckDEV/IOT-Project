<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Reportes por Fecha</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            text-align: center;
            background-image: url('../img/fondo.png'); /* Ruta de la imagen de fondo */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white; /* Cambiar el color de las letras a blanco */
        }

        h1 {
            margin-bottom: 40px;
            color: white; /* Título en letras blancas */
        }

        /* Contenedor de carpetas */
        .folder-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        /* Estilo de las carpetas */
        .folder {
            width: 200px;
            height: 150px;
            background-color: white; /* Carpeta en color blanco */
            color: black; /* Letras negras */
            border-radius: 8px 8px 0 0; /* Redondear las esquinas superiores */
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            font-weight: bold;
            overflow: hidden; /* Para asegurarse de que las esquinas se corten */
        }

        /* Pestaña superior de la carpeta */
        .folder::before {
            content: '';
            position: absolute;
            top: -20px;
            left: 10px;
            width: 80px;
            height: 40px;
            background-color: white; /* Color de la pestaña también en blanco */
            border-radius: 8px 8px 0 0; /* Bordes redondeados para parecerse a una pestaña */
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.2); /* Sombra para la pestaña */
            z-index: -1; /* Asegurarse de que la pestaña esté detrás del texto */
        }

        /* Efecto hover para resaltar la carpeta */
        .folder:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); /* Efecto hover para que la carpeta resalte */
            transform: translateY(-5px); /* Elevar un poco la carpeta al pasar el ratón */
        }
    </style>
    <script>
        // Función para obtener las carpetas agrupadas por fecha
        async function fetchImageFolders() {
            const response = await fetch('get_image_folders.php');
            const data = await response.json();

            const folderContainer = document.getElementById('folderContainer');
            folderContainer.innerHTML = '';

            data.forEach(fecha => {
                const folder = document.createElement('div');
                folder.className = 'folder';
                folder.innerText = fecha;
                folder.onclick = function() {
                    window.location.href = `ver_imagenes.php?fecha=${fecha}`;
                };
                folderContainer.appendChild(folder);
            });
        }

        // Cargar las carpetas al cargar la página
        window.onload = function() {
            fetchImageFolders();
        };
    </script>
</head>
<body>

    <h1>Reportes Agrupados por Fecha</h1>

    <!-- Contenedor de carpetas -->
    <div id="folderContainer" class="folder-container">
        <!-- Aquí se mostrarán las carpetas -->
    </div>

</body>
</html>
