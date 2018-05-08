-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 08-05-2018 a las 20:03:43
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
('20180503082652'),
('20180507200928'),
('20180508211033');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `usuario`) VALUES
(1, 'Joseph', 'Muentes', 'elgranjm'),
(2, 'Eber', 'Blanco', 'eberj');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_task`
--

CREATE TABLE `usuarios_task` (
  `task_id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_635405981B12A85` (`idtask`);

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
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios_task`
--
ALTER TABLE `usuarios_task`
  ADD PRIMARY KEY (`task_id`,`usuarios_id`),
  ADD KEY `IDX_62EB046D8DB60186` (`task_id`),
  ADD KEY `IDX_62EB046DF01D3B25` (`usuarios_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT de la tabla `taskboard`
--
ALTER TABLE `taskboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `FK_635405981B12A85` FOREIGN KEY (`idtask`) REFERENCES `task` (`id`);

--
-- Filtros para la tabla `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `FK_527EDB254DE53A5E` FOREIGN KEY (`idtaskboad`) REFERENCES `taskboard` (`id`);

--
-- Filtros para la tabla `usuarios_task`
--
ALTER TABLE `usuarios_task`
  ADD CONSTRAINT `FK_62EB046D8DB60186` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_62EB046DF01D3B25` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
