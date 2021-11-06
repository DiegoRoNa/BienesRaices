-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2021 a las 11:05:08
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bienes_raices`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedades`
--

CREATE TABLE `propiedades` (
  `id` int(11) NOT NULL,
  `idVendedor` int(11) DEFAULT NULL,
  `titulo` varchar(60) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `descripcion` longtext DEFAULT NULL,
  `habitaciones` int(1) DEFAULT NULL,
  `wc` int(1) DEFAULT NULL,
  `estacionamiento` int(1) DEFAULT NULL,
  `creado` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `propiedades`
--

INSERT INTO `propiedades` (`id`, `idVendedor`, `titulo`, `precio`, `imagen`, `descripcion`, `habitaciones`, `wc`, `estacionamiento`, `creado`) VALUES
(3, 1, 'Casa con tres pisos', '156.00', '8f0bdc884a338ab81316646ec55cf9d2.jpg', 'ACTUALIZADO ACTUALIZADO ACTUALIZADO ACTUALIZADO ACTUALIZADO ACTUALIZADO ACTUALIZADO ACTUALIZADO ACTUALIZADO', 9, 9, 9, '2021-11-02'),
(8, 1, 'Casa con tres pisos', '3245656.00', '058edc3a2df683f47db9b2602adfc7af.jpg', 'Casa con tres pisosCasa con tres pisosCasa con tres pisosCasa con tres pisosCasa con tres pisosCasa con tres pisosCasa con tres pisosCasa con tres pisosCasa con tres pisosCasa con tres pisosCasa con tres pisosCasa con tres', 2, 4, 2, '2021-11-03'),
(9, 2, 'Casa en el bosque', '578562.00', 'a94596933ad1f3df301189e36694022f.jpg', 'Casa en el bosqueCasa en el bosqueCasa en el bosqueCasa en el bosqueCasa en el bosqueCasa en el bosqueCasa en el bosqueCasa en el bosqueCasa en el', 3, 4, 2, '2021-11-03'),
(10, 2, 'Casa con alberca', '454231.00', 'e7f2c6a3c91a685e6d06230deede2884.jpg', 'Casa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con albercaCasa con alberca', 3, 3, 1, '2021-11-03'),
(11, 1, 'Casa de super lujo', '3145906.00', '087f8aaa7ace6c67076e7c47183a963d.jpg', 'Casa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujoCasa de super lujo', 2, 3, 3, '2021-11-03'),
(12, 1, 'Propiedad más cara', '9948599.00', '8fda573203fa08a1d69a9bac80dbcca1.jpg', 'Propiedad más caraPropiedad más caraPropiedad más caraPropiedad más caraPropiedad más caraPropiedad más caraPropiedad más caraPropiedad más caraPropiedad más caraPropiedad más caraPropiedad más caraPropiedad más caraPropiedad más caraPropiedad más caraPropiedad más caraPropiedad más caraPropiedad más caraPropiedad más cara', 4, 4, 2, '2021-11-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(1) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` char(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`) VALUES
(2, 'correo@correo.com', '$2y$10$afhyrRN8mMAU/JZ1hZGk.Os8TThwLcOf47j8dqpolVg/6cNbPTKGi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedores`
--

CREATE TABLE `vendedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellidos` varchar(45) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `vendedores`
--

INSERT INTO `vendedores` (`id`, `nombre`, `apellidos`, `telefono`) VALUES
(1, 'Diego', 'Rojas Nava', '2358760030'),
(2, 'Karen', 'Perez', '4892759023');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `propiedades`
--
ALTER TABLE `propiedades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idVendedor` (`idVendedor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `propiedades`
--
ALTER TABLE `propiedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `propiedades`
--
ALTER TABLE `propiedades`
  ADD CONSTRAINT `propiedades_ibfk_1` FOREIGN KEY (`idVendedor`) REFERENCES `vendedores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
