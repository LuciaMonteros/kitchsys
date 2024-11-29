<?php
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codigo_qr'])) {
    $codigo_qr = $_POST['codigo_qr'];

    // Buscamos al alumno con el código QR escaneado
    $sql = "SELECT * FROM usuarios WHERE qr_code = '$codigo_qr'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Actualizamos el estado del alumno como presente
        $alumno = $result->fetch_assoc();
        $sql_update = "UPDATE usuarios SET presente = 1 WHERE qr_code = '$codigo_qr'";
        if ($conn->query($sql_update) === TRUE) {
            echo "Asistencia registrada correctamente";
        } else {
            echo "Error al registrar la asistencia: " . $conn->error;
        }
    } else {
        echo "Código QR no encontrado.";
    }
}
?>
