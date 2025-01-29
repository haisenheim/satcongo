-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 29 jan. 2025 à 12:47
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `satcongo_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `agents`
--

CREATE TABLE `agents` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `site_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `agents`
--

INSERT INTO `agents` (`id`, `name`, `phone`, `active`, `site_id`) VALUES
(1, 'NGOMA SYLVAIN', '05893284', 1, 0),
(2, 'MASSALA AUBIN', '065456326', 1, 0),
(3, 'MOUSSAVOU Pierre', '067329389', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `caisses`
--

CREATE TABLE `caisses` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `compte` varchar(20) DEFAULT NULL,
  `solde` double NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `site_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `caisses`
--

INSERT INTO `caisses` (`id`, `name`, `code`, `compte`, `solde`, `active`, `site_id`) VALUES
(1, 'B.D.R', 'B.D.R', '521400', -55066800, 1, 0),
(2, 'OPERATIONS BCI', 'BCI', '521100', 0, 1, 0),
(3, 'OPERATIONS BGFI', 'BGFI', '521200', -7000, 1, 0),
(4, 'OPERATION BPC', 'BPC', '521600', -2205237740, 1, 0),
(5, 'OPERATIONS BSCA', 'BSCA', '521300', -37629959, 1, 0),
(6, 'CAISSE PRINCIPALE', 'CAI1', '571100', -400000, 1, 0),
(7, 'CAISSE TRANSPORT', 'CAI1T', '571110', -4656000, 1, 0),
(8, 'CAISSE TRANSIT PNR', 'CAI2', '571200', -82508400, 1, 0),
(9, 'CAISSE BZV', 'CAI3', '571300', -15542300, 1, 0),
(10, 'CAISSE MENUISERIE', 'CAI4', '571400', 0, 1, 0),
(11, 'CAISSE SHIPPING', 'CAI5', '571500', 0, 1, 0),
(12, 'OPERATIONS LCB', 'LCB', '521500', 0, 1, 0),
(13, 'OPERATIONS UBA', 'U.B.A', '521700', 0, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `caisses_comptes`
--

CREATE TABLE `caisses_comptes` (
  `id` int(11) NOT NULL,
  `compte_id` int(11) NOT NULL DEFAULT 0,
  `caisse_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `caisses_comptes`
--

INSERT INTO `caisses_comptes` (`id`, `compte_id`, `caisse_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 3, 4),
(8, 6, 4),
(9, 10, 5),
(10, 10, 8),
(11, 12, 8),
(12, 21, 8);

-- --------------------------------------------------------

--
-- Structure de la table `caisses_users`
--

CREATE TABLE `caisses_users` (
  `id` int(11) NOT NULL,
  `caisse_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `caisses_users`
--

INSERT INTO `caisses_users` (`id`, `caisse_id`, `user_id`) VALUES
(1, 1, 3),
(2, 5, 3),
(3, 8, 3);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `compte` varchar(30) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `site_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `name`, `code`, `compte`, `phone`, `email`, `site_id`, `user_id`, `created_at`, `updated_at`, `token`) VALUES
(1, 'DHL', NULL, NULL, '073273298', 'info@dhl.com', 1, 7, '2025-01-23 16:25:13', '2025-01-23 16:25:13', NULL),
(2, 'Volvo', NULL, NULL, '0673923883', 'contact@volvo.com', 1, 7, '2025-01-23 16:26:20', '2025-01-23 16:26:20', NULL),
(3, 'SMT', 'SMT', '632453', '06784394', 'info@smt.cg', 1, 7, '2025-01-23 17:12:35', '2025-01-23 17:12:35', NULL),
(4, 'Africa Airlaines', 'AFA56768', '5347438783', '0678788989', 'info@africa-air.com', 1, 7, '2025-01-23 18:17:11', '2025-01-23 18:17:11', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

CREATE TABLE `comptes` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `credit` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `comptes`
--

INSERT INTO `comptes` (`id`, `code`, `name`, `active`, `credit`) VALUES
(1, '585000', 'APPRO CAISSE', 1, 1),
(2, '411100', 'CLIENTS', 1, 1),
(3, '401100', 'FOURNISSEURS', 1, 1),
(4, '585000', 'VERSEMENT DES CLIENTS ', 1, 1),
(5, '421100', 'AV SUR SALAIRE', 1, 1),
(6, '471300', 'FRAIS IMPUTER', 1, 1),
(7, '411120', 'CLTS REGLEMENTS FACTURES', 1, 1),
(8, '411120', 'CLTS REGLEMENTS FACTURES', 1, 1),
(9, '275108', 'CAUTION HAPAG-LLOYD CG', 1, 1),
(10, '401100', 'CESSION DOCUMENTAIRE', 1, 1),
(11, '604710', 'CONSOMMABLE INFORMATIQUE', 1, 1),
(12, '401110', 'OXYGENE + ACETYLENE', 1, 1),
(13, '663820', 'FRAIS EXPATRIES', 1, 1),
(14, '667100', 'MANUTENTION -POINTEUR', 1, 1),
(15, '585000', 'RAVITAILLEMENT CAISSE TRANSPORT', 1, 1),
(16, '585000', 'RAVITAILLEMENT CAISSE TRANSIT', 1, 1),
(17, '411120', 'RAVITAILLEMENT CAISSE SAT BZV', 1, 1),
(18, '585000', 'RAVITAILLEMENT CAISSE SHIPPING', 1, 1),
(19, '663810', 'EQUIPEMENT ET PROTECTION', 1, 1),
(20, '585000', 'VERSEMENT ESPECES EN BQUE', 1, 1),
(21, '663820', 'FRAIS EXPATRIES', 1, 1),
(22, '632804', 'FRAIS DIVERS', 1, 1),
(23, '632800', 'ACCES AU SITE GUOT', 1, 1),
(24, '632800', 'ACCES ZONE FRET', 1, 1),
(25, '470100', 'ACCORD IM9', 1, 1),
(26, '470100', 'ACCORD SOUSCRIPTION', 1, 1),
(27, '470100', 'ACCORD TRANSACTION', 1, 1),
(28, '605600', 'ACHAT CABLE ALIMNETATION', 1, 1),
(29, '605800', 'ACHAT CABLE RESEAU', 1, 1),
(30, '604100', 'ACHAT CARTOUCHE CANON', 1, 1),
(31, '605300', 'CARBURANT VEHICULES', 1, 1),
(32, '604700', 'ACHAT CARNET TEL KOUILOU', 1, 1),
(33, '628110', 'ACHAT CREDIT DE COMMUNICATION', 1, 1),
(34, '605100', 'ACHAT EAU AEROPORT', 1, 1),
(35, '604100', 'ACHAT ENCRE', 1, 1),
(36, '604700', 'ACHAT FOURNITURES DE BUREAU', 1, 1),
(37, '244200', 'ACHAT ORDINATEUR', 1, 1),
(38, '618300', 'TAXI ALLER - RETOUR', 1, 1),
(39, '661300', 'ALLOCATION CONGES', 1, 1),
(40, '470100', 'ANNULATION DE', 1, 1),
(41, '470100', 'APUREMENT DEPOT DOUANE', 1, 1),
(42, '421000', 'AVANCE SALAIRE', 1, 1),
(43, '470100', 'BULL D\'ESCORTE - VU EMBARQUE', 1, 1),
(44, '470100', 'BULL ESCORT - PRISE CHARGE', 1, 1),
(45, '470100', 'CERTIFICAT DEMENAGEMENT', 1, 1),
(46, '470100', 'CERTIFICAT EMPOTAGE', 1, 1),
(47, '632800', 'CHARGE TRANSIT', 1, 1),
(48, '605700', 'COFECTION CARTES VISITE', 1, 1),
(49, '401100', 'DROITS  ET TAXES', 1, 1),
(50, '470100', 'COMPL PMT PROROGATION', 1, 1),
(51, '470100', 'COMPL PRISE CHARGE DOUANIER', 1, 1),
(52, '470100', 'COMPLE FR SOUSCRIPTION', 1, 1),
(53, '470100', 'COMPLEM PMT TRANSACTION', 1, 1),
(54, '470100', 'COMPLEMENT ESCORTE', 1, 1),
(55, '624300', 'CONFIGURATION ROUTER', 1, 1),
(56, '628810', 'CONNEXION INTERNET', 1, 1),
(57, '275850', 'CONSIGNATION D T DOUANE', 1, 1),
(58, '470100', 'CONTRE ECRITURE', 1, 1),
(59, '470100', 'COUPURE PLOMB', 1, 1),
(60, '470100', 'DEMANDE OUVERT BUREAU', 1, 1),
(61, '421000', 'DEMANDE PRÊT', 1, 1),
(62, '470100', 'DEPLACEM DOUANIER', 1, 1),
(63, '618100', 'DEPLACEMENT GUOT', 1, 1),
(64, '632800', 'DEPOTAGE', 1, 1),
(65, '605600', 'DEVIS DE COMPTOIRE DHL', 1, 1),
(66, '470100', 'ESCORTE ZP', 1, 1),
(67, '470100', 'ESCORTE AEROPORT', 1, 1),
(68, '470100', 'ESCORTE EN ZU', 1, 1),
(69, '470100', 'ESCORTE', 1, 1),
(70, '470100', 'FORMALITES', 1, 1),
(71, '470100', 'LOCATION HYSTER', 1, 1),
(72, '470100', 'FRAIS CERTIFICAT ORIGINE', 1, 1),
(73, '632801', 'FRAIS DIVERS TRANSPORT', 1, 1),
(74, '275850', 'FRAIS CONSIGNATION', 1, 1),
(75, '638300', 'FRAIS DIRECTION', 1, 1),
(76, '470100', 'FRAIS LTA', 1, 1),
(77, '470100', 'FRAIS MAGASINAGE', 1, 1),
(78, '470800', 'FRAIS PEAGE', 1, 1),
(79, '470100', 'FRAIS SAISIE DI', 1, 1),
(80, '401100', 'FRAIS SGED', 1, 1),
(81, '622300', 'LOCATION ENGIN', 1, 1),
(82, '470100', 'LOCATION HYSTER', 1, 1),
(83, '470100', 'NEGOCIATION OUVERT BUREAU', 1, 1),
(84, '470100', 'OPERATION FACTURE MAERSK', 1, 1),
(85, '470100', 'PASSAGE DOUANE', 1, 1),
(86, '605100', 'PMT BOMBONNES EAU', 1, 1),
(87, '401100', 'PAIEMENT SURESTARIE', 1, 1),
(88, '628810', 'PMT INTERNET ABONNEMENT', 1, 1),
(89, '470100', 'RETARD APUREMENT', 1, 1),
(90, '632800', 'SLB/ TRANSIT', 1, 1),
(91, '470100', 'VACATION DOUANE TEL', 1, 1),
(92, '470100', 'VACATION SERVICE INFORMATIQUE', 1, 1),
(93, '470100', 'VALIDATION DE CONFORMITE', 1, 1),
(94, '470100', 'VALIDATION DI', 1, 1),
(95, '663800', 'PRIME JOURS FERIE', 1, 1),
(96, '632700', 'PRIME TRAVAIL DE DIMANCHE', 1, 1),
(97, '632700', 'CONDUCTEUR JOURNALIER', 1, 1),
(98, '661210', 'PRIME MOIS', 1, 1),
(99, '401100', 'FR ETUDE DES HYDROCARBURES', 1, 1),
(100, '605600', 'ACHAT PIECES DE RECHANGE', 1, 1),
(101, '638400', 'FR MISSION', 1, 1),
(102, '605100', 'ACHAT EAU POTABLE', 1, 1),
(103, '668400', 'REMB ACHAT MEDICAMENT', 1, 1),
(104, '661100', 'PAIEMENT SALAIRE', 1, 1),
(105, '667100', 'POINTEURS', 1, 1),
(106, '470800', 'FR PEAGE', 1, 1),
(107, '632800', 'RETRAIT DOSSIER VEHICULE', 1, 1),
(108, '632800', 'RENOUVELLE VERITAS', 1, 1),
(109, '667100', 'POINTEUR - MANUTENTION', 1, 1),
(110, '632700', 'PRESTATION  INFORMATICIEN', 1, 1),
(111, '605600', 'ACHAT FILTRES HUILE', 1, 1),
(112, '604700', 'ACHAT RAMES PAPIER', 1, 1),
(113, '421000', 'PRÊT', 1, 1),
(114, '632801', 'CHARGEMENT - DECHARGEMET', 1, 1),
(115, '632400', 'NOTE D\'HONORAIRE HUSSIER JUSTICE', 1, 1),
(116, '632804', 'FR  EXTRAIT DE MAIN COURANTE ACCI', 1, 1),
(117, '624800', 'AUTRE ENTRETIENS ET REPARATION', 1, 1),
(118, '632800', 'MANUTENTION ZONE LOGISTIQUE', 1, 1),
(119, '661100', 'QUINZAINE', 1, 1),
(120, '668400', 'ACHAT MEDICAMENTS', 1, 1),
(121, '605600', 'ACHAT PIECES', 1, 1),
(122, '605800', 'ACHAT PNEUS', 1, 1),
(123, '605600', 'ACHAT CLE A ROUE', 1, 1),
(124, '605600', 'ACHAT  CRIQUES', 1, 1),
(125, '618300', 'TRANSPORT', 1, 1),
(126, '632700', 'FRANSFERT ARGENT', 1, 1),
(127, '638401', 'RATION', 1, 1),
(128, '605300', 'ACHAT GASOIL VEHICULES', 1, 1),
(129, '421000', 'FRAIS DG', 1, 1),
(130, '632800', 'DECHARGEMENT DECHETS', 1, 1),
(131, '411120', 'VERSEMENT SADI P-C SAT-ROYAL', 1, 1),
(132, '632800', 'GARDIENNAGE', 1, 1),
(133, '663800', 'PRIME VOYAGE', 1, 1),
(134, '605430', 'FOURNITURE ENTRETIEN BATIMENT', 1, 1),
(135, '663870', 'EVENEMENTS DU PERSONNEL', 1, 1),
(136, '401110', 'PAIEMENT FACT F/SSEURS TRANSPORT', 1, 1),
(137, '632800', 'FRAIS DIVERS TRANSIT', 1, 1),
(138, '604700', 'FOURNITURES ET MATERIEL DE BUREAU', 1, 1),
(139, '401120', 'PAIEMENT FACT F/SSEURS SHIPPING', 1, 1),
(140, '604300', 'ACHAT PRODUITS D\'ENTRETIEN', 1, 1),
(141, '470100', 'RETOUR CAISSE OPERAT° TRANSIT', 1, 1),
(142, '470100', 'AMANDEMENT DI', 1, 1),
(143, '470100', 'PAIEMENT  BIC/BESC', 1, 1),
(144, '624700', 'DEPANNAGE', 1, 1),
(145, '401100', 'PAIEMENT FACT F/SSEURS TRANSIT', 1, 1),
(146, '471300', 'COMPTE PROVISOIRE', 1, 1),
(147, '411120', 'DEPOT ESPECES COMPTE GROUP', 1, 1),
(148, '632700', 'PRESTATIONS GRUTIER & MANUTENTIONNAIRES', 1, 1),
(149, '638300', 'FRAIS DIRECTION', 1, 1),
(150, '632841', 'TRAVAUX CHANTIER PORT', 1, 1),
(151, '661100', 'PAIEMENT QUINZAINE', 1, 1),
(152, '470100', 'LIVRAISON NZASSI', 1, 1),
(153, '470100', 'AMENDEMENT DE', 1, 1),
(154, '605600', 'ACHAT MATERIEL DE CONSTRUCTION', 1, 1),
(155, '622300', 'CONTRAT DE LOCATION', 1, 1),
(156, '411120', 'REGLEMENT FACTURE POUR CPTE TIERS', 1, 1),
(157, '632702', 'PRESTATIONS CHARGES TRANSIT', 1, 1),
(158, '632700', 'FRAIS MANUTENTION', 1, 1),
(159, '616000', 'FRAIS D\'EXPEDITION COLIS', 1, 1),
(160, '605000', 'PETIT MATERIEL DE BUREAU', 1, 1),
(161, '632200', 'COMMISSIONS & COURTAGES SUR VENTES', 1, 1),
(162, '605700', 'ETUDES ET PRESTATIONS DE SERVICES', 1, 1),
(163, '661400', 'INDEMNITES DE LICENCIEMENT', 1, 1),
(164, '632500', 'FRAIS D\'ACTES ET CONTENTIEUX', 1, 1),
(165, '585000', 'RETOUR CAISSE - REGULARISATION', 1, 1),
(166, '585000', 'RAVITAILLEMENT CAISSE ALU', 1, 1),
(167, '470102', 'PRETSTATIONS DEBOURS TRANSIT', 1, 1),
(168, '632700', 'PAIEMENT JOURNALIER', 1, 1),
(169, '470100', 'DEBOURS TRANSIT', 1, 1),
(170, '638402', 'FRAIS DE ROUTE', 1, 1),
(171, '632805', 'DIVERS FRAIS SHIPPING', 1, 1),
(172, '470100', 'AETEX', 1, 1),
(173, '470100', 'FABRICATION CAISSE- TRANSIT', 1, 1),
(174, '632801', 'ESCORTE VIDE', 1, 1),
(175, '632801', 'ESCORTE PLEIN', 1, 1),
(176, '401100', 'DEM', 1, 1),
(177, '470100', 'FRAIS DOSSIER TRANSIT', 1, 1),
(178, '470100', 'FRAIS SPAMS', 1, 1),
(179, '470100', 'ASSURANCES', 1, 1),
(180, '470100', 'CONTROLE TECHNIQUE', 1, 1),
(181, '470100', 'VIGNETTE ENTREE PORT', 1, 1),
(182, '470100', 'ETAT DE CHARGEMENT', 1, 1),
(183, '470100', 'POLICE-GENDARMERIE+MAIRIE+APUREMENT', 1, 1),
(184, '470100', 'COURRIER  DOUANES', 1, 1),
(185, '470100', 'MISE A TERRE', 1, 1),
(186, '470100', 'ECHANGE BL', 1, 1),
(187, '470100', 'ETAT DE CHARGEMENT', 1, 1),
(188, '470100', 'ACCORD IM5', 1, 1),
(189, '638300', 'ACHAT ATN', 1, 1),
(190, '632510', 'FRAIS DEPART JURIDIQUE', 1, 1),
(191, '470100', 'ANNULATION DECLARATION', 1, 1),
(192, '245100', 'ACQUISIT° MATERIEL ROULANT', 1, 1),
(193, '470100', 'ANNULATION DI', 1, 1),
(194, '470100', 'DI-GUOT', 1, 1),
(195, '244300', 'ACHAT MATERIEL BUREAUTIQUE', 1, 1),
(196, '663810', 'ACHATS DIVERS', 1, 1),
(197, '605310', 'CARBURANT CITERNE', 1, 1),
(198, '605610', 'FOURNITURES ET PIECES VEHICULES PNR', 1, 1),
(199, '605620', 'FOURNITURES ET PIECES VEHICULES BZV', 1, 1),
(200, '624300', 'ENTRETIEN & REPARATIONS BATIMENTS', 1, 1),
(201, '658800', 'ECART DE CAISSE', 1, 1),
(202, '604100', 'ACHAT PRODUIT D\'ENTRETIEN', 1, 1),
(203, '632805', 'SHIPPING-FRAIS DIVERS', 1, 1),
(204, '668400', 'MEDECINE DU TRAVAIL  +PHARMACIE', 1, 1),
(205, '470800', 'RETOUR CAISSE OPERAT° TRANSPORT', 1, 1),
(206, '585000', 'APPRO CAISSE ALU', 1, 1),
(207, '585000', 'APPRO CAISSE SHIPPING', 1, 1),
(208, '632801', 'RETOUR CAISSE CHARGES TRANSPORT', 1, 1),
(209, '421000', 'RETOUR CAISSE AVANCE SUR SALAIRE', 1, 1),
(210, '585000', 'APPRO CAISSE TRANSIT', 1, 1),
(211, '471300', 'RETOUR CAISSE PROVISOIRE', 1, 1),
(212, '624700', 'RETOUR EN CAISSE DEPANNAGE', 1, 1),
(213, '585000', 'RETOUR ESPECES DANS CAISSE PRINCIPALE', 1, 1),
(214, '750000', 'PRODUITS DIVERS', 1, 1),
(215, '411120', 'REGLEMENT CLIENT', 1, 1),
(216, '585000', 'APPRO CAISSE TRANSPORT', 1, 1),
(217, '275850', 'RETOUR CONSIGNATION', 1, 1),
(218, '706000', 'IMMOBILISATION REMORQUE', 1, 1),
(219, '706000', 'RETRAIT D\'ESPECES EN BQUE', 1, 1),
(220, '470100', 'RETOUR EN CAISSE DOSSIER TRANSIT', 1, 1),
(221, '421000', 'EMPLOYE REMBOURSEMENT DETTE', 1, 1),
(222, '411120', 'VENTE GRAVIER', 1, 1),
(223, '411120', 'ENCAISSEMENT RECETTE PORT', 1, 1),
(224, '411120', 'APPROVISIONNEM PIECES BANGUI', 1, 1),
(225, '401100', 'RETOUR CAISSE D&T TRANSIT', 1, 1),
(226, '401110', 'RETOUR CAISSE F/SSEURS TRANSPORT', 1, 1),
(227, '401100', 'RETOUR F/SSEURS TRANSIT', 1, 1),
(228, '411120', 'RAVITAILLEMENT CAISSE PAR SADI', 1, 1),
(229, '661100', 'RETOUR CAISSE SALAIRE', 1, 1),
(230, '244400', 'MOBILIER DE BUREAU', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `departements`
--

CREATE TABLE `departements` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `departements`
--

INSERT INTO `departements` (`id`, `name`, `active`) VALUES
(1, 'DEPARTEMENT 1', 1),
(2, 'DEPARTEMENT 2', 1),
(3, 'DEPARTEMENT 3', 1),
(4, 'DEPARTEMENT 4', 1),
(5, 'DEPARTEMENT 5', 1);

-- --------------------------------------------------------

--
-- Structure de la table `dossiers`
--

CREATE TABLE `dossiers` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `closed_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `site_id` int(11) NOT NULL DEFAULT 0,
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `dossiers`
--

INSERT INTO `dossiers` (`id`, `name`, `code`, `client_id`, `closed_at`, `created_at`, `updated_at`, `active`, `user_id`, `site_id`, `token`) VALUES
(1, 'Transfert de colis', '68928393', 1, '2025-01-29 08:50:07', '2025-01-23 16:35:27', '2025-01-29 08:50:07', 1, 7, 1, 'e1f555b961cf40033daaa4d3cb36cacc0c0c141e'),
(2, 'Dossier Transfert', '6878998', 4, '2025-01-29 08:18:46', '2025-01-23 18:23:08', '2025-01-29 08:18:46', 1, 7, 1, '783e8bb0244cba2cfc69ffcf4b49e3e397c22cf2');

-- --------------------------------------------------------

--
-- Structure de la table `operations`
--

CREATE TABLE `operations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `agent` varchar(200) DEFAULT NULL,
  `beneficiaire` varchar(200) DEFAULT NULL,
  `validated_at` datetime DEFAULT NULL,
  `validated_by` int(11) NOT NULL DEFAULT 0,
  `cancelled_at` datetime DEFAULT NULL,
  `cancelled_by` int(11) DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `caisse_id` int(11) NOT NULL DEFAULT 0,
  `site_id` int(11) NOT NULL DEFAULT 0,
  `libelle` varchar(200) DEFAULT NULL,
  `dossier_id` int(11) NOT NULL DEFAULT 0,
  `montant` double NOT NULL DEFAULT 0,
  `mt_lettres` varchar(190) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `moi_id` int(11) DEFAULT 0,
  `annee` int(11) NOT NULL DEFAULT 0,
  `semaine` int(11) NOT NULL DEFAULT 0,
  `token` varchar(100) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `operations`
--

INSERT INTO `operations` (`id`, `name`, `client_id`, `agent`, `beneficiaire`, `validated_at`, `validated_by`, `cancelled_at`, `cancelled_by`, `user_id`, `caisse_id`, `site_id`, `libelle`, `dossier_id`, `montant`, `mt_lettres`, `created_at`, `updated_at`, `moi_id`, `annee`, `semaine`, `token`, `active`) VALUES
(1, '000001251', 1, 'Olomo sic', 'Les impots', '2025-01-29 07:49:58', 4, NULL, 0, 3, 5, 0, 'Paiement de la patente', 1, 300000, 'Trois cent mille', '2025-01-24 14:21:29', '2025-01-29 07:49:58', 1, 2025, 5, 'eb5006ac4bf04674c6aa3e317073a63a3a305314', 1),
(2, '000001252', 1, 'Le bureau des transports', 'Le gouvernement', NULL, 0, NULL, 0, 3, 8, 0, 'Paiement de la taxe carbone', 1, 1200000, 'Un million deux cent mille', '2025-01-24 15:14:56', '2025-01-24 15:14:56', 1, 2025, 5, '0a0390d8a199e520701e3e11e5f612be8fe132e4', 1),
(3, '000001253', 1, 'Le bureau des transports', 'Le gouvernement', NULL, 0, NULL, 0, 3, 8, 0, 'Paiement de la taxe carbone', 1, 1200000, 'Un million deux cent mille', '2025-01-24 15:29:38', '2025-01-24 15:29:38', 1, 2025, 5, '2c9fe15d2722f3c1115681e54324ed3500d5c6cf', 1),
(4, '000001254', 1, 'Le bureau des transports', 'Le gouvernement', NULL, 0, NULL, 0, 3, 8, 0, 'Paiement de la taxe carbone', 1, 1200000, 'Un million deux cent mille', '2025-01-24 15:33:52', '2025-01-24 15:33:52', 1, 2025, 5, '010c9041ccded0953e7554a541d6cdb61295200f', 1),
(5, '000001255', 1, 'Le bureau des transports', 'Le gouvernement', NULL, 0, NULL, 0, 3, 8, 0, 'Paiement de la taxe carbone', 1, 1200000, 'Un million deux cent mille', '2025-01-24 15:35:31', '2025-01-24 15:35:31', 1, 2025, 5, '923e31d7173ebec9889e75f4c92182826c78e28a', 1),
(6, '000001256', 1, 'Le bureau des transports', 'Le gouvernement', NULL, 0, NULL, 0, 3, 8, 0, 'Paiement de la taxe carbone', 1, 1200000, 'Un million deux cent mille', '2025-01-24 15:39:51', '2025-01-24 15:39:51', 1, 2025, 5, '5f8df6a1a75f5bb7a428fade6e5a4c9789feb4df', 1),
(7, '000001257', 4, 'La DRH', 'CNSS', NULL, 0, NULL, 0, 3, 5, 0, 'Paiement des charges sociales', 2, 4500000, 'Quatre million cinq cent mille', '2025-01-24 15:56:23', '2025-01-24 15:56:23', 1, 2025, 5, 'bd911ba6a3bc866907a7754298550f2d4863a849', 1),
(8, '000001258', 4, 'La DRH', 'CNSS', NULL, 0, NULL, 0, 3, 5, 0, 'Paiement des charges sociales', 2, 4500000, 'Quatre million cinq cent mille', '2025-01-24 15:59:12', '2025-01-24 15:59:12', 1, 2025, 5, 'acb883ee79f414d411db7e2f6cd3d6b225c9a647', 1),
(9, '000001259', 4, 'La DRH', 'CNSS', NULL, 0, NULL, 0, 3, 5, 0, 'Paiement des charges sociales', 2, 4500000, 'Quatre million cinq cent mille', '2025-01-24 16:00:37', '2025-01-24 16:00:37', 1, 2025, 5, 'c93bad4e2ae7024e4cbcb7aed90e53c0efc8bf7c', 1),
(10, '000012510', 4, 'Yemal', 'CNPS', NULL, 0, NULL, 0, 3, 5, 0, 'something', 2, 195400, 'Un cent quatre-vingt-dix-cinq mille quatre cent', '2025-01-25 10:09:53', '2025-01-25 10:09:53', 1, 2025, 6, '9546ad15e7a2f1f7f7600e6da50be50a19d2884e', 1),
(11, '000012511', 4, 'Yemal', 'CNPS', NULL, 0, NULL, 0, 3, 5, 0, 'something', 2, 195400, 'Un cent quatre-vingt-dix-cinq mille quatre cent', '2025-01-25 10:10:18', '2025-01-25 10:10:18', 1, 2025, 6, '69c92ba15efcca824bb43c1f9022cc9436550def', 1),
(12, '000012512', 4, 'Yemal', 'CNPS', NULL, 0, NULL, 0, 3, 5, 0, 'something', 2, 195400, 'Un cent quatre-vingt-dix-cinq mille quatre cent', '2025-01-25 10:10:39', '2025-01-25 10:10:39', 1, 2025, 6, '4e0d85d71bc411361549bad7349763e33676a8a1', 1),
(13, '000012513', 4, 'Yemal', 'CNPS', NULL, 0, NULL, 0, 3, 5, 0, 'something', 2, 195400, 'Un cent quatre-vingt-dix-cinq mille quatre cent', '2025-01-25 10:11:24', '2025-01-25 10:11:24', 1, 2025, 6, '91a7993fbf91217ee31c5dc56706898d6acf8860', 1),
(14, '000012514', 4, 'Yemal', 'CNPS', NULL, 0, NULL, 0, 3, 5, 0, 'something', 2, 195400, 'Un cent quatre-vingt-dix-cinq mille quatre cent', '2025-01-25 10:12:05', '2025-01-25 10:12:05', 1, 2025, 6, 'a1eb44447bedf8f578ad3a9b296433d9a0325dfe', 1),
(15, '000012515', 4, 'Yemal', 'CNPS', NULL, 0, NULL, 0, 3, 5, 0, 'something', 2, 195400, 'Un cent quatre-vingt-dix-cinq mille quatre cent', '2025-01-25 10:13:01', '2025-01-25 10:13:01', 1, 2025, 6, '092be407f024f02a5928ef635aeda470de7089dd', 1),
(16, '000012516', 4, 'Yemal', 'CNPS', NULL, 0, NULL, 0, 3, 5, 0, 'something', 2, 195400, 'Un cent quatre-vingt-dix-cinq mille quatre cent', '2025-01-25 10:14:19', '2025-01-25 10:14:19', 1, 2025, 6, 'cabed68deb10bff35295b758c3e50feae14b54cc', 1),
(17, '000012517', 4, 'Yemal', 'CNPS', NULL, 0, NULL, 0, 3, 5, 0, 'something', 2, 195400, 'Un cent quatre-vingt-dix-cinq mille quatre cent', '2025-01-25 10:15:41', '2025-01-25 10:15:41', 1, 2025, 6, '1a9407d50c1f37611ae5608caf547044fed79598', 1),
(18, '000012518', 4, 'Yemal', 'CNPS', NULL, 0, NULL, 0, 3, 5, 0, 'something', 2, 195400, 'Un cent quatre-vingt-dix-cinq mille quatre cent', '2025-01-25 10:17:10', '2025-01-25 10:17:10', 1, 2025, 6, 'f3f8381dc24d3d2d83fe5ea4a2384eb71f1f8df4', 1),
(19, '000012519', 4, 'Yemal', 'CNPS', NULL, 0, NULL, 0, 3, 5, 0, 'something', 2, 195400, 'Un cent quatre-vingt-dix-cinq mille quatre cent', '2025-01-25 10:17:42', '2025-01-25 10:17:42', 1, 2025, 6, '2b603bc1fc334fd6800d542013fb1b34c39c66dc', 1),
(20, '000012520', 4, 'Yemal', 'CNPS', NULL, 0, NULL, 0, 3, 5, 0, 'something', 2, 195400, 'Un cent quatre-vingt-dix-cinq mille quatre cent', '2025-01-25 10:32:47', '2025-01-25 10:32:47', 1, 2025, 6, '234705b3229ffe740dce95e6dbb3819aa5af7efe', 1),
(21, '000012521', 4, 'Yemal', 'CNPS', NULL, 0, NULL, 0, 3, 5, 0, 'something', 2, 195400, 'Un cent quatre-vingt-dix-cinq mille quatre cent', '2025-01-25 10:34:48', '2025-01-25 10:34:48', 1, 2025, 6, 'c31e4189a8e05861c9fd02dd5e1ddfe2eb412631', 1),
(22, '000012522', 4, 'Yemal', 'CNPS', '2025-01-25 19:22:20', 4, NULL, 0, 3, 5, 0, 'something', 2, 195400, 'Un cent quatre-vingt-dix-cinq mille quatre cent', '2025-01-25 10:35:41', '2025-01-25 19:22:20', 1, 2025, 6, '070a8be8e9a57b02f91e878077bf88d6b627d150', 1),
(23, '000012523', 4, 'Yemal', 'CNPS', NULL, 0, '2025-01-29 07:50:35', 4, 3, 5, 0, 'something', 2, 195400, 'Un cent quatre-vingt-dix-cinq mille quatre cent', '2025-01-25 10:37:20', '2025-01-29 07:50:35', 1, 2025, 6, 'cf7fb6b617ca7f07a3fb70bd89ee25a5777a1241', 1),
(24, '000012524', 4, 'Yemal', 'CNPS', NULL, 0, NULL, 0, 3, 5, 0, 'something', 2, 195400, 'Un cent quatre-vingt-dix-cinq mille quatre cent', '2025-01-25 10:37:58', '2025-01-25 10:37:58', 1, 2025, 6, '27dc7d3d6396cc31256dbf905e714230bc93d85d', 1),
(25, '000012525', 4, 'Ossama', 'La CNPS', '2025-01-27 09:29:31', 4, NULL, 0, 3, 8, 0, 'Cotisations sociales', 2, 3400000, 'Trois million quatre cent mille', '2025-01-27 09:26:55', '2025-01-27 09:29:31', 1, 2025, 1, '3668649b22de278e47494d771bcf4fad64b54c5a', 1),
(26, '000012526', 1, 'Ossama', 'Le Port autonome de Pointe-Noire', NULL, 0, '2025-01-27 09:54:12', 4, 3, 1, 0, 'Manutention', 1, 6700000, 'Six million sept cent mille', '2025-01-27 09:28:46', '2025-01-27 09:54:12', 1, 2025, 1, 'b195cbd2d9e72bc821989084e98a6e90845586ad', 1),
(27, '000012527', 1, 'Warren', 'Clement', '2025-01-29 08:41:06', 4, NULL, 0, 3, 1, 0, 'something', 1, 200000, 'Deux cent mille', '2025-01-29 08:39:11', '2025-01-29 08:41:06', 1, 2025, 3, '5f67ab4b803e1099929e24ff5fd2ef96eeed3335', 1),
(28, '000012528', 1, 'Warren', 'Made', NULL, 0, '2025-01-29 08:41:18', 4, 3, 1, 0, 'something', 1, 3000000, 'Trois million', '2025-01-29 08:40:02', '2025-01-29 08:41:18', 1, 2025, 3, '907fa6f503e11048dbeb077c4e78ac9e3c0b5627', 1);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `active`) VALUES
(1, 'Administrateur', 1),
(2, 'Manager', 1),
(3, 'Operateur de saisie', 1),
(5, 'Operateur dossier', 1);

-- --------------------------------------------------------

--
-- Structure de la table `sites`
--

CREATE TABLE `sites` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `sites`
--

INSERT INTO `sites` (`id`, `name`) VALUES
(1, 'POINTE-NOIRE'),
(2, 'BRAZZAVILLE');

-- --------------------------------------------------------

--
-- Structure de la table `tiers`
--

CREATE TABLE `tiers` (
  `id` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `code` varchar(17) DEFAULT NULL,
  `compte` varchar(20) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tiers`
--

INSERT INTO `tiers` (`id`, `name`, `code`, `compte`, `active`, `token`) VALUES
(1, 'Alliages Technologies', NULL, NULL, 1, '1eaec7fa0f203eac660018d887c6be9a36da1b29'),
(2, 'Zanzi Apps Inc.', NULL, NULL, 1, '84b38a80341b92c2a7861e60afe0ca1a21af557b'),
(3, 'Adjuvant Consulting', '4011ADJU', '40111000', 1, 'd93c37041ed25176cd9f455bc8ae88942e055109'),
(4, 'AllTech', 'ALt67', '578000', 1, '59a8bdcc82cf3943e2fd6ed6c45de9aa51a92471');

-- --------------------------------------------------------

--
-- Structure de la table `toperations`
--

CREATE TABLE `toperations` (
  `id` int(11) NOT NULL,
  `name` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `toperations`
--

INSERT INTO `toperations` (`id`, `name`) VALUES
(1, 'DECAISSEMENT'),
(2, 'DECAISSEMENT TRANSPORT'),
(3, 'DECAISSEMENT TRANSIT');

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `compte` varchar(20) DEFAULT NULL,
  `operation_id` int(11) NOT NULL DEFAULT 0,
  `compte_id` int(11) NOT NULL DEFAULT 0,
  `client_id` int(11) NOT NULL DEFAULT 0,
  `site_id` int(11) NOT NULL DEFAULT 0,
  `montant` double NOT NULL DEFAULT 0,
  `credit` tinyint(1) NOT NULL DEFAULT 1,
  `validated_at` datetime DEFAULT NULL,
  `validated_by` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `caisse_id` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `moi_id` int(11) DEFAULT 0,
  `annee` int(11) NOT NULL DEFAULT 0,
  `semaine` int(11) NOT NULL DEFAULT 0,
  `token` varchar(100) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `transactions`
--

INSERT INTO `transactions` (`id`, `compte`, `operation_id`, `compte_id`, `client_id`, `site_id`, `montant`, `credit`, `validated_at`, `validated_by`, `user_id`, `caisse_id`, `created_at`, `updated_at`, `moi_id`, `annee`, `semaine`, `token`, `active`) VALUES
(1, '521300', 1, 0, 0, 0, 300000, 1, NULL, 0, 3, 5, '2025-01-24 14:21:29', '2025-01-24 14:21:29', 0, 0, 0, 'ae28fa8de6e188773e9974ae642bb0112dce3405', 1),
(2, '275108', 1, 0, 0, 0, 300000, 0, NULL, 0, 3, 5, '2025-01-24 14:21:29', '2025-01-24 14:21:29', 0, 0, 0, 'fed46080a6b82fa89b1ed1ac0484027923eac301', 1),
(3, '571200', 2, 0, 0, 0, 1200000, 1, NULL, 0, 3, 8, '2025-01-24 15:14:56', '2025-01-24 15:14:56', 0, 0, 0, 'b5c75da5098ff5723992f14df2102d2798f27cb6', 1),
(4, '604710', 2, 0, 0, 0, 1200000, 0, NULL, 0, 3, 8, '2025-01-24 15:14:56', '2025-01-24 15:14:56', 0, 0, 0, '5e6542d48ced20aa8e2ad382fc68b88ee1f9087f', 1),
(5, '571200', 3, 0, 0, 0, 1200000, 1, NULL, 0, 3, 8, '2025-01-24 15:29:38', '2025-01-24 15:29:38', 0, 0, 0, '561b8eae2da6436f99ba4c35b26529f5436b31f3', 1),
(6, '604710', 3, 0, 0, 0, 1200000, 0, NULL, 0, 3, 8, '2025-01-24 15:29:38', '2025-01-24 15:29:38', 0, 0, 0, '1cac7c7d467357034477ce67c0f00eee11fbea03', 1),
(7, '571200', 4, 0, 0, 0, 1200000, 1, NULL, 0, 3, 8, '2025-01-24 15:33:52', '2025-01-24 15:33:52', 0, 0, 0, '06db8d99c35ff919a5209487f987eaf2d088b542', 1),
(8, '604710', 4, 0, 0, 0, 1200000, 0, NULL, 0, 3, 8, '2025-01-24 15:33:52', '2025-01-24 15:33:52', 0, 0, 0, 'd3fb87ae2861485c4debb30056a18eee4f2c2180', 1),
(9, '571200', 5, 0, 0, 0, 1200000, 1, NULL, 0, 3, 8, '2025-01-24 15:35:31', '2025-01-24 15:35:31', 0, 0, 0, 'c390eab03a66aed6fd7887df0028c4c1131f179f', 1),
(10, '604710', 5, 0, 0, 0, 1200000, 0, NULL, 0, 3, 8, '2025-01-24 15:35:31', '2025-01-24 15:35:31', 0, 0, 0, '3ae46512c33e476010c1230a27b93e3b9229a763', 1),
(11, '571200', 6, 0, 0, 0, 1200000, 1, NULL, 0, 3, 8, '2025-01-24 15:39:51', '2025-01-24 15:39:51', 0, 0, 0, '51b0c4e686fd6086d9db2bf90c10183870703160', 1),
(12, '604710', 6, 0, 0, 0, 1200000, 0, NULL, 0, 3, 8, '2025-01-24 15:39:51', '2025-01-24 15:39:51', 0, 0, 0, '7410a103a0723ff6abd73ee7258953c1cdc41392', 1),
(13, '521300', 7, 0, 0, 0, 4500000, 1, NULL, 0, 3, 5, '2025-01-24 15:56:23', '2025-01-24 15:56:23', 0, 0, 0, 'ca8ae1471870be76c9caec2ddb9bc44095919785', 1),
(14, '401100', 7, 0, 0, 0, 4500000, 0, NULL, 0, 3, 5, '2025-01-24 15:56:23', '2025-01-24 15:56:23', 0, 0, 0, '7218af7505d26258fef506f3c475b3ce55ca4085', 1),
(15, '521300', 8, 0, 0, 0, 4500000, 1, NULL, 0, 3, 5, '2025-01-24 15:59:13', '2025-01-24 15:59:13', 0, 0, 0, '962d760379c45eafccba2aa44ddc384c6d6ff538', 1),
(16, '401100', 8, 0, 0, 0, 4500000, 0, NULL, 0, 3, 5, '2025-01-24 15:59:13', '2025-01-24 15:59:13', 0, 0, 0, '6dba499ce8e8845c81082e2cdc2bebe3621b2b52', 1),
(17, '521300', 9, 0, 0, 0, 4500000, 1, NULL, 0, 3, 5, '2025-01-24 16:00:37', '2025-01-24 16:00:37', 0, 0, 0, '1ea85f3fec0f663b2754c11575c08449a0c27fb5', 1),
(18, '401100', 9, 0, 0, 0, 4500000, 0, NULL, 0, 3, 5, '2025-01-24 16:00:37', '2025-01-24 16:00:37', 0, 0, 0, '2d7512bbfa32a644bdbe47f8d90eedca08c59a69', 1),
(19, '521300', 10, 0, 0, 0, 195400, 1, NULL, 0, 3, 5, '2025-01-25 10:09:53', '2025-01-25 10:09:53', 0, 0, 0, 'e39f6f9a15afdc5a99e5be248a01dcddfe4c31ef', 1),
(20, '421100', 10, 0, 0, 0, 195400, 0, NULL, 0, 3, 5, '2025-01-25 10:09:53', '2025-01-25 10:09:53', 0, 0, 0, '803fc6550b06a24310ea42fbc57cb767fd716d47', 1),
(21, '521300', 11, 0, 0, 0, 195400, 1, NULL, 0, 3, 5, '2025-01-25 10:10:18', '2025-01-25 10:10:18', 0, 0, 0, '15c39641ad27ce6379ba046004cb0c462190d3c0', 1),
(22, '421100', 11, 0, 0, 0, 195400, 0, NULL, 0, 3, 5, '2025-01-25 10:10:18', '2025-01-25 10:10:18', 0, 0, 0, '06fb05b698975841682bd35d720098ff2bb3d656', 1),
(23, '521300', 12, 0, 0, 0, 195400, 1, NULL, 0, 3, 5, '2025-01-25 10:10:39', '2025-01-25 10:10:39', 0, 0, 0, 'fffa06a1a6d8ef1da92e976f6dbb34143205d2b2', 1),
(24, '421100', 12, 0, 0, 0, 195400, 0, NULL, 0, 3, 5, '2025-01-25 10:10:39', '2025-01-25 10:10:39', 0, 0, 0, '16a0ad9b94f1165487641c959fe2994fab17bf57', 1),
(25, '521300', 13, 0, 0, 0, 195400, 1, NULL, 0, 3, 5, '2025-01-25 10:11:24', '2025-01-25 10:11:24', 0, 0, 0, 'ae31650a4647a6fe83a1c03c03f6db3ccc09829c', 1),
(26, '421100', 13, 0, 0, 0, 195400, 0, NULL, 0, 3, 5, '2025-01-25 10:11:24', '2025-01-25 10:11:24', 0, 0, 0, 'fc46081af3167caad911f65ce32318e25aa7be50', 1),
(27, '521300', 14, 0, 0, 0, 195400, 1, NULL, 0, 3, 5, '2025-01-25 10:12:05', '2025-01-25 10:12:05', 0, 0, 0, 'c7b33e0f86fecd7e4cb6e29db4585c611776478a', 1),
(28, '421100', 14, 0, 0, 0, 195400, 0, NULL, 0, 3, 5, '2025-01-25 10:12:05', '2025-01-25 10:12:05', 0, 0, 0, 'b005f1042e5160b87818ee9cdf33bbe5b28fe39a', 1),
(29, '521300', 15, 0, 0, 0, 195400, 1, NULL, 0, 3, 5, '2025-01-25 10:13:01', '2025-01-25 10:13:01', 0, 0, 0, 'f077d2c59e0de76d85a7cb231a1493a1f80e1226', 1),
(30, '421100', 15, 0, 0, 0, 195400, 0, NULL, 0, 3, 5, '2025-01-25 10:13:01', '2025-01-25 10:13:01', 0, 0, 0, 'b1bad2c7937a4afdeb1333eec7e0912ee5a06898', 1),
(31, '521300', 16, 0, 0, 0, 195400, 1, NULL, 0, 3, 5, '2025-01-25 10:14:19', '2025-01-25 10:14:19', 0, 0, 0, '2fc966e5607741700906ba2abea9e525873ff105', 1),
(32, '421100', 16, 0, 0, 0, 195400, 0, NULL, 0, 3, 5, '2025-01-25 10:14:19', '2025-01-25 10:14:19', 0, 0, 0, '8e6c3e307f979d92d7b1646f6cd9de2deb6de8fb', 1),
(33, '521300', 17, 0, 0, 0, 195400, 1, NULL, 0, 3, 5, '2025-01-25 10:15:41', '2025-01-25 10:15:41', 0, 0, 0, '02918977fb295ae084a8b02e56ec72521be98db4', 1),
(34, '421100', 17, 0, 0, 0, 195400, 0, NULL, 0, 3, 5, '2025-01-25 10:15:42', '2025-01-25 10:15:42', 0, 0, 0, '20e726cd938f13fa4a40a7a03330e3ebd560ee80', 1),
(35, '521300', 18, 0, 0, 0, 195400, 1, NULL, 0, 3, 5, '2025-01-25 10:17:10', '2025-01-25 10:17:10', 0, 0, 0, '42bd483ebb13ff9f6e74e346a8ca71e2828a07c6', 1),
(36, '421100', 18, 0, 0, 0, 195400, 0, NULL, 0, 3, 5, '2025-01-25 10:17:10', '2025-01-25 10:17:10', 0, 0, 0, '054a29bbf4c3832b8970f234365da6998efbc7ee', 1),
(37, '521300', 19, 0, 0, 0, 195400, 1, NULL, 0, 3, 5, '2025-01-25 10:17:42', '2025-01-25 10:17:42', 0, 0, 0, '665363111eb538991038cdd2730e7268ac6a45f7', 1),
(38, '421100', 19, 0, 0, 0, 195400, 0, NULL, 0, 3, 5, '2025-01-25 10:17:42', '2025-01-25 10:17:42', 0, 0, 0, '9edca8d2b1d28cbae167a5c621d9b013b0912ff3', 1),
(39, '521300', 20, 0, 0, 0, 195400, 1, NULL, 0, 3, 5, '2025-01-25 10:32:47', '2025-01-25 10:32:47', 0, 0, 0, '9c82fabc8ba8028da8ecc035268184adabb53604', 1),
(40, '421100', 20, 0, 0, 0, 195400, 0, NULL, 0, 3, 5, '2025-01-25 10:32:47', '2025-01-25 10:32:47', 0, 0, 0, 'fc35d25d8780a8faf59d9e5baef15bfc32c9404b', 1),
(41, '521300', 21, 0, 0, 0, 195400, 1, NULL, 0, 3, 5, '2025-01-25 10:34:48', '2025-01-25 10:34:48', 0, 0, 0, '33c2071abde0f96f5b451c9aa1cd076376023b4a', 1),
(42, '421100', 21, 0, 0, 0, 195400, 0, NULL, 0, 3, 5, '2025-01-25 10:34:48', '2025-01-25 10:34:48', 0, 0, 0, '646ffe3fcfc179506fefdf8822311ed7a03c29b5', 1),
(43, '521300', 22, 0, 0, 0, 195400, 1, NULL, 0, 3, 5, '2025-01-25 10:35:41', '2025-01-25 10:35:41', 0, 0, 0, '71095e9d36f895d2461ada43207aad62dfcf063f', 1),
(44, '421100', 22, 0, 0, 0, 195400, 0, NULL, 0, 3, 5, '2025-01-25 10:35:41', '2025-01-25 10:35:41', 0, 0, 0, '5005d5a2ef1d7486fd7236679ed8661183b6e491', 1),
(45, '521300', 23, 0, 0, 0, 195400, 1, NULL, 0, 3, 5, '2025-01-25 10:37:20', '2025-01-25 10:37:20', 0, 0, 0, '8671c794279a673bcaf942a690384b513d60d3ae', 1),
(46, '421100', 23, 0, 0, 0, 195400, 0, NULL, 0, 3, 5, '2025-01-25 10:37:20', '2025-01-25 10:37:20', 0, 0, 0, 'd6ca9b01c7308c1870afd59adf565f60aaeac9f0', 1),
(47, '521300', 24, 0, 0, 0, 195400, 1, NULL, 0, 3, 5, '2025-01-25 10:37:58', '2025-01-25 10:37:58', 0, 0, 0, '62cf80a0d2ca8b21b2d2aa8cdce717d1d573ea08', 1),
(48, '421100', 24, 0, 0, 0, 195400, 0, NULL, 0, 3, 5, '2025-01-25 10:37:58', '2025-01-25 10:37:58', 0, 0, 0, '0d64b5f66e5e785f296a4256cce926956ccc3cc5', 1),
(49, '571200', 25, 0, 0, 0, 3400000, 1, NULL, 0, 3, 8, '2025-01-27 09:26:55', '2025-01-27 09:26:55', 0, 0, 0, '938f2284ca8a5a59c1f36283f7d2fd3d0d2b0c9d', 1),
(50, '471300', 25, 0, 0, 0, 3400000, 0, NULL, 0, 3, 8, '2025-01-27 09:26:55', '2025-01-27 09:26:55', 0, 0, 0, '5c91fcf00f33268acb7a24e26c5d3bd846a1eec4', 1),
(51, '521400', 26, 0, 0, 0, 6700000, 1, NULL, 0, 3, 1, '2025-01-27 09:28:46', '2025-01-27 09:28:46', 0, 0, 0, '20b68e6f775e8fe90c0ffdce7687c227470bcb32', 1),
(52, '401100', 26, 0, 0, 0, 6700000, 0, NULL, 0, 3, 1, '2025-01-27 09:28:46', '2025-01-27 09:28:46', 0, 0, 0, 'efa83e616fbd722a08ac1ea72998c4136c83fcca', 1),
(53, '521400', 27, 0, 0, 0, 200000, 1, NULL, 0, 3, 1, '2025-01-29 08:39:11', '2025-01-29 08:39:11', 0, 0, 0, 'edf2071994e56801fe7296cfd58a0f851775a13a', 1),
(54, '411100', 27, 0, 0, 0, 200000, 0, NULL, 0, 3, 1, '2025-01-29 08:39:11', '2025-01-29 08:39:11', 0, 0, 0, '3cf0e42f6957819033ee3f8dee57e944421b234f', 1),
(55, '521400', 28, 0, 0, 0, 3000000, 1, NULL, 0, 3, 1, '2025-01-29 08:40:02', '2025-01-29 08:40:02', 0, 0, 0, '5e9a4bb24fbad84aee5f2a10f50744ac7ab7ff20', 1),
(56, '275108', 28, 0, 0, 0, 3000000, 0, NULL, 0, 3, 1, '2025-01-29 08:40:02', '2025-01-29 08:40:02', 0, 0, 0, '0e6a32cafc7476ca74ddd9b8915afeab9b1ab15d', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 0,
  `caisse_id` int(11) NOT NULL DEFAULT 0,
  `departement_id` int(11) NOT NULL DEFAULT 0,
  `site_id` int(11) NOT NULL DEFAULT 0,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `role_id`, `caisse_id`, `departement_id`, `site_id`, `phone`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`, `active`, `token`) VALUES
(1, 'Clement Essomba', 1, 0, 0, 1, NULL, 'clementessomba@gmail.com', NULL, '$2y$12$TrAoqzd5gebPK55h255uJ.dPBQqNZf5kfh93FN01HHHfBTXU75IMi', NULL, NULL, NULL, NULL, '2024-08-27 10:36:45', '2024-08-27 10:36:45', 1, 'gfhgjdhhjdshgftehfgh'),
(3, 'Ngoma Simeon', 3, 1, 0, 1, '064332121', 's.ngoma@gmail.com', NULL, '$2y$12$nkY6NwWIOcJYUPefU7zusO9srq.fpiybnWV2dbDRmaC5mPc8mm/Bi', NULL, NULL, NULL, NULL, '2024-09-30 15:27:58', '2024-09-30 16:54:01', 1, '979c6d51776c8fc06429d12b64fcc112d56a736f'),
(4, 'Alphonse Nola', 2, 0, 0, 1, '045345565', 'a.nola@gmail.com', NULL, '$2y$12$q9XyK9jJxCRbidMUwN9OVOabJgZy5Dq3/cY6h47WuFFPe88CWqysy', NULL, NULL, NULL, NULL, '2024-09-30 21:32:47', '2024-09-30 21:32:47', 1, 'ce430a8369b760cecf5b260d7e4f43a6ca8179b0'),
(6, 'Boua Made', 1, 0, 0, 1, '067892389', 'admin@system.com', NULL, '$2y$12$ravJx8FlcnpQO1uFgn.gKeVWHg6RWHgGQBe9.wT9X7D04U3F8mVNi', NULL, NULL, NULL, NULL, '2024-12-19 20:37:21', '2024-12-19 20:37:21', 1, 'e91f5b89fc71cf2db11e45eb4731e2a06e8089e5'),
(7, 'Alain warren', 5, 0, 0, 1, '632798238', 'a.warren@gmail.com', NULL, '$2y$12$wjdj/IADxKpFHVCqu38eKuNji00m0uNWxPV7lPlZfLQuLm7iM.Q2O', NULL, NULL, NULL, NULL, '2025-01-23 13:34:07', '2025-01-23 13:34:07', 1, '040b2ff363a71f1c7952c2dd470f3b9e7cd84a2e');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `caisses`
--
ALTER TABLE `caisses`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `caisses_comptes`
--
ALTER TABLE `caisses_comptes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `caisses_users`
--
ALTER TABLE `caisses_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comptes`
--
ALTER TABLE `comptes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `departements`
--
ALTER TABLE `departements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `dossiers`
--
ALTER TABLE `dossiers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `operations`
--
ALTER TABLE `operations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tiers`
--
ALTER TABLE `tiers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `toperations`
--
ALTER TABLE `toperations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `caisses`
--
ALTER TABLE `caisses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `caisses_comptes`
--
ALTER TABLE `caisses_comptes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `caisses_users`
--
ALTER TABLE `caisses_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `comptes`
--
ALTER TABLE `comptes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT pour la table `departements`
--
ALTER TABLE `departements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `dossiers`
--
ALTER TABLE `dossiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `operations`
--
ALTER TABLE `operations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `tiers`
--
ALTER TABLE `tiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `toperations`
--
ALTER TABLE `toperations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
