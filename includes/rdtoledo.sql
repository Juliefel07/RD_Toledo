-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2026 at 04:36 AM
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
-- Database: `rdtoledo`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `window_no` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `queue_id` int(11) NOT NULL,
  `queue_number` varchar(20) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `service_id` int(11) NOT NULL,
  `window_no` int(11) DEFAULT NULL,
  `status` enum('Waiting','Serving','Payment','Completed','Cancelled') DEFAULT 'Waiting',
  `called_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_by` int(11) DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `senior_citizen` varchar(50) NOT NULL DEFAULT 'No',
  `cancelled_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`queue_id`, `queue_number`, `client_name`, `service_id`, `window_no`, `status`, `called_at`, `created_at`, `completed_by`, `completed_at`, `senior_citizen`, `cancelled_at`) VALUES
(99, 'Q026', 'Juliefel Malusay', 2, 1, 'Completed', '2026-07-29 14:38:02', '2026-07-29 14:37:33', 2, '2026-07-29 22:44:50', 'No', NULL),
(100, 'Q027', 'Hellow', 1, 1, 'Completed', '2026-07-29 14:41:55', '2026-07-29 14:41:45', 2, '2026-07-29 22:44:51', 'No', NULL),
(101, 'Q028', 'Julia Montes', 2, 4, 'Serving', '2026-07-29 14:45:09', '2026-07-29 14:42:33', NULL, NULL, 'No', NULL),
(102, 'Q029', 'Kim', 3, 1, 'Completed', '2026-07-29 14:49:56', '2026-07-29 14:48:59', 2, '2026-07-29 23:03:15', 'No', NULL),
(103, 'Q030', 'Justine Bieber', 1, 1, '', '2026-07-29 14:50:59', '2026-07-29 14:50:25', NULL, '2026-07-29 23:03:18', 'No', NULL),
(104, 'Q031', 'Daniel Padilla', 3, 1, '', '2026-07-29 14:54:54', '2026-07-29 14:50:36', NULL, '2026-07-29 23:03:20', 'No', NULL),
(105, 'Q032', 'Kim Cyril Balug', 6, 1, '', '2026-07-29 14:52:25', '2026-07-29 14:50:49', NULL, '2026-07-29 23:03:22', 'No', NULL),
(106, 'Q033', 'HEEEEY', 1, 1, 'Completed', '2026-07-29 14:55:56', '2026-07-29 14:55:50', 2, '2026-07-29 23:03:25', 'No', NULL),
(107, 'Q034', 'UYY', 1, 1, 'Completed', '2026-07-29 15:03:13', '2026-07-29 15:00:04', 2, '2026-07-29 23:03:26', 'No', NULL),
(108, 'Q035', 'YO', 1, 1, 'Serving', '2026-07-29 15:03:54', '2026-07-29 15:03:48', NULL, NULL, 'No', NULL),
(109, 'Q036', 'Juliefel Malusay', 6, 4, 'Serving', '2026-07-29 15:05:52', '2026-07-29 15:05:04', NULL, NULL, 'No', NULL),
(110, 'Q037', 'Ira Mariz', 2, 1, 'Serving', '2026-07-30 02:20:21', '2026-07-30 02:19:48', NULL, NULL, 'No', NULL),
(111, 'Q038', 'Juliefel Malusay', 3, 1, 'Serving', '2026-07-30 02:21:04', '2026-07-30 02:21:00', NULL, NULL, 'No', NULL),
(112, 'Q039', 'Ivana Alawi', 5, 1, 'Serving', '2026-07-30 02:21:59', '2026-07-30 02:21:52', NULL, NULL, 'No', NULL),
(113, 'Q040', 'Juliefel Malusay', 3, 1, 'Serving', '2026-07-30 02:24:03', '2026-07-30 02:23:56', NULL, NULL, 'No', NULL),
(114, 'Q041', 'Anjenneth Alcontin', 5, 2, '', '2026-07-30 02:27:06', '2026-07-30 02:26:52', NULL, '2026-07-30 10:28:01', 'No', NULL),
(115, 'Q042', 'Ken Andrie Quisido', 6, 2, '', '2026-07-30 02:27:44', '2026-07-30 02:27:37', NULL, '2026-07-30 10:28:13', 'No', NULL),
(116, 'Q043', 'Ira Mariz', 3, 2, 'Completed', '2026-07-30 02:28:52', '2026-07-30 02:28:38', 3, '2026-07-30 10:28:58', 'No', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `status`, `created_at`) VALUES
(1, 'RIO / Inquiry', 'Active', '2026-07-21 15:38:48'),
(2, 'Entry', 'Active', '2026-07-21 15:38:48'),
(3, 'Releasing', 'Active', '2026-07-21 15:38:48'),
(5, 'Payment', 'Active', '2026-07-27 13:31:54'),
(6, 'Certified True Copy / Certification', 'Active', '2026-07-27 13:31:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `window_no` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `username`, `password`, `window_no`, `created_at`) VALUES
(2, 'Admin 1', 'admin1', 'admin1rd', 1, '2026-07-26 15:36:06'),
(3, 'Admin 2', 'admin2', 'admin2rd', 2, '2026-07-26 15:36:06'),
(4, 'Admin 3', 'admin3', 'admin3rd', 3, '2026-07-26 15:36:06'),
(5, 'Cashier', 'admin4', 'admin4rd', 4, '2026-07-29 08:00:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`queue_id`),
  ADD KEY `fk_queue_service` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `queue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `queue`
--
ALTER TABLE `queue`
  ADD CONSTRAINT `fk_queue_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
