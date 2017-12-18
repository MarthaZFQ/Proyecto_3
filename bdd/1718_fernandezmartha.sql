-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-12-2017 a las 21:47:37
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `1718_fernandezmartha`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia`
--

CREATE TABLE `incidencia` (
  `inci_id` int(4) NOT NULL,
  `inci_descripcion` text COLLATE utf8_spanish_ci,
  `inci_fecha_inci` timestamp NULL DEFAULT NULL,
  `res_id` int(4) NOT NULL,
  `inci_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `incidencia`
--

INSERT INTO `incidencia` (`inci_id`, `inci_descripcion`, `inci_fecha_inci`, `res_id`, `inci_estado`) VALUES
(1, 'No funciona el proyector', '2017-12-14 12:37:33', 4, 0),
(3, 'El proyector no funciona\r\n', '2017-12-15 15:59:09', 7, 0),
(10, 'No hay luz\r\n', '2017-12-15 16:08:59', 9, 0),
(11, 'No funciona.', '2017-12-15 18:40:47', 11, 0),
(12, 'El proyector se ha estropeado.', '2017-12-15 18:48:47', 13, 0),
(13, 'El proyector no funciona en esta aula.', '2017-12-18 02:04:03', 28, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE `recurso` (
  `rec_id` int(4) NOT NULL,
  `rec_tipo` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `rec_nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `rec_descripcion` text COLLATE utf8_spanish_ci,
  `rec_img` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rec_usado` int(3) NOT NULL,
  `rec_habilitado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `recurso`
--

INSERT INTO `recurso` (`rec_id`, `rec_tipo`, `rec_nombre`, `rec_descripcion`, `rec_img`, `rec_usado`, `rec_habilitado`) VALUES
(1, 'Aula de teoría', 'Aula de teoría con proyector 01', 'Aula de teoría con proyector en el piso 3 puerta 304', 'teoria_pry.png', 100, 0),
(2, 'Aula de teoría', 'Aula de teoría con proyector 02', 'Aula de teoría con proyector en el piso 3 puerta 305', 'teoria_pry.png', 43, 0),
(3, 'Aula de teoría', 'Aula de teoría sin proyector', 'Aula de teoría sin proyector en el piso 3 puerta 306', 'teoria.png', 40, 0),
(4, 'Aula de informática', 'Aula de informática 01', 'Aula de informática situada en el piso 4 puerta 414', 'informatica.png', 21, 0),
(5, 'Aula de informática', 'Aula de informática 02', 'Aula de informática situada en el piso 4 puerta 415', 'informatica.png', 43, 0),
(6, 'Sala', 'Despacho para entrevistas 01', 'Despacho para entrevistas situado en el primer piso, en la puerta número 100', 'despacho.png', 45, 0),
(7, 'Sala', 'Despacho para entrevistas 02', 'Despacho para entrevistas situado en el primer piso, en la puerta número 101', 'despacho.png', 43, 0),
(8, 'Sala', 'Sala de reuniones', 'Sala para reuniones situado en el primer piso, en la puerta número 105', 'reuniones.png', 39, 0),
(9, 'Proyector', 'Proyector', 'Proyector en el almacén del piso 3, en la puerta 307', 'proyector.jpg', 29, 0),
(10, 'Carro de portátiles', 'Carro de portatiles', 'Carro de portátiles en el almacén del piso 3, en la puerta 307', 'carro.jpg', 47, 0),
(11, 'Portátil', 'Portátil 01', 'Portátil Lenovo en el almacén del piso 3, en la puerta 307', 'portatil.jpg', 25, 0),
(12, 'Portátil', 'Portátil 02', 'Portátil ASUS en el almacén del piso 3, en la puerta 307', 'portatil2.jpg', 55, 0),
(13, 'Portátil', 'Portátil 03', 'Portátil Toshiba en el almacén del piso 3, en la puerta 307', 'portatil3.jpg', 49, 0),
(14, 'Móvil', 'Móvil 01', 'Móvil iPhone situado en el almacén del piso 3, en la puerta 307', 'movil1.jpg', 34, 0),
(15, 'Móvil', 'Móvil 02', 'Samsung S8 situado en el almacén del piso 3, en la puerta 307', 'movil2.jpg', 22, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `res_id` int(4) NOT NULL,
  `res_fechainicio` timestamp NULL DEFAULT NULL,
  `res_fechadevolucion` timestamp NULL DEFAULT NULL,
  `usu_id` int(4) NOT NULL,
  `rec_id` int(4) NOT NULL,
  `res_habilitado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`res_id`, `res_fechainicio`, `res_fechadevolucion`, `usu_id`, `rec_id`, `res_habilitado`) VALUES
(4, '2017-12-14 07:00:00', '2017-12-15 08:00:00', 1, 1, 0),
(6, '2017-12-15 08:00:00', '2017-12-15 09:00:00', 2, 8, 0),
(7, '2017-12-15 08:00:00', '2017-12-15 10:00:00', 2, 3, 0),
(9, '2017-12-15 16:04:52', '2017-12-15 17:28:24', 2, 5, 1),
(11, '2017-12-15 18:16:00', '2017-12-15 18:40:47', 2, 9, 0),
(12, '2017-12-15 18:40:30', '2017-12-15 19:00:00', 2, 1, 0),
(13, '2017-12-15 18:48:34', '2017-12-15 18:48:47', 2, 2, 0),
(14, '2017-12-16 15:00:00', '2017-12-16 21:58:30', 3, 1, 0),
(16, '2017-12-22 10:00:00', '2017-12-22 12:00:00', 2, 1, 0),
(20, '2017-12-17 15:00:00', '2017-12-17 16:00:00', 2, 2, 0),
(26, '2017-12-22 07:00:00', '2017-12-22 09:00:00', 2, 1, 0),
(27, '2017-12-18 07:00:00', '2017-12-18 08:00:00', 2, 1, 1),
(28, '2017-12-19 07:00:00', '2017-12-18 02:04:03', 2, 2, 1),
(29, '2017-12-19 07:00:00', '2017-12-19 08:00:00', 2, 1, 0),
(30, '2017-12-19 08:00:00', '2017-12-19 09:00:00', 2, 1, 0),
(31, '2017-12-20 07:00:00', '2017-12-20 08:00:00', 2, 2, 1),
(32, '2017-12-28 07:00:00', '2017-12-28 08:00:00', 2, 3, 1),
(33, '2017-12-27 07:00:00', '2017-12-27 08:00:00', 1, 4, 1),
(34, '2017-12-28 13:00:00', '2017-12-28 14:00:00', 1, 3, 1),
(35, '2017-12-28 07:00:00', '2017-12-28 09:00:00', 1, 3, 1),
(36, '2017-12-26 07:00:00', '2017-12-26 08:00:00', 1, 15, 1),
(37, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 2, 1),
(38, '2017-12-19 07:00:00', '2017-12-19 08:00:00', 1, 2, 1),
(39, '2017-12-28 07:00:00', '2017-12-28 08:00:00', 1, 2, 1),
(40, '2017-12-28 07:00:00', '2017-12-28 08:00:00', 1, 2, 1),
(41, '2017-12-28 07:00:00', '2017-12-28 08:00:00', 1, 2, 1),
(42, '2017-12-28 07:00:00', '2017-12-28 08:00:00', 1, 2, 0),
(43, '2017-12-28 07:00:00', '2017-12-28 09:00:00', 1, 2, 1),
(44, '2017-12-28 07:00:00', '2017-12-28 08:00:00', 1, 2, 1),
(45, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 3, 1),
(46, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 1, 1),
(47, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 1, 1),
(48, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 1, 1),
(49, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 1, 1),
(50, '2017-12-20 07:00:00', '2017-12-20 08:00:00', 9, 1, 1),
(51, '2017-12-20 07:00:00', '2017-12-20 08:00:00', 9, 1, 0),
(52, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 1, 1),
(53, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 1, 1),
(54, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 1, 1),
(55, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 1, 1),
(56, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 1, 1),
(57, '2017-12-19 10:00:00', '2017-12-19 11:00:00', 9, 1, 0),
(58, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 1, 1),
(59, '1970-01-01 07:00:00', '1970-01-01 08:00:00', 9, 1, 1),
(60, '1970-01-01 07:00:00', '1970-01-01 08:00:00', 9, 1, 1),
(61, '1970-01-01 07:00:00', '1970-01-01 08:00:00', 9, 1, 1),
(62, '1970-01-01 07:00:00', '1970-01-01 08:00:00', 9, 1, 1),
(63, '2017-12-18 09:00:00', '2017-12-18 11:00:00', 9, 1, 1),
(64, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 1, 1),
(65, '2017-12-18 11:00:00', '2017-12-18 15:00:00', 9, 1, 1),
(66, '2017-12-20 11:00:00', '2017-12-20 14:00:00', 9, 1, 0),
(67, '1970-01-01 07:00:00', '1970-01-01 08:00:00', 9, 2, 1),
(68, '1970-01-01 07:00:00', '1970-01-01 08:00:00', 9, 2, 1),
(69, '2017-12-18 07:00:00', '2017-12-18 08:00:00', 9, 2, 1),
(70, '2017-12-20 08:00:00', '2017-12-20 10:00:00', 9, 2, 0),
(71, '1970-01-01 07:00:00', '1970-01-01 08:00:00', 9, 3, 1),
(72, '2017-12-18 12:00:00', '2017-12-18 14:00:00', 9, 3, 1),
(73, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 2, 1),
(74, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 3, 1),
(75, '2017-12-21 07:00:00', '2017-12-21 08:00:00', 1, 3, 0),
(76, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 2, 1),
(77, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 2, 1),
(78, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 1, 1),
(79, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 1, 1),
(80, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 1, 1),
(81, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 1, 1),
(82, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 1, 1),
(83, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 1, 1),
(84, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 1, 1),
(85, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 1, 1),
(86, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 1, 1),
(87, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 1, 1),
(88, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 1, 1),
(89, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 1, 1),
(90, '1970-01-01 18:00:00', '1970-01-01 19:00:00', 1, 1, 1),
(91, '1970-01-01 19:00:00', '1970-01-01 19:00:00', 1, 1, 1),
(92, '1970-01-01 19:00:00', '1970-01-01 19:00:00', 1, 1, 1),
(93, '1970-01-01 19:00:00', '1970-01-01 19:00:00', 1, 1, 1),
(94, '2017-12-19 14:00:00', '2017-12-19 18:00:00', 1, 2, 0),
(95, '2017-12-21 08:00:00', '2017-12-21 09:00:00', 1, 1, 0),
(96, '2017-12-27 07:00:00', '2017-12-27 08:00:00', 1, 12, 0),
(97, '2017-12-28 08:00:00', '2017-12-28 10:00:00', 1, 12, 0),
(98, '2017-12-28 11:00:00', '2017-12-28 13:00:00', 1, 12, 0),
(99, '2017-12-28 18:00:00', '2017-12-28 19:00:00', 1, 12, 0),
(100, '2017-12-31 07:00:00', '2017-12-31 08:00:00', 1, 6, 0),
(101, '2017-12-31 10:00:00', '2017-12-31 11:00:00', 1, 6, 0),
(102, '2017-12-23 07:00:00', '2017-12-23 08:00:00', 1, 6, 0),
(103, '1970-01-01 07:00:00', '1970-01-01 08:00:00', 1, 6, 1),
(106, '2017-12-28 13:00:00', '2017-12-28 16:00:00', 1, 5, 0),
(107, '2017-12-23 09:00:00', '2017-12-23 10:00:00', 1, 5, 0),
(108, '2017-12-22 13:00:00', '2017-12-22 16:00:00', 1, 5, 0),
(109, '2017-12-29 07:00:00', '2017-12-29 08:00:00', 1, 5, 0),
(110, '2017-12-29 09:00:00', '2017-12-29 10:00:00', 1, 5, 0),
(111, '2017-12-29 11:00:00', '2017-12-29 12:00:00', 1, 5, 0),
(112, '2017-12-31 11:00:00', '2017-12-31 13:00:00', 1, 9, 0),
(113, '2017-12-21 10:00:00', '2017-12-21 14:00:00', 1, 9, 0),
(114, '2017-12-30 07:00:00', '2017-12-30 08:00:00', 1, 9, 1),
(115, '2017-12-30 07:00:00', '2017-12-30 08:00:00', 1, 9, 1),
(116, '2017-12-30 07:00:00', '2017-12-30 08:00:00', 1, 9, 1),
(117, '2017-12-30 07:00:00', '2017-12-30 08:00:00', 1, 9, 1),
(118, '2017-12-30 07:00:00', '2017-12-30 08:00:00', 1, 9, 0),
(119, '2017-12-20 14:00:00', '2017-12-20 15:00:00', 1, 1, 0),
(120, '2017-12-27 07:00:00', '2017-12-27 08:00:00', 1, 5, 0),
(121, '2017-12-29 16:00:00', '2017-12-29 19:00:00', 1, 5, 0),
(122, '2017-12-30 12:00:00', '2017-12-30 16:00:00', 1, 6, 0),
(123, '2017-12-30 11:00:00', '2017-12-30 11:00:00', 1, 6, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usu_id` int(4) NOT NULL,
  `usu_nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `usu_apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `usu_correo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `usu_password` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `usu_seguridad` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `usu_nivel` varchar(35) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usu_habilitado` tinyint(1) NOT NULL,
  `usu_foto` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `usu_direccion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `usu_telf` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usu_id`, `usu_nombre`, `usu_apellido`, `usu_correo`, `usu_password`, `usu_seguridad`, `usu_nivel`, `usu_habilitado`, `usu_foto`, `usu_direccion`, `usu_telf`) VALUES
(1, 'Alex', 'Perez', 'alex@gmail.com', '1fa3356b1eb65f144a367ff8560cb406', 'Milú', 'Administrador', 0, 'defecto.png', 'Avenida Masnou 76 5a 3a ', 612345678),
(2, 'Irene', 'Fernández', 'irene@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Draco', 'Usuario', 0, 'defecto.png', 'C/ Maria Cristina 102 3a 1a', 612345678),
(3, 'David', 'Gomez', 'david@gmail.com', '47496afd0bb349059c000e89235b1d87', 'Pitus', 'Usuario', 0, 'defecto.png', 'Carrer d\'Aragó 80 2a B 1a', 612345678),
(4, 'Maria', 'Gil', 'maria@gmail.com', '8c794bf29f7c86024dbeb4fe4eb368aa', 'Akira', 'Usuario', 0, 'defecto.png', 'Carrer de Casanova 100 2a 2a', 612345678),
(5, 'Javier', 'Ortiz', 'javier@gmail.com', 'ef01f1e49e93e161a7d4115e5d06ea1e', 'Flash', 'Usuario', 0, 'defecto.png', 'Ronda de Sant Pau 49 1a 4a', 612345678),
(6, 'Esther', 'Rivera', 'esther@gmail.com', '480aeb42d7b1e3937fe8db12a1ffe6d8', 'Rocky', 'Usuario', 0, 'defecto.png', 'Carrer de la Riera Alta 13 3a 5a', 612345678),
(7, 'John', 'Smith', 'john@gmail.com', '25f9e794323b453885f5181f1b624d0b', 'Bilbo', 'Usuario', 0, 'defecto.png', 'Carrer de Casanova 43 2a 4a', 612345678),
(8, 'Irene', 'Adler', 'adler@gmail.com', '6ebe76c9fb411be97b3b0d48b791a7c9', 'Isti', 'Usuario', 0, 'defecto.png', 'Travessera de Gràcia 60 1a 4a', 612345678),
(9, 'David', 'Marin', 'dmarin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'No tengo', 'Superadministrador', 0, 'defecto.png', 'Carrer de la indústria 73 2a 2a', 123456789),
(11, 'Martha', 'Fernández', 'martha@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Lumi', 'Usuario', 0, 'defecto.png', '', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD PRIMARY KEY (`inci_id`),
  ADD KEY `fk_reserva_incidencia` (`res_id`);

--
-- Indices de la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`rec_id`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`res_id`),
  ADD KEY `fk_recurso_reserva` (`rec_id`),
  ADD KEY `fk_usuario_reserva` (`usu_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usu_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  MODIFY `inci_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `recurso`
--
ALTER TABLE `recurso`
  MODIFY `rec_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `res_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usu_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD CONSTRAINT `fk_reserva_incidencia` FOREIGN KEY (`res_id`) REFERENCES `reserva` (`res_id`);

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `fk_recurso_reserva` FOREIGN KEY (`rec_id`) REFERENCES `recurso` (`rec_id`),
  ADD CONSTRAINT `fk_usuario_reserva` FOREIGN KEY (`usu_id`) REFERENCES `usuario` (`usu_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
