-- Crear base de datos si no existe y seleccionarla
CREATE DATABASE IF NOT EXISTS kitchsys_db;
USE kitchsys_db;

-- --------------------------------------------------------
-- Asegúrate de que la tabla `usuarios` existe antes de crear la tabla `asistencia`
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `curso` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `rol` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `presente` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Ahora puedes crear la tabla `asistencia` con la clave foránea referenciando a `usuarios`
CREATE TABLE IF NOT EXISTS `asistencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------
-- Volcado de datos para la tabla `usuarios`
INSERT INTO `usuarios` (`id`, `nombre_completo`, `email`, `curso`, `password`, `qr_code`, `rol`, `created_at`, `presente`) VALUES
(1, 'Admin User', 'admin@kitchsys.com', 'N/A', '$2y$10$hashDeContraseñaAdmin', NULL, 'admin', '2024-09-18 16:23:28', 0),
(2, 'Usuario Normal', 'usuario@kitchsys.com', 'Curso Ejemplo', '$2y$10$hashDeContraseñaUsuario', NULL, 'user', '2024-09-18 16:23:28', 0),
(3, 'elian patricio', 'elian.patricio@hotmail.com', '7mo 3ra', '$2y$10$JjVaohOIOwFHc/6speH6a.U1Rzl3K1Q6Qh90NNBeOadVvY73a/DgC', 'images/qr/94719efafa45727d0d736f3c314bac91.png', 'admin', '2024-09-18 16:25:09', 0),
(4, 'Admin User', 'admin2@hotmail.com', 'N/A', '12345', NULL, 'admin', '2024-09-18 16:32:02', 0);

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `alumnos_presentes`
CREATE TABLE `alumnos_presentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `alumnos_presentes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Modificación de la tabla `usuarios` para incluir el campo qr_code si no existía
ALTER TABLE `usuarios`
  ADD COLUMN IF NOT EXISTS `qr_code` VARCHAR(255) DEFAULT NULL;

-- --------------------------------------------------------
-- Auto incremento de la tabla `usuarios`
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

-- --------------------------------------------------------
-- Restricciones para la tabla `asistencia`
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
