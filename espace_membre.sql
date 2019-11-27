-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  mer. 27 nov. 2019 à 18:16
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `espace_membre`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `name_partenaire` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_time_publication` datetime NOT NULL,
  `logo_img` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_inscription` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `pseudo` varchar(255) NOT NULL,
  `question` text,
  `response` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id`, `nom`, `prenom`, `mail`, `password`, `date_inscription`, `pseudo`, `question`, `response`) VALUES
(8, 'Ricard', 'Elodie', 'elodie.ricard.cynthia@gmail.com', '83787f060a59493aefdcd4b2369990e7303e186e', NULL, '', '', ''),
(10, 'Compper', 'Michel', 'compper.michel@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, '', '', ''),
(18, 'Ricard', 'Elodie', 'ricard.cynthia@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2019-11-27 17:27:36', 'elodie32', NULL, NULL),
(19, 'Ricard', 'Elodie', 'a@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2019-11-27 17:33:46', 'elodie33', NULL, NULL),
(20, 'Ricard', 'Elodie', 'bccc@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2019-11-27 17:36:57', 'elodie34', NULL, NULL),
(21, 'Ricard', 'Elodie', 'cc@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2019-11-27 17:38:42', 'elodie35', NULL, NULL),
(22, 'Ricard', 'Elodie', 'd.cynthia@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2019-11-27 17:41:41', 'elodie36', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
