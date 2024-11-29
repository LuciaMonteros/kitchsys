<?php
require 'includes/db.php';

$sql = "SELECT COUNT(*) AS total, presente FROM usuarios GROUP BY presente";
$result = $conn->query($sql);

$data = [0, 0]; // 0: ausentes, 1: presentes
while ($row = $result->fetch_assoc()) {
    if ($row['presente'] == 1) {
        $data[1] = $row['total'];
    } else {
        $data[0] = $row['total'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas y Reportes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Estadísticas de Asistencia</h2>
        <canvas id="asistenciaChart" width="400" height="200"></canvas>
        <script>
            const ctx = document.getElementById('asistenciaChart').getContext('2d');
            const asistenciaChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Ausentes', 'Presentes'],
                    datasets: [{
                        label: 'Asistencias',
                        data: [<?php echo $data[0]; ?>, <?php echo $data[1]; ?>],
                        backgroundColor: ['#ff6384', '#36a2eb'],
                    }]
                },
                options: {
                    responsive: true
                }
            });
        </script>
        <a href="dashboard.php" class="btn btn-secondary mt-3">Volver al Dashboard</a>
    </div>
</body>
</html>
