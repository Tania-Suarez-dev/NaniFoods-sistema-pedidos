-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-04-2026 a las 23:55:48
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
-- Base de datos: `nanifoods`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarPedidosConDetalles` (IN `fechaInicio` DATE, IN `fechaFin` DATE, IN `estadoPedido` VARCHAR(50))   BEGIN
    SELECT 
        p.id AS id_pedido,
        p.preciototal,
        p.fecha,
        p.estado,
        p.id_cliente,
        p.id_repartidor,
        p.direccion,
        p.metodo_pago,
        p.observaciones,
        GROUP_CONCAT(CONCAT('Producto ID ', dp.id_producto, ' x', dp.cantidad, ' ($', dp.precio_unitario, ')') SEPARATOR ' | ') AS productos
    FROM pedidos p
    LEFT JOIN detalles_pedidos dp ON p.id = dp.id_pedido
    WHERE 
        (fechaInicio IS NULL OR p.fecha >= fechaInicio)
        AND (fechaFin IS NULL OR p.fecha <= fechaFin)
        AND (estadoPedido IS NULL OR p.estado COLLATE utf8mb4_general_ci = estadoPedido COLLATE utf8mb4_general_ci)
    GROUP BY p.id
    ORDER BY p.fecha DESC;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedidos`
--

CREATE TABLE `detalles_pedidos` (
  `id` int(11) NOT NULL,
  `precio_unitario` int(11) DEFAULT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalles_pedidos`
--

INSERT INTO `detalles_pedidos` (`id`, `precio_unitario`, `id_pedido`, `id_producto`, `cantidad`) VALUES
(102, 25000, 102, 2, 3),
(116, 20000, 111, 1, 1),
(117, 23000, 111, 3, 1),
(118, 15000, 111, 19, 1),
(119, 20000, 112, 1, 1),
(120, 15000, 112, 19, 1),
(121, 15000, 121, 1, 1),
(122, 15000, 122, 2, 6),
(123, 25000, 122, 14, 3),
(124, 15000, 122, 17, 17),
(125, 30000, 123, 3, 20),
(126, 15000, 123, 23, 5),
(127, 15000, 123, 24, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `preciototal` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `estado` varchar(10) DEFAULT NULL,
  `direccion` varchar(255) NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `observaciones` text NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_repartidor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `preciototal`, `fecha`, `estado`, `direccion`, `metodo_pago`, `observaciones`, `id_cliente`, `id_repartidor`) VALUES
(102, 136000, '2025-10-01 00:00:00', 'pendiente', '', '', '', 17, 10),
(111, 58000, '2025-10-15 00:00:00', 'pendiente', 'calle falsa 123', 'efectivo', 'un repartidor guapo', 17, 10),
(112, 35000, '2025-10-15 00:00:00', 'pendiente', 'calle falsa 123', 'transferencia', 'salamandra mutante', 17, 10),
(121, 15000, '2025-10-17 04:49:49', 'pendiente', 'Cl. 65 #113F-55', 'efectivo', 'SADSFD', 17, 10),
(122, 420000, '2025-10-19 03:50:29', 'pendiente', 'Calle 80', 'efectivo', 'Que este bien rico', 20, 10),
(123, 720000, '2025-10-18 20:55:32', 'pendiente', 'Calle 70A #115 D-04', 'transferencia', 'Algo bien elaborado plis', 20, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `categoria` varchar(15) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `eliminado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`codigo`, `nombre`, `precio`, `descripcion`, `categoria`, `imagen`, `activo`, `eliminado`) VALUES
(1, 'Hamburguesa Sencilla', 18000, 'rica hamburguesa sabor a hamburguesa', 'hamburguesa', 'img/products/1a9d86d7-b476-4c6a-9894-e43173d526be_anuncioham.png', 1, 0),
(2, 'Hamburguesa Doble', 25000, 'rica hamburguesa con doble sabor a hamburguesa', 'hamburguesa', 'img/products/280db54c-676c-4b93-8123-f89101e1366f_plastica.png', 1, 0),
(3, 'MONSTRUO TRIPLE X', 30000, 'Tres carnes jugosas 100% premium, doble ración de nuestra tocineta crujiente ahumada y queso fundido. Un exceso que te mereces, si puedes con ella, es tuya.', 'hamburguesa', 'img/products/b7414b58-0213-4c4d-a277-1846270df264_monstruosa.png', 1, 0),
(4, 'Frisby Burguer', 18000, '¡Ríndete a la tentación! Dos medallones de pollo frito perfectos, queso derretido y vegetales frescos. Tu nueva obsesión está aquí.', 'hamburguesa', 'img/products/0d5366e3-1506-402f-a7f6-b4531b063444_Crispy.png', 1, 0),
(10, 'Hamburguesa Mexicana', 200000, 'Pollo Mexicano\r\nHamburguesa de 154 g de pechuga de pollo, guacamole, frijol refrito, nachos de maíz, tomate, lechuga y salsa blanca en pan ajonjolí', 'hamburguesa', 'img/products/7d87eb58-1a25-4b79-8740-04d4781bb9f5_base.png', 1, 0),
(11, 'Frisby Única ', 25000, '¡Ríndete a la tentación! Dos medallones de pollo frito perfectos, queso derretido y vegetales frescos. Tu nueva obsesión está aquí.', 'hamburguesa', 'img/products/f66a704e-3805-49cb-b0af-c61324b905e0_doble_pollo.png', 1, 0),
(13, 'Pizza Peperonistica', 30000, 'pizza de pepperoni en gran cantidad, jamón serrano, cubano, y cervecero, queso mozzarella y una bola de burata', 'pizza', 'img/products/d159c5c7-e49a-4f71-9232-a6ae49e9ecc6_Pizza_de_Pepperoni.jpg', 1, 0),
(14, 'Napolitana Estelar', 25000, 'La pizza napolitana es un ritual sagrado: masa nacida del fuego ancestral, tomates que guardan el sol eterno, mozzarella pura como un milagro divino y albahaca fresca que exhala un perfume celestial capaz de conquistar hasta dioses hambrientos', 'pizza', 'img/products/24f31aaf-2d3a-4f9f-92a1-ad232e899e8b_Pizza_Napolitana.jpg', 1, 0),
(15, '	Quattro Formaggii', 25000, 'La fusión perfecta de texturas y sabor: Mozzarella, Parmesano, Gorgonzola y Fontina fundidos sobre nuestra masa artesanal. Cremosa, intensa y adictiva.', 'pizza', 'img/products/feff8ff7-88a7-40f0-b903-3714cf8c7780_11.png', 1, 0),
(17, 'Granizado de fresa', 15000, ' jugo de fresa con cubos de hielo triturados del himalaya con pedazos de fresa, salsa de fresa fresca recién exprimida sabor a frambuesa', 'Granizado', 'img/products/28f266d6-f70d-45f1-8802-3d94b9e1dfe1_granifresa.png', 1, 0),
(19, 'Granizado de Mango', 15000, 'Un clásico tropical lleno de frescura. Su color naranja brillante resalta la intensidad del mango maduro, con un sabor dulce y jugoso que refresca en cada sorbo. Ideal para quienes buscan una experiencia exótica y energizante.', 'Granizado', 'img/products/bdf46c93-fa51-4916-9710-8376c0018d31_granimango.png', 1, 0),
(20, 'Granizado de Sandia', 15000, 'Ligero y refrescante como una tarde de verano. Su tono rojo vibrante refleja la jugosidad de la sandía natural, con un toque sutil de dulzura que calma la sed y revive el ánimo. Perfecto para un respiro fresco y natural.', 'Granizado', 'img/products/1973f5e6-a821-4777-8c6d-9d68d1e98053_granisandia.png', 1, 0),
(21, 'Granizado de Arandanos', 15000, 'El granizado de arándanos es un hechizo helado: cristales de hielo que crujen como diamantes, jugo púrpura que explota como fuegos artificiales frutales y frescura tan brutal que podría congelar hasta un dragón sediento', 'Granizado', 'img/products/f57263d0-3bc8-455c-a4bd-1c44b61df152_graniarandanos.png', 1, 0),
(22, 'Granizado de Lulo', 15000, 'Exótico y auténtico, con un color verde amarillento translúcido característico del jugo de lulo natural. Su sabor es una mezcla única de ácido y dulce, que ofrece una experiencia tropical inigualable para los paladares aventureros.', 'Granizado', 'img/products/a987ec43-3257-422f-88f8-1f05eff57d18_granilulo.png', 1, 0),
(23, 'Granizado de Maracuya ', 15000, 'Intenso y vibrante, con un color amarillo dorado que refleja la pasión y frescura de esta fruta. Su sabor es una explosión de notas ácidas y dulces que despiertan los sentidos y aportan un golpe de energía natural.', 'Granizado', 'img/products/5596a1a0-d738-4212-ae7f-c166f9b5f2ee_granimaracuya.png', 1, 0),
(24, 'Granizado de Mora', 15000, 'De color morado intenso, este granizado es un deleite frutal con sabor dulce y ácido al mismo tiempo. Su frescura resalta la esencia natural de la mora, convirtiéndolo en una opción vibrante y deliciosa.', 'Granizado', 'img/products/bb57cc4c-8bf5-44d2-9d35-bb7dc9b71b9d_granimora.png', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repartidores`
--

CREATE TABLE `repartidores` (
  `id` int(11) NOT NULL,
  `cedul` int(11) DEFAULT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `vehiculo` varchar(20) DEFAULT NULL,
  `placa` varchar(6) DEFAULT NULL,
  `eps` varchar(15) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `contraseña` varchar(20) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `repartidores`
--

INSERT INTO `repartidores` (`id`, `cedul`, `nombre`, `correo`, `vehiculo`, `placa`, `eps`, `fecha_nacimiento`, `contraseña`, `observaciones`) VALUES
(10, 11111111, 'Pedro Repartidor', 'pedro@correo.com', 'moto', 'XYZ123', 'Sura', '1995-06-01', 'clave', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resena`
--

CREATE TABLE `resena` (
  `ID_resena` int(11) NOT NULL,
  `tipo_resena` varchar(10) NOT NULL,
  `estrellas` int(11) DEFAULT NULL,
  `resena` varchar(100) DEFAULT NULL,
  `id_detalles_pedido` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nombre_cliente` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `resena`
--

INSERT INTO `resena` (`ID_resena`, `tipo_resena`, `estrellas`, `resena`, `id_detalles_pedido`, `fecha`, `nombre_cliente`) VALUES
(1, 'pedido', 5, 'excelente producto', 102, '2025-10-15 15:22:28', 'Cliente Prueba'),
(2, 'pedido', 3, 'se puede mejorar el producto', 102, '2025-10-15 15:23:19', 'Cliente Prueba'),
(3, 'pedido', 1, 'El peor producto que he probado', 102, '2025-10-15 15:23:19', 'Cliente Prueba'),
(4, 'pedido', 4, 'Muy bueno', 102, '2025-10-15 15:23:19', 'Cliente Prueba'),
(5, 'pedido', 2, 'hay cosas por mejorar', 102, '2025-10-15 15:23:19', 'Cliente Prueba'),
(6, 'pedido', 2, 'la comida me supo a culo', 102, '2025-10-15 15:23:19', 'hola'),
(7, 'pedido', 4, 'un manjar hecho por los mismos dioses dejando un sabor fdloripepiado en la jeta', 102, '2025-10-15 15:23:19', 'fulano rodriguez'),
(8, 'pedido', 5, 'La mejor hamburguesa de todas, se la compre a Cris Jr. y le gustó mucho, recomendada 100%', 102, '2025-10-15 15:23:19', 'Cristiano Ronaldo'),
(9, 'pedido', 3, 'popo', 102, '2025-10-15 15:23:19', 'matias fernandez'),
(10, 'pedido', 5, 'bien', NULL, '2025-10-18 08:37:59', ':v'),
(11, 'producto', 3, 'masomeno', NULL, '2025-10-18 01:40:49', ':v');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `rol` varchar(20) DEFAULT NULL,
  `identificacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `telefono`, `fecha_nacimiento`, `contraseña`, `rol`, `identificacion`) VALUES
(17, 'mod', 'mod@gmail.com', 2147483647, '2000-01-01', '$2y$10$yfN239LFdioQPcvbLXuIJuEj.xZVX.A2QGEvJoNAYxwwGlPMkSgOS', 'user', 1234567890),
(20, 'admin', 'admin@gmail.com', 30000000, '2023-11-17', '$2y$10$89e347RfvGj0U5tkgBhltOehf264hV39BwQV7PJxIA4SVp6bJZyeW', 'admin', 1234567890),
(21, 'pepito', 'hectorpamplona@hotmail.com', 2147483647, '4234-03-12', '$2y$10$OxS9BctrEtLxrf5ekRuB4OEFVl5KbDs37NXQtFJFgjvEIIvojaU1.', 'user', 12345678);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalles_pedidos`
--
ALTER TABLE `detalles_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalles_pedidos_ibfk_1` (`id_pedido`),
  ADD KEY `detalles_pedidos_ibfk_2` (`id_producto`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedidos_ibfk_1` (`id_cliente`),
  ADD KEY `pedidos_ibfk_2` (`id_repartidor`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `repartidores`
--
ALTER TABLE `repartidores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resena`
--
ALTER TABLE `resena`
  ADD PRIMARY KEY (`ID_resena`),
  ADD KEY `id_detalles_pedido` (`id_detalles_pedido`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalles_pedidos`
--
ALTER TABLE `detalles_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `repartidores`
--
ALTER TABLE `repartidores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `resena`
--
ALTER TABLE `resena`
  MODIFY `ID_resena` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles_pedidos`
--
ALTER TABLE `detalles_pedidos`
  ADD CONSTRAINT `detalles_pedidos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `detalles_pedidos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`codigo`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_repartidor`) REFERENCES `repartidores` (`id`);

--
-- Filtros para la tabla `resena`
--
ALTER TABLE `resena`
  ADD CONSTRAINT `resena_ibfk_1` FOREIGN KEY (`id_detalles_pedido`) REFERENCES `detalles_pedidos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
