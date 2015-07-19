-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-07-2015 a las 07:34:58
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `canchas`
--

INSERT INTO `canchas` (`ID_CANCHA`, `NOMBRE_CANCHA`, `DIRECCION_CANCHA`, `NUM_MAX`, `LATITUD`, `LONGITUD`, `COSTO`) VALUES
(1, 'Cancha ejemplo', 'Loja', 12, NULL, NULL, 25);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `chat`
--

INSERT INTO `chat` (`id`, `from`, `to`, `message`, `sent`, `recd`) VALUES
(1, 'jncorrea', 'esquezada1', 'hola', '2015-07-18 23:17:01', 1),
(2, 'esquezada1', 'jncorrea', 'hola', '2015-07-18 23:22:19', 1),
(3, 'jncorrea', 'esquezada1', 'como tas?', '2015-07-18 23:22:38', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `email`, `id_partido`, `fecha`, `comentario`) VALUES
(1, 'migranda@utpl.edu.ec', 9, '2015-07-08 00:00:00', 'Muy buen partido'),
(8, 'migranda@utpl.edu.ec', 9, '2015-07-13 00:00:00', 'Felicitaciones'),
(9, 'esquezada1@utpl.edu.ec', 10, '2015-07-18 13:07:58', 'Felicitaciones a los ganadores\r\n      '),
(10, 'esquezada1@utpl.edu.ec', 10, '2015-07-18 13:12:58', '      \r\n      FElicitaciones seguir ganando'),
(11, 'esquezada1@utpl.edu.ec', 10, '2015-07-18 13:13:23', '      muy bien\r\n      '),
(12, 'esquezada1@utpl.edu.ec', 10, '2015-07-18 13:14:47', '      \r\n      Exitos');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `convocatoria`
--

INSERT INTO `convocatoria` (`ID_CONVOCATORIA`, `EMAIL`, `ID_PARTIDO`, `POSICION`, `EQUIPO`, `ESTADO`) VALUES
(1, 'esquezada1@utpl.edu.ec', 13, 22, 'Equipo B', '1'),
(2, 'jncorrea@utpl.edu.ec', 13, 12, 'Equipo A', '1'),
(3, 'jperez@gmail.com', 13, 28, 'Equipo A', '1'),
(4, 'esquezada1@utpl.edu.ec', 14, 20, 'Equipo A', '1'),
(5, 'jncorrea@utpl.edu.ec', 14, 0, '', '0'),
(6, 'jperez@gmail.com', 14, 22, 'Equipo B', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
`ID_GRUPO` int(11) NOT NULL,
  `NOMBRE_GRUPO` char(200) NOT NULL,
  `OWNER` char(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`ID_GRUPO`, `NOMBRE_GRUPO`, `OWNER`) VALUES
(1, 'UTPL-2015', 'esquezada1@utpl.edu.ec'),
(3, 'otro grupo', 'esquezada1@utpl.edu.ec'),
(4, 'grupo prueba', 'esquezada1@utpl.edu.ec'),
(5, 'utpl', 'rlramirez@utpl.edu.ec');

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
('esquezada1@utpl.edu.ec', 4, '1'),
('esquezada1@utpl.edu.ec', 5, '1'),
('jncorrea@utpl.edu.ec', 1, '1'),
('jncorrea@utpl.edu.ec', 4, '0'),
('jncorrea@utpl.edu.ec', 5, '0'),
('jperez@gmail.com', 1, '1'),
('rlramirez@utpl.edu.ec', 5, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembros`
--

CREATE TABLE IF NOT EXISTS `miembros` (
  `EMAIL` char(150) NOT NULL,
  `PASS` char(25) NOT NULL,
  `USER` varchar(100) NOT NULL,
  `NOMBRES` char(200) DEFAULT NULL,
  `APELLIDOS` char(200) DEFAULT NULL,
  `CELULAR` char(15) DEFAULT NULL,
  `POSICION` char(50) DEFAULT NULL,
  `AVATAR` char(10) DEFAULT NULL,
  `ESTADO` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `miembros`
--

INSERT INTO `miembros` (`EMAIL`, `PASS`, `USER`, `NOMBRES`, `APELLIDOS`, `CELULAR`, `POSICION`, `AVATAR`, `ESTADO`) VALUES
('esquezada1@utpl.edu.ec', '123', 'esquezada1', 'Edgar', 'Quezada', '0990128372', '', 'user.jpeg', 1),
('jncorrea@utpl.edu.ec', '12345', 'jncorrea', 'Jessica', 'Correa', '0991025208', '', '', 1),
('jperez@gmail.com', '12345', 'jperez', '', '', '', '', '', 0),
('j_perez@utpl.edu.ec', '12345', 'jperez-96', '', '', '', '', '', 0),
('rlramirez@utpl.edu.ec', '12345', 'rlramirez', '', '', '', '', 'user.jpeg', 0);

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
  `RESESQUIPOA` int(11) DEFAULT NULL,
  `RESEQUIPOB` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`ID_PARTIDO`, `ID_GRUPO`, `ID_CANCHA`, `FECHA`, `ESTADO`, `NOMEQUIPOA`, `NOMEQUIPOB`, `RESESQUIPOA`, `RESEQUIPOB`) VALUES
(13, 1, 1, '2015-07-22 00:00:00', '1', 'Equipo A', 'Equipo B', 0, 0),
(14, 1, 1, '2015-07-24 00:00:00', '1', 'Equipo A', 'Equipo B', 0, 0);

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
-- Indices de la tabla `chat`
--
ALTER TABLE `chat`
 ADD PRIMARY KEY (`id`);

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
MODIFY `ID_CANCHA` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `chat`
--
ALTER TABLE `chat`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
MODIFY `ID_CONVOCATORIA` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
MODIFY `ID_GRUPO` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
MODIFY `ID_PARTIDO` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
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
