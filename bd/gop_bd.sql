-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-08-2015 a las 06:07:39
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `canchas`
--

INSERT INTO `canchas` (`ID_CANCHA`, `NOMBRE_CANCHA`, `DIRECCION_CANCHA`, `NUM_MAX`, `LATITUD`, `LONGITUD`, `COSTO`) VALUES
(1, 'La pampita', 'Av. Orillas del Zamora, Loja', 12, '-3.977599', '-79.202093', 25),
(2, 'Punto Sport', 'Azuay 11-18 y Juan José Peña', 8, '-4.0002533', '-79.1987175', 18),
(3, 'Maxfutbol', 'Av. 8 de Diciembre y Jaime Roldos Aguilera (Redondel de las Pitas), Loja', 12, '-3.9695182', '-79.2076872', 20),
(4, 'Cancha Sintetica La Rdonda', 'Pifo, Quito', 14, '-0.2315431', '-78.3387828', 25);


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
`id` int(10) unsigned NOT NULL,
  `from` varchar(255) NOT NULL DEFAULT '',
  `to` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recd` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE IF NOT EXISTS `comentarios` (
`id_comentario` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `id_partido` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `comentario` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convocatoria`
--

CREATE TABLE IF NOT EXISTS `convocatoria` (
`ID_CONVOCATORIA` int(11) NOT NULL,
  `EMAIL` char(150) DEFAULT NULL,
  `ID_PARTIDO` int(11) DEFAULT NULL,
  `POSICION` int(11) DEFAULT NULL,
  `EQUIPO` char(150) DEFAULT NULL,
  `ESTADO` varchar(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
`ID_GRUPO` int(11) NOT NULL,
  `NOMBRE_GRUPO` char(200) NOT NULL,
  `OWNER` char(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_miembros`
--

CREATE TABLE IF NOT EXISTS `grupos_miembros` (
  `EMAIL` char(150) NOT NULL,
  `ID_GRUPO` int(11) NOT NULL,
  `ESTADO` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembros`
--

CREATE TABLE IF NOT EXISTS `miembros` (
  `EMAIL` char(150) NOT NULL,
  `PASS` char(250) NOT NULL,
  `USER` varchar(100) NOT NULL,
  `NOMBRES` char(200) DEFAULT NULL,
  `APELLIDOS` char(200) DEFAULT NULL,
  `CELULAR` char(15) DEFAULT NULL,
  `POSICION` char(50) DEFAULT NULL,
  `AVATAR` char(10) DEFAULT NULL,
  `ESTADO` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE IF NOT EXISTS `partidos` (
`ID_PARTIDO` int(11) NOT NULL,
  `ID_GRUPO` int(11) NOT NULL,
  `ID_CANCHA` int(11) DEFAULT NULL,
  `FECHA` datetime DEFAULT NULL,
  `ESTADO` char(10) DEFAULT NULL,
  `NOMEQUIPOA` char(150) DEFAULT NULL,
  `NOMEQUIPOB` char(150) DEFAULT NULL,
  `RESEQUIPOA` int(11) DEFAULT NULL,
  `RESEQUIPOB` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temp`
--

CREATE TABLE IF NOT EXISTS `temp` (
`id_temp` int(11) NOT NULL,
  `email_temp` varchar(150) NOT NULL,
  `grupo_temp` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `canchas`
--
ALTER TABLE `canchas`
 ADD PRIMARY KEY (`ID_CANCHA`);

--
-- Indices de la tabla `chat`
--
ALTER TABLE `chat`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
 ADD PRIMARY KEY (`id_comentario`);

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
 ADD PRIMARY KEY (`ID_PARTIDO`), ADD KEY `FK_ALBERGA` (`ID_CANCHA`), ADD KEY `FK_FORMA` (`ID_GRUPO`);

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
MODIFY `ID_CANCHA` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `chat`
--
ALTER TABLE `chat`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
MODIFY `ID_CONVOCATORIA` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
MODIFY `ID_GRUPO` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
MODIFY `ID_PARTIDO` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `temp`
--
ALTER TABLE `temp`
MODIFY `id_temp` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
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
