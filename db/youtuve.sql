-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-09-2015 a las 18:23:33
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
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `last_log` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `last_log`) VALUES
(1, 'admin', 'admin', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `channel`
--

CREATE TABLE IF NOT EXISTS `channel` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(500) NOT NULL,
  `frontImgUrl` varchar(100) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `channel`
--

INSERT INTO `channel` (`id`, `idUser`, `name`, `description`, `frontImgUrl`, `active`) VALUES
(1, 8, 'El canal de Peter', '', '', 1),
(2, 11, 'El canal de asdasd', '', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idVideo` int(11) NOT NULL,
  `comment` varchar(150) NOT NULL,
  `date` datetime NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comment`
--

INSERT INTO `comment` (`id`, `idUser`, `idVideo`, `comment`, `date`, `active`) VALUES
(1, 11, 1, 'asd', '2015-07-14 05:17:52', 1);

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
(11, 1, 0, 0, '2015-07-14 05:17:38');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `playlist`
--

INSERT INTO `playlist` (`id`, `name`, `idUser`, `created_date`, `isWatchLater`) VALUES
(2, 'sad', 8, '0000-00-00', 0),
(3, 'penis', 8, '0000-00-00', 0),
(4, '2', 11, '0000-00-00', 0),
(5, 'Hola master', 11, '0000-00-00', 0);

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
(8, 1, 3),
(11, 1, 1);

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
  `thumbUrl` varchar(100) NOT NULL,
  `confirm_token` varchar(255) NOT NULL,
  `active` tinyint(2) NOT NULL DEFAULT '0',
  `banned_until` date DEFAULT '0000-00-00'
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `nick`, `name`, `lastname`, `birthday`, `gender`, `thumbUrl`, `confirm_token`, `active`, `banned_until`) VALUES
(8, 'nicocarnebia2@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'Peter', '123123', '123123', '2015-06-02', '0', 'Peter/thumb.png', '', 1, '0000-00-00'),
(10, 'nicocarnebi1a@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'asdasdsd', 'sdasd', 'asdasd', '1970-01-01', '0', '', '', 1, '0000-00-00'),
(11, 'nicocarnebia@gmail.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'asdasd', 'asd', 'asd', '2014-12-12', '0', 'asdasd/thumb.png', '', 1, '0000-00-00');

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `video`
--

INSERT INTO `video` (`id`, `idChannel`, `name`, `link`, `date`, `durationInSeconds`, `active`) VALUES
(1, 1, 'Mister choto', 'xe1LrMqURuw', '2015-06-11', 123, 1),
(2, 2, 'gdfgdfg', 'dfgdfg', '2015-07-14', 0, 1),
(3, 2, 'asd', 'asd', '2015-07-14', 12, 1),
(4, 2, 'asd', 'asd', '2015-07-14', 2, 1),
(5, 2, 'asd', 'asd', '2015-07-14', 12, 1),
(6, 2, 'asd', 'asd', '2015-07-14', 2, 1),
(7, 2, 'asd', '2323', '2015-07-14', 212, 1),
(8, 2, 'asd', 'asd', '2015-07-14', 2, 1),
(9, 2, 'asd', 'asd', '2015-07-14', 2, 1),
(10, 2, 'asd', 'asd', '2015-07-14', 2, 1),
(11, 2, 'AAAAAAAAAA', '2323', '2015-07-14', 2, 1),
(12, 2, 'asd', 'asd', '2015-07-14', 21, 1);

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
(1, 2),
(1, 3),
(1, 5),
(7, 4),
(11, 5);

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
(1, 1),
(1, 2),
(1, 7),
(2, 2),
(4, 2),
(7, 5),
(8, 2),
(9, 2),
(10, 4),
(11, 8),
(12, 4);

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
(8, 1, '2015-06-11 01:58:21'),
(8, 1, '2015-06-13 17:51:28'),
(8, 1, '2015-06-13 19:11:16'),
(8, 1, '2015-06-13 20:23:26'),
(8, 1, '2015-06-28 03:13:37'),
(11, 1, '2015-07-14 05:17:32'),
(11, 2, '2015-07-14 04:59:16'),
(11, 3, '2015-07-14 05:09:07'),
(11, 7, '2015-07-14 05:03:18'),
(11, 7, '2015-07-14 06:00:20'),
(11, 10, '2015-07-14 05:17:14'),
(11, 11, '2015-07-14 05:20:05');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `playlist`
--
ALTER TABLE `playlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
