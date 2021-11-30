-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 30 nov. 2021 à 10:14
-- Version du serveur :  5.7.34
-- Version de PHP : 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `reservationsalles`
--

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `debut` datetime NOT NULL,
  `fin` datetime NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `titre`, `description`, `debut`, `fin`, `id_utilisateur`) VALUES
(1, 'Réunion', 'Réunion de travail', '2021-11-30 14:00:00', '2021-11-30 14:00:00', 1),
(3, 'Réunion', 'Réunion de travail', '2021-11-26 14:00:00', '2021-11-26 15:00:00', 2),
(4, 'Entretien', 'Réunion de travail', '2021-12-16 16:00:00', '2021-11-26 17:00:00', 3),
(5, 'Entretien', 'Réunion de travail', '2021-11-29 09:00:00', '2021-11-29 10:00:00', 4),
(12, 'Conférence', 'Conférence de magie', '2021-12-02 10:00:00', '2021-12-02 11:00:00', 5),
(28, 'Jury', 'Jury', '2021-12-07 16:00:00', '2021-12-07 17:00:00', 1),
(29, 'Atelier', 'Atelier', '2021-12-09 11:00:00', '2021-12-09 12:00:00', 2);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `password`) VALUES
(1, 'Callum', '$2y$10$PG/B.MlJUnHlcJjx.8Z.TOQjpgTqobnPHMUgIhJ7AFarc.//JG/EC'),
(2, 'Rayla', '$2y$10$NkA.CQpUDbAiAQfI3ODUAu3OnhpWgYzHOENE2wAn6ggQlKf4KzcM2'),
(3, 'Ezran', '$2y$10$2jfoVXakRguD5OYqqlbyvuTplh.u2.PIp.9uJRzQ/PdBU8HlzbxvG'),
(4, 'Claudia', '$2y$10$y9LyDs90SiqMIc2RbaaXfOpt2e62KHMiiceVlUSvkX3XhYLf1m.5e'),
(5, 'Runaan', '$2y$10$G1e8uz.lOHYlE1JcEyvd5e3jTfH11mEguvOgmo8g8cKIviORR/Vwa');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
