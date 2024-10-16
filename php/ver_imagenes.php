<?php
if (!isset($_GET['fecha'])) {
    echo "Fecha no seleccionada.";
    exit();
}

$fechaSeleccionada = $_GET['fecha'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes del <?php echo $fechaSeleccionada; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            text-align: center;
            background-image: url('../img/fondo.png'); /* Ruta de la imagen de fondo */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }

        h1 {
            margin-bottom: 40px;
            color: white;
        }

        /* Contenedor de imágenes */
        .image-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .image-list img {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .image-list img:hover {
            transform: scale(1.05);
        }

        .image-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .image-container p {
            margin-top: 5px;
            font-size: 14px;
            color: white;
        }

        /* Estilos del modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .modal img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
        }
    </style>
    <script>
        // Función para obtener las imágenes por fecha
        async function fetchImagesByDate() {
            const fecha = "<?php echo $fechaSeleccionada; ?>";
            const response = await fetch(`get_images_by_date.php?fecha=${fecha}`);
            const data = await response.json();

            const imageList = document.getElementById('imageList');
            imageList.innerHTML = '';

            data.forEach(imagen => {
                const container = document.createElement('div');
                container.className = 'image-container';

                const img = document.createElement('img');
                img.src = imagen.ruta;
                img.onclick = function() {
                    openModal(imagen.ruta);
                };

                const fechaHora = document.createElement('p');
                fechaHora.innerText = `Fecha: ${imagen.fecha} Hora: ${imagen.hora}`;

                container.appendChild(img);
                container.appendChild(fechaHora);

                imageList.appendChild(container);
            });
        }

        // Función para abrir el modal
        function openModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modal.style.display = 'flex'; // Mostrar el modal
            modalImg.src = imageSrc;      // Colocar la imagen en el modal
        }

        // Función para cerrar el modal
        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.style.display = 'none';
        }

        window.onload = fetchImagesByDate;
    </script>
</head>
<body>

    <h1>Reportes del <?php echo $fechaSeleccionada; ?></h1>

    <div id="imageList" class="image-list">
        <!-- Aquí se mostrarán las imágenes -->
    </div>

    <!-- Modal para mostrar la imagen ampliada -->
    <div id="imageModal" class="modal" onclick="closeModal()">
        <img id="modalImage" src="">
    </div>

</body>
</html>
