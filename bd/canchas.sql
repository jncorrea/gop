-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-08-2015 a las 18:23:29
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `gop_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canchas`
--

CREATE TABLE IF NOT EXISTS `canchas` (
`ID_CANCHA` int(11) NOT NULL,
  `NOMBRE_CANCHA` char(150) NOT NULL,
  `DIRECCION_CANCHA` char(200) DEFAULT NULL,
  `NUM_MAX` int(11) DEFAULT NULL,
  `LATITUD` char(50) DEFAULT NULL,
  `LONGITUD` char(50) DEFAULT NULL,
  `COSTO` int(11) DEFAULT NULL,
  `HORA_INICIO` time NOT NULL,
  `HORA_FIN` time NOT NULL,
  `admin` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `canchas`
--

INSERT INTO `canchas` (`ID_CANCHA`, `NOMBRE_CANCHA`, `DIRECCION_CANCHA`, `NUM_MAX`, `LATITUD`, `LONGITUD`, `COSTO`, `HORA_INICIO`, `HORA_FIN`, `admin`) VALUES
(1, 'Cancha ejemplo', 'Loja', 12, '-4.3651522', '-79.1999994', 25, '00:00:00', '00:00:00', ''),
(2, 'Cancha Sintética de la UTPL', 'Instalaciones de la Universidad Técnica Particular de Loja', 18, '-4.032945', '-79.202649', 0, '00:00:00', '00:00:00', ''),
(4, 'Punto Sport', 'Azuay 11-18 y Juan JosÃ© PeÃ±a', 8, '-4.0002533', '-79.1987175', 18, '00:00:00', '00:00:00', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `canchas`
--
ALTER TABLE `canchas`
 ADD PRIMARY KEY (`ID_CANCHA`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `canchas`
--
ALTER TABLE `canchas`
MODIFY `ID_CANCHA` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
