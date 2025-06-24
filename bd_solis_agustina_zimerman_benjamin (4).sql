-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-06-2025 a las 16:18:57
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
-- Base de datos: `bd_solis_agustina_zimerman_benjamin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_agregado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `id` int(11) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(50) NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-06-21-001028', 'App\\Database\\Migrations\\AddRolToUsuariosTable', 'default', 'App', 1750464847, 1),
(2, '2025-06-21-002716', 'App\\Database\\Migrations\\AddActivoToUsuariosTable', 'default', 'App', 1750465781, 2);

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
(123, 'Costilla Swift', 'Costilla de novillo swift por kg', 5000.00, 2, 'https://clientes.sigmafoodservice.com/medias/70040129.jpg?context=bWFzdGVyfGltYWdlc3w3NDQ2OHxpbWFnZS9qcGVnfGFHSTJMMmd4T1M4NU5qUTRORFl4T0RRd05ERTBMemN3TURRd01USTVMbXB3Wnd8NDY2MzYxMGYzM2Q0MTQzNmQ0YmRkODdkYTI3MTQzY2ZmY2JlMmE2YjkxOGY5MjllMzA5NzZlZmFhNmRlNmI3N', 1, '2025-06-05 11:44:20', '2025-06-09 21:29:54', '2025-06-09 21:29:54', 3),
(1234, 'Fideos Favorita', ' Spaguetti 500 gr', 400.00, 5, 'https://statics.dinoonline.com.ar/imagenes/full_600x600_ma/2540899_f.jpg', 1, '2025-06-03 11:41:14', '2025-06-09 20:47:58', '2025-06-09 20:47:58', 5),
(1235, 'Gaseosa Coca Cola', '1 litro sabor cola', 3500.00, 3, '', 1, '2025-06-09 20:33:41', '2025-06-09 20:36:29', '2025-06-09 20:36:29', 7),
(1236, 'Gaseosa Coca Cola', '1 litro', 6000.00, 20, '', 1, '2025-06-09 20:46:59', '2025-06-09 20:47:26', '2025-06-09 20:47:26', 7),
(1237, 'Gaseosa Coca Cola', '1 litro', 6000.00, 11, 'https://dcdn-us.mitiendanube.com/stores/001/151/835/products/77908950004301-80602de5b61cff11bb15890782195412-1024-1024.jpg', 1, '2025-06-09 21:21:11', '2025-06-23 23:34:30', NULL, 7),
(1238, 'Pan', 'Lactal', 1200.00, 3, '', 1, '2025-06-09 21:21:58', '2025-06-23 20:29:36', '2025-06-23 20:29:36', 2),
(1239, 'Costilla de Cerdo', 'Cerdo chancho', 5000.00, 20, 'https://arcordiezb2c.vteximg.com.br/arquivos/ids/176372/Costilla-De-Cerdo-X-Kg-1-5527.jpg?v=638043933857030000', 1, '2025-06-23 20:30:22', '2025-06-23 20:30:22', NULL, 3),
(1240, 'Jamón Cagnoli ', 'jamón cocido feteado x250 gr envasado al vacío ', 4170.20, 10, 'https://arjosimarprod.vtexassets.com/arquivos/ids/155641/Jamon-Cocido-Cagnoli-Kg-1-5849.jpg?v=637377693656330000', 1, '2025-06-23 22:20:58', '2025-06-23 22:20:58', NULL, 1),
(1241, 'Mortadela Paladini', 'mortadela Paladini x300 gr ', 3420.24, 6, 'https://www.lacoopeencasa.coop/media/lcec/publico/articulos/f/1/6/f1675c646d98582de2978081720455a2', 1, '2025-06-23 22:22:19', '2025-06-23 22:22:19', NULL, 1),
(1242, 'Queso Pategras La Paulina', 'Queso Pategras La Paulina x300 gr envasado al vacío', 6300.50, 12, 'https://www.lacoopeencasa.coop/media/lcec/publico/articulos/d/4/c/d4cd6c063248072d00dd0ebc0b6fa7eb', 1, '2025-06-23 22:23:56', '2025-06-23 22:23:56', NULL, 1),
(1243, 'Bondiola Paladini', 'Bondiola Paladini feteada x150 gr envasada al vacío', 4510.12, 7, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9cig2FCFx_a3DT0sO-FiJSIKFIJaCVakpXQ&s', 1, '2025-06-23 22:25:04', '2025-06-23 22:25:04', NULL, 1),
(1244, 'Salame Milán Paladini', 'Salame Milán feteado Paladini x150 gr envasado al vacío', 4168.25, 4, 'https://delimart.com.ar/user-content/f96c37f6-0fbd-48c1-a021-737e3a184723.jpg', 1, '2025-06-23 22:28:37', '2025-06-23 22:28:37', NULL, 1),
(1245, 'Sprite', 'Gaseosa Sprite Lima Limón 1.5 Lt', 2800.80, 20, '', 1, '2025-06-23 22:31:05', '2025-06-23 23:35:46', '2025-06-23 23:35:46', 7),
(1246, 'Fanta', 'Gaseosa Fanta Naranja1.5lt', 2883.40, 20, 'https://dcdn-us.mitiendanube.com/stores/001/151/835/products/77908950010171-f5d162eb6218e6544815890789301064-1024-1024.jpg', 1, '2025-06-23 22:32:01', '2025-06-23 22:32:01', NULL, 7),
(1247, 'Cerveza Miller', 'Cerveza Rubia Miller Genuine Draft Lata x 473 Ml', 2200.00, 30, 'https://hiperlibertad.vtexassets.com/arquivos/ids/172495-800-auto?v=637467730619030000&width=800&height=auto&aspect=true', 1, '2025-06-23 22:34:27', '2025-06-23 22:34:27', NULL, 7),
(1248, 'Fernet Branca', 'Fernet Branca x750cc ', 12500.50, 12, 'https://acdn-us.mitiendanube.com/stores/001/144/141/products/3070001_f1-a405ae57c3cc2692e415868118505808-640-0.jpg', 1, '2025-06-23 22:35:37', '2025-06-23 22:35:37', NULL, 7),
(1249, 'Cerveza Corona', 'Cerveza Rubia Corona 300cc', 4400.00, 15, 'https://distribuidoramif.com.ar/wp-content/uploads/2024/08/751da77e-f226-4007-9176-2ebec4d2bb77.jpg', 1, '2025-06-23 22:36:49', '2025-06-23 22:36:49', NULL, 7),
(1250, 'Queso Cremoso Cremon La Serenisima', 'Queso Cremoso Cremon La Serenisima 500 Gr', 6873.33, 6, 'https://lailusiononline.com.ar/imagenes/publicaciones/618905/0_thumb_618905_ab0e53ab1b1946f3d4c757a7f316fb18.webp', 1, '2025-06-23 22:38:29', '2025-06-23 22:38:29', NULL, 1),
(1251, 'Carne Molida especial Zimelman', 'Carne Molida Especial Congelada Zimelman 500 G', 6730.27, 30, 'https://productosdeldia.com/cdn/shop/products/CARNEMOLIDA.png?v=1633038321', 1, '2025-06-23 22:42:53', '2025-06-23 22:42:53', NULL, 3),
(1252, 'Milanesa de pollo', 'milanesa de pollo x kg', 5230.25, 10, 'https://acdn-us.mitiendanube.com/stores/001/157/846/products/milanesas-todas1-46a986b4bfcd038aaa16648884607858-640-0.png', 1, '2025-06-23 22:44:17', '2025-06-23 22:44:17', NULL, 3),
(1253, 'Peceto ', 'Peceto envasado al vacío x kilo', 15080.88, 12, 'https://arjosimarprod.vtexassets.com/arquivos/ids/155728/Peceto-de-Novillito-Kg-1-8364.jpg?v=637378633522130000', 1, '2025-06-23 22:45:23', '2025-06-23 22:45:23', NULL, 3),
(1254, 'Bife de Chorizo', 'Bife de Chorizo envasado al vacío por kilo', 16240.95, 23, 'https://acdn-us.mitiendanube.com/stores/861/458/products/bife-de-chorizo1-ced07cfd2e04c2022b15702023078761-1024-1024.jpg', 1, '2025-06-23 22:46:23', '2025-06-23 22:46:23', NULL, 3),
(1255, 'Bife de Cuadril', 'Bife de Cuadril envasado al vacío por kilo', 10428.91, 13, 'https://www.res.com.ar/media/catalog/product/cache/6c63de560a15562fe08de38c3c766637/c/u/cuadril.jpg', 1, '2025-06-23 22:47:08', '2025-06-23 22:47:08', NULL, 3),
(1256, 'Papa negra', 'Papa negra por kilo', 504.95, 40, 'https://www.superaki.mx/cdn/shop/products/0000000000147.png?v=1634911468', 1, '2025-06-23 22:49:27', '2025-06-24 01:21:42', NULL, 4),
(1257, 'Cebolla Blanca', 'Cebolla blanca por kilo', 750.00, 50, 'https://www.clarin.com/2016/12/27/Bym_3FWrg_1200x0.jpg', 1, '2025-06-23 22:50:13', '2025-06-24 01:23:14', NULL, 4),
(1258, 'Lechuga Repollada', 'Lechuga Repollada por 300 gr', 1695.85, 25, 'https://acdn-us.mitiendanube.com/stores/001/219/229/products/lechuga-repollada1-195c11412b03d49fea16025975848780-640-0.jpg', 1, '2025-06-23 22:51:25', '2025-06-24 01:23:54', NULL, 4),
(1259, 'Morrón Verde', 'Morrón Verde por 250gr', 765.20, 21, 'https://www.packfruit.com.ar/media/productos/6068650156_292feac7a5_z.jpg', 1, '2025-06-23 22:52:32', '2025-06-24 01:24:41', NULL, 4),
(1260, 'Manzana Roja', 'Manzana Roja por kilo', 2460.75, 32, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcToksvFu8lSKMLjI-vKpNr0hAAXXWX_mv4PGA&s', 1, '2025-06-23 22:53:06', '2025-06-24 01:25:20', NULL, 4),
(1261, 'Banana', 'Banana por kilo', 3200.00, 40, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTYndi-maZ1i84U1Im_SEw27sRqd7dKsCN6qw&s', 1, '2025-06-23 22:53:45', '2025-06-24 01:25:46', NULL, 4),
(1262, 'Lavandina Ayudin', 'Lavandina Ayudin por 700ml', 3242.62, 15, 'https://acdn-us.mitiendanube.com/stores/001/165/255/products/ayudin-lavandina-clasica-1l-69cff2fbe9f90343c617006063082250-1024-1024.jpg', 1, '2025-06-23 22:55:32', '2025-06-24 01:16:15', NULL, 6),
(1263, 'Detergente Magistral', 'Detergente Magistral Ultra Limón 225ml', 1978.17, 13, 'https://jumboargentina.vtexassets.com/arquivos/ids/826347/Detergente-Magistral-Ultra-Lim-n-Botella-750-Ml-1-1017530.jpg?v=638551209644270000', 1, '2025-06-23 22:57:20', '2025-06-24 01:18:05', NULL, 6),
(1264, 'Detergente Ala', 'Detergente Lavavajilla Cremoso Con Glicerina Ala x 750 Ml\r\n', 2647.59, 24, 'https://farmalife.vtexassets.com/arquivos/ids/187139/7791290793927--1-.jpg?v=638512288979730000', 1, '2025-06-23 22:58:31', '2025-06-24 01:19:51', NULL, 6),
(1265, 'Glade Harmony', 'Desodorante de Ambiente Aerosol Glade Harmony 360 Ml', 3406.25, 16, 'https://hiperlibertad.vtexassets.com/arquivos/ids/218179/GLADE-AERO-HARMONY-380ML-2-50479.jpg?v=638430036490300000', 1, '2025-06-23 22:59:31', '2025-06-24 01:19:05', NULL, 6),
(1266, 'Jabón en Polvo Ala', 'Jabon En Polvo Ala Matic 800 Gr', 2540.58, 17, 'https://www.delimart.com.ar/user-content/bfe81087-2081-4fd9-b5cb-ee46a25ede41.jpg', 1, '2025-06-23 23:01:47', '2025-06-23 23:33:47', NULL, 6),
(1267, 'Jabon Lux Orquidea Negra', 'Jabon Lux Orquidea Negra por 3 unidades 125 Gr', 2511.62, 19, 'https://plataforma.supersimple.com.ar/Panelcontenidos/Contenidos/1740428335-0-0.png', 1, '2025-06-23 23:04:30', '2025-06-23 23:04:30', NULL, 6),
(1268, 'Bizcochuelo Exquisita', 'Bizcochuelo Exquisita Chocolate Especial 540 Gr', 3047.69, 31, 'https://maxiconsumo.com/media/catalog/product/cache/dee42de555cd0e5c071d2951391ded3b/5/5/556.jpg', 1, '2025-06-23 23:14:14', '2025-06-23 23:14:14', NULL, 5),
(1269, 'Dulce de Leche La Serenisima', 'Dulce De Leche Clasico La Serenisima 400 Gr', 2491.18, 52, 'https://acdn-us.mitiendanube.com/stores/001/380/807/products/dulce-de-leche-la-seren-sima-cl-sico-x-400-gr-1-6620-9032bdf477225d72c217099875794540-1024-1024.webp', 1, '2025-06-23 23:17:39', '2025-06-23 23:17:39', NULL, 5),
(1270, 'Fideo Spaghetti La Favorita', 'Fideo Spaghetti La Favorita por 500 gr', 847.96, 36, 'https://statics.dinoonline.com.ar/imagenes/full_600x600_ma/2540899_f.jpg', 1, '2025-06-23 23:19:07', '2025-06-23 23:19:07', NULL, 5),
(1271, 'Aceite Girasol Legitimo', 'Aceite Girasol Legitimo por 900cc', 2150.49, 24, 'https://arcordiezb2c.vteximg.com.br/arquivos/ids/180115/Aceite-Girasol-Legitimo-1500-Cc-1-15323.jpg?v=638333373695700000', 1, '2025-06-23 23:20:16', '2025-06-23 23:20:16', NULL, 5),
(1272, 'Arroz Danubio', 'Arroz Danubio Largo Fino por kilo', 1720.45, 23, 'https://depotexpress.com.ar/wp-content/uploads/2022/05/ARROZ-DANUBIO-LARGO-FINO-00000-X-500.png', 1, '2025-06-23 23:21:45', '2025-06-23 23:21:45', NULL, 5),
(1273, 'Harina Pureza', 'Harina 0000 Ultra refinada Pureza por kilo', 1340.60, 14, 'https://ardiaprod.vtexassets.com/arquivos/ids/313482/Harina-0000-Pureza-Ultra-Refinada-1-Kg-_1.jpg?v=638599414991800000', 1, '2025-06-23 23:23:18', '2025-06-23 23:23:18', NULL, 5),
(1274, 'Pan Rallado Luchetti', 'Pan Rallad Luchetti por 500 gr', 1441.14, 12, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQp92XNGIFbjr-04TD9beUWmW-KkvtP7jeOEA&s', 1, '2025-06-23 23:25:59', '2025-06-23 23:25:59', NULL, 2),
(1275, 'Pan francés', 'Pan francés por kilo', 1339.85, 50, 'https://www.distribuidora.com.ar/productos/productos/23468.jpg', 1, '2025-06-23 23:28:06', '2025-06-23 23:28:06', NULL, 2),
(1276, 'Pan Lactal', 'Pan Lactal por 460gr', 3420.00, 32, 'https://elnenearg.vtexassets.com/arquivos/ids/166800/PAN-LACTAL-MESA-GRANDE-X460GR-1-11658.jpg?v=638180337675700000', 1, '2025-06-23 23:29:33', '2025-06-23 23:29:33', NULL, 2),
(1277, 'Cañoncitos de Dulce de Leche', 'Cañoncitos de Dulce de Leche por 250 gr', 1200.00, 26, 'https://cuk-it.com/wp-content/uploads/2021/08/canoncitos-stories03b.webp', 1, '2025-06-23 23:31:17', '2025-06-23 23:31:17', NULL, 2),
(1278, 'Prepizza', 'Prepizza por unidad', 950.45, 45, 'https://arcordiezb2c.vteximg.com.br/arquivos/ids/184505/Prepizza-Don-Michelli-2-Un-500-Gr-1-15120.jpg?v=638524425654630000', 1, '2025-06-23 23:32:10', '2025-06-23 23:32:10', NULL, 2),
(1279, 'Facturas dulces', 'Facturas dulces surtidas por docena', 4000.00, 36, 'https://arjosimarprod.vtexassets.com/arquivos/ids/155684/Facturas-Surtidas-1U-1-6339.jpg?v=637377693980300000', 1, '2025-06-23 23:33:23', '2025-06-23 23:33:23', NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` int(5) NOT NULL DEFAULT 2,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`, `rol`, `activo`) VALUES
(1, 'Benjamin', 'benja@gmail.com', '$2y$10$953ss/R/PHgD6PMxHOPJ3OqboKza9BgyKhqp7WWdVy6GFwH/CwY0e', 2, 1),
(2, 'Agustin', 'agus@gmail.com', '$2y$10$VZwHMBe2U5xgo3alACF2zOLx8iJJ5RiSHL8Lnf.8cn9jsV.ZCm9j.', 2, 1),
(3, 'marta', 'marta@gmail.com', '$2y$10$RmIMcvl/yYcENNT/6/4IS.N123yk/5SX9PX5e8ooqRAjfKGEh6Jay', 2, 1),
(4, 'tobias', 'tobias@gmail.com', '$2y$10$TSdcXeny9Zfs/BCtoQF.6uPUp92Ah.HRghDPJtoklbAjBKttwNybO', 2, 1),
(5, 'BenjaminZim', 'benjaminzimermanxiaomi@gmail.com', '$2y$10$BxNqF3gE21b3KsB1E7ylKuhct/RJpmxdDpUqCCenDdidL3Hbphfk2', 1, 1),
(7, 'Martin', 'martin3@gmail.com', '$2y$10$8t3DoKufsbuGPN3kXPwD3.Tc6sop6ppzLnlvtuMzAL0c7B8iN.WVy', 2, 1),
(8, 'agustina', 'solisagustinaaylen@gmail.com', '$2y$10$12uYmXfEYOGhtpAuM9GQfePQZtRf9wqdNSodQ55EU7NWWZC04Jn56', 2, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `Category` (`nombre`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `idx_productos_id_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1280;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
