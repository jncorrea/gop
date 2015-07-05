-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-07-2015 a las 20:51:33
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
  `COSTO` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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
  `EJE_X` char(6) DEFAULT NULL,
  `EJE_Y` char(6) DEFAULT NULL,
  `EQUIPO` char(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
`ID_GRUPO` int(11) NOT NULL,
  `NOMBRE_GRUPO` char(200) NOT NULL,
  `OWNER` char(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`ID_GRUPO`, `NOMBRE_GRUPO`, `OWNER`) VALUES
(2, 'C++ que tú', 'migranda@utpl.edu.ec'),
(9, 'Los dormidos', 'esquezada1@utpl.edu.ec'),
(10, 'Grupo SIs', 'migranda@utpl.edu.ec');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_miembros`
--

CREATE TABLE IF NOT EXISTS `grupos_miembros` (
  `EMAIL` char(150) NOT NULL,
  `ID_GRUPO` int(11) NOT NULL,
  `estado` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupos_miembros`
--

INSERT INTO `grupos_miembros` (`EMAIL`, `ID_GRUPO`, `estado`) VALUES
('esquezada1@utpl.edu.ec', 2, '1'),
('esquezada1@utpl.edu.ec', 9, '1'),
('jncorrea@utpl.edu.ec', 2, '0'),
('migranda@utpl.edu.ec', 2, '0');

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
('esquezada1@utpl.edu.ec', '123', 'Edgar', 'Quezada', '0990088726', '', 'user.jpeg'),
('jncorrea@utpl.edu.ec', '456', NULL, NULL, NULL, NULL, NULL),
('migranda@utpl.edu.ec', '789', '', 'Granda Aguilar', '0969945150', 'Delantera', NULL);

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
  `ID_GRUPO` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`ID_PARTIDO`, `ID_CANCHA`, `FECHA`, `ESTADO`, `NOMEQUIPOA`, `NOMEQUIPOB`, `RESESQUIPOA`, `RESEQUIPOB`, `ID_GRUPO`) VALUES
(7, 1, '2015-07-22 21:00:00', '1', 'Equipo A', 'Equipo B', 0, 7, 2),
(8, 2, '2015-07-08 00:00:00', '1', 'Equipo A', 'Equipo B', 0, 0, 9);

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
 ADD PRIMARY KEY (`ID_PARTIDO`), ADD KEY `FK_ALBERGA` (`ID_CANCHA`), ADD KEY `FK_FORMAN` (`ID_GRUPO`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `canchas`
--
ALTER TABLE `canchas`
MODIFY `ID_CANCHA` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
MODIFY `ID_CONVOCATORIA` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
MODIFY `ID_GRUPO` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
MODIFY `ID_PARTIDO` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
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
ADD CONSTRAINT `FK_FORMAN` FOREIGN KEY (`ID_GRUPO`) REFERENCES `grupos` (`ID_GRUPO`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
