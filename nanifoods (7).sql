-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-10-2025 a las 17:55:55
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nanifoods`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedidos`
--

CREATE TABLE `detalles_pedidos` (
  `id` int(11) NOT NULL,
  `precio_unitario` int(11) DEFAULT NULL,
  `observaciones` text,
  `id_pedido` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalles_pedidos`
--

INSERT INTO `detalles_pedidos` (`id`, `precio_unitario`, `observaciones`, `id_pedido`, `id_producto`, `cantidad`) VALUES
(100, 35000, 'Caliente y bien servida', 100, 10, 1),
(101, 0, 'Llegó puntual y sonriente', 101, NULL, 1),
(102, 25000, '', 102, 2, 3),
(103, 23000, '', 102, 3, 2),
(104, 15000, '', 102, 11, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `preciototal` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `estado` varchar(10) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_repartidor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `preciototal`, `fecha`, `hora`, `estado`, `id_cliente`, `id_repartidor`) VALUES
(100, 35000, '2025-08-18', '12:00:00', 'entregado', 10, 10),
(101, 0, '2025-08-20', '15:00:00', 'entregado', 10, 10),
(102, 136000, '2025-10-01', '16:46:12', 'pendiente', 10, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `descripcion` text,
  `categoria` varchar(15) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `eliminado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`codigo`, `nombre`, `precio`, `descripcion`, `categoria`, `imagen`, `activo`, `eliminado`) VALUES
(1, 'Hamburguesa Sencilla', 20000, 'rica hamburguesa sabor a hamburguesa', 'hamburguesa', 'img/products/a29ac318-70e1-41fa-a107-a1c390b03711_anuncioham.png', 1, 0),
(2, 'Hamburguesa Triple', 25000, 'rica hamburguesa con doble sabor a hamburguesa', 'hamburguesa', 'img/products/85e71b63-0f13-432f-a87e-d1fcb0f5c0af_7.png', 1, 0),
(3, 'Frisby Burguer', 23000, 'rica hamburguesa sabor a pollo totalmente original', 'hamburguesa', 'img/products/5237e215-f774-4803-a93c-01820b70ebe4_frisbyburguer.png', 1, 0),
(4, ' BBQ Burguer', 30000, 'rica hamburguesa sabor a queso, especialidad de la casa', 'hamburguesa', 'img/products/381ca57b-1e99-49e2-a594-c953a8ca6223_5.png', 1, 0),
(10, 'Mega Hamburguesa', 35000, 'Hamburguesa gigante con queso', 'hamburguesa', 'img/products/934f4b30-8c56-49a6-b5ce-040a57ea59d8_7.png', 1, 0),
(11, 'Frisby Doble', 15000, 'Deliciosa hamburquesa con carne ahumada y queso extra', 'Hamburguesa ', 'img/products/ac164ee8-935a-4133-9163-13407f0a97b9_5.png', 1, 0),
(13, 'Pizza Peperonistica', 30000, 'pizza de pepperoni en gran cantidad, jamón serrano, cubano, y cervecero, queso mozzarella y una bola de burata', 'pizza', 'img/products/3f1c8048-da9c-4970-93a7-0b2205b8a58d_1.png', 1, 0),
(14, 'Napolitana Estelar', 25000, 'La pizza napolitana es un ritual sagrado: masa nacida del fuego ancestral, tomates que guardan el sol eterno, mozzarella pura como un milagro divino y albahaca fresca que exhala un perfume celestial capaz de conquistar hasta dioses hambrientos', 'pizza', 'img/products/ed8f306a-488c-436b-8a56-b782376543fc_3.png', 1, 0),
(15, 'Granizado de Fresa', 15000, 'jufo de fresa con cubos de hielo triturados del himalaya con pedazos de fresa, salsa de fresa fresca recién exprimida sabor a frambuesa', 'granizado', 'img/products/989c6d5b-3390-4995-861d-a02a166986e0_granifresa.png', 1, 0),
(17, 'Pizza Margarita', 25000, 'La pizza Margarita es la reina del antojo: masa dorada que cruje como aplausos, tomates que gritan verano, mozzarella que se derrite como amor adolescente y albahaca fresca que desfila como modelo en pasarela divina.', 'pizza', 'img/products/81edb1e5-845c-4b95-874d-af988d468ce4_4.png', 1, 0),
(19, 'Granizado de Mango', 15000, 'Un clásico tropical lleno de frescura. Su color naranja brillante resalta la intensidad del mango maduro, con un sabor dulce y jugoso que refresca en cada sorbo. Ideal para quienes buscan una experiencia exótica y energizante.', 'Granizado', 'img/products/92444631-1752-4a66-97b4-c21b175d8b6d_granimango.png', 1, 0),
(20, 'Granizado de Sandia', 15000, 'Ligero y refrescante como una tarde de verano. Su tono rojo vibrante refleja la jugosidad de la sandía natural, con un toque sutil de dulzura que calma la sed y revive el ánimo. Perfecto para un respiro fresco y natural.', 'Granizado', NULL, 1, 0),
(21, 'Granizado de Arandanos', 15000, 'El granizado de arándanos es un hechizo helado: cristales de hielo que crujen como diamantes, jugo púrpura que explota como fuegos artificiales frutales y frescura tan brutal que podría congelar hasta un dragón sediento', 'granizado', NULL, 1, 0),
(22, 'Granizado de Lulo', 15000, 'Exótico y auténtico, con un color verde amarillento translúcido característico del jugo de lulo natural. Su sabor es una mezcla única de ácido y dulce, que ofrece una experiencia tropical inigualable para los paladares aventureros.', 'Granizado', 'img/products/5b176651-d9ca-4990-b4a0-a5a5c45da58d_granilulo.png', 1, 0),
(23, 'Granizado de Maracuya ', 15000, 'Intenso y vibrante, con un color amarillo dorado que refleja la pasión y frescura de esta fruta. Su sabor es una explosión de notas ácidas y dulces que despiertan los sentidos y aportan un golpe de energía natural.', 'Granizado', NULL, 1, 0),
(24, 'Granizado de Mora', 15000, 'De color morado intenso, este granizado es un deleite frutal con sabor dulce y ácido al mismo tiempo. Su frescura resalta la esencia natural de la mora, convirtiéndolo en una opción vibrante y deliciosa.', 'Granizado', NULL, 1, 0),
(25, 'asd', 23, 'sdf', 'as', NULL, 1, 0);

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
  `observaciones` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `estrellas` int(11) DEFAULT NULL,
  `resena` varchar(100) DEFAULT NULL,
  `id_detalles_pedido` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nombre_cliente` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `resena`
--

INSERT INTO `resena` (`ID_resena`, `estrellas`, `resena`, `id_detalles_pedido`, `fecha`, `nombre_cliente`) VALUES
(1, 5, 'excelente producto', 102, '2025-10-01 14:53:14', 'Cliente Prueba'),
(2, 3, 'se puede mejorar el producto', 102, '2025-10-01 14:53:35', 'Cliente Prueba'),
(3, 1, 'El peor producto que he probado', 102, '2025-10-01 14:53:56', 'Cliente Prueba'),
(4, 4, 'Muy bueno', 102, '2025-10-01 14:54:14', 'Cliente Prueba'),
(5, 2, 'hay cosas por mejorar', 102, '2025-10-01 14:54:37', 'Cliente Prueba');

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
  `identificacion` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `telefono`, `fecha_nacimiento`, `contraseña`, `rol`, `identificacion`) VALUES
(10, 'Cliente Prueba', 'cliente@correo.com', 123456789, '2000-01-01', '1234', 'cliente', 987654),
(17, 'mod', 'mod@gmail.com', 2147483647, '2000-01-01', '$2y$10$yfN239LFdioQPcvbLXuIJuEj.xZVX.A2QGEvJoNAYxwwGlPMkSgOS', 'user', 1234567890),
(18, 'admin', 'admin@gmail.com', 2147483647, '2000-01-01', '$2y$10$Syxg3cPIZEV6vv5KiXl1EuKGAUaoTNUjTGDu2pWQaowyFtFZlNEOW', 'admin', 1234567890),
(19, 'test', 'test@gmail.com', 2147483647, '2000-01-01', '$2y$10$MdjFLGjhYegZCTww149YcucR3DLB71gUZwppWo1INJ2Q5rLih1Tn2', 'user', 1234567890),
(20, 'david', 'pablito@gmail.com', 2147483647, '2023-11-17', '$2y$10$89e347RfvGj0U5tkgBhltOehf264hV39BwQV7PJxIA4SVp6bJZyeW', 'user', 1234567890),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

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
  MODIFY `ID_resena` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
