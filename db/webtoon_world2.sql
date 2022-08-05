-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2022 at 04:32 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webtoon_world2`
--

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `c_name` varchar(25) NOT NULL,
  `c_no` int(3) UNSIGNED NOT NULL,
  `c_link` varchar(150) NOT NULL,
  `w_id` int(10) UNSIGNED NOT NULL,
  `c_posted_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `covers`
--

CREATE TABLE `covers` (
  `cover_url` varchar(150) NOT NULL,
  `cover_path` varchar(100) DEFAULT NULL,
  `w_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Stand-in structure for view `cover_details`
-- (See below for the actual view)
--
CREATE TABLE `cover_details` (
`w_id` int(10) unsigned
,`w_title` varchar(100)
,`cover_url` varchar(150)
,`cover_path` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `parser_hub`
--

CREATE TABLE `parser_hub` (
  `p_id` int(10) UNSIGNED NOT NULL,
  `p_title` varchar(80) NOT NULL,
  `p_token` varchar(50) NOT NULL,
  `run_token` varchar(50) NOT NULL,
  `run_status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `webtoons`
--

CREATE TABLE `webtoons` (
  `w_id` int(11) UNSIGNED NOT NULL,
  `w_title` varchar(100) NOT NULL,
  `w_link` varchar(150) NOT NULL,
  `last_mod` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Stand-in structure for view `webtoon_details`
-- (See below for the actual view)
--
CREATE TABLE `webtoon_details` (
`w_id` int(11) unsigned
,`w_title` varchar(100)
,`w_link` varchar(150)
,`cover_path` varchar(100)
,`last_mod` timestamp
);

-- --------------------------------------------------------

--
-- Structure for view `cover_details`
--
DROP TABLE IF EXISTS `cover_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cover_details`  AS SELECT `covers`.`w_id` AS `w_id`, `webtoons`.`w_title` AS `w_title`, `covers`.`cover_url` AS `cover_url`, `covers`.`cover_path` AS `cover_path` FROM (`covers` join `webtoons` on(`webtoons`.`w_id` = `covers`.`w_id`))  ;

-- --------------------------------------------------------

--
-- Structure for view `webtoon_details`
--
DROP TABLE IF EXISTS `webtoon_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `webtoon_details`  AS SELECT `webtoons`.`w_id` AS `w_id`, `webtoons`.`w_title` AS `w_title`, `webtoons`.`w_link` AS `w_link`, `covers`.`cover_path` AS `cover_path`, `webtoons`.`last_mod` AS `last_mod` FROM (`webtoons` left join `covers` on(`webtoons`.`w_id` = `covers`.`w_id`))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD UNIQUE KEY `c_link` (`c_link`),
  ADD KEY `w_id` (`w_id`);

--
-- Indexes for table `covers`
--
ALTER TABLE `covers`
  ADD UNIQUE KEY `w_id_2` (`w_id`),
  ADD UNIQUE KEY `cover_path` (`cover_path`) USING BTREE,
  ADD KEY `w_id` (`w_id`);

--
-- Indexes for table `parser_hub`
--
ALTER TABLE `parser_hub`
  ADD PRIMARY KEY (`p_id`),
  ADD UNIQUE KEY `p_title` (`p_title`);

--
-- Indexes for table `webtoons`
--
ALTER TABLE `webtoons`
  ADD PRIMARY KEY (`w_id`),
  ADD UNIQUE KEY `w_title` (`w_title`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parser_hub`
--
ALTER TABLE `parser_hub`
  MODIFY `p_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `webtoons`
--
ALTER TABLE `webtoons`
  MODIFY `w_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `chapters_ibfk_1` FOREIGN KEY (`w_id`) REFERENCES `webtoons` (`w_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `covers`
--
ALTER TABLE `covers`
  ADD CONSTRAINT `covers_ibfk_1` FOREIGN KEY (`w_id`) REFERENCES `webtoons` (`w_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
