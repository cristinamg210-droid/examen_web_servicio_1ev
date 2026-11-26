-- Little Chapters: estructura y datos iniciales

CREATE DATABASE IF NOT EXISTS `little_chapters`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
USE `little_chapters`;

CREATE TABLE IF NOT EXISTS `categoria` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` varchar(20) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE TABLE IF NOT EXISTS `producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE TABLE IF NOT EXISTS `pedido` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` varchar(50) NOT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE TABLE IF NOT EXISTS `detalle_pedido` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `id_pedido` (`id_pedido`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Datos de categorias
INSERT INTO `categoria` (`id_categoria`, `nombre`, `descripcion`) VALUES
(1, 'Accesorios de lectura', 'Productos para acompañar tus momentos de lectura'),
(2, 'Papelería literaria', 'Artículos de papelería relacionados con la lectura'),
(3, 'Rincón acogedor', 'Productos para crear un espacio cómodo y acogedor')
ON DUPLICATE KEY UPDATE `nombre`=VALUES(`nombre`), `descripcion`=VALUES(`descripcion`);

-- Datos de productos
INSERT INTO `producto` (`id_producto`, `id_categoria`, `nombre`, `descripcion`, `precio`, `stock`, `imagen`) VALUES
(1, 1, 'Lámpara de lectura', 'Lámpara pequeña para leer cómodamente sin molestar a otras personas.', 18.50, 12, 'imagenes/productos/lampara_lectura.webp'),
(2, 1, 'Marcapáginas', 'Marcapáginas para señalar la página en la que te has quedado.', 2.35, 25, 'imagenes/productos/marcapaginas.avif'),
(3, 1, 'Funda para libros', 'Funda para proteger los libros y llevarlos cómodamente.', 9.90, 15, 'imagenes/productos/funda_libros.webp'),
(4, 1, 'Marcapáginas magnético', 'Marcapáginas magnético que se sujeta a la página del libro.', 3.50, 20, 'imagenes/productos/marcapaginas_magnetico.webp'),
(5, 1, 'Luz de lectura con pinza', 'Luz con pinza para colocarla directamente en el libro.', 14.95, 10, 'imagenes/productos/luz_pinza.jpg'),
(6, 1, 'Soporte para libros', 'Soporte para mantener el libro abierto mientras lees.', 11.50, 12, 'imagenes/productos/soporte_libros.jpg'),
(7, 1, 'Funda para libros acolchada', 'Funda acolchada que ayuda a proteger los libros de golpes y roces.', 13.90, 10, 'imagenes/productos/funda_libros_acolchada.jpg'),
(8, 1, 'Marcapáginas de tela', 'Marcapáginas de tela para acompañar tus lecturas.', 4.25, 20, 'imagenes/productos/marcapaginas_tela.jpg'),
(9, 2, 'Libreta', 'Libreta para escribir notas, ideas y apuntes.', 15.50, 15, 'imagenes/productos/libreta.avif'),
(10, 2, 'Diario de lectura', 'Diario para apuntar los libros que lees y tus opiniones.', 12.95, 12, 'imagenes/productos/diario_lectura.jpg'),
(11, 2, 'Cuaderno literario', 'Cuaderno para escribir y organizar tus ideas sobre tus lecturas.', 8.50, 18, 'imagenes/productos/cuaderno_literario.jpg'),
(12, 2, 'Bolígrafo', 'Bolígrafo para escribir y tomar notas.', 2.75, 30, 'imagenes/productos/boligrafo.jpg'),
(13, 2, 'Pack de pegatinas literarias', 'Pack de pegatinas con diseños relacionados con los libros y la lectura.', 4.50, 20, 'imagenes/productos/pegatinas.jpg'),
(14, 2, 'Bloc de notas', 'Bloc de notas para apuntar tareas, ideas y recordatorios.', 5.95, 15, 'imagenes/productos/bloc_notas.webp'),
(15, 2, 'Planificador de lectura', 'Planificador para organizar tus próximas lecturas.', 10.90, 12, 'imagenes/productos/planificador_lectura.avif'),
(16, 2, 'Set de papelería', 'Conjunto de artículos de papelería para organizar tus apuntes.', 16.95, 10, 'imagenes/productos/set_papeleria.jpg'),
(17, 3, 'Taza', 'Taza para disfrutar de tu bebida favorita mientras lees.', 12.90, 15, 'imagenes/productos/taza.webp'),
(18, 3, 'Vela aromática', 'Vela aromática para crear un ambiente agradable.', 9.50, 12, 'imagenes/productos/vela_aromatica.avif'),
(19, 3, 'Cojín decorativo', 'Cojín decorativo para dar un toque acogedor a tu espacio.', 17.95, 8, 'imagenes/productos/cojin.jpg'),
(20, 3, 'Manta suave', 'Manta suave para acompañar tus momentos de lectura.', 24.90, 8, 'imagenes/productos/manta.jpg'),
(21, 3, 'Lámina decorativa', 'Lámina decorativa para dar un toque literario a tu habitación.', 8.95, 15, 'imagenes/productos/lamina_decorativa.avif'),
(22, 3, 'Taza literaria', 'Taza con un diseño inspirado en el mundo de los libros.', 14.50, 12, 'imagenes/productos/taza_literaria.webp'),
(23, 3, 'Vela con diseño de libros', 'Vela decorativa con un diseño relacionado con la lectura.', 11.95, 10, 'imagenes/productos/vela_literaria.jpg'),
(24, 3, 'Cojín con frase literaria', 'Cojín decorativo con una frase relacionada con los libros.', 19.50, 8, 'imagenes/productos/cojin_frase.jpg')
ON DUPLICATE KEY UPDATE `id_categoria`=VALUES(`id_categoria`), `nombre`=VALUES(`nombre`), `descripcion`=VALUES(`descripcion`), `precio`=VALUES(`precio`), `stock`=VALUES(`stock`), `imagen`=VALUES(`imagen`);

-- Usuarios de prueba (hashes de contraseña del volcado original)
INSERT INTO `usuario` (`id_usuario`, `nombre`, `email`, `contrasena`, `rol`) VALUES
(1, 'Ana Gomez', 'ana1@gmail.com', '$2y$10$acA0iMYnt9HDpQUEqUuRJueYcRWqe33WkYnyiEqxh7tIXfeT72U6m', 'cliente'),
(2, 'Cristina Menéndez', 'cristinamg210@gmail.com', '$2y$10$k9AIyPhDjFZ/NSOS5RBzoe56WJaFQfWRpt9NKNtpMG6Xz/KRr.u5a', 'admin'),
(3, 'Juan', 'j@gmail.com', '$2y$10$fTB.Kv1ckSLN9AGTtsLMOOvFdk0A45YU7tEj.3JlefBc3Yq6GGiS', 'cliente'),
(4, 'Jorge', 'jorge@gmail.com', '$2y$10$.wnN5z0ygOihtioqpPENCON9FY9zd4ysffxeuEfLSpFt.iwYPZ8eW', 'cliente')
ON DUPLICATE KEY UPDATE `nombre`=VALUES(`nombre`), `email`=VALUES(`email`), `contrasena`=VALUES(`contrasena`), `rol`=VALUES(`rol`);
