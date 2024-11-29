<?php
require 'includes/db.php';

$sql = "SELECT id, nombre_completo, email, curso FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Gestión de Alumnos</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Curso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['nombre_completo']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['curso']; ?></td>
                        <td>
                            <a href="editar_alumno.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Editar</a>
                            <a href="eliminar_alumno.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este alumno?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
    </div>
</body>
</html>
