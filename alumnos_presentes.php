<?php
// Conexión a la base de datos
require 'includes/db.php';

if (isset($_GET['codigo_qr'])) {
    $codigo_qr = $_GET['codigo_qr'];  // Este es el correo del alumno escaneado

    // Verificar si el código QR (correo) corresponde a un alumno
    $sql = "SELECT id, nombre_completo, curso FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $codigo_qr);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $alumno = $result->fetch_assoc();
        $user_id = $alumno['id'];
        $nombre_completo = $alumno['nombre_completo'];
        $curso = $alumno['curso'];

        // Verificar si el alumno ya tiene asistencia registrada en el mismo día
        $sql_check = "SELECT id FROM alumnos_presentes WHERE id_usuario = ? AND DATE(fecha_hora) = CURDATE()";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("i", $user_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows == 0) {
            // Registrar al alumno como presente con fecha y hora actual
            $sql_insert = "INSERT INTO alumnos_presentes (id_usuario, fecha_hora, medallon_entregado) VALUES (?, NOW(), 1)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("i", $user_id);
            $stmt_insert->execute();

            // Descontar un medallón del inventario
            $sql_update_inventario = "UPDATE inventario_medallones SET cantidad = cantidad - 1 WHERE tipo_medallon = 'pollo' AND cantidad > 0";
            $stmt_update = $conn->prepare($sql_update_inventario);
            $stmt_update->execute();
        } else {
            // Mostrar advertencia de "Medallón Denegado" en caso de registro duplicado
            echo "<div class='alert alert-warning'>El alumno ya ha sido registrado hoy. Medallón Denegado.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Código QR no válido o usuario no encontrado.</div>";
    }
} else {
    echo "<div class='alert alert-warning'>No se ha escaneado ningún código QR.</div>";
}

// Mostrar la lista de alumnos presentes
$sql_presentes = "SELECT usuarios.nombre_completo, usuarios.curso, alumnos_presentes.fecha_hora, alumnos_presentes.medallon_entregado 
                  FROM alumnos_presentes 
                  JOIN usuarios ON alumnos_presentes.id_usuario = usuarios.id
                  ORDER BY alumnos_presentes.fecha_hora DESC";
$result_presentes = $conn->query($sql_presentes);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos Presentes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Alumnos Presentes</h2>

        <!-- Tabla para mostrar los alumnos presentes -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre Completo</th>
                    <th>Curso</th>
                    <th>Fecha y Hora</th>
                    <th>Medallón de Pollo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_presentes->num_rows > 0) {
                    while ($row = $result_presentes->fetch_assoc()) {
                        $medallon_text = $row['medallon_entregado'] ? "<span class='badge bg-success'>Medallón Entregado</span>" : "<span class='badge bg-danger'>Medallón Denegado</span>";
                        echo "<tr><td>" . htmlspecialchars($row['nombre_completo']) . "</td>
                                <td>" . htmlspecialchars($row['curso']) . "</td>
                                <td>" . htmlspecialchars($row['fecha_hora']) . "</td>
                                <td>$medallon_text</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay alumnos presentes</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Botón para eliminar todos los registros de asistencia -->
        <form method="post">
            <button type="submit" name="delete_all" class="btn btn-danger">Eliminar todos los registros de asistencia</button>
        </form>
    </div>
</body>
</html>