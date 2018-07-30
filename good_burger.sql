-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 30 Juillet 2018 à 13:54
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `good_burger`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `login` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `password` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`login`),
  KEY `FK_create` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id_cart` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_cart`),
  KEY `FK_have` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `checkout`
--

CREATE TABLE IF NOT EXISTS `checkout` (
  `id_cart` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date_out` datetime NOT NULL,
  `total_price` int(11) NOT NULL,
  PRIMARY KEY (`id_cart`,`id_user`),
  KEY `FK_Checkout` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id_product` int(11) NOT NULL,
  `id_cart` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id_product`,`id_cart`),
  KEY `FK_content` (`id_cart`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `goodburger`
--

CREATE TABLE IF NOT EXISTS `goodburger` (
  `id_gb` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_gb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `id_state` int(11) DEFAULT NULL,
  `id_type` int(11) DEFAULT NULL,
  `name` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  `image_url` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_product`),
  KEY `FK_can_be` (`id_state`),
  KEY `FK_may_be` (`id_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id_product`, `id_state`, `id_type`, `name`, `description`, `price`, `quantity`, `date_creation`, `image_url`) VALUES
(1, 1, 1, 'Burger 1', 'Sweet burger', '4$', 12, '2017-04-17 00:00:00', 'img/b1.jpg'),
(2, 1, 2, 'Burger 2', 'Nice', '2$', 4, '2018-07-15 00:00:00', 'img/b2.jpg'),
(3, 1, 3, 'Burger 3', 'Good', '6$', 10, '2018-03-05 00:00:00', 'img/b3.jpg'),
(4, 2, 1, 'Burger 4', 'Good', '3$', 1, '2018-07-07 00:00:00', 'img/b4.jpg'),
(5, 1, 3, 'Burger 5', 'Nice & Good', '9$', 20, '2017-07-05 00:00:00', 'img/b5.jpg'),
(6, 1, 2, 'Burger 6', 'Nice,Sweet & Good', '7.5$', 12, '2018-07-02 00:00:00', 'img/b6.jpg'),
(7, 1, 1, 'Burger 7', 'Very Good', '4$', 14, '2018-07-19 00:00:00', 'img/b7.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `id_state` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_state`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `state`
--

INSERT INTO `state` (`id_state`, `state`) VALUES
(1, 'available'),
(2, 'not available');

-- --------------------------------------------------------

--
-- Structure de la table `take`
--

CREATE TABLE IF NOT EXISTS `take` (
  `id_product` int(11) NOT NULL,
  `id_gb` int(11) NOT NULL,
  PRIMARY KEY (`id_gb`,`id_product`),
  KEY `FK_content` (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id_type` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `type`
--

INSERT INTO `type` (`id_type`, `type`) VALUES
(1, 'meat'),
(2, 'vegetable'),
(3, 'cheese');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `surname` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(254) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(254) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `FK_create` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_have` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `FK_Checkout` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `FK_content` FOREIGN KEY (`id_cart`) REFERENCES `cart` (`id_cart`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_can_be` FOREIGN KEY (`id_state`) REFERENCES `state` (`id_state`),
  ADD CONSTRAINT `FK_may_be` FOREIGN KEY (`id_type`) REFERENCES `type` (`id_type`);

--
-- Contraintes pour la table `take`
--
ALTER TABLE `take`
  ADD CONSTRAINT `FK_take` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
