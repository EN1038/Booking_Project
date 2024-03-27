-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2024 at 06:08 AM
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
-- Database: `booking_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `workTime_id` varchar(255) NOT NULL,
  `status_book` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `workTime_id`, `status_book`, `created_at`, `updated_at`) VALUES
(3, '4', 'รอการยืนยันการจอง', '2024-03-26 11:03:35', '2024-03-26 11:03:35'),
(4, '5', 'รอการยืนยันการจอง', '2024-03-26 11:04:40', '2024-03-26 11:04:40');

-- --------------------------------------------------------

--
-- Table structure for table `book_details`
--

CREATE TABLE `book_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_details`
--

INSERT INTO `book_details` (`id`, `user_id`, `booking_id`, `created_at`, `updated_at`) VALUES
(7, '3', 4, '2024-03-26 11:04:40', '2024-03-26 11:04:40'),
(8, '4', 4, '2024-03-26 11:04:40', '2024-03-26 11:04:40');

-- --------------------------------------------------------

--
-- Table structure for table `levelusers`
--

CREATE TABLE `levelusers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_user` varchar(255) NOT NULL,
  `passWordNumber_user` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `level_user` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `levelusers`
--

INSERT INTO `levelusers` (`id`, `name_user`, `passWordNumber_user`, `email`, `level_user`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '63113532008Admin', 'Admin@example.com', 'admin', '$2y$12$pq3xbO7ftPkCCPDeT5lCbOLokbLtJJ1E9lSWn9LD2tsfUNNJ6XLaW', '2024-03-26 09:40:30', '2024-03-26 09:40:30'),
(2, 'กระเพราทดลอง', '63113532008User', 'User@example.com', 'user', '$2y$12$slDkP0eiZecnl4J1s2TbmeFZ.6KcxVVX2JLgdeFpHODrs0IGO0m.K', '2024-03-26 09:40:42', '2024-03-26 09:40:42'),
(3, 'Users', '63113532008', 'Usesr@example.com', 'user', '$2y$12$flgbCNHxPvroClt5O9mXveQjmw2nsL5Z7kyYHv8Wk0I7SxsIgqXR6', '2024-03-26 11:04:00', '2024-03-26 11:04:00'),
(4, 'กระเพราทดลอง', '63113532007', 'Usexr@example.com', 'user', '$2y$12$630//PlMc0wIpwqk5xk5h.cvfDGVWQsMBdgXjNIkq8mJDT15BijCq', '2024-03-26 11:04:19', '2024-03-26 11:04:19');

-- --------------------------------------------------------

--
-- Table structure for table `list_rooms`
--

CREATE TABLE `list_rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_room` varchar(255) NOT NULL,
  `status_room` varchar(255) NOT NULL,
  `id_type_room` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `list_rooms`
--

INSERT INTO `list_rooms` (`id`, `name_room`, `status_room`, `id_type_room`, `created_at`, `updated_at`) VALUES
(1, 'นกบิน', 'On', 1, '2024-03-26 09:41:43', '2024-03-26 09:41:43'),
(2, 'นกใหญ่', 'On', 2, '2024-03-26 09:41:51', '2024-03-26 09:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(22, '2024_03_11_150709_create_rooms_table', 1),
(46, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(47, '2024_03_09_055309_create_type_rooms_table', 2),
(48, '2024_03_12_015832_create_list_rooms_table', 2),
(49, '2024_03_12_151432_create_levelusers_table', 2),
(50, '2024_03_23_072231_create_work_times_table', 2),
(51, '2024_03_23_072418_create_bookings_table', 2),
(52, '2024_03_23_072550_create_book_details_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `type_rooms`
--

CREATE TABLE `type_rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_type` varchar(255) NOT NULL,
  `time_duration` time NOT NULL,
  `number_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `type_rooms`
--

INSERT INTO `type_rooms` (`id`, `name_type`, `time_duration`, `number_user`, `created_at`, `updated_at`) VALUES
(1, 'ดูหนัง', '03:30:00', 4, '2024-03-26 09:41:10', '2024-03-26 09:41:10'),
(2, 'ร้องเพลง', '01:30:00', 2, '2024-03-26 09:41:23', '2024-03-26 09:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `work_times`
--

CREATE TABLE `work_times` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_start_workTime` time NOT NULL,
  `name_end_workTime` time NOT NULL,
  `id_room` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_times`
--

INSERT INTO `work_times` (`id`, `name_start_workTime`, `name_end_workTime`, `id_room`, `created_at`, `updated_at`) VALUES
(1, '08:30:00', '11:59:00', '1', '2024-03-26 09:41:43', '2024-03-26 09:41:43'),
(2, '12:00:00', '15:29:00', '1', '2024-03-26 09:41:43', '2024-03-26 09:41:43'),
(3, '15:30:00', '16:30:00', '1', '2024-03-26 09:41:43', '2024-03-26 09:41:43'),
(4, '08:30:00', '09:59:00', '2', '2024-03-26 09:41:51', '2024-03-26 09:41:51'),
(5, '10:00:00', '11:29:00', '2', '2024-03-26 09:41:51', '2024-03-26 09:41:51'),
(6, '11:30:00', '12:59:00', '2', '2024-03-26 09:41:51', '2024-03-26 09:41:51'),
(7, '13:00:00', '14:29:00', '2', '2024-03-26 09:41:51', '2024-03-26 09:41:51'),
(8, '14:30:00', '15:59:00', '2', '2024-03-26 09:41:51', '2024-03-26 09:41:51'),
(9, '16:00:00', '16:30:00', '2', '2024-03-26 09:41:51', '2024-03-26 09:41:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_details`
--
ALTER TABLE `book_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levelusers`
--
ALTER TABLE `levelusers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_rooms`
--
ALTER TABLE `list_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `type_rooms`
--
ALTER TABLE `type_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_times`
--
ALTER TABLE `work_times`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `book_details`
--
ALTER TABLE `book_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `levelusers`
--
ALTER TABLE `levelusers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `list_rooms`
--
ALTER TABLE `list_rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `type_rooms`
--
ALTER TABLE `type_rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `work_times`
--
ALTER TABLE `work_times`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
