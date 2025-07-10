-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: sql102.infinityfree.com
-- Tiempo de generación: 10-07-2025 a las 13:40:21
-- Versión del servidor: 11.4.7-MariaDB
-- Versión de PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `if0_38917778_azul`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tu_arte`
--

CREATE TABLE `tu_arte` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `imagen_url` text NOT NULL,
  `emocion` varchar(100) DEFAULT NULL,
  `estilo` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tu_arte`
--

INSERT INTO `tu_arte` (`id`, `user_id`, `titulo`, `imagen_url`, `emocion`, `estilo`, `descripcion`, `fecha_subida`) VALUES
(1, 0, 'Almendro en flor - Vincent Van Gogh\r\n', 'https://www.reprodart.com/kunst/vincent_van_gogh/bluehende-mandelbaumzweig-5093000.jpg', 'Alegría', 'Impresionismo\r\n', '92 x 74 cm\r\nTécnica :Oleo sobre lienzo\r\n', '0000-00-00 00:00:00'),
(9, 4, 'La joven de la perla. ', 'uploads/6866fb2b36873_la joven.jpg', 'Melancolia', 'Barroco', '\"La Joven de la Perla\", tambiÃ©n conocida como \"Muchacha con turbante\", es una de las obras mÃ¡s emblemÃ¡ticas de Johannes Vermeer, creada entre 1665 y 1667. Esta pintura, que se encuentra en el museo Mauritshuis de La Haya, destaca por su representaciÃ³n de una joven con un turbante y un pendiente de perla, y es considerada un \"tronie\", es decir, una representaciÃ³n de un personaje imaginario mÃ¡s que un retrato. ', '2025-07-03 21:50:35'),
(6, 5, 'La muerte de Ofelia', 'uploads/684b1da84bfe4_melancolia.jpg', 'Melancolia', 'barroco', 'Este cuadro, pintado por John Everett Millais, representa el trÃ¡gico final de Ofelia, la dama de la cÃ©lebre novela de Shakespeare Hamlet, trÃ¡gicamente ahogada en un arroyo, lo cual pone fin a su sufrimiento.', '2025-06-12 18:34:16'),
(7, 5, 'Ferrocarril', 'uploads/68640f483bc69_ferrocaril.jpg', 'Alegría', 'barroco', 'JosÃ© MarÃ­a Velazco (Paisajista mexicano)', '2025-07-01 16:39:36'),
(10, 4, 'El puente japonÃ©s', 'uploads/686c69bed9c05_El puente japonÃ©s.webp', 'Amor', 'Impresionismo', 'El cuadro El puente japonÃ©s, Monet lo realizÃ³ en una etapa previa a la construcciÃ³n del estudio en Giverny. Al momento de trabajar en este cuadro Monet tuvo que fijar su caballete sobre la tierra, apartarse las moscas que le sobrevolaban y trabajar con el sol como testigo.', '2025-07-08 00:43:42'),
(11, 7, 'Halo: La caida de Reach', 'uploads/686d33bb5fcc2_REACH.jpg', 'tristeza', 'Futurismo', 'Para el Covenant un triunfo birrico, para la humanidad una tragica derrota', '2025-07-08 15:05:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verify_token` varchar(100) DEFAULT NULL,
  `imagen_perfil` varchar(255) DEFAULT 'img/perfil_default.png'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `verify_token`, `imagen_perfil`) VALUES
(4, 'Karla', 'km2281567@gmail.com', '$2y$10$H0Gnks.yrgDUxXiqtrq.Qe2rz62V9w5Y8U0arVqr.EiDsszmzTtKm', '5c1b330b578ff0e5f9508f0e31e08464e3053d3f6cb5901ad8e5b76132d6f3ac', 'uploads/la joven.jpg'),
(5, 'Ana', 'lunafg712@gmail.com', '$2y$10$kOKUqDec8FBZxc.o9B8dVuGaUvm99NRNizzgXF0NeyJwxsfCFmPyW', '8dc5d80f7a264fa1becb2e3b2b77a209cca142b5db4d3f85f44d0d2348055381', 'uploads/perfil.jpg'),
(6, 'MarcJA', 'Marcelocrack55@gmail.com', '$2y$10$UUKMFafTMYFkgin3lj5CRuumdb5s0p/5llpyvMwrw0qlNPsRxSQBC', '77de249bfaa368a9649e530200145db0339eef063a804f6f5d3c6013054f1ec9', 'img/perfil_default.png'),
(7, 'StopAmister595', 'ancientbeyder@gmail.com', '$2y$10$QFEBWtvYjHnsce7KxaESMuXp3V.ad.CLj0OXwdS3oFmNSz9XN50su', '0816e35f17f9609a7ad72fc0483557a3dadd863a507ac1e1239bdf809b69f2fc', 'uploads/Gato Chico.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tu_arte`
--
ALTER TABLE `tu_arte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tu_arte`
--
ALTER TABLE `tu_arte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
