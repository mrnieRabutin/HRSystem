-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2026 at 08:18 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deped_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `sg` varchar(50) NOT NULL,
  `status` varchar(100) NOT NULL,
  `office` varchar(255) NOT NULL,
  `salary_words` varchar(255) NOT NULL,
  `salary_amount` varchar(100) NOT NULL,
  `nature` varchar(255) NOT NULL,
  `vice_name` varchar(255) NOT NULL,
  `vice_status` varchar(255) NOT NULL,
  `plantilla` varchar(255) NOT NULL,
  `page_no` varchar(50) NOT NULL,
  `date_signing` date NOT NULL,
  `authorized_official` varchar(255) NOT NULL,
  `csc_date` date NOT NULL,
  `published_at` varchar(255) NOT NULL,
  `published_from` date NOT NULL,
  `published_to` date NOT NULL,
  `posted_from` date NOT NULL,
  `posted_to` date NOT NULL,
  `hrmpsb_start` date NOT NULL,
  `deliberation_date` date NOT NULL,
  `ack_date` date NOT NULL,
  `appointee` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `control_no` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `fullname`, `address`, `position`, `sg`, `status`, `office`, `salary_words`, `salary_amount`, `nature`, `vice_name`, `vice_status`, `plantilla`, `page_no`, `date_signing`, `authorized_official`, `csc_date`, `published_at`, `published_from`, `published_to`, `posted_from`, `posted_to`, `hrmpsb_start`, `deliberation_date`, `ack_date`, `appointee`, `created_at`, `control_no`) VALUES
(319, 'marnie mitaran', 'San Isidro Tomas Oppus So. Leyte', 'teacher 1', '11', 'Permanent', 'ICT Unit', 'Twenty Thousand Pesos', '9000', 'Original', 'Maria Santos', 'Retired', 'OSEC', '6', '2026-03-21', 'Maria Santos', '2026-03-18', 'DepEd Bulletin', '2026-03-24', '2026-03-16', '2026-03-26', '2026-03-26', '2026-03-19', '2026-03-18', '2026-03-17', 'Juan Dela Cruz', '2026-03-03 05:22:29', '');

-- --------------------------------------------------------

--
-- Table structure for table `assumption_records`
--

CREATE TABLE `assumption_records` (
  `id` int(11) NOT NULL,
  `fullname` varchar(150) DEFAULT NULL,
  `position` varchar(150) DEFAULT NULL,
  `office` varchar(150) DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `appointment_name` varchar(150) DEFAULT NULL,
  `appointment_position` varchar(150) DEFAULT NULL,
  `day_signed` varchar(10) DEFAULT NULL,
  `month_signed` varchar(20) DEFAULT NULL,
  `year_signed` varchar(10) DEFAULT NULL,
  `hrmo_name` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sig_name` varchar(255) DEFAULT NULL,
  `sig_rank` varchar(255) DEFAULT NULL,
  `sig_place` varchar(255) DEFAULT NULL,
  `hrmo_rank` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assumption_records`
--

INSERT INTO `assumption_records` (`id`, `fullname`, `position`, `office`, `effective_date`, `appointment_name`, `appointment_position`, `day_signed`, `month_signed`, `year_signed`, `hrmo_name`, `created_at`, `sig_name`, `sig_rank`, `sig_place`, `hrmo_rank`) VALUES
(6, 'Melca Abogado', 'Intern', 'ICT', '2026-03-19', 'Marnie Rabutin', 'Teacher', '03', 'March', '2026', 'ETHEL', '2026-02-28 17:55:03', 'JOSILYN S. SOLANA EdD, CESO V', 'Schools Division Superintendent', 'Head', 'Administrative Officer IV (HRMO II)'),
(10, 'Mica Abogado', 'Head Teacher', 'ICT Office', '2026-03-02', 'Kristel Sala', 'Teacher', '3', 'January', '2026', 'ETHEL S. ACUÑA', '2026-03-02 05:54:53', ' ', ' ', ' 11', 'Administrative Officer IV (HRMO II)');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500'),
(2, 'admin', '00670d8995b7d9cbb26df3d8e9154f2d');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assumption_records`
--
ALTER TABLE `assumption_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=320;

--
-- AUTO_INCREMENT for table `assumption_records`
--
ALTER TABLE `assumption_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
