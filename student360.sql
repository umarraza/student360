-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2019 at 12:59 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

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
(1, 'image_1559124359.jpeg', 1, 8, '2019-05-27 04:13:18', '2019-05-29 05:05:59'),
(2, 'image_1559285963.jpeg', 1, 7, '2019-05-27 04:13:25', '2019-05-27 04:13:25'),
(3, 'image_1559124782.jpeg', 0, 7, '2019-05-27 04:13:30', '2019-05-29 05:13:02'),
(4, 'image_1558948411.png', 0, 7, '2019-05-27 04:13:31', '2019-05-27 04:13:31'),
(6, 'image_1559109628.jpeg', 1, 5, '2019-05-29 01:00:28', '2019-05-29 01:00:28'),
(7, 'image_1559121500.jpeg', 0, 8, '2019-05-29 04:18:20', '2019-05-29 04:18:20'),
(8, 'image_1559121536.jpeg', 0, 8, '2019-05-29 04:18:56', '2019-05-29 04:18:56'),
(11, 'image_1559204104.jpeg', 1, 9, '2019-05-30 03:15:04', '2019-05-30 03:15:04');

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
  `description` varchar(500) NOT NULL,
  `contactName` varchar(50) NOT NULL,
  `contactEmail` varchar(30) DEFAULT NULL,
  `website` varchar(50) NOT NULL,
  `phoneNumber` varchar(50) NOT NULL,
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
(5, 'prime', 'boys', 10, 20, '15000-20000', 'Haji Sadiq Rd, Block B2 Block B 2 Phase 1 Johar Town, Lahore, Punjab 54600, Pakistan', '74.2659491', '31.4466242', 'punjab', 54000, 'lahore', 'pakistan', 'average Hostel', 'anas', 'anas@gmail.com', 'anas.com', '03009444444', 0, 1, '[\"24-hour reception\",\"24-hour security\",\"Air conditioning\",\"ATM\",\"BBQ area\",\"Parking area\",\"Board Games\",\"Mess\"]', 25, '2019-05-28 00:44:12', '2019-05-28 00:45:53'),
(7, '6 Star Hostel', 'Girls', 25, 15, '5000', 'Haji Sadiq Rd, Block B2 Block B 2 Phase 1 Johar Town, Lahore, Punjab 54600, Pakistan', '10.000000', '10.000000', 'Sindh', 212121, 'Karachi', 'Pakistan', 'Mairona Hotels Gulberg is located in Lahore, 28 km from Wagah Border.', 'Shehzad Numan', 'shehzad@gmail.com', 'www.maironahotel.com', '03218840489', 0, 1, '[\"24-hour reception\",\"24-hour security\",\"Air conditioning\",\"ATM\",\"BBQ area\",\"Parking area\",\"Board Games\",\"Mess\",\"TV\",\"Ceiling Fan\",\"Childrens play area\",\"Common Room\",\"Currency Exchange\",\"Direct Dial Telephone\",\"Kitchen\",\"Elevator\",\"Free Internet Access\",\"Free Parking\",\"Free WiFi\",\"Fridge/Freezer\",\"Fusball\",\"Games Room\",\"Gym\",\"Housekeeping\",\"Internet Access\",\"Iron/ironing Board\",\"Laundry Facilities\",\"Lockers\",\"Luggage Storage\",\"Microwave\",\"Outdoor Swimming Pool\",\"Outdoor Terrace\",\"Pool Table\",\"Reception (limited hours)\",\"Swimming Pool\",\"Tea & Coffee Making Facilities\",\"Vending Machines\",\"Wake-up calls\",\"Washing Machine\",\"Wheelchair Accessible\",\"Video games\",\"Transport\",\"CCTV\",\"Sports area\",\"Lawn\",\"Attached bathrooms\",\"Room service\",\"Pets allowed\",\"Guests allowed\",\"Water filter\",\"First aid\",\"Furnished\",\"Not furnished\",\"UPS\",\"Geyser\",\"Study room\",\"Medical support\",\"Ground Floor\",\"Professional cook\",\"Carpeted rooms\",\"Cupboards\",\"Daily news paper\",\"Electricity 24/7\",\"3-time meal\",\"Non- Smoking\",\"seprate\"]', 31, '2019-05-28 05:06:30', '2019-05-31 23:52:27'),
(8, 'Continental Guest House', 'Guest House', 50, 50, '5000', 'Haji Sadiq Rd, Block B2 Block B 2 Phase 1 Johar Town, Lahore, Punjab 54600, Pakistan', '10.000000', '10.000000', 'Punjab', 212121, 'Islamabad', 'Pakistan', 'Mairona Hotels Gulberg is located in Lahore, 28 km from Wagah Border.', 'Malik Javed', 'javed@gmail.com', 'www.maironahotel.com', '03218840489', 0, 0, '[\"24-hour reception\",\"24-hour security\",\"Air conditioning\",\"ATM\",\"BBQ area\",\"Parking area\",\"Board Games\",\"Mess\",\"TV\",\"Ceiling Fan\",\"Childrens play area\",\"Common Room\"]', 32, '2019-05-29 04:04:19', '2019-05-29 04:04:19'),
(9, 'Five Star Hostel', 'Boys', 50, 50, '5000', 'Haji Sadiq Rd, Block B2 Block B 2 Phase 1 Johar Town, Lahore, Punjab 54600, Pakistan', '10.000000', '10.000000', 'Punjab', 212121, 'Islamabad', 'Pakistan', 'Mairona Hotels Gulberg is located in Lahore, 28 km from Wagah Border.', 'Ahtisham', 'ahtisham@gmail.com', 'www.maironahotel.com', '03218840489', 0, 1, '[\"24-hour reception\",\"24-hour security\",\"Air conditioning\",\"ATM\",\"BBQ area\",\"Parking area\",\"Board Games\",\"Mess\",\"TV\",\"Ceiling Fan\",\"Childrens play area\",\"Common Room\"]', 33, '2019-05-29 05:50:55', '2019-05-29 05:50:55'),
(11, '3 Star Hostel', 'Boys', 30, 30, '15000-20000', 'Lahore, Pakistan', '74.3967798', '31.5811398', 'Punjab', 1214, 'Lahore', 'Pakistan', 'some description', 'Mujahid Alvi', 'mujahid@gmail.com', 'www.example.com', '0303121241', 0, 0, '[\"24-hour reception\",\"24-hour security\",\"Air conditioning\",\"ATM\",\"BBQ area\",\"Parking area\",\"Board Games\",\"Mess\",\"TV\",\"Ceiling Fan\",\"Childrens play area\",\"Common Room\"]', 50, '2019-05-31 03:17:32', '2019-05-31 03:17:32');

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
(5, '07:00 AM', '10:00 AM', '01:00 PM', '03:00 PM', '07:00 PM', '10:00 PM', 0, 0, 0, 5, '2019-05-28 00:44:12', '2019-05-28 00:44:12'),
(7, '06:00 AM', '09:00 AM', '12:00 PM', '03:00 PM', '06:00 PM', '09:00 PM', 1, 1, 1, 7, '2019-05-28 05:06:30', '2019-06-01 02:01:36'),
(8, '07:00 AM', '10:00 AM', '01:00 PM', '03:00 PM', '07:00 PM', '10:00 PM', 0, 0, 0, 8, '2019-05-29 04:04:19', '2019-05-29 04:04:19'),
(9, '07:00 AM', '10:00 AM', '01:00 PM', '03:00 PM', '07:00 PM', '10:00 PM', 0, 0, 0, 9, '2019-05-29 05:50:55', '2019-05-29 05:50:55'),
(11, '07:00 AM', '10:00 AM', '01:00 PM', '03:00 PM', '07:00 PM', '10:00 PM', 0, 0, 0, 11, '2019-05-31 03:17:32', '2019-05-31 03:17:32');

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
(25, 'Mon', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 5, '2019-05-28 00:44:12', '2019-05-28 00:44:12'),
(26, 'Tue', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 5, '2019-05-28 00:44:12', '2019-05-28 00:44:12'),
(27, 'Wed', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 5, '2019-05-28 00:44:12', '2019-05-28 00:44:12'),
(28, 'Thu', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 5, '2019-05-28 00:44:12', '2019-05-28 00:44:12'),
(29, 'Fri', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 5, '2019-05-28 00:44:12', '2019-05-28 00:44:12'),
(30, 'Sat', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 5, '2019-05-28 00:44:12', '2019-05-28 00:44:12'),
(37, 'Mon', 'Rice', 'Beaf', 'Koftay', 7, '2019-05-28 05:06:30', '2019-06-01 01:58:54'),
(38, 'Tue', 'Pratha Channay', 'Koftay', 'Rice', 7, '2019-05-28 05:06:30', '2019-06-01 01:49:45'),
(39, 'Wed', 'Pratha Channay', 'Koftay', 'Rice', 7, '2019-05-28 05:06:30', '2019-06-01 01:49:45'),
(40, 'Thu', 'Beaf', 'Koftay', 'Rice', 7, '2019-05-28 05:06:30', '2019-06-01 02:01:36'),
(41, 'Fri', 'Pratha Channay', 'Koftay', 'Rice', 7, '2019-05-28 05:06:30', '2019-06-01 01:49:45'),
(42, 'Sat', 'Pratha Channay', 'Koftay', 'Rice', 7, '2019-05-28 05:06:30', '2019-06-01 01:49:45'),
(43, 'Mon', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 8, '2019-05-29 04:04:19', '2019-05-29 04:04:19'),
(44, 'Tue', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 8, '2019-05-29 04:04:19', '2019-05-29 04:04:19'),
(45, 'Wed', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 8, '2019-05-29 04:04:19', '2019-05-29 04:04:19'),
(46, 'Thu', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 8, '2019-05-29 04:04:19', '2019-05-29 04:04:19'),
(47, 'Fri', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 8, '2019-05-29 04:04:19', '2019-05-29 04:04:19'),
(48, 'Sat', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 8, '2019-05-29 04:04:19', '2019-05-29 04:04:19'),
(49, 'Mon', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 9, '2019-05-29 05:50:55', '2019-05-29 05:50:55'),
(50, 'Tue', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 9, '2019-05-29 05:50:55', '2019-05-29 05:50:55'),
(51, 'Wed', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 9, '2019-05-29 05:50:55', '2019-05-29 05:50:55'),
(52, 'Thu', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 9, '2019-05-29 05:50:55', '2019-05-29 05:50:55'),
(53, 'Fri', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 9, '2019-05-29 05:50:55', '2019-05-29 05:50:55'),
(54, 'Sat', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 9, '2019-05-29 05:50:55', '2019-05-29 05:50:55'),
(61, 'Mon', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 11, '2019-05-31 03:17:32', '2019-05-31 03:17:32'),
(62, 'Tue', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 11, '2019-05-31 03:17:32', '2019-05-31 03:17:32'),
(63, 'Wed', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 11, '2019-05-31 03:17:32', '2019-05-31 03:17:32'),
(64, 'Thu', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 11, '2019-05-31 03:17:32', '2019-05-31 03:17:32'),
(65, 'Fri', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 11, '2019-05-31 03:17:32', '2019-05-31 03:17:32'),
(66, 'Sat', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 11, '2019-05-31 03:17:32', '2019-05-31 03:17:32');

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
(3, 'image_1559287989.jpeg', 29, '2019-05-30 00:03:45', '2019-05-31 02:33:09'),
(4, 'image_1559287789.jpeg', 28, '2019-05-30 00:04:44', '2019-05-31 02:29:49');

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
(1, 'What are the prices of mess menu?', 'Q', 6, 5, '2019-05-27 02:26:01', '2019-05-27 02:26:01'),
(2, 'some other', 'Q', 6, 5, '2019-05-27 02:26:12', '2019-05-27 02:26:12'),
(3, 'Prices are different for different hostel\'s mess menu.', 'Q', 5, 7, '2019-05-27 02:26:27', '2019-05-27 02:26:27'),
(4, 'Is wifi service available of this hostel?', 'U', 6, 9, '2019-05-30 04:21:29', '2019-05-30 04:21:29'),
(5, 'What are the prices for mess menu?', 'Q', 14, 8, '2019-06-01 04:33:25', '2019-06-01 04:33:25'),
(10, 'Hello?', 'Q', 18, 5, '2019-06-01 05:09:07', '2019-06-01 05:09:07'),
(11, 'Parking available?', 'Q', 18, 5, '2019-06-01 05:09:35', '2019-06-01 05:09:35');

-- --------------------------------------------------------

--
-- Table structure for table `queries_by_student`
--

CREATE TABLE `queries_by_student` (
  `id` int(10) NOT NULL,
  `question` varchar(500) DEFAULT NULL,
  `answers` varchar(500) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `hostelId` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `queries_by_student`
--

INSERT INTO `queries_by_student` (`id`, `question`, `answers`, `type`, `hostelId`, `userId`, `createdAt`, `updatedAt`) VALUES
(1, 'Is wifi service available of this hostel?', NULL, 'Q', 5, 29, '2019-05-31 05:05:32', '2019-05-31 05:05:32'),
(2, 'Yes available', 'AYes available', 'A', 5, 29, '2019-05-31 05:06:37', '2019-05-31 05:06:37'),
(3, 'Parking available?', NULL, 'Q', 7, 29, '2019-05-31 05:11:01', '2019-05-31 05:11:01'),
(4, NULL, 'Yes Available parking', 'A', 7, 29, '2019-05-31 05:11:29', '2019-05-31 05:11:29');

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
(1, 3, 29, 7, '2019-05-28 23:56:09', '2019-05-28 23:56:09'),
(2, 3, 29, 5, '2019-05-28 23:56:49', '2019-05-28 23:56:49'),
(3, 2, 29, 8, '2019-05-29 08:18:07', '2019-05-29 08:18:07'),
(4, 3, 28, 7, '2019-05-29 03:54:50', '2019-05-29 03:54:50'),
(5, 4, 28, 5, '2019-05-29 04:13:18', '2019-05-29 04:13:18'),
(6, 2, 28, 8, '2019-05-29 04:14:02', '2019-05-29 04:14:02'),
(9, 3, 28, 9, '2019-05-30 03:10:54', '2019-05-30 03:10:54'),
(10, 2, 29, 8, '2019-05-30 05:34:55', '2019-05-30 05:34:55'),
(12, 1, 29, 9, '2019-05-30 05:39:00', '2019-05-30 05:39:00'),
(17, 4, 47, 7, '2019-05-31 00:24:33', '2019-05-31 00:24:33');

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
(3, 'Quite good services they offered', 7, 29, '2019-05-29 01:19:11', '2019-05-31 02:13:02'),
(4, 'Not a good hostel at all', 7, 28, '2019-05-29 01:19:40', '2019-05-29 01:19:40'),
(5, 'Great hostel to live', 8, 29, '2019-05-29 01:23:03', '2019-05-29 01:23:03'),
(6, 'Bad Services', 8, 28, '2019-05-29 04:16:00', '2019-05-29 04:16:00'),
(7, 'Bad Services', 5, 28, '2019-05-29 04:21:51', '2019-05-29 04:21:51'),
(10, 'Good thing about this hostel is cleanliness', 9, 28, '2019-05-30 03:20:51', '2019-05-30 03:20:51'),
(11, 'Nice', 7, 29, '2019-05-30 05:20:15', '2019-05-30 05:20:15'),
(12, 'Nice hostel', 8, 29, '2019-05-30 05:28:38', '2019-05-30 05:28:38'),
(13, 'So', 9, 29, '2019-05-30 05:31:22', '2019-05-30 05:31:22'),
(14, 'So nice', 9, 29, '2019-05-30 05:32:32', '2019-05-30 05:32:32'),
(15, 'Good', 8, 29, '2019-05-30 05:34:54', '2019-05-30 05:34:54'),
(16, 'Good one', 9, 29, '2019-05-30 05:38:19', '2019-05-30 05:38:19'),
(17, 'Just', 9, 29, '2019-05-30 05:38:59', '2019-05-30 05:38:59'),
(18, 'Good', 5, 29, '2019-05-30 05:42:18', '2019-05-30 05:42:18'),
(19, 'Good', 5, 29, '2019-05-30 05:43:24', '2019-05-30 05:43:24'),
(20, 'Ok', 5, 29, '2019-05-30 05:46:50', '2019-05-30 05:46:50'),
(21, 'Nice hostel', 7, 47, '2019-05-31 00:24:33', '2019-05-31 00:24:33');

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
(5, 7, 29, '2019-05-30 04:19:52', '2019-05-30 04:19:52'),
(6, 5, 29, '2019-05-28 02:40:45', '2019-05-28 02:40:45'),
(14, 8, 45, '2019-06-01 04:30:52', '2019-06-01 04:30:52'),
(18, 5, 45, '2019-06-01 05:09:07', '2019-06-01 05:09:07');

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

--
-- Dumping data for table `update-hostels-requests`
--

INSERT INTO `update-hostels-requests` (`id`, `hostelName`, `hostelCategory`, `numberOfBedRooms`, `noOfBeds`, `priceRange`, `address`, `longitude`, `latitude`, `state`, `postCode`, `city`, `country`, `description`, `contactName`, `contactEmail`, `website`, `phoneNumber`, `features`, `status`, `hostelId`, `userId`, `createdAt`, `updatedAt`) VALUES
(1, 'Prime Hostel', 'boys', 10, 20, '15000-20000', '280-B/2 Johar town, Lahore', '31.520370', '74.358747', 'punjab', '54000', 'lahore', 'pakistan', 'average Hostel', 'anas', NULL, 'anas.com', '03009444444', '[\"24-hour reception\",\"24-hour security\",\"Air conditioning\",\"ATM\",\"BBQ area\"]', 0, 5, 25, '2019-05-29 05:48:43', '2019-05-29 05:48:43'),
(2, 'Prime Hostel', 'boys', 10, 20, '15000-20000', '280-B/2 Johar town, Lahore', '31.520370', '74.358747', 'punjab', '54000', 'lahore', 'pakistan', 'average Hostel', 'anas', NULL, 'anas.com', '03009444444', '[\"24-hour reception\",\"24-hour security\",\"Air conditioning\",\"ATM\",\"BBQ area\"]', 0, 5, 25, '2019-05-29 05:48:49', '2019-05-29 05:48:49');

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
(1, 'super.admin@admin.com', 'super.admin@admin.com', '$2y$10$VwROsyn0bDr5gTh/rnCCG.5JN3kZTAWEEUZPJLHfiZf.84ZLdPtwq', NULL, 1, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '', '2019-05-07 01:14:38', '2019-05-06 20:14:38'),
(25, 'anas.baig', 'anas@gmail.com', '$2y$10$.n3bSKf/f8msUAaXBnb14uSWyKc/bfA.SZ8n/bRdtSRXS3mypehde', NULL, 2, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-05-28 05:45:53', '2019-05-28 00:45:53'),
(28, 'hassan', 'umar123@gmail.com', '$2y$10$UMC20mDosFo/.aKbbTt0kOYy0GKn21JML4lKEvvB4wu3SrIs1N5.m', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-05-29 04:42:50', '2019-05-28 23:42:50'),
(29, 'rizwanmunir', 'rizwan@gmail.com', '$2y$10$BPgJciN1dHN6OuRwj4HLLeJ2mLTZ.JGvFuLjnwBCG29awAolvBMFO', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-05-30 10:36:00', '2019-05-28 03:23:02'),
(31, 'shehzad@gmail.com', 'shehzad@gmail.com', '$2y$10$oxnFVw1yq99KmNjg..B.ae0h0QTY2VTLIVcE7jTi/1SqvsD1oe7M2', NULL, 2, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-05-28 10:06:49', '2019-05-28 05:06:30'),
(32, 'javed@gmail.com', 'javed@gmail.com', '$2y$10$uuQkqtxSrQFYf9zQ678mFuZiM6x54f8Y6qtCoRIwgV7MH3CpYRqH6', NULL, 2, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'English', '2019-05-31 06:47:33', '2019-05-29 04:04:19'),
(33, 'ahtisham210', 'ahtisham@gmail.com', '$2y$10$XLbnWilqqt.4hIBnSm9fUuQ9bfP9TDzhpqLBMX5rDuEk73FPMERyO', NULL, 2, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-05-31 06:13:43', '2019-05-29 05:50:55'),
(34, 'kami', 'kami@gmail.com', '$2y$10$56WgYDWeYb6ow3o.YET1kOpiYUmQmwamC.vMX9lBTjTRxr8PFTNeS', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-05-31 06:30:28', '2019-05-31 01:30:28'),
(45, 'umarraza', 'umar@gmail.com', '$2y$10$LFpmbyi/sghex9eulh3vuexbGcXWxW/SplLkS5kplzjKg9C9K0i9.', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-06-01 06:10:09', '2019-06-01 01:10:09'),
(47, 'Shan', 'Shan@gmail.com', '$2y$10$glfAsWYr5WU/6LjX.skAX.2Kfu5gqteHxhPFK4WneSLMzHPhW4M9q', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-05-31 05:18:30', '2019-05-31 00:18:30'),
(50, 'mujahid', 'mujahid@gmail.com', '$2y$10$qFbjSelf4z9gIyLnAyezuOMIx7UM/NpmZStRv8mAXpybSf4Bn.goi', NULL, 2, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'English', '2019-05-31 03:17:32', '2019-05-31 03:17:32');

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
(4, 'Anas', '030000000', 'anas@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 28, '2019-05-28 01:35:15', '2019-05-28 01:35:15'),
(5, 'Rizwan Munir', '03034969408', 'rizwanmunir@gmail.com', 'Lahore', 'Pakistan', 'Computer Engineer', 'UMT', '15-04-1996', 'Male', '3520161178493', 1, 5, 29, '2019-05-28 02:40:45', '2019-05-28 23:42:50'),
(6, 'Kamran', '031111111', 'kami@gmail.com', 'Krachi', 'Pakistan', 'Graphic Designer', 'UCP', '15-03-1995', 'Male', '35201-2335489-3', 1, 6, 34, '2019-05-30 04:19:52', '2019-05-31 01:30:28'),
(10, 'Umar Raza', '03034646101', 'umar@gmail.com', 'lahore', 'pakistan', 'student', 'punjab university', '15-03-1995', 'male', '350111235439', 1, 12, 45, '2019-05-31 00:03:24', '2019-06-01 01:10:09'),
(11, 'Shan ali', '03001234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 13, 47, '2019-05-31 00:18:30', '2019-05-31 00:18:30');

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
-- Indexes for table `queries_by_student`
--
ALTER TABLE `queries_by_student`
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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `hostel_profiles`
--
ALTER TABLE `hostel_profiles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `mess-menu-timinigs`
--
ALTER TABLE `mess-menu-timinigs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `mess_menu-meal`
--
ALTER TABLE `mess_menu-meal`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `profile_pictures`
--
ALTER TABLE `profile_pictures`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `queries_by_student`
--
ALTER TABLE `queries_by_student`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `update-hostels-requests`
--
ALTER TABLE `update-hostels-requests`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
