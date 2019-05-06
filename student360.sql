-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2019 at 06:32 AM
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
-- Table structure for table `hostels_registration-requests`
--

CREATE TABLE `hostels_registration-requests` (
  `id` int(10) NOT NULL,
  `isApproved` tinyint(4) NOT NULL DEFAULT '0',
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
  `image_name` varchar(50) NOT NULL,
  `hostelId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hostel_images`
--

INSERT INTO `hostel_images` (`id`, `image_name`, `hostelId`, `createdAt`, `updatedAt`) VALUES
(1, 'image_1557041414.png', 1, '2019-05-05 14:30:14', '2019-05-05 14:30:14');

-- --------------------------------------------------------

--
-- Table structure for table `hostel_profiles`
--

CREATE TABLE `hostel_profiles` (
  `id` int(10) NOT NULL,
  `hostelName` varchar(50) NOT NULL,
  `hostelType` varchar(50) NOT NULL,
  `numberOfBedRooms` int(10) NOT NULL,
  `noOfBeds` int(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postCode` int(20) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `contactName` varchar(50) NOT NULL,
  `contactEmail` varchar(30) NOT NULL,
  `website` varchar(50) NOT NULL,
  `phoneNumber` int(30) NOT NULL,
  `isApproved` tinyint(4) NOT NULL DEFAULT '0',
  `isAvailable` tinyint(4) DEFAULT '0',
  `facilities` varchar(1000) NOT NULL,
  `userId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hostel_profiles`
--

INSERT INTO `hostel_profiles` (`id`, `hostelName`, `hostelType`, `numberOfBedRooms`, `noOfBeds`, `address`, `longitude`, `latitude`, `state`, `postCode`, `city`, `country`, `description`, `contactName`, `contactEmail`, `website`, `phoneNumber`, `isApproved`, `isAvailable`, `facilities`, `userId`, `createdAt`, `updatedAt`) VALUES
(1, 'Lahore Hostel', 'Boys', 10, 20, '6-S-A Gulberg II Lahore, Gulberg, 54660 Lahore, Pakistan', '29.546687', '29.546687', NULL, NULL, 'Lahore', 'Pakistan', 'Mairona Hotels Gulberg is located in Lahore, 28 km from Wagah Border, and offers free WiFi. Located around 1.2 km from Pace Shopping Mall, the hotel is also 2.1 km away from Lahore Gymkhana. A tour desk can provide information on the area.', 'Imtiaz Ali', 'imtiazali@gmail.com', 'www.maironahotel.com', 321, 0, 0, 'wifi, AC,', 5, '2019-05-05 05:46:35', '2019-05-05 05:46:35'),
(7, 'Grand Palm Hotel', 'Girls', 50, 50, '6-S-A Gulberg II Lahore, Gulberg, 54660 Lahore, Pakistan', '71.627639', '29.546687', NULL, NULL, 'Lahore', 'Pakistan', 'Mairona Hotels Gulberg is located in Lahore, 28 km from Wagah Border, and offers free WiFi. Located around 1.2 km from Pace Shopping Mall, the hotel is also 2.1 km away from Lahore Gymkhana. A tour desk can provide information on the area.', 'Adnan Razzaq', 'adnan@gmail.com', 'www.maironahotel.com', 321, 0, 0, 'wifi, AC,', 14, '2019-05-05 13:50:32', '2019-05-05 13:50:32');

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE `queries` (
  `id` int(10) NOT NULL,
  `query` varchar(500) NOT NULL,
  `hostelId` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(10) NOT NULL,
  `rating` varchar(200) NOT NULL,
  `userId` int(10) NOT NULL,
  `hostelId` int(10) NOT NULL,
  `createdAt` int(11) NOT NULL,
  `updatedAt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) NOT NULL,
  `review` varchar(200) NOT NULL,
  `hostelId` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `update_requests`
--

CREATE TABLE `update_requests` (
  `id` int(10) NOT NULL,
  `isApproved` tinyint(4) NOT NULL DEFAULT '0',
  `hostelId` int(10) NOT NULL,
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
(1, 'super.admin@admin.com', 'super.admin@admin.com', '$2y$10$H37nrQO752FJnZsKSHNwdeez2pDm3rLBAx9e1YwBEK5yKR6pUeuIW', NULL, 1, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '', '2019-05-05 01:56:35', '0000-00-00 00:00:00'),
(5, 'imtiazali@gmail.com', NULL, '$2y$10$/HXEOgCraobyeBlSNwSSoe414MAhcxpu6MMFVCEIo..qoO0ONzTj.', NULL, 2, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-05-05 07:28:26', '2019-05-05 05:46:35'),
(7, 'umarraza2200@gmail.com', NULL, '$2y$10$I4dpKP3LcFuyjJPhY21h7e1ckEGuWJ.KSVuhTo6s4.yB2EclfOg8G', NULL, 3, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'English', '2019-05-05 03:56:33', '2019-05-05 09:44:51'),
(10, 'faizan@gmail.com', NULL, '$2y$10$mN0FcnU.2DHl86fh0sYwqe4WsphQyNIRmQlgVSVKgduwZJxftlNuy', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', '2019-05-05 03:56:44', '2019-05-05 09:18:34'),
(14, 'adnan@gmail.com', NULL, '$2y$10$z2h6ZbXC4KWPz.CBxKPkZOiwbI/uGG1PQq1Tuu4nvbSBIJdKuV0ou', NULL, 2, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'English', '2019-05-05 13:50:32', '2019-05-05 13:50:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` int(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `city` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `occupation` varchar(20) NOT NULL,
  `institute` varchar(20) NOT NULL,
  `dateOfBirth` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `CNIC` int(50) NOT NULL,
  `userId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `name`, `phone`, `email`, `city`, `country`, `occupation`, `institute`, `dateOfBirth`, `gender`, `CNIC`, `userId`, `createdAt`, `updatedAt`) VALUES
(2, 'Umar Raza', 121212, 'umarraza2200@gmail.com', 'Lahore', 'Pakistan', 'PHP Developer', 'VU', '15-03-1995', 'Male', 3520, 7, '2019-05-05 08:25:36', '2019-05-05 08:25:36'),
(3, 'Faizan E Elahi', 121212, 'faizan@gmail.com', 'Lahore', 'Pakistan', 'Electrical Engineer', 'UET', '15-03-1995', 'Male', 3520, 10, '2019-05-05 09:18:34', '2019-05-05 09:18:34');

-- --------------------------------------------------------

--
-- Table structure for table `varification_badge`
--

CREATE TABLE `varification_badge` (
  `id` int(10) NOT NULL,
  `isVarified` tinyint(4) NOT NULL DEFAULT '0',
  `hostelI` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

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
-- Indexes for table `update_requests`
--
ALTER TABLE `update_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_k1` (`roleId`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `varification_badge`
--
ALTER TABLE `varification_badge`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hostels_registration-requests`
--
ALTER TABLE `hostels_registration-requests`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hostel_images`
--
ALTER TABLE `hostel_images`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hostel_profiles`
--
ALTER TABLE `hostel_profiles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `update_requests`
--
ALTER TABLE `update_requests`
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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `varification_badge`
--
ALTER TABLE `varification_badge`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
