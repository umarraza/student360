-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2019 at 09:47 AM
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
(4, 1, 9, '2019-05-09 02:46:03', '2019-05-09 02:47:19');

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

--
-- Dumping data for table `hostels_registration-requests`
--

INSERT INTO `hostels_registration-requests` (`id`, `verificationStatus`, `hostelId`, `createdAt`, `updatedAt`) VALUES
(1, 0, 20, '2019-05-09 22:47:08', '2019-05-09 22:47:08');

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
(1, 'image_1557041414.png', 1, 9, '2019-05-05 14:30:14', '2019-05-05 14:30:14'),
(2, 'image_1557120758.png', 1, 15, '2019-05-06 00:32:38', '2019-05-06 00:32:38'),
(3, 'image_1557120758.png', 1, 20, '2019-05-06 05:44:29', '2019-05-06 05:44:29'),
(4, 'image_1557122005.png', 0, 3, '2019-05-06 00:53:25', '2019-05-06 00:53:25'),
(6, 'image_1557122005.png', 0, 3, '2019-05-06 05:58:47', '2019-05-06 05:58:47');

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
  `state` varchar(50) NOT NULL,
  `postCode` int(20) NOT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `contactName` varchar(50) NOT NULL,
  `contactEmail` varchar(30) NOT NULL,
  `website` varchar(50) NOT NULL,
  `phoneNumber` varchar(50) NOT NULL,
  `isApproved` int(10) NOT NULL DEFAULT '0',
  `isVerified` int(10) NOT NULL DEFAULT '0',
  `isAvailable` tinyint(4) DEFAULT '0',
  `features` varchar(2000) NOT NULL,
  `userId` int(10) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hostel_profiles`
--

INSERT INTO `hostel_profiles` (`id`, `hostelName`, `hostelCategory`, `numberOfBedRooms`, `noOfBeds`, `priceRange`, `address`, `longitude`, `latitude`, `state`, `postCode`, `city`, `country`, `description`, `contactName`, `contactEmail`, `website`, `phoneNumber`, `isApproved`, `isVerified`, `isAvailable`, `features`, `userId`, `createdAt`, `updatedAt`) VALUES
(9, 'MASHALLAH BOYS HOSTEL GULBERG 3 NEAR HAJVERY UNIVERSITY', 'Boys', 10, 20, '10000-15000', 'iqbal town', '31.520370', '74.358747', 'punjab', 54000, 'lahore', 'pakistan', 'Mashallah Boys Hostel Gulberg 3 near hajvery university Facilities: Wifi Internet - Free UPS Connection - Free TV cable Connection - Free Attach Bath Carpeted Room Geyser for Hot Water in winters Electric Water Cooler for Drinking -Electricity (separate sub meters installed) Room Sharing Rent 4000 (Security 5000) Full Room Rent 8000 (Security 10000) Max 2 persons allowed in a room.', 'anas', 'abc@gmail.com', 'abc.com', '03249470780', 1, 0, 0, '[\"ATM\",\"waterFilter\"]', 39, '2019-05-07 21:44:54', '2019-05-09 02:47:19'),
(15, 'Fast Hostel', 'Girls', 25, 15, '10000-15000', '370,TIP BLOCK KHAYABAN-E-AMIN,DEFENCE ROAD LAHORE 370 TIP BLOCK KHAYABAN E AMEEN LAHORE', '74.358747', '31.520370', 'Punjab', 212121, 'Lahore', 'Pakistan', 'Mairona Hotels Gulberg is located in Lahore, 28 km from Wagah Border, and offers free WiFi. Located around 1.2 km from Pace Shopping Mall, the hotel is also 2.1 km away from Lahore Gymkhana. A tour desk can provide information on the area.', 'Uzair', 'uzairsalar@gmail.com', 'www.maironahotel.com', '03218840489', 0, 0, 0, '[\"ATM\",\"attachedBathroom\",\"seprate\"]', 49, '2019-05-08 20:30:14', '2019-05-08 20:30:14'),
(17, 'Continental Hostel', 'Girls', 25, 15, '5000', '370,TIP BLOCK KHAYABAN-E-AMIN,DEFENCE ROAD LAHORE 370 TIP BLOCK KHAYABAN E AMEEN LAHORE', '74.358747', '31.520370', 'Punjab', 212121, 'Lahore', 'Pakistan', 'Mairona Hotels Gulberg is located in Lahore, 28 km from Wagah Border, and offers free WiFi. Located around 1.2 km from Pace Shopping Mall, the hotel is also 2.1 km away from Lahore Gymkhana. A tour desk can provide information on the area.', 'Umar Raza', 'umarraza@gmail.com', 'www.maironahotel.com', '03218840489', 0, 0, 0, '[\"ATM\",\"attachedBathroom\",\"seprate\"]', 52, '2019-05-09 03:04:45', '2019-05-09 03:04:45'),
(20, 'Friends Hostel', 'Boys', 20, 30, '10000-12000', '280 D block, Faisal town lahore', '31.520370', '74.358747', 'punjab', 54000, 'Lahore', 'Pakistan', 'hostel is at good location with all the fascilities.', 'Rehan', 'Rehan@gmail.com', 'friends.com', '03211234567', 0, 0, 0, '[\"24-hour reception\",\"24-hour security\",\"Air conditioning\",\"ATM\",\"BBQ area\",\"Parking area\",\"Board Games\",\"Mess\",\"TV\",\"Ceiling Fan\",\"Childrens play area\",\"Common Room\",\"Currency Exchange\",\"Direct Dial Telephone\",\"Kitchen\",\"Elevator\",\"Free Internet Access\",\"Free Parking\",\"Free WiFi\",\"Fridge/Freezer\",\"Fusball\",\"Games Room\",\"Gym\",\"Housekeeping\",\"Internet Access\",\"Iron/ironing Board\",\"Laundry Facilities\",\"Lockers\",\"Luggage Storage\",\"Microwave\",\"Outdoor Swimming Pool\",\"Outdoor Terrace\",\"Pool Table\",\"Reception (limited hours)\",\"Swimming Pool\",\"Tea & Coffee Making Facilities\",\"Vending Machines\",\"Wake-up calls\",\"Washing Machine\",\"Wheelchair Accessible\",\"Video games\",\"Transport\",\"CCTV\",\"Sports area\",\"Lawn\",\"Attached bathrooms\",\"Room service\",\"Pets allowed\",\"Guests allowed\",\"Water filter\",\"First aid\",\"Furnished\",\"Not furnished\",\"UPS\",\"Geyser\",\"Study room\",\"Medical support\",\"Ground Floor\",\"Professional cook\",\"Carpeted rooms\",\"Cupboards\",\"Daily news paper\",\"Electricity 24/7\",\"3-time meal\",\"Non- Smoking\",\"seprate\"]', 57, '2019-05-09 22:47:08', '2019-05-09 22:47:08');

-- --------------------------------------------------------

--
-- Table structure for table `mess_menu`
--

CREATE TABLE `mess_menu` (
  `id` int(10) NOT NULL,
  `day` varchar(20) NOT NULL,
  `breakFastTiming` varchar(50) NOT NULL,
  `dinnerTiming` varchar(50) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mess_menu`
--

INSERT INTO `mess_menu` (`id`, `day`, `breakFastTiming`, `dinnerTiming`, `createdAt`, `updatedAt`) VALUES
(1, 'Monday', 'Paratha, Channa, 1 cup tea	', 'Paratha, Channa, 1 cup tea	', '2019-05-08 02:21:15', '2019-05-07 22:14:38'),
(2, 'Tuesday', 'Breads, Omelet, 1 cup tea', 'Vegetable', '2019-05-08 02:21:53', '2019-05-08 02:21:53'),
(3, 'Wednesday', 'French Toasts, 1 cup tea', 'Chicken Biryani', '2019-05-08 02:21:53', '2019-05-08 02:21:53'),
(4, 'Thursday', 'Paratha, Egg-Potato, 1 cup tea', 'Daal Chicken/Daal Maash', '2019-05-08 02:22:38', '2019-05-08 02:22:38'),
(5, 'Friday', 'Paratha, Omelet, 1 cup tea', 'Vegetable Rice + Raita', '2019-05-08 02:22:38', '2019-05-08 02:22:38'),
(6, 'Saturday', 'Pratha, Channa, 1 cup tea', 'Vegetable', '2019-05-08 02:23:19', '2019-05-08 02:23:19'),
(7, 'Sunday', 'Aaloo wale parathay + Raita', 'Badami Koftay', '2019-05-08 02:23:19', '2019-05-08 02:23:19');

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
(2, '2', 16, 9, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, '3', 18, 15, '2019-05-06 05:54:08', '2019-05-06 05:54:08');

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
(1, 'Very affordable prices', 7, 34, '2019-05-07 00:29:30', '2019-05-07 00:29:30');

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
(3, 49, 1, '2019-05-08 20:30:14', '2019-05-08 20:30:14'),
(4, 34, 1, '2019-05-09 02:07:49', '2019-05-09 02:07:49'),
(5, 39, 1, '2019-05-09 02:36:12', '2019-05-09 02:36:12'),
(6, 50, 1, '2019-05-08 22:34:09', '2019-05-08 22:34:09');

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
  `state` varchar(20) NOT NULL,
  `postCode` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `country` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `contactName` varchar(50) NOT NULL,
  `contactEmail` varchar(50) NOT NULL,
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
(3, 'Continental Hostel', 'Boys', 30, 20, '15000', 'Johar Town Lahore', '74.358747', '31.520370', 'Punjab', '15253', 'Lahore', 'Pakistan', 'Mairona Hotels Gulberg is located in Lahore, 28 km from Wagah Border', 'Sikandar', 'sikandar@gmail.com', 'www.continentalhostel.com', '03034969407', '[\"ATM\",\"BBQ area\"]', 1, 13, 43, '2019-05-08 00:15:53', '2019-05-08 00:37:28');

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
(34, 'mahmoodanas4012@gmail.com', NULL, '$2y$10$iwJKoPCYPuWHGXnXvysAPO81Pav848QyK3EiwddLjtqOzzjWb2T/.', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', 4, '2019-05-09 02:08:15', '2019-05-07 00:05:00'),
(39, 'l1f14bscs0068', NULL, '$2y$10$qQ4eksvopVasJatY2OzaZul9KpkpIA.YqmPBGKn3e6mpUOmVOMXby', NULL, 2, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'English', 0, '2019-05-07 21:44:54', '2019-05-07 21:44:54'),
(49, 'uzairsalar@gmail.com', 'uzairsalar@gmail.com', '$2y$10$w5J5dS6PdH3vsOLNRndpcOFZH7pUBqnkdQco0QdPlN8Pey7SPW/Ai', NULL, 2, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', 3, '2019-05-09 05:54:22', '2019-05-08 20:30:14'),
(50, 'usman@gmail.com', NULL, '$2y$10$90jzB05LV4yLB4nVxbbHYOv249xHfzonyiSDeiOgRxLpAL6rBruLe', NULL, 3, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', 6, '2019-05-09 03:34:09', '2019-05-08 22:34:09'),
(52, 'umarraza@gmail.com', 'umarraza@gmail.com', '$2y$10$OXOrevcQvUsO38t3douf6O.JehyC3TLCH1BVCKxLxblTE5H5XpFF.', NULL, 2, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'English', NULL, '2019-05-09 03:04:45', '2019-05-09 03:04:45'),
(57, 'rehan.rehan', 'Rehan@gmail.com', '$2y$10$9Z.NhqP63wq6jpl8qxLgQO68tqYPnsItrrFlwqmbq2Af1Y4QLrG6W', NULL, 2, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, 'English', NULL, '2019-05-10 04:37:18', '2019-05-09 22:47:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(10) NOT NULL,
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
(1, 'Umar Raza', '03249470780', 'umarraza@gmail.com', 'Lahore', 'Pakistan', 'Student', 'Virtual University', '15-03-1995', 'Male', '35201-123456-7', 0, 34, '2019-05-07 00:05:00', '2019-05-07 00:05:00'),
(2, 'Usman Munir', '03034969407', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 50, '2019-05-08 22:34:09', '2019-05-08 22:34:09');

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
-- Indexes for table `mess_menu`
--
ALTER TABLE `mess_menu`
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_k1` (`roleId`);

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hostels_registration-requests`
--
ALTER TABLE `hostels_registration-requests`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hostel_images`
--
ALTER TABLE `hostel_images`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hostel_profiles`
--
ALTER TABLE `hostel_profiles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `mess_menu`
--
ALTER TABLE `mess_menu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `profile_pictures`
--
ALTER TABLE `profile_pictures`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
