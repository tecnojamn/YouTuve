-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 14-05-2015 a las 11:27:27
-- Versión del servidor: 5.5.41
-- Versión de PHP: 5.3.10-1ubuntu3.16

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(500) NOT NULL,
  `frontImgUrl` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `idVideo` int(11) NOT NULL,
  `comment` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `follower`
--

CREATE TABLE IF NOT EXISTS `follower` (
  `idUser` int(11) NOT NULL,
  `IdChannel` int(11) NOT NULL,
  `seen` tinyint(4) NOT NULL DEFAULT '0',
  `confirmed` tinyint(4) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  PRIMARY KEY (`idUser`,`IdChannel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playlist`
--

CREATE TABLE IF NOT EXISTS `playlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rate`
--

CREATE TABLE IF NOT EXISTS `rate` (
  `idUser` int(11) NOT NULL,
  `idVideo` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  PRIMARY KEY (`idUser`,`idVideo`)
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
  `date` datetime NOT NULL,
  PRIMARY KEY (`idUser`,`idUserToSuggest`,`idVideo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `name` int(30) NOT NULL,
  `lastname` int(30) NOT NULL,
  `birthday` date NOT NULL,
  `gender` char(1) NOT NULL,
  `thumbUrl` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idChannel` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `link` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `durationInSeconds` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user` (`idChannel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videoplaylist`
--

CREATE TABLE IF NOT EXISTS `videoplaylist` (
  `idVideo` int(11) NOT NULL,
  `idPlaylist` int(11) NOT NULL,
  `isWatchLater` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idVideo`,`idPlaylist`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videotag`
--

CREATE TABLE IF NOT EXISTS `videotag` (
  `idVideo` int(11) NOT NULL,
  `idTag` int(11) NOT NULL,
  PRIMARY KEY (`idVideo`,`idTag`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viewhistory`
--

CREATE TABLE IF NOT EXISTS `viewhistory` (
  `idUser` int(11) NOT NULL,
  `idVideo` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`idUser`,`idVideo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
