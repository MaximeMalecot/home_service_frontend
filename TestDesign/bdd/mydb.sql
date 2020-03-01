-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 01, 2020 at 02:59 PM
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
-- Database: `mydb`
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
  `temps` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `abonnement`
--

INSERT INTO `abonnement` (`id_abonnement`, `nom`, `cout`, `nb_heure`, `temps`) VALUES
(1, 'Abonnement de base', 2400, 12, 5),
(2, 'Abonnement familial', 3600, 25, 6),
(3, 'Abonnement premium', 6000, 50, 7);

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `nom` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`nom`) VALUES
('electric'),
('garde'),
('jardinage'),
('plomberie');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `mdp` varchar(256) DEFAULT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `date_inscription` datetime DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `adresse` varchar(45) DEFAULT NULL,
  `cp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id_client`, `nom`, `prenom`, `mdp`, `mail`, `date_inscription`, `phone`, `adresse`, `cp`) VALUES
(1, 'Malecot', 'Maxime', '2247aa5d779d2d2384cadf9773dc47b4f73a08270d5365ef72a043df90e41051e19a6c080a690f5b44eabaa28a919853c9d0ed26fa7e4338e281a5a138f57a89', '92maximemalecot@gmail.com', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contrat`
--

CREATE TABLE `contrat` (
  `id_contrat` int(11) NOT NULL,
  `duree` int(11) DEFAULT NULL,
  `path_contrat` varchar(45) DEFAULT NULL,
  `prestataire_id_prestataire` int(11) NOT NULL,
  `salaire` float DEFAULT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `facturation`
--

CREATE TABLE `facturation` (
  `id_facturation` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `cout` float DEFAULT NULL,
  `client_id_client` int(11) NOT NULL,
  `prestataire_id_prestataire` int(11) DEFAULT NULL,
  `devis` int(11) DEFAULT NULL,
  `reservation_id_reservation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `ville` varchar(45) DEFAULT NULL,
  `company_name` varchar(45) DEFAULT NULL,
  `code_postal` int(11) DEFAULT NULL,
  `categorie_nom` varchar(45) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `nb_heure_min` float DEFAULT NULL,
  `prix_recurrent` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prestation`
--

CREATE TABLE `prestation` (
  `id_prestation` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `categorie_nom` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prestation`
--

INSERT INTO `prestation` (`id_prestation`, `nom`, `description`, `categorie_nom`) VALUES
(1, 'garde temps plein', 'super garde faites par des passionés', 'garde'),
(2, 'jardinage de grande surface', 'on peut s\'occuper de tous vos jardins et plantes', 'jardinage');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int(11) NOT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `prestation_id_prestation` int(11) NOT NULL,
  `client_id_client` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `souscription`
--

CREATE TABLE `souscription` (
  `client_id_client` int(11) NOT NULL,
  `abonnement_id_abonnement` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `heure_restante` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `souscription`
--

INSERT INTO `souscription` (`client_id_client`, `abonnement_id_abonnement`, `date`, `heure_restante`) VALUES
(1, 2, '2020-03-01 00:00:00', 50);

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
  ADD PRIMARY KEY (`nom`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`);

--
-- Indexes for table `contrat`
--
ALTER TABLE `contrat`
  ADD PRIMARY KEY (`id_contrat`),
  ADD KEY `fk_contrat_prestataire1_idx` (`prestataire_id_prestataire`);

--
-- Indexes for table `facturation`
--
ALTER TABLE `facturation`
  ADD PRIMARY KEY (`id_facturation`),
  ADD KEY `fk_facturation_client1_idx` (`client_id_client`),
  ADD KEY `fk_facturation_prestataire1_idx` (`prestataire_id_prestataire`),
  ADD KEY `fk_facturation_reservation1_idx` (`reservation_id_reservation`);

--
-- Indexes for table `prestataire`
--
ALTER TABLE `prestataire`
  ADD PRIMARY KEY (`id_prestataire`),
  ADD KEY `fk_prestataire_categorie1_idx` (`categorie_nom`);

--
-- Indexes for table `prestation`
--
ALTER TABLE `prestation`
  ADD PRIMARY KEY (`id_prestation`),
  ADD KEY `fk_prestation_categorie1_idx` (`categorie_nom`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `fk_reservation_prestation1_idx` (`prestation_id_prestation`),
  ADD KEY `fk_reservation_client1_idx` (`client_id_client`);

--
-- Indexes for table `souscription`
--
ALTER TABLE `souscription`
  ADD PRIMARY KEY (`client_id_client`,`abonnement_id_abonnement`),
  ADD KEY `fk_client_has_abonnement_abonnement1_idx` (`abonnement_id_abonnement`),
  ADD KEY `fk_client_has_abonnement_client1_idx` (`client_id_client`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abonnement`
--
ALTER TABLE `abonnement`
  MODIFY `id_abonnement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contrat`
--
ALTER TABLE `contrat`
  MODIFY `id_contrat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facturation`
--
ALTER TABLE `facturation`
  MODIFY `id_facturation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prestataire`
--
ALTER TABLE `prestataire`
  MODIFY `id_prestataire` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prestation`
--
ALTER TABLE `prestation`
  MODIFY `id_prestation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contrat`
--
ALTER TABLE `contrat`
  ADD CONSTRAINT `fk_contrat_prestataire1` FOREIGN KEY (`prestataire_id_prestataire`) REFERENCES `prestataire` (`id_prestataire`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `facturation`
--
ALTER TABLE `facturation`
  ADD CONSTRAINT `fk_facturation_client1` FOREIGN KEY (`client_id_client`) REFERENCES `client` (`id_client`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_facturation_prestataire1` FOREIGN KEY (`prestataire_id_prestataire`) REFERENCES `prestataire` (`id_prestataire`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_facturation_reservation1` FOREIGN KEY (`reservation_id_reservation`) REFERENCES `reservation` (`id_reservation`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `prestataire`
--
ALTER TABLE `prestataire`
  ADD CONSTRAINT `fk_prestataire_categorie1` FOREIGN KEY (`categorie_nom`) REFERENCES `categorie` (`nom`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `prestation`
--
ALTER TABLE `prestation`
  ADD CONSTRAINT `fk_prestation_categorie1` FOREIGN KEY (`categorie_nom`) REFERENCES `categorie` (`nom`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_reservation_client1` FOREIGN KEY (`client_id_client`) REFERENCES `client` (`id_client`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reservation_prestation1` FOREIGN KEY (`prestation_id_prestation`) REFERENCES `prestation` (`id_prestation`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `souscription`
--
ALTER TABLE `souscription`
  ADD CONSTRAINT `fk_client_has_abonnement_abonnement1` FOREIGN KEY (`abonnement_id_abonnement`) REFERENCES `abonnement` (`id_abonnement`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_client_has_abonnement_client1` FOREIGN KEY (`client_id_client`) REFERENCES `client` (`id_client`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
