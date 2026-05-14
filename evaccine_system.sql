-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2025 at 05:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evaccine_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `vaccine_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `status` enum('Pending Approval','Approved','Rejected','Completed','Missed') NOT NULL DEFAULT 'Pending Approval',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `child_id`, `parent_id`, `hospital_id`, `vaccine_id`, `appointment_date`, `status`, `notes`, `created_at`) VALUES
(1, 1, 4, 1, 2, '2025-06-14', 'Completed', NULL, '2025-06-14 05:50:19'),
(2, 2, 4, 1, 3, '2025-06-15', 'Completed', NULL, '2025-06-14 05:50:38'),
(3, 2, 4, 1, 5, '2025-06-15', 'Completed', NULL, '2025-06-14 11:18:24'),
(4, 1, 4, 1, 5, '2025-06-15', 'Completed', NULL, '2025-06-15 10:23:12'),
(5, 2, 4, 1, 2, '2025-06-16', 'Completed', NULL, '2025-06-15 10:45:52');

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

CREATE TABLE `children` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`id`, `parent_id`, `full_name`, `date_of_birth`, `gender`, `created_at`) VALUES
(1, 4, 'Ahmad', '2025-06-14', 'Male', '2025-06-14 04:46:40'),
(2, 4, 'ali', '2025-06-13', 'Male', '2025-06-14 04:46:56');

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `location_details` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`id`, `user_id`, `name`, `address`, `location_details`, `created_at`) VALUES
(1, 3, 'alkhidmat', 'c35 phase extention', NULL, '2025-06-14 04:45:26'),
(2, 5, 'Aga Khan University Hospital', 'Stadium Road, Karachi', NULL, '2025-06-17 05:33:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','parent','hospital') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin123', 'admin', '2025-06-14 04:41:37'),
(3, 'alkhidmat', 'alkhidmat@gmail.com', 'alkhidmat', 'hospital', '2025-06-14 04:45:26'),
(4, 'abdulsattar', 'abdulsattar@gmail.com', 'abdulsattar', 'parent', '2025-06-14 04:45:56'),
(5, 'Aga Khan University Hospital', 'info@aku.edu', 'abdulsattar', 'hospital', '2025-06-17 05:33:01'),
(6, 'Ahmed Ali', 'ahmed.ali@email.com', 'Ahmed Ali', 'parent', '2025-06-17 05:34:06');

-- --------------------------------------------------------

--
-- Table structure for table `vaccines`
--

CREATE TABLE `vaccines` (
  `id` int(11) NOT NULL,
  `vaccine_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `recommended_age_months` int(3) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccines`
--

INSERT INTO `vaccines` (`id`, `vaccine_name`, `description`, `recommended_age_months`, `is_available`) VALUES
(1, 'BCG', 'Bacillus Calmette-Guerin vaccine for Tuberculosis', 0, 1),
(2, 'Polio (OPV 0)', 'Oral Polio Vaccine - Birth Dose', 0, 1),
(3, 'Hepatitis B (Hep-B 1)', 'Hepatitis B Vaccine - First Dose', 1, 1),
(4, 'DTwP / DTaP 1', 'Diphtheria, Tetanus, and Pertussis vaccine - First Dose', 2, 1),
(5, 'MMR-1', 'Measles, Mumps, and Rubella vaccine - First Dose', 9, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `child_id` (`child_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `hospital_id` (`hospital_id`),
  ADD KEY `vaccine_id` (`vaccine_id`);

--
-- Indexes for table `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vaccines`
--
ALTER TABLE `vaccines`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `children`
--
ALTER TABLE `children`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vaccines`
--
ALTER TABLE `vaccines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`hospital_id`) REFERENCES `hospitals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_4` FOREIGN KEY (`vaccine_id`) REFERENCES `vaccines` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `children`
--
ALTER TABLE `children`
  ADD CONSTRAINT `children_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD CONSTRAINT `hospitals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
