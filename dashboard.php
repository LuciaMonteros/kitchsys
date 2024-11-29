<?php
require 'includes/db.php';  // Conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestión de Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/js/all.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="dashboard.php">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="alumnos_presentes.php">
                                <i class="fas fa-users"></i> Ver Alumnos Presentes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="gestionar_alumnos.php">
                                <i class="fas fa-user-cog"></i> Gestión de Alumnos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chart-line"></i> Inventario de Medallones
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reportes.php">
                                <i class="fas fa-chart-line"></i> Estadísticas y Reportes
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>

                <!-- Contenido del dashboard -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-header">Escaneo de QR</div>
                            <div class="card-body">
                                <h5 class="card-title">Escanear códigos QR de los alumnos</h5>
                                <a href="escanear_qr.php" class="btn btn-light">Escanear QR</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-header">Ver Alumnos Presentes</div>
                            <div class="card-body">
                                <h5 class="card-title">Listado de alumnos que han asistido</h5>
                                <a href="alumnos_presentes.php" class="btn btn-light">Ver Asistencias</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-header">Ver Inventario</div>
                            <div class="card-body">
                                <h5 class="card-title">Inventario de Medallones</h5>
                                <a href="inventario_medallones.php" class="btn btn-light">Ver Inventario</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-header">Estadisticas y Reportes</div>
                            <div class="card-body">
                                <h5 class="card-title">Estadisticas y Reportes de los Alumnos</h5>
                                <a href="alumnos_presentes.php" class="btn btn-light">Ver Estadisticas</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-header">Gestión de Alumnos</div>
                            <div class="card-body">
                                <h5 class="card-title">Administrar alumnos</h5>
                                <a href="gestionar_alumnos.php" class="btn btn-light">Gestionar Alumnos</a>
                            </div>
                        </div>
                    </div>
                </div>
    
            </main>
        </div>
    </div>
</body>
</html>
