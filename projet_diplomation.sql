-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 19 juin 2025 à 17:33
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_diplomation`
--

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `id` int(4) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `sexe` enum('M','F') DEFAULT NULL,
  `lieu_naissance` varchar(100) DEFAULT NULL,
  `MATRICULE` varchar(7) NOT NULL,
  `groupe` int(11) DEFAULT NULL,
  `filiere_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `nom`, `prenom`, `date_naissance`, `sexe`, `lieu_naissance`, `MATRICULE`, `groupe`, `filiere_id`) VALUES
(1, 'MOUHAMADOU', 'EL MOUHTAR', '2006-04-08', 'M', 'Yaoundé', '24X9001', 1, 1),
(2, 'Nguema', 'Aristide kevin', '2002-10-10', 'M', 'Yaoundé', '24X9002', 1, 1),
(3, 'Monkama Adoube', 'Durel', '2005-09-14', 'M', 'Yaoundé', '24X9003', 1, 1),
(4, 'Kouogang', 'Leny roussel', '2005-03-03', 'M', 'Yaounde 5', '24H2145', 1, 1),
(5, 'MOUDANG NOAH', 'ESAI ESPERANZO', '2006-06-23', 'M', 'OBALA', '24X9004', 1, 1),
(6, 'KOUAWA FOBA', 'BENJAMIN', '2004-06-23', 'M', 'Yaoundé', '24G2425', 1, 1),
(7, 'MAFEUKAM TAKOUKAM', 'Rameline', '2005-05-25', 'F', 'Bameka', '24H2077', 2, 1),
(8, 'NDOUANLA', 'AKIl YVON', '2007-07-31', 'M', 'Bafang', '24H2091', 1, 1),
(9, 'Mbodiam', 'Raymonde Maurane', '2006-01-06', 'F', 'Yaoundé', '24H2528', 1, 1),
(10, 'Eyebe', 'Germaine Prisca', '2008-05-10', 'F', 'Yaoundé', '24H2116', 1, 1),
(11, 'MOUHAMADOU', 'EL MOUHTAR', '2006-04-08', 'M', 'Yaounde', '24H2149', 1, 1),
(12, 'SINENG KENGNI', 'JUVENAL', '2006-06-20', 'M', 'CMP DE PENKA-MICHEL', '24H2194', 1, 1),
(13, 'NDANGA WANDJI', 'STEEV HARRY', '2006-01-29', 'M', 'Yaoundé', '24H2289', 2, 1),
(14, 'NNANGA', 'CLARISSE GLORIEUSE', '2005-12-13', 'F', 'Yaoundé', '24H2023', 1, 1),
(15, 'KOUAWA FOBA', 'BENJAMIN', '2004-06-23', 'M', 'YAOUNDÉ', '24G2425', 1, 1),
(16, 'FOSSONG TSOFACK', 'PATRICIA', '2007-10-10', 'F', 'BUBA 1', '24G2975', 1, 1),
(17, 'Djikap Moyo', 'Ange Prisca', '2009-12-14', 'F', 'Yaounde', '24G2004', 1, 1),
(18, 'TCHOUTA HAPPI', 'CLAUDE ARIELLE', '2006-05-06', 'F', 'YAOUNDÉ', '24G2523', 1, 1),
(19, 'TAGNE FONO', 'DAVID NICAULD', '2007-03-01', 'M', 'yaounde 5', '24H2005', 1, 1),
(20, 'MAFEUKAM TAKOUKAM', 'Rameline', '2005-05-25', 'F', 'Bameka', '24H2077', 2, 1),
(21, 'Fouepi Tchatchueng', 'Jadone Naomie', '2007-01-25', 'F', 'Bamenda', '24H2159', 1, 1),
(22, 'FOMBEN CHAGHEN', 'Hilaire', '1997-03-10', 'M', 'MBOUDA', '24H2173', 2, 1),
(23, 'Ngou Mambunji', 'Jojo', '2005-01-28', 'M', 'Foumban', '24H2056', 1, 1),
(24, 'GBETNKOM FESSAL', 'SAID', '2006-08-13', 'M', 'Koutaba', '24H2073', 1, 1),
(25, 'MENGUE NOUMEUMEU', 'MAXIME RAYAN', '2006-10-19', 'M', 'Yaoundé', '24F2973', 1, 1),
(26, 'NGOMSI PAGUIE', 'YVAN', '2005-10-02', 'M', 'YAOUNDÉ', '23U2405', 2, 1),
(27, 'Ottam Bagneken', 'Emmanuelle larissa', '2008-01-23', 'F', 'Yaoundé', '24H2244', 1, 1),
(28, 'BISCIONGOL UDOKA', 'CASSIDY ELISABETH', '2007-01-03', 'F', 'Yaoundé', '23U2329', 2, 1),
(29, 'Demanou Kenfack', 'Ange Trecy', '2005-07-25', 'F', 'Nkongsamba', '24H2247', 1, 1),
(30, 'Kenfack Momo', 'Yvana', '2004-09-26', 'F', 'Yaoundé', '24W2250', 2, 1),
(31, 'Batchamen', 'Joram Maël', '2005-04-17', 'M', 'Yaounde', '24H2191', 1, 1),
(32, 'Ndouceu ndoumi', 'Raissa', '2006-04-19', 'F', 'Ngaoundere', '24G2512', 2, 1),
(33, 'SOKENG FANDO', 'FRANCK RAYAN', '2006-05-01', 'M', 'YAOUNDÉ 5IEME', '24G2754', 1, 1),
(34, 'TENKAM', 'BENITO BRYAN', '2007-07-15', 'M', 'YAOUNDE', '24G2998', 1, 1),
(35, 'NGUETEU', 'VIANNEY', '2005-09-27', 'M', 'CSI de Lingang-foto', '24H2192', 1, 1),
(36, 'DIPITA EBONGUE', 'ALBERT CLAUDE VALDEZ', '2007-08-07', 'M', 'Yaoundé', '23V2314', 2, 1),
(37, 'NGEM', 'EMMANUELLA', '2003-12-24', 'F', 'ADUK', '24H2279', 2, 1),
(38, 'DJEUTCHOU', 'RUXEL', '2006-09-08', 'M', 'NKONGSAMBA', '24H2253', 2, 1),
(39, 'Kenfack Momo', 'Ruchi valdo', '2003-01-19', 'M', 'Banka-bafang', '24H2221', 1, 1),
(40, 'EPOGE KANG', 'LESLIE OJEH', '2010-09-08', 'M', 'POALA NHIA', '24H2082', 2, 1),
(41, 'YOGO', 'Victorine', '2006-11-24', 'F', 'Libamba', '24H2103', 1, 1),
(42, 'Moulema Onguene', 'Lysette Lorraine', '2008-05-16', 'F', 'Yaoundé', '24H2147', 2, 1),
(43, 'ABDELMALICK', 'MAHAMAT SALEH', '2004-05-15', 'M', 'ABECHE', '24G2658', 2, 1),
(44, 'MOUDANG NOAH', 'ESAI ESPERANZO', '2006-09-23', 'M', 'OBALA', '24h2134', 1, 1),
(45, 'Baniem', 'Elise Jessica', '2006-06-02', 'F', 'Yaoundé', '24H2291', 1, 1),
(46, 'NJONTU SOH', 'TEDDY FRANCK', '2004-08-17', 'M', 'YAOUNDE', '24H2102', 2, 1),
(47, 'KEMGANG FOKOU', 'PATRICK EVRARD', '2006-02-14', 'M', 'Yaoundé', '24H2088', 2, 1),
(48, 'DJOMGOUÉ', 'MIGUEL FRANK', '2007-09-05', 'M', 'YAOUNDÉ', '24H2449', 2, 1),
(49, 'OMGBA BIDJA', 'ULRICH JORDAN', '2007-05-22', 'M', 'NKOABANG', '24H2246', 2, 1),
(50, 'FEBNCHAK MFOUT', 'Borelle Sandra', '2005-03-09', 'F', 'Ngaoundere', '24H2127', 1, 1),
(51, 'MOUHAMADOU', 'EL MOUHTAR', '2006-04-08', 'M', 'Yaoundé', '44F5535', 1, 1),
(52, 'SINENG KENGNI', 'JUVENAL', '2025-06-04', 'M', 'momomomo', '', NULL, 1),
(53, 'SINENG KENGNI', 'JUVENAL', '2006-06-20', 'M', 'momomomo', '', NULL, 1),
(54, 'SINENG KENGNI', 'JUVENAL', '2025-06-13', 'M', 'momomomo', '', NULL, 2),
(55, 'mnyt', 'wfyko', '2025-06-05', 'F', 'momomomo', '', NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `etudiant_piece`
--

CREATE TABLE `etudiant_piece` (
  `id` int(11) NOT NULL,
  `id_etudiant` int(11) DEFAULT NULL,
  `id_piece` int(11) DEFAULT NULL,
  `statut` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiant_piece`
--

INSERT INTO `etudiant_piece` (`id`, `id_etudiant`, `id_piece`, `statut`) VALUES
(1, 17, 1, 1),
(2, 17, 2, 1),
(3, 17, 1, 1),
(4, 17, 2, 1),
(5, 17, 1, 1),
(6, 17, 2, 1),
(7, 17, 1, 1),
(8, 17, 2, 1),
(9, 17, 1, 1),
(10, 17, 2, 1),
(11, 17, 5, 1),
(12, 43, 1, 1),
(13, 43, 2, 1),
(14, 43, 3, 1),
(15, 43, 4, 1),
(16, 43, 5, 1),
(17, 43, 1, 1),
(18, 43, 2, 1),
(19, 43, 3, 1),
(20, 43, 4, 1),
(21, 43, 5, 1),
(22, 10, 1, 1),
(23, 10, 2, 1),
(24, 10, 3, 1),
(25, 10, 4, 1),
(26, 10, 5, 1),
(27, 10, 1, 1),
(28, 10, 2, 1),
(29, 10, 3, 1),
(30, 10, 4, 1),
(31, 10, 5, 1),
(32, 45, 1, 1),
(33, 45, 2, 1),
(34, 45, 3, 1),
(35, 45, 4, 1),
(36, 45, 5, 1),
(37, 45, 1, 1),
(38, 45, 2, 1),
(39, 45, 3, 1),
(40, 45, 4, 1),
(41, 45, 5, 1),
(42, 48, 1, 1),
(43, 48, 2, 1),
(44, 48, 3, 1),
(45, 48, 4, 1),
(46, 48, 5, 1),
(47, 48, 1, 1),
(48, 48, 2, 1),
(49, 48, 3, 1),
(50, 48, 4, 1),
(51, 48, 5, 1),
(52, 43, 1, 1),
(53, 43, 2, 1),
(54, 43, 3, 1),
(55, 43, 4, 1),
(56, 43, 5, 1),
(57, 52, 1, 0),
(58, 52, 2, 0),
(59, 52, 3, 0),
(60, 52, 4, 0),
(61, 52, 5, 0),
(62, 53, 1, 0),
(63, 53, 2, 0),
(64, 53, 3, 0),
(65, 53, 4, 0),
(66, 53, 5, 0),
(67, 52, 1, 1),
(68, 52, 2, 1),
(69, 54, 1, 1),
(70, 54, 2, 1),
(71, 54, 3, 1),
(72, 54, 4, 1),
(73, 54, 5, 0),
(74, 54, 1, 1),
(75, 54, 2, 1),
(76, 54, 3, 1),
(77, 54, 4, 1),
(78, 54, 5, 0),
(79, 54, 1, 1),
(80, 54, 1, 1),
(81, 54, 2, 1),
(82, 54, 2, 1),
(83, 54, 3, 1),
(84, 54, 3, 1),
(85, 54, 4, 1),
(86, 54, 4, 1),
(87, 54, 5, 0),
(88, 54, 5, 0),
(89, 54, 1, 1),
(90, 54, 1, 1),
(91, 54, 1, 1),
(92, 54, 1, 1),
(93, 54, 2, 1),
(94, 54, 2, 1),
(95, 54, 2, 1),
(96, 54, 2, 1),
(97, 54, 3, 1),
(98, 54, 3, 1),
(99, 54, 3, 1),
(100, 54, 3, 1),
(101, 54, 4, 1),
(102, 54, 4, 1),
(103, 54, 4, 1),
(104, 54, 4, 1),
(105, 54, 5, 1),
(106, 54, 5, 1),
(107, 54, 5, 1),
(108, 54, 5, 1),
(109, 54, 1, 1),
(110, 54, 1, 1),
(111, 54, 1, 1),
(112, 54, 1, 1),
(113, 54, 1, 1),
(114, 54, 1, 1),
(115, 54, 1, 1),
(116, 54, 1, 1),
(117, 54, 2, 1),
(118, 54, 2, 1),
(119, 54, 2, 1),
(120, 54, 2, 1),
(121, 54, 2, 1),
(122, 54, 2, 1),
(123, 54, 2, 1),
(124, 54, 2, 1),
(125, 54, 3, 1),
(126, 54, 3, 1),
(127, 54, 3, 1),
(128, 54, 3, 1),
(129, 54, 3, 1),
(130, 54, 3, 1),
(131, 54, 3, 1),
(132, 54, 3, 1),
(133, 54, 4, 1),
(134, 54, 4, 1),
(135, 54, 4, 1),
(136, 54, 4, 1),
(137, 54, 4, 1),
(138, 54, 4, 1),
(139, 54, 4, 1),
(140, 54, 4, 1),
(141, 54, 5, 1),
(142, 54, 5, 1),
(143, 54, 5, 1),
(144, 54, 5, 1),
(145, 54, 5, 1),
(146, 54, 5, 1),
(147, 54, 5, 1),
(148, 54, 5, 1),
(149, 54, 1, 1),
(150, 54, 1, 1),
(151, 54, 1, 1),
(152, 54, 1, 1),
(153, 54, 1, 1),
(154, 54, 1, 1),
(155, 54, 1, 1),
(156, 54, 1, 1),
(157, 54, 1, 1),
(158, 54, 1, 1),
(159, 54, 1, 1),
(160, 54, 1, 1),
(161, 54, 1, 1),
(162, 54, 1, 1),
(163, 54, 1, 1),
(164, 54, 1, 1),
(165, 54, 2, 1),
(166, 54, 2, 1),
(167, 54, 2, 1),
(168, 54, 2, 1),
(169, 54, 2, 1),
(170, 54, 2, 1),
(171, 54, 2, 1),
(172, 54, 2, 1),
(173, 54, 2, 1),
(174, 54, 2, 1),
(175, 54, 2, 1),
(176, 54, 2, 1),
(177, 54, 2, 1),
(178, 54, 2, 1),
(179, 54, 2, 1),
(180, 54, 2, 1),
(181, 54, 3, 1),
(182, 54, 3, 1),
(183, 54, 3, 1),
(184, 54, 3, 1),
(185, 54, 3, 1),
(186, 54, 3, 1),
(187, 54, 3, 1),
(188, 54, 3, 1),
(189, 54, 3, 1),
(190, 54, 3, 1),
(191, 54, 3, 1),
(192, 54, 3, 1),
(193, 54, 3, 1),
(194, 54, 3, 1),
(195, 54, 3, 1),
(196, 54, 3, 1),
(197, 54, 4, 1),
(198, 54, 4, 1),
(199, 54, 4, 1),
(200, 54, 4, 1),
(201, 54, 4, 1),
(202, 54, 4, 1),
(203, 54, 4, 1),
(204, 54, 4, 1),
(205, 54, 4, 1),
(206, 54, 4, 1),
(207, 54, 4, 1),
(208, 54, 4, 1),
(209, 54, 4, 1),
(210, 54, 4, 1),
(211, 54, 4, 1),
(212, 54, 4, 1),
(213, 54, 5, 1),
(214, 54, 5, 1),
(215, 54, 5, 1),
(216, 54, 5, 1),
(217, 54, 5, 1),
(218, 54, 5, 1),
(219, 54, 5, 1),
(220, 54, 5, 1),
(221, 54, 5, 1),
(222, 54, 5, 1),
(223, 54, 5, 1),
(224, 54, 5, 1),
(225, 54, 5, 1),
(226, 54, 5, 1),
(227, 54, 5, 1),
(228, 54, 5, 1),
(229, 55, 1, 1),
(230, 55, 2, 0),
(231, 55, 3, 1),
(232, 55, 4, 0),
(233, 55, 5, 1),
(234, 45, 1, 1),
(235, 45, 2, 1),
(236, 45, 3, 1),
(237, 45, 4, 1),
(238, 45, 5, 1),
(239, 45, 1, 1),
(240, 45, 2, 1),
(241, 45, 3, 1),
(242, 45, 4, 1),
(243, 45, 5, 1),
(244, 45, 1, 1),
(245, 45, 2, 1),
(246, 45, 3, 1),
(247, 45, 4, 1),
(248, 45, 5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `filieres`
--

CREATE TABLE `filieres` (
  `id` int(11) NOT NULL,
  `nom_filiere` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `filieres`
--

INSERT INTO `filieres` (`id`, `nom_filiere`) VALUES
(1, 'ICT'),
(2, 'FONDAMENTALE');

-- --------------------------------------------------------

--
-- Structure de la table `pieces`
--

CREATE TABLE `pieces` (
  `id` int(11) NOT NULL,
  `nom_piece` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `pieces`
--

INSERT INTO `pieces` (`id`, `nom_piece`) VALUES
(1, 'Acte de naissance'),
(2, 'Baccalauréat certifié conforme'),
(3, 'Relevés de notes certifiés L1, L2, L3'),
(4, 'Reçu de paiement'),
(5, 'Fiche d’inscription académique');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `created_at`) VALUES
(1, 'SINENG KENGNI', NULL, 'sinengjuvenal@gmail.com', '$2y$10$qRoESA/HnQyLyTc/efkn.uUHJeq9DJ.fbqUttVLIcsjIXOzsJaLqS', '2025-06-19 12:30:05'),
(2, 'Baniem', NULL, 'sinengjuv@gmail.com', '$2y$10$x9LeN9HHL39sTk3fNxZHk.fCmZKTFhy9ETgFsD5uB1X/.ObvKsK06', '2025-06-19 13:57:51'),
(3, 'eric mukoko', NULL, 'mokoko@gmail.com', '$2y$10$ZzHS0XrLzuHfRLzvsyOih.Mi..EoUzqHceTx/4raVgSg0w4nvLxLG', '2025-06-19 14:25:52');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `filiere_id` (`filiere_id`);

--
-- Index pour la table `etudiant_piece`
--
ALTER TABLE `etudiant_piece`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_etudiant` (`id_etudiant`),
  ADD KEY `id_piece` (`id_piece`);

--
-- Index pour la table `filieres`
--
ALTER TABLE `filieres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pieces`
--
ALTER TABLE `pieces`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT pour la table `etudiant_piece`
--
ALTER TABLE `etudiant_piece`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT pour la table `filieres`
--
ALTER TABLE `filieres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `pieces`
--
ALTER TABLE `pieces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD CONSTRAINT `etudiants_ibfk_1` FOREIGN KEY (`filiere_id`) REFERENCES `filieres` (`id`);

--
-- Contraintes pour la table `etudiant_piece`
--
ALTER TABLE `etudiant_piece`
  ADD CONSTRAINT `etudiant_piece_ibfk_1` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id`),
  ADD CONSTRAINT `etudiant_piece_ibfk_2` FOREIGN KEY (`id_piece`) REFERENCES `pieces` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
