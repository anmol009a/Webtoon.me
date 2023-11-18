-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2023 at 07:04 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webtoon_world`
--

-- --------------------------------------------------------

--
-- Table structure for table `webtoon`
--

CREATE TABLE `webtoon` (
  `webtoon_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `webtoon_chapter`
--

CREATE TABLE `webtoon_chapter` (
  `chapter_id` bigint(20) UNSIGNED NOT NULL,
  `webtoon_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `number` decimal(4,1) UNSIGNED NOT NULL,
  `url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `webtoon`
--
ALTER TABLE `webtoon`
  ADD PRIMARY KEY (`webtoon_id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `webtoon_chapter`
--
ALTER TABLE `webtoon_chapter`
  ADD PRIMARY KEY (`chapter_id`),
  ADD UNIQUE KEY `webtoon_id` (`webtoon_id`,`number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `webtoon`
--
ALTER TABLE `webtoon`
  MODIFY `webtoon_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `webtoon_chapter`
--
ALTER TABLE `webtoon_chapter`
  MODIFY `chapter_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `webtoon_chapter`
--
ALTER TABLE `webtoon_chapter`
  ADD CONSTRAINT `webtoon_chapter_ibfk_1` FOREIGN KEY (`webtoon_id`) REFERENCES `webtoon` (`webtoon_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
