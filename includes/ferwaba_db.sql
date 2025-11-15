-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2025 at 09:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ferwaba_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` enum('SuperAdmin','SubAdmin') DEFAULT 'SubAdmin',
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `full_name`, `email`, `password`, `role`, `is_active`) VALUES
(1, 'Super Admin', 'admin@ferwaba.rw', 'f865b53623b121fd34ee5426c792e5c33af8c227', 'SuperAdmin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `coaches`
--

CREATE TABLE `coaches` (
  `id` int(11) NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `role` enum('Head Coach','Assistant Coach','Team Staff') DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `team_id`, `image`, `caption`, `uploaded_at`) VALUES
(1, 5, 'gallery_1761148793_4c2ccbeb.png', '', '2025-10-22 15:59:53'),
(2, 5, 'gallery_1761735317_0554e35f.png', '', '2025-10-29 10:55:17');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `home_team_id` int(11) DEFAULT NULL,
  `away_team_id` int(11) DEFAULT NULL,
  `game_date` date DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `home_score` int(11) DEFAULT 0,
  `away_score` int(11) DEFAULT 0,
  `division` enum('Division 1','Division 2') DEFAULT NULL,
  `gender` enum('Men','Women') DEFAULT NULL,
  `status` enum('Scheduled','Completed') DEFAULT 'Scheduled',
  `highlight_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `home_team_id`, `away_team_id`, `game_date`, `location`, `home_score`, `away_score`, `division`, `gender`, `status`, `highlight_url`) VALUES
(6, 6, 5, '2025-10-20', 'nakka', 89, 78, 'Division 1', 'Men', 'Completed', 'hb'),
(7, 5, 6, '2025-10-20', 'BK Arena', 123, 89, 'Division 1', 'Men', 'Completed', 'hb'),
(8, 8, 7, '2025-10-21', 'kigali-Rwanda', 128, 98, 'Division 1', 'Men', 'Completed', ''),
(9, 5, 8, '2025-10-21', 'BK Arena', 94, 89, 'Division 1', 'Men', 'Completed', ''),
(10, 6, 7, '2025-10-30', 'nakka', 0, 0, 'Division 1', 'Men', 'Scheduled', '');

-- --------------------------------------------------------

--
-- Table structure for table `national_coaches`
--

CREATE TABLE `national_coaches` (
  `id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(50) DEFAULT 'Head Coach',
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `national_players`
--

CREATE TABLE `national_players` (
  `id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(50) DEFAULT NULL,
  `jersey_number` int(11) DEFAULT NULL,
  `club` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `national_players`
--

INSERT INTO `national_players` (`id`, `team_id`, `name`, `position`, `jersey_number`, `club`, `photo`, `created_at`) VALUES
(1, 1, 'Ntore habimana', 'pg', 12, 'APR', '1760609955_Screenshot 2025-10-06 103740.png', '2025-10-16 10:19:15'),
(2, 2, 'APR', '0', 12, 'APR', '1763041415_kit.jpg', '2025-11-13 13:43:35');

-- --------------------------------------------------------

--
-- Table structure for table `national_teams`
--

CREATE TABLE `national_teams` (
  `id` int(11) NOT NULL,
  `team_name` varchar(100) NOT NULL,
  `category` enum('Senior Men','Senior Women','U18 Men','U18 Women','U16 Men','U16 Women') NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `national_teams`
--

INSERT INTO `national_teams` (`id`, `team_name`, `category`, `banner_image`, `created_at`) VALUES
(1, 'Amavubi', 'Senior Men', '1760609905_Screenshot 2025-10-06 103751.png', '2025-10-16 10:18:25'),
(2, 'Amavubi', 'U18 Men', '1763041398_logo.png', '2025-11-13 13:43:18');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `category` enum('Latest','Transfers','Injuries','Squad Updates') DEFAULT 'Latest',
  `image` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `category`, `image`, `video_url`, `created_at`) VALUES
(1, 'RBL OPENING DAY', 'ajddflvwkfgkwkufguiwghuohou;ghoiwow', 'Latest', 'news_1761077891_2405f863.png', '', '2025-10-21 20:18:11'),
(2, 'Mpoyo Ties the Game', 'Mpooyo does it again! A clutch bucket to tie things up — the arena explodes as fans leap to their feet! That was pure determination from the star guard, refusing to let his team fall behind. You can feel the energy surging now; it’s anyone’s game from here!', 'Latest', 'news_1761663339_ef63325c.jpeg', '', '2025-10-28 14:55:39'),
(3, 'What a block!', 'Outstanding timing from Diarra on that rejection. He read the play perfectly, rotated over, and met the attacker at the summit. That block not only denies two easy points but sends a clear message — nothing easy in the paint tonight.', 'Latest', 'news_1761663433_4a208c1c.jpeg', '', '2025-10-28 14:57:13'),
(4, 'Sweet moves', 'Exceptional ball control  there — quick hands, sharp footwork, and total command of the tempo. He uses his dribble not just to entertain, but to create space and open up the defense. That’s textbook guard play at its finest.', 'Latest', 'news_1761663573_2d483155.jpeg', '', '2025-10-28 14:59:33'),
(5, 'Osborn layer', 'That’s an elite finish from Osborn. Great body control, smart use of angles, and the perfect touch off the board. He read the help defense early and adjusted midair — a veteran-level move from the young star.', 'Latest', 'news_1761663653_42ccbf2c.jpg', '', '2025-10-28 15:00:53');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `height` varchar(10) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `jersey_number` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `team_id`, `name`, `position`, `height`, `nationality`, `jersey_number`, `photo`) VALUES
(2, 5, 'Ntore habi', 'PG', '6\'5', 'Rwandan', 12, 'player_1760629502_bbe8888a.png'),
(3, 7, 'sisi rosine', 'SG', '5\'6', 'Rwandan', 3, 'player_1761143300_8585cddd.png');

-- --------------------------------------------------------

--
-- Table structure for table `player_stats`
--

CREATE TABLE `player_stats` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `games_played` int(11) DEFAULT 0,
  `total_points` int(11) DEFAULT 0,
  `total_rebounds` int(11) DEFAULT 0,
  `total_assists` int(11) DEFAULT 0,
  `total_steals` int(11) DEFAULT 0,
  `total_blocks` int(11) DEFAULT 0,
  `fg_made` int(11) DEFAULT 0,
  `fg_attempted` int(11) DEFAULT 0,
  `three_made` int(11) DEFAULT 0,
  `three_attempted` int(11) DEFAULT 0,
  `ft_made` int(11) DEFAULT 0,
  `ft_attempted` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `player_stats`
--

INSERT INTO `player_stats` (`id`, `player_id`, `games_played`, `total_points`, `total_rebounds`, `total_assists`, `total_steals`, `total_blocks`, `fg_made`, `fg_attempted`, `three_made`, `three_attempted`, `ft_made`, `ft_attempted`, `created_at`, `updated_at`) VALUES
(1, 2, 5, 23, 8, 9, 2, 1, 5, 12, 4, 5, 12, 20, '2025-10-18 08:48:36', '2025-10-19 15:40:09');

-- --------------------------------------------------------

--
-- Table structure for table `playoffs`
--

CREATE TABLE `playoffs` (
  `id` int(11) NOT NULL,
  `stage` enum('Quarterfinal','Semifinal','Final','3rd Place') DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `home_team_id` int(11) DEFAULT NULL,
  `away_team_id` int(11) DEFAULT NULL,
  `home_score` int(11) DEFAULT 0,
  `away_score` int(11) DEFAULT 0,
  `winner_team_id` int(11) DEFAULT NULL,
  `status` enum('Pending','Completed') DEFAULT 'Pending',
  `seed` int(11) DEFAULT NULL,
  `series_format` varchar(20) DEFAULT 'Single'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop_items`
--

CREATE TABLE `shop_items` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` enum('Jerseys','Kits','Gear') DEFAULT 'Jerseys',
  `price` decimal(10,2) DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `team_id` int(11) DEFAULT NULL,
  `gender` enum('Men','Women','Unisex') DEFAULT 'Unisex'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shop_items`
--

INSERT INTO `shop_items` (`id`, `name`, `description`, `category`, `price`, `image`, `is_active`, `created_at`, `team_id`, `gender`) VALUES
(1, 'APR', 'Apr home kit', 'Jerseys', 15000.00, 'shop_1761590977_6075ec06.png', 1, '2025-10-27 18:19:58', 5, 'Men'),
(2, 'APR away kit', '', 'Jerseys', 15000.00, 'shop_1761590963_fb46867e.png', 1, '2025-10-27 18:49:23', 5, 'Men');

-- --------------------------------------------------------

--
-- Table structure for table `standings`
--

CREATE TABLE `standings` (
  `id` int(11) NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `games_played` int(11) DEFAULT 0,
  `wins` int(11) DEFAULT 0,
  `losses` int(11) DEFAULT 0,
  `points` int(11) DEFAULT 0,
  `win_percentage` decimal(5,2) DEFAULT NULL,
  `games_behind` decimal(5,2) DEFAULT NULL,
  `division` enum('Division 1','Division 2') DEFAULT NULL,
  `gender` enum('Men','Women') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `standings`
--

INSERT INTO `standings` (`id`, `team_id`, `games_played`, `wins`, `losses`, `points`, `win_percentage`, `games_behind`, `division`, `gender`) VALUES
(11, 5, 3, 2, 1, 5, NULL, NULL, 'Division 1', 'Men'),
(12, 6, 2, 1, 1, 3, NULL, NULL, 'Division 1', 'Men'),
(14, 7, 0, 0, 0, 0, NULL, NULL, 'Division 1', 'Women'),
(15, 8, 2, 1, 1, 3, 0.00, 0.00, 'Division 1', 'Men'),
(16, 9, 0, 0, 0, 0, 0.00, 0.00, 'Division 1', 'Men'),
(17, 7, 1, 0, 1, 1, NULL, NULL, 'Division 1', 'Men');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `gender` enum('Men','Women') DEFAULT NULL,
  `division` enum('Division 1','Division 2') DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `gender`, `division`, `location`, `logo`, `description`) VALUES
(5, 'APR', 'Men', 'Division 1', 'Kigali-Rwanda', 'team_1760610317_d6bc7244.png', ''),
(6, 'REG', 'Men', 'Division 1', 'Kigali-Rwanda', 'team_1761052848_5a7dc83c.png', ''),
(7, 'Patriots', 'Women', 'Division 1', 'kigali-Rwanda', 'team_1761055987_4a102eab.png', ''),
(8, 'Espoir', 'Men', 'Division 1', 'kigali-Rwanda', 'team_1761068432_07f0f72a.png', ''),
(9, 'Azmaco', 'Men', 'Division 1', 'kigali-Rwanda', 'team_1762190980_d20f5a63.png', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `coaches`
--
ALTER TABLE `coaches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `home_team_id` (`home_team_id`),
  ADD KEY `away_team_id` (`away_team_id`);

--
-- Indexes for table `national_coaches`
--
ALTER TABLE `national_coaches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `national_players`
--
ALTER TABLE `national_players`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `national_teams`
--
ALTER TABLE `national_teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `player_stats`
--
ALTER TABLE `player_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`);

--
-- Indexes for table `playoffs`
--
ALTER TABLE `playoffs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `home_team_id` (`home_team_id`),
  ADD KEY `away_team_id` (`away_team_id`);

--
-- Indexes for table `shop_items`
--
ALTER TABLE `shop_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `standings`
--
ALTER TABLE `standings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coaches`
--
ALTER TABLE `coaches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `national_coaches`
--
ALTER TABLE `national_coaches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `national_players`
--
ALTER TABLE `national_players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `national_teams`
--
ALTER TABLE `national_teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `player_stats`
--
ALTER TABLE `player_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `playoffs`
--
ALTER TABLE `playoffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shop_items`
--
ALTER TABLE `shop_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `standings`
--
ALTER TABLE `standings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coaches`
--
ALTER TABLE `coaches`
  ADD CONSTRAINT `coaches_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`);

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`home_team_id`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `games_ibfk_2` FOREIGN KEY (`away_team_id`) REFERENCES `teams` (`id`);

--
-- Constraints for table `national_coaches`
--
ALTER TABLE `national_coaches`
  ADD CONSTRAINT `national_coaches_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `national_teams` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `national_players`
--
ALTER TABLE `national_players`
  ADD CONSTRAINT `national_players_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `national_teams` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `player_stats`
--
ALTER TABLE `player_stats`
  ADD CONSTRAINT `player_stats_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `playoffs`
--
ALTER TABLE `playoffs`
  ADD CONSTRAINT `playoffs_ibfk_1` FOREIGN KEY (`home_team_id`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `playoffs_ibfk_2` FOREIGN KEY (`away_team_id`) REFERENCES `teams` (`id`);

--
-- Constraints for table `standings`
--
ALTER TABLE `standings`
  ADD CONSTRAINT `standings_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
