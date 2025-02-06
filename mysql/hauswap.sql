-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 04, 2023 at 08:17 PM
-- Server version: 8.0.32-0ubuntu0.20.04.2
-- PHP Version: 7.4.3-4ubuntu2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hauswap`
--

-- --------------------------------------------------------

--
-- Table structure for table `mensajes`
--

CREATE TABLE `mensajes` (
  `id_mensaje` int NOT NULL,
  `id_remitente` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_destinatario` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenido` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mensajes`
--

INSERT INTO `mensajes` (`id_mensaje`, `id_remitente`, `id_destinatario`, `contenido`, `fecha`) VALUES
(9, 'marina@ucm.es', 'luis@ucm.es', 'Hola! He visto que tienes una casa publicada y me gustaría reservarla. Qué fechas tienes disponibles?', '2023-05-01 14:10:12'),
(10, 'luis@ucm.es', 'marina@ucm.es', 'Pues mira lo siento en el alma pero tengo todo reservado hasta Septiembre.', '2023-05-01 14:18:29'),
(11, 'marina@ucm.es', 'luis@ucm.es', 'Vaya, una pena, otra vez será. Un saludo!!', '2023-05-01 14:21:29'),
(12, 'marina@ucm.es', 'lucia@ucm.es', 'Hola Lucía. ¿Qué tal todo? Espero que bien. Esto de que hayan metido un chat en HauSwap es una maravilla, ¿no te parece?', '2023-05-01 17:02:29'),
(13, 'lucia@ucm.es', 'marina@ucm.es', 'Qué tal Marina. Todo genial la verdad, estoy deseando pillar vacaciones para hacer algún intercambio, he visto casas muy chulas. Y sí, me encanta que ahora podamos hablar por aquí!', '2023-05-03 17:09:29'),
(14, 'juan@ucm.es', 'lucia@ucm.es', 'Hola Lucía! Te escribo porque estaba pensando en hacer un swap en Mayo. Tengo unos días libres y me encantaría ir a tu casa de Cádiz, las playas allí son geniales! 🌊🌊', '2023-05-02 09:11:29'),
(15, 'lucia@ucm.es', 'juan@ucm.es', 'Genial! La primera semana de mayo tengo vacaciones. Podría ir a tu piso de Milán? Nunca he estado en Italia y me encantaría ir... 🍕🍝😋😋', '2023-05-02 09:15:29'),
(16, 'juan@ucm.es', 'lucia@ucm.es', 'Claro, qué te parece que hagamos swap del 4 al 7?', '2023-05-02 09:21:22'),
(17, 'lucia@ucm.es', 'juan@ucm.es', 'Perfecto! Ahora mismo te mando la solicitud de Swap', '2023-05-02 09:35:39'),
(18, 'juan@ucm.es', 'lucia@ucm.es', 'Vale, acabo de aceptar la solicitud👍🏼✅', '2023-05-02 09:38:29'),
(24, 'luis@ucm.es', 'juan@ucm.es', 'Hola Juan!', '2023-05-04 20:10:41'),
(25, 'luis@ucm.es', 'juan@ucm.es', 'Te interesaría un intercambio? :)', '2023-05-04 20:10:56'),
(26, 'juan@ucm.es', 'luis@ucm.es', 'Claro!! Tu casa en Lisboa es preciosa', '2023-05-04 20:12:21');

-- --------------------------------------------------------

--
-- Table structure for table `propiedades`
--

CREATE TABLE `propiedades` (
  `id_casa` int NOT NULL,
  `id_usuario` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `localizacion` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_valoraciones` int NOT NULL,
  `servidor_fotos` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estrellas` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `propiedades`
--

INSERT INTO `propiedades` (`id_casa`, `id_usuario`, `nombre`, `localizacion`, `numero_valoraciones`, `servidor_fotos`, `descripcion`, `estrellas`) VALUES
(1, 'luis@ucm.es', 'Casa Lisboa', 'Lisboa, Portugal', 1, 'imagenes\\641310fb1ac95.jpeg', 'Esta hermosa casa en Lisboa es espaciosa y cuenta con una gran cantidad de luz natural que entra a través de sus grandes ventanales. Sus interiores tienen acabados elegantes y modernos, con pisos de madera noble y paredes blancas que crean una sensación de amplitud y frescura en todos los ambientes. La casa cuenta con una gran sala de estar con techos altos, perfecta para reuniones familiares y entre amigos, así como con una acogedora sala de estar con chimenea, ideal para disfrutar en las noches de invierno. Además, la casa cuenta con una amplia cocina totalmente equipada y moderna, que tiene acceso directo a un hermoso jardín privado. Los espacios exteriores de esta propiedad son verdaderamente impresionantes. Esta casa es la combinación perfecta de elegancia, confort y belleza. Prueba editar casa', 4),
(2, 'marina@ucm.es', 'Casa Berna', 'Berna, Suiza', 2, 'imagenes\\6412f9ebae9ca.jpg', 'Esta hermosa casa en Berna es una propiedad encantadora, ubicada en un entorno natural impresionante. La casa cuenta con un diseño arquitectónico tradicional, que evoca el encanto y la calidez de las casas alpinas. Los interiores son acogedores y confortables, con paredes de madera y detalles de decoración que crean un ambiente rústico y hogareño. La casa cuenta con una gran sala de estar con chimenea, perfecta para relajarse después de un día de esquí en las montañas cercanas. La cocina es amplia y totalmente equipada, con una gran mesa de comedor perfecta para reuniones familiares y entre amigos. La casa tiene varias habitaciones, todas ellas decoradas con buen gusto y equipadas con baños privados. Además, la propiedad cuenta con una amplia terraza, ideal para disfrutar del sol y las vistas panorámicas de los Alpes suizos. La casa está rodeada por un hermoso jardín privado, perfecto para jugar en la nieve o disfrutar de un delicioso chocolate caliente en un día de invierno. En definitiva, esta casa es la opción perfecta para aquellos que buscan una vida tranquila y acogedora', 5),
(3, 'juan@ucm.es', 'Piso Milán', 'Milán, Italia', 0, 'imagenes\\492336204.jpg', 'Este impresionante piso en Milán cuenta con una magnífica terraza con vistas panorámicas que te dejarán sin aliento. La terraza es espaciosa y ofrece un lugar ideal para relajarse y disfrutar del sol italiano. Desde aquí, se puede contemplar la vibrante ciudad de Milán, con sus impresionantes rascacielos y su arquitectura histórica, mientras se disfruta de una taza de café o una copa de vino.\r\n\r\nEl interior del piso es igualmente impresionante, con un diseño elegante y moderno que combina con el ambiente cosmopolita de la ciudad. Las grandes ventanas permiten la entrada de mucha luz natural, creando un ambiente luminoso y acogedor en todo el espacio habitable.\r\n\r\nEl piso cuenta con todas las comodidades modernas, incluyendo aire acondicionado, calefacción central y acceso a internet de alta velocidad. La cocina está completamente equipada, lo que la hace ideal para aquellos que disfrutan de cocinar en casa. El dormitorio es amplio y confortable, con una cama king size y un armario empotrado para el almacenamiento.\r\n\r\nEn resumen, este piso en Milán es una opción perfecta para aquellos que buscan una experiencia inolvidable en la ciudad. Con su impresionante terraza, vistas panorámicas y comodidades modernas, este piso es un verdadero oasis urbano en el corazón de Milán.', 5),
(4, 'lucia@ucm.es', 'Casa Cádiz', 'Cádiz, España', 0, 'imagenes\\1627031468.jpg', 'Esta impresionante casa en Cádiz es la escapada perfecta para aquellos que buscan relajarse en una de las playas más hermosas de España. Situada en primera línea de playa, la casa cuenta con una gran terraza con vistas panorámicas al mar Mediterráneo, donde podrás disfrutar del sol y de las vistas del mar mientras te relajas con tu bebida favorita.\r\n\r\nEl interior de la casa es igualmente impresionante, con una decoración moderna y elegante que combina perfectamente con el ambiente costero. La sala de estar es espaciosa y luminosa, con grandes ventanas que permiten la entrada de mucha luz natural y ofrecen vistas al mar. El salón cuenta con cómodos sofás y sillones, así como una televisión de pantalla plana para aquellos que quieran relajarse viendo una película.\r\n\r\nLa cocina está completamente equipada con todos los electrodomésticos modernos que necesitas para preparar comidas caseras deliciosas. También hay una mesa de comedor con capacidad para seis personas, perfecta para disfrutar de una cena en familia o con amigos.\r\n\r\nLa casa cuenta con tres dormitorios, todos ellos luminosos y cómodos, con camas amplias y armarios empotrados para el almacenamiento. Hay dos baños modernos, uno con bañera y otro con ducha.\r\n\r\nLa casa también cuenta con aire acondicionado y calefacción central, lo que la hace ideal para aquellos que quieran disfrutar de unas vacaciones en la playa durante todo el año. Además, su ubicación en primera línea de playa significa que tendrás acceso directo a la playa desde la casa.\r\n\r\nEn resumen, esta casa en Cádiz es una opción ideal para aquellos que buscan una escapada relajante en la playa. Con su gran terraza con vistas al mar, su decoración moderna y sus comodidades modernas, esta casa es el lugar perfecto para disfrutar del sol, la arena y el mar Mediterráneo.', 0),
(5, 'marina@ucm.es', 'Piso Salamanca', 'Salamanca, España', 2, 'imagenes\\38373562.jpg', 'Este encantador piso en Salamanca es el lugar perfecto para aquellos que buscan un hogar acogedor y confortable en una ciudad histórica y vibrante. El apartamento cuenta con una decoración cálida y acogedora, con tonos suaves y detalles decorativos cuidadosamente seleccionados para crear un ambiente hogareño.\r\n\r\nEl espacio habitable es cómodo y luminoso, con grandes ventanas que permiten la entrada de mucha luz natural. El salón cuenta con un cómodo sofá y una mesa de café, ideal para relajarse después de un largo día de explorar la ciudad. La cocina es pequeña pero completamente equipada, lo que la hace ideal para preparar comidas caseras.\r\n\r\nEl piso tiene un dormitorio amplio y tranquilo, con una cama cómoda y armarios empotrados para el almacenamiento. El baño es moderno y limpio, con una ducha y todos los accesorios necesarios.\r\n\r\nEste piso también cuenta con calefacción central y acceso a internet de alta velocidad, lo que lo hace ideal para aquellos que necesitan trabajar o estudiar desde casa. Además, su ubicación en el centro de Salamanca lo hace ideal para aquellos que quieren estar cerca de los lugares más importantes de la ciudad, como la Plaza Mayor y la famosa universidad.\r\n\r\nEn resumen, este piso en Salamanca es una opción ideal para aquellos que buscan un hogar acogedor y confortable en una ciudad histórica y vibrante. Con su decoración cálida y cuidada, su ubicación privilegiada y sus comodidades modernas, este piso es un lugar perfecto para disfrutar de la vida en una de las ciudades más hermosas de España.', 3);

-- --------------------------------------------------------

--
-- Table structure for table `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int NOT NULL,
  `id_casa1` int NOT NULL,
  `id_casa2` int NOT NULL,
  `fecha_entrada` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `estado` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `id_casa1`, `id_casa2`, `fecha_entrada`, `fecha_salida`, `estado`) VALUES
(1679003164, 1, 5, '2023-03-14', '2023-03-20', 'COMPLETADA'),
(1679003179, 1, 2, '2023-03-22', '2023-03-26', 'COMPLETADA'),
(1679003212, 2, 1, '2023-03-01', '2023-03-04', 'COMPLETADA'),
(1679003410, 5, 3, '2023-03-29', '2023-04-01', 'COMPLETADA'),
(1681065763, 3, 1, '2023-04-10', '2023-04-15', 'COMPLETADA'),
(1681146331, 2, 4, '2023-05-09', '2023-05-13', 'PENDIENTE'),
(1681149321, 1, 3, '2023-07-11', '2023-07-09', 'PENDIENTE'),
(1681286612, 3, 1, '2023-04-24', '2023-04-26', 'COMPLETADA'),
(1682356331, 3, 4, '2023-05-04', '2023-05-07', 'ACEPTADA');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `rol` int NOT NULL,
  `nombre` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`rol`, `nombre`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `correo` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contraseña` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` int NOT NULL,
  `sexo` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `pais` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date NOT NULL,
  `servidor_fotoperfil` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biografia` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`correo`, `nombre`, `contraseña`, `telefono`, `sexo`, `fecha_nacimiento`, `pais`, `fecha_registro`, `servidor_fotoperfil`, `biografia`, `tipo`) VALUES
('admin@admin.es', 'Admin', '$2y$10$P/fjjOxUu7f0I3gCIShVp.mUX3HPaTV2BzmsTR2kprtBhaCpcMiwm', 0, 'Prefiero no contestar', '0000-00-00', 'España', '2023-03-14', './imagenes/perfil_admin.png', '', 1),
('juan@ucm.es', 'Juan', '$2y$10$bAknaeOLnh./Vv0OoE.pheJpeHpj4ZOsWztKyuSx2AYiz9n1l.5Wy', 866425116, 'Hombre', '1980-02-10', 'Italia', '2023-04-04', './imagenes/perfil1.png', 'Mi nombre es Juan y nací en la ciudad de Nápoles en 1985. Desde pequeño, siempre he sido una persona muy curiosa y apasionada por la tecnología. En el colegio, me interesé especialmente por las ciencias y las matemáticas, y siempre disfruté aprendiendo todo lo que pudiera sobre ellas.  Después de graduarme de la escuela secundaria, decidí estudiar Ingeniería en Sistemas en la universidad. Durante mis estudios universitarios, me involucré en varios proyectos de programación y desarrollo de software, lo que me permitió adquirir una gran experiencia en el campo de la tecnología.  Después de graduarme de la universidad, trabajé en varias empresas de tecnología, donde pude aplicar mis conocimientos en programación y desarrollo de software en proyectos emocionantes y desafiantes. También he tenido la oportunidad de trabajar con un equipo de expertos en tecnología y aprender de ellos.  En mi tiempo libre, me gusta practicar deportes al aire libre y también disfruto de la música y el cine. Soy un apasionado de la tecnología y siempre estoy buscando nuevas formas de aplicarla en diferentes áreas de la vida.  Actualmente, me encuentro trabajando en una empresa de desarrollo de software, donde me desempeño como ingeniero de software. Me siento muy agradecido por las oportunidades que he tenido en mi carrera y estoy emocionado por lo que depara el futuro en este apasionante campo de la tecnología.', 2),
('lucia@ucm.es', 'Lucía', '$2y$10$XQTM6Iu6BQ4xg7Or3r5lv.oj3oNJKAM06Y0wqFmw5t7UzDzlafWQG', 672118277, 'No binario', '1997-07-23', 'España', '2023-04-04', './imagenes/perfil2.png', '¡Hola! Mi nombre es Lucía y nací en una pequeña ciudad en el centro de España. Desde muy joven, siempre he tenido una gran pasión por el arte y la creatividad. Me encantaba pasar horas dibujando y experimentando con diferentes formas de expresión artística.  Después de graduarme de la escuela secundaria, decidí estudiar Diseño Gráfico en la universidad. Fue una experiencia increíble, aprendí mucho y me permitió desarrollar aún más mi creatividad y habilidades artísticas. Durante mi carrera, tuve la oportunidad de trabajar en varios proyectos emocionantes y desafiantes, y eso me ayudó a descubrir mi verdadera pasión: el diseño de interiores.  Después de graduarme, decidí perseguir mi sueño de convertirme en diseñadora de interiores y comencé a trabajar en una pequeña empresa de diseño. Fue una experiencia increíble, aprendí mucho y tuve la oportunidad de trabajar en algunos proyectos emocionantes y desafiantes. Después de unos años, decidí comenzar mi propio negocio de diseño de interiores y ha sido una experiencia increíble hasta ahora.  Me encanta trabajar en estrecha colaboración con mis clientes y ayudarles a crear espacios que reflejen su personalidad y estilo de vida únicos. Desde pequeñas renovaciones hasta proyectos completos de diseño de interiores, siempre estoy emocionada de tomar un nuevo desafío. En mi tiempo libre, me gusta leer, viajar y pasar tiempo al aire libre con mi familia y amigos.', 2),
('luis@ucm.es', 'Luis', '$2y$10$/cmfNMj7VzROPNx6RTxmWuLveu1khyiL6z1PwYPv41ytdcW9KMOZu', 601422389, 'Hombre', '2001-11-06', 'Portugal', '2023-03-16', './imagenes/perfil5.png', 'Hola, soy Luis y nací en Oporto, Portugal, en 1985, y desde joven mostré una gran pasión por la música. Comencé a tocar la guitarra y el piano a la edad de 8 años, y a medida que crecía, mi amor por la música se intensificaba. Decidí que quería dedicar mi vida a ella.\r\n\r\nDespués de graduarme de la escuela secundaria, asistí al Conservatorio de Música de Madrid, donde me especialicé en guitarra clásica. Durante mi tiempo en el conservatorio, fui muy activo en la escena musical local, tocando en numerosos conciertos y festivales de música.\r\n\r\nDespués de graduarme del conservatorio, decidí ampliar mis horizontes y viajé a América del Sur, donde me sumergí en la rica cultura musical de la región. Allí, aprendí a tocar una variedad de instrumentos tradicionales sudamericanos y me inspiré para crear mi propio estilo único de música.\r\n\r\nA mi regreso a Portugal, comencé a tocar en conciertos y eventos en toda la región, ganando rápidamente una base de fans leales. En poco tiempo, comencé a producir y grabar mi propia música, y mi álbum debut fue un éxito instantáneo.\r\n\r\nHoy en día, soy un músico muy respetado y reconocido en la escena musical española y he actuado en todo el mundo. He grabado varios álbumes aclamados por la crítica y he ganado numerosos premios por mi música. Además de mi carrera musical, soy un defensor apasionado de la educación musical y trabajo con jóvenes músicos en todo el país para ayudar a inspirar la próxima generación de artistas.', 2),
('marina@ucm.es', 'Marina', '$2y$10$aA7.CMma209L7v9W2EY2B.7m7dc6ymI6Sl42NBxvSlDj3www4pTWG', 677854331, 'Mujer', '2002-03-26', 'España', '2023-03-16', './imagenes/perfil6.png', 'Hola, mi nombre es Marina y nací en una pequeña ciudad costera en el norte de España. Siempre he sido muy curiosa y apasionada por aprender cosas nuevas, lo que me llevó a estudiar en la universidad una carrera relacionada con la comunicación y el marketing.  Después de terminar mis estudios, empecé a trabajar en una agencia de publicidad, donde tuve la oportunidad de desarrollar mis habilidades y aprender mucho sobre el mundo de la publicidad y el marketing digital. Sin embargo, después de unos años trabajando en el sector, sentí que necesitaba un cambio y decidí emprender mi propio negocio.  Así fue como fundé mi propia agencia de marketing digital, enfocada en ayudar a pequeñas empresas y emprendedores a crear y gestionar su presencia en línea. Desde entonces, he trabajado con muchos clientes y he tenido la oportunidad de ayudar a muchos negocios a crecer y expandirse.  Pero mi trabajo no lo es todo en mi vida. Me encanta viajar y explorar nuevos lugares, y siempre intento aprovechar cualquier oportunidad para hacerlo. También disfruto de la lectura, el cine y la música, y trato de hacer tiempo para mis hobbies siempre que puedo.  En resumen, mi vida es una mezcla de trabajo, aprendizaje constante, aventuras y momentos de tranquilidad y disfrute personal. Espero seguir aprendiendo y creciendo en todos los aspectos de mi vida, y seguir contribuyendo al éxito de mi negocio y al de mis clientes.', 2),
('roberto@ucm.es', 'Roberto', '$2y$10$CRX1cTxYlo2gaZ7tpNpL/.w/itdz/t97GQPRk//sil6WjddpsiT1y', 610474088, 'Hombre', '1998-03-19', 'España', '2023-04-23', './imagenes/perfil4.png', '¡Hola! Me llamo Roberto y soy un agente inmobiliario con más de 10 años de experiencia en el mercado de bienes raíces. Nací en España, en una pequeña ciudad de la región de Andalucía.\r\n\r\nDesde muy joven, me interesé por el mundo de los bienes raíces. Durante mi adolescencia, acompañaba a mi padre en sus negocios inmobiliarios y aprendí mucho de él. A los 18 años, decidí estudiar una carrera en Administración y Dirección de Empresas para poder especializarme en el sector.\r\n\r\nUna vez finalizados mis estudios, empecé a trabajar en una agencia inmobiliaria en mi ciudad natal. Allí aprendí todo lo necesario sobre la gestión de propiedades, la evaluación de precios y las negociaciones con clientes y propietarios.\r\n\r\nDespués de varios años de trabajo en la misma agencia, decidí dar un paso más en mi carrera y comencé a alquilar propiedades. ¡Estoy deseando de ver qué me puede ofrecer Hauswap!', 2);

-- --------------------------------------------------------

--
-- Table structure for table `valoraciones`
--

CREATE TABLE `valoraciones` (
  `id_valoracion` int NOT NULL,
  `id_casa` int NOT NULL,
  `id_reserva` int NOT NULL,
  `id_usuario` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estrellas` int NOT NULL,
  `opinion` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `valoraciones`
--

INSERT INTO `valoraciones` (`id_valoracion`, `id_casa`, `id_reserva`, `id_usuario`, `estrellas`, `opinion`, `fecha`) VALUES
(1, 3, 1679003164, 'lucia@ucm.es', 5, 'Experiencia inmejorable', '2023-04-27'),
(1683223115, 1, 1679003212, 'marina@ucm.es', 4, 'Una casa preciosa, muy recomendable', '2023-05-04'),
(1683223217, 1, 1681065763, 'juan@ucm.es', 3, 'Amplia y con mucha luz, muy bonita', '2023-05-04'),
(1683223291, 2, 1679003179, 'luis@ucm.es', 5, 'Impresionante!!! Vuelvo seguro', '2023-05-04'),
(1683223537, 5, 1679003164, 'luis@ucm.es', 3, 'Acogedor y cálido!', '2023-05-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `id_remitente` (`id_remitente`),
  ADD KEY `id_receptor` (`id_destinatario`);

--
-- Indexes for table `propiedades`
--
ALTER TABLE `propiedades`
  ADD PRIMARY KEY (`id_casa`),
  ADD KEY `usuario` (`id_usuario`);

--
-- Indexes for table `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `id_casa1` (`id_casa1`),
  ADD KEY `id_casa2` (`id_casa2`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`rol`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`correo`),
  ADD KEY `rol` (`tipo`);

--
-- Indexes for table `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD PRIMARY KEY (`id_valoracion`),
  ADD KEY `id_casa` (`id_casa`),
  ADD KEY `id_reserva` (`id_reserva`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id_mensaje` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `id_destinatario` FOREIGN KEY (`id_destinatario`) REFERENCES `usuarios` (`correo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_remitente` FOREIGN KEY (`id_remitente`) REFERENCES `usuarios` (`correo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `propiedades`
--
ALTER TABLE `propiedades`
  ADD CONSTRAINT `usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`correo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `id_casa1` FOREIGN KEY (`id_casa1`) REFERENCES `propiedades` (`id_casa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_casa2` FOREIGN KEY (`id_casa2`) REFERENCES `propiedades` (`id_casa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `rol` FOREIGN KEY (`tipo`) REFERENCES `roles` (`rol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD CONSTRAINT `id_casa` FOREIGN KEY (`id_casa`) REFERENCES `propiedades` (`id_casa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_reserva` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`correo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;