-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2025 at 04:52 PM
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
-- Database: `school-bus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone_tel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `phone_tel`) VALUES
(1, 'Rusell', 9999);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendence_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT 'Type = 0 --> Check-IN | Type = 1 --> Check-OUT',
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendence_id`, `student_id`, `bus_id`, `type`, `timestamp`) VALUES
(196, 12, 3, 0, '2025-12-14 21:35:01'),
(197, 12, 3, 1, '2025-12-14 21:36:33'),
(198, 12, 3, 0, '2025-12-14 21:36:37'),
(199, 12, 3, 0, '2025-12-14 21:37:14'),
(200, 12, 3, 1, '2025-12-14 21:37:39'),
(201, 12, 3, 0, '2025-12-14 21:37:42'),
(202, 12, 3, 0, '2025-12-14 21:40:01'),
(203, 12, 3, 1, '2025-12-14 21:41:47'),
(204, 12, 3, 0, '2025-12-14 21:41:51'),
(205, 12, 3, 0, '2025-12-14 21:43:53'),
(206, 12, 3, 1, '2025-12-14 21:44:27'),
(207, 12, 3, 0, '2025-12-14 21:44:30'),
(208, 13, 3, 0, '2025-12-14 21:45:25'),
(209, 15, 3, 0, '2025-12-14 23:13:33'),
(210, 13, 3, 1, '2025-12-14 23:26:54'),
(211, 13, 3, 0, '2025-12-14 23:26:58'),
(212, 13, 3, 0, '2025-12-14 23:27:23'),
(213, 13, 3, 1, '2025-12-14 23:27:41'),
(214, 13, 3, 0, '2025-12-14 23:27:45'),
(215, 13, 3, 0, '2025-12-15 00:02:01'),
(216, 13, 3, 1, '2025-12-15 00:02:23'),
(217, 13, 3, 0, '2025-12-15 00:02:26'),
(218, 12, 3, 0, '2025-12-15 00:02:51'),
(219, 13, 3, 0, '2025-12-15 00:03:24'),
(220, 13, 3, 1, '2025-12-15 00:20:13'),
(221, 13, 3, 0, '2025-12-15 00:20:16'),
(222, 13, 3, 0, '2025-12-15 00:20:41'),
(223, 13, 3, 1, '2025-12-15 00:21:04'),
(224, 13, 3, 0, '2025-12-15 00:21:07'),
(225, 13, 3, 0, '2025-12-15 00:31:19'),
(226, 13, 3, 0, '2025-12-15 00:31:53'),
(227, 15, 3, 0, '2025-12-15 00:32:25'),
(228, 13, 3, 0, '2025-12-15 00:32:57'),
(229, 13, 3, 0, '2025-12-15 00:33:23'),
(230, 13, 3, 0, '2025-12-15 00:35:01'),
(231, 13, 3, 1, '2025-12-15 00:35:27'),
(232, 13, 3, 0, '2025-12-15 00:35:30'),
(233, 13, 3, 0, '2025-12-15 00:35:55'),
(234, 13, 3, 1, '2025-12-15 00:36:21'),
(235, 13, 3, 0, '2025-12-15 00:36:24'),
(236, 13, 3, 0, '2025-12-15 00:36:58'),
(237, 13, 3, 1, '2025-12-15 00:38:10'),
(238, 13, 3, 0, '2025-12-15 00:38:13'),
(239, 13, 3, 1, '2025-12-15 00:40:42'),
(240, 13, 3, 0, '2025-12-15 00:40:45'),
(241, 13, 3, 1, '2025-12-15 00:41:48'),
(242, 13, 3, 0, '2025-12-15 00:41:51'),
(243, 13, 3, 0, '2025-12-15 00:42:17'),
(244, 13, 3, 1, '2025-12-15 00:42:32'),
(245, 13, 3, 0, '2025-12-15 00:42:35'),
(246, 13, 3, 0, '2025-12-15 00:42:56'),
(247, 13, 3, 1, '2025-12-15 00:43:10'),
(248, 13, 3, 0, '2025-12-15 00:43:13'),
(249, 13, 3, 0, '2025-12-15 00:43:30'),
(250, 13, 3, 1, '2025-12-15 00:43:49'),
(251, 13, 3, 0, '2025-12-15 00:43:52'),
(252, 13, 3, 0, '2025-12-15 00:44:10'),
(253, 13, 3, 1, '2025-12-15 00:44:26'),
(254, 13, 3, 0, '2025-12-15 00:44:29'),
(255, 13, 3, 0, '2025-12-15 00:50:49'),
(256, 13, 3, 0, '2025-12-15 00:54:35'),
(257, 13, 3, 0, '2025-12-15 00:59:21'),
(258, 13, 3, 1, '2025-12-15 00:59:37'),
(259, 13, 3, 0, '2025-12-15 00:59:40'),
(260, 13, 3, 0, '2025-12-15 01:00:10'),
(261, 13, 3, 1, '2025-12-15 01:00:25'),
(262, 13, 3, 0, '2025-12-15 01:00:28'),
(263, 13, 3, 0, '2025-12-15 01:00:46'),
(264, 13, 3, 1, '2025-12-15 01:01:07'),
(265, 13, 3, 0, '2025-12-15 01:01:11'),
(266, 13, 3, 0, '2025-12-15 01:01:28'),
(267, 13, 3, 1, '2025-12-15 01:01:42'),
(268, 13, 3, 0, '2025-12-15 01:01:45'),
(269, 13, 3, 0, '2025-12-15 01:04:31'),
(270, 13, 3, 1, '2025-12-15 01:04:53'),
(271, 13, 3, 0, '2025-12-15 01:04:57'),
(272, 9, 3, 0, '2025-12-15 01:06:43'),
(273, 9, 3, 1, '2025-12-15 01:08:56'),
(274, 9, 3, 0, '2025-12-15 01:08:59'),
(275, 9, 3, 0, '2025-12-15 01:09:24'),
(276, 13, 3, 0, '2025-12-15 01:09:56'),
(277, 13, 3, 1, '2025-12-15 01:10:16'),
(278, 13, 3, 0, '2025-12-15 01:10:20'),
(279, 9, 3, 1, '2025-12-15 01:10:40'),
(280, 9, 3, 0, '2025-12-15 01:10:43'),
(281, 12, 3, 1, '2025-12-15 01:14:38'),
(282, 13, 3, 0, '2025-12-15 01:16:04'),
(283, 9, 3, 0, '2025-12-15 01:16:37'),
(284, 9, 3, 1, '2025-12-15 01:16:56'),
(285, 9, 3, 0, '2025-12-15 01:16:59'),
(286, 9, 3, 0, '2025-12-15 01:17:31'),
(287, 9, 3, 1, '2025-12-15 01:21:43'),
(288, 9, 3, 0, '2025-12-15 01:21:46'),
(289, 9, 3, 0, '2025-12-15 01:22:12'),
(290, 9, 3, 1, '2025-12-15 01:22:34'),
(291, 9, 3, 0, '2025-12-15 01:22:37'),
(292, 9, 3, 0, '2025-12-15 01:23:43'),
(293, 9, 3, 1, '2025-12-15 01:24:04'),
(294, 9, 3, 0, '2025-12-15 01:24:07'),
(295, 9, 3, 0, '2025-12-15 01:24:31'),
(296, 9, 3, 1, '2025-12-15 01:24:51'),
(297, 9, 3, 0, '2025-12-15 01:24:54'),
(298, 9, 3, 0, '2025-12-15 01:25:20'),
(299, 9, 3, 1, '2025-12-15 01:25:47'),
(300, 9, 3, 0, '2025-12-15 01:25:50'),
(301, 9, 3, 0, '2025-12-15 01:26:15'),
(302, 9, 3, 1, '2025-12-15 01:26:41'),
(303, 9, 3, 0, '2025-12-15 01:26:43'),
(304, 9, 3, 0, '2025-12-15 01:27:09'),
(305, 9, 3, 1, '2025-12-15 01:36:32'),
(306, 13, 3, 1, '2025-12-15 01:36:32'),
(307, 13, 3, 0, '2025-12-15 01:38:09'),
(308, 9, 3, 0, '2025-12-15 01:39:13'),
(309, 9, 3, 1, '2025-12-15 01:41:38'),
(310, 9, 3, 0, '2025-12-15 01:41:41'),
(311, 13, 3, 1, '2025-12-15 01:42:04'),
(312, 13, 3, 0, '2025-12-15 01:42:07'),
(313, 15, 3, 0, '2025-12-15 01:42:32'),
(314, 13, 3, 0, '2025-12-15 01:43:05'),
(315, 15, 3, 1, '2025-12-15 02:33:04'),
(316, 13, 3, 1, '2025-12-15 02:33:04'),
(317, 11, 3, 1, '2025-12-15 12:55:22'),
(318, 4, 3, 0, '2025-12-15 14:32:16'),
(319, 4, 3, 1, '2025-12-15 14:32:29'),
(320, 12, 3, 0, '2025-12-15 15:00:05'),
(321, 13, 3, 0, '2025-12-15 15:03:22'),
(322, 12, 3, 1, '2025-12-15 15:03:45'),
(323, 12, 3, 0, '2025-12-15 15:03:48'),
(324, 13, 3, 1, '2025-12-17 18:10:25');

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

CREATE TABLE `bus` (
  `bus_id` int(11) NOT NULL,
  `bus_driver_name` varchar(50) NOT NULL,
  `bus_model` varchar(50) NOT NULL,
  `bus_capacity` int(11) NOT NULL,
  `trip_status` int(11) NOT NULL DEFAULT 0 COMMENT 'TRIP Started = 1 , TRIP NOT STARTED = 0 ',
  `student_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Student SET for python. easier way to handle data for active student in the bus!' CHECK (json_valid(`student_list`)),
  `google_map` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus`
--

INSERT INTO `bus` (`bus_id`, `bus_driver_name`, `bus_model`, `bus_capacity`, `trip_status`, `student_list`, `google_map`) VALUES
(1, 'mohammed farook', 'Bus1', 17, 0, '[]', NULL),
(2, 'Salim mahroooqi', 'yaris van', 21, 0, '[]', NULL),
(3, 'Pink Panther', 'Cartoon School bus', 5, 0, '[]', 'https://www.google.com/maps/search/?api=1&query=0.0,0.0'),
(9, 'Sb', 'Sara bus', 3, 0, '[]', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE `parent` (
  `parent_id` int(11) NOT NULL,
  `parent_name` varchar(50) NOT NULL,
  `parent_tel` varchar(100) NOT NULL,
  `parent_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parent`
--

INSERT INTO `parent` (`parent_id`, `parent_name`, `parent_tel`, `parent_email`) VALUES
(3, 'Sulaiman', '', ''),
(5, 'Basim', '', ''),
(6, 'Salim', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `student_bus_id` int(11) NOT NULL,
  `student_name` varchar(50) NOT NULL,
  `student_rfid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `parent_id`, `student_bus_id`, `student_name`, `student_rfid`) VALUES
(4, 5, 3, 'Mohammed', '222814543110'),
(8, 3, 1, 'Nooh', '740021306198'),
(9, 3, 1, 'Saeed', '95071503235'),
(10, 3, 1, 'Muzn', '1000839840600'),
(11, 3, 3, 'Fahad', '280258347953'),
(12, 6, 3, 'Huda', '801727775648'),
(13, 6, 3, 'Hood', '802516370388'),
(14, 3, 1, 'Salim', '442175259429'),
(15, 5, 3, 'Tariq', '1076605682656'),
(16, 3, 1, 'Leen', '949652620144'),
(17, 3, 1, 'Sara', '228668474303');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` enum('parent','driver','admin') NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `bus_id` int(11) DEFAULT NULL,
  `last_login_timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `username`, `password`, `usertype`, `parent_id`, `admin_id`, `bus_id`, `last_login_timestamp`) VALUES
(1, 'sulaiman', 'test123', 'parent', 3, NULL, NULL, '2025-12-07 18:52:46'),
(2, 'basim', 'basim', 'driver', NULL, NULL, 1, '2025-12-07 20:09:32'),
(5, 'admin', 'adminXXX', 'admin', NULL, 1, NULL, '2025-12-10 15:02:26'),
(6, 'pink', '1111', 'driver', NULL, NULL, 3, '2025-12-13 00:24:12'),
(7, 'basim2', 'basim2', 'parent', 5, NULL, NULL, '2025-12-13 19:26:58'),
(9, 'salim2', 'salim2', 'parent', 6, NULL, NULL, '2025-12-15 13:54:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendence_id`),
  ADD KEY `Bus_ID Relation` (`bus_id`),
  ADD KEY `Student_ID Relation` (`student_id`);

--
-- Indexes for table `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`bus_id`);

--
-- Indexes for table `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`parent_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `student_rfid` (`student_rfid`),
  ADD KEY `Parent ID Relation` (`parent_id`),
  ADD KEY `student_bus_id` (`student_bus_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_user_parent` (`parent_id`),
  ADD KEY `fk_user_admin` (`admin_id`),
  ADD KEY `fk_user_bus` (`bus_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendence_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=325;

--
-- AUTO_INCREMENT for table `bus`
--
ALTER TABLE `bus`
  MODIFY `bus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `parent`
--
ALTER TABLE `parent`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `Bus_ID Relation` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`bus_id`),
  ADD CONSTRAINT `Student_ID Relation` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `Parent ID Relation` FOREIGN KEY (`parent_id`) REFERENCES `parent` (`parent_id`),
  ADD CONSTRAINT `Student_BUS_ID` FOREIGN KEY (`student_bus_id`) REFERENCES `bus` (`bus_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_admin` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`),
  ADD CONSTRAINT `fk_user_bus` FOREIGN KEY (`bus_id`) REFERENCES `bus` (`bus_id`),
  ADD CONSTRAINT `fk_user_parent` FOREIGN KEY (`parent_id`) REFERENCES `parent` (`parent_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
