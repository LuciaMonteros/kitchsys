<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles2.css">
</head>
<body>
    <div class="container mt-5 text-center">
        <div class="logo-container">
            <img src="images/logo.png" alt="Logo" class="img-fluid logo">
        </div>
        <h1>KITCHSYS</h1>
        <h3>~~ PERFIL DE USUARIO ~~</h3>
        <div class="qr-section">
            <img src="<?php echo $user['qr_code']; ?>" alt="Código QR">
            <p class="qr-info">Escanea este código para acceder a tu información.</p>
        </div>
        <div class="user-info">
            <h3><?php echo $user['nombre_completo']; ?></h3>
            <p styles= "color= black;">Correo: <?php echo $user['email']; ?></p>
            <p>Curso: <?php echo $user['curso']; ?></p>
        </div>
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</body>
</html>