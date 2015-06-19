SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `activites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8_bin NOT NULL,
  `lieu` varchar(50) COLLATE utf8_bin NOT NULL,
  `signature` varchar(20) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `debut` date NOT NULL,
  `fin` date NOT NULL,
  `propose_par` int(11) NOT NULL,
  `valide_par` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `adherents` (
  `numcbde` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sexe` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `pseudo` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `motdepasse` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `solde` float NOT NULL,
  `section` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `droits` bigint(20) NOT NULL,
  `surdroits` bigint(20) NOT NULL,
  `supreme` tinyint(1) NOT NULL DEFAULT '0',
  `fonctions` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `inscription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valide` tinyint(1) NOT NULL DEFAULT '0',
  `pb_sante` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `numero_tel` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `preinscription` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`numcbde`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `boutons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) COLLATE utf8_bin NOT NULL,
  `montant` float NOT NULL,
  `receveur` int(11) NOT NULL,
  `categorie` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `categories_boutons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(60) COLLATE utf8_bin NOT NULL,
  `affichage` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `cheques` (
  `id` int(11) NOT NULL,
  `transaction` bigint(20) NOT NULL,
  `nom` varchar(80) COLLATE utf8_bin NOT NULL,
  `prenom` varchar(50) COLLATE utf8_bin NOT NULL,
  `banque` varchar(30) COLLATE utf8_bin NOT NULL,
  `montant` float NOT NULL,
  `date` date NOT NULL,
  `date_cheque` varchar(10) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `historique_pseudo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `numcbde` int(11) NOT NULL,
  `pseudo` varchar(30) COLLATE utf8_bin NOT NULL,
  `debut` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fin` datetime NOT NULL,
  `fin_affichage` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `sid` (
  `sid` varchar(42) COLLATE utf8_bin NOT NULL,
  `expircomplet` datetime NOT NULL,
  `expiration` datetime NOT NULL,
  `numcbde` int(11) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `emetteur` int(11) NOT NULL,
  `recepteur` int(11) NOT NULL,
  `montant` float NOT NULL,
  `idconso` int(11) NOT NULL,
  `commentaire` varchar(100) COLLATE utf8_bin NOT NULL,
  `valide` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

