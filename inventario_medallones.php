<?php
require 'includes/db.php';  // Conexión a la base de datos

// Si el formulario se ha enviado, insertar los datos en la base de datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_medallon = $_POST['tipo_medallon'];
    $cantidad = $_POST['cantidad'];
    
    $stmt = $conn->prepare("INSERT INTO inventario_medallones (tipo_medallon, cantidad) VALUES (?, ?)");
    $stmt->bind_param("si", $tipo_medallon, $cantidad);
    $stmt->execute();
    $stmt->close();
}

// Obtener los registros del inventario actual
$result = $conn->query("SELECT * FROM inventario_medallones ORDER BY fecha_ingreso DESC");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Medallones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Inventario de Medallones</h1>
        <form action="inventario_medallones.php" method="POST" class="mb-4">
            <div class="mb-3">
                <label for="tipo_medallon" class="form-label">Tipo de Medallón</label>
                <input type="text" class="form-control" id="tipo_medallon" name="tipo_medallon" required>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar al Inventario</button>
        </form>

        <h2>Medallones en Inventario</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Medallón</th>
                    <th>Cantidad</th>
                    <th>Fecha de Ingreso</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['tipo_medallon']; ?></td>
                    <td><?php echo $row['cantidad']; ?></td>
                    <td><?php echo $row['fecha_ingreso']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
