<?php 
require 'includes/db.php';  // Conexión a la base de datos

// Verificar si se ha enviado el ID del alumno desde el escaneo
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    // Verificar si el alumno ya está registrado como presente en la fecha actual
    $stmt = $conn->prepare("SELECT COUNT(*) FROM alumnos_presentes WHERE id_usuario = ? AND DATE(fecha_hora) = CURDATE()");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Si ya se registró hoy, mostrar la ventana modal y detener el lector
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() { 
                let modal = document.createElement('div');
                modal.style.position = 'fixed';
                modal.style.top = '50%';
                modal.style.left = '50%';
                modal.style.transform = 'translate(-50%, -50%)';
                modal.style.padding = '20px';
                modal.style.backgroundColor = 'white';
                modal.style.border = '1px solid black';
                modal.style.zIndex = '1000';
                modal.innerHTML = '<p>El QR ya ha sido escaneado para hoy.</p><button onclick=\"document.body.removeChild(this.parentNode)\">Cerrar</button>';
                document.body.appendChild(modal);
                qrReader.stop(); // Detener el lector de QR
            });
        </script>";
        exit();
    }

    // Registrar la presencia del alumno si no está registrado hoy
    $stmt = $conn->prepare("INSERT INTO alumnos_presentes (id_usuario, fecha_hora) VALUES (?, NOW())");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $stmt->close();

    // Descontar un medallón del inventario
    $tipo_medallon = 'Pollo';
    $stmt = $conn->prepare("UPDATE inventario_medallones SET cantidad = cantidad - 1 WHERE tipo_medallon = ? AND cantidad > 0 LIMIT 1");
    $stmt->bind_param("s", $tipo_medallon);
    $stmt->execute();
    $stmt->close();

    // Mostrar mensaje de éxito y abrir alumnos_presentes.php en una nueva pestaña
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() { 
            let modal = document.createElement('div');
            modal.style.position = 'fixed';
            modal.style.top = '50%';
            modal.style.left = '50%';
            modal.style.transform = 'translate(-50%, -50%)';
            modal.style.padding = '20px';
            modal.style.backgroundColor = 'white';
            modal.style.border = '1px solid green';
            modal.style.zIndex = '1000';
            modal.innerHTML = '<p>Asistencia registrada exitosamente.</p><button onclick=\"document.body.removeChild(this.parentNode)\">Cerrar</button>';
            document.body.appendChild(modal);
            qrReader.stop(); // Detener el lector de QR
            window.open('alumnos_presentes.php', '_blank'); // Abrir en una nueva pestaña
        });
    </script>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escanear QR</title>
    <!-- Incluir h5qrcode desde una CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.2.1/html5-qrcode.min.js"></script>
    <style>
        #qr-reader {
            width: 500px;
            margin: auto;
        }
        #error-message {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Escanear Código QR</h1>
    <div id="qr-reader" style="width: 100%;"></div>
    <div id="error-message"></div>
    
    <script>
        function onScanSuccess(qrMessage) {
            // Enviar el valor escaneado a alumnos_presentes.php
            window.location.href = "alumnos_presentes.php?codigo_qr=" + encodeURIComponent(qrMessage);
        }

        function onScanError(errorMessage) {
            console.error(`Error de escaneo: ${errorMessage}`);
        }

        function mostrarError(mensaje) {
            document.getElementById('error-message').textContent = mensaje;
        }

        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            let qrReader = new Html5Qrcode("qr-reader");

            qrReader.start(
                { facingMode: "environment" }, // Cámara trasera
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 }
                },
                onScanSuccess,
                onScanError
            ).catch(err => {
                console.error(`Error al iniciar la cámara: ${err}`);
                mostrarError("No se pudo acceder a la cámara. Verifica los permisos y que estés usando HTTPS.");
            });
        } else {
            mostrarError("Tu navegador no soporta la cámara.");
        }
    </script>
</body>
</html>
