-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : Dim 07 fév. 2021 à 15:26
-- Version du serveur :  5.7.30
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données : `room`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id_avis` int(3) NOT NULL,
  `id_membre` int(3) NOT NULL,
  `id_salle` int(3) NOT NULL,
  `commentaire` text NOT NULL,
  `note` int(2) NOT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id_avis`, `id_membre`, `id_salle`, `commentaire`, `note`, `date_enregistrement`) VALUES
(2, 5, 23, 'coucouy', 5, '2021-02-07 14:06:02'),
(3, 6, 24, 'Salle vaste est agréable , je recommande !', 4, '2021-01-05 09:01:50'),
(59, 5, 24, 'belle salle, service top!', 2, '2021-02-07 14:00:56'),
(61, 5, 28, 'Nice and cozy', 5, '2021-02-07 10:52:01'),
(62, 5, 29, 'Acceptable ', 2, '2021-02-07 14:01:46');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(3) NOT NULL,
  `id_membre` int(3) NOT NULL,
  `id_produit` int(3) NOT NULL,
  `date_enregistrement` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_membre`, `id_produit`, `date_enregistrement`) VALUES
(1, 5, 3, '2021-01-31'),
(2, 3, 8, '2021-01-31'),
(3, 6, 4, '2021-01-31'),
(259, 5, 8, '2021-02-06'),
(260, 5, 8, '2021-02-06'),
(265, 5, 10, '2021-02-06'),
(267, 5, 9, '2021-02-07'),
(269, 10, 12, '2021-02-07');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(3) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('f','m') NOT NULL,
  `statut` int(1) NOT NULL,
  `date_enregistrement` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(3, 'jiji', '$2y$10$.sBinAcYmoq5c6OY452sYeoxjswV2Lk8.ZnC/JBFGSvf74DYkxX0i', 'Doe', 'Jane', 'jane@doe.com', 'f', 0, '2021-02-07'),
(5, 'jinny', '$2y$10$aFL4NSjWm.sc.T7dO85Sne.QwJcPDlcneftcRPHDwU98Jr5QjrcE6', 'Jinan', 'Alaouf', 'jinanrae@jinan.com', 'f', 1, '2021-02-07'),
(6, 'hado', '$2y$10$JFlUQxYJ5PY9XFlcWGTUZORpvtBSIxuJiH4EFn5KYnlG9l5jxNH.K', 'jojo', 'meme', 'mimi@jiji.com', 'f', 0, '2021-02-07'),
(7, 'yoyo', '$2y$10$VPioIdHLlwK5GLaaxXEEpuqGRSUMf7MPUDg8E551uyTshBHk3xIIC', 'jerry', 'terry', 'jerry@terry.com', 'm', 0, '2021-02-01'),
(9, 'debo', '$2y$10$cuKNFwaUwTz4T53nMuggouO3OHGyJiZmQ8JnbjKI4NtBkaVrKKWem', 'Derry', 'Berry', 'dery@bery.com', 'f', 0, '2021-01-22'),
(10, 'omi', '$2y$10$FnI3ygh7x0QAGaDJ/YfaC..pvj2bEnTAJL12uFhaH5zu75Pl1JO7O', 'homer', 'simpson', 'homer@sim.com', 'm', 0, '2021-02-07'),
(11, 'bobi', '$2y$10$0TZsDL/MWeTDo/mkc/PqZ.BBUxXWeUXciop6agDG3I038HwcpQ1cS', 'eponge', 'bob', 'bob@eponge.com', 'm', 0, '2021-02-07'),
(12, 'fredo', '$2y$10$RFGxbprBfAliNxtPbOyLHOt9YMzU732NIgCWUxBKinCE6EdhomeGO', 'fred', 'flinstone', 'fred@flins.com', 'm', 0, '2021-01-22'),
(13, 'papi', '$2y$10$zD.rLKxH.vw84N9oaKdOzOzkCmfYG18IgeDM0Ok8jzPDsJmDdxvee', 'barny', 'garny', 'barny@garny.com', 'm', 0, '2021-01-22'),
(15, 'mommy', '$2y$10$F334qv4HSvdvLarNrUAEteROckk9h.6K8D4nvV68YhrTIUrK3vRKm', 'dany', 'nani', 'john@gmail.com', 'm', 0, '2021-02-07'),
(17, 'lili', '0', 'lalane', 'lilas', 'lili@lala.com', 'f', 0, '2021-02-06'),
(18, 'bobo', '0', 'bob', 'bobin', 'bobo@boba.com', 'm', 0, '2021-02-07'),
(20, 'mary', '$2y$10$00lFosNq7Eq7/6Ck8n6Va.rXLkvivc15V6dVYZDVKKxnmMJAdN4la', 'maria', 'BD', 'maria@gmail.com', 'f', 0, '2021-02-07');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(3) NOT NULL,
  `id_salle` int(3) NOT NULL,
  `date_arrive` date NOT NULL,
  `date_depart` date NOT NULL,
  `prix` int(3) NOT NULL,
  `etat` enum('libre','reservation') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `id_salle`, `date_arrive`, `date_depart`, `prix`, `etat`) VALUES
(3, 24, '2021-01-31', '2021-01-26', 200, 'libre'),
(4, 29, '2021-03-01', '2021-03-22', 3000, 'libre'),
(8, 25, '2021-04-01', '2021-04-05', 1200, 'libre'),
(9, 24, '2021-04-01', '2021-04-08', 1200, 'libre'),
(10, 23, '2021-07-01', '2021-01-07', 9000, 'libre'),
(11, 26, '2021-07-06', '2021-01-15', 600, 'libre'),
(12, 23, '2021-11-10', '2021-11-20', 1000, 'libre'),
(13, 27, '2021-03-31', '2021-04-04', 500, 'libre'),
(19, 26, '2021-08-06', '2021-08-16', 1500, 'libre'),
(20, 29, '2021-07-01', '2021-07-06', 700, 'libre'),
(21, 23, '2021-04-06', '2021-04-17', 6000, 'libre'),
(22, 23, '2021-06-02', '2021-06-09', 70, 'libre'),
(23, 23, '2021-05-05', '2021-05-20', 35, 'libre');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE `salle` (
  `id_salle` int(3) NOT NULL,
  `titre` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(200) NOT NULL,
  `pays` varchar(20) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `cp` int(5) NOT NULL,
  `capacite` int(3) NOT NULL,
  `categorie` enum('reunion','bureau','formation') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id_salle`, `titre`, `description`, `photo`, `pays`, `ville`, `adresse`, `cp`, `capacite`, `categorie`) VALUES
(23, 'Cézanne', 'Grande salle de réunion ', 'photos/601564a572a01_salle-blanc.jpeg', 'France', 'Paris', '17 rue Turbigo', 75002, 5, 'reunion'),
(24, 'Mozrat', 'Salle lumineuse et spacieuse ', 'photos/600fd3911737f_salle-4 copie.jpeg', 'France', 'Lyon', '28 quai Claude Bernard', 69007, 30, 'formation'),
(25, 'Monet', 'Très grande salle', 'photos/601564b60e092_salle-bleu.jpg', 'France', 'Paris', '3,  rue de la paix', 75005, 10, 'reunion'),
(26, 'Renoir', 'Salle calme, bien  équipée ', 'photos/601564c626c01_salle-grise.jpg', 'France', 'Marseille', '2 rue da la paix', 9876, 30, 'formation'),
(27, 'Van Gogh', 'Jolie salle bien pour vos réunions de travail ', 'photos/601564dbbed1d_salle-orang.jpg', 'France', 'Paris', '3,  rue de la paix', 75005, 10, 'reunion'),
(28, 'Chopin', 'Bureau  pour travailler au calme ', 'photos/60156540b567f_bureau.jpg', 'France', 'Lyon', '1 rue paris', 95370, 5, 'bureau'),
(29, 'Duchamp ', 'Salle agréable et confortable ', 'photos/601564f047fa7_salle-rouge.jpg', 'France', 'Paris', 'Avenue Rome', 65098, 10, 'bureau');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id_avis`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`id_salle`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id_avis` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `salle`
--
ALTER TABLE `salle`
  MODIFY `id_salle` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;