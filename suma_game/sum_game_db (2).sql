-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-11-2024 a las 22:33:52
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
-- Base de datos: `sum_game_db`
--
CREATE DATABASE IF NOT EXISTS `sum_game_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sum_game_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicios`
--

CREATE TABLE `ejercicios` (
  `id` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  `sumando1` int(11) NOT NULL,
  `sumando2` int(11) NOT NULL,
  `respuesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejercicios`
--

INSERT INTO `ejercicios` (`id`, `nivel`, `sumando1`, `sumando2`, `respuesta`) VALUES
(1, 1, 3, 5, 8),
(2, 1, 7, 2, 9),
(3, 1, 4, 6, 10),
(4, 1, 2, 3, 5),
(5, 1, 8, 1, 9),
(6, 1, 5, 4, 9),
(7, 1, 6, 2, 8),
(8, 1, 9, 0, 9),
(9, 2, 12, 23, 35),
(10, 2, 45, 32, 77),
(11, 2, 56, 21, 77),
(12, 2, 34, 11, 45),
(13, 2, 22, 33, 55),
(14, 2, 19, 40, 59),
(15, 2, 31, 25, 56),
(16, 2, 44, 12, 56),
(17, 3, 123, 234, 357),
(18, 3, 456, 321, 777),
(19, 3, 567, 210, 777),
(20, 3, 340, 110, 450),
(21, 3, 222, 333, 555),
(22, 3, 198, 401, 599),
(23, 3, 315, 250, 565),
(24, 3, 440, 120, 560),
(25, 4, 1234, 2345, 3579),
(26, 4, 4567, 3210, 7777),
(27, 4, 5678, 2100, 7778),
(28, 4, 3400, 1100, 4500),
(29, 4, 2222, 3333, 5555),
(30, 4, 1987, 4012, 5999),
(31, 4, 3150, 2500, 5650),
(32, 4, 4400, 1200, 5600);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `progreso`
--

CREATE TABLE `progreso` (
  `id` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  `ejercicio_id` int(11) NOT NULL,
  `completado` tinyint(1) DEFAULT 0,
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `contraseña`) VALUES
(1, 'Luis', '$2y$10$Qk99zQI0kobp1KuSceKgBOakvehXUnW4TVa4SQtH.tD9mRYt4jf1C'),
(2, 'andy', '$2y$10$rKkPAKp5PLjUgHiPXFa9y.d3lRRGSbwTBqmaJj6.dv28bfDa8Fv5m');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `progreso`
--
ALTER TABLE `progreso`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nivel_ejercicio` (`nivel`,`ejercicio_id`),
  ADD KEY `ejercicio_id` (`ejercicio_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `progreso`
--
ALTER TABLE `progreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `progreso`
--
ALTER TABLE `progreso`
  ADD CONSTRAINT `progreso_ibfk_1` FOREIGN KEY (`ejercicio_id`) REFERENCES `ejercicios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `progreso_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
