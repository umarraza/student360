-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2019 at 04:39 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student360`
--

-- --------------------------------------------------------

--
-- Table structure for table `approve_hostel_requests`
--

CREATE TABLE `approve_hostel_requests` (
  `id` int(10) NOT NULL,
  `approveStatus` int(10) NOT NULL,
  `hostelId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `device_tokens`
--

CREATE TABLE `device_tokens` (
  `id` int(10) NOT NULL,
  `deviceToken` varchar(500) NOT NULL,
  `deviceType` tinyint(3) NOT NULL DEFAULT '0',
  `userId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(10) NOT NULL,
  `featureName` varchar(100) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `featureName`, `createdAt`, `updatedAt`) VALUES
(1, '24-hour reception', '2019-05-31 03:04:39', '2019-05-31 03:04:39'),
(2, '24-hour security', '2019-05-31 03:04:49', '2019-05-31 03:04:49'),
(3, 'Air conditioning', '2019-05-31 03:04:55', '2019-05-31 03:04:55'),
(4, 'ATM', '2019-05-31 03:05:01', '2019-05-31 03:05:01'),
(5, 'BBQ area', '2019-05-31 03:05:09', '2019-05-31 03:05:09'),
(6, 'Parking area', '2019-05-31 03:05:18', '2019-05-31 03:05:18'),
(7, 'Board Games', '2019-05-31 03:05:24', '2019-05-31 03:05:24'),
(8, 'Mess', '2019-05-31 03:05:31', '2019-05-31 03:05:31'),
(9, 'TV', '2019-05-31 03:05:36', '2019-05-31 03:05:36'),
(10, 'Carpeted rooms', '2019-05-31 03:05:52', '2019-05-31 03:05:52'),
(11, 'Cupboards', '2019-05-31 03:05:58', '2019-05-31 03:05:58'),
(12, 'Daily news paper', '2019-05-31 03:06:06', '2019-05-31 03:06:06'),
(13, 'Electricity 24/7', '2019-05-31 03:06:14', '2019-05-31 03:06:14'),
(14, '3-time meal', '2019-05-31 03:06:20', '2019-05-31 03:06:20'),
(15, 'Non- Smoking', '2019-05-31 03:06:28', '2019-05-31 03:06:28'),
(16, 'seprate', '2019-05-31 03:06:34', '2019-05-31 03:06:34'),
(17, 'UPS', '2019-05-31 03:06:58', '2019-05-31 03:06:58'),
(18, 'Not furnished', '2019-05-31 03:07:04', '2019-05-31 03:07:04'),
(19, 'Furnished', '2019-05-31 03:07:29', '2019-05-31 03:07:29'),
(20, 'First aid', '2019-05-31 03:07:36', '2019-05-31 03:07:36'),
(21, 'Water filter', '2019-05-31 03:07:51', '2019-05-31 03:07:51'),
(22, 'Guests allowed', '2019-05-31 03:07:58', '2019-05-31 03:07:58'),
(23, 'Outdoor Terrace', '2019-05-31 03:08:16', '2019-05-31 03:08:16'),
(24, 'Outdoor Swimming Pool', '2019-05-31 03:08:27', '2019-05-31 03:08:27'),
(25, 'Microwave', '2019-05-31 03:08:34', '2019-05-31 03:08:34'),
(26, 'Luggage Storage', '2019-05-31 03:08:46', '2019-05-31 03:08:46');

-- --------------------------------------------------------

--
-- Table structure for table `hostels_registration-requests`
--

CREATE TABLE `hostels_registration-requests` (
  `id` int(10) NOT NULL,
  `verificationStatus` tinyint(4) NOT NULL DEFAULT '0',
  `hostelId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hostel_images`
--

CREATE TABLE `hostel_images` (
  `id` int(10) NOT NULL,
  `imageName` varchar(50) NOT NULL,
  `isThumbnail` tinyint(10) NOT NULL DEFAULT '0',
  `hostelId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hostel_images`
--

INSERT INTO `hostel_images` (`id`, `imageName`, `isThumbnail`, `hostelId`, `createdAt`, `updatedAt`) VALUES
(1, 'image_1560053096.jpeg', 1, 1, '2019-06-09 11:04:56', '2019-06-09 11:04:56'),
(2, 'image_1560053230.jpeg', 0, 1, '2019-06-09 11:07:10', '2019-06-09 11:07:10'),
(3, 'image_1560053256.jpeg', 0, 1, '2019-06-09 11:07:36', '2019-06-09 11:07:36'),
(4, 'image_1560053328.jpeg', 0, 1, '2019-06-09 11:08:48', '2019-06-09 11:08:48'),
(5, 'image_1560053353.jpeg', 0, 1, '2019-06-09 11:09:13', '2019-06-09 11:09:13'),
(6, 'image_1560056393.jpeg', 1, 2, '2019-06-09 11:59:53', '2019-06-09 11:59:53'),
(7, 'image_1560056424.jpeg', 0, 2, '2019-06-09 12:00:24', '2019-06-09 12:00:24'),
(8, 'image_1560056434.jpeg', 0, 2, '2019-06-09 12:00:34', '2019-06-09 12:00:34'),
(9, 'image_1560056438.jpeg', 0, 2, '2019-06-09 12:00:38', '2019-06-09 12:00:38'),
(10, 'image_1560056454.jpeg', 0, 2, '2019-06-09 12:00:54', '2019-06-09 12:00:54'),
(11, 'image_1560056457.jpeg', 0, 2, '2019-06-09 12:00:57', '2019-06-09 12:00:57'),
(12, 'image_1560058113.jpeg', 1, 3, '2019-06-09 12:28:33', '2019-06-09 12:28:33');

-- --------------------------------------------------------

--
-- Table structure for table `hostel_profiles`
--

CREATE TABLE `hostel_profiles` (
  `id` int(10) NOT NULL,
  `hostelName` varchar(200) NOT NULL,
  `hostelCategory` varchar(50) NOT NULL,
  `numberOfBedRooms` int(10) NOT NULL,
  `noOfBeds` int(10) NOT NULL,
  `priceRange` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `longitude` varchar(20) NOT NULL,
  `latitude` varchar(20) NOT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postCode` int(20) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `description` varchar(500) CHARACTER SET utf32 COLLATE utf32_croatian_ci NOT NULL,
  `contactName` varchar(50) NOT NULL,
  `contactEmail` varchar(30) DEFAULT NULL,
  `website` varchar(50) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `isApproved` int(10) NOT NULL DEFAULT '0',
  `isVerified` int(10) NOT NULL DEFAULT '0',
  `features` varchar(2000) NOT NULL,
  `userId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hostel_profiles`
--

INSERT INTO `hostel_profiles` (`id`, `hostelName`, `hostelCategory`, `numberOfBedRooms`, `noOfBeds`, `priceRange`, `address`, `longitude`, `latitude`, `state`, `postCode`, `city`, `country`, `description`, `contactName`, `contactEmail`, `website`, `phoneNumber`, `isApproved`, `isVerified`, `features`, `userId`, `createdAt`, `updatedAt`) VALUES
(1, 'Continental Girls Hostel GCP Society', 'Girls', 30, 60, '15000-20000', 'Lahore, Pakistan', '74.2662099', '31.4486204', 'Punjab', 1214, 'Lahore', 'Pakistan', 'Paradise Group Of Hostels For Boys In Firdaus Market Gulberg 3 Lahore (All included in monthly rent) Gulberg 3, model colony.\r\n', 'Mujahid Alvi', 'mujahid@gmail.com', 'www.continentalgirlshostel.com', '03034969407', 0, 0, '[\"24-hour reception\",\"24-hour security\",\"Air conditioning\",\"ATM\",\"BBQ area\",\"Parking area\",\"Board Games\"\r\n,\"TV\",\"Ceiling Fan\",\"Childrens play area\",\"Common Room\"]', 2, '2019-06-09 09:57:37', '2019-06-09 09:57:37'),
(2, 'Shelton\'s Rezidor Lahore', 'Gust House', 20, 60, '150000', 'House no 3, Street no 30, F-7/1, F-7 Sector, 44000 Lahore, Pakistan', '74.309168', '31.4811591', 'Punjab', 1214, 'Lahore', 'Pakistan', 'Shelton\'s Rezid In Lahore Is Located In 7-A Salik Street, Green Avenue، 7-A Salik Street, Muslim Town, Lahore, Punjab 54600, Pakistan. It\'s Condition is Semi Furnished. We Include Bills In Only 5000 Rs. We give the internet accessibility through WIFI and many other Facilites.', 'Qasim Mughal', 'qasim@gmail.com', 'www.shelton.com', '03034545201', 0, 0, '[\"24-hour reception\",\"24-hour security\",\"Air conditioning\",\"ATM\",\"BBQ area\",\"Parking area\",\"Board Games\",\"Mess\",\"TV\",\"Ceiling Fan\",\"Childrens play area\",\"Common Room\"]', 13, '2019-06-09 11:55:49', '2019-06-09 11:55:49'),
(3, 'Royal Residencia Centaurus', 'Girls', 20, 60, '150000', 'House no 3, Street no 30, F-7/1, F-7 Sector, 44000 Lahore, Pakistan', '74.3094792', '31.4812231', 'Punjab', 1214, 'Lahore', 'Pakistan', 'Shelton\'s Rezid In Lahore Is Located In 7-A Salik Street, Green Avenue، 7-A Salik Street, Muslim Town, Lahore, Punjab 54600, Pakistan. It\'s Condition is Semi Furnished. We Include Bills In Only 5000 Rs. We give the internet accessibility through WIFI and many other Facilites.', 'Imran Maqbool', 'imran@gmail.com', 'www.shelton.com', '03034545201', 0, 0, '[\"24-hour reception\",\"24-hour security\",\"Air conditioning\",\"ATM\",\"BBQ area\",\"Parking area\",\"Board Games\",\"Mess\",\"TV\",\"Ceiling Fan\",\"Childrens play area\",\"Common Room\"]', 14, '2019-06-09 12:27:04', '2019-06-09 12:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `mess-menu-timinigs`
--

CREATE TABLE `mess-menu-timinigs` (
  `id` int(10) NOT NULL,
  `brkfastStartTime` varchar(30) NOT NULL,
  `brkfastEndTime` varchar(30) NOT NULL,
  `lunchStartTime` varchar(30) NOT NULL,
  `lunchEndTime` varchar(30) NOT NULL,
  `dinnerStartTime` varchar(30) NOT NULL,
  `dinnerEndTime` varchar(30) NOT NULL,
  `isSetBreakFast` tinyint(3) NOT NULL DEFAULT '0',
  `isSetLunch` tinyint(3) NOT NULL DEFAULT '0',
  `isSetDinner` tinyint(3) NOT NULL DEFAULT '0',
  `hostelId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mess-menu-timinigs`
--

INSERT INTO `mess-menu-timinigs` (`id`, `brkfastStartTime`, `brkfastEndTime`, `lunchStartTime`, `lunchEndTime`, `dinnerStartTime`, `dinnerEndTime`, `isSetBreakFast`, `isSetLunch`, `isSetDinner`, `hostelId`, `createdAt`, `updatedAt`) VALUES
(1, '07:00 AM', '10:00 AM', '01:00 PM', '03:00 PM', '07:00 PM', '10:00 PM', 0, 0, 0, 1, '2019-06-09 09:57:38', '2019-06-09 09:57:38'),
(2, '07:00 AM', '10:00 AM', '01:00 PM', '03:00 PM', '07:00 PM', '10:00 PM', 0, 0, 0, 2, '2019-06-09 11:55:49', '2019-06-09 11:55:49'),
(3, '07:00 AM', '10:00 AM', '01:00 PM', '03:00 PM', '07:00 PM', '10:00 PM', 0, 0, 0, 3, '2019-06-09 12:27:04', '2019-06-09 12:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `mess_menu-meal`
--

CREATE TABLE `mess_menu-meal` (
  `id` int(10) NOT NULL,
  `day` varchar(100) NOT NULL,
  `breakFastMeal` varchar(100) NOT NULL,
  `LunchMeal` varchar(100) NOT NULL,
  `dinnerMeal` varchar(100) NOT NULL,
  `hostelId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mess_menu-meal`
--

INSERT INTO `mess_menu-meal` (`id`, `day`, `breakFastMeal`, `LunchMeal`, `dinnerMeal`, `hostelId`, `createdAt`, `updatedAt`) VALUES
(1, 'Mon', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 1, '2019-06-09 09:57:38', '2019-06-09 09:57:38'),
(2, 'Tue', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 1, '2019-06-09 09:57:38', '2019-06-09 09:57:38'),
(3, 'Wed', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 1, '2019-06-09 09:57:38', '2019-06-09 09:57:38'),
(4, 'Thu', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 1, '2019-06-09 09:57:38', '2019-06-09 09:57:38'),
(5, 'Fri', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 1, '2019-06-09 09:57:38', '2019-06-09 09:57:38'),
(6, 'Sat', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 1, '2019-06-09 09:57:38', '2019-06-09 09:57:38'),
(7, 'Mon', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 2, '2019-06-09 11:55:49', '2019-06-09 11:55:49'),
(8, 'Tue', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 2, '2019-06-09 11:55:49', '2019-06-09 11:55:49'),
(9, 'Wed', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 2, '2019-06-09 11:55:49', '2019-06-09 11:55:49'),
(10, 'Thu', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 2, '2019-06-09 11:55:49', '2019-06-09 11:55:49'),
(11, 'Fri', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 2, '2019-06-09 11:55:49', '2019-06-09 11:55:49'),
(12, 'Sat', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 2, '2019-06-09 11:55:49', '2019-06-09 11:55:49'),
(13, 'Mon', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 3, '2019-06-09 12:27:04', '2019-06-09 12:27:04'),
(14, 'Tue', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 3, '2019-06-09 12:27:04', '2019-06-09 12:27:04'),
(15, 'Wed', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 3, '2019-06-09 12:27:04', '2019-06-09 12:27:04'),
(16, 'Thu', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 3, '2019-06-09 12:27:04', '2019-06-09 12:27:04'),
(17, 'Fri', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 3, '2019-06-09 12:27:04', '2019-06-09 12:27:04'),
(18, 'Sat', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 3, '2019-06-09 12:27:04', '2019-06-09 12:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `profile_pictures`
--

CREATE TABLE `profile_pictures` (
  `id` int(10) NOT NULL,
  `imageName` varchar(50) NOT NULL,
  `userId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile_pictures`
--

INSERT INTO `profile_pictures` (`id`, `imageName`, `userId`, `createdAt`, `updatedAt`) VALUES
(1, 'image_1560053954.jpeg', 3, '2019-06-09 11:19:14', '2019-06-09 11:19:14'),
(2, 'image_1560053988.jpeg', 4, '2019-06-09 11:19:48', '2019-06-09 11:19:48'),
(3, 'image_1560054003.png', 5, '2019-06-09 11:20:03', '2019-06-09 11:20:03'),
(4, 'image_1560054019.jpeg', 6, '2019-06-09 11:20:19', '2019-06-09 11:20:19'),
(5, 'image_1560054039.webp', 7, '2019-06-09 11:20:39', '2019-06-09 11:20:39'),
(6, 'image_1560054065.jpeg', 8, '2019-06-09 11:21:05', '2019-06-09 11:21:05'),
(7, 'image_1560054085.jpeg', 9, '2019-06-09 11:21:25', '2019-06-09 11:21:25');

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE `queries` (
  `id` int(10) NOT NULL,
  `message` varchar(500) NOT NULL,
  `type` varchar(20) NOT NULL,
  `threadId` int(11) NOT NULL,
  `hostelId` int(10) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `queries`
--

INSERT INTO `queries` (`id`, `message`, `type`, `threadId`, `hostelId`, `createdAt`, `updatedAt`) VALUES
(1, 'Parking available?', 'Q', 1, 1, '2019-06-09 11:25:40', '2019-06-09 11:25:40'),
(2, 'Yes, available', 'A', 1, 1, '2019-06-09 11:26:16', '2019-06-09 11:26:16'),
(3, 'Wifi available?', 'Q', 2, 1, '2019-06-09 11:26:46', '2019-06-09 11:26:46'),
(4, 'Yes available', 'A', 2, 1, '2019-06-09 11:27:10', '2019-06-09 11:27:10'),
(5, 'AC available?', 'Q', 3, 1, '2019-06-09 11:27:27', '2019-06-09 11:27:27'),
(6, 'AC Not available', 'A', 3, 1, '2019-06-09 11:27:54', '2019-06-09 11:27:54'),
(7, 'What are the prices per month stay for two rooms?', 'Q', 4, 2, '2019-06-09 12:02:04', '2019-06-09 12:02:04'),
(8, 'Prices range are 15000 to 20000', 'A', 4, 2, '2019-06-09 12:02:24', '2019-06-09 12:02:24'),
(9, 'Mess Menu vailable?', 'Q', 5, 2, '2019-06-09 12:02:44', '2019-06-09 12:02:44'),
(10, 'Yes Mess Menu vailable', 'A', 5, 2, '2019-06-09 12:02:58', '2019-06-09 12:02:58'),
(11, 'How much is the cost of ac room?', 'Q', 6, 2, '2019-06-09 12:03:21', '2019-06-09 12:03:21'),
(12, '20000 per month', 'A', 6, 2, '2019-06-09 12:03:37', '2019-06-09 12:03:37');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(10) NOT NULL,
  `score` int(10) DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `hostelId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `score`, `userId`, `hostelId`, `createdAt`, `updatedAt`) VALUES
(1, 5, 3, 1, '2019-06-09 11:36:02', '2019-06-09 11:36:02'),
(2, 4, 4, 1, '2019-06-09 11:36:09', '2019-06-09 11:36:09'),
(3, 3, 5, 1, '2019-06-09 11:36:14', '2019-06-09 11:36:14'),
(4, 2, 6, 1, '2019-06-09 11:36:19', '2019-06-09 11:36:19'),
(5, 1, 7, 1, '2019-06-09 11:36:24', '2019-06-09 11:36:24'),
(6, 1, 3, 2, '2019-06-09 12:06:08', '2019-06-09 12:06:08'),
(7, 2, 4, 2, '2019-06-09 12:06:13', '2019-06-09 12:06:13'),
(8, 3, 5, 2, '2019-06-09 12:06:17', '2019-06-09 12:06:17'),
(9, 4, 6, 2, '2019-06-09 12:06:21', '2019-06-09 12:06:21'),
(10, 5, 7, 2, '2019-06-09 12:06:25', '2019-06-09 12:06:25');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) NOT NULL,
  `body` varchar(500) DEFAULT NULL,
  `hostelId` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `body`, `hostelId`, `userId`, `createdAt`, `updatedAt`) VALUES
(1, 'Good thing about this hostel is cleanliness', 1, 3, '2019-06-09 11:29:38', '2019-06-09 11:29:38'),
(2, 'Best Services', 1, 4, '2019-06-09 11:29:49', '2019-06-09 11:29:49'),
(3, 'Waste of time and money', 1, 5, '2019-06-09 11:30:14', '2019-06-09 11:30:14'),
(4, 'Worst Services', 1, 6, '2019-06-09 11:30:25', '2019-06-09 11:30:25'),
(5, 'Worst Services', 2, 3, '2019-06-09 12:04:23', '2019-06-09 12:04:23'),
(6, 'Waste of time and money', 2, 4, '2019-06-09 12:04:30', '2019-06-09 12:04:30'),
(7, 'Quite good food they offered', 2, 5, '2019-06-09 12:04:47', '2019-06-09 12:04:47'),
(8, 'Nice and clean hostel', 2, 6, '2019-06-09 12:05:02', '2019-06-09 12:05:02'),
(9, 'Best hostel, fast services, amazed by the quick working response', 2, 7, '2019-06-09 12:05:38', '2019-06-09 12:05:38');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) NOT NULL,
  `description` varchar(200) NOT NULL,
  `label` varchar(50) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `description`, `label`, `createdAt`, `updatedAt`) VALUES
(1, 'Super Admin', 'super_admin', '2019-05-02 12:33:33', '0000-00-00 00:00:00'),
(2, 'Hostel_Admin', 'hostel_admin', '2019-05-02 12:51:51', '0000-00-00 00:00:00'),
(3, 'Student', 'student', '2019-05-02 12:51:34', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `id` int(10) NOT NULL,
  `hostelId` int(11) NOT NULL,
  `userId` int(10) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`id`, `hostelId`, `userId`, `createdAt`, `updatedAt`) VALUES
(1, 1, 3, '2019-06-09 11:25:40', '2019-06-09 11:25:40'),
(2, 1, 4, '2019-06-09 11:26:46', '2019-06-09 11:26:46'),
(3, 1, 5, '2019-06-09 11:27:27', '2019-06-09 11:27:27'),
(4, 2, 3, '2019-06-09 12:02:04', '2019-06-09 12:02:04'),
(5, 2, 4, '2019-06-09 12:02:44', '2019-06-09 12:02:44'),
(6, 2, 5, '2019-06-09 12:03:21', '2019-06-09 12:03:21');

-- --------------------------------------------------------

--
-- Table structure for table `update-hostels-requests`
--

CREATE TABLE `update-hostels-requests` (
  `id` int(10) NOT NULL,
  `hostelName` varchar(50) NOT NULL,
  `hostelCategory` varchar(50) NOT NULL,
  `numberOfBedRooms` int(10) NOT NULL,
  `noOfBeds` int(10) NOT NULL,
  `priceRange` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `state` varchar(20) DEFAULT NULL,
  `postCode` varchar(20) DEFAULT NULL,
  `city` varchar(20) NOT NULL,
  `country` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `contactName` varchar(50) NOT NULL,
  `contactEmail` varchar(50) DEFAULT NULL,
  `website` varchar(50) NOT NULL,
  `phoneNumber` varchar(50) NOT NULL,
  `features` varchar(1000) NOT NULL,
  `status` tinyint(10) NOT NULL DEFAULT '0',
  `hostelId` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `roleId` int(10) NOT NULL,
  `resetPasswordToken` varchar(255) DEFAULT NULL,
  `createdResetPToken` timestamp NULL DEFAULT NULL,
  `avatarFilePath` varchar(200) DEFAULT NULL,
  `deviceToken` varchar(200) DEFAULT NULL,
  `onlineStatus` tinyint(3) NOT NULL DEFAULT '0',
  `verified` tinyint(3) NOT NULL,
  `googleLogin` varchar(250) DEFAULT NULL,
  `facebookLogin` varchar(250) DEFAULT NULL,
  `language` varchar(20) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `remember_token`, `roleId`, `resetPasswordToken`, `createdResetPToken`, `avatarFilePath`, `deviceToken`, `onlineStatus`, `verified`, `googleLogin`, `facebookLogin`, `language`, `createdAt`, `updatedAt`) VALUES
(1, 'super.admin@admin.com', 'super.admin@admin.com', '$2y$10$VwROsyn0bDr5gTh/rnCCG.5JN3kZTAWEEUZPJLHfiZf.84ZLdPtwq', 'J4Wo5S1I3oG53IGMe2ttEW2YFKojus9tizVBsMCr59YPTrbQqUd00YudN4Og', 1, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '', '2019-06-09 02:46:11', '0000-00-00 00:00:00'),
(2, 'mujahid', 'mujahid@gmail.com', '$2y$10$iUblXwbYHalkAUNhbfcILOfUnWyrPtfRh21tjQSu0JPwi4bLgEbhi', NULL, 2, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-06-09 04:02:55', '2019-06-09 09:57:37'),
(3, 'umarraza', 'umarraza@gmail.com', '$2y$10$mbirzJlPwGY.eHWHF0VrdOQMaS3BwY.R.8H17H4Dq71r/nS9zworG', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-06-09 11:10:53', '2019-06-09 11:10:53'),
(4, 'aliraza', 'aliraza@gmail.com', '$2y$10$HlpGfd9Jw8NeqPtLg5P3tOzUOkcCk7n2QMZ2J.5YlqlZvsrSrGcoe', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-06-09 11:11:32', '2019-06-09 11:11:32'),
(5, 'fahadali', 'fahadali@gmail.com', '$2y$10$P/2DMYUYDVdSFMLTg4hEYOM5vsWlHDiPJiB8g7yM9M4.pd3SlYND.', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-06-09 11:11:54', '2019-06-09 11:11:54'),
(6, 'saadali', 'saadali@gmail.com', '$2y$10$rV26bg/AfkGdhy3rcSM4aeX/6tzpXmYrlQ8KtLqln44Q8WPe9p5l6', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-06-09 11:12:15', '2019-06-09 11:12:15'),
(7, 'haroonali', 'harron@gmail.com', '$2y$10$mIJJFk08E/TL49Ipyj6PCeV4wm6timvdD11Cf1zRr/9Fkc1skJk1u', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-06-09 11:12:36', '2019-06-09 11:12:36'),
(8, 'asimmajid', 'asimmajid@gmail.com', '$2y$10$BBmC.OEEdVumJgKL2utcz.ry207akzFO0.Ni6zxpLjia5EiCEisQa', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-06-09 11:12:59', '2019-06-09 11:12:59'),
(9, 'sohaibnaveed', 'sohaib@gmail.com', '$2y$10$LUNKkG5i9YDLu7aQXVSFKu6fy/FihnuLvcgE/x6HxO7tgNjYiboQq', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-06-09 11:13:24', '2019-06-09 11:13:24'),
(10, 'qasim', 'qasim@gmail.com', '$2y$10$acOwq1oiwFFGEidNkaCW2.0os8cWYwuCe2wJ6EPtVvKOIfcZGE0Ii', NULL, 2, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-06-09 04:58:44', '2019-06-09 11:55:49'),
(14, 'imran', 'imran@gmail.com', '$2y$10$M1CU8ZtMwZsRhIg1a8a5x.Re6YNj0uht6RRXgn.CKjn9laA7PkDNq', NULL, 2, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'English', '2019-06-09 12:27:04', '2019-06-09 12:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL,
  `fullName` varchar(50) NOT NULL,
  `phoneNumber` varchar(50) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  `occupation` varchar(20) DEFAULT NULL,
  `institute` varchar(20) DEFAULT NULL,
  `dateOfBirth` varchar(50) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `CNIC` varchar(50) DEFAULT NULL,
  `isVerified` int(10) NOT NULL DEFAULT '0',
  `threadId` int(10) DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `fullName`, `phoneNumber`, `email`, `city`, `country`, `occupation`, `institute`, `dateOfBirth`, `gender`, `CNIC`, `isVerified`, `threadId`, `userId`, `createdAt`, `updatedAt`) VALUES
(1, 'Umar Raza', '03231414124', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 3, '2019-06-09 11:10:53', '2019-06-09 11:10:53'),
(2, 'Ali Raza', '03231414124', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 4, '2019-06-09 11:11:32', '2019-06-09 11:11:32'),
(3, 'Fahad Ali', '03231414124', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 5, '2019-06-09 11:11:54', '2019-06-09 11:11:54'),
(4, 'Saad Ali', '03231414124', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 6, '2019-06-09 11:12:15', '2019-06-09 11:12:15'),
(5, 'Haroon Ali', '03231414124', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 7, '2019-06-09 11:12:36', '2019-06-09 11:12:36'),
(6, 'Asim Majid', '03231414124', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 8, '2019-06-09 11:12:59', '2019-06-09 11:12:59'),
(7, 'Sohaib Naveed', '03231414124', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 9, '2019-06-09 11:13:24', '2019-06-09 11:13:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approve_hostel_requests`
--
ALTER TABLE `approve_hostel_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_tokens`
--
ALTER TABLE `device_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hostels_registration-requests`
--
ALTER TABLE `hostels_registration-requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hostel_images`
--
ALTER TABLE `hostel_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hostel_profiles`
--
ALTER TABLE `hostel_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mess-menu-timinigs`
--
ALTER TABLE `mess-menu-timinigs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mess_menu-meal`
--
ALTER TABLE `mess_menu-meal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_pictures`
--
ALTER TABLE `profile_pictures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queries`
--
ALTER TABLE `queries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `update-hostels-requests`
--
ALTER TABLE `update-hostels-requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approve_hostel_requests`
--
ALTER TABLE `approve_hostel_requests`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `device_tokens`
--
ALTER TABLE `device_tokens`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `hostels_registration-requests`
--
ALTER TABLE `hostels_registration-requests`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hostel_images`
--
ALTER TABLE `hostel_images`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `hostel_profiles`
--
ALTER TABLE `hostel_profiles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mess-menu-timinigs`
--
ALTER TABLE `mess-menu-timinigs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mess_menu-meal`
--
ALTER TABLE `mess_menu-meal`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `profile_pictures`
--
ALTER TABLE `profile_pictures`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `update-hostels-requests`
--
ALTER TABLE `update-hostels-requests`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
