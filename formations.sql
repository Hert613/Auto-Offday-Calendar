-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le : mer. 18 juin 2025 à 12:24
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `formation`
--

-- --------------------------------------------------------

--
-- Structure de la table `formations`
--

DROP TABLE IF EXISTS `formations`;
CREATE TABLE IF NOT EXISTS `formations` (
  `id` int NOT NULL,
  `intitule` text NOT NULL,
  `niveau` text,
  `duree` text,
  `modalite` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `formations`
--

INSERT INTO `formations` (`id`, `intitule`, `niveau`) VALUES
(1, 'CAP Accompagnant éducatif petite enfance', 'CAP'),
(2, 'Titre professionnel Commis de cuisine', 'Titre Professionnel'),
(3, 'Diplôme d\'État aide-soignant', 'Diplôme d\'État'),
(4, 'BTS Services informatiques aux organisations (SISR)', 'Bac+2'),
(5, 'Titre professionnel Développeur intégrateur web', 'Titre Professionnel Niveau 5'),
(6, 'CAP Boulanger', 'CAP'),
(7, 'Titre professionnel Data Analyst', 'Titre Professionnel Niveau 6'),
(8, 'BTS Négociation et digitalisation de la relation client (NDRC)', 'Bac+2'),
(9, 'Diplôme d’État Auxiliaire de Puériculture (DEAP)', 'Diplôme d’État'),
(10, 'Diplôme d’État Accompagnant Éducatif et Social (DEAES)', 'Diplôme d’État'),
(11, 'Diplôme d’État Aide-Soignant (DEAS)', 'Diplôme d’État');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
