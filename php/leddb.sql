-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-09-2024 a las 08:52:29
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `leddb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `leds`
--

CREATE TABLE `leds` (
  `id` int(11) NOT NULL,
  `state` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `leds`
--

INSERT INTO `leds` (`id`, `state`) VALUES
(1, 1),
(2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logmovimiento`
--

CREATE TABLE `logmovimiento` (
  `idReporte` int(11) NOT NULL,
  `Hora` time NOT NULL,
  `Fecha` date NOT NULL,
  `imagen` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `logmovimiento`
--

INSERT INTO `logmovimiento` (`idReporte`, `Hora`, `Fecha`, `imagen`) VALUES
(1, '08:43:04', '2024-09-04', NULL),
(2, '08:52:11', '2024-09-04', NULL),
(3, '09:08:26', '2024-09-04', NULL),
(4, '02:21:20', '2024-09-03', NULL),
(5, '03:22:29', '2024-09-03', NULL),
(6, '04:22:29', '2024-09-03', NULL),
(7, '01:22:29', '2024-09-03', NULL),
(8, '01:22:29', '2024-09-02', NULL),
(9, '18:26:49', '2024-09-04', NULL),
(10, '18:27:30', '2024-09-04', NULL),
(11, '05:04:42', '2024-09-05', NULL),
(12, '05:12:10', '2024-09-05', NULL),
(13, '05:12:33', '2024-09-05', NULL),
(14, '05:17:15', '2024-09-05', NULL),
(15, '05:19:33', '2024-09-05', NULL),
(16, '05:25:47', '2024-09-05', NULL),
(17, '05:41:39', '2024-09-05', NULL),
(18, '06:57:10', '2024-09-05', NULL),
(19, '09:26:38', '2024-09-05', NULL),
(20, '09:30:26', '2024-09-05', NULL),
(21, '09:41:14', '2024-09-05', NULL),
(22, '12:05:42', '2024-09-05', NULL),
(23, '15:04:03', '2024-09-10', NULL),
(24, '15:14:12', '2024-09-10', NULL),
(25, '15:28:51', '2024-09-10', NULL),
(26, '15:31:16', '2024-09-10', NULL),
(27, '15:31:59', '2024-09-10', NULL),
(28, '15:45:21', '2024-09-10', NULL),
(29, '16:07:27', '2024-09-10', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`idUser`, `nombre`, `correo`, `password`, `status`) VALUES
(1, 'ThonyMarck', 'thonymarck385213xd@gmail.com', '0811273008', 'loggedOn');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `leds`
--
ALTER TABLE `leds`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logmovimiento`
--
ALTER TABLE `logmovimiento`
  ADD PRIMARY KEY (`idReporte`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `logmovimiento`
--
ALTER TABLE `logmovimiento`
  MODIFY `idReporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
