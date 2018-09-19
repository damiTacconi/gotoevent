-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 19-09-2018 a las 19:25:56
-- Versión del servidor: 5.7.19-log
-- Versión de PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gotoevent`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `getcliente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `getcliente` (IN `email` VARCHAR(50), IN `password` VARCHAR(20))  begin
select cli.* from clientes cli inner join usuarios us on cli.id_usuario=us.id_usuario where
us.email=email and us.password=password;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendarios`
--

DROP TABLE IF EXISTS `calendarios`;
CREATE TABLE IF NOT EXISTS `calendarios` (
  `id_calendario` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id_calendario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(40) NOT NULL,
  `dni` varchar(9) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_cliente`),
  KEY `fk_clientes_x_id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

DROP TABLE IF EXISTS `eventos`;
CREATE TABLE IF NOT EXISTS `eventos` (
  `id_evento` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(15) NOT NULL,
  `fecha_desde` date DEFAULT NULL,
  `fecha_hasta` date DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_calendario` int(11) NOT NULL,
  PRIMARY KEY (`id_evento`),
  UNIQUE KEY `unq_evento_titulo` (`titulo`),
  KEY `fk_id_evento_x_id_categoria` (`id_categoria`),
  KEY `fk_id_evento_x_id_calendario` (`id_calendario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plaza_eventos`
--

DROP TABLE IF EXISTS `plaza_eventos`;
CREATE TABLE IF NOT EXISTS `plaza_eventos` (
  `id_plaza_evento` int(11) NOT NULL AUTO_INCREMENT,
  `capacidad` int(11) NOT NULL,
  `remanente` int(11) NOT NULL,
  `id_tipo_plaza` int(11) NOT NULL,
  `id_calendario` int(11) NOT NULL,
  `id_sede` int(11) NOT NULL,
  PRIMARY KEY (`id_plaza_evento`),
  KEY `fk_id_plaza_eventos_x_id_sede` (`id_sede`),
  KEY `fk_id_plaza_eventos_x_id_calendario` (`id_calendario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sedes`
--

DROP TABLE IF EXISTS `sedes`;
CREATE TABLE IF NOT EXISTS `sedes` (
  `id_sede` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(20) NOT NULL,
  `capacidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_sede`),
  UNIQUE KEY `unq_descripcion` (`descripcion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_plazas`
--

DROP TABLE IF EXISTS `tipo_plazas`;
CREATE TABLE IF NOT EXISTS `tipo_plazas` (
  `id_tipo_plaza` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(15) NOT NULL,
  `id_sede` int(11) NOT NULL,
  PRIMARY KEY (`id_tipo_plaza`),
  KEY `fk_id_tipo_plazas_x_id_sedes` (`id_sede`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `unq_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_x_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `fk_id_evento_x_id_calendario` FOREIGN KEY (`id_calendario`) REFERENCES `calendarios` (`id_calendario`),
  ADD CONSTRAINT `fk_id_evento_x_id_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

--
-- Filtros para la tabla `plaza_eventos`
--
ALTER TABLE `plaza_eventos`
  ADD CONSTRAINT `fk_id_plaza_eventos_x_id_calendario` FOREIGN KEY (`id_calendario`) REFERENCES `calendarios` (`id_calendario`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_id_plaza_eventos_x_id_sede` FOREIGN KEY (`id_sede`) REFERENCES `sedes` (`id_sede`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_id_plaza_eventos_x_id_tipo_plaza` FOREIGN KEY (`id_plaza_evento`) REFERENCES `tipo_plazas` (`id_tipo_plaza`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tipo_plazas`
--
ALTER TABLE `tipo_plazas`
  ADD CONSTRAINT `fk_id_tipo_plazas_x_id_sedes` FOREIGN KEY (`id_sede`) REFERENCES `sedes` (`id_sede`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

