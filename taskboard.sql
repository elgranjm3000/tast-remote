-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 03-05-2018 a las 13:23:47
-- Versión del servidor: 5.7.22-0ubuntu0.16.04.1
-- Versión de PHP: 7.1.15-1+ubuntu16.04.1+deb.sury.org+2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `taskboard`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `files` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ext` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idtask` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20180425033601'),
('20180430234206'),
('20180430235154'),
('20180503082652');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `titulo` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechacreacion` datetime NOT NULL,
  `fechacomienzo` datetime DEFAULT NULL,
  `fechafin` datetime DEFAULT NULL,
  `tiempo` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iduser` int(11) NOT NULL,
  `idtaskboad` int(11) NOT NULL,
  `status` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `task`
--

INSERT INTO `task` (`id`, `titulo`, `descripcion`, `estado`, `fechacreacion`, `fechacomienzo`, `fechafin`, `tiempo`, `iduser`, `idtaskboad`, `status`) VALUES
(1, 'Tarea Nueva', 'nueva', 'P', '2018-04-07 09:10:00', '2018-04-18 10:00:00', '2018-04-21 01:00:00', '0', 1, 1, NULL),
(2, 'Tarea Nueva', 'nueva', 'A', '2018-04-07 09:10:00', '2018-04-18 10:00:00', '2018-04-21 01:00:00', '0', 1, 1, NULL),
(3, 'TITULO TASK', 'DESCRIPCION DE TASK', 'A', '2018-04-04 10:00:00', '2018-04-11 11:00:00', '2018-04-28 11:00:00', '0', 1, 1, NULL),
(4, 'TITULO TASK', 'DESCRIPCION DE TASK', 'F', '2008-02-01 11:00:00', '2008-02-01 01:20:00', '2004-04-01 01:00:00', '104446', 1, 2, NULL),
(5, 'TITULO TASK', 'DESCRIPCION DE TASK', 'P', '2008-02-01 11:00:00', '2008-02-01 01:20:00', '2004-04-01 01:00:00', '1648', 1, 2, 'P'),
(6, 'TITULO TASK', 'DESCRIPCION DE TASK', 'F', '2008-02-01 11:00:00', '2008-02-01 01:20:00', '2004-04-01 01:00:00', '2018-05-03 05:22:35', 1, 2, NULL),
(7, 'TITULO TASK', 'DESCRIPCION DE TASK', 'A', '2008-02-01 11:00:00', '2008-02-01 01:20:00', '2004-04-01 01:00:00', '15296', 1, 2, 'P'),
(8, 'asdad', 'asdasd', 'F', '2008-04-04 01:04:00', '2008-04-01 01:00:00', '2008-04-04 01:01:00', '0', 1, 1, NULL),
(9, 'asdad', 'asdasd', 'P', '2008-04-04 01:04:00', '2008-04-01 01:00:00', '2008-04-04 01:01:00', '0', 1, 1, NULL),
(10, 'asdad', 'asdasd', 'P', '2008-04-04 01:04:00', '2008-04-01 01:00:00', '2008-04-04 01:01:00', '0', 1, 1, NULL),
(11, 'fsdfsf', 'gfdg', 'F', '2008-02-01 11:01:00', '2004-02-01 11:00:00', '2004-04-04 11:00:00', '60536785502', 1, 2, 'P');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taskboard`
--

CREATE TABLE `taskboard` (
  `id` int(11) NOT NULL,
  `titulo` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechacreacion` datetime NOT NULL,
  `fechacomienzo` datetime NOT NULL,
  `fechafin` datetime DEFAULT NULL,
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `taskboard`
--

INSERT INTO `taskboard` (`id`, `titulo`, `descripcion`, `fechacreacion`, `fechacomienzo`, `fechafin`, `userid`) VALUES
(1, 'TITULO', 'DESCRIPCION', '2000-02-01 11:00:00', '2008-02-01 01:00:00', '2002-02-01 01:00:00', 1),
(2, 'Tarea NUeva', 'Descripcion Tarea Nuva', '2008-02-01 11:00:00', '2008-01-01 11:00:00', '2004-04-01 01:00:00', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_527EDB254DE53A5E` (`idtaskboad`);

--
-- Indices de la tabla `taskboard`
--
ALTER TABLE `taskboard`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `taskboard`
--
ALTER TABLE `taskboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `FK_527EDB254DE53A5E` FOREIGN KEY (`idtaskboad`) REFERENCES `taskboard` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
