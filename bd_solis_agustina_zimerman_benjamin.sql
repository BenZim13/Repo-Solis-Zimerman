-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2025 a las 00:22:57
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_solis_agustina_zimerman_benjamin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(50) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre`) VALUES
(5, 'Alimentos'),
(7, 'Bebidas'),
(3, 'Carniceria'),
(1, 'Fiambreria'),
(4, 'Frutas y Verduras'),
(6, 'Limpieza'),
(2, 'Panaderia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(50) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(50) NOT NULL DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_alta` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_modifica` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_elimina` datetime DEFAULT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `descripcion`, `precio`, `stock`, `image_url`, `activo`, `fecha_alta`, `fecha_modifica`, `fecha_elimina`, `id_categoria`) VALUES
(123, 'Costilla Swift', 'Costilla de novillo swift por kg', 5000.00, 2, '', 1, '2025-06-05 11:44:20', '2025-06-09 21:29:54', '2025-06-09 21:29:54', 3),
(1234, 'Fideos Favorita', ' Spaguetti 500 gr', 400.00, 5, NULL, 1, '2025-06-03 11:41:14', '2025-06-09 20:47:58', '2025-06-09 20:47:58', 5),
(1235, 'Gaseosa Coca Cola', '1 litro sabor cola', 3500.00, 3, '', 1, '2025-06-09 20:33:41', '2025-06-09 20:36:29', '2025-06-09 20:36:29', 7),
(1236, 'Gaseosa Coca Cola', '1 litro', 6000.00, 20, '', 1, '2025-06-09 20:46:59', '2025-06-09 20:47:26', '2025-06-09 20:47:26', 7),
(1237, 'Gaseosa Coca Cola', '1 litro', 6000.00, 20, '', 1, '2025-06-09 21:21:11', '2025-06-09 21:21:11', NULL, 7),
(1238, 'Pan', 'Lactal', 1200.00, 10, '', 1, '2025-06-09 21:21:58', '2025-06-09 21:21:58', NULL, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `Category` (`nombre`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `idx_productos_id_categoria` (`id_categoria`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1239;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
