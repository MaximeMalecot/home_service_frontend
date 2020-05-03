-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 03, 2020 at 10:49 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_lille`
--

-- --------------------------------------------------------

--
-- Table structure for table `abonnement`
--

CREATE TABLE `abonnement` (
  `id_abonnement` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `cout` float DEFAULT NULL,
  `nb_heure` float DEFAULT NULL,
  `temps` int(11) DEFAULT NULL,
  `heure_debut` int(11) DEFAULT NULL,
  `heure_fin` int(11) DEFAULT NULL,
  `stripe_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `abonnement`
--

INSERT INTO `abonnement` (`id_abonnement`, `nom`, `cout`, `nb_heure`, `temps`, `heure_debut`, `heure_fin`, `stripe_id`) VALUES
(1, 'Abonnement de base', 2400, 12, 5, 9, 20, 'prod_HBg8yyk7I9jZqA'),
(2, 'Abonnement familial', 3600, 25, 6, 9, 20, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `affectation`
--

CREATE TABLE `affectation` (
  `prestataire_id_prestataire` int(11) NOT NULL,
  `prestataire_categorie_ville` varchar(45) NOT NULL,
  `prestataire_categorie_nom` varchar(45) NOT NULL,
  `prestation_id_prestation` int(11) NOT NULL,
  `prestation_categorie_ville` varchar(45) NOT NULL,
  `prestation_categorie_nom` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `affectation`
--

INSERT INTO `affectation` (`prestataire_id_prestataire`, `prestataire_categorie_ville`, `prestataire_categorie_nom`, `prestation_id_prestation`, `prestation_categorie_ville`, `prestation_categorie_nom`) VALUES
(1, 'Lille', 'Plomberie', 3, 'Lille', 'Plomberie'),
(2, 'Lille', 'Administratif', 2, 'Lille', 'Administratif'),
(5, 'Lille', 'Plomberie', 1, 'Lille', 'Plomberie'),
(5, 'Lille', 'Plomberie', 3, 'Lille', 'Plomberie');

-- --------------------------------------------------------

--
-- Table structure for table `bareme`
--

CREATE TABLE `bareme` (
  `id_bareme` int(11) NOT NULL,
  `unite` varchar(45) DEFAULT NULL,
  `prix_unite` float DEFAULT NULL,
  `prix_unit_recurrent` float DEFAULT NULL,
  `nb_unite_minimum` float DEFAULT NULL,
  `time_per_unit` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bareme`
--

INSERT INTO `bareme` (`id_bareme`, `unite`, `prix_unite`, `prix_unit_recurrent`, `nb_unite_minimum`, `time_per_unit`) VALUES
(1, 'heure', 130, 117, 20, 1),
(2, 'document', 25, 22, 3, 0.5),
(3, 'heure', 20, 18, 2, 1),
(6, 'heure', 3.3, 2.8, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `nom` varchar(45) NOT NULL,
  `ville` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`nom`, `ville`) VALUES
('Administratif', 'Lille'),
('Menage', 'Lille'),
('Plomberie', 'Lille'),
('testJava', 'Paris');

-- --------------------------------------------------------

--
-- Table structure for table `contrat`
--

CREATE TABLE `contrat` (
  `id_contrat` int(11) NOT NULL,
  `duree` int(11) DEFAULT NULL,
  `path_contrat` varchar(45) DEFAULT NULL,
  `salaire` float DEFAULT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `prestataire_id_prestataire` int(11) NOT NULL,
  `prestataire_ville` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contrat`
--

INSERT INTO `contrat` (`id_contrat`, `duree`, `path_contrat`, `salaire`, `date_debut`, `date_fin`, `prestataire_id_prestataire`, `prestataire_ville`) VALUES
(6, 0, NULL, 6, '2020-05-02 10:00:00', '2020-05-02 11:00:00', 2, 'Lille');

-- --------------------------------------------------------

--
-- Table structure for table `demande`
--

CREATE TABLE `demande` (
  `id_demande` int(11) NOT NULL,
  `description` longtext,
  `date` datetime DEFAULT NULL,
  `etat` tinyint(4) DEFAULT NULL,
  `user_id_user` int(11) NOT NULL,
  `user_ville_reference` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `devis`
--

CREATE TABLE `devis` (
  `idDevis` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `cout` float DEFAULT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `nb_unite` int(11) DEFAULT NULL,
  `id_supplement` int(11) DEFAULT NULL,
  `nb_unit_supplement` float DEFAULT NULL,
  `prestation_id_prestation` int(11) NOT NULL,
  `prestation_categorie_ville` varchar(45) NOT NULL,
  `prestation_categorie_nom` varchar(45) NOT NULL,
  `user_id_user` int(11) NOT NULL,
  `user_ville_reference` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `devis`
--

INSERT INTO `devis` (`idDevis`, `date`, `cout`, `date_debut`, `date_fin`, `nb_unite`, `id_supplement`, `nb_unit_supplement`, `prestation_id_prestation`, `prestation_categorie_ville`, `prestation_categorie_nom`, `user_id_user`, `user_ville_reference`) VALUES
(2, '2020-05-02 18:49:27', 198, '2020-05-20 14:00:00', '2020-05-22 19:00:00', 3, NULL, 0, 2, 'Lille', 'Administratif', 1, 'Paris'),
(4, '2020-05-02 19:10:19', 88, '2020-05-07 15:00:00', '2020-05-08 16:00:00', 2, NULL, 0, 2, 'Lille', 'Administratif', 1, 'Paris'),
(5, '2020-05-02 19:13:11', 88, '2020-05-07 15:00:00', '2020-05-08 16:00:00', 2, NULL, 0, 2, 'Lille', 'Administratif', 1, 'Paris');

-- --------------------------------------------------------

--
-- Table structure for table `facturation`
--

CREATE TABLE `facturation` (
  `id_facturation` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `cout` float DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `reservation_id_reservation` int(11) NOT NULL,
  `prestataire_id_prestataire` int(11) DEFAULT NULL,
  `prestataire_ville` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `facturation`
--

INSERT INTO `facturation` (`id_facturation`, `date`, `cout`, `id_user`, `reservation_id_reservation`, `prestataire_id_prestataire`, `prestataire_ville`) VALUES
(1, '2020-04-19 22:03:20', 216, 1, 1, 3, 'Lille'),
(2, '2020-04-19 23:06:01', 72, 1, 2, 3, 'Lille'),
(3, '2020-04-19 23:09:44', 72, 1, 3, 3, 'Lille'),
(4, '2020-04-19 23:13:57', 82, 1, 4, 3, 'Lille'),
(5, '2020-04-19 23:28:47', 54, 1, 5, 3, 'Lille'),
(6, '2020-04-20 19:29:42', 36, 1, 6, 1, 'Lille'),
(7, '2020-04-20 19:38:51', 36, 1, 7, 3, 'Lille'),
(8, '2020-04-20 19:40:27', 36, 1, 8, 3, 'Lille'),
(9, '2020-04-20 19:43:18', 36, 1, 9, 3, 'Lille'),
(10, '2020-04-20 19:43:18', 36, 1, 10, 3, 'Lille'),
(11, '2020-04-20 19:45:40', 36, 1, 11, 3, 'Lille'),
(12, '2020-04-20 19:45:40', 162, 1, 12, 3, 'Lille'),
(13, '2020-04-29 18:47:34', 0, 1, 13, 2, 'Lille'),
(14, '2020-04-29 21:46:17', 0, 1, 14, 2, 'Lille'),
(15, '2020-04-29 21:46:52', 88, 1, 15, 2, 'Lille'),
(16, '2020-05-02 19:53:37', 132, 1, 16, 2, 'Lille'),
(17, '2020-05-02 19:57:48', 132, 1, 17, 2, 'Lille');

-- --------------------------------------------------------

--
-- Table structure for table `planning`
--

CREATE TABLE `planning` (
  `id_planning` int(11) NOT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `prestataire_id_prestataire` int(11) NOT NULL,
  `prestataire_categorie_ville` varchar(45) NOT NULL,
  `prestataire_categorie_nom` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `planning`
--

INSERT INTO `planning` (`id_planning`, `date_debut`, `date_fin`, `prestataire_id_prestataire`, `prestataire_categorie_ville`, `prestataire_categorie_nom`) VALUES
(1, '2020-04-19 09:00:00', '2020-04-19 20:00:00', 3, 'Lille', 'Plomberie'),
(2, '2020-04-20 08:00:00', '2020-04-20 11:00:00', 3, 'Lille', 'Plomberie'),
(3, '2020-04-21 13:00:00', '2020-04-21 17:00:00', 3, 'Lille', 'Plomberie'),
(4, '2020-04-22 13:00:00', '2020-04-22 17:00:00', 3, 'Lille', 'Plomberie'),
(5, '2020-04-23 00:00:00', '2020-04-23 00:00:00', 3, 'Lille', 'Plomberie'),
(6, '2020-04-20 09:00:00', '2020-04-20 11:00:00', 1, 'Lille', 'Plomberie'),
(8, '2020-04-21 09:00:00', '2020-04-21 14:00:00', 1, 'Lille', 'Plomberie'),
(9, '2020-04-19 05:00:00', '2020-04-19 18:00:00', 1, 'Lille', 'Plomberie'),
(10, '2020-04-25 09:00:00', '2020-04-25 20:00:00', 3, 'Lille', 'Plomberie'),
(11, '2020-04-26 09:00:00', '2020-04-26 20:00:00', 4, 'Lille', 'Plomberie'),
(12, '2020-04-26 09:00:00', '2020-04-26 20:00:00', 3, 'Lille', 'Plomberie'),
(13, '2020-04-27 09:00:00', '2020-04-27 20:00:00', 3, 'Lille', 'Plomberie'),
(14, '2020-04-26 09:00:00', '2020-04-26 20:00:00', 2, 'Lille', 'Administratif'),
(15, '2020-04-27 09:00:00', '2020-04-27 20:00:00', 2, 'Lille', 'Administratif'),
(16, '2020-04-28 09:00:00', '2020-04-28 20:00:00', 2, 'Lille', 'Administratif'),
(17, '2020-04-29 09:00:00', '2020-04-29 20:00:00', 2, 'Lille', 'Administratif'),
(18, '2020-04-30 12:00:00', '2020-04-30 20:00:00', 2, 'Lille', 'Administratif'),
(19, '2020-04-26 09:00:00', '2020-04-26 20:00:00', 1, 'Lille', 'Plomberie'),
(20, '2020-04-27 09:00:00', '2020-04-27 20:00:00', 1, 'Lille', 'Plomberie'),
(21, '2020-04-27 09:00:00', '2020-04-27 20:00:00', 4, 'Lille', 'Plomberie'),
(22, '2020-04-28 09:00:00', '2020-04-28 20:00:00', 4, 'Lille', 'Plomberie'),
(23, '2020-04-29 09:00:00', '2020-04-29 20:00:00', 4, 'Lille', 'Plomberie'),
(24, '2020-04-30 09:00:00', '2020-04-30 20:00:00', 4, 'Lille', 'Plomberie'),
(25, '2020-05-01 09:00:00', '2020-05-01 20:00:00', 4, 'Lille', 'Plomberie'),
(26, '2020-04-28 09:00:00', '2020-04-28 20:00:00', 1, 'Lille', 'Plomberie'),
(27, '2020-04-27 09:00:00', '2020-04-27 20:00:00', 5, 'Lille', 'Plomberie'),
(28, '2020-04-28 09:00:00', '2020-04-28 20:00:00', 5, 'Lille', 'Plomberie'),
(29, '2020-04-30 09:00:00', '2020-04-30 20:00:00', 3, 'Lille', 'Plomberie'),
(30, '2020-05-01 09:00:00', '2020-05-01 20:00:00', 3, 'Lille', 'Plomberie'),
(31, '2020-05-02 09:00:00', '2020-05-02 20:00:00', 3, 'Lille', 'Plomberie'),
(32, '2020-05-03 09:00:00', '2020-05-03 20:00:00', 3, 'Lille', 'Plomberie'),
(33, '2020-05-04 09:00:00', '2020-05-04 20:00:00', 3, 'Lille', 'Plomberie'),
(34, '2020-05-01 12:00:00', '2020-05-01 20:00:00', 2, 'Lille', 'Administratif'),
(35, '2020-05-02 12:00:00', '2020-05-02 20:00:00', 2, 'Lille', 'Administratif'),
(36, '2020-05-03 09:00:00', '2020-05-03 20:00:00', 2, 'Lille', 'Administratif'),
(37, '2020-05-04 09:00:00', '2020-05-04 20:00:00', 2, 'Lille', 'Administratif'),
(38, '2020-05-05 09:00:00', '2020-05-05 13:00:00', 2, 'Lille', 'Administratif'),
(39, '2020-05-06 09:00:00', '2020-05-06 13:00:00', 2, 'Lille', 'Administratif'),
(40, '2020-05-07 09:00:00', '2020-05-07 20:00:00', 2, 'Lille', 'Administratif'),
(41, '2020-05-08 09:00:00', '2020-05-08 20:00:00', 2, 'Lille', 'Administratif'),
(42, '2020-05-09 09:00:00', '2020-05-09 20:00:00', 2, 'Lille', 'Administratif'),
(43, '2020-05-10 09:00:00', '2020-05-10 20:00:00', 2, 'Lille', 'Administratif');

-- --------------------------------------------------------

--
-- Table structure for table `prestataire`
--

CREATE TABLE `prestataire` (
  `id_prestataire` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `tel_mobile` varchar(45) DEFAULT NULL,
  `tel_fixe` varchar(45) DEFAULT NULL,
  `adresse_entreprise` varchar(45) DEFAULT NULL,
  `url_qrcode` varchar(45) DEFAULT NULL,
  `prix_heure` float DEFAULT NULL,
  `supplement` varchar(45) DEFAULT NULL,
  `company_name` varchar(45) DEFAULT NULL,
  `code_postal` int(11) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `nb_heure_min` float DEFAULT NULL,
  `prix_recurrent` double DEFAULT NULL,
  `categorie_ville` varchar(45) NOT NULL,
  `categorie_nom` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prestataire`
--

INSERT INTO `prestataire` (`id_prestataire`, `nom`, `tel_mobile`, `tel_fixe`, `adresse_entreprise`, `url_qrcode`, `prix_heure`, `supplement`, `company_name`, `code_postal`, `email`, `nb_heure_min`, `prix_recurrent`, `categorie_ville`, `categorie_nom`) VALUES
(1, 'SuperPlombier', '0606060606', '0101010101', '5 rue de STDN', NULL, 6, 'Par outils 4 euros', NULL, 75000, 'Leroy@merlin.com', 3, 5, 'Lille', 'Plomberie'),
(2, 'SecretaireSpe', '0707070707', '0909090909', '4 place jeola', NULL, 3, 'Par visa 5euros', NULL, 60000, 'super@secretaire.com', 3, 2, 'Lille', 'Administratif'),
(3, 'PlombierTest', '0707070707', '0101010101', '9 rue de Paris', NULL, 1, NULL, 'PaCher', 55555, 'Plombier@test.com', 1, 1, 'Lille', 'Plomberie'),
(4, 'Tet', '0000000000', '1111111111', 'rue test', NULL, 100, NULL, 'TestTest', 55555, 'test@test.com', 20, 90, 'Lille', 'Plomberie'),
(5, 'PrestaPrem', '2222222222', '6666666666', NULL, NULL, 40, NULL, NULL, 92300, 'presta@prem.com', 20, 38, 'Lille', 'Plomberie');

-- --------------------------------------------------------

--
-- Table structure for table `prestation`
--

CREATE TABLE `prestation` (
  `id_prestation` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `categorie_ville` varchar(45) NOT NULL,
  `categorie_nom` varchar(45) NOT NULL,
  `bareme_id_bareme` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prestation`
--

INSERT INTO `prestation` (`id_prestation`, `nom`, `description`, `categorie_ville`, `categorie_nom`, `bareme_id_bareme`) VALUES
(1, 'Plomberie', 'On refait tous ', 'Lille', 'Plomberie', 1),
(2, 'Secretariat', 'Tous vos documents sont bien avec nous', 'Lille', 'Administratif', 2),
(3, 'La plombe', 'on plombe tous', 'Lille', 'Plomberie', 1),
(4, 'Prestation tah les ouf', 'on est des ouf', 'Paris', 'testJava', 6);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int(11) NOT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `nb_unite` int(11) NOT NULL,
  `id_supplement` int(11) DEFAULT NULL,
  `user_id_user` int(11) NOT NULL,
  `user_ville_reference` varchar(45) NOT NULL,
  `prestation_id_prestation` int(11) NOT NULL,
  `prestation_ville` varchar(45) NOT NULL,
  `nb_unit_suplement` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `date_debut`, `date_fin`, `nb_unite`, `id_supplement`, `user_id_user`, `user_ville_reference`, `prestation_id_prestation`, `prestation_ville`, `nb_unit_suplement`) VALUES
(1, '2020-04-20 09:00:00', '2020-04-23 12:00:00', 3, NULL, 1, 'Paris', 1, 'Lille', 0),
(2, '2020-04-20 14:00:00', '2020-04-23 15:00:00', 1, NULL, 1, 'Paris', 1, 'Lille', 0),
(3, '2020-04-20 10:00:00', '2020-04-21 12:00:00', 2, NULL, 1, 'Paris', 1, 'Lille', 0),
(4, '2020-04-22 10:00:00', '2020-04-23 12:00:00', 2, 1, 1, 'Paris', 1, 'Lille', 2),
(5, '2020-04-19 11:00:00', '2020-04-19 14:00:00', 3, 1, 1, 'Paris', 1, 'Lille', 0),
(6, '2020-04-20 12:00:00', '2020-04-20 14:00:00', 2, 1, 1, 'Paris', 1, 'Lille', 0),
(7, '2020-04-20 12:00:00', '2020-04-20 14:00:00', 2, 1, 1, 'Paris', 1, 'Lille', 0),
(8, '2020-04-20 12:00:00', '2020-04-20 14:00:00', 2, 1, 1, 'Paris', 1, 'Lille', 0),
(9, '2020-04-20 12:00:00', '2020-04-20 14:00:00', 2, 1, 1, 'Paris', 1, 'Lille', 0),
(10, '2020-04-22 12:00:00', '2020-04-22 14:00:00', 2, 1, 1, 'Paris', 1, 'Lille', 0),
(11, '2020-04-20 12:00:00', '2020-04-20 14:00:00', 2, 1, 1, 'Paris', 1, 'Lille', 0),
(12, '2020-04-21 09:00:00', '2020-04-23 12:00:00', 3, 1, 1, 'Paris', 1, 'Lille', 0),
(13, '2020-04-30 10:00:00', '2020-04-30 11:00:00', 2, NULL, 1, 'Paris', 2, 'Lille', 0),
(14, '2020-05-02 10:00:00', '2020-05-02 11:00:00', 2, NULL, 1, 'Paris', 2, 'Lille', 0),
(15, '2020-04-30 10:00:00', '2020-05-01 11:00:00', 2, NULL, 1, 'Paris', 2, 'Lille', 0),
(16, '2020-05-05 14:00:00', '2020-05-06 19:00:00', 3, NULL, 1, 'Paris', 2, 'Lille', 0),
(17, '2020-05-05 14:00:00', '2020-05-06 19:00:00', 3, NULL, 1, 'Paris', 2, 'Lille', 0);

-- --------------------------------------------------------

--
-- Table structure for table `souscription`
--

CREATE TABLE `souscription` (
  `abonnement_id_abonnement` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `heure_restante` float DEFAULT NULL,
  `user_id_user` int(11) NOT NULL,
  `user_ville_reference` varchar(45) NOT NULL,
  `stripe_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `souscription`
--

INSERT INTO `souscription` (`abonnement_id_abonnement`, `date`, `heure_restante`, `user_id_user`, `user_ville_reference`, `stripe_id`) VALUES
(1, '2020-04-29 18:31:12', 12, 1, 'Paris', 'sub_HBg9nHAEz7kVbA');

-- --------------------------------------------------------

--
-- Table structure for table `supplement`
--

CREATE TABLE `supplement` (
  `id_supplement` int(11) NOT NULL,
  `bareme_id_bareme` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `unite` varchar(45) DEFAULT NULL,
  `prix_unite` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplement`
--

INSERT INTO `supplement` (`id_supplement`, `bareme_id_bareme`, `description`, `unite`, `prix_unite`) VALUES
(1, 1, 'par outils en plus', 'outils', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `ville_reference` varchar(45) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `mdp` varchar(256) DEFAULT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `date_inscription` datetime DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `adresse` varchar(45) DEFAULT NULL,
  `cp` int(11) DEFAULT NULL,
  `statut` varchar(45) DEFAULT NULL,
  `stripe_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `ville_reference`, `nom`, `prenom`, `mdp`, `mail`, `date_inscription`, `phone`, `adresse`, `cp`, `statut`, `stripe_id`) VALUES
(1, 'Paris', 'Malecot', 'Maxime', '887375daec62a9f02d32a63c9e14c7641a9a8a42e4fa8f6590eb928d9744b57bb5057a1d227e4d40ef911ac030590bbce2bfdb78103ff0b79094cee8425601f5', '92maximemalecot@gmail.com', '2020-04-18 20:05:55', '0659591280', '7 rue trezel', 92300, NULL, 'cus_H7aDAEVmke62Jx');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abonnement`
--
ALTER TABLE `abonnement`
  ADD PRIMARY KEY (`id_abonnement`);

--
-- Indexes for table `affectation`
--
ALTER TABLE `affectation`
  ADD PRIMARY KEY (`prestataire_id_prestataire`,`prestataire_categorie_ville`,`prestataire_categorie_nom`,`prestation_id_prestation`,`prestation_categorie_ville`,`prestation_categorie_nom`),
  ADD KEY `fk_affectation_prestataire1_idx` (`prestataire_id_prestataire`,`prestataire_categorie_ville`,`prestataire_categorie_nom`),
  ADD KEY `fk_affectation_prestation1_idx` (`prestation_id_prestation`,`prestation_categorie_ville`,`prestation_categorie_nom`);

--
-- Indexes for table `bareme`
--
ALTER TABLE `bareme`
  ADD PRIMARY KEY (`id_bareme`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`ville`,`nom`);

--
-- Indexes for table `contrat`
--
ALTER TABLE `contrat`
  ADD PRIMARY KEY (`id_contrat`,`prestataire_id_prestataire`,`prestataire_ville`),
  ADD KEY `fk_contrat_prestataire1_idx` (`prestataire_id_prestataire`,`prestataire_ville`);

--
-- Indexes for table `demande`
--
ALTER TABLE `demande`
  ADD PRIMARY KEY (`id_demande`,`user_id_user`,`user_ville_reference`),
  ADD KEY `fk_demande_user1_idx` (`user_id_user`,`user_ville_reference`);

--
-- Indexes for table `devis`
--
ALTER TABLE `devis`
  ADD PRIMARY KEY (`idDevis`,`prestation_id_prestation`,`prestation_categorie_ville`,`prestation_categorie_nom`,`user_id_user`,`user_ville_reference`),
  ADD KEY `fk_Devis_prestation1_idx` (`prestation_id_prestation`,`prestation_categorie_ville`,`prestation_categorie_nom`),
  ADD KEY `fk_Devis_user1_idx` (`user_id_user`,`user_ville_reference`);

--
-- Indexes for table `facturation`
--
ALTER TABLE `facturation`
  ADD PRIMARY KEY (`id_facturation`),
  ADD KEY `fk_facturation_client1_idx` (`id_user`),
  ADD KEY `fk_facturation_reservation1_idx` (`reservation_id_reservation`),
  ADD KEY `fk_facturation_prestataire1_idx` (`prestataire_id_prestataire`,`prestataire_ville`);

--
-- Indexes for table `planning`
--
ALTER TABLE `planning`
  ADD PRIMARY KEY (`id_planning`,`prestataire_id_prestataire`,`prestataire_categorie_ville`,`prestataire_categorie_nom`),
  ADD KEY `fk_planning_prestataire1_idx` (`prestataire_id_prestataire`,`prestataire_categorie_ville`,`prestataire_categorie_nom`);

--
-- Indexes for table `prestataire`
--
ALTER TABLE `prestataire`
  ADD PRIMARY KEY (`id_prestataire`,`categorie_ville`,`categorie_nom`),
  ADD KEY `fk_prestataire_categorie1_idx` (`categorie_ville`,`categorie_nom`);

--
-- Indexes for table `prestation`
--
ALTER TABLE `prestation`
  ADD PRIMARY KEY (`id_prestation`,`categorie_ville`,`categorie_nom`),
  ADD KEY `fk_prestation_categorie1_idx` (`categorie_ville`,`categorie_nom`),
  ADD KEY `fk_prestation_bareme1_idx` (`bareme_id_bareme`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_reservation`,`user_id_user`,`user_ville_reference`,`prestation_id_prestation`,`prestation_ville`),
  ADD KEY `fk_reservation_user1_idx` (`user_id_user`,`user_ville_reference`),
  ADD KEY `fk_reservation_prestation1_idx` (`prestation_id_prestation`,`prestation_ville`);

--
-- Indexes for table `souscription`
--
ALTER TABLE `souscription`
  ADD PRIMARY KEY (`abonnement_id_abonnement`,`user_id_user`,`user_ville_reference`),
  ADD KEY `fk_client_has_abonnement_abonnement1_idx` (`abonnement_id_abonnement`),
  ADD KEY `fk_souscription_user1_idx` (`user_id_user`,`user_ville_reference`);

--
-- Indexes for table `supplement`
--
ALTER TABLE `supplement`
  ADD PRIMARY KEY (`id_supplement`,`bareme_id_bareme`),
  ADD KEY `fk_supplement_bareme1_idx` (`bareme_id_bareme`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`,`ville_reference`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abonnement`
--
ALTER TABLE `abonnement`
  MODIFY `id_abonnement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bareme`
--
ALTER TABLE `bareme`
  MODIFY `id_bareme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contrat`
--
ALTER TABLE `contrat`
  MODIFY `id_contrat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `demande`
--
ALTER TABLE `demande`
  MODIFY `id_demande` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devis`
--
ALTER TABLE `devis`
  MODIFY `idDevis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `facturation`
--
ALTER TABLE `facturation`
  MODIFY `id_facturation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `planning`
--
ALTER TABLE `planning`
  MODIFY `id_planning` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `prestataire`
--
ALTER TABLE `prestataire`
  MODIFY `id_prestataire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `prestation`
--
ALTER TABLE `prestation`
  MODIFY `id_prestation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `supplement`
--
ALTER TABLE `supplement`
  MODIFY `id_supplement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `affectation`
--
ALTER TABLE `affectation`
  ADD CONSTRAINT `fk_affectation_prestataire1` FOREIGN KEY (`prestataire_id_prestataire`,`prestataire_categorie_ville`,`prestataire_categorie_nom`) REFERENCES `prestataire` (`id_prestataire`, `categorie_ville`, `categorie_nom`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_affectation_prestation1` FOREIGN KEY (`prestation_id_prestation`,`prestation_categorie_ville`,`prestation_categorie_nom`) REFERENCES `prestation` (`id_prestation`, `categorie_ville`, `categorie_nom`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `contrat`
--
ALTER TABLE `contrat`
  ADD CONSTRAINT `fk_contrat_prestataire1` FOREIGN KEY (`prestataire_id_prestataire`) REFERENCES `prestataire` (`id_prestataire`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `demande`
--
ALTER TABLE `demande`
  ADD CONSTRAINT `fk_demande_user1` FOREIGN KEY (`user_id_user`,`user_ville_reference`) REFERENCES `user` (`id_user`, `ville_reference`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `devis`
--
ALTER TABLE `devis`
  ADD CONSTRAINT `fk_Devis_prestation1` FOREIGN KEY (`prestation_id_prestation`,`prestation_categorie_ville`,`prestation_categorie_nom`) REFERENCES `prestation` (`id_prestation`, `categorie_ville`, `categorie_nom`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Devis_user1` FOREIGN KEY (`user_id_user`,`user_ville_reference`) REFERENCES `user` (`id_user`, `ville_reference`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `facturation`
--
ALTER TABLE `facturation`
  ADD CONSTRAINT `fk_facturation_client1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_facturation_prestataire1` FOREIGN KEY (`prestataire_id_prestataire`) REFERENCES `prestataire` (`id_prestataire`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_facturation_reservation1` FOREIGN KEY (`reservation_id_reservation`) REFERENCES `reservation` (`id_reservation`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `planning`
--
ALTER TABLE `planning`
  ADD CONSTRAINT `fk_planning_prestataire1` FOREIGN KEY (`prestataire_id_prestataire`,`prestataire_categorie_ville`,`prestataire_categorie_nom`) REFERENCES `prestataire` (`id_prestataire`, `categorie_ville`, `categorie_nom`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `prestataire`
--
ALTER TABLE `prestataire`
  ADD CONSTRAINT `fk_prestataire_categorie1` FOREIGN KEY (`categorie_ville`,`categorie_nom`) REFERENCES `categorie` (`ville`, `nom`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `prestation`
--
ALTER TABLE `prestation`
  ADD CONSTRAINT `fk_prestation_bareme1` FOREIGN KEY (`bareme_id_bareme`) REFERENCES `bareme` (`id_bareme`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_prestation_categorie1` FOREIGN KEY (`categorie_ville`,`categorie_nom`) REFERENCES `categorie` (`ville`, `nom`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_reservation_prestation1` FOREIGN KEY (`prestation_id_prestation`) REFERENCES `prestation` (`id_prestation`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reservation_user1` FOREIGN KEY (`user_id_user`,`user_ville_reference`) REFERENCES `user` (`id_user`, `ville_reference`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `souscription`
--
ALTER TABLE `souscription`
  ADD CONSTRAINT `fk_client_has_abonnement_abonnement1` FOREIGN KEY (`abonnement_id_abonnement`) REFERENCES `abonnement` (`id_abonnement`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_souscription_user1` FOREIGN KEY (`user_id_user`,`user_ville_reference`) REFERENCES `user` (`id_user`, `ville_reference`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `supplement`
--
ALTER TABLE `supplement`
  ADD CONSTRAINT `fk_supplement_bareme1` FOREIGN KEY (`bareme_id_bareme`) REFERENCES `bareme` (`id_bareme`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
