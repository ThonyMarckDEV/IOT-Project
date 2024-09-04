<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user'])) {
    header("Location: index.php"); // Redirige al inicio de sesión si no hay sesión iniciada
    exit();
}

// Incluir la conexión a la base de datos
include 'conexion.php';

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    /* Estilos básicos */
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #000;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        text-align: center;
    }

    h1, h2 {
        color: #fff;
        margin-top:40px;
    }

    .container {
        width: 80%;
        max-width: 1200px; /* Ajusta el ancho máximo si es necesario */
        margin: 0 auto;
    }

    .charts-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px; /* Espacio entre los gráficos */
        width: 100%;
    }

    canvas {
        max-width: 800px; /* Ajusta el tamaño máximo si es necesario */
        max-height: 500px; /* Ajusta el tamaño máximo si es necesario */
    }

    /* Estilo opcional para pantallas pequeñas */
    @media (max-width: 768px) {
        .charts-container {
            flex-direction: column; /* Apila los gráficos verticalmente en pantallas pequeñas */
        }

        canvas {
            max-width: 100%;
            max-height: 300px;
        }
    }

     /* Botón de Cerrar Sesión */
     .logout {
            position: absolute;
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: red;  
            color: white;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .logout:hover {
            transform: scale(1.05);
        }
    </style>
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

    <a href="logout.php" class="logout">Cerrar Sesión</a>

</body>
</html>
