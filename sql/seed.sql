-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 12 juin 2026 à 10:11
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS=0;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `5bx75_k7m_db`
--

-- ========================================
-- DROP des tables dans le bon ordre (dépendances d'abord)
-- ========================================
DROP TABLE IF EXISTS `favoris`;
DROP TABLE IF EXISTS `matchs`;
DROP TABLE IF EXISTS `joueurs`;
DROP TABLE IF EXISTS `equipes`;
DROP TABLE IF EXISTS `groupes`;
DROP TABLE IF EXISTS `confederations`;
DROP TABLE IF EXISTS `stades`;
DROP TABLE IF EXISTS `messages_contact`;
DROP TABLE IF EXISTS `utilisateurs`;

-- ========================================
-- CRÉATION des tables
-- ========================================

-- --------------------------------------------------------

--
-- Structure de la table `confederations`
--

CREATE TABLE `confederations` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `confederations`
--

INSERT INTO `confederations` (`id`, `code`, `nom`) VALUES(1, 'UEFA', 'Union des associations européennes de football');
INSERT INTO `confederations` (`id`, `code`, `nom`) VALUES(2, 'CONMEBOL', 'Confédération sud-américaine de football');
INSERT INTO `confederations` (`id`, `code`, `nom`) VALUES(3, 'CAF', 'Confédération africaine de football');
INSERT INTO `confederations` (`id`, `code`, `nom`) VALUES(4, 'AFC', 'Confédération asiatique de football');
INSERT INTO `confederations` (`id`, `code`, `nom`) VALUES(5, 'CONCACAF', 'Confédération de football d\'Amérique du Nord, centrale et Caraïbes');
INSERT INTO `confederations` (`id`, `code`, `nom`) VALUES(6, 'OFC', 'Confédération océanienne de football');

-- --------------------------------------------------------

--
-- Structure de la table `equipes`
--

CREATE TABLE `equipes` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `code_pays` char(3) NOT NULL,
  `drapeau_url` varchar(255) DEFAULT NULL,
  `groupe_id` int(11) NOT NULL,
  `confederation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipes`
--

INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(1, 'Mexique', 'MEX', 'https://flagcdn.com/mx.svg', 1, 5);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(2, 'Afrique du Sud', 'ZAF', 'https://flagcdn.com/za.svg', 1, 3);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(3, 'République de Corée', 'KOR', 'https://flagcdn.com/kr.svg', 1, 4);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(4, 'République tchèque', 'CZE', 'https://flagcdn.com/cz.svg', 1, 1);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(5, 'Canada', 'CAN', 'https://flagcdn.com/ca.svg', 2, 5);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(6, 'Suisse', 'CHE', 'https://flagcdn.com/ch.svg', 2, 1);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(7, 'Qatar', 'QAT', 'https://flagcdn.com/qa.svg', 2, 4);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(8, 'Bosnie-Herzégovine', 'BIH', 'https://flagcdn.com/ba.svg', 2, 1);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(9, 'Brésil', 'BRA', 'https://flagcdn.com/br.svg', 3, 2);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(10, 'Maroc', 'MAR', 'https://flagcdn.com/ma.svg', 3, 3);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(11, 'Haïti', 'HTI', 'https://flagcdn.com/ht.svg', 3, 5);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(12, 'Écosse', 'SCO', 'https://flagcdn.com/gb-sct.svg', 3, 1);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(13, 'États-Unis', 'USA', 'https://flagcdn.com/us.svg', 4, 5);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(14, 'Paraguay', 'PRY', 'https://flagcdn.com/py.svg', 4, 2);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(15, 'Australie', 'AUS', 'https://flagcdn.com/au.svg', 4, 6);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(16, 'Turquie', 'TUR', 'https://flagcdn.com/tr.svg', 4, 1);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(17, 'Allemagne', 'DEU', 'https://flagcdn.com/de.svg', 5, 1);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(18, 'Curaçao', 'CUW', 'https://flagcdn.com/cw.svg', 5, 5);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(19, 'Côte d\'Ivoire', 'CIV', 'https://flagcdn.com/ci.svg', 5, 3);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(20, 'Équateur', 'ECU', 'https://flagcdn.com/ec.svg', 5, 2);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(21, 'Pays-Bas', 'NLD', 'https://flagcdn.com/nl.svg', 6, 1);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(22, 'Japon', 'JPN', 'https://flagcdn.com/jp.svg', 6, 4);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(23, 'Tunisie', 'TUN', 'https://flagcdn.com/tn.svg', 6, 3);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(24, 'Suède', 'SWE', 'https://flagcdn.com/se.svg', 6, 1);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(25, 'Belgique', 'BEL', 'https://flagcdn.com/be.svg', 7, 1);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(26, 'Égypte', 'EGY', 'https://flagcdn.com/eg.svg', 7, 3);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(27, 'Iran', 'IRN', 'https://flagcdn.com/ir.svg', 7, 4);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(28, 'Nouvelle-Zélande', 'NZL', 'https://flagcdn.com/nz.svg', 7, 6);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(29, 'Espagne', 'ESP', 'https://flagcdn.com/es.svg', 8, 1);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(30, 'Cap-Vert', 'CPV', 'https://flagcdn.com/cv.svg', 8, 3);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(31, 'Arabie Saoudite', 'SAU', 'https://flagcdn.com/sa.svg', 8, 4);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(32, 'Uruguay', 'URY', 'https://flagcdn.com/uy.svg', 8, 2);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(33, 'France', 'FRA', 'https://flagcdn.com/fr.svg', 9, 1);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(34, 'Sénégal', 'SEN', 'https://flagcdn.com/sn.svg', 9, 3);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(35, 'Norvège', 'NOR', 'https://flagcdn.com/no.svg', 9, 1);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(36, 'Irak', 'IRQ', 'https://flagcdn.com/iq.svg', 9, 4);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(37, 'Argentine', 'ARG', 'https://flagcdn.com/ar.svg', 10, 2);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(38, 'Algérie', 'DZA', 'https://flagcdn.com/dz.svg', 10, 3);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(39, 'Autriche', 'AUT', 'https://flagcdn.com/at.svg', 10, 1);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(40, 'Jordanie', 'JOR', 'https://flagcdn.com/jo.svg', 10, 4);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(41, 'Portugal', 'PRT', 'https://flagcdn.com/pt.svg', 11, 1);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(42, 'Colombie', 'COL', 'https://flagcdn.com/co.svg', 11, 2);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(43, 'Ouzbékistan', 'UZB', 'https://flagcdn.com/uz.svg', 11, 4);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(44, 'RD Congo', 'COD', 'https://flagcdn.com/cd.svg', 11, 3);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(45, 'Angleterre', 'ENG', 'https://flagcdn.com/gb-eng.svg', 12, 1);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(46, 'Croatie', 'HRV', 'https://flagcdn.com/hr.svg', 12, 1);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(47, 'Ghana', 'GHA', 'https://flagcdn.com/gh.svg', 12, 3);
INSERT INTO `equipes` (`id`, `nom`, `code_pays`, `drapeau_url`, `groupe_id`, `confederation_id`) VALUES(48, 'Panama', 'PAN', 'https://flagcdn.com/pa.svg', 12, 5);

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

CREATE TABLE `favoris` (
  `utilisateur_id` int(11) NOT NULL,
  `equipe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `favoris`
--

INSERT INTO `favoris` (`utilisateur_id`, `equipe_id`) VALUES(2, 25);
INSERT INTO `favoris` (`utilisateur_id`, `equipe_id`) VALUES(2, 33);
INSERT INTO `favoris` (`utilisateur_id`, `equipe_id`) VALUES(2, 37);
INSERT INTO `favoris` (`utilisateur_id`, `equipe_id`) VALUES(3, 9);
INSERT INTO `favoris` (`utilisateur_id`, `equipe_id`) VALUES(3, 10);

-- --------------------------------------------------------

--
-- Structure de la table `groupes`
--

CREATE TABLE `groupes` (
  `id` int(11) NOT NULL,
  `nom` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `groupes`
--

INSERT INTO `groupes` (`id`, `nom`) VALUES(1, 'A');
INSERT INTO `groupes` (`id`, `nom`) VALUES(2, 'B');
INSERT INTO `groupes` (`id`, `nom`) VALUES(3, 'C');
INSERT INTO `groupes` (`id`, `nom`) VALUES(4, 'D');
INSERT INTO `groupes` (`id`, `nom`) VALUES(5, 'E');
INSERT INTO `groupes` (`id`, `nom`) VALUES(6, 'F');
INSERT INTO `groupes` (`id`, `nom`) VALUES(7, 'G');
INSERT INTO `groupes` (`id`, `nom`) VALUES(8, 'H');
INSERT INTO `groupes` (`id`, `nom`) VALUES(9, 'I');
INSERT INTO `groupes` (`id`, `nom`) VALUES(10, 'J');
INSERT INTO `groupes` (`id`, `nom`) VALUES(11, 'K');
INSERT INTO `groupes` (`id`, `nom`) VALUES(12, 'L');

-- --------------------------------------------------------

--
-- Structure de la table `joueurs`
--

CREATE TABLE `joueurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `poste` enum('GB','DEF','MIL','ATT') NOT NULL,
  `numero` tinyint(4) DEFAULT NULL,
  `equipe_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `joueurs`
--

INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(1, 'Ochoa', 'Guillermo', 'GB', 1, 1);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(2, 'Sánchez', 'Jesús', 'DEF', 2, 1);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(3, 'Montes', 'César', 'DEF', 3, 1);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(4, 'Herrera', 'Héctor', 'MIL', 8, 1);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(5, 'Lozano', 'Hirving', 'ATT', 22, 1);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(6, 'Jiménez', 'Raúl', 'ATT', 9, 1);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(7, 'Williams', 'Ronwen', 'GB', 1, 2);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(8, 'Ngcobo', 'Siyanda', 'DEF', 5, 2);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(9, 'Hlanti', 'Sifiso', 'DEF', 3, 2);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(10, 'Zungu', 'Bongani', 'MIL', 6, 2);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(11, 'Maja', 'Lyle', 'ATT', 9, 2);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(12, 'Dolly', 'Keagan', 'ATT', 10, 2);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(13, 'Kim', 'Seung-Gyu', 'GB', 1, 3);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(14, 'Kim', 'Min-Jae', 'DEF', 3, 3);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(15, 'Lee', 'Yong', 'DEF', 2, 3);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(16, 'Jung', 'Woo-Young', 'MIL', 6, 3);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(17, 'Lee', 'Jae-Sung', 'MIL', 10, 3);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(18, 'Son', 'Heung-Min', 'ATT', 7, 3);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(19, 'Staněk', 'Jindřich', 'GB', 1, 4);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(20, 'Kúdela', 'Ondřej', 'DEF', 5, 4);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(21, 'Holeš', 'Tomáš', 'DEF', 4, 4);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(22, 'Souček', 'Tomáš', 'MIL', 8, 4);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(23, 'Barák', 'Antonín', 'MIL', 10, 4);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(24, 'Schick', 'Patrik', 'ATT', 9, 4);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(25, 'Borjan', 'Milan', 'GB', 1, 5);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(26, 'Johnston', 'Alistair', 'DEF', 2, 5);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(27, 'Miller', 'Kamal', 'DEF', 5, 5);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(28, 'Eustaquio', 'Stephen', 'MIL', 7, 5);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(29, 'Davies', 'Alphonso', 'ATT', 19, 5);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(30, 'David', 'Jonathan', 'ATT', 9, 5);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(31, 'Sommer', 'Yann', 'GB', 1, 6);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(32, 'Elvedi', 'Nico', 'DEF', 5, 6);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(33, 'Akanji', 'Manuel', 'DEF', 6, 6);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(34, 'Freuler', 'Remo', 'MIL', 8, 6);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(35, 'Xhaka', 'Granit', 'MIL', 10, 6);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(36, 'Embolo', 'Breel', 'ATT', 9, 6);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(37, 'Al-Sheeb', 'Saad', 'GB', 1, 7);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(38, 'Salman', 'Abdelkarim', 'DEF', 13, 7);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(39, 'Hassan', 'Bassam', 'DEF', 5, 7);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(40, 'Boudiaf', 'Mohammed', 'MIL', 6, 7);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(41, 'Ali', 'Akram', 'MIL', 10, 7);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(42, 'Almoez', 'Ali', 'ATT', 19, 7);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(43, 'Sehic', 'Kenan', 'GB', 1, 8);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(44, 'Kolasinac', 'Sead', 'DEF', 5, 8);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(45, 'Bicakcic', 'Ervin', 'DEF', 4, 8);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(46, 'Pjanic', 'Miralem', 'MIL', 8, 8);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(47, 'Krunic', 'Rade', 'MIL', 7, 8);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(48, 'Dzeko', 'Edin', 'ATT', 9, 8);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(49, 'Alisson', 'Becker', 'GB', 1, 9);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(50, 'Silva', 'Thiago', 'DEF', 3, 9);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(51, 'Militão', 'Éder', 'DEF', 4, 9);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(52, 'Casemiro', 'Carlos', 'MIL', 5, 9);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(53, 'Rodrygo', 'Goes', 'ATT', 11, 9);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(54, 'Vinícius', 'Júnior', 'ATT', 7, 9);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(55, 'Bounou', 'Yassine', 'GB', 1, 10);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(56, 'Hakimi', 'Achraf', 'DEF', 2, 10);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(57, 'Aguerd', 'Nayef', 'DEF', 5, 10);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(58, 'Amrabat', 'Sofyan', 'MIL', 4, 10);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(59, 'Ziyech', 'Hakim', 'MIL', 7, 10);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(60, 'En-Nesyri', 'Youssef', 'ATT', 9, 10);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(61, 'Voltaire', 'Josué', 'GB', 1, 11);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(62, 'Jérôme', 'Steeven', 'DEF', 5, 11);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(63, 'Vorbe', 'Mechack', 'DEF', 4, 11);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(64, 'Cantave', 'Wilde-Donald', 'MIL', 8, 11);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(65, 'Noel', 'Kevin', 'MIL', 6, 11);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(66, 'Nazon', 'Duckens', 'ATT', 9, 11);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(67, 'Gordon', 'Craig', 'GB', 1, 12);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(68, 'Ralston', 'Anthony', 'DEF', 2, 12);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(69, 'Hendry', 'Jack', 'DEF', 5, 12);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(70, 'McTominay', 'Scott', 'MIL', 8, 12);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(71, 'McGinn', 'John', 'MIL', 7, 12);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(72, 'Adams', 'Che', 'ATT', 9, 12);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(73, 'Turner', 'Matt', 'GB', 1, 13);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(74, 'Dest', 'Sergiño', 'DEF', 2, 13);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(75, 'Richards', 'Chris', 'DEF', 5, 13);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(76, 'McKennie', 'Weston', 'MIL', 8, 13);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(77, 'Musah', 'Yunus', 'MIL', 6, 13);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(78, 'Pulisic', 'Christian', 'ATT', 10, 13);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(79, 'Silva', 'Antony', 'GB', 1, 14);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(80, 'Balbuena', 'Fabián', 'DEF', 3, 14);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(81, 'Alderete', 'Omar', 'DEF', 5, 14);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(82, 'Cubas', 'Andrés', 'MIL', 8, 14);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(83, 'Almiron', 'Miguel', 'MIL', 10, 14);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(84, 'Sanabria', 'Antonio', 'ATT', 9, 14);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(85, 'Ryan', 'Mathew', 'GB', 1, 15);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(86, 'Behich', 'Aziz', 'DEF', 3, 15);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(87, 'Rowles', 'Kye', 'DEF', 5, 15);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(88, 'Mooy', 'Aaron', 'MIL', 7, 15);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(89, 'Irvine', 'Jackson', 'MIL', 8, 15);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(90, 'Leckie', 'Mathew', 'ATT', 9, 15);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(91, 'Çakır', 'Altay', 'GB', 1, 16);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(92, 'Müldür', 'Zeki', 'DEF', 2, 16);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(93, 'Demiral', 'Merih', 'DEF', 3, 16);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(94, 'Özcan', 'Salih', 'MIL', 6, 16);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(95, 'Çalhanoğlu', 'Hakan', 'MIL', 10, 16);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(96, 'Yılmaz', 'Burak', 'ATT', 9, 16);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(97, 'Neuer', 'Manuel', 'GB', 1, 17);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(98, 'Rüdiger', 'Antonio', 'DEF', 2, 17);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(99, 'Schlotterbeck', 'Nico', 'DEF', 5, 17);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(100, 'Kimmich', 'Joshua', 'MIL', 6, 17);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(101, 'Musiala', 'Jamal', 'MIL', 10, 17);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(102, 'Havertz', 'Kai', 'ATT', 7, 17);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(103, 'Terminal', 'Eloy', 'GB', 1, 18);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(104, 'Francisca', 'Cuco', 'DEF', 5, 18);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(105, 'Martha', 'Riechedly', 'DEF', 4, 18);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(106, 'Fer', 'Leroy', 'MIL', 8, 18);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(107, 'Laveist', 'Gevaro', 'MIL', 7, 18);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(108, 'Daal', 'Jurickson', 'ATT', 9, 18);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(109, 'Sangaré', 'Ibrahim', 'GB', 16, 19);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(110, 'Bailly', 'Eric', 'DEF', 5, 19);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(111, 'Konan', 'Wilfried', 'DEF', 3, 19);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(112, 'Sangaré', 'Ibrahim', 'MIL', 8, 19);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(113, 'Zaha', 'Wilfried', 'ATT', 11, 19);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(114, 'Haller', 'Sébastien', 'ATT', 9, 19);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(115, 'Domínguez', 'Hernán', 'GB', 1, 20);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(116, 'Preciado', 'Angelo', 'DEF', 2, 20);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(117, 'Hincapié', 'Piero', 'DEF', 5, 20);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(118, 'Caicedo', 'Moisés', 'MIL', 8, 20);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(119, 'Plata', 'Gonzalo', 'ATT', 11, 20);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(120, 'Valencia', 'Enner', 'ATT', 13, 20);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(121, 'Flekken', 'Mark', 'GB', 1, 21);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(122, 'Dumfries', 'Denzel', 'DEF', 2, 21);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(123, 'Van Dijk', 'Virgil', 'DEF', 4, 21);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(124, 'De Jong', 'Frenkie', 'MIL', 8, 21);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(125, 'Gakpo', 'Cody', 'ATT', 11, 21);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(126, 'Depay', 'Memphis', 'ATT', 10, 21);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(127, 'Gonda', 'Shuichi', 'GB', 1, 22);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(128, 'Tomiyasu', 'Takehiro', 'DEF', 5, 22);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(129, 'Yoshida', 'Maya', 'DEF', 3, 22);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(130, 'Endo', 'Wataru', 'MIL', 6, 22);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(131, 'Kamada', 'Daichi', 'MIL', 10, 22);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(132, 'Minamino', 'Takumi', 'ATT', 9, 22);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(133, 'Dahmen', 'Aymen', 'GB', 1, 23);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(134, 'Meriah', 'Montassar', 'DEF', 5, 23);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(135, 'Talbi', 'Élyes', 'DEF', 4, 23);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(136, 'Skhiri', 'Ellyes', 'MIL', 8, 23);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(137, 'Khazri', 'Wahbi', 'MIL', 10, 23);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(138, 'Jebali', 'Issam', 'ATT', 9, 23);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(139, 'Olsen', 'Robin', 'GB', 1, 24);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(140, 'Krafth', 'Emil', 'DEF', 2, 24);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(141, 'Danielson', 'Andreas', 'DEF', 5, 24);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(142, 'Ekdal', 'Albin', 'MIL', 8, 24);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(143, 'Forsberg', 'Emil', 'MIL', 10, 24);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(144, 'Isak', 'Alexander', 'ATT', 9, 24);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(145, 'Casteels', 'Koen', 'GB', 1, 25);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(146, 'Castagne', 'Timothy', 'DEF', 2, 25);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(147, 'Vertonghen', 'Jan', 'DEF', 5, 25);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(148, 'Tielemans', 'Youri', 'MIL', 8, 25);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(149, 'De Bruyne', 'Kevin', 'MIL', 7, 25);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(150, 'Lukaku', 'Romelu', 'ATT', 9, 25);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(151, 'El-Shenawy', 'Mohamed', 'GB', 1, 26);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(152, 'Hamdi', 'Akram', 'DEF', 5, 26);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(153, 'Abdelmonem', 'Ahmed', 'DEF', 4, 26);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(154, 'Elneny', 'Mohamed', 'MIL', 8, 26);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(155, 'Trezeguet', 'Ibrahim', 'MIL', 10, 26);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(156, 'Salah', 'Mohamed', 'ATT', 11, 26);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(157, 'Beiranvand', 'Alireza', 'GB', 1, 27);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(158, 'Mohammadi', 'Ehsan', 'DEF', 3, 27);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(159, 'Pouraliganji', 'Ramin', 'DEF', 5, 27);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(160, 'Ezatolahi', 'Saeid', 'MIL', 8, 27);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(161, 'Jahanbakhsh', 'Alireza', 'MIL', 7, 27);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(162, 'Taremi', 'Mehdi', 'ATT', 9, 27);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(163, 'Sail', 'Oli', 'GB', 1, 28);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(164, 'Seamungal', 'Liberato', 'DEF', 5, 28);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(165, 'Hamill', 'Michael', 'DEF', 4, 28);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(166, 'McGlinchey', 'Callum', 'MIL', 8, 28);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(167, 'Waine', 'Marko', 'MIL', 7, 28);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(168, 'Wood', 'Chris', 'ATT', 9, 28);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(169, 'Unai', 'Simón', 'GB', 1, 29);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(170, 'Carvajal', 'Dani', 'DEF', 2, 29);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(171, 'Laporte', 'Aymeric', 'DEF', 4, 29);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(172, 'Rodri', 'Rodrigo', 'MIL', 16, 29);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(173, 'Pedri', 'González', 'MIL', 8, 29);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(174, 'Morata', 'Álvaro', 'ATT', 9, 29);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(175, 'Vozinha', 'João', 'GB', 1, 30);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(176, 'Fali', 'Stopira', 'DEF', 5, 30);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(177, 'Varela', 'Diney', 'DEF', 4, 30);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(178, 'Lopes', 'Kenny', 'MIL', 8, 30);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(179, 'Júnior', 'Garry', 'MIL', 10, 30);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(180, 'Tavares', 'Ryan', 'ATT', 9, 30);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(181, 'Al-Owais', 'Mohammed', 'GB', 1, 31);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(182, 'Al-Bulayhi', 'Ali', 'DEF', 6, 31);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(183, 'Al-Tambakti', 'Hassan', 'DEF', 5, 31);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(184, 'Al-Malki', 'Sami', 'MIL', 8, 31);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(185, 'Al-Dawsari', 'Salem', 'ATT', 10, 31);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(186, 'Al-Shehri', 'Saleh', 'ATT', 9, 31);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(187, 'Rochet', 'Sergio', 'GB', 1, 32);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(188, 'Giménez', 'José María', 'DEF', 2, 32);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(189, 'Godín', 'Diego', 'DEF', 3, 32);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(190, 'Valverde', 'Federico', 'MIL', 8, 32);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(191, 'Bentancur', 'Rodrigo', 'MIL', 6, 32);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(192, 'Núñez', 'Darwin', 'ATT', 9, 32);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(193, 'Maignan', 'Mike', 'GB', 16, 33);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(194, 'Pavard', 'Benjamin', 'DEF', 5, 33);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(195, 'Upamecano', 'Dayot', 'DEF', 4, 33);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(196, 'Tchouaméni', 'Aurélien', 'MIL', 8, 33);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(197, 'Griezmann', 'Antoine', 'MIL', 7, 33);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(198, 'Mbappé', 'Kylian', 'ATT', 10, 33);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(199, 'Mendy', 'Édouard', 'GB', 1, 34);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(200, 'Sarr', 'Ismaïla', 'DEF', 3, 34);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(201, 'Koulibaly', 'Kalidou', 'DEF', 5, 34);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(202, 'Gueye', 'Idrissa', 'MIL', 8, 34);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(203, 'Diatta', 'Krepin', 'MIL', 10, 34);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(204, 'Mané', 'Sadio', 'ATT', 10, 34);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(205, 'Nyland', 'Ørjan', 'GB', 1, 35);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(206, 'Ryerson', 'Julian', 'DEF', 2, 35);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(207, 'Ajer', 'Kristoffer', 'DEF', 5, 35);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(208, 'Berg', 'Sander', 'MIL', 8, 35);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(209, 'Ødegaard', 'Martin', 'MIL', 7, 35);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(210, 'Haaland', 'Erling', 'ATT', 9, 35);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(211, 'Doham', 'Jalal', 'GB', 1, 36);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(212, 'Karrar', 'Ali', 'DEF', 5, 36);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(213, 'Hamid', 'Rebin', 'DEF', 4, 36);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(214, 'Mukhtar', 'Saad', 'MIL', 8, 36);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(215, 'Ameen', 'Ayman', 'MIL', 10, 36);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(216, 'Mohanad', 'Ali', 'ATT', 9, 36);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(217, 'Martínez', 'Emiliano', 'GB', 1, 37);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(218, 'Molina', 'Nahuel', 'DEF', 26, 37);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(219, 'Romero', 'Cristian', 'DEF', 13, 37);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(220, 'De Paul', 'Rodrigo', 'MIL', 7, 37);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(221, 'Mac Allister', 'Alexis', 'MIL', 20, 37);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(222, 'Messi', 'Lionel', 'ATT', 10, 37);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(223, 'Mandrea', 'Alexandre', 'GB', 16, 38);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(224, 'Mandi', 'Aïssa', 'DEF', 5, 38);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(225, 'Benlamri', 'Djamel', 'DEF', 4, 38);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(226, 'Bennacer', 'Ismaël', 'MIL', 8, 38);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(227, 'Atal', 'Youcef', 'MIL', 7, 38);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(228, 'Mahrez', 'Riyad', 'ATT', 11, 38);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(229, 'Pentz', 'Patrick', 'GB', 1, 39);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(230, 'Posch', 'Stefan', 'DEF', 5, 39);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(231, 'Hinteregger', 'Martin', 'DEF', 4, 39);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(232, 'Seiwald', 'Nicolas', 'MIL', 8, 39);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(233, 'Sabitzer', 'Marcel', 'MIL', 7, 39);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(234, 'Arnautovic', 'Marko', 'ATT', 9, 39);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(235, 'Shafi', 'Yazeed', 'GB', 1, 40);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(236, 'Al-Bawab', 'Badr', 'DEF', 5, 40);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(237, 'Sukar', 'Abdallah', 'DEF', 4, 40);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(238, 'Al-Rawabdeh', 'Musa', 'MIL', 8, 40);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(239, 'Bani Attiyeh', 'Yazan', 'MIL', 7, 40);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(240, 'Al-Taamari', 'Musa', 'ATT', 10, 40);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(241, 'Costa', 'Diogo', 'GB', 1, 41);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(242, 'Cancelo', 'João', 'DEF', 20, 41);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(243, 'Dias', 'Rúben', 'DEF', 4, 41);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(244, 'Palhinha', 'João', 'MIL', 8, 41);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(245, 'Fernandes', 'Bruno', 'MIL', 8, 41);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(246, 'Ronaldo', 'Cristiano', 'ATT', 7, 41);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(247, 'Vargas', 'Camilo', 'GB', 1, 42);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(248, 'Muñoz', 'Daniel', 'DEF', 2, 42);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(249, 'Sánchez', 'Jhon', 'DEF', 5, 42);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(250, 'Lerma', 'Jefferson', 'MIL', 8, 42);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(251, 'Cuadrado', 'Juan', 'MIL', 11, 42);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(252, 'Díaz', 'Luis', 'ATT', 7, 42);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(253, 'Nematov', 'Otabek', 'GB', 1, 43);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(254, 'Ashurmatov', 'Khusan', 'DEF', 5, 43);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(255, 'Jaloliddinov', 'Akbar', 'DEF', 4, 43);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(256, 'Khamdamov', 'Azizbek', 'MIL', 8, 43);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(257, 'Shomurodov', 'Eldor', 'ATT', 9, 43);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(258, 'Tursunov', 'Jasur', 'ATT', 10, 43);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(259, 'Kibambi', 'Ley', 'GB', 1, 44);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(260, 'Mbemba', 'Chancel', 'DEF', 5, 44);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(261, 'Batubinsika', 'Yvan', 'DEF', 4, 44);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(262, 'Tshimanga', 'Cédric', 'MIL', 8, 44);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(263, 'Kakuta', 'Gaël', 'MIL', 10, 44);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(264, 'Bakambu', 'Cédric', 'ATT', 9, 44);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(265, 'Pickford', 'Jordan', 'GB', 1, 45);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(266, 'Alexander-Arnold', 'Trent', 'DEF', 66, 45);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(267, 'Maguire', 'Harry', 'DEF', 5, 45);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(268, 'Bellingham', 'Jude', 'MIL', 22, 45);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(269, 'Saka', 'Bukayo', 'ATT', 7, 45);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(270, 'Kane', 'Harry', 'ATT', 9, 45);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(271, 'Livakovic', 'Dominik', 'GB', 1, 46);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(272, 'Juranovic', 'Josip', 'DEF', 2, 46);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(273, 'Gvardiol', 'Joško', 'DEF', 4, 46);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(274, 'Brozovic', 'Marcelo', 'MIL', 11, 46);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(275, 'Kovacic', 'Mateo', 'MIL', 8, 46);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(276, 'Kramaric', 'Andrej', 'ATT', 9, 46);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(277, 'Ati-Zigi', 'Lawrence', 'GB', 1, 47);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(278, 'Lamptey', 'Tariq', 'DEF', 2, 47);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(279, 'Amartey', 'Daniel', 'DEF', 5, 47);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(280, 'Partey', 'Thomas', 'MIL', 5, 47);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(281, 'Kudus', 'Mohammed', 'MIL', 10, 47);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(282, 'Ayew', 'Jordan', 'ATT', 9, 47);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(283, 'Mosquera', 'Orlando', 'GB', 1, 48);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(284, 'Davis', 'Fidel', 'DEF', 5, 48);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(285, 'Murillo', 'Édgar', 'DEF', 4, 48);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(286, 'Godoy', 'Adalberto', 'MIL', 8, 48);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(287, 'Cox', 'Rolando', 'MIL', 7, 48);
INSERT INTO `joueurs` (`id`, `nom`, `prenom`, `poste`, `numero`, `equipe_id`) VALUES(288, 'Fajardo', 'Gabriel', 'ATT', 9, 48);

-- --------------------------------------------------------

--
-- Structure de la table `matchs`
--

CREATE TABLE `matchs` (
  `id` int(11) NOT NULL,
  `equipe_dom_id` int(11) NOT NULL,
  `equipe_ext_id` int(11) NOT NULL,
  `stade_id` int(11) NOT NULL,
  `date_match` datetime NOT NULL,
  `score_dom` tinyint(4) DEFAULT NULL,
  `score_ext` tinyint(4) DEFAULT NULL,
  `phase` enum('groupes','huitieme','quart','demi','finale_petite','finale') NOT NULL,
  `apercu_ia` text DEFAULT NULL,
  `apercu_genere` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Déchargement des données de la table `matchs`
--
INSERT INTO `matchs` (`id`, `equipe_dom_id`, `equipe_ext_id`, `stade_id`, `date_match`, `score_dom`, `score_ext`, `phase`, `apercu_ia`, `apercu_genere`) VALUES
(1, 1, 2, 14, '2026-06-11 20:00:00', 2, 0, 'groupes', NULL, 0),
(2, 3, 4, 15, '2026-06-11 20:00:00', 2, 1, 'groupes', NULL, 0),
(3, 5, 8, 11, '2026-06-12 15:00:00', 1, 1, 'groupes', NULL, 0),
(4, 13, 14, 3, '2026-06-12 18:00:00', 4, 1, 'groupes', NULL, 0),
(5, 7, 6, 4, '2026-06-13 12:00:00', 1, 1, 'groupes', NULL, 0),
(6, 9, 10, 1, '2026-06-13 18:00:00', 1, 1, 'groupes', NULL, 0),
(7, 11, 12, 10, '2026-06-13 21:00:00', 0, 1, 'groupes', NULL, 0),
(8, 15, 16, 11, '2026-06-13 21:00:00', 2, 0, 'groupes', NULL, 0),
(9, 17, 18, 2, '2026-06-14 12:00:00', 7, 1, 'groupes', NULL, 0),
(10, 19, 20, 9, '2026-06-14 19:00:00', 1, 0, 'groupes', NULL, 0),
(11, 21, 22, 14, '2026-06-14 15:00:00', 2, 2, 'groupes', NULL, 0),
(12, 23, 24, 15, '2026-06-14 20:00:00', 5, 1, 'groupes', NULL, 0),
(13, 25, 26, 8, '2026-06-15 12:00:00', 1, 1, 'groupes', NULL, 0),
(14, 27, 28, 5, '2026-06-15 18:00:00', 2, 2, 'groupes', NULL, 0),
(15, 29, 30, 6, '2026-06-15 12:00:00', 0, 0, 'groupes', NULL, 0),
(16, 31, 32, 6, '2026-06-15 18:00:00', 1, 1, 'groupes', NULL, 0),
(17, 33, 34, 1, '2026-06-16 15:00:00', 3, 1, 'groupes', NULL, 0),
(18, 36, 35, 10, '2026-06-16 18:00:00', 1, 4, 'groupes', NULL, 0),
(19, 37, 38, 7, '2026-06-16 20:00:00', 3, 0, 'groupes', NULL, 0),
(20, 39, 40, 4, '2026-06-16 21:00:00', 3, 1, 'groupes', NULL, 0),
(21, 41, 44, 2, '2026-06-17 12:00:00', 1, 1, 'groupes', NULL, 0),
(22, 43, 42, 14, '2026-06-17 20:00:00', 1, 3, 'groupes', NULL, 0),
(23, 45, 46, 14, '2026-06-17 15:00:00', 4, 2, 'groupes', NULL, 0),
(24, 47, 48, 12, '2026-06-17 19:00:00', 1, 0, 'groupes', NULL, 0),
(25, 4, 2, 14, '2026-06-18 12:00:00', 1, 1, 'groupes', NULL, 0),
(26, 6, 8, 3, '2026-06-18 12:00:00', 4, 1, 'groupes', NULL, 0),
(27, 5, 7, 11, '2026-06-18 15:00:00', 6, 0, 'groupes', NULL, 0),
(28, 1, 3, 15, '2026-06-18 19:00:00', 1, 0, 'groupes', NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `messages_contact`
--

CREATE TABLE `messages_contact` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sujet` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `lu` tinyint(1) DEFAULT 0,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages_contact`
--

INSERT INTO `messages_contact` (`id`, `nom`, `email`, `sujet`, `message`, `lu`, `date_creation`) VALUES(1, 'Jean Dupont', 'jean.dupont@gmail.com', 'signaler_erreur', 'Le score du match Mexique vs Afrique du Sud semble incorrect sur la page détail.', 1, '2026-06-05 17:23:41');
INSERT INTO `messages_contact` (`id`, `nom`, `email`, `sujet`, `message`, `lu`, `date_creation`) VALUES(2, 'Marie Martin', 'marie.martin@outlook.com', 'suggestion', 'Serait-il possible d\'ajouter les statistiques de possession de balle dans les aperçus IA ?', 0, '2026-06-05 17:23:41');
INSERT INTO `messages_contact` (`id`, `nom`, `email`, `sujet`, `message`, `lu`, `date_creation`) VALUES(3, 'Pierre Bernard', 'pierre.bernard@yahoo.fr', 'autre', 'Super site, j\'adore le design et les aperçus tactiques générés par IA. Continuez comme ça !', 0, '2026-06-05 17:23:41');

-- --------------------------------------------------------

--
-- Structure de la table `stades`
--

CREATE TABLE `stades` (
  `id` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `pays` varchar(50) NOT NULL,
  `capacite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stades`
--

INSERT INTO `stades` (`id`, `nom`, `ville`, `pays`, `capacite`) VALUES(1, 'MetLife Stadium', 'New York / New Jersey', 'USA', 82500);
INSERT INTO `stades` (`id`, `nom`, `ville`, `pays`, `capacite`) VALUES(2, 'AT&T Stadium', 'Dallas', 'USA', 80000);
INSERT INTO `stades` (`id`, `nom`, `ville`, `pays`, `capacite`) VALUES(3, 'SoFi Stadium', 'Los Angeles', 'USA', 70240);
INSERT INTO `stades` (`id`, `nom`, `ville`, `pays`, `capacite`) VALUES(4, 'Levi\'s Stadium', 'San Francisco', 'USA', 68500);
INSERT INTO `stades` (`id`, `nom`, `ville`, `pays`, `capacite`) VALUES(5, 'Hard Rock Stadium', 'Miami', 'USA', 65326);
INSERT INTO `stades` (`id`, `nom`, `ville`, `pays`, `capacite`) VALUES(6, 'Caesars Superdome', 'La Nouvelle-Orléans', 'USA', 73208);
INSERT INTO `stades` (`id`, `nom`, `ville`, `pays`, `capacite`) VALUES(7, 'Arrowhead Stadium', 'Kansas City', 'USA', 76416);
INSERT INTO `stades` (`id`, `nom`, `ville`, `pays`, `capacite`) VALUES(8, 'Lumen Field', 'Seattle', 'USA', 68740);
INSERT INTO `stades` (`id`, `nom`, `ville`, `pays`, `capacite`) VALUES(9, 'Lincoln Financial Field', 'Philadelphie', 'USA', 69796);
INSERT INTO `stades` (`id`, `nom`, `ville`, `pays`, `capacite`) VALUES(10, 'Gillette Stadium', 'Boston', 'USA', 65878);
INSERT INTO `stades` (`id`, `nom`, `ville`, `pays`, `capacite`) VALUES(11, 'BC Place', 'Vancouver', 'Canada', 54500);
INSERT INTO `stades` (`id`, `nom`, `ville`, `pays`, `capacite`) VALUES(12, 'BMO Field', 'Toronto', 'Canada', 45736);
INSERT INTO `stades` (`id`, `nom`, `ville`, `pays`, `capacite`) VALUES(13, 'Stade Olympique', 'Montréal', 'Canada', 61004);
INSERT INTO `stades` (`id`, `nom`, `ville`, `pays`, `capacite`) VALUES(14, 'Estadio Azteca', 'Mexico', 'Mexique', 87523);
INSERT INTO `stades` (`id`, `nom`, `ville`, `pays`, `capacite`) VALUES(15, 'Estadio BBVA', 'Monterrey', 'Mexique', 53500);
INSERT INTO `stades` (`id`, `nom`, `ville`, `pays`, `capacite`) VALUES(16, 'Estadio Akron', 'Guadalajara', 'Mexique', 49850);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe_hash` varchar(255) NOT NULL,
  `role` enum('admin','membre') NOT NULL DEFAULT 'membre',
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `email`, `mot_de_passe_hash`, `role`, `date_creation`) VALUES(1, 'admin@goalzone.be', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2026-06-05 17:22:10');
INSERT INTO `utilisateurs` (`id`, `email`, `mot_de_passe_hash`, `role`, `date_creation`) VALUES(2, 'membre1@goalzone.be', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'membre', '2026-06-05 17:22:10');
INSERT INTO `utilisateurs` (`id`, `email`, `mot_de_passe_hash`, `role`, `date_creation`) VALUES(3, 'membre2@goalzone.be', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'membre', '2026-06-05 17:22:10');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `confederations`
--
ALTER TABLE `confederations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Index pour la table `equipes`
--
ALTER TABLE `equipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groupe_id` (`groupe_id`),
  ADD KEY `confederation_id` (`confederation_id`);

--
-- Index pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD PRIMARY KEY (`utilisateur_id`,`equipe_id`),
  ADD KEY `equipe_id` (`equipe_id`);

--
-- Index pour la table `groupes`
--
ALTER TABLE `groupes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `joueurs`
--
ALTER TABLE `joueurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipe_id` (`equipe_id`);

--
-- Index pour la table `matchs`
--
ALTER TABLE `matchs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipe_dom_id` (`equipe_dom_id`),
  ADD KEY `equipe_ext_id` (`equipe_ext_id`),
  ADD KEY `stade_id` (`stade_id`);

--
-- Index pour la table `messages_contact`
--
ALTER TABLE `messages_contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stades`
--
ALTER TABLE `stades`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `confederations`
--
ALTER TABLE `confederations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `equipes`
--
ALTER TABLE `equipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `groupes`
--
ALTER TABLE `groupes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `joueurs`
--
ALTER TABLE `joueurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=289;

--
-- AUTO_INCREMENT pour la table `matchs`
--
ALTER TABLE `matchs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages_contact`
--
ALTER TABLE `messages_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `stades`
--
ALTER TABLE `stades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `equipes`
--
ALTER TABLE `equipes`
  ADD CONSTRAINT `equipes_ibfk_1` FOREIGN KEY (`groupe_id`) REFERENCES `groupes` (`id`),
  ADD CONSTRAINT `equipes_ibfk_2` FOREIGN KEY (`confederation_id`) REFERENCES `confederations` (`id`);

--
-- Contraintes pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD CONSTRAINT `favoris_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favoris_ibfk_2` FOREIGN KEY (`equipe_id`) REFERENCES `equipes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `joueurs`
--
ALTER TABLE `joueurs`
  ADD CONSTRAINT `joueurs_ibfk_1` FOREIGN KEY (`equipe_id`) REFERENCES `equipes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `matchs`
--
ALTER TABLE `matchs`
  ADD CONSTRAINT `matchs_ibfk_1` FOREIGN KEY (`equipe_dom_id`) REFERENCES `equipes` (`id`),
  ADD CONSTRAINT `matchs_ibfk_2` FOREIGN KEY (`equipe_ext_id`) REFERENCES `equipes` (`id`),
  ADD CONSTRAINT `matchs_ibfk_3` FOREIGN KEY (`stade_id`) REFERENCES `stades` (`id`);
COMMIT;

SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
