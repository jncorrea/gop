-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-08-2015 a las 19:11:27
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
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE IF NOT EXISTS `partidos` (
`ID_PARTIDO` int(11) NOT NULL,
  `ID_GRUPO` int(11) NOT NULL,
  `ID_CANCHA` int(11) DEFAULT NULL,
  `FECHA` date DEFAULT NULL,
  `HORA` time NOT NULL,
  `ESTADO` char(10) DEFAULT NULL,
  `NOMEQUIPOA` char(150) DEFAULT NULL,
  `NOMEQUIPOB` char(150) DEFAULT NULL,
  `RESEQUIPOA` int(11) DEFAULT NULL,
  `RESEQUIPOB` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`ID_PARTIDO`, `ID_GRUPO`, `ID_CANCHA`, `FECHA`, `HORA`, `ESTADO`, `NOMEQUIPOA`, `NOMEQUIPOB`, `RESEQUIPOA`, `RESEQUIPOB`) VALUES
(25, 13, 5, '2015-08-20', '21:00:00', '1', 'Equipo A', 'Equipo B', 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `partidos`
--
ALTER TABLE `partidos`
 ADD PRIMARY KEY (`ID_PARTIDO`), ADD KEY `FK_ALBERGA` (`ID_CANCHA`), ADD KEY `FK_FORMA` (`ID_GRUPO`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
MODIFY `ID_PARTIDO` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `partidos`
--
ALTER TABLE `partidos`
ADD CONSTRAINT `FK_ALBERGA` FOREIGN KEY (`ID_CANCHA`) REFERENCES `canchas` (`ID_CANCHA`),
ADD CONSTRAINT `FK_FORMA` FOREIGN KEY (`ID_GRUPO`) REFERENCES `grupos` (`ID_GRUPO`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
