-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-07-2015 a las 04:58:19
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
CREATE DATABASE IF NOT EXISTS `gop_bd` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gop_bd`;

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
  `COSTO` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `canchas`
--

INSERT INTO `canchas` (`ID_CANCHA`, `NOMBRE_CANCHA`, `DIRECCION_CANCHA`, `NUM_MAX`, `LATITUD`, `LONGITUD`, `COSTO`) VALUES
(1, 'PUNTO SPORT', 'CALLE AZUAY 11-18 Y JUAN JOSE PEÑA', 8, '-4.000102', '-79.198888', 18),
(2, 'CHAMPIONS', 'Daniel Alvárez', 12, '-4.020376', ' -79.217999', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convocatoria`
--

CREATE TABLE IF NOT EXISTS `convocatoria` (
`ID_CONVOCATORIA` int(11) NOT NULL,
  `EMAIL` char(150) DEFAULT NULL,
  `ID_PARTIDO` int(11) DEFAULT NULL,
  `POSICION` int(11) DEFAULT NULL,
  `EQUIPO` char(150) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `convocatoria`
--

INSERT INTO `convocatoria` (`ID_CONVOCATORIA`, `EMAIL`, `ID_PARTIDO`, `POSICION`, `EQUIPO`) VALUES
(1, 'esquezada1@utpl.edu.ec', 1, NULL, NULL),
(2, 'jncorrea@utpl.edu.ec', 1, NULL, NULL),
(3, 'jperez@gmail.com', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
`ID_GRUPO` int(11) NOT NULL,
  `NOMBRE_GRUPO` char(200) NOT NULL,
  `OWNER` char(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`ID_GRUPO`, `NOMBRE_GRUPO`, `OWNER`) VALUES
(1, 'UTPL-2015', 'esquezada1@utpl.edu.ec'),
(3, 'otro grupo', 'esquezada1@utpl.edu.ec');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_miembros`
--

CREATE TABLE IF NOT EXISTS `grupos_miembros` (
  `EMAIL` char(150) NOT NULL,
  `ID_GRUPO` int(11) NOT NULL,
  `ESTADO` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupos_miembros`
--

INSERT INTO `grupos_miembros` (`EMAIL`, `ID_GRUPO`, `ESTADO`) VALUES
('esquezada1@utpl.edu.ec', 1, '1'),
('esquezada1@utpl.edu.ec', 3, '1'),
('jncorrea@utpl.edu.ec', 1, '1'),
('jperez@gmail.com', 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembros`
--

CREATE TABLE IF NOT EXISTS `miembros` (
  `EMAIL` char(150) NOT NULL,
  `PASS` char(25) NOT NULL,
  `NOMBRES` char(200) DEFAULT NULL,
  `APELLIDOS` char(200) DEFAULT NULL,
  `CELULAR` char(15) DEFAULT NULL,
  `POSICION` char(50) DEFAULT NULL,
  `AVATAR` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `miembros`
--

INSERT INTO `miembros` (`EMAIL`, `PASS`, `NOMBRES`, `APELLIDOS`, `CELULAR`, `POSICION`, `AVATAR`) VALUES
('esquezada1@utpl.edu.ec', '123', 'Edgar', 'Quezada', '0990128372', '', 'user.jpeg'),
('jncorrea@utpl.edu.ec', '12345', 'Jessica', 'Correa', '0991025208', 'Delantero', ''),
('jperez@gmail.com', '12345', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE IF NOT EXISTS `partidos` (
`ID_PARTIDO` int(11) NOT NULL,
  `ID_CANCHA` int(11) DEFAULT NULL,
  `FECHA` datetime DEFAULT NULL,
  `ESTADO` char(10) DEFAULT NULL,
  `NOMEQUIPOA` char(150) DEFAULT NULL,
  `NOMEQUIPOB` char(150) DEFAULT NULL,
  `RESESQUIPOA` int(11) DEFAULT NULL,
  `RESEQUIPOB` int(11) DEFAULT NULL,
  `ID_GRUPO` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`ID_PARTIDO`, `ID_CANCHA`, `FECHA`, `ESTADO`, `NOMEQUIPOA`, `NOMEQUIPOB`, `RESESQUIPOA`, `RESEQUIPOB`, `ID_GRUPO`) VALUES
(1, 1, '2015-07-22 21:00:00', '1', 'Equipo A', 'Equipo B', 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temp`
--

CREATE TABLE IF NOT EXISTS `temp` (
`id_temp` int(11) NOT NULL,
  `email_temp` varchar(150) NOT NULL,
  `grupo_temp` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `temp`
--

INSERT INTO `temp` (`id_temp`, `email_temp`, `grupo_temp`) VALUES
(4, 'nattyc0906@gmail.com', '1'),
(5, 'migranda@utpl.edu.ec', '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `canchas`
--
ALTER TABLE `canchas`
 ADD PRIMARY KEY (`ID_CANCHA`);

--
-- Indices de la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
 ADD PRIMARY KEY (`ID_CONVOCATORIA`), ADD KEY `FK_ASISTEN` (`EMAIL`), ADD KEY `FK_HACE` (`ID_PARTIDO`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
 ADD PRIMARY KEY (`ID_GRUPO`);

--
-- Indices de la tabla `grupos_miembros`
--
ALTER TABLE `grupos_miembros`
 ADD PRIMARY KEY (`EMAIL`,`ID_GRUPO`), ADD KEY `FK_PERTENECE2` (`ID_GRUPO`);

--
-- Indices de la tabla `miembros`
--
ALTER TABLE `miembros`
 ADD PRIMARY KEY (`EMAIL`);

--
-- Indices de la tabla `partidos`
--
ALTER TABLE `partidos`
 ADD PRIMARY KEY (`ID_PARTIDO`), ADD UNIQUE KEY `FK_FORMA` (`ID_GRUPO`), ADD KEY `FK_ALBERGA` (`ID_CANCHA`);

--
-- Indices de la tabla `temp`
--
ALTER TABLE `temp`
 ADD PRIMARY KEY (`id_temp`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `canchas`
--
ALTER TABLE `canchas`
MODIFY `ID_CANCHA` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
MODIFY `ID_CONVOCATORIA` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
MODIFY `ID_GRUPO` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
MODIFY `ID_PARTIDO` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `temp`
--
ALTER TABLE `temp`
MODIFY `id_temp` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
ADD CONSTRAINT `FK_ASISTEN` FOREIGN KEY (`EMAIL`) REFERENCES `miembros` (`EMAIL`),
ADD CONSTRAINT `FK_HACE` FOREIGN KEY (`ID_PARTIDO`) REFERENCES `partidos` (`ID_PARTIDO`);

--
-- Filtros para la tabla `grupos_miembros`
--
ALTER TABLE `grupos_miembros`
ADD CONSTRAINT `FK_PERTENECE` FOREIGN KEY (`EMAIL`) REFERENCES `miembros` (`EMAIL`),
ADD CONSTRAINT `FK_PERTENECE2` FOREIGN KEY (`ID_GRUPO`) REFERENCES `grupos` (`ID_GRUPO`);

--
-- Filtros para la tabla `partidos`
--
ALTER TABLE `partidos`
ADD CONSTRAINT `FK_ALBERGA` FOREIGN KEY (`ID_CANCHA`) REFERENCES `canchas` (`ID_CANCHA`),
ADD CONSTRAINT `FK_FORMA` FOREIGN KEY (`ID_GRUPO`) REFERENCES `grupos` (`ID_GRUPO`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
