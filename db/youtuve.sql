-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-06-2015 a las 01:08:03
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `youtuve`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `channel`
--

CREATE TABLE IF NOT EXISTS `channel` (
`id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(500) NOT NULL,
  `frontImgUrl` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `channel`
--

INSERT INTO `channel` (`id`, `idUser`, `name`, `description`, `frontImgUrl`) VALUES
(1, 1, 'El canal de julio', 'tengo poca imaginacion', ''),
(2, 2, 'El canal de julitoo', 'prueba', ''),
(3, 5, 'El canal de pepino', 'descripcion gral', ''),
(4, 7, 'OrdureBizarre', 'Nada raro por aca', ''),
(5, 8, 'VamoLosPibe', 'EL canal de los nierys', ''),
(6, 9, 'SosaSensualYaTuSabe', 'Un canal op', ''),
(7, 10, 'DondeEstaWally', 'Like si no me encontraste', ''),
(8, 11, 'ElMejorCanalPAPA', 'asdasdas asdasd asdasdasd asda asdasdasd asdasdasd    by chewaka', ''),
(9, 13, 'EsteeeeeeBanQuito', 'AAAAAAAAAA no.', ''),
(10, 14, 'LALALA', 'canal de musica', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
`id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idVideo` int(11) NOT NULL,
  `comment` varchar(150) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comment`
--

INSERT INTO `comment` (`id`, `idUser`, `idVideo`, `comment`, `date`) VALUES
(1, 2, 20, 'hola que tal', '2015-06-18 01:05:25'),
(2, 1, 20, 'muy bueno el video', '2015-06-18 01:05:57'),
(3, 7, 20, 'sabelo papa, el propio video', '2015-06-18 01:06:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `follower`
--

CREATE TABLE IF NOT EXISTS `follower` (
  `idUser` int(11) NOT NULL,
  `IdChannel` int(11) NOT NULL,
  `seen` tinyint(4) NOT NULL DEFAULT '0',
  `confirmed` tinyint(4) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `follower`
--

INSERT INTO `follower` (`idUser`, `IdChannel`, `seen`, `confirmed`, `date`) VALUES
(1, 2, 0, 0, '2015-06-14 22:30:48'),
(2, 3, 0, 0, '2015-06-14 23:21:39'),
(5, 2, 0, 0, '2015-06-14 20:57:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playlist`
--

CREATE TABLE IF NOT EXISTS `playlist` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `idUser` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `isWatchLater` tinyint(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `playlist`
--

INSERT INTO `playlist` (`id`, `name`, `idUser`, `created_date`, `isWatchLater`) VALUES
(1, 'play1', 1, '0000-00-00', 0),
(2, 'playlist', 2, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rate`
--

CREATE TABLE IF NOT EXISTS `rate` (
  `idUser` int(11) NOT NULL,
  `idVideo` int(11) NOT NULL,
  `rate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rate`
--

INSERT INTO `rate` (`idUser`, `idVideo`, `rate`) VALUES
(1, 2, 4),
(1, 3, 5),
(2, 2, 2),
(2, 3, 3),
(2, 4, 4),
(2, 5, 2),
(2, 6, 2),
(2, 7, 1),
(5, 8, 5),
(5, 9, 4),
(5, 10, 3),
(5, 11, 2),
(5, 12, 1),
(7, 12, 5),
(7, 13, 4),
(7, 14, 3),
(7, 15, 2),
(7, 16, 1),
(8, 16, 5),
(8, 17, 4),
(8, 18, 3),
(8, 19, 2),
(8, 20, 1),
(9, 2, 5),
(9, 3, 4),
(9, 4, 3),
(9, 5, 2),
(9, 6, 1),
(10, 1, 5),
(10, 2, 4),
(10, 3, 3),
(10, 4, 2),
(11, 1, 5),
(11, 4, 4),
(11, 7, 3),
(11, 11, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tag`
--

INSERT INTO `tag` (`id`, `name`) VALUES
(1, 'Pelicula'),
(2, 'Musica'),
(3, 'Serie'),
(4, 'Dibujos Animados'),
(5, 'Documental'),
(6, 'Reality'),
(7, 'Adultos'),
(8, 'Noticias'),
(9, 'Cortos'),
(10, 'Anime'),
(11, 'Deportes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `nick` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `birthday` date NOT NULL,
  `gender` char(1) NOT NULL,
  `thumbUrl` varchar(100) NOT NULL,
  `confirm_token` varchar(255) NOT NULL,
  `active` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `nick`, `name`, `lastname`, `birthday`, `gender`, `thumbUrl`, `confirm_token`, `active`) VALUES
(1, 'julio@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'julio', 'julio', 'gra', '2015-06-10', '0', 'julio/thumb.png', 'rJr57nua7JXR2vdDXU4t', 1),
(2, 'julito.gg@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'julitoo', 'julio', 'gra', '2015-06-17', '0', '', 'tGTRG1wJbFiy3P3kUd9v', 1),
(5, 'user1@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'pepino', 'elvis', 'crespo', '2015-05-05', '0', '', '6cjvjAsc4GbHj3clwNIZ', 1),
(7, 'nico.carnebia@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'nico', 'nicolas', 'carnebia', '2015-06-02', '0', '', 'potndxnmsad3468dahsd', 1),
(8, 'andrespenaluna@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'andyDelCap', 'andres', 'penia', '2015-06-08', '0', '', 'ñlasoderekjh5656', 1),
(9, 'maxisamuelsosa@hotmail.es', '81dc9bdb52d04dc20036dbd8313ed055', 'SoVoSosa', 'maximiliano', 'sosa', '2015-06-25', '0', '', '25gbndfkfd76540endst23', 1),
(10, 'dondeestawally@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'wally', 'wally', 'unknow', '2015-06-18', '0', '', 'asdkl5678yw3nmjb324yhg145ad', 1),
(11, 'anotherUser@hotmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'LaYaron', 'Yaron', 'Carter', '2015-06-03', '1', '', '89234bjmdfyh23467234bdfs', 1),
(13, 'este@outlock.com', '81dc9bdb52d04dc20036dbd8313ed055', 'estabanSito', 'estaban', 'quito', '2015-06-08', '0', '', '45897asdjbhasd7843jbasd', 1),
(14, 'susanahoria@adinet.com', '81dc9bdb52d04dc20036dbd8313ed055', 'susanaHoria', 'susana', 'horia', '2015-06-10', '1', '', '7845nsdty3490dsfjk2345re', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `video`
--

CREATE TABLE IF NOT EXISTS `video` (
`id` int(11) NOT NULL,
  `idChannel` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `link` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `durationInSeconds` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `video`
--

INSERT INTO `video` (`id`, `idChannel`, `name`, `link`, `date`, `durationInSeconds`, `active`) VALUES
(1, 1, 'No te va a gustar - Pensar', 'Q8nhp1o4SmA', '2015-06-10', 200, 1),
(2, 1, 'linking park - numb', 'kXYiU_JCYtU', '2015-06-10', 187, 1),
(3, 2, 'simple plan - jet lag', 'ntSBKPkk4m4', '2015-06-11', 219, 1),
(4, 3, 'simple plan - the worst day ev', 'e8RzY5X6xp4', '2015-06-14', 210, 1),
(5, 1, 'Fall Out Boy - Sophomore Slump', 'UQKnjDpmlio', '2015-06-01', 250, 1),
(6, 1, 'Fall Out Boy - Thnks fr th Mmr', 'onzL0EM1pKY', '2015-06-05', 320, 1),
(7, 1, 'No Te Va Gustar: "No Hay Dolor', 'Ay-bbHqlst0', '2015-06-09', 210, 1),
(8, 1, 'No Te Va Gustar - Ese Maldito ', 'NvB0sFK1sjY', '2015-06-02', 280, 1),
(9, 2, '¿CUÁNTO GANAN MESSI Y CRISTIAN', '7_BjEQkGy2c', '2015-06-01', 210, 1),
(10, 2, '10 PERSONAJES EN QUE NOS CONVE', 'tUyHza4ToW0', '2015-06-08', 150, 1),
(11, 2, '14 FAMOSOS TAN OPERADOS QUE SO', '4FSBmOPUuqs', '2015-06-03', 120, 1),
(12, 2, 'COSAS DE LOS 90''s', 'lQxMTWT7Ejs', '2015-06-02', 140, 1),
(13, 3, 'Let''s Draw Minion/Despicable M', 'uJASvqQ_rok', '2015-06-08', 150, 1),
(14, 3, 'How I Draw Anna/Frozen/Disney', 'zAjWcKDJThE', '2015-06-01', 200, 1),
(15, 3, 'How I Draw Splatoon / TwitchTv', 'u73wCwk-jvg', '2015-06-23', 185, 1),
(16, 3, 'How I Draw Dancing Groot / Gua', '5_iHT5y5iqc', '2015-06-09', 123, 1),
(17, 4, 'Incredible Spinning Illusion!', '3atqYbHFG4k', '2015-06-09', 250, 1),
(18, 4, 'Amazing Animated Optical Illus', 'UW5bcsax78I', '2015-06-03', 123, 1),
(19, 4, 'Amazing Magnetic Levitation De', '1gMMM62NC-4', '2015-06-23', 123, 1),
(20, 4, 'razy Circle Illusion!', 'pNe6fsaCVtI', '2015-06-24', 123, 1),
(21, 4, 'Nyan Windows 98 VS XP', 'FFRYAyx5tqU', '2015-06-09', 200, 1),
(22, 4, 'Windows Error Remix 2014', '37e4GZDuwBE', '2015-06-02', 421, 1),
(23, 5, 'Zelda Twilight Princess: Midna', 'OyTCyz0p3sM', '2015-06-22', 198, 1),
(24, 5, 'The Rains of Castamere - A Lan', 'WSJk7G4cWEU', '2015-06-01', 120, 1),
(25, 5, 'Brothers (Fullmetal Alchemist)', 'DsAa0KzaJSg', '2015-06-12', 215, 1),
(26, 5, 'Dr. Wily''s Castle (Mega Man 2)', 'hRmQ6WlIjlY', '2015-06-09', 176, 1),
(27, 6, '34.- Curso Ruby on Rails 4 des', 'XVUyBy5yexc', '2015-06-23', 324, 1),
(28, 6, '40.- Programación Android - Ex', 'J4xGXzNNgCY', '2015-06-16', 453, 1),
(29, 6, 'Cinemática de League of Legend', 'KbOQQNwj1-I', '2015-06-01', 321, 1),
(32, 6, 'A Twist of Fate', 'tEnsqpThaFg', '2015-06-02', 231, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videoplaylist`
--

CREATE TABLE IF NOT EXISTS `videoplaylist` (
  `idVideo` int(11) NOT NULL,
  `idPlaylist` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `videoplaylist`
--

INSERT INTO `videoplaylist` (`idVideo`, `idPlaylist`) VALUES
(3, 2),
(4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videotag`
--

CREATE TABLE IF NOT EXISTS `videotag` (
  `idVideo` int(11) NOT NULL,
  `idTag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `videotag`
--

INSERT INTO `videotag` (`idVideo`, `idTag`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viewhistory`
--

CREATE TABLE IF NOT EXISTS `viewhistory` (
  `idUser` int(11) NOT NULL,
  `idVideo` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `viewhistory`
--

INSERT INTO `viewhistory` (`idUser`, `idVideo`, `date`) VALUES
(1, 1, '2015-06-14 22:41:56'),
(1, 2, '2015-06-11 00:12:55'),
(1, 3, '2015-06-14 22:17:55'),
(1, 3, '2015-06-14 22:50:21'),
(1, 4, '2015-06-14 22:18:54'),
(1, 4, '2015-06-14 23:15:49'),
(1, 20, '2015-06-18 01:05:47'),
(2, 1, '2015-06-11 00:10:53'),
(2, 1, '2015-06-14 21:20:40'),
(2, 2, '2015-06-11 00:10:59'),
(2, 2, '2015-06-14 23:18:21'),
(2, 3, '2015-06-14 23:18:38'),
(2, 4, '2015-06-14 23:21:33'),
(2, 15, '2015-06-14 23:59:50'),
(2, 16, '2015-06-15 00:01:30'),
(2, 19, '2015-06-16 00:07:37'),
(2, 19, '2015-06-17 22:01:40'),
(2, 20, '2015-06-17 22:07:46'),
(2, 20, '2015-06-17 22:35:59'),
(2, 20, '2015-06-18 01:05:07'),
(2, 34, '2015-06-16 00:27:32'),
(2, 35, '2015-06-16 00:27:30'),
(5, 3, '2015-06-14 20:57:27'),
(5, 4, '2015-06-14 20:57:02'),
(7, 9, '2015-06-18 01:06:55'),
(7, 20, '2015-06-18 01:06:22');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `channel`
--
ALTER TABLE `channel`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `idUser` (`idUser`);

--
-- Indices de la tabla `comment`
--
ALTER TABLE `comment`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `follower`
--
ALTER TABLE `follower`
 ADD PRIMARY KEY (`idUser`,`IdChannel`);

--
-- Indices de la tabla `playlist`
--
ALTER TABLE `playlist`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rate`
--
ALTER TABLE `rate`
 ADD PRIMARY KEY (`idUser`,`idVideo`);

--
-- Indices de la tabla `tag`
--
ALTER TABLE `tag`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `video`
--
ALTER TABLE `video`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_user` (`idChannel`);

--
-- Indices de la tabla `videoplaylist`
--
ALTER TABLE `videoplaylist`
 ADD PRIMARY KEY (`idVideo`,`idPlaylist`);

--
-- Indices de la tabla `videotag`
--
ALTER TABLE `videotag`
 ADD PRIMARY KEY (`idVideo`,`idTag`);

--
-- Indices de la tabla `viewhistory`
--
ALTER TABLE `viewhistory`
 ADD PRIMARY KEY (`idUser`,`idVideo`,`date`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `channel`
--
ALTER TABLE `channel`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `comment`
--
ALTER TABLE `comment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `playlist`
--
ALTER TABLE `playlist`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tag`
--
ALTER TABLE `tag`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `video`
--
ALTER TABLE `video`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
