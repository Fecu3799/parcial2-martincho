-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-12-2022 a las 19:33:36
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `parcial2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_usuario` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  `respuestas` text NOT NULL,
  `id_trabajos` int(11) NOT NULL,
  `fechas` date NOT NULL,
  `id_comentarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id_usuario`, `likes`, `respuestas`, `id_trabajos`, `fechas`, `id_comentarios`) VALUES
(1, 3, 'Que buen tema es Billie Jean', 1, '2022-09-30', 2),
(2, 7, 'Que grande Michael pero no Jackson', 2, '2022-09-22', 3),
(3, 2, 'No me gusta escuchar música', 3, '2022-04-11', 4),
(4, 8, 'No entiendo la consigna.', 4, '2022-07-08', 5),
(5, 27, 'No contesta los mails.', 5, '2022-09-27', 6),
(6, 21, 'Que bella que es Amapola.', 6, '2022-09-29', 7),
(7, 69, 'Un revistero me acosó el otro día.', 7, '2022-09-29', 8),
(8, 131, 'No quiero jugar más a la unviersidad.', 8, '2022-09-28', 9),
(17, 0, 'asduiguiqw', 2, '2022-12-02', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compartidos`
--

CREATE TABLE `compartidos` (
  `id_compartidos` int(11) NOT NULL,
  `id_usuarios` int(11) NOT NULL,
  `id_trabajos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guardados`
--

CREATE TABLE `guardados` (
  `id_guardados` int(11) NOT NULL,
  `id_usuarios` int(11) NOT NULL,
  `id_trabajos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `id_likes` int(11) NOT NULL,
  `id_usuarios` int(11) NOT NULL,
  `id_trabajos` int(11) NOT NULL,
  `id_comentarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles`
--

CREATE TABLE `niveles` (
  `id_niveles` int(11) NOT NULL,
  `rol` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `niveles`
--

INSERT INTO `niveles` (`id_niveles`, `rol`) VALUES
(1, 'Visitante'),
(2, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajos`
--

CREATE TABLE `trabajos` (
  `id_trabajos` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(128) NOT NULL,
  `likes` int(11) NOT NULL,
  `comentarios` varchar(521) NOT NULL,
  `clasificacion` int(11) NOT NULL,
  `contenido` varchar(512) NOT NULL,
  `fechas` date NOT NULL,
  `foto_url` varchar(128) NOT NULL,
  `foto_detalle` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `trabajos`
--

INSERT INTO `trabajos` (`id_trabajos`, `id_usuario`, `titulo`, `likes`, `comentarios`, `clasificacion`, `contenido`, `fechas`, `foto_url`, `foto_detalle`) VALUES
(1, 1, 'Diseño Web Escuela Da Vinci', 20, 'Una Web Excelente!', 5, 'Diseño de la página web de Escuela Da Vinci, año 2020, en colaboración con Aczerb. \r\nProgramación es comunismo. Nuestro código.', '2022-09-20', 'img/davinci.jpg', 'img/davinci.jpg'),
(2, 2, 'Identidad de Marca Coca Cola', 0, '0', 0, 'Rebranding para Coca-Cola, en su incorporación de la Coca Cola Cero Cero, en el año 2013. ', '2022-09-08', 'img/coca.jpg', 'img/identidad.png'),
(3, 3, 'Campaña Publicitaria Lenovo', 0, '0', 0, 'Lenovo presenta su nueva Notebook Legion 5 pro. La campaña se realizó para las redes.\r\nRendimiento de nivel profesional\r\nRendimiento épico por dentro y por fuera\r\nProcesamiento AMD Ryzen™ y tarjeta gráfica NVIDIA® GeForce RTX™\r\nPerfecta para juegos de alta resolución\r\nPrimera laptop de 16” del mundo con hasta 165 Hz\r\nTecnología de audio 3D de Nahimic: podrás ver y oír a cualquier enemigo acercándose a ti', '2022-09-27', 'img/lenovo.png', 'img/computadora.jpeg'),
(4, 4, 'Pieza Audiovisual Pantene', 0, '0', 0, 'Video publicitario para Pantene.\r\nPantene con sus exclusivas fórmulas con Pro-vitaminas transforma tu cabello, haciéndolo lucir más fuerte y saludable. Descubre lo que pasó por casualidad hace 70 años y cómo esto puede darle mejores días a tu cabello.', '2022-09-15', 'img/pantene.png\r\n\r\n', 'img/pantene_detalle.jpg'),
(5, 5, 'Campaña The Candel Shop\r\n', 0, '0', 0, 'Campaña con Candel Shop: Buscamos el detalle que nos dice mucho sobre cada persona y la historia que desea contar. Un aroma, un color, un objeto, que apenas se vislumbra en el espacio y transmite su estilo personal. Encontrar esos elementos, nos inspira. Diseñarlos, nos transporta. Crearlos y lograr que en ellos, la otra persona se sienta reflejada, nos emociona. Para nosotros la belleza de cada esencia, está en el aire.', '2022-08-17', 'img/candel.jpg', 'img/vela_rosa.jpeg'),
(6, 6, 'Diseño Publicidad Personal', 0, '0', 0, 'Si tenés Personal en el celu y además tenés cuenta de Flow, contás con “Flow Pass”: un pase para disfrutar de tus contenidos favoritos sin gastar los datos de tu plan. Si en tu celu tenés un plan de 3 GB o de 5 GB, podés probar un pase “Flow Pass de 10 GB” gratis. Además de esto, podés comprar los pases disponibles de diferente duración:1 día, 3 días o 30 días.', '2022-06-09', 'img/personal.jpg', 'img/control.jpeg'),
(7, 10, 'Publicidad Natura línea Ekos', 0, '0', 0, 'La línea Natura Ekos obtiene su riqueza del árbol de castaña. Por esto, considerado el rey de la selva amazónica y una de las principales fuentes de proteínas de esta comunidad. El uso de ésta, ayuda a impulsar su cosecha, haciendo ésta, una practica tradicional.', '2022-08-04', 'img/natura.jpg', 'img/perfume.jpeg'),
(8, 7, 'Corto Publicitario', 0, '0', 0, 'Corto publicitario para Mattel, en el año 2022. Campaña \"Nuevas aventuras\". Acompaña a los chicos en diversas etapas de desarrollo, para que aprendan mientras juegan.', '2022-09-26', 'img/mattel_logo.jpeg', 'img/mattel.jpeg'),
(9, 8, 'Poster Volver al Futuro ', 0, '0', 0, 'Película estadounidense de ciencia ficción y comedia de 1985 dirigida y escrita por Robert Zemeckis —Bob Gale también colaboró como guionista—, producida por Steven Spielberg y protagonizada por Michael J. Fox, Christopher Lloyd, Lea Thompson, Crispin Glover y Thomas F. Wilson.', '2022-09-13', 'img/future.jpg', 'img/future.jpg'),
(10, 9, 'Publicidad gráfica Nike', 0, '0', 0, 'La razón de nuestra existencia es prestar un servicio a los atletas, por lo que nos atrevemos a diseñar el futuro del deporte. Para nosotros, la innovación tiene que ver con mejorar el potencial humano.', '2022-09-09', 'img/nike.jpg', 'img/nike.jpg'),
(16, 17, 'Hola', 0, '', 0, 'Post numero 1', '2022-12-02', 'img/', ''),
(17, 17, 'Hola 2', 0, '', 0, 'Post numero 2', '2022-12-02', 'img/', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_niveles` int(11) NOT NULL,
  `nombre_de_usuario` varchar(64) NOT NULL,
  `clave_de_acceso` decimal(65,0) NOT NULL,
  `email` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_niveles`, `nombre_de_usuario`, `clave_de_acceso`, `email`) VALUES
(1, 1, 'Martín Cardol', '1234', 'martin_cardol@hotmail.com'),
(2, 2, 'Esteban Quito', '0', 'quito_esteban@hotmail.com'),
(3, 1, 'Jorge Rial', '0', 'conta_chisme@hotmail.com'),
(4, 1, 'Walter Ojeda', '0', 'frases_pasionales@hotmail.com'),
(5, 1, 'Julieta Amada', '0', 'ama_a_juli@hotmail.com'),
(6, 1, 'Silvina Esudero', '0', 'silvina_escudero@hotmail.com'),
(7, 1, 'Mirtha Legrand', '0', 'mirtha_legrand_1927@hotmail.com'),
(8, 1, 'Santiago Cuneo', '0', 'santiago_bobi@hotmail.com'),
(9, 1, 'Armando Paredes', '0', 'armando_tu_vida@hotmail.com'),
(10, 1, 'Florencia Peña', '0', 'yo_soy_moni_argento@hotmail.com'),
(15, 1, 'Amapola', '123', 'test@mail.com'),
(16, 1, 'Amapola', '123', 'test@mail.com'),
(17, 1, 'Amapola', '1234', 'test@mail.com'),
(18, 1, 'Amapola', '1234', 'test@mail.com'),
(19, 1, 'Ari', '1234', 'test2@mail.com'),
(20, 1, 'Ari', '1234', 'test2@mail.com'),
(21, 1, 'Elida Maribel', '1234', 'test3@mail.com'),
(22, 1, 'Elida Maribel', '1234', 'test3@mail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentarios`);

--
-- Indices de la tabla `compartidos`
--
ALTER TABLE `compartidos`
  ADD PRIMARY KEY (`id_compartidos`);

--
-- Indices de la tabla `guardados`
--
ALTER TABLE `guardados`
  ADD PRIMARY KEY (`id_guardados`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id_likes`);

--
-- Indices de la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`id_niveles`);

--
-- Indices de la tabla `trabajos`
--
ALTER TABLE `trabajos`
  ADD PRIMARY KEY (`id_trabajos`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `niveles`
--
ALTER TABLE `niveles`
  MODIFY `id_niveles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `trabajos`
--
ALTER TABLE `trabajos`
  MODIFY `id_trabajos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
