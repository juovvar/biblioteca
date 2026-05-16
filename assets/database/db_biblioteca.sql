CREATE DATABASE db_biblioteca;
USE db_biblioteca;
-- Estructura de tabla para la tabla `autores`
CREATE TABLE `autores` (
  `id_autor` int(11) NOT NULL,
  `nombre_autor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- Volcado de datos para la tabla `autores`
INSERT INTO `autores` (`id_autor`, `nombre_autor`) VALUES
(1, 'Bram Stoker'),
(2, 'Stephen King'),
(3, 'Mary Shelley'),
(4, 'Robert Ludlum'),
(5, 'Michael Crichton'),
(6, 'Tom Clancy'),
(7, 'Ursula K. Le Guin'),
(8, 'Jon Krakauer'),
(9, 'Robert Louis Stevenson'),
(10, 'James Clavells'),
(11, 'Gabriel García Márquez'),
(12, 'Madelline Miller'),
(13, 'Taylor Jenkins Reid'),
(14, 'Carlos Ruiz Zafón');
-- Estructura de tabla para la tabla `categorias`
CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- Volcado de datos para la tabla `categorias`
INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `descripcion`) VALUES
(1, 'Terror', 'Desde horror psicológico que juega con tu mente y lo sobrenatural que desafía la lógica, hasta el slasher más sangriento y visceral.'),
(2, 'Accion', 'Persecuciones imposibles, combates cuerpo a cuerpo, operaciones tácticas y héroes (o antihéroes) que se enfrentan a fuerzas abrumadoras.'),
(3, 'Aventura', 'Grandes odiseas en tierras lejanas, búsquedas de tesoros perdidos, viajes épicos de supervivencia y mundos fantásticos por explorar.'),
(4, 'Ficcion', 'Desde realismo mágico y dramas contemporáneos hasta epopeyas fantásticas y ucronías. Es el lugar donde conviven las historias que definen quiénes somos.');
-- Estructura de tabla para la tabla `libros`
CREATE TABLE `libros` (
  `id_libro` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `sinopsis` text DEFAULT NULL,
  `portada_url` varchar(255) DEFAULT NULL,
  `archivo_pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- Volcado de datos para la tabla `libros`
INSERT INTO `libros` (`id_libro`, `id_categoria`, `titulo`, `sinopsis`, `portada_url`, `archivo_pdf`) VALUES
(1, 1, 'Drácula', 'El joven abogado Jonathan Harker viaja a Transilvania para ayudar al conde Drácula a comprar una propiedad en Londres, sin imaginar que se encontrará con una criatura legendaria.', 'dracula.png', 'dracula.pdf'),
(2, 1, 'El Resplandor', 'Narra cómo Jack Torrance, un alcohólico en recuperación, acepta ser el cuidador invernal del aislado Hotel Overlook con su familia. El hotel, poseedor de una entidad maligna, corrompe a Jack, quien se vuelve violento, mientras su hijo Danny utiliza sus habilidades psíquicas para sobrevivir al acoso sobrenatural.', 'elresplandor3.png', 'elresplandor.pdf'),
(3, 1, 'Frankenstein', 'Narra la historia del científico Víctor Frankenstein, quien, obsesionado con vencer la muerte, crea vida a partir de cadáveres.', 'frankenstein.png', 'frankenstein.pdf'),
(4, 1, 'It', 'Narra la lucha del \"Club de los Perdedores\", siete niños marginados en Derry, Maine, contra una entidad polimórfica que despierta cada 27 años para alimentarse del miedo, a menudo personificada como el payaso Pennywise.', 'it.png', 'it.pdf'),
(5, 2, 'Area 81', 'Un niño y su hermano son perseguidos por una fuerza misteriosa y buscan la ayuda de un grupo de desconocidos en una vieja área de descanso abandonada.', 'area81.png', 'area81.pdf'),
(6, 2, 'El caso BOURNE', 'Narra la historia de Jason Bourne , un hombre con extraordinarias habilidades de supervivencia que sufre amnesia retrógrada y debe descubrir su verdadera identidad', 'big.png', 'big.pdf'),
(7, 2, 'CONGO', 'En lo profundo de la selva tropical africana, cerca de las legendarias ruinas de la Ciudad Perdida de Zinj, una expedición de ocho geólogos estadounidenses es asesinada misteriosa y brutalmente en cuestión de minutos.', 'congo.png', 'congo.pdf'),
(8, 2, 'Sin remordimientos', 'Sin remordimientos ofrece una historia que es dinamita pura. John Kelly vive una frenética odisea personal ambientada en el ojo del huracán del mundo actual: por un lado, inicia una implacable cruzada contra los narcotraficantes que han arruinado la vida de la mujer a la que ama.', 'sinremordimientos.png', 'sinremordimientos.pdf'),
(9, 3, 'El nombre del mundo es bosque', 'La trama cuenta la historia de una colonia militar que recolecta madera en el planeta ficticio de Athshe, instalada por personas de la Tierra (llamada «Terra»). Los colonos esclavizan a los nativos, completamente carentes de agresividad, y los tratan con dureza.', 'elnombredelmundo.png', 'elnombredelmundo.pdf'),
(10, 3, 'Hacia rutas salvajes', 'La llegada de un misterioso marino a la posada de su padre cambiará la vida del joven Jim Hawkins. El viejo confraternizará con él y, al morir repentinamente en la posada, Jim hallará entre sus cosas un mapa que revela la situación de un tesoro pirata enterrado en una isla remota.', 'haciarutassalvajes.png', 'haciarutassalvajes.pdf'),
(11, 3, 'La isla del tesoro', 'En lo profundo de la selva tropical africana, cerca de las legendarias ruinas de la Ciudad Perdida de Zinj, una expedición de ocho geólogos estadounidenses es asesinada misteriosa y brutalmente en cuestión de minutos.', 'isladeltesoro.png', 'isladeltesoro.pdf'),
(12, 3, 'SHOGUN', 'Shogun es una obra de ficción histórica basada en la lucha de poder entre los sucesores de Toyotomi Hideyoshi que condujo a la fundación del shogunato Tokugawa . Clavell basó cada personaje en una figura histórica, pero cambió sus nombres para añadir negación narrativa a la historia.', 'shogun.png', 'shogun.pdf'),
(13, 4, 'Cien años de soledad', 'Entre la boda de José Arcadio Buendía con Amelia Iguarán hasta la maldición de Aureliano Babilonia transcurre todo un siglo. Cien años de soledad para una estirpe única, fantástica, capaz de fundar una ciudad tan especial como Macondo y de engendrar niños con cola de cerdo.', 'cienanosdesoledad.png', 'cienanosdesoledad.pdf'),
(14, 4, 'CIRCE', 'Temeroso, Zeus la destierra a una isla desierta, donde Circe perfecciona sus oscuras artes, doma bestias salvajes y se va topando con númerosas figuras célebres de la mitología griega: desde el Minotauro hasta Dédalo y su desventurado hijo Ícaro, la asesina Medea y, por supuesto, el astuto Odiseo.', 'circe.png', 'circe.pdf'),
(15, 4, 'Los siete maridos', 'Evelyn Hugo, el icono de Hollywood que se ha recluido a su edad madura, por fin decide contar la verdad sobre su vida llena de glamour y de escándalos. Pero cuando para ello elige a Monique Grant, una periodista desconocida, nadie se sorprende más que la propia Monique. ¿Por que ella? ¿Por que ahora?', 'sietemaridos.png', 'sietemaridos.pdf'),
(16, 4, 'La sombra del viento', 'La trama se desenvuelve en una embrujada Barcelona donde, junto a su nuevo amigo Fermín, intentará descubrir la verdad que envuelve a un enigmático ser que a toda costa intenta enterrar el pasado de Julián Carax. Una novela de suspense que intenta mezclar lo real con la fantasía, el misterio con el amor.', 'sombradeviento.png', 'sombradeviento.pdf');
-- Estructura de tabla para la tabla `libros_autor`
CREATE TABLE `libros_autor` (
  `id_libro` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- Volcado de datos para la tabla `libros_autor`
INSERT INTO `libros_autor` (`id_libro`, `id_autor`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 2),
(5, 2),
(6, 4),
(7, 5),
(8, 6),
(9, 7),
(10, 8),
(11, 9),
(12, 10),
(13, 11),
(14, 12),
(15, 13),
(16, 14);
-- Estructura de tabla para la tabla `resenas`
CREATE TABLE `resenas` (
  `id_resena` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  `calificacion` int(11) NOT NULL CHECK (`calificacion` >= 1 and `calificacion` <= 5),
  `comentario` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- Estructura de tabla para la tabla `roles`
CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- Volcado de datos para la tabla `roles`
INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Usuario');
-- Estructura de tabla para la tabla `usuarios`
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(120) DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT 'assets/images/usuario.png',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `eliminado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- Índices para tablas volcadas
-- Indices de la tabla `autores`
ALTER TABLE `autores`
  ADD PRIMARY KEY (`id_autor`);
-- Indices de la tabla `categorias`
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);
-- Indices de la tabla `libros`
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id_libro`),
  ADD KEY `id_categoria` (`id_categoria`);
-- Indices de la tabla `libros_autor`
ALTER TABLE `libros_autor`
  ADD PRIMARY KEY (`id_libro`,`id_autor`),
  ADD KEY `id_autor` (`id_autor`);
-- Indices de la tabla `resenas`
ALTER TABLE `resenas`
  ADD PRIMARY KEY (`id_resena`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_libro` (`id_libro`);
-- Indices de la tabla `roles`
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);
-- Indices de la tabla `usuarios`
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `id_rol` (`id_rol`);
-- AUTO_INCREMENT de las tablas volcadas
-- AUTO_INCREMENT de la tabla `autores`
ALTER TABLE `autores`
  MODIFY `id_autor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
-- AUTO_INCREMENT de la tabla `categorias`
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
-- AUTO_INCREMENT de la tabla `libros`
ALTER TABLE `libros`
  MODIFY `id_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
-- AUTO_INCREMENT de la tabla `resenas`
ALTER TABLE `resenas`
  MODIFY `id_resena` int(11) NOT NULL AUTO_INCREMENT;
-- AUTO_INCREMENT de la tabla `roles`
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
-- AUTO_INCREMENT de la tabla `usuarios`
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;
-- Restricciones para tablas volcadas
-- Filtros para la tabla `libros`
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
-- Filtros para la tabla `libros_autor`
ALTER TABLE `libros_autor`
  ADD CONSTRAINT `libros_autor_ibfk_1` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id_libro`) ON DELETE CASCADE,
  ADD CONSTRAINT `libros_autor_ibfk_2` FOREIGN KEY (`id_autor`) REFERENCES `autores` (`id_autor`) ON DELETE CASCADE;
-- Filtros para la tabla `resenas`
ALTER TABLE `resenas`
  ADD CONSTRAINT `resenas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `resenas_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id_libro`) ON DELETE CASCADE;
-- Filtros para la tabla `usuarios`
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);
COMMIT;
