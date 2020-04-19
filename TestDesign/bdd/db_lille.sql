-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 19, 2020 at 10:42 PM
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
(1, 'Lille', 'Plomberie', 1, 'Lille', 'Plomberie'),
(2, 'Lille', 'Administratif', 2, 'Lille', 'Administratif'),
(3, 'Lille', 'Plomberie', 1, 'Lille', 'Plomberie');

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
(1, 'heure', 20, 18, 5, 1),
(2, 'document', 25, 22, 3, 0.5);

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
('Plomberie', 'Lille');

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
(5, '2020-04-19 23:28:47', 54, 1, 5, 3, 'Lille');

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
(1, '2020-04-19 08:00:00', '2020-04-19 10:00:00', 3, 'Lille', 'Plomberie'),
(2, '2020-04-20 13:00:00', '2020-04-20 17:00:00', 3, 'Lille', 'Plomberie'),
(3, '2020-04-21 13:00:00', '2020-04-21 17:00:00', 3, 'Lille', 'Plomberie'),
(4, '2020-04-22 13:00:00', '2020-04-22 17:00:00', 3, 'Lille', 'Plomberie'),
(5, '2020-04-23 13:00:00', '2020-04-23 17:00:00', 3, 'Lille', 'Plomberie'),
(6, '2020-04-20 09:00:00', '2020-04-20 14:15:00', 1, 'Lille', 'Plomberie'),
(8, '2020-04-21 09:00:00', '2020-04-21 14:00:00', 1, 'Lille', 'Plomberie'),
(9, '2020-04-19 05:00:00', '2020-04-19 18:00:00', 1, 'Lille', 'Plomberie');

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
(1, 'SuperPlombier', '0606060606', '0101010101', '5 rue de STDN', NULL, 6, 'Par outils 4 euros', NULL, 75000, 'Leroy@merlin.com', 3, '5', 'Lille', 'Plomberie'),
(2, 'SecretaireSpe', '0707070707', '0909090909', '4 place jeola', NULL, 3, 'Par visa 5euros', NULL, 60000, 'super@secretaire.com', 3, '2', 'Lille', 'Administratif'),
(3, 'PlombierTest', '0707070707', '0101010101', '9 rue de Paris', NULL, 1, NULL, 'PaCher', 55555, 'Plombier@test.com', 1, '1', 'Lille', 'Plomberie');

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
(2, 'Secretariat', 'Tous vos documents sont bien avec nous', 'Lille', 'Administratif', 2);

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
(5, '2020-04-19 11:00:00', '2020-04-19 14:00:00', 3, 1, 1, 'Paris', 1, 'Lille', 0);

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
  MODIFY `id_abonnement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bareme`
--
ALTER TABLE `bareme`
  MODIFY `id_bareme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contrat`
--
ALTER TABLE `contrat`
  MODIFY `id_contrat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `demande`
--
ALTER TABLE `demande`
  MODIFY `id_demande` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facturation`
--
ALTER TABLE `facturation`
  MODIFY `id_facturation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `planning`
--
ALTER TABLE `planning`
  MODIFY `id_planning` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `prestataire`
--
ALTER TABLE `prestataire`
  MODIFY `id_prestataire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prestation`
--
ALTER TABLE `prestation`
  MODIFY `id_prestation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
