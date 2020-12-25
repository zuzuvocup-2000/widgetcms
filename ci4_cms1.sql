-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 29, 2020 at 11:26 AM
-- Server version: 5.6.47
-- PHP Version: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci4_cms1`
--

-- --------------------------------------------------------

--
-- Table structure for table `attribute`
--

CREATE TABLE `attribute` (
  `id` int(11) NOT NULL,
  `catalogueid` int(11) NOT NULL,
  `catalogue` longtext NOT NULL,
  `order` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` tinyint(1) NOT NULL,
  `publish` tinyint(1) NOT NULL,
  `userid_created` int(11) NOT NULL,
  `userid_updated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attribute`
--

INSERT INTO `attribute` (`id`, `catalogueid`, `catalogue`, `order`, `created_at`, `updated_at`, `deleted_at`, `publish`, `userid_created`, `userid_updated`) VALUES
(1, 6, 'null', 0, '2020-10-28 16:35:35', '2020-10-28 16:55:34', 0, 1, 8, 8),
(2, 4, 'null', 0, '2020-10-28 17:07:17', '0000-00-00 00:00:00', 0, 1, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `attribute_catalogue`
--

CREATE TABLE `attribute_catalogue` (
  `id` int(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` tinyint(1) NOT NULL,
  `publish` tinyint(1) NOT NULL,
  `userid_created` int(11) NOT NULL,
  `userid_updated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attribute_catalogue`
--

INSERT INTO `attribute_catalogue` (`id`, `parentid`, `lft`, `rgt`, `level`, `order`, `created_at`, `updated_at`, `deleted_at`, `publish`, `userid_created`, `userid_updated`) VALUES
(2, 0, 0, 0, 0, 0, '2020-10-28 15:31:52', '0000-00-00 00:00:00', 0, 1, 8, 0),
(3, 0, 2, 3, 1, 0, '2020-10-28 15:32:23', '2020-10-28 15:48:38', 0, 1, 8, 8),
(4, 0, 4, 9, 1, 0, '2020-10-28 15:35:51', '0000-00-00 00:00:00', 0, 1, 8, 0),
(5, 4, 5, 8, 0, 0, '2020-10-28 15:43:12', '0000-00-00 00:00:00', 0, 1, 8, 0),
(6, 5, 6, 7, 3, 0, '2020-10-28 15:43:41', '0000-00-00 00:00:00', 0, 1, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `attribute_translate`
--

CREATE TABLE `attribute_translate` (
  `objectid` int(11) NOT NULL,
  `language` longtext NOT NULL,
  `module` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` varchar(20) NOT NULL,
  `userid_created` int(11) NOT NULL,
  `userid_updated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attribute_translate`
--

INSERT INTO `attribute_translate` (`objectid`, `language`, `module`, `title`, `value`, `userid_created`, `userid_updated`) VALUES
(3, 'vi', 'attribute_catalogue', 'Kích thước 111', '', 0, 0),
(4, 'vi', 'attribute_catalogue', 'Máy tính', '', 0, 0),
(5, 'vi', 'attribute_catalogue', 'Phụ kiện máy tính', '', 0, 0),
(6, 'vi', 'attribute_catalogue', 'Tai nghe', '', 0, 0),
(3, 'en', 'attribute_catalogue', 'kích thước', '', 0, 0),
(3, 'jp', 'attribute_catalogue', 'abs', '', 0, 0),
(1, 'vi', 'attribute', 'admin', 'SSSSS', 0, 0),
(1, 'en', 'attribute', 'admin', 'SSSS', 0, 0),
(2, 'vi', 'attribute', 'Màu sắc', 'Đỏ', 0, 0),
(2, 'en', 'attribute', 'color', 'red', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attribute`
--
ALTER TABLE `attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_catalogue`
--
ALTER TABLE `attribute_catalogue`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attribute`
--
ALTER TABLE `attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attribute_catalogue`
--
ALTER TABLE `attribute_catalogue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
