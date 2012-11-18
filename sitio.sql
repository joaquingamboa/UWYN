-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2012 a las 23:24:12
-- Versión del servidor: 5.5.27
-- Versión de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sitio`
--
CREATE DATABASE `sitio` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sitio`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_author` int(11) NOT NULL,
  `news_title` varchar(255) NOT NULL,
  `news_url` varchar(255) NOT NULL,
  `news_content` text,
  `news_date` datetime NOT NULL,
  `news_modified` datetime NOT NULL,
  `news_description` text,
  `news_status` int(11) NOT NULL,
  `url_image` tinytext,
  `news_usermodified` int(11) NOT NULL,
  PRIMARY KEY (`news_id`),
  UNIQUE KEY `news_name_UNIQUE` (`news_url`),
  KEY `fk_news_author` (`news_author`),
  KEY `fk_news_modf` (`news_usermodified`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `news`
--

INSERT INTO `news` (`news_id`, `news_author`, `news_title`, `news_url`, `news_content`, `news_date`, `news_modified`, `news_description`, `news_status`, `url_image`, `news_usermodified`) VALUES
(3, 1, 'PRIMERA NOTICIA', 'primera-noticia', 'a', '2012-11-18 16:46:20', '2012-11-18 16:46:22', 'a', 1, '', 1),
(4, 1, 'segunda noticia', 'segunda-noticia', 'a', '2012-11-18 16:46:33', '2012-11-18 16:46:34', 'a', 1, '', 1),
(5, 1, 'tercera noticai', 'tercera-noticai', 'a', '2012-11-18 16:47:06', '2012-11-18 16:47:07', 'as', 1, '', 1),
(6, 1, 'asdadas', 'asdadas', 'asd', '2012-11-18 19:13:13', '2012-11-18 19:13:18', 'asd', 1, '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `pages_id` int(11) NOT NULL,
  `user_mod` int(11) NOT NULL,
  `page_author` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_url` varchar(255) NOT NULL,
  `page_created` datetime NOT NULL,
  `page_modified` datetime NOT NULL,
  `html_title` varchar(70) DEFAULT NULL,
  `html_description` varchar(170) DEFAULT NULL,
  `html_keywords` text,
  `html_content` text,
  PRIMARY KEY (`pages_id`),
  UNIQUE KEY `pages_url_UNIQUE` (`page_url`),
  KEY `page_indx1` (`page_author`),
  KEY `page_inx2` (`user_mod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `user_nickname` varchar(50) NOT NULL,
  `user_registertime` datetime NOT NULL,
  `user_status` int(11) NOT NULL,
  `users_ID` int(11) DEFAULT NULL,
  `isAdmin` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `myus_user_UNIQUE` (`username`),
  UNIQUE KEY `user_nickname_UNIQUE` (`user_nickname`),
  KEY `use_cre_nx` (`users_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`ID`, `username`, `user_nickname`, `user_registertime`, `user_status`, `users_ID`, `isAdmin`) VALUES
(1, 'admin', 'ADMINISTRADOR', '2012-11-15 02:15:00', 1, NULL, 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_author` FOREIGN KEY (`news_author`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_news_modf` FOREIGN KEY (`news_usermodified`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `page_author_fk` FOREIGN KEY (`page_author`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `page_mod_fk` FOREIGN KEY (`user_mod`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `use_cre_fk` FOREIGN KEY (`users_ID`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
