<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user'])) {
    header("Location: index.php"); // Redirige al inicio de sesión si no hay sesión iniciada
    exit();
}

// Incluir la conexión a la base de datos
include 'conexion.php';

// Obtener el nombre de usuario de la sesión
$username = $_SESSION['user'];

// Obtener la cantidad de reportes por día de la semana (Lunes a Domingo)
$reportes_por_dia = [];
$result = $conn->query("
    SELECT DAYNAME(Fecha) AS dia, COUNT(*) as total
    FROM logMovimiento
    GROUP BY DAYNAME(Fecha)
    ORDER BY FIELD(DAYNAME(Fecha), 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')
");

while ($row = $result->fetch_assoc()) {
    $reportes_por_dia[] = $row;
}

// Inicializar los días de la semana
$dias_semana = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$reportes_por_dia_completos = array_fill_keys($dias_semana, 0);

// Rellenar los reportes por día
foreach ($reportes_por_dia as $data) {
    $reportes_por_dia_completos[$data['dia']] = $data['total'];
}

// Obtener la cantidad de reportes por mes
$reportes_por_mes = [];
$result = $conn->query("
    SELECT DATE_FORMAT(Fecha, '%Y-%m') AS mes, COUNT(*) AS total
    FROM logMovimiento
    GROUP BY DATE_FORMAT(Fecha, '%Y-%m')
    ORDER BY DATE_FORMAT(Fecha, '%Y-%m')
");

while ($row = $result->fetch_assoc()) {
    $reportes_por_mes[] = $row;
}

// Inicializar los meses del año
$meses = [
    '2024-01' => 'Enero', '2024-02' => 'Febrero', '2024-03' => 'Marzo', '2024-04' => 'Abril',
    '2024-05' => 'Mayo', '2024-06' => 'Junio', '2024-07' => 'Julio', '2024-08' => 'Agosto',
    '2024-09' => 'Septiembre', '2024-10' => 'Octubre', '2024-11' => 'Noviembre', '2024-12' => 'Diciembre'
];
$reportes_por_mes_completos = array_fill_keys(array_keys($meses), 0);

// Rellenar los reportes por mes
foreach ($reportes_por_mes as $data) {
    $reportes_por_mes_completos[$data['mes']] = $data['total'];
}

// Obtener la cantidad total de reportes
$result = $conn->query("SELECT COUNT(*) as total FROM logMovimiento");
$total_reportes = $result->fetch_assoc()['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Reportes</title>
    <link rel="stylesheet" href="/css/DashboardPC.css">
    <link rel="stylesheet" href="/css/DashboardMobile.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1>Bienvenido, <?php echo $_SESSION['user']; ?></h1>
        <h2>Dashboard de Reportes</h2>

        <div class="charts-container">
            <canvas id="reportesPorDiaChart"></canvas>
            <canvas id="reportesPorMesChart"></canvas>
        </div>
    </div>

    <script>
        // Datos para el gráfico de reportes por día de la semana
        const reportesPorDia = <?php echo json_encode($reportes_por_dia_completos); ?>;
        const dias = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        const cantidadPorDia = dias.map(dia => reportesPorDia[dia] || 0);

        // Gráfico de reportes por día de la semana
        const ctx1 = document.getElementById('reportesPorDiaChart').getContext('2d');
        const reportesPorDiaChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
                datasets: [{
                    label: 'Reportes por Día de la Semana',
                    data: cantidadPorDia,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Color de fondo de las barras
                    borderColor: 'rgba(255, 99, 132, 1)', // Color del borde de las barras
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        ticks: {
                            color: '#fff' // Color de las etiquetas del eje X
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)' // Color de las líneas de la cuadrícula del eje X
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#fff' // Color de las etiquetas del eje Y
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)' // Color de las líneas de la cuadrícula del eje Y
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#fff' // Color de las etiquetas de la leyenda
                        }
                    }
                }
            }
        });

        // Datos para el gráfico de reportes por mes
        const reportesPorMes = <?php echo json_encode($reportes_por_mes_completos); ?>;
        const meses = [
            '2024-01', '2024-02', '2024-03', '2024-04', '2024-05', '2024-06',
            '2024-07', '2024-08', '2024-09', '2024-10', '2024-11', '2024-12'
        ];
        const cantidadPorMes = meses.map(mes => reportesPorMes[mes] || 0);

        // Gráfico de reportes por mes
        const ctx2 = document.getElementById('reportesPorMesChart').getContext('2d');
        const reportesPorMesChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: [
                    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                datasets: [{
                    label: 'Reportes por Mes',
                    data: cantidadPorMes,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo de las barras
                    borderColor: 'rgba(54, 162, 235, 1)', // Color del borde de las barras
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        ticks: {
                            color: '#fff' // Color de las etiquetas del eje X
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)' // Color de las líneas de la cuadrícula del eje X
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#fff' // Color de las etiquetas del eje Y
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)' // Color de las líneas de la cuadrícula del eje Y
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#fff' // Color de las etiquetas de la leyenda
                        }
                    }
                }
            }
        });
    </script>
<script>
    // Variables para rastrear la inactividad
    let tiempoInactividad = 0;
    let sesionCerrada = false;  // Bandera para evitar múltiples redirecciones

    // Función para restablecer el temporizador de inactividad
    function reiniciarTiempoInactividad() {
        tiempoInactividad = 0;  // Restablecer el contador de inactividad
    }

    // Función para verificar el estado del usuario
    function verificarEstadoUsuario() {
        fetch('verificar_estado.php', {  // Verificar si la sesión sigue activa
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            cache: 'no-cache'
        })
        .then(response => response.text())
        .then(data => {
            if (data === "loggedOff" && !sesionCerrada) {
                // Redirigir a logout.php si el estado es "loggedOff"
                window.location.href = 'logout.php';
            }
        })
        .catch(error => console.error('Error al verificar el estado del usuario:', error));
    }

    // Función para redirigir a logout.php por inactividad
    function cerrarSesionPorInactividad() {
        if (!sesionCerrada) {  // Solo redirigir si no se ha cerrado la sesión aún
            sesionCerrada = true;  // Marcar la sesión como cerrada
            window.location.href = 'logout.php';  // Redirigir a logout.php
        }
    }

    // Incrementar el tiempo de inactividad cada segundo
    setInterval(() => {
        tiempoInactividad += 1;

        if (tiempoInactividad >= 10) { // 10 segundos de inactividad
            cerrarSesionPorInactividad();
        }
    }, 1000);

    // Escuchar eventos de actividad (teclado o mouse) y reiniciar el temporizador
    window.addEventListener('mousemove', reiniciarTiempoInactividad);
    window.addEventListener('keydown', reiniciarTiempoInactividad);

    // Ejecutar la verificación de sesión al cargar la página
    verificarEstadoUsuario();

    // Ejecutar la verificación de sesión cada 3 segundos
    setInterval(verificarEstadoUsuario, 3000);

</script>
    <a href="logout.php" class="logout">Cerrar Sesión</a>

</body>
</html>
