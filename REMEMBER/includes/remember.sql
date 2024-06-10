-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2024 a las 14:34:54
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `remember`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `dia_inicio` date NOT NULL,
  `dia_final` date NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `color` varchar(7) DEFAULT '#FFFFFF'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `nombre`, `descripcion`, `dia_inicio`, `dia_final`, `usuario`, `color`) VALUES
(1, 'DÍAS DE EXPOSICIÓN', 'EXPOSICIONES DEL TFG', '2024-06-18', '2024-06-21', 'Paulita', '#ff8080');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos_hechos`
--

CREATE TABLE `eventos_hechos` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `fecha_completado` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `dia_limite` date DEFAULT NULL,
  `nivel_urgencia` int(11) DEFAULT NULL,
  `color` varchar(7) DEFAULT '#FFFFFF'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `usuario`, `titulo`, `descripcion`, `fecha_creacion`, `dia_limite`, `nivel_urgencia`, `color`) VALUES
(8, 'Paulita', 'TFG', 'ENTREGA DE LA DOCUMENTACIÓN Y PROYECTO ', '2024-06-08 16:56:41', '2024-06-11', 5, '#0080ff'),
(12, 'Paulita', 'EXAMEN DAVID PHP', 'EXAMEN RECUPERACIÓN DE PHP', '2024-06-10 10:22:13', '2024-06-17', 5, '#8080ff'),
(15, 'Paulita', 'prueba 4', 'kjkdfsjklfjksdfjklsdkjlf', '2024-06-10 12:22:35', '2024-06-11', 3, '#008040');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas_hechas`
--

CREATE TABLE `tareas_hechas` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `tarea_id` int(11) NOT NULL,
  `fecha_completado` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `email`, `contraseña`) VALUES
(26, 'Olenka', 'Olenka123@gmail.com', '$2y$10$EiPA.W6hD8SiD24X5cgUXOatuSqxFhBFUpLYJ9OMjFijMtXhFTNwu'),
(30, 'Administrador', 'adminremember123@gmail.com', '$2y$10$Td2q6XYeBN0umkINGK6zVeETdtTP2T8z5ldUyP2BmJl.QzP4r3lku'),
(33, 'Adri <3', 'adri123@gmail.com', '$2y$10$GdAAWgZZhvIlkmjzH6Hi9uRH4jKpdmVlE/DwXlnX1zFGCXqvhH.va'),
(34, 'Usuario', 'usuario123@gmail.com', '$2y$10$wyoOFB81YpJ4jM2InlzDmOvwd0Rwz1dIVONjSMfbEBNimgzOXOXB.'),
(35, 'Paulita', 'paulita123@gmail.com', '$2y$10$5WIRNs1xQRjqYUo4XURng.tTP/pJTR7iNafLyTmX103mbNh6EU0Ce');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `eventos_hechos`
--
ALTER TABLE `eventos_hechos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `evento_id` (`evento_id`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `tareas_hechas`
--
ALTER TABLE `tareas_hechas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `tarea_id` (`tarea_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `eventos_hechos`
--
ALTER TABLE `eventos_hechos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tareas_hechas`
--
ALTER TABLE `tareas_hechas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `eventos_hechos`
--
ALTER TABLE `eventos_hechos`
  ADD CONSTRAINT `eventos_hechos_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `eventos_hechos_ibfk_2` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tareas_hechas`
--
ALTER TABLE `tareas_hechas`
  ADD CONSTRAINT `tareas_hechas_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `tareas_hechas_ibfk_2` FOREIGN KEY (`tarea_id`) REFERENCES `tareas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
