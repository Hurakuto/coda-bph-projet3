-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : ven. 12 déc. 2025 à 17:42
-- Version du serveur : 5.7.44
-- Version de PHP : 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `coda_bph_projet3`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Nourriture'),
(2, 'Ecole'),
(3, 'Transport'),
(4, 'Logement'),
(5, 'Sorties');

-- --------------------------------------------------------

--
-- Structure de la table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `amount_100` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL,
  `motif` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `expenses`
--

INSERT INTO `expenses` (`id`, `amount_100`, `id_user`, `id_category`, `motif`) VALUES
(39, 50000, 2, 1, 'kebab'),
(40, 2000, 1, 4, 'hotel'),
(41, 10000, 1, 1, 'tacos'),
(42, 10000, 2, 4, 'test'),
(43, 15000, 2, 1, 'kebab'),
(44, 10000, 1, 5, 'cinema'),
(45, 10000000, 2, 4, 'achat appartement'),
(46, 10000000, 2, 4, 'achat appartement'),
(47, 2000, 1, 1, 'jambon'),
(48, 600000, 3, 5, 'vacances à Hawaii'),
(49, 10000, 3, 1, 'Kebab');

-- --------------------------------------------------------

--
-- Structure de la table `refunds`
--

CREATE TABLE `refunds` (
  `id` int(11) NOT NULL,
  `payer_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `amount_100` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `refunds`
--

INSERT INTO `refunds` (`id`, `payer_id`, `receiver_id`, `amount_100`) VALUES
(25, 3, 2, 16666),
(28, 3, 2, 5000),
(30, 3, 2, 5000),
(32, 3, 1, 3333),
(33, 3, 2, 5000000),
(34, 1, 2, 5000000),
(35, 2, 1, 666),
(36, 3, 1, 666),
(37, 1, 3, 200000),
(38, 2, 3, 200000),
(39, 1, 3, 5000);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `total_100` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`, `role`, `total_100`) VALUES
(1, 'Tom', 'CIZEAU', 'cizeautom404@gmail.com', '$2y$10$NKWKToEdpmYmXd8xqK.E0uvA0pRknIB06bbV5Tb4N6KloYQM3t4ZK', 'ADMIN', 13767),
(2, 'Robin', 'Delayre', 'robin.delayre@icloud.com', '$2y$10$CpLRYZKywHM/JVl5rBmt6.QsgfUhqgiAJE57b9Ka1WAsWW/EgwZCq', 'ADMIN', 1238915381),
(3, 'test', 'test', 'test@test.com', '$2y$10$KAnFRinei2MIZLrCrXBfce2RafsVakoz4kYAmutc/s0/hffTyI6lK', 'USER', 1390000);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_category` (`id_category`);

--
-- Index pour la table `refunds`
--
ALTER TABLE `refunds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payer_id` (`payer_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `refunds`
--
ALTER TABLE `refunds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`id_category`) REFERENCES `category` (`id`);

--
-- Contraintes pour la table `refunds`
--
ALTER TABLE `refunds`
  ADD CONSTRAINT `refunds_ibfk_1` FOREIGN KEY (`payer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `refunds_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
