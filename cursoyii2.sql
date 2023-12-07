-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 06-12-2023 a las 20:42:54
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cursoyii2`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `Contaragotados`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Contaragotados` ()   BEGIN
DECLARE totalprod int;
SELECT COUNT(*) INTO totalprod
FROM productos
WHERE stock = 0;
SELECT totalprod AS 'contarp';
END$$

DROP PROCEDURE IF EXISTS `Contarclientes`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Contarclientes` ()   BEGIN
DECLARE totalcli int;
SELECT COUNT(*) INTO totalcli
FROM clientes
WHERE id>1;
SELECT totalcli AS 'contarc';
end$$

DROP PROCEDURE IF EXISTS `ObtenerCategoria`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerCategoria` ()   BEGIN
SELECT id, categoria_nombre FROM categoria;
END$$

DROP PROCEDURE IF EXISTS `ObtenerLogAccesos`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerLogAccesos` ()   BEGIN
	select * from log_accesos;
END$$

DROP PROCEDURE IF EXISTS `ObtenerTotal`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerTotal` ()   BEGIN
	DECLARE totalVentas DECIMAL(10,2);
SELECT SUM(Total) INTO totalVentas
FROM ventas
WHERE id_estado=1;
SELECT totalVentas AS TotalVentas;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria_nombre` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `categoria_nombre`) VALUES
(3, 'refrescos'),
(4, 'Lacteos'),
(5, 'Limpieza'),
(6, 'Verdura'),
(7, 'Sabritas'),
(8, 'Galletas'),
(9, 'Higiene');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `telefono`) VALUES
(1, 'Ninguno', '', ''),
(2, 'Gael', 'Tun', '9872437654'),
(3, 'Juan', 'Hoil', '9875643234'),
(4, 'Jennifer', 'Hau', '9875643212'),
(5, 'Santos', 'Dzib', '9874562312');

--
-- Disparadores `clientes`
--
DROP TRIGGER IF EXISTS `tg_insercionclientes`;
DELIMITER $$
CREATE TRIGGER `tg_insercionclientes` BEFORE INSERT ON `clientes` FOR EACH ROW BEGIN
INSERT INTO cursoyii2.log_accesos (usuario, fecha,nombre_cliente,apellido_cliente)
values (CURRENT_USER(),NOW(),NEW.nombre, NEW.apellido);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

DROP TABLE IF EXISTS `compras`;
CREATE TABLE IF NOT EXISTS `compras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `user_id` int NOT NULL,
  `id_proveedor` int NOT NULL,
  `id_estado` int NOT NULL,
  `adeudo` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `id_proveedor` (`id_proveedor`),
  KEY `id_estado` (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=227 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `fecha`, `user_id`, `id_proveedor`, `id_estado`, `adeudo`, `total`) VALUES
(226, '2023-12-06', 7, 2, 2, '0.00', '160.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

DROP TABLE IF EXISTS `detalle_compras`;
CREATE TABLE IF NOT EXISTS `detalle_compras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_compras` int NOT NULL,
  `user_id` int NOT NULL,
  `fecha` date NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `id_compras` (`id_compras`),
  KEY `id_producto` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_compras`
--

INSERT INTO `detalle_compras` (`id`, `id_compras`, `user_id`, `fecha`, `id_producto`, `cantidad`, `precio_compra`, `subtotal`) VALUES
(138, 226, 7, '2023-12-06', 8, '20.00', '8.00', '160.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

DROP TABLE IF EXISTS `detalle_ventas`;
CREATE TABLE IF NOT EXISTS `detalle_ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_ventas` int NOT NULL,
  `user_id` int NOT NULL,
  `fecha` date NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_producto` (`id_producto`),
  KEY `id_user` (`user_id`),
  KEY `id_ventas` (`id_ventas`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `id_ventas`, `user_id`, `fecha`, `id_producto`, `cantidad`, `precio_venta`, `subtotal`) VALUES
(110, 221, 7, '2023-12-04', 8, '2.00', '13.00', '26.00'),
(111, 221, 7, '2023-12-04', 10, '1.00', '17.00', '17.00'),
(112, 222, 7, '2023-12-04', 13, '2.00', '35.00', '70.00'),
(113, 225, 7, '2023-12-04', 10, '3.00', '17.00', '51.00'),
(114, 225, 7, '2023-12-04', 9, '3.00', '28.00', '84.00'),
(115, 227, 7, '2023-12-06', 8, '40.00', '13.00', '520.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deuda`
--

DROP TABLE IF EXISTS `deuda`;
CREATE TABLE IF NOT EXISTS `deuda` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_venta` int NOT NULL,
  `monto_pendiente` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_venta` (`id_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `deuda`
--

INSERT INTO `deuda` (`id`, `id_venta`, `monto_pendiente`) VALUES
(17, 221, '0.00'),
(18, 222, '0.00'),
(19, 223, '0.00'),
(20, 224, '0.00'),
(21, 225, '0.00'),
(22, 226, '0.00'),
(23, 227, '20.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

DROP TABLE IF EXISTS `estado`;
CREATE TABLE IF NOT EXISTS `estado` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `estado_nombre` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `estado_valor` smallint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id`, `estado_nombre`, `estado_valor`) VALUES
(1, 'Activo', 10),
(2, 'Pendiente', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadoventa`
--

DROP TABLE IF EXISTS `estadoventa`;
CREATE TABLE IF NOT EXISTS `estadoventa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `estado_venta` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estadoventa`
--

INSERT INTO `estadoventa` (`id`, `estado_venta`) VALUES
(1, 'Pagado'),
(2, 'Credito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

DROP TABLE IF EXISTS `genero`;
CREATE TABLE IF NOT EXISTS `genero` (
  `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `genero_nombre` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`id`, `genero_nombre`) VALUES
(1, 'masculino'),
(2, 'femenino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_accesos`
--

DROP TABLE IF EXISTS `log_accesos`;
CREATE TABLE IF NOT EXISTS `log_accesos` (
  `codigo` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `nombre_cliente` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `apellido_cliente` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `log_accesos`
--

INSERT INTO `log_accesos` (`codigo`, `usuario`, `fecha`, `nombre_cliente`, `apellido_cliente`) VALUES
(3, 'root@localhost', '2023-11-24 12:24:03', 'Adrián', 'Gomez'),
(4, 'root@localhost', '2023-11-26 23:48:08', 'Ninguno', ''),
(5, 'root@localhost', '2023-11-26 23:48:08', 'Gael', 'Tun'),
(6, 'root@localhost', '2023-11-26 23:49:30', 'Juan', 'Hoil'),
(7, 'root@localhost', '2023-11-26 23:49:30', 'Jennifer', 'Hau'),
(8, 'root@localhost', '2023-12-03 12:27:50', 'Santos', 'Dzib');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) COLLATE utf8mb4_general_ci NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1693548325),
('m130524_201442_init', 1693548435),
('m190124_110200_add_verification_token_column_to_user_table', 1693548435);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

DROP TABLE IF EXISTS `movimientos`;
CREATE TABLE IF NOT EXISTS `movimientos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_tipo` int NOT NULL,
  `motivo` text COLLATE utf8mb4_general_ci NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `user_id` int NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `id_tipo` (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `id_tipo`, `motivo`, `monto`, `user_id`, `fecha`) VALUES
(2, 1, 'Prestamo', '30.50', 7, '2023-11-27 00:00:00'),
(4, 1, 'Reposicion efectivo', '50.00', 7, '2023-12-05 00:00:00'),
(5, 2, 'Prestamo personal', '100.00', 7, '2023-12-05 04:58:34');

--
-- Disparadores `movimientos`
--
DROP TRIGGER IF EXISTS `tg_auditoria_eliminarmovimiento`;
DELIMITER $$
CREATE TRIGGER `tg_auditoria_eliminarmovimiento` BEFORE DELETE ON `movimientos` FOR EACH ROW BEGIN
INSERT INTO cursoyii2.trdelete (usuario,fecha,motivo,monto,userprograma)
VALUES (CURRENT_USER(),NOW(),OLD.motivo,OLD.monto,OLD.user_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

DROP TABLE IF EXISTS `pago`;
CREATE TABLE IF NOT EXISTS `pago` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_venta` int NOT NULL,
  `id_deuda` int NOT NULL,
  `fecha` date NOT NULL,
  `monto_pagado` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_venta` (`id_venta`,`id_deuda`),
  KEY `id_deuda` (`id_deuda`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id`, `id_venta`, `id_deuda`, `fecha`, `monto_pagado`) VALUES
(19, 221, 17, '2023-12-04', '50.00'),
(20, 222, 18, '2023-12-04', '60.00'),
(21, 223, 19, '2023-12-04', '14.00'),
(22, 223, 19, '2023-12-04', '1.00'),
(23, 224, 20, '2023-12-04', '10.00'),
(24, 224, 20, '2023-12-04', '5.00'),
(25, 221, 17, '2023-12-04', '10.50'),
(26, 225, 21, '2023-12-04', '35.00'),
(27, 222, 18, '2023-12-04', '5.00'),
(28, 225, 21, '2023-12-04', '100.00'),
(29, 226, 22, '2023-12-06', '17.50'),
(30, 227, 23, '2023-12-06', '500.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

DROP TABLE IF EXISTS `perfil`;
CREATE TABLE IF NOT EXISTS `perfil` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `nombre` tinytext COLLATE utf8mb4_general_ci,
  `apellido` tinytext COLLATE utf8mb4_general_ci,
  `fecha_nacimiento` datetime DEFAULT NULL,
  `genero_id` smallint UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `genero_id_2` (`genero_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id`, `user_id`, `nombre`, `apellido`, `fecha_nacimiento`, `genero_id`, `created_at`, `updated_at`) VALUES
(1, 6, 'Daniel', 'Cahum', '1999-12-24 15:01:44', 1, '2023-11-19 15:01:44', '2023-11-19 15:01:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `UM` int NOT NULL,
  `id_categoria` int NOT NULL,
  `stock` int NOT NULL,
  `precio_costo` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`),
  KEY `UM` (`UM`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `UM`, `id_categoria`, `stock`, `precio_costo`, `precio_venta`) VALUES
(6, 'Tomate', 'Tomate Rojo', 2, 6, 0, '25.00', '30.00'),
(7, 'Cebolla', 'Cebolla morada', 2, 6, 1, '25.00', '30.00'),
(8, 'Pepsi', 'Pepsi 400ml', 1, 3, 29, '8.00', '13.00'),
(9, 'Coca', 'Coca cola 2.5ml Retornable', 1, 3, 197, '25.00', '28.00'),
(10, 'Doritos', 'Doritos 100gr', 1, 7, 146, '15.00', '17.00'),
(11, 'Emperador', 'Galleta Emperador ', 1, 8, 100, '16.00', '18.00'),
(12, 'Yoghurt ', 'Yoghurt lala bebible 500ml', 1, 4, 130, '18.50', '20.00'),
(13, 'Papas', 'Papas', 2, 6, 8, '28.00', '35.00'),
(14, 'Zanahoria', 'Zanahoria', 2, 6, 10, '25.00', '30.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE IF NOT EXISTS `proveedores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `apellido` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `empresa` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `apellido`, `empresa`, `telefono`) VALUES
(1, 'Jose', 'Gomez', 'Sabritas', 2147483647),
(2, 'santoss', 'dzib', 'Coca cola', 2147483647);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `rol_nombre` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `rol_valor` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `rol_nombre`, `rol_valor`) VALUES
(1, 'Usuario', 10),
(2, 'Admin', 20),
(3, 'SuperUsuario', 30),
(4, 'Vendedor', 11),
(5, 'Inventarista', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_movimiento`
--

DROP TABLE IF EXISTS `tipo_movimiento`;
CREATE TABLE IF NOT EXISTS `tipo_movimiento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_movimiento`
--

INSERT INTO `tipo_movimiento` (`id`, `nombre`) VALUES
(1, 'Ingreso'),
(2, 'Retiro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `tipo_usuario_nombre` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_usuario_valor` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `tipo_usuario_nombre`, `tipo_usuario_valor`) VALUES
(1, 'Gratuito', 10),
(2, 'Pago', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trdelete`
--

DROP TABLE IF EXISTS `trdelete`;
CREATE TABLE IF NOT EXISTS `trdelete` (
  `codigo` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `motivo` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `monto` decimal(10,0) DEFAULT NULL,
  `userprograma` int DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trdelete`
--

INSERT INTO `trdelete` (`codigo`, `usuario`, `fecha`, `motivo`, `monto`, `userprograma`) VALUES
(1, 'root@localhost', '2023-11-30 00:05:47', 'Prestamo', '31', 7),
(2, 'root@localhost', '2023-12-04 21:49:22', 'prestamo bimbo', '51', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `um`
--

DROP TABLE IF EXISTS `um`;
CREATE TABLE IF NOT EXISTS `um` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Unidad` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `um`
--

INSERT INTO `um` (`id`, `Unidad`) VALUES
(1, 'PZA'),
(2, 'KG');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `estado_id` smallint NOT NULL DEFAULT '1',
  `rol_id` smallint NOT NULL DEFAULT '1',
  `tipo_usuario_id` smallint NOT NULL DEFAULT '1',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `verification_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  KEY `tipo_usuario_id` (`tipo_usuario_id`),
  KEY `estado_id` (`estado_id`),
  KEY `rol_id` (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `estado_id`, `rol_id`, `tipo_usuario_id`, `created_at`, `updated_at`, `verification_token`) VALUES
(6, 'Cahum24', '1fIdu6ZLEtzL2sjjTNgsiwiz2hakYDuv', '$2y$13$W/aoKIsAq2fdw5b7IE8hqucnDH/kSpVXDWyibleFrA3KrZ/4gHSXa', NULL, 'l20070006@valladolid.tecnm.mx', 1, 4, 1, 2147483647, 2147483647, 'QLzAFKesnMmgEhnPvSM9OMvtc8S3OO2V_1699416019'),
(7, 'Daniel Cahum', '89evQ0sLMokVZpjhkcDQZDor5OcvlBzX', '$2y$13$FZsyctFhLfJRiUtvplT/c.RBrrE/JZix0W9mSkdc3MeU97d5oDcyW', NULL, 'jcahum9@gmail.com', 1, 2, 2, 2147483647, 2147483647, 'vx1roE73rPJ5qooaq3-ZsrgKAJQZaL8-_1700533864'),
(8, 'cahumchay', '2rBuUjQ53QrKSf4uWLYAVW_lnRYGCYZm', '$2y$13$tbksHaeoA/vhVQsjmSpLYO9WoJTse/TGVjeJrh7EFM3mNDydHANpW', NULL, 'jesusckahum@gmail.com', 1, 5, 1, 2147483647, 2147483647, 'pr6VOt128GOBi3QIyahM_cGXL7azpwJj_1701110154'),
(11, 'Santos', 'mHuZ-pu8kpXhO6U6opljKgtKRgXy-Zxb', '$2y$13$Smboc2v.yxZqsMkBfzY4Ge36XOICgmPmIBIXXGcATU4A9LNRYvjJy', NULL, 'danieldzib@gmail.com', 1, 1, 1, 2147483647, 2147483647, 'Uzkq_rBiwaoKy-Xet6tpEb69Jv_LjLiB_1701754046');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `user_id` int NOT NULL,
  `id_cliente` int NOT NULL,
  `id_estado` int NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_estado` (`id_estado`),
  KEY `id_user` (`user_id`,`id_cliente`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=228 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `fecha`, `user_id`, `id_cliente`, `id_estado`, `Total`) VALUES
(221, '2023-12-04', 7, 2, 1, '60.50'),
(222, '2023-12-04', 7, 2, 1, '70.00'),
(223, '2023-12-04', 7, 2, 1, '15.00'),
(224, '2023-12-04', 7, 2, 1, '15.00'),
(225, '2023-12-04', 7, 2, 1, '135.00'),
(226, '2023-12-06', 7, 2, 1, '17.50'),
(227, '2023-12-06', 7, 2, 2, '520.00');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`),
  ADD CONSTRAINT `compras_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estadoventa` (`id`);

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `detalle_compras_ibfk_1` FOREIGN KEY (`id_compras`) REFERENCES `compras` (`id`),
  ADD CONSTRAINT `detalle_compras_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `detalle_compras_ibfk_3` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `detalle_ventas_ibfk_2` FOREIGN KEY (`id_ventas`) REFERENCES `ventas` (`id`),
  ADD CONSTRAINT `detalle_ventas_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `deuda`
--
ALTER TABLE `deuda`
  ADD CONSTRAINT `deuda_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`);

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_movimiento` (`id`),
  ADD CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`),
  ADD CONSTRAINT `pago_ibfk_2` FOREIGN KEY (`id_deuda`) REFERENCES `deuda` (`id`);

--
-- Filtros para la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD CONSTRAINT `fk_perfil_genero` FOREIGN KEY (`genero_id`) REFERENCES `genero` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `perfil_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`UM`) REFERENCES `um` (`id`);

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`tipo_usuario_id`) REFERENCES `tipo_usuario` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `estadoventa` (`id`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `ventas_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
