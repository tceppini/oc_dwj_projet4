-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Client :  tceppinitamcms.mysql.db
-- Généré le :  Mar 02 Mai 2017 à 21:27
-- Version du serveur :  5.5.54-0+deb7u1-log
-- Version de PHP :  5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `tceppinitamcms`
--

-- --------------------------------------------------------

--
-- Structure de la table `P4_t_billet`
--

CREATE TABLE IF NOT EXISTS `P4_t_billet` (
  `billet_id` int(11) NOT NULL,
  `billet_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `billet_content` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `billet_dateAjout` date NOT NULL,
  `billet_dateModif` date NOT NULL,
  `billet_nbComments` int(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `P4_t_billet`
--

INSERT INTO `P4_t_billet` (`billet_id`, `billet_title`, `billet_content`, `billet_dateAjout`, `billet_dateModif`, `billet_nbComments`) VALUES
(8, 'Episode 1', '<h3 style="text-align: left;">Et quoniam mirari posse quosdam peregrinos existimo haec lecturos forsitan, si contigerit, quamobrem cum oratio ad ea monstranda deflexerit quae Romae gererentur, nihil praeter seditiones narratur et tabernas et vilitates harum similis alias, summatim causas perstringam nusquam a veritate sponte propria digressurus.</h3>', '2017-04-01', '2017-05-02', 1),
(54, 'Episode 2', '<h3 style="text-align: left;">Et quoniam mirari posse quosdam peregrinos existimo haec lecturos forsitan, si contigerit, quamobrem cum oratio ad ea monstranda deflexerit quae Romae gererentur, nihil praeter seditiones narratur et tabernas et vilitates harum similis alias, summatim causas perstringam nusquam a veritate sponte propria digressurus.</h3>', '2017-04-27', '2017-05-02', 0),
(55, 'Episode 3', '<h3 style="text-align: left;"><img src="http://blog.tceppini.lu/lib/tinymce/plugins/image/uploads/1/FILE-20170422-1311YGCNHZJ4HRM4.jpg" width="1000" height="646" /></h3>\r\n<h3 style="text-align: left;">Et quoniam mirari posse quosdam peregrinos existimo haec lecturos forsitan, si contigerit, quamobrem cum oratio ad ea monstranda deflexerit quae Romae gererentur, nihil praeter seditiones narratur et tabernas et vilitates harum similis alias, summatim causas perstringam nusquam a veritate sponte propria digressurus.</h3>\r\n<p>&nbsp;</p>', '2017-04-27', '2017-05-02', 1),
(56, 'Episode 4', '<p><img style="float: right;" src="http://blog.tceppini.lu/lib/tinymce/plugins/image/uploads/1/FILE-20170422-1311YGCNHZJ4HRM4.jpg" width="401" height="259" /></p>\r\n<h3 style="text-align: left;">Et quoniam mirari posse quosdam peregrinos existimo haec lecturos forsitan, si contigerit, quamobrem cum oratio ad ea monstranda deflexerit quae Romae gererentur, nihil praeter seditiones narratur et tabernas et vilitates harum similis alias, summatim causas perstringam nusquam a veritate sponte propria digressurus.</h3>', '2017-04-27', '2017-05-02', 1);

-- --------------------------------------------------------

--
-- Structure de la table `P4_t_comment`
--

CREATE TABLE IF NOT EXISTS `P4_t_comment` (
  `com_id` int(11) NOT NULL,
  `com_content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `billet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `com_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `P4_t_comment`
--

INSERT INTO `P4_t_comment` (`com_id`, `com_content`, `billet_id`, `user_id`, `com_date`) VALUES
(10, 'C''est cool !!!!!', 8, 1, '2017-04-01 14:58:09'),
(17, 'gfhnfghng vilitates harum similis alias, summatim causas perstringam nusquam a veritate sponte propria digressurus', 56, 5, '2017-05-02 15:31:21'),
(18, 'Lorem ipsum Lorem ipsum Lorem ipsum', 55, 5, '2017-05-02 15:32:02');

-- --------------------------------------------------------

--
-- Structure de la table `P4_t_user`
--

CREATE TABLE IF NOT EXISTS `P4_t_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(88) COLLATE utf8_unicode_ci NOT NULL,
  `user_salt` varchar(23) COLLATE utf8_unicode_ci NOT NULL,
  `user_role` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `P4_t_user`
--

INSERT INTO `P4_t_user` (`user_id`, `user_name`, `user_password`, `user_salt`, `user_role`) VALUES
(1, 'JohnDoe', '$2y$13$F9v8pl5u5WMrCorP9MLyJeyIsOLj.0/xqKd/hqa5440kyeB7FQ8te', 'YcM=A$nsYzkyeDVjEUa7W9K', 'ROLE_ADMIN'),
(5, 'thom57', '$2y$13$sWR2sMaZX6Cc3q.UOghAXOXwbX0nzP9Wc1bsDSLcEna5tICcvp4RK', 'ca92d77afccf43dff8f0316', 'ROLE_ADMIN'),
(6, 'Forteroche', '$2y$13$AkanD9s2dMaZkqGVSmUXC.yREF.eV55G6b5SQCpsCpE6WJDJV1zWa', 'e925dd1d1b2ec8b3c12275b', 'ROLE_ADMIN'),
(7, 'Aurélien', '$2y$13$wcRjX3SoOCkV9A0wY8gXvuGacdDeWEWQZwb/aMj5lZ7zr7RSnKLWS', '79df0aaeb4470a2bbdef3fc', 'ROLE_ADMIN');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `P4_t_billet`
--
ALTER TABLE `P4_t_billet`
  ADD PRIMARY KEY (`billet_id`);

--
-- Index pour la table `P4_t_comment`
--
ALTER TABLE `P4_t_comment`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `fk_com_billet` (`billet_id`),
  ADD KEY `fk_com_user` (`user_id`);

--
-- Index pour la table `P4_t_user`
--
ALTER TABLE `P4_t_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `P4_t_billet`
--
ALTER TABLE `P4_t_billet`
  MODIFY `billet_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT pour la table `P4_t_comment`
--
ALTER TABLE `P4_t_comment`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `P4_t_user`
--
ALTER TABLE `P4_t_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `P4_t_comment`
--
ALTER TABLE `P4_t_comment`
  ADD CONSTRAINT `fk_com_billet` FOREIGN KEY (`billet_id`) REFERENCES `P4_t_billet` (`billet_id`),
  ADD CONSTRAINT `fk_com_user` FOREIGN KEY (`user_id`) REFERENCES `P4_t_user` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
