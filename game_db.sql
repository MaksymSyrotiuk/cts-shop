-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 27. Feb 2025 um 01:00
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `game_db`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Daten für Tabelle `inventory`
--

INSERT INTO `inventory` (`id`, `player_id`, `item_id`, `quantity`) VALUES
(5, 16, 1, 52),
(6, 16, 2, 12),
(7, 16, 3, 1),
(8, 16, 17, 1),
(9, 19, 4, 1),
(10, 19, 12, 1),
(11, 19, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `category` enum('armor','weapon','implant','medical','misc') NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `armor` int(11) DEFAULT 0,
  `strength` int(11) DEFAULT 0,
  `intelligence` int(11) DEFAULT 0,
  `hp` int(11) DEFAULT 0,
  `stamina` int(11) DEFAULT 0,
  `psych_resistance` int(11) DEFAULT 0,
  `hp_regen` int(11) DEFAULT 0,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Daten für Tabelle `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `price`, `category`, `image_url`, `armor`, `strength`, `intelligence`, `hp`, `stamina`, `psych_resistance`, `hp_regen`, `quantity`) VALUES
(1, 'Tactical ExoSuit MK-I', 'An advanced exoskeleton designed for high mobility and protection.', 1500, 'armor', 'media/armor1.png', 10, 0, 0, 0, -2, 0, 0, 20),
(2, 'Shadow Armor X-22', 'Lightweight armor providing enhanced agility and minor ballistic resistance.', 1200, 'armor', 'media/armor2.png', 8, 0, 0, 0, 0, 0, 0, 1),
(3, 'Titan Heavy Vest', 'A reinforced bulletproof vest that offers maximum protection at the cost of agility.', 2000, 'armor', 'media/armor3.png', 15, 0, 0, 0, -5, 0, 0, 3),
(4, 'Reaper Stealth Suit', 'A cutting-edge stealth suit with limited armor but no movement penalties.', 1000, 'armor', 'media/armor4.png', 5, 0, 0, 0, 0, 0, 0, 4),
(5, 'Inferno Combat Gear', 'Fire-resistant combat armor with built-in heat dispersal systems.', 1700, 'armor', 'media/armor5.png', 12, 0, 0, 0, -3, 0, 0, 1),
(6, 'Sentinel Forcefield Rig', 'Advanced armor with integrated energy shielding for enhanced survivability.', 2500, 'armor', 'media/armor6.png', 20, 0, 0, 0, -6, 0, 0, 1),
(7, 'Vortex Plasma Rifle', 'A high-tech plasma rifle with devastating firepower.', 3000, 'weapon', 'media/weapon1.png', 0, 6, 0, 0, -3, 0, 0, 5),
(8, 'Hellfire SMG', 'A compact submachine gun with incendiary rounds.', 2500, 'weapon', 'media/weapon2.png', 0, 4, 0, 0, -2, 0, 0, 1),
(9, 'Thunderstrike Shotgun', 'A powerful shotgun that delivers high-impact electric rounds.', 3500, 'weapon', 'media/weapon3.png', 0, 8, 0, 0, -4, 0, 0, 2),
(10, 'Raven Sniper X-9', 'A high-precision sniper rifle with an advanced scope.', 4000, 'weapon', 'media/weapon4.png', 0, 5, 0, 0, -3, 0, 0, 6),
(11, 'Daggerfang Blade', 'A cyber-enhanced blade designed for swift and deadly strikes.', 1200, 'weapon', 'media/weapon5.png', 0, 3, 0, 0, 0, 0, 0, 5),
(12, 'Havoc Rocket Launcher', 'A shoulder-mounted launcher firing explosive projectiles.', 5000, 'weapon', 'media/weapon6.png', 0, 10, 0, 0, -6, 0, 0, 3),
(13, 'Neural Booster X', 'Enhances neural connections, improving intelligence and reflexes.', 1800, 'implant', 'media/implant1.png', 0, 0, 6, 0, 2, 0, 0, 3),
(14, 'Bionic Muscle Enhancer', 'Cybernetic implants that enhance muscle strength.', 2200, 'implant', 'media/implant2.png', 0, 7, 0, 0, 3, 0, 0, 5),
(15, 'Nano Regenerator', 'An advanced biotech implant that accelerates cellular regeneration.', 2700, 'implant', 'media/implant3.png', 0, 0, 0, 10, 0, 0, 5, 2),
(16, 'Cyber-Eye Mk2', 'Augmented vision module with thermal and night vision.', 2000, 'implant', 'media/implant4.png', 0, 0, 5, 0, 0, 3, 0, 2),
(17, 'Titanium Bone Reinforcement', 'Strengthens the skeletal structure, reducing physical damage taken.', 3000, 'implant', 'media/implant5.png', 5, 4, 0, 0, 0, 0, 0, 3),
(18, 'Phantom Reflex Chip', 'Increases reaction time for quicker responses in combat.', 2500, 'implant', 'media/implant6.png', 0, 0, 5, 0, 4, 0, 0, 3),
(19, 'NanoStim Injector', 'A fast-acting nanobot serum that repairs wounds instantly.', 500, 'medical', 'media/med1.png', 0, 0, 0, 3, 0, 0, 0, 4),
(20, 'BioShield Serum', 'Boosts the immune system and temporarily reduces incoming damage.', 800, 'medical', 'media/med2.png', 0, 0, 0, 10, 0, 3, 0, 5),
(21, 'NeuroPatch', 'A cognitive enhancer that reduces mental fatigue.', 600, 'medical', 'media/med3.png', 0, 0, 4, 0, 0, 0, 0, 10),
(22, 'Adrenaline Booster', 'Increases physical performance for a short duration.', 900, 'medical', 'media/med4.png', 0, 4, 0, 0, 5, 0, 0, 21),
(23, 'Toxic Purge Pill', 'Neutralizes poisons and radiation exposure.', 700, 'medical', 'media/med5.png', 0, 0, 0, 0, 0, 5, 0, 6),
(24, 'MedKit V3', 'A high-quality first aid kit for emergency medical treatment.', 1200, 'medical', 'media/med6.png', 0, 0, 0, 15, 0, 0, 0, 27),
(25, 'Hacking Module X', 'A state-of-the-art hacking tool for bypassing security systems.', 1500, 'misc', 'media/misc1.png', 0, 0, 0, 0, 0, 0, 0, 10),
(26, 'EMP Grenade', 'Disrupts electronic devices and shields in a radius.', 1000, 'misc', 'media/misc2.png', 0, 0, 0, 0, 0, 0, 0, 1),
(27, 'Cloaking Device', 'Provides temporary invisibility to avoid detection.', 2500, 'misc', 'media/misc3.png', 0, 0, 0, 0, 0, 0, 0, 12),
(28, 'Portable Shield Generator', 'Deploys a temporary energy barrier for protection.', 2000, 'misc', 'media/misc4.png', 0, 0, 0, 0, 0, 0, 0, 10),
(29, 'Data Chip: Classified Intel', 'Contains sensitive information that can be sold for high value.', 3000, 'misc', 'media/misc5.png', 0, 0, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `birth_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `echo_credits` int(11) DEFAULT 10000,
  `level` int(11) DEFAULT 1,
  `class` enum('Human','Cyborg','Mutant') DEFAULT 'Human',
  `strength` int(11) DEFAULT 5,
  `hp` int(11) DEFAULT 5,
  `stamina` int(11) DEFAULT 5,
  `hp_regen` int(11) DEFAULT 5,
  `intelligence` int(11) DEFAULT 5,
  `armor` int(11) DEFAULT 5,
  `psych_resistance` int(11) DEFAULT 5,
  `weapon` varchar(50) DEFAULT 'none',
  `skill_points` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Daten für Tabelle `players`
--

INSERT INTO `players` (`id`, `username`, `email`, `password_hash`, `gender`, `birth_date`, `created_at`, `echo_credits`, `level`, `class`, `strength`, `hp`, `stamina`, `hp_regen`, `intelligence`, `armor`, `psych_resistance`, `weapon`, `skill_points`) VALUES
(15, 'Nick', 'nick@gmail.com', '$2y$10$rLNnM2xDKbB3g1/bcXejmeuPoyJwAHQ.N0bZwqxpWt/C1cS07NHJi', 'Male', '2004-05-26', '2025-02-04 12:38:31', 100, 1, 'Human', 5, 5, 5, 5, 5, 5, 5, 'none', 0),
(16, 'Nick2', 'nick2@gmail.com', '$2y$10$JaY9I/igjVif8cgAd7/57.iQcTTbxS4/IAbl55aO28BjvTz01TRXu', 'Male', '2025-02-08', '2025-02-04 12:39:23', 518825, 67, 'Human', 40, 35, 20, 22, 10, 22, 21, 'none', 195),
(17, 'Nick3', 'htherh@gmail.com', '$2y$10$zdY5NYdR1d8Vhp/RTNLHZ.zrQ7cZXcZ1AYcgNVDC0BoY3sbbkRcBu', 'Male', '2025-02-23', '2025-02-16 19:12:38', 9145, 19, 'Human', 11, 6, 10, 20, 5, 19, 6, 'none', 48),
(18, 'Nick22', 'asdfasf@gmail.com', '$2y$10$U/bwqZGXKRjNbyzaafK9xOhBAN9zUbvMuvAl1yneCE34IaJTlQZG.', 'Male', '2025-02-07', '2025-02-18 13:30:46', 25, 6, 'Human', 6, 6, 6, 7, 5, 6, 5, 'none', 19),
(19, 'Gag', 'gag@gag.com', '$2y$10$2Q/DmuVLiF2VvFxUA3xxqufcv8AmgdJ33xj0TZfFMkmLLqe0mS/Pi', 'Male', '2025-02-15', '2025-02-26 13:09:58', -2505, 2, 'Human', 9, 6, 5, 5, 5, 5, 5, 'none', 0),
(20, 'Exp', 'exp@gfg.d', '$2y$10$gBeEt2vJxLWbq52swR95ieTAPCSr1bR0bCc8A12pTa1/7k8qDizF6', 'Male', '2025-02-13', '2025-02-26 20:41:36', 10000, 1, 'Human', 5, 5, 5, 5, 5, 5, 5, 'none', 0),
(22, 'Expa', 'eherdhtr@reg.rg', '$2y$10$vanHl6vPWy.rw7JRxbYpLuIEAtXy5NtpqvEWvi3SdeeDRyAE8fqz6', 'Male', '2005-01-12', '2025-02-26 20:44:46', 10000, 1, 'Human', 5, 5, 5, 5, 5, 5, 5, 'none', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `purchase_time` datetime DEFAULT NULL,
  `item_quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Daten für Tabelle `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `item_id`, `total_price`, `purchase_time`, `item_quantity`) VALUES
(1, 16, 1, 1500.00, '2025-02-20 11:33:17', 1),
(2, 16, 1, 1500.00, '2025-02-20 11:33:59', 1),
(3, 16, 1, 1500.00, '2025-02-20 11:35:28', 1),
(4, 16, 1, 1500.00, '2025-02-20 11:36:12', 1),
(5, 16, 1, 6000.00, '2025-02-20 13:34:23', 1),
(6, 16, 1, 1500.00, '2025-02-20 13:38:31', 1),
(7, 16, 1, 1500.00, '2025-02-20 13:39:18', 1),
(8, 16, 1, 1500.00, '2025-02-20 13:39:34', 1),
(9, 16, 1, 54000.00, '2025-02-20 13:39:40', 1),
(10, 16, 1, 6000.00, '2025-02-20 14:25:12', 1),
(11, 16, 2, 4800.00, '2025-02-25 18:57:05', 1),
(12, 16, 2, 4800.00, '2025-02-25 18:57:31', 1),
(13, 16, 3, 2000.00, '2025-02-25 18:58:11', 1),
(14, 16, 2, 1200.00, '2025-02-25 18:58:30', 1),
(15, 16, 2, 10800.00, '2025-02-25 18:58:47', 1),
(16, 16, 2, 4800.00, '2025-02-25 19:05:32', 1),
(17, 16, 2, 4800.00, '2025-02-25 19:16:48', 2),
(18, 16, 1, 24000.00, '2025-02-25 19:21:54', 4),
(19, 16, 1, 6000.00, '2025-02-25 19:22:47', 4),
(20, 16, 1, 1500.00, '2025-02-26 10:36:41', 1),
(21, 16, 1, 1500.00, '2025-02-26 10:36:54', 3),
(22, 16, 17, 3000.00, '2025-02-26 12:31:03', 1),
(23, 19, 4, 1000.00, '2025-02-26 14:37:27', 1),
(24, 19, 12, 5000.00, '2025-02-26 19:35:57', 1),
(25, 19, 1, 1500.00, '2025-02-26 19:36:05', 1),
(26, 16, 1, 1500.00, '2025-02-26 23:38:12', 1),
(27, 16, 1, 39000.00, '2025-02-27 00:06:03', 26);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indizes für die Tabelle `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT für Tabelle `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT für Tabelle `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
