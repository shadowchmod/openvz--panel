-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb5+lenny7
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 24 Janvier 2011 à 00:15
-- Version du serveur: 5.0.51
-- Version de PHP: 5.2.6-1+lenny9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `hd_panel`
--
CREATE DATABASE `hd_panel` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `hd_panel`;

-- --------------------------------------------------------

--
-- Structure de la table `action_client`
--

CREATE TABLE IF NOT EXISTS `action_client` (
  `id` mediumint(9) NOT NULL auto_increment,
  `id_client` varchar(4) NOT NULL,
  `time` text NOT NULL,
  `texte` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `action_client`
--


-- --------------------------------------------------------

--
-- Structure de la table `action_facture`
--

CREATE TABLE IF NOT EXISTS `action_facture` (
  `id` mediumint(9) NOT NULL auto_increment,
  `id_facture` varchar(4) NOT NULL,
  `time` text NOT NULL,
  `texte` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `action_facture`
--


-- --------------------------------------------------------

--
-- Structure de la table `action_vps`
--

CREATE TABLE IF NOT EXISTS `action_vps` (
  `id` mediumint(9) NOT NULL auto_increment,
  `id_vps` varchar(4) NOT NULL,
  `time` text NOT NULL,
  `texte` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `action_vps`
--


-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` mediumint(9) NOT NULL auto_increment,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tel_fixe` varchar(14) NOT NULL,
  `tel_mobile` varchar(14) NOT NULL,
  `password` text NOT NULL,
  `nikhandle` text NOT NULL,
  `etat` varchar(1) NOT NULL,
  `ville` text NOT NULL,
  `cp` varchar(5) NOT NULL,
  `adresse` text NOT NULL,
  `pays` varchar(20) NOT NULL,
  `credit` varchar(6) NOT NULL,
  `langue` text NOT NULL,
  `ip_register` text NOT NULL,
  `status` text NOT NULL,
  `admin` varchar(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=754 ;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`id`, `nom`, `prenom`, `email`, `tel_fixe`, `tel_mobile`, `password`, `nikhandle`, `etat`, `ville`, `cp`, `adresse`, `pays`, `credit`, `langue`, `ip_register`, `status`, `admin`) VALUES
(1, 'Admin', 'admin', 'support@your-domaine.fr', '', '', 'votre-mot-de-passe-crypter-md5', 'admin', '1', '', '', '', 'France', '', '', '', '', '1');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `id` mediumint(9) NOT NULL auto_increment,
  `id_client` varchar(4) NOT NULL,
  `number_cmd` text NOT NULL,
  `id_service` varchar(4) NOT NULL,
  `cat_service` varchar(10) NOT NULL,
  `nbr_service` varchar(4) NOT NULL,
  `ip_client` text NOT NULL,
  `etat` varchar(4) NOT NULL,
  `id_prix` varchar(4) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `commande`
--


-- --------------------------------------------------------

--
-- Structure de la table `compte_ftp`
--

CREATE TABLE IF NOT EXISTS `compte_ftp` (
  `id` mediumint(9) NOT NULL auto_increment,
  `user` text NOT NULL,
  `password` text NOT NULL,
  `quotat` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `compte_ftp`
--



-- --------------------------------------------------------

--
-- Structure de la table `connexion`
--

CREATE TABLE IF NOT EXISTS `connexion` (
  `id` int(5) NOT NULL auto_increment,
  `time` text NOT NULL,
  `id_client` int(4) NOT NULL,
  `login` text NOT NULL,
  `ip` text NOT NULL,
  `etat` text NOT NULL,
  `md5` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `connexion`
--


-- --------------------------------------------------------

--
-- Structure de la table `disque_ram`
--

CREATE TABLE IF NOT EXISTS `disque_ram` (
  `id` int(10) NOT NULL,
  `vpsid` int(10) NOT NULL,
  `disque_use` float NOT NULL,
  `ram_use` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `disque_ram`
--


-- --------------------------------------------------------

--
-- Structure de la table `email`
--

CREATE TABLE IF NOT EXISTS `email` (
  `id` mediumint(9) NOT NULL auto_increment,
  `id_client` varchar(4) NOT NULL,
  `mail` text NOT NULL,
  `sujet` text NOT NULL,
  `time` text NOT NULL,
  `prioriter` varchar(4) NOT NULL,
  `etat` varchar(4) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `email`
--


-- --------------------------------------------------------

--
-- Structure de la table `enquette`
--

CREATE TABLE IF NOT EXISTS `enquette` (
  `id` mediumint(9) NOT NULL auto_increment,
  `time` text NOT NULL,
  `ip` text NOT NULL,
  `id_client` text NOT NULL,
  `commande_note` text NOT NULL,
  `commande_commentair` text NOT NULL,
  `payement_note` text NOT NULL,
  `payement_commentair` text NOT NULL,
  `payement_prefere` text NOT NULL,
  `payement_utilise` text NOT NULL,
  `offre_commentair` text NOT NULL,
  `offre_note` text NOT NULL,
  `support_note` text NOT NULL,
  `support_comentair` text NOT NULL,
  `service_note` text NOT NULL,
  `service_commentair` text NOT NULL,
  `livraison_note` text NOT NULL,
  `livraison_commentair` text NOT NULL,
  `global_note` text NOT NULL,
  `global_comentair` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `enquette`
--


-- --------------------------------------------------------

--
-- Structure de la table `hosting`
--

CREATE TABLE IF NOT EXISTS `hosting` (
  `id` int(11) NOT NULL auto_increment,
  `domaine` text NOT NULL,
  `plan` varchar(4) NOT NULL,
  `id_client` text NOT NULL,
  `user` text NOT NULL,
  `password` text NOT NULL,
  `etat` varchar(4) NOT NULL,
  `status` varchar(4) NOT NULL,
  `id_plan` varchar(4) NOT NULL,
  `id_server` varchar(4) NOT NULL,
  `expiration` text NOT NULL,
  `creation` text NOT NULL,
  `commentair` text NOT NULL,
  `facture_prolongation` text NOT NULL,
  `generate_invoice` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `hosting`
--


-- --------------------------------------------------------

--
-- Structure de la table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `id` mediumint(9) NOT NULL auto_increment,
  `id_client` varchar(5) NOT NULL,
  `etat` varchar(5) NOT NULL,
  `date_creat` text NOT NULL,
  `ip_crea` text NOT NULL,
  `commentaire_admin` text NOT NULL,
  `commentair_facture` text NOT NULL,
  `texte` text NOT NULL,
  `facture` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `invoice`
--


-- --------------------------------------------------------

--
-- Structure de la table `invoice_corp`
--

CREATE TABLE IF NOT EXISTS `invoice_corp` (
  `id` mediumint(9) NOT NULL auto_increment,
  `id_service` varchar(4) NOT NULL,
  `cat_service` text NOT NULL,
  `id_prix` varchar(4) NOT NULL,
  `jour_add` text NOT NULL,
  `etat` varchar(4) NOT NULL,
  `time_exec` text NOT NULL,
  `return_exec` text NOT NULL,
  `type_action` text NOT NULL,
  `text` text NOT NULL,
  `id_facture` text NOT NULL,
  `prix` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `invoice_corp`
--


-- --------------------------------------------------------

--
-- Structure de la table `ip`
--

CREATE TABLE IF NOT EXISTS `ip` (
  `id` mediumint(9) NOT NULL auto_increment,
  `ip` text NOT NULL,
  `reverse_original` varchar(30) NOT NULL,
  `reverse_client` varchar(50) NOT NULL,
  `dispo` varchar(50) NOT NULL default '1',
  `id_server` mediumint(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `ip`
--


-- --------------------------------------------------------

--
-- Structure de la table `maintenance`
--

CREATE TABLE IF NOT EXISTS `maintenance` (
  `id` mediumint(9) NOT NULL auto_increment,
  `server` varchar(4) NOT NULL,
  `type` text NOT NULL,
  `sujet` text NOT NULL,
  `description` text NOT NULL,
  `technitien` text NOT NULL,
  `date_open` text NOT NULL,
  `temp_prevue` text NOT NULL,
  `avancement` text NOT NULL,
  `etat` varchar(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `maintenance`
--


-- --------------------------------------------------------

--
-- Structure de la table `maintenance_message`
--

CREATE TABLE IF NOT EXISTS `maintenance_message` (
  `id` mediumint(9) NOT NULL auto_increment,
  `id_maintenance` varchar(4) NOT NULL,
  `id_tech` varchar(4) NOT NULL,
  `time` text NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `maintenance_message`
--


-- --------------------------------------------------------

--
-- Structure de la table `messagerie_message`
--

CREATE TABLE IF NOT EXISTS `messagerie_message` (
  `id` int(10) NOT NULL auto_increment,
  `id_objet` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `message` mediumtext NOT NULL,
  `id_client` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `messagerie_message`
--


-- --------------------------------------------------------

--
-- Structure de la table `messagerie_objet`
--

CREATE TABLE IF NOT EXISTS `messagerie_objet` (
  `id` int(10) NOT NULL auto_increment,
  `date` datetime NOT NULL,
  `objet` mediumtext NOT NULL,
  `id_client` int(10) NOT NULL,
  `status` int(2) NOT NULL,
  `new_client` int(2) NOT NULL default '1',
  `new_admin` int(2) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `messagerie_objet`
--


-- --------------------------------------------------------

--
-- Structure de la table `notes_client`
--

CREATE TABLE IF NOT EXISTS `notes_client` (
  `id` mediumint(9) NOT NULL auto_increment,
  `id_client` text NOT NULL,
  `time` text NOT NULL,
  `ip_crea` text NOT NULL,
  `id_admin` text NOT NULL,
  `texte` text NOT NULL,
  `etat` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `notes_client`
--


-- --------------------------------------------------------

--
-- Structure de la table `notes_facture`
--

CREATE TABLE IF NOT EXISTS `notes_facture` (
  `id` mediumint(9) NOT NULL auto_increment,
  `id_facture` text NOT NULL,
  `time` text NOT NULL,
  `ip_crea` text NOT NULL,
  `id_admin` text NOT NULL,
  `texte` text NOT NULL,
  `etat` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `notes_facture`
--


-- --------------------------------------------------------

--
-- Structure de la table `notes_vps`
--

CREATE TABLE IF NOT EXISTS `notes_vps` (
  `id` mediumint(9) NOT NULL auto_increment,
  `id_vps` text NOT NULL,
  `time` text NOT NULL,
  `ip_crea` text NOT NULL,
  `id_admin` text NOT NULL,
  `texte` text NOT NULL,
  `etat` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `notes_vps`
--


-- --------------------------------------------------------

--
-- Structure de la table `option_disque`
--

CREATE TABLE IF NOT EXISTS `option_disque` (
  `id` int(9) NOT NULL auto_increment,
  `nom` varchar(50) NOT NULL,
  `disque_plus` int(5) NOT NULL default '0',
  `prix` float NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `option_disque`
--


-- --------------------------------------------------------

--
-- Structure de la table `option_panel`
--

CREATE TABLE IF NOT EXISTS `option_panel` (
  `id` mediumint(9) NOT NULL auto_increment,
  `value` text NOT NULL,
  `valeur` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `option_panel`
--

INSERT INTO `option_panel` (`id`, `value`, `valeur`) VALUES
(1, 'MODE_MAINTENANCE', '0'),
(2, 'TEXTE_MAITENANCE', 'Site web en maintenance temporaire.');

-- --------------------------------------------------------

--
-- Structure de la table `option_ram`
--

CREATE TABLE IF NOT EXISTS `option_ram` (
  `id` int(9) NOT NULL auto_increment,
  `nom` varchar(50) NOT NULL,
  `ram_plus` int(4) NOT NULL default '0',
  `prix` float NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `option_ram`
--


-- --------------------------------------------------------

--
-- Structure de la table `os`
--

CREATE TABLE IF NOT EXISTS `os` (
  `id` mediumint(9) NOT NULL auto_increment,
  `nom_os` text NOT NULL,
  `fichier` text NOT NULL,
  `etat` int(2) NOT NULL,
  `type` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Contenu de la table `os`
--

INSERT INTO `os` (`id`, `nom_os`, `fichier`, `etat`, `type`) VALUES
(6, 'Debian 5 x86 (32bits)', 'debian-5.0-x86.tar.gz', 1, 'linux'),
(9, 'Fedora 12 (32bits)', 'fedora-12-x86.tar.gz', 1, 'linux');

-- --------------------------------------------------------

--
-- Structure de la table `payement`
--

CREATE TABLE IF NOT EXISTS `payement` (
  `id` mediumint(9) NOT NULL auto_increment,
  `id_client` varchar(4) NOT NULL,
  `id_facture` text NOT NULL,
  `id_transaction` text NOT NULL,
  `id_type_payement` text NOT NULL,
  `montant` text NOT NULL,
  `taxe` text NOT NULL,
  `etat` varchar(4) NOT NULL,
  `ip_client` text NOT NULL,
  `heur` text NOT NULL,
  `date` text NOT NULL,
  `key` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `payement`
--


-- --------------------------------------------------------

--
-- Structure de la table `plan`
--

CREATE TABLE IF NOT EXISTS `plan` (
  `id` mediumint(9) NOT NULL auto_increment,
  `id_whmcs` int(10) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `ram` varchar(20) NOT NULL,
  `disque` varchar(20) NOT NULL,
  `nbr_cpu` varchar(20) NOT NULL,
  `dd_info` text NOT NULL,
  `ram_info` text NOT NULL,
  `proco_info` text NOT NULL,
  `connexion_info` text NOT NULL,
  `bp_info` text NOT NULL,
  `frai_install` varchar(1) NOT NULL,
  `install_price` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `plan`
--

INSERT INTO `plan` (`id`, `id_whmcs`, `nom`, `ram`, `disque`, `nbr_cpu`, `dd_info`, `ram_info`, `proco_info`, `connexion_info`, `bp_info`, `frai_install`, `install_price`) VALUES
(1, 47, 'VPS 0', '128', '20', '1', '1 x 20Go', '128 Mo ', '1 * 2,40Ghz', '100Mbps', 'Illimité', '0', '3,00'),
(2, 12, 'VPS 1', '256', '50', '2', '50Go', '256 Mo', '2 x 2,40Ghz', '100Mbps', 'Illimité', '0', ''),
(3, 13, 'VPS 2', '512', '80', '3', '80Go', '512 Mo', '3 x 2,40Ghz', '100Mbps', 'Illimité', '0', ''),
(7, 0, 'VPS 3', '1024', '100', '4', '100', '1024 Mo', '4 x 2,40Ghz', '100Mbps', 'Illimité', '0', '');

-- --------------------------------------------------------

--
-- Structure de la table `plan_dedicated`
--

CREATE TABLE IF NOT EXISTS `plan_dedicated` (
  `id` mediumint(9) NOT NULL auto_increment,
  `nom_plan` text NOT NULL,
  `ram` text NOT NULL,
  `disque` text NOT NULL,
  `connexion` text NOT NULL,
  `etat` varchar(4) NOT NULL,
  `cpu` text NOT NULL,
  `ref` text NOT NULL,
  `type_revendeur` text NOT NULL,
  `location` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `plan_dedicated`
--


-- --------------------------------------------------------

--
-- Structure de la table `plan_domaine`
--

CREATE TABLE IF NOT EXISTS `plan_domaine` (
  `id` mediumint(9) NOT NULL auto_increment,
  `extension` text NOT NULL,
  `fourniseur` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `plan_domaine`
--


-- --------------------------------------------------------

--
-- Structure de la table `plan_hosting`
--

CREATE TABLE IF NOT EXISTS `plan_hosting` (
  `id` mediumint(9) NOT NULL auto_increment,
  `nom` text NOT NULL,
  `disque` text NOT NULL,
  `bandeb` text NOT NULL,
  `domaine` text NOT NULL,
  `plan_cpanel` text NOT NULL,
  `ftp` text NOT NULL,
  `bdd` text NOT NULL,
  `compte_mail` text NOT NULL,
  `frai_install` varchar(1) NOT NULL,
  `install_price` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `plan_hosting`
--


-- --------------------------------------------------------

--
-- Structure de la table `prix_service`
--

CREATE TABLE IF NOT EXISTS `prix_service` (
  `id` mediumint(9) NOT NULL auto_increment,
  `service_type` text NOT NULL,
  `service_id` text NOT NULL,
  `jour_time` text NOT NULL,
  `jour_nbr` text NOT NULL,
  `jour_texte` text NOT NULL,
  `prix` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Contenu de la table `prix_service`
--

INSERT INTO `prix_service` (`id`, `service_type`, `service_id`, `jour_time`, `jour_nbr`, `jour_texte`, `prix`) VALUES
(17, 'VPS', '1', '2678400', '31', '1 Moi', '4.00'),


-- --------------------------------------------------------

--
-- Structure de la table `reboot`
--

CREATE TABLE IF NOT EXISTS `reboot` (
  `id` mediumint(9) NOT NULL auto_increment,
  `heure` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `ip` varchar(16) NOT NULL,
  `id_client` int(4) NOT NULL,
  `id_vps` int(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Contenu de la table `reboot`
--


-- --------------------------------------------------------

--
-- Structure de la table `reinstallation`
--

CREATE TABLE IF NOT EXISTS `reinstallation` (
  `id` int(9) NOT NULL auto_increment,
  `id_vps` int(4) NOT NULL,
  `id_os` int(2) NOT NULL,
  `date` date NOT NULL,
  `heure` varchar(6) NOT NULL,
  `etape` varchar(2) NOT NULL,
  `commentair` text NOT NULL,
  `etat` varchar(2) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `id_client` int(6) NOT NULL,
  `erreur` text NOT NULL,
  `msn_erreur` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=97 ;

--
-- Contenu de la table `reinstallation`
--


-- --------------------------------------------------------

--
-- Structure de la table `serveur`
--

CREATE TABLE IF NOT EXISTS `serveur` (
  `id` mediumint(9) NOT NULL auto_increment,
  `login` varchar(10) NOT NULL,
  `password` varchar(32) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `host` varchar(60) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `etat` varchar(2) NOT NULL,
  `port` int(5) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `serveur`
--

INSERT INTO `serveur` (`id`, `login`, `password`, `ip`, `host`, `nom`, `etat`, `port`) VALUES
(2, 'root', 'code-serveur', '80XXXipserveur', 'ks3058.kimsufi.com', 'ks3058', '1', 22);

-- --------------------------------------------------------

--
-- Structure de la table `stats_mem_dd`
--

CREATE TABLE IF NOT EXISTS `stats_mem_dd` (
  `id` int(9) NOT NULL auto_increment,
  `id_vps` int(9) NOT NULL,
  `ram_total` bigint(20) NOT NULL,
  `ram_use` bigint(20) NOT NULL,
  `disque_total` bigint(20) NOT NULL,
  `disque_use` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `stats_mem_dd`
--


-- --------------------------------------------------------

--
-- Structure de la table `tache_admin`
--

CREATE TABLE IF NOT EXISTS `tache_admin` (
  `id` mediumint(9) NOT NULL auto_increment,
  `date` text NOT NULL,
  `for` varchar(4) NOT NULL,
  `texte` text NOT NULL,
  `sujet` text NOT NULL,
  `etat` varchar(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `tache_admin`
--


-- --------------------------------------------------------

--
-- Structure de la table `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `id` mediumint(9) NOT NULL auto_increment,
  `id_client` varchar(4) NOT NULL,
  `sujet` varchar(255) NOT NULL,
  `date_creation` text NOT NULL,
  `createur` varchar(255) NOT NULL,
  `service` varchar(4) NOT NULL,
  `cat_service` text NOT NULL,
  `facture` varchar(10) NOT NULL,
  `etat` varchar(4) NOT NULL,
  `secteur` varchar(4) NOT NULL,
  `urgence` varchar(4) NOT NULL,
  `technitien` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `ticket`
--


-- --------------------------------------------------------

--
-- Structure de la table `ticket_message`
--

CREATE TABLE IF NOT EXISTS `ticket_message` (
  `id` mediumint(9) NOT NULL auto_increment,
  `id_client` varchar(4) NOT NULL,
  `id_ticket` varchar(4) NOT NULL,
  `date` text NOT NULL,
  `message` text NOT NULL,
  `etat` varchar(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `ticket_message`
--


-- --------------------------------------------------------

--
-- Structure de la table `ticket_secteur`
--

CREATE TABLE IF NOT EXISTS `ticket_secteur` (
  `id` mediumint(9) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `ticket_secteur`
--

INSERT INTO `ticket_secteur` (`id`, `name`) VALUES
(1, 'Serveur dédié (Commercial)'),
(2, 'Serveur dédié (Technique)'),
(3, 'Serveur Virtuel (VPS) (Commercial)'),
(4, 'Serveur Virtuel (VPS) (Technique)'),
(5, 'Hebergement web (Commercial)'),
(6, 'Hebergement web (Technique)'),
(7, 'Autre servcices');

-- --------------------------------------------------------

--
-- Structure de la table `vps`
--

CREATE TABLE IF NOT EXISTS `vps` (
  `id` int(3) NOT NULL auto_increment,
  `id_vps_whmcs` int(10) NOT NULL,
  `new` int(1) NOT NULL default '0',
  `etat` int(1) NOT NULL default '1',
  `status` int(1) NOT NULL default '0',
  `id_client` int(5) NOT NULL,
  `vmid` int(5) NOT NULL,
  `id_ip` int(3) NOT NULL,
  `id_os` int(2) NOT NULL,
  `id_plan` int(2) NOT NULL,
  `id_server` int(2) NOT NULL default '2',
  `TX_total` bigint(20) NOT NULL default '0',
  `RX_total` bigint(20) NOT NULL default '0',
  `TX_temp` bigint(20) NOT NULL default '0',
  `RX_temp` bigint(20) NOT NULL default '0',
  `deb_TX` varchar(20) NOT NULL,
  `deb_RX` varchar(20) NOT NULL,
  `expiration` text NOT NULL,
  `creation` text NOT NULL,
  `commentaire` text NOT NULL,
  `facture_prolongation` varchar(10) NOT NULL,
  `facture` varchar(10) NOT NULL,
  `generate_invoice` varchar(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `vps`
--


-- --------------------------------------------------------

--
-- Structure de la table `vps_option`
--

CREATE TABLE IF NOT EXISTS `vps_option` (
  `id` int(9) NOT NULL auto_increment,
  `type` int(3) NOT NULL,
  `id_vps` int(9) NOT NULL,
  `id_option` int(9) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `vps_option`
--


-- --------------------------------------------------------

--
-- Structure de la table `warning`
--

CREATE TABLE IF NOT EXISTS `warning` (
  `id` mediumint(9) NOT NULL auto_increment,
  `id_client` varchar(4) NOT NULL,
  `ip` varchar(15) NOT NULL default '0.0.0.0',
  `message` text NOT NULL,
  `page` text NOT NULL,
  `time` varchar(15) NOT NULL,
  `type` text NOT NULL,
  `TYPE_W` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=95 ;

--
-- Contenu de la table `warning`
--

