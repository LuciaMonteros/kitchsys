<?php
require 'includes/db.php';
require 'phpqrcode/qrlib.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_completo = $_POST['nombre_completo'];
    $email = $_POST['email'];
    $curso = $_POST['curso'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $qr_filename = 'images/qr/' . md5($email) . '.png';
    QRcode::png($email, $qr_filename);

    $sql = "INSERT INTO usuarios (nombre_completo, email, curso, password, qr_code) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre_completo, $email, $curso, $password, $qr_filename);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear tu Cuenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles2.css">
</head>
<body>
    <div class="container mt-5 text-center">
        <div class="logo-container">
            <img src="images/logo.png" alt="Logo" class="img-fluid logo">
        </div>
        <h1>KITCHSYS</h1>
        <h3>~~ REGISTRARSE ~~</h3>
        <form method="post" class="p-4">
            <div class="mb-3">
                <input type="text" class="form-control" name="nombre_completo" placeholder="Nombre Completo" required>
            </div>
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="curso" placeholder="Curso" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Crear Cuenta</button>
        </form>
    </div>
</body>
</html>