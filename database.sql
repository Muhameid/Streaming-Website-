-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 24 avr. 2024 à 08:16
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
-- Base de données : `streaming_website`
--

-- --------------------------------------------------------

--
-- Structure de la table `appartenir`
--

CREATE TABLE `appartenir` (
  `id_f` int(11) NOT NULL,
  `id_cat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id_cat` int(11) NOT NULL,
  `libelle_cat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_cat`, `libelle_cat`) VALUES
(1, 'Action et aventure'),
(2, 'Comédie'),
(3, 'Drame'),
(4, 'Science-fiction et fantastique'),
(5, 'Thriller et suspense'),
(6, 'Animation');

-- --------------------------------------------------------

--
-- Structure de la table `films`
--

CREATE TABLE `films` (
  `id_f` int(11) NOT NULL,
  `id_cat` int(11) NOT NULL,
  `nom_f` varchar(50) NOT NULL,
  `duree_f` int(11) NOT NULL,
  `description_f` text NOT NULL,
  `lien_f` varchar(255) NOT NULL,
  `imag_f` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `films`
--

INSERT INTO `films` (`id_f`, `id_cat`, `nom_f`, `duree_f`, `description_f`, `lien_f`, `imag_f`) VALUES
(19, 1, 'Buchigirri', 0, 'Manga', 'includes\\Video\\ Bucchigiri 07 VOSTFR.mp4', ''),
(40, 4, 'Batman', 1, 'Sciences', 'includes\\Video\\ poul.mp4', ''),
(42, 1, 'Blue Lock', 2, 'Nagi -Isaki episode 9 vostfr', 'includes\\Video\\ Blue_Lock_21_VOSTFR _ Mavanime.mp4', ''),
(43, 4, 'Blue Lock', 4, 'Nagi -Isaki episode 10 vostfr', 'includes\\Video\\ Blue Lock - 10 VOSTFR Voiranime.mp4', ''),
(44, 1, 'Blue Lock', 12, 'Nagi -Isaki episode 11 vostfr', 'includes\\Video\\ Blue Lock 20 VOSTFR _ Mavanime.mp4', ''),
(45, 1, 'Blue Lock', 1, 'Nagi -Isaki episode 13 vostfr', 'includes\\Video\\  poul.mp4', 'includes\\Video\\  Ichigo.jpg'),
(46, 5, 'Breaker Wind', 1, 'Pouvoir', 'includes\\Video\\  poul.mp4', 'includes\\Video\\ ');

-- --------------------------------------------------------

--
-- Structure de la table `regarder`
--

CREATE TABLE `regarder` (
  `id_commentaire` int(11) NOT NULL,
  `id_f` int(11) NOT NULL,
  `id_m` int(11) NOT NULL,
  `note` enum('Mauvais','Pas mal','Bien','Excellent') DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `favori` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_m` int(11) NOT NULL,
  `login` varchar(35) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `lvl` int(11) DEFAULT 1,
  `date_deb_abo` datetime NOT NULL,
  `date_fin_abo` datetime NOT NULL,
  `ip_ban` varchar(20) NOT NULL,
  `type_abonnement_en_jours` int(11) DEFAULT 2 CHECK (`type_abonnement_en_jours` in (2,3,5))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_m`, `login`, `email`, `mdp`, `lvl`, `date_deb_abo`, `date_fin_abo`, `ip_ban`, `type_abonnement_en_jours`) VALUES
(1, 'admin', 'admin@gmail.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0', NULL),
(6, 'Todorki Shoto', 'user@gmail.com', '12dea96fec20593566ab75692c9949596833adc9', 1, '2024-04-23 22:28:38', '2024-04-28 22:28:38', '::1', 5);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `appartenir`
--
ALTER TABLE `appartenir`
  ADD PRIMARY KEY (`id_f`,`id_cat`),
  ADD KEY `id_cat` (`id_cat`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_cat`);

--
-- Index pour la table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id_f`),
  ADD KEY `fk_cat` (`id_cat`);

--
-- Index pour la table `regarder`
--
ALTER TABLE `regarder`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `id_m` (`id_m`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_m`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_cat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `films`
--
ALTER TABLE `films`
  MODIFY `id_f` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `regarder`
--
ALTER TABLE `regarder`
  MODIFY `id_commentaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_m` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appartenir`
--
ALTER TABLE `appartenir`
  ADD CONSTRAINT `appartenir_ibfk_1` FOREIGN KEY (`id_f`) REFERENCES `films` (`id_f`),
  ADD CONSTRAINT `appartenir_ibfk_2` FOREIGN KEY (`id_cat`) REFERENCES `categories` (`id_cat`);

--
-- Contraintes pour la table `films`
--
ALTER TABLE `films`
  ADD CONSTRAINT `fk_cat` FOREIGN KEY (`id_cat`) REFERENCES `categories` (`id_cat`);

--
-- Contraintes pour la table `regarder`
--
ALTER TABLE `regarder`
  ADD CONSTRAINT `regarder_ibfk_1` FOREIGN KEY (`id_f`) REFERENCES `films` (`id_f`),
  ADD CONSTRAINT `regarder_ibfk_2` FOREIGN KEY (`id_m`) REFERENCES `users` (`id_m`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
