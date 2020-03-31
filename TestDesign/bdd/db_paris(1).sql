-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 30, 2020 at 11:38 PM
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
-- Database: `db_paris`
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
(1, 'Abonnement de base', 2400, 12, 5, 9, 20, 'prod_GyqiP8eyYTvQfV'),
(2, 'Abonnement familial', 3600, 25, 6, 9, 20, 'prod_GyqjGaMprHKyaz'),
(3, 'Abonnement premium', 6000, 50, 7, 0, 24, 'prod_Gyqnowfz91E14R');

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
('jardinage', 'Paris'),
('plomberie', 'Paris');

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

--
-- Dumping data for table `demande`
--

INSERT INTO `demande` (`id_demande`, `description`, `date`, `etat`, `user_id_user`, `user_ville_reference`) VALUES
(1, 'J\'aimerais avoir un jardinier personnel', '2020-03-30 18:07:46', 0, 10, 'Paris'),
(2, 'J\'aimerais avoir un déménageur dispo pour le 15', '2020-03-30 18:19:47', 0, 10, 'Paris');

-- --------------------------------------------------------

--
-- Table structure for table `facturation`
--

CREATE TABLE `facturation` (
  `id_facturation` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `cout` float DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `devis` int(11) DEFAULT NULL,
  `reservation_id_reservation` int(11) NOT NULL,
  `prestataire_id_prestataire` int(11) DEFAULT NULL,
  `prestataire_ville` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `facturation`
--

INSERT INTO `facturation` (`id_facturation`, `date`, `cout`, `id_user`, `devis`, `reservation_id_reservation`, `prestataire_id_prestataire`, `prestataire_ville`) VALUES
(20, '2020-03-31 00:25:46', 916.5, 11, NULL, 26, NULL, NULL),
(21, '2020-03-31 00:28:02', 0, 11, NULL, 27, NULL, NULL),
(22, '2020-03-31 00:29:11', 18.2, 11, NULL, 28, NULL, NULL),
(23, '2020-03-31 00:29:11', 61.1, 11, NULL, 29, NULL, NULL),
(24, '2020-03-31 00:29:11', 4093.7, 11, NULL, 30, NULL, NULL),
(25, '2020-03-31 00:29:11', 2688.4, 11, NULL, 31, NULL, NULL);

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
  `prix_recurrent` varchar(45) DEFAULT NULL,
  `categorie_ville` varchar(45) NOT NULL,
  `categorie_nom` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prestataire`
--

INSERT INTO `prestataire` (`id_prestataire`, `nom`, `tel_mobile`, `tel_fixe`, `adresse_entreprise`, `url_qrcode`, `prix_heure`, `supplement`, `company_name`, `code_postal`, `email`, `nb_heure_min`, `prix_recurrent`, `categorie_ville`, `categorie_nom`) VALUES
(1, 'SuperPlombier', '0606060606', '0101010101', '8 rue Paris', NULL, 14, '5', 'PlacoBrico', 75001, 'placobrico@brico.com', 1, '10', 'Paris', 'plomberie'),
(2, 'PlombierSuper', '0707070707', '0909090909', '9 rue de Paris', NULL, 14, '5', 'LeroiMerline', 75002, 'Leroy@merlin.com', 1, '10', 'Paris', 'plomberie'),
(3, 'BricoLow', '0000000000', '1111111111', '5 rue de STDN', NULL, 2, '45', 'PaCher', 93000, 'Pa@cher.com', 1, '0.5', 'Paris', 'plomberie');

-- --------------------------------------------------------

--
-- Table structure for table `prestation`
--

CREATE TABLE `prestation` (
  `id_prestation` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `categorie_ville` varchar(45) NOT NULL,
  `categorie_nom` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prestation`
--

INSERT INTO `prestation` (`id_prestation`, `nom`, `description`, `categorie_ville`, `categorie_nom`) VALUES
(1, 'SuperPlombier', 'On vous refait tous', 'Paris', 'plomberie');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int(11) NOT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `nb_heure` int(11) NOT NULL,
  `supplement` text NOT NULL,
  `user_id_user` int(11) NOT NULL,
  `user_ville_reference` varchar(45) NOT NULL,
  `prestation_id_prestation` int(11) NOT NULL,
  `prestation_ville` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `date_debut`, `date_fin`, `nb_heure`, `supplement`, `user_id_user`, `user_ville_reference`, `prestation_id_prestation`, `prestation_ville`) VALUES
(26, '2020-04-08 00:00:00', '2020-04-22 00:00:00', 2, 'Oignon grillé', 11, 'Paris', 1, 'Paris'),
(27, '2020-04-01 00:00:00', '2020-04-16 00:00:00', 1, 'saladetomateoignon', 11, 'Paris', 1, 'Paris'),
(28, '2020-03-31 00:00:00', '2020-03-31 00:00:00', 1, 'aucun', 11, 'Paris', 1, 'Paris'),
(29, '2020-04-01 00:00:00', '2020-04-01 00:00:00', 1, 'Tomate', 11, 'Paris', 1, 'Paris'),
(30, '2020-03-31 00:00:00', '2020-06-05 00:00:00', 20, 'superSalade', 11, 'Paris', 1, 'Paris'),
(31, '2020-03-31 00:00:00', '2020-05-13 00:00:00', 1, 'tomatesalade', 11, 'Paris', 1, 'Paris');

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
(1, '2020-03-30 19:13:52', 12, 10, 'Paris', 'sub_H0S5jdAZmcLVD4'),
(3, '2020-03-30 22:44:54', 1, 11, 'Paris', 'sub_H0VUwqHsXpsgD8');

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
(9, 'Paris', 'Malecot', 'Maxime', '2247aa5d779d2d2384cadf9773dc47b4f73a08270d5365ef72a043df90e41051e19a6c080a690f5b44eabaa28a919853c9d0ed26fa7e4338e281a5a138f57a89', 'maxime92.trap@gmail.com', '2020-03-17 15:27:34', '0659591280', '7 rue trezel', 92300, NULL, NULL),
(10, 'Paris', 'Malecot', 'Maxime', '2247aa5d779d2d2384cadf9773dc47b4f73a08270d5365ef72a043df90e41051e19a6c080a690f5b44eabaa28a919853c9d0ed26fa7e4338e281a5a138f57a89', '92maximemalecot@gmail.com', '2020-03-26 21:06:26', '0659591280', '7 rue trezel', 92300, NULL, 'cus_GyzycjfDFB0zon'),
(11, 'Paris', 'Malecot', 'Maxime', '2247aa5d779d2d2384cadf9773dc47b4f73a08270d5365ef72a043df90e41051e19a6c080a690f5b44eabaa28a919853c9d0ed26fa7e4338e281a5a138f57a89', 'super@maxime.com', '2020-03-29 04:07:12', '0659591280', '7 rue trezel', 92300, 'admin', 'cus_GzqF2W3dISprLY'),
(12, 'Paris', 'Malecot', 'Maxime', '2247aa5d779d2d2384cadf9773dc47b4f73a08270d5365ef72a043df90e41051e19a6c080a690f5b44eabaa28a919853c9d0ed26fa7e4338e281a5a138f57a89', 'super@mail.com', '2020-03-30 19:26:30', '0659591280', '7 rue trezel', 92300, NULL, 'cus_H0SI0EhsUN4aeO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abonnement`
--
ALTER TABLE `abonnement`
  ADD PRIMARY KEY (`id_abonnement`);

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
-- Indexes for table `facturation`
--
ALTER TABLE `facturation`
  ADD PRIMARY KEY (`id_facturation`),
  ADD KEY `fk_facturation_client1_idx` (`id_user`),
  ADD KEY `fk_facturation_reservation1_idx` (`reservation_id_reservation`),
  ADD KEY `fk_facturation_prestataire1_idx` (`prestataire_id_prestataire`,`prestataire_ville`);

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
  ADD KEY `fk_prestation_categorie1_idx` (`categorie_ville`,`categorie_nom`);

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
  MODIFY `id_abonnement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contrat`
--
ALTER TABLE `contrat`
  MODIFY `id_contrat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `demande`
--
ALTER TABLE `demande`
  MODIFY `id_demande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `facturation`
--
ALTER TABLE `facturation`
  MODIFY `id_facturation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `prestataire`
--
ALTER TABLE `prestataire`
  MODIFY `id_prestataire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prestation`
--
ALTER TABLE `prestation`
  MODIFY `id_prestation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `facturation`
--
ALTER TABLE `facturation`
  ADD CONSTRAINT `fk_facturation_client1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_facturation_prestataire1` FOREIGN KEY (`prestataire_id_prestataire`) REFERENCES `prestataire` (`id_prestataire`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_facturation_reservation1` FOREIGN KEY (`reservation_id_reservation`) REFERENCES `reservation` (`id_reservation`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `prestataire`
--
ALTER TABLE `prestataire`
  ADD CONSTRAINT `fk_prestataire_categorie1` FOREIGN KEY (`categorie_ville`,`categorie_nom`) REFERENCES `categorie` (`ville`, `nom`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `prestation`
--
ALTER TABLE `prestation`
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
