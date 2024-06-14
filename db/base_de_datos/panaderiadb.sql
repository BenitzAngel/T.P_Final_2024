-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2024 a las 11:59:14
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
-- Base de datos: `panaderiadb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` text DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `altura` int(11) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `direccion`, `telefono`, `email`, `fecha_registro`, `altura`, `apellido`) VALUES
(2, 'belén', NULL, '14567890', 'asdfgh@gmail.com', '2024-06-08 17:20:53', NULL, NULL),
(5, 'milagros', 'ooejndf@dfgh.com', '12345678', '', '2024-06-11 02:26:42', 111, 'dalma'),
(6, '12345', 'Rivadavia', '1234567777', '', '2024-06-13 01:22:12', 3434, 'benitez'),
(7, '12345', '12345', '123456', '', '2024-06-13 01:41:58', 1234, '12345'),
(8, '456', '12345', '4r5t61234', '', '2024-06-13 02:15:00', 12345, '23456'),
(9, 'bbb  ', 'Rivadavia', '12345678', '', '2024-06-13 02:15:18', 12345, ' benitez'),
(10, '  asdfghjkl', 'Rivadavia', '1234567777', '', '2024-06-13 02:29:13', 111, 'benitez'),
(12, 'angel', 'Rivadavia', '1234', '', '2024-06-14 09:24:26', 1234, 'benitez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallesventas`
--

CREATE TABLE `detallesventas` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha_gasto` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

CREATE TABLE `ingredientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `unidad` varchar(50) NOT NULL,
  `fecha_compra` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_vencimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`id`, `nombre`, `descripcion`, `stock`, `unidad`, `fecha_compra`, `fecha_vencimiento`) VALUES
(8, 'Levadura', 'de cerveza', 2, 'kg', '2024-06-10 20:22:24', '2024-06-27'),
(9, 'Leche', 'entera', 500, 'cm3', '2024-06-10 20:23:27', '2024-06-14'),
(10, 'azucar', '', 20, 'kg', '2024-06-10 20:24:13', '2024-06-27'),
(11, 'huevo', 'blaco', 20, 'docenas', '2024-06-10 20:24:48', '2024-06-27'),
(14, 'harina', 'harina florencia', -10303, 'kg', '2024-06-13 10:25:00', '2024-06-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `unidad` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `stock`, `unidad`, `fecha_creacion`) VALUES
(3, 'pan', 'sin sal', 1250.00, 60, 'kg', '2024-06-09 00:54:40'),
(4, 'galleta', 'fgh', 456.00, 55, 'kg', '2024-06-09 01:06:31'),
(6, 'pan', 'salvado', 567.00, 55, 'kg', '2024-06-09 01:07:18'),
(7, 'Facturas', 'medialuna por docena', 1550.00, 10, 'docenas', '2024-06-10 20:19:11'),
(8, 'Facturas', 'deeee', 1234.00, 10, 'docenas', '2024-06-13 10:22:47'),
(9, 'Facturas', 'deeee', 1234.00, 10, 'docenas', '2024-06-13 10:23:03'),
(17, 'pan frances', 'qwe', 123.00, 103, 'kg', '2024-06-13 16:52:54');

--
-- Disparadores `productos`
--
DELIMITER $$
CREATE TRIGGER `actualizar_stock_ingredientes` AFTER INSERT ON `productos` FOR EACH ROW BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE id_ingrediente INT;
    DECLARE cantidad_ingrediente INT;
    DECLARE cur CURSOR FOR
        SELECT id_ingrediente, cantidad_ingrediente
        FROM ProductosIngredientes
        WHERE id_producto = NEW.id;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO id_ingrediente, cantidad_ingrediente;
        IF done THEN
            LEAVE read_loop;
        END IF;

        UPDATE Ingredientes
        SET stock = stock - cantidad_ingrediente * NEW.stock
        WHERE id = id_ingrediente;

        IF ROW_COUNT() = 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stock insuficiente para el ingrediente';
        END IF;
    END LOOP;

    CLOSE cur;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_producto_insert` AFTER INSERT ON `productos` FOR EACH ROW BEGIN
    DECLARE done INT DEFAULT 0;
    DECLARE cantidad_total INT;
    DECLARE id_ingrediente INT;
    DECLARE cantidad_ingrediente INT;

    DECLARE cur CURSOR FOR
        SELECT id_ingrediente, cantidad_ingrediente 
        FROM ProductosIngredientes 
        WHERE id_producto = NEW.id;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    OPEN cur;

    read_loop: LOOP
        FETCH cur INTO id_ingrediente, cantidad_ingrediente;
        IF done THEN
            LEAVE read_loop;
        END IF;
        SET cantidad_total = cantidad_ingrediente * NEW.stock;
        UPDATE Ingredientes SET stock = stock - cantidad_total WHERE id = id_ingrediente;
    END LOOP;

    CLOSE cur;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosingredientes`
--

CREATE TABLE `productosingredientes` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_ingrediente` int(11) DEFAULT NULL,
  `cantidad_ingrediente` int(11) NOT NULL,
  `unidad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productosingredientes`
--

INSERT INTO `productosingredientes` (`id`, `id_producto`, `id_ingrediente`, `cantidad_ingrediente`, `unidad`) VALUES
(63, 7, 8, 0, 'g'),
(64, 7, 9, 500, 'cm3'),
(65, 7, 10, 200, 'cm3'),
(66, 7, 11, 2, 'unidad'),
(68, 17, 14, 101, 'kg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(30) DEFAULT NULL,
  `empresa` varchar(30) NOT NULL,
  `direccion` text DEFAULT NULL,
  `altura` int(11) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `apellido`, `empresa`, `direccion`, `altura`, `telefono`, `email`, `fecha_creacion`) VALUES
(1, 'rodrigo', 'gonzales', 'litoral', '', 1234567, '12344', 'Rivadavia', '2024-06-11 03:40:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `contrasena` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `usuario`, `contrasena`) VALUES
(1, 'admin', 12345);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `fecha_venta` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `id_cliente`, `fecha_venta`, `total`) VALUES
(2, 2, '2024-06-11 06:59:07', 5567.00),
(4, 5, '2024-06-11 07:07:44', 444.00),
(5, 5, '2024-06-11 07:07:44', 444.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detallesventas`
--
ALTER TABLE `detallesventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productosingredientes`
--
ALTER TABLE `productosingredientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productosingredientes_ibfk_1` (`id_producto`),
  ADD KEY `productosingredientes_ibfk_2` (`id_ingrediente`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `detallesventas`
--
ALTER TABLE `detallesventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `productosingredientes`
--
ALTER TABLE `productosingredientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallesventas`
--
ALTER TABLE `detallesventas`
  ADD CONSTRAINT `detallesventas_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`),
  ADD CONSTRAINT `detallesventas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `productosingredientes`
--
ALTER TABLE `productosingredientes`
  ADD CONSTRAINT `productosingredientes_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productosingredientes_ibfk_2` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
