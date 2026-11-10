-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-11-2026 a las 20:28:16
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
-- Base de datos: `coescon`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` int(5) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `correo`, `nombre`) VALUES
(1, 'thomaslm1002@gmail.com', 'Thomas Lopera Muñoz'),
(2, 'daniela.jaramillo@alzate.edu.co', 'Daniela Jaramillo Puerta'),
(3, 'raulbetancourt@alzate.edu.co', 'Raúl Eduardo Betancourt Ossa'),
(4, 'annasophiemejiaalzate@gmail.com', 'Anna Sophie Mejía Alzate'),
(5, 'alexandragiraldogarcia@alzate.edu.co', 'Alexandra María Giraldo García'),
(6, 'Hilda Morales Luna', 'hildamoralesluna@alzate.edu.co');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id` int(5) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `asunto` varchar(200) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id`, `Nombre`, `correo`, `telefono`, `asunto`, `mensaje`, `fecha`) VALUES
(2, 'Tania Carrillo', 'TaniaCarrillo@gmail.com', '1221424231', 'Se pelió Con Yael', 'Ile vio todo\r\nSi ya vi', '2026-10-01 09:19:41'),
(3, 'Thomas Lopera Muñoz', 'thomaslm1002@gmail.com', '1001324242', 'AAAAA', 'ADAODAFOASF', '2026-10-08 22:34:33'),
(4, 'Melanny Valderrama', 'Mely@gmail.com', '1001324242', 'aaa', 'aaa', '2026-10-13 06:49:58'),
(5, 'Isabella Guerra Ciro', 'isabguerra@gmail.com', '132424223', 'Extraño a Mateo', 'Lo amo y lo extraño', '2026-10-15 11:16:31'),
(6, 'Thomas', 'thomaslm1002@gmail.com', '2242421', 'loí', 'buyuihy', '2026-10-15 15:18:16'),
(7, 'Maria Jose', 'mariajose@gmail.com', '13131313', 'cvsvsvs', '3fwfsfsdfs', '2026-10-15 15:18:37'),
(11, 'Luisa Fernanda', 'luisafer@gmail.com', '242424', 'Hola n', 'Como están', '2026-10-16 09:25:35'),
(14, 'Luisa Fernanda', 'luisafer@gmail.com', '1001324242', 'holaaa', 'kkh', '2026-10-16 10:10:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registrar`
--

CREATE TABLE `registrar` (
  `id` int(5) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `correo` text NOT NULL,
  `Clave` varchar(255) NOT NULL,
  `ConfirmarClave` varchar(255) NOT NULL,
  `TipoCuenta` varchar(20) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registrar`
--

INSERT INTO `registrar` (`id`, `Nombre`, `correo`, `Clave`, `ConfirmarClave`, `TipoCuenta`, `fecha_registro`) VALUES
(2, 'Maria Jose', 'mariajose@gmail.com', '$2y$10$9dgdJCYIXp5USNkHOwV27.k/tesamjoPl.AG1IGojw3lvzpRuycmW', '', 'usuario', '2026-10-01 09:16:46'),
(3, 'Thomas Lopera Muñoz', 'thomaslm1002@gmail.com', '$2y$10$DiEcvhnoT/Vaj0yCqGI9POUTRK2Ee9lXFKMlx5OaPoMWCQw5yVlGG', '', 'administrador', '2026-10-01 09:16:46'),
(4, 'Luisa Fernanda', 'luisafernanda@gmail.com', '$2y$10$j77FaM1eLPj72SKDDXMyW.iNkzLAoJME4vR0H7caYb3f1x6Z.b3xW', '', 'usuario', '2026-10-01 09:16:46'),
(5, 'Tania Carrillo', 'TaniaCarrillo@gmail.com', '$2y$10$jJhWo6KAwkpC58oUnpGJwOKkGcA8fjf9hnWRGFaj.LVOrR77mPA/2', '', 'usuario', '2026-10-01 09:16:46'),
(10, 'Sor Mirella', 'ayerim2007@gmail.com', '$2y$10$7MlDUMXGGaxdJuzpcVw5xuuIiz2NUg3Jmnr3ECnXMzFbnOpF4GhFu', '', 'usuario', '2026-10-01 09:16:46'),
(11, 'Oriel De Jesús', 'Oriellopera@gmail.com', '$2y$10$EMuetVq6Q/a5I8i4Hm1iMug.rySl7/O0R3VatYg1.zpj3LM7HkjB2', '', 'usuario', '2026-10-01 09:16:46'),
(12, 'Rosa', 'rosa@gmail.com', '$2y$10$r7RcGZTKDVbJifj6ZYIu9.XuB8a.Iz5MsmLEH9QhDQ2Wyzpc5B3oO', '', 'usuario', '2026-10-01 09:16:46'),
(13, 'Harold Montoya', 'Harold@gmail.com', '$2y$10$PgPJy7BtOgvkoUEUAw.x.u3yplngZ7S6fRk/9ztyP5pMvUaXTbUhC', '', 'usuario', '2026-10-01 09:16:46'),
(14, 'Maicol Puerta', 'Maicolp@gmail.com', '$2y$10$FkDxLh8SBSU.NlIrvilYGubSvZG5hgZ463eiA8KPU3ZQhg542ZKca', '', 'usuario', '2026-10-01 10:06:10'),
(15, 'Juan Fernando', 'Juanfer@gmail.com', '$2y$10$P7sSPcbr8fxjI7HiT55R8uUqzhg7SQM2o2vIQjANQPA6gjAzOcKfu', '', 'usuario', '2026-10-07 21:07:26'),
(16, 'Melanny Valderrama', 'Mely@gmail.com', '$2y$10$dtlTOzYElWrbExbmwLd5bOZDMz6VQ6aX92RS5uh6GqqnC930z2GtO', '', 'usuario', '2026-10-10 15:52:49'),
(17, 'Alba', 'alba@gmail.com', '$2y$10$sbmvEEi1N3fAMcBajpocb.8s2NX1HBgwzPf/4sfFfj/edtPyhTqDG', '', 'usuario', '2026-10-11 02:12:22'),
(18, 'Luisa Fernanda', 'luisafer@gmail.com', '$2y$10$/nV0ed5COhPX5j6BXuPQm.I.OYZLrFFPr5N.djRvbg8efj7ovSFM2', '', 'usuario', '2026-10-13 06:55:37'),
(19, 'Alejandro', 'Ale@gmail.com', '$2y$10$kPvkDnNCJtH8LUjjUV4vZeCI3yO8PGD9zYIh4MFGeoNJVbkolcE/O', '', 'usuario', '2026-10-13 06:58:09'),
(1000, 'juan', 'juann@gmail.com', '$2y$10$XW0VjD2VCNvfMA3nx9sMSed4SXrYtQfkl28oBZ1/13LfOIQqp2wJC', '', 'usuario', '2026-10-16 07:08:53'),
(1001, 'manuel muñoz', 'emejo@gmail.com', '$2y$10$VzUshzdlbErovyr6IxuN2uRIicoBiOPjOCzmWhte32wPauMeysQC6', '', 'usuario', '2026-10-16 08:29:05'),
(1002, 'Julio Profe', 'julioprofe@gmail.com', '$2y$10$0jljnPUgMoHvh6.scomQIu/5uD/XEryqiZfHT74Lum.TwnO8GZCNi', '', 'usuario', '2026-10-27 08:17:59');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registrar`
--
ALTER TABLE `registrar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`) USING HASH;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `registrar`
--
ALTER TABLE `registrar`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
