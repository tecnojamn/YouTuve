-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-06-2015 a las 00:16:26
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.6.8

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `channel`
--

INSERT INTO `channel` (`id`, `idUser`, `name`, `description`, `frontImgUrl`) VALUES
(8, 11, 'El canal de anonymus', '', ''),
(9, 12, 'El canal de Azaraza', '', '');

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
(1, 11, 15, 'Que buen videoo locoo', '2015-05-28 06:58:20'),
(2, 8, 15, 'Que es esta mierda?\n', '2015-05-28 06:58:52'),
(3, 11, 3, 'a', '2015-05-30 23:39:59');

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
(11, 9, 0, 0, '2015-05-28 06:12:42'),
(12, 8, 0, 0, '2015-05-27 06:46:59');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `playlist`
--

INSERT INTO `playlist` (`id`, `name`, `idUser`, `created_date`, `isWatchLater`) VALUES
(1, 'My Playlist 1', 11, '2015-05-06', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rate`
--

CREATE TABLE IF NOT EXISTS `rate` (
  `idUser` int(11) NOT NULL,
  `idVideo` int(11) NOT NULL,
  `rate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suggestion`
--

CREATE TABLE IF NOT EXISTS `suggestion` (
  `idUser` int(11) NOT NULL,
  `idUserToSuggest` int(11) NOT NULL,
  `idVideo` int(11) NOT NULL,
  `seen` tinyint(4) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `thumbUrl` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `nick`, `name`, `lastname`, `birthday`, `gender`, `thumbUrl`) VALUES
(8, 'armandito@gmail.com', '365d5b8a9bb4ccd7fe8e986626b6afc5', 'asdasdasd', 'asdasd', 'asdasd', '0000-00-00', '1', ''),
(9, 'aaaaaa', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'aaaaaa', 'aaaaaa', 'aaaaaa', '0000-00-00', '1', ''),
(11, 'nicocarnebia@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'anonymus', 'Junior', 'Bahiano', '1970-01-01', '0', 'anonymus/thumb.png'),
(12, 'arlequin1234@GeeMail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Azaraza', '123456esMyPass', 'SoyUnRaulito.com', '2015-05-07', '1', 'Azaraza/thumb.png');

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `video`
--

INSERT INTO `video` (`id`, `idChannel`, `name`, `link`, `date`, `durationInSeconds`, `active`) VALUES
(3, 8, 'Unjustice for jason', '6kqTcLwUYj8', '2015-05-24', 2000, 1),
(5, 8, 'Cliff em all', 'dmvFZpROrJQ', '2015-05-24', 123123, 1),
(14, 8, 'videos en peligro', 'n75iVg5meAA', '2015-05-24', 123, 1),
(15, 9, 'Who is Jhon NAsh', 'cFjy0e7_D8Y', '2015-05-27', 123, 1);

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
(14, 1),
(15, 1);

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
(14, 1),
(14, 2),
(15, 11);

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
(11, 3, '2015-06-01 00:00:00'),
(11, 3, '2015-06-01 00:15:55');

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
-- Indices de la tabla `suggestion`
--
ALTER TABLE `suggestion`
  ADD PRIMARY KEY (`idUser`,`idUserToSuggest`,`idVideo`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `playlist`
--
ALTER TABLE `playlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
