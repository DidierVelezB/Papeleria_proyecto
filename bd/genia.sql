-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2025 a las 00:20:10
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `genia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL,
  `correoElectronico` varchar(320) NOT NULL,
  `contraseña` varchar(300) DEFAULT NULL,
  `tipo_documento` varchar(10) DEFAULT NULL,
  `cedula` varchar(20) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idCliente`, `correoElectronico`, `contraseña`, `tipo_documento`, `cedula`, `nombre`, `apellidos`) VALUES
(1, 'otalvarodidier@gmail.com', '1234', NULL, NULL, 'didier', NULL),
(2, 'carolcarol@gmail.com', '4321', NULL, NULL, 'carol', NULL),
(3, 'carmen@gmail.com', '$2y$10$AijvmdGljl/KxsMNmgtaG.fWrcSRXhSdL7YSF6', NULL, NULL, 'carmen', NULL),
(4, 'carlosdavir@gmail.com', '$2y$10$t/.ployossPN8z7KJEa9Yuys.OQ15sDt1ds1.x', NULL, NULL, NULL, NULL),
(5, 'deivyd@gmail.com', '$2y$10$FTxO/.LAoqVRjjwzpFShZev4ydofDJ5HjuHXYN', NULL, NULL, NULL, NULL),
(6, 'stiven@gmail.com', '$2y$10$4hfLcmCB9Qq.qH0RUod8eONqk7AclIcDhwROgU', NULL, NULL, 'stiven', NULL),
(7, 'tana@gmail.com', '$2y$10$BHHZTO31tXcwm/81B4b10e3aKza0eruq5y0b/4', NULL, NULL, 'tana', NULL),
(8, 'hola@gmail.com', '$2y$10$d61IK0GJrRMhv8nlm6QPeO3cBFaibBHWi6eyCx', NULL, NULL, 'hola', NULL),
(9, 'pascal@gmail.com', '$2y$10$3JpOS1iQq5Q/nDpDzZpi7OWTiUe6VjH6mlVMv6OtRKpCUI6WqgFLi', NULL, NULL, 'pascal', NULL),
(10, 'romina@gmail.com', '$2y$10$R5t9Disn2Zj9uEYJm6T9Be1TSmyGOGygd5dKBS/Zphms8H3rEejmW', NULL, NULL, 'romina', NULL),
(11, 'patricio@gmail.com', '$2y$10$rrEMXikgMT1OLrCkOMTbyO3Aa32R0vLob4IL5Xqgf56S9ExX9kWdK', NULL, NULL, 'patricio', NULL),
(12, 'claudia@gmail.com', '$2y$10$ChubiP9qLg.JbL8SBqhE/.j4i40sstlEi2pkJXQ7BK7Szz5g92Guu', NULL, NULL, 'claudia', NULL),
(13, 'dani@gmail.com', '$2y$10$AUR4y1.X9p.SEif.qae40ONS4tmrJ/U0Bw342AGFlLfnrp4JFfQHK', '1111111', NULL, 'Dani', 'Caprapasd1'),
(14, 'maria@gmail.com', '$2y$10$u0j8/DQU59wrhqX5KSTSR.LDUAzz48O3PbyjT27oRTcP7lMeFOxE6', NULL, NULL, 'Maria', 'patricio'),
(15, 'prueba2@gmail.com', '$2y$10$XkTqyeBZ0ZrVr7XWj3SBGOv8.N60u3QlspGCnvYSrXWCdc9hRWiTm', 'cedula', '1111111', 'prueba', 'prueba'),
(16, 'prueba3@gmail.com', '$2y$10$MriwVhwD7IKzYoNLEHPR0Oo.bkAYI3GmYwuFYBlzpsSkrLUEx8VEa', NULL, NULL, 'prueba3', NULL),
(17, 'parroco@gmail.com', '$2y$10$R4aqRs7nHqTH5gtQacsCSOV0DzcueQ1ByycKgjaPByioEW/OuarEO', NULL, NULL, 'parroco', NULL),
(18, 'profesora@gmail.com', '$2y$10$vuvcd4FWXDbHcPPqTEWv5ujCECEY6ST9a1l//PYlOgjsYye3mzbte', NULL, NULL, 'profesora', NULL),
(19, 'guillermo@gmail.com', '$2y$10$H5WOCcj.z3PIwT8lKKdkOe4yryXD1TwcC9T3pZCXdMME/yUWnM6zi', NULL, NULL, 'guillermo', NULL),
(20, 'prueba5@gmail.com', '$2y$10$D.u48lLc9k1Byek0lRKcqu5pH.gF0WXcPpJJVTFSDN.9vk4wxJIvy', NULL, NULL, 'prueba5', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos_descuento`
--

CREATE TABLE `codigos_descuento` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `porcentaje` decimal(5,2) NOT NULL,
  `valido_hasta` date DEFAULT NULL,
  `usos_maximos` int(11) DEFAULT NULL,
  `usos_actuales` int(11) DEFAULT 0,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `codigos_descuento`
--

INSERT INTO `codigos_descuento` (`id`, `codigo`, `porcentaje`, `valido_hasta`, `usos_maximos`, `usos_actuales`, `activo`) VALUES
(2, 'hola', 10.00, '2025-05-21', 4, 4, 1),
(3, 'valo', 100.00, '2025-05-21', 20, 7, 1),
(11, '1111', 1.00, '2025-05-29', 1, 0, 1),
(16, 'salario', 12.00, '2025-05-28', 1, 0, 1),
(17, 'romina', 99.00, '2025-05-27', 4, 0, 1),
(18, 'castr', 99.00, '2025-05-30', 1, 0, 1),
(19, 'oar', 1.00, '2025-05-28', 1, 0, 1),
(20, '99999', 1.00, '2025-05-28', 4, 0, 1),
(21, 'garda', 1.00, '2025-05-25', 1, 0, 1),
(25, 'rocky', 100.00, '2025-05-29', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generadordemensajes`
--

CREATE TABLE `generadordemensajes` (
  `idGeneradorDeMensajes` int(11) NOT NULL,
  `plantillaMensaje` varchar(150) DEFAULT NULL,
  `Cliente_idCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `producto` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `talla` varchar(20) NOT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id`, `id_cliente`, `producto`, `fecha`, `precio`, `talla`, `imagen`) VALUES
(1, 16, 'Camiseta Básica', '2025-05-29 01:59:05', 35000.00, 'S, M, L', ''),
(2, 16, 'Camiseta Deportiva', '2025-05-29 01:59:05', 55000.00, 'S, M, L', ''),
(3, 16, 'Chaqueta Modelo 2', '2025-05-29 01:59:05', 81000.00, 'S, M, L', ''),
(4, 10, 'Camiseta Básica', '2025-05-29 02:07:11', 35000.00, 'S, M, L', '/img/Camisas/hombre/Camisa1.jpg'),
(5, 10, 'Camiseta Modelo 5', '2025-05-29 02:07:11', 40000.00, 'S, M, L', '/img/Camisas/hombre/Camisa5.jpg'),
(6, 10, 'Chaqueta Modelo 5', '2025-05-29 02:07:11', 84000.00, 'S, M, L', '/img/Chaquetas/hombre/chaqueta5.jpg'),
(7, 10, 'Chaqueta Modelo 1', '2025-05-29 02:07:11', 80000.00, 'S, M, L', '/img/Chaquetas/hombre/chaqueta1.jpg'),
(8, 10, 'Chaqueta Modelo 4', '2025-05-29 02:07:11', 83000.00, 'S, M, L', '/img/Chaquetas/hombre/chaqueta4.jpg'),
(9, 10, 'Camiseta Deportiva', '2025-05-29 02:07:48', 55000.00, 'S, M, L', '/img/Camisas/hombre/Camisa3.jpg'),
(10, 10, 'Camiseta Básica', '2025-05-29 02:07:48', 35000.00, 'S, M, L', '/img/Camisas/hombre/Camisa1.jpg'),
(11, 10, 'Camiseta Premium', '2025-05-29 02:07:48', 45000.00, 'S, M, L', '/img/Camisas/hombre/Camisa2.jpg'),
(12, 10, 'Camiseta Modelo 5', '2025-05-29 02:07:48', 40000.00, 'S, M, L', '/img/Camisas/hombre/Camisa5.jpg'),
(13, 10, 'Camiseta Modelo 4', '2025-05-29 02:07:48', 39000.00, 'S, M, L', '/img/Camisas/hombre/Camisa4.jpg'),
(14, 10, 'Camiseta Modelo 7', '2025-05-29 02:07:48', 42000.00, 'S, M, L', '/img/Camisas/mujer/Camisa2.jpg'),
(15, 10, 'Camiseta Modelo 9', '2025-05-29 02:07:48', 44000.00, 'S, M, L', '/img/Camisas/mujer/Camisa4.jpg'),
(16, 10, 'Camiseta Modelo 6', '2025-05-29 02:07:48', 41000.00, 'S, M, L', '/img/Camisas/mujer/Camisa1.jpg'),
(17, 10, 'Camiseta Modelo 8', '2025-05-29 02:07:48', 43000.00, 'S, M, L', '/img/Camisas/mujer/Camisa3.jpg'),
(18, 10, 'Falda Modelo 10', '2025-05-29 02:07:48', 54000.00, 'S, M, L', '/img/faldas/falda10.jpg'),
(19, 10, 'Falda Modelo 8', '2025-05-29 02:07:48', 52000.00, 'S, M, L', '/img/faldas/falda8.jpg'),
(20, 10, 'Blusa de Algodón', '2025-05-29 02:09:58', 42000.00, 'S, M, L', '/img/Blusas/blusa8.jpg'),
(21, 16, 'Falda Modelo 10', '2025-05-29 03:40:35', 54000.00, 'S, M, L', '/img/faldas/falda10.jpg'),
(22, 16, 'Falda Modelo 4', '2025-05-29 03:40:35', 48000.00, 'S, M, L', '/img/faldas/falda4.jpg'),
(23, 16, 'Falda Modelo 2', '2025-05-29 03:40:35', 46000.00, 'S, M, L', '/img/faldas/falda2.jpg'),
(24, 18, 'Camiseta Modelo 10', '2025-05-29 03:42:53', 45000.00, 'S, M, L', '/img/Camisas/mujer/Camisa5.jpg'),
(25, 18, 'Camiseta Modelo 6', '2025-05-29 03:42:53', 41000.00, 'S, M, L', '/img/Camisas/mujer/Camisa1.jpg'),
(26, 18, 'Camiseta Modelo 5', '2025-05-29 03:43:19', 40000.00, 'S, M, L', '/img/Camisas/hombre/Camisa5.jpg'),
(27, 18, 'Camiseta Deportiva', '2025-05-29 03:43:19', 55000.00, 'S, M, L', '/img/Camisas/hombre/Camisa3.jpg'),
(28, 19, 'Chaqueta Modelo 4', '2025-05-29 03:47:20', 83000.00, 'S, M, L', '/img/Chaquetas/hombre/chaqueta4.jpg'),
(29, 19, 'Chaqueta Modelo 5', '2025-05-29 03:47:20', 84000.00, 'S, M, L', '/img/Chaquetas/hombre/chaqueta5.jpg'),
(30, 19, 'Camiseta Modelo 4', '2025-05-29 03:50:31', 39000.00, 'S, M, L', '/img/Camisas/hombre/Camisa4.jpg'),
(31, 20, 'Camiseta Clasic', '2025-05-29 23:38:58', 40000.00, 'S, M, L', '/img/Camisas/hombre/Camisa5.jpg'),
(32, 20, 'Camiseta Básica', '2025-05-29 23:38:58', 35000.00, 'S, M, L', '/img/Camisas/hombre/Camisa1.jpg'),
(33, 20, 'Camiseta Gato', '2025-05-29 23:38:58', 39000.00, 'S, M, L', '/img/Camisas/hombre/Camisa4.jpg'),
(34, 20, 'Camiseta Roja', '2025-05-29 23:38:58', 42000.00, 'S, M, L', '/img/Camisas/mujer/Camisa2.jpg'),
(35, 20, 'Camiseta Happy', '2025-05-29 23:38:58', 41000.00, 'S, M, L', '/img/Camisas/mujer/Camisa1.jpg'),
(36, 20, 'Camiseta Vogue', '2025-05-29 23:38:58', 44000.00, 'S, M, L', '/img/Camisas/mujer/Camisa4.jpg'),
(37, 20, 'Jean', '2025-05-29 23:38:58', 62000.00, 'S, M, L', '/img/Pantalones/hombre/pantalon3.jpg'),
(38, 20, 'Pantalon Jogger', '2025-05-29 23:38:58', 63000.00, 'S, M, L', '/img/Pantalones/hombre/pantalon4.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialdemensaje`
--

CREATE TABLE `historialdemensaje` (
  `idHistorialDeMensaje` int(11) NOT NULL,
  `mensajeEnviado` varchar(750) NOT NULL,
  `Cliente_idCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intereses`
--

CREATE TABLE `intereses` (
  `idIntereses` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `intereses`
--

INSERT INTO `intereses` (`idIntereses`, `nombre`) VALUES
(1, 'Ropa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intereses_has_cliente`
--

CREATE TABLE `intereses_has_cliente` (
  `Intereses_idIntereses` int(11) NOT NULL,
  `Cliente_idCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificador`
--

CREATE TABLE `notificador` (
  `idNotificador` int(11) NOT NULL,
  `Cliente_idCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProductos` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(320) NOT NULL,
  `categoria` varchar(200) NOT NULL,
  `Intereses_idIntereses` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `idReporte` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `documento` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `reporte` text NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `reportes`
--

INSERT INTO `reportes` (`idReporte`, `nombres`, `apellidos`, `documento`, `fecha`, `reporte`, `usuario_id`) VALUES
(1, 'Didier', 'Otalvaro', '1000859255', '2025-05-29', 'Funciona excelente', 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repositoriocliente`
--

CREATE TABLE `repositoriocliente` (
  `idRepositorioCliente` int(11) NOT NULL,
  `Cliente_idCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `codigos_descuento`
--
ALTER TABLE `codigos_descuento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `generadordemensajes`
--
ALTER TABLE `generadordemensajes`
  ADD PRIMARY KEY (`idGeneradorDeMensajes`),
  ADD KEY `fk_GeneradorDeMensajes_Cliente_idx` (`Cliente_idCliente`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `historialdemensaje`
--
ALTER TABLE `historialdemensaje`
  ADD PRIMARY KEY (`idHistorialDeMensaje`),
  ADD KEY `fk_HistorialDeMensaje_Cliente1_idx` (`Cliente_idCliente`);

--
-- Indices de la tabla `intereses`
--
ALTER TABLE `intereses`
  ADD PRIMARY KEY (`idIntereses`);

--
-- Indices de la tabla `intereses_has_cliente`
--
ALTER TABLE `intereses_has_cliente`
  ADD PRIMARY KEY (`Intereses_idIntereses`,`Cliente_idCliente`),
  ADD KEY `fk_Intereses_has_Cliente_Cliente1_idx` (`Cliente_idCliente`),
  ADD KEY `fk_Intereses_has_Cliente_Intereses1_idx` (`Intereses_idIntereses`);

--
-- Indices de la tabla `notificador`
--
ALTER TABLE `notificador`
  ADD PRIMARY KEY (`idNotificador`,`Cliente_idCliente`),
  ADD KEY `fk_Notificador_Cliente1_idx` (`Cliente_idCliente`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProductos`),
  ADD KEY `fk_Productos_Intereses1_idx` (`Intereses_idIntereses`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`idReporte`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `repositoriocliente`
--
ALTER TABLE `repositoriocliente`
  ADD PRIMARY KEY (`idRepositorioCliente`,`Cliente_idCliente`),
  ADD KEY `fk_RepositorioCliente_Cliente1_idx` (`Cliente_idCliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `codigos_descuento`
--
ALTER TABLE `codigos_descuento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `generadordemensajes`
--
ALTER TABLE `generadordemensajes`
  MODIFY `idGeneradorDeMensajes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `historialdemensaje`
--
ALTER TABLE `historialdemensaje`
  MODIFY `idHistorialDeMensaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `intereses`
--
ALTER TABLE `intereses`
  MODIFY `idIntereses` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `notificador`
--
ALTER TABLE `notificador`
  MODIFY `idNotificador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProductos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `idReporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `repositoriocliente`
--
ALTER TABLE `repositoriocliente`
  MODIFY `idRepositorioCliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `generadordemensajes`
--
ALTER TABLE `generadordemensajes`
  ADD CONSTRAINT `fk_GeneradorDeMensajes_Cliente` FOREIGN KEY (`Cliente_idCliente`) REFERENCES `cliente` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`idCliente`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historialdemensaje`
--
ALTER TABLE `historialdemensaje`
  ADD CONSTRAINT `fk_HistorialDeMensaje_Cliente1` FOREIGN KEY (`Cliente_idCliente`) REFERENCES `cliente` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `intereses_has_cliente`
--
ALTER TABLE `intereses_has_cliente`
  ADD CONSTRAINT `fk_Intereses_has_Cliente_Cliente1` FOREIGN KEY (`Cliente_idCliente`) REFERENCES `cliente` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Intereses_has_Cliente_Intereses1` FOREIGN KEY (`Intereses_idIntereses`) REFERENCES `intereses` (`idIntereses`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `notificador`
--
ALTER TABLE `notificador`
  ADD CONSTRAINT `fk_Notificador_Cliente1` FOREIGN KEY (`Cliente_idCliente`) REFERENCES `cliente` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_Productos_Intereses1` FOREIGN KEY (`Intereses_idIntereses`) REFERENCES `intereses` (`idIntereses`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `reportes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `cliente` (`idCliente`) ON DELETE CASCADE;

--
-- Filtros para la tabla `repositoriocliente`
--
ALTER TABLE `repositoriocliente`
  ADD CONSTRAINT `fk_RepositorioCliente_Cliente1` FOREIGN KEY (`Cliente_idCliente`) REFERENCES `cliente` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
