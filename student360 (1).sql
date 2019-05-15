-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2019 at 12:54 PM
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

--
-- Dumping data for table `approve_hostel_requests`
--

INSERT INTO `approve_hostel_requests` (`id`, `approveStatus`, `hostelId`, `createdAt`, `updatedAt`) VALUES
(1, 0, 3, '2019-05-15 09:07:57', '2019-05-15 09:07:57'),
(2, 0, 4, '2019-05-15 09:49:11', '2019-05-15 09:49:11');

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
(9, 'image_1557809594.png', 1, 20, '2019-05-13 23:53:14', '2019-05-13 23:53:14');

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
  `longitude` varchar(50) NOT NULL,
  `latitude` varchar(50) NOT NULL,
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
(3, 'Friends Hostel', 'boys', 20, 40, '10000-12000', '20A B block, Johar town, Lahore', '31.520370', '74.358747', 'punjab', 54000, 'Lahore', 'Pakistan', 'Neat and clean hostle with good envinonment and fascilities', 'mahad', NULL, 'friends.com', '03009444444', 1, 1, '[\"ATM\",\"BBQ area\"]', 13, '2019-05-15 03:11:07', '2019-05-15 05:47:40'),
(4, 'Continental Hostel', 'Boys', 30, 20, '15000', 'Johar Town Lahore', '74.358747', '31.520370', 'Punjab', 15253, 'Lahore', 'Pakistan', 'Mairona Hotels Gulberg is located in Lahore, 28 km from Wagah Border', 'Sikandar', NULL, 'www.continentalhostel.com', '03034969407', 0, 1, '[\"ATM\",\"BBQ area\"]', 16, '2019-05-15 04:48:49', '2019-05-15 05:45:31'),
(5, 'chillHostel', 'boys', 20, 30, '15000-20000', '570 b block, johar town', '31.520370', '74.358747', 'punjab', 54000, 'lahore', 'pakistan', 'average hostel', 'anas', 'anas@gmail.com', 'cool.com', '03249470780', 1, 1, '[\"Air conditioning\",\"ATM\",\"BBQ area\",\"Parking area\",\"Board Games\",\"Mess\",\"TV\",\"Ceiling Fan\",\"Childrens play area\",\"Common Room\",\"Currency Exchange\"]', 17, '2019-05-15 05:43:21', '2019-05-15 05:47:47');

-- --------------------------------------------------------

--
-- Table structure for table `mess-menu-timinigs`
--

CREATE TABLE `mess-menu-timinigs` (
  `id` int(10) NOT NULL,
  `bkfastStartTime` varchar(30) NOT NULL,
  `bkfastEndTime` varchar(30) NOT NULL,
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

INSERT INTO `mess-menu-timinigs` (`id`, `bkfastStartTime`, `bkfastEndTime`, `lunchStartTime`, `lunchEndTime`, `dinnerStartTime`, `dinnerEndTime`, `isSetBreakFast`, `isSetLunch`, `isSetDinner`, `hostelId`, `createdAt`, `updatedAt`) VALUES
(1, '07:00 AM ', '10:00 AM', '01:00 PM', '03:00 PM', '07:00 PM', '07:10 PM', 0, 0, 0, 3, '2019-05-15 03:11:07', '2019-05-15 03:11:07'),
(2, '07:00 AM ', '10:00 AM', '01:00 PM', '03:00 PM', '07:00 PM', '07:10 PM', 0, 0, 0, 4, '2019-05-15 04:48:49', '2019-05-15 04:48:49'),
(3, '07:00 AM ', '10:00 AM', '01:00 PM', '03:00 PM', '07:00 PM', '07:10 PM', 0, 0, 0, 5, '2019-05-15 05:43:21', '2019-05-15 05:43:21');

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
(1, 'Mon', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 3, '2019-05-15 03:11:07', '2019-05-15 03:11:07'),
(2, 'Tue', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 3, '2019-05-15 03:11:07', '2019-05-15 03:11:07'),
(3, 'Wed', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 3, '2019-05-15 03:11:07', '2019-05-15 03:11:07'),
(4, 'Thu', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 3, '2019-05-15 03:11:07', '2019-05-15 03:11:07'),
(5, 'Fri', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 3, '2019-05-15 03:11:07', '2019-05-15 03:11:07'),
(6, 'Sat', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 3, '2019-05-15 03:11:07', '2019-05-15 03:11:07'),
(7, 'Mon', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 4, '2019-05-15 04:48:49', '2019-05-15 04:48:49'),
(8, 'Tue', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 4, '2019-05-15 04:48:49', '2019-05-15 04:48:49'),
(9, 'Wed', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 4, '2019-05-15 04:48:49', '2019-05-15 04:48:49'),
(10, 'Thu', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 4, '2019-05-15 04:48:49', '2019-05-15 04:48:49'),
(11, 'Fri', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 4, '2019-05-15 04:48:49', '2019-05-15 04:48:49'),
(12, 'Sat', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 4, '2019-05-15 04:48:49', '2019-05-15 04:48:49'),
(13, 'Mon', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 5, '2019-05-15 05:43:21', '2019-05-15 05:43:21'),
(14, 'Tue', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 5, '2019-05-15 05:43:21', '2019-05-15 05:43:21'),
(15, 'Wed', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 5, '2019-05-15 05:43:21', '2019-05-15 05:43:21'),
(16, 'Thu', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 5, '2019-05-15 05:43:21', '2019-05-15 05:43:21'),
(17, 'Fri', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 5, '2019-05-15 05:43:21', '2019-05-15 05:43:21'),
(18, 'Sat', 'Set Break Fast Meal', 'Set lunch Meal', 'Set Dinner Meal', 5, '2019-05-15 05:43:21', '2019-05-15 05:43:21');

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
(1, 'image_1557137425.png', 19, '2019-05-06 05:10:25', '2019-05-06 05:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE `queries` (
  `id` int(10) NOT NULL,
  `message` varchar(500) NOT NULL,
  `type` varchar(20) NOT NULL,
  `threadId` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `queries`
--

INSERT INTO `queries` (`id`, `message`, `type`, `threadId`, `createdAt`, `updatedAt`) VALUES
(1, 'What are the prices?', 'U', 3, '2019-05-08 21:03:10', '2019-05-08 21:03:10'),
(2, 'Wifi available?', 'U', 3, '2019-05-08 21:05:17', '2019-05-08 21:05:17'),
(3, 'What are the prices of mess menu?', 'U', 4, '2019-05-08 21:17:24', '2019-05-08 21:17:24');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(10) NOT NULL,
  `score` varchar(200) NOT NULL,
  `userId` int(10) NOT NULL,
  `hostelId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `score`, `userId`, `hostelId`, `createdAt`, `updatedAt`) VALUES
(1, '1', 15, 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, '2', 16, 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, '3', 18, 9, '2019-05-06 05:54:08', '2019-05-06 05:54:08');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) NOT NULL,
  `message` varchar(200) NOT NULL,
  `hostelId` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `message`, `hostelId`, `userId`, `createdAt`, `updatedAt`) VALUES
(1, 'Very affordable prices', 9, 34, '2019-05-07 00:29:30', '2019-05-07 00:29:30');

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
  `userId` int(10) NOT NULL,
  `adminId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`id`, `userId`, `adminId`, `createdAt`, `updatedAt`) VALUES
(1, 14, 1, '2019-05-15 03:50:34', '2019-05-15 03:50:34'),
(2, 15, 1, '2019-05-15 03:50:40', '2019-05-15 03:50:40'),
(3, 18, 1, '2019-05-15 05:49:10', '2019-05-15 05:49:10');

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
(1, 'Friends Hostel', 'boys', 20, 40, '10000-12000', '20A B block, Johar town, Lahore', '31.520370', '74.358747', 'punjab', '54000', 'Lahore', 'Pakistan', 'Neat and clean hostle with good envinonment and fascilities', 'mahad', NULL, 'friends.com', '03009444444', '[\"ATM\",\"BBQ area\"]', 1, 3, 13, '2019-05-15 05:20:47', '2019-05-15 05:21:51'),
(2, 'Continental Hostel', 'Boys', 30, 20, '15000', 'Johar Town Lahore', '74.358747', '31.520370', 'Punjab', '15253', 'Lahore', 'Pakistan', 'Mairona Hotels Gulberg is located in Lahore, 28 km from Wagah Border', 'Sikandar', NULL, 'www.continentalhostel.com', '03034969407', '[\"ATM\",\"BBQ area\"]', 1, 4, 16, '2019-05-15 05:22:06', '2019-05-15 05:22:21');

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
  `threadId` int(10) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `remember_token`, `roleId`, `resetPasswordToken`, `createdResetPToken`, `avatarFilePath`, `deviceToken`, `onlineStatus`, `verified`, `googleLogin`, `facebookLogin`, `language`, `threadId`, `createdAt`, `updatedAt`) VALUES
(1, 'super.admin@admin.com', 'super.admin@admin.com', '$2y$10$VwROsyn0bDr5gTh/rnCCG.5JN3kZTAWEEUZPJLHfiZf.84ZLdPtwq', NULL, 1, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '', 0, '2019-05-07 01:14:38', '2019-05-06 20:14:38'),
(13, 'mahadd', 'mahad@gmail.com', '$2y$10$b2MUQtjjCM6eVHrzsptaieV5Tx4K9CfU0vvZiw1jIvwAqne5Ia3O2', NULL, 2, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', NULL, '2019-05-15 08:26:47', '2019-05-15 03:26:47'),
(14, 'usman@gmail.com', NULL, '$2y$10$SwWGRdJbRQCZheyH/hREo.G3VaZs4xAnr0sG8TVCcNosp1i3xDs5e', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', 1, '2019-05-15 08:50:34', '2019-05-15 03:50:34'),
(15, 'mahmoodanas4012@gmail.com', NULL, '$2y$10$EDDnl7CLmuOiU0Us87TIiu5BILh5WA.UpnnPRO9MhdZTvLEQZ7KUC', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', 2, '2019-05-15 08:50:40', '2019-05-15 03:50:40'),
(16, 'shehzad@gmail.com', 'shehzad@gmail.com', '$2y$10$KdNVeWlrec8EaqqnbGZtL.6H5WVBk/Dj.iubUuF.HLdn0BHzLp1.G', NULL, 2, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', NULL, '2019-05-15 10:20:49', '2019-05-15 04:48:49'),
(17, 'anas.baig', 'anas@gmail.com', '$2y$10$zR0/nKhK6qzxcV1sF6YlT.ViRi9dXKauJwLUV9GYP8ZnmtYVMEY8.', NULL, 2, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', NULL, '2019-05-15 10:45:34', '2019-05-15 05:45:34'),
(18, 'hamza@gmail.com', NULL, '$2y$10$BrhV2Z3jWjiPVdd5Z/LKOejvIjCTz0F4hChMWvtlCINlvRrFt3qkS', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', 3, '2019-05-15 10:49:10', '2019-05-15 05:49:10');

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
  `userId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `fullName`, `phoneNumber`, `email`, `city`, `country`, `occupation`, `institute`, `dateOfBirth`, `gender`, `CNIC`, `isVerified`, `userId`, `createdAt`, `updatedAt`) VALUES
(1, 'Rizwan Munir', '03034969407', 'rizwan@gmail.com', 'Lahore', 'Pakistan', 'Electrical Engineer', 'UET', '15-03-1995', 'Male', '3520161178493', 1, 14, '2019-05-15 03:50:34', '2019-05-15 03:56:43'),
(2, 'Anas', '03249470780', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 15, '2019-05-15 03:50:40', '2019-05-15 03:50:40'),
(3, 'hamza', '03249470780', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 18, '2019-05-15 05:49:10', '2019-05-15 05:49:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approve_hostel_requests`
--
ALTER TABLE `approve_hostel_requests`
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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hostels_registration-requests`
--
ALTER TABLE `hostels_registration-requests`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hostel_profiles`
--
ALTER TABLE `hostel_profiles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `update-hostels-requests`
--
ALTER TABLE `update-hostels-requests`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
