-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2026 at 09:35 AM
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
-- Database: `assumption_db`
--

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
(6, 'Melca Abogado', 'Intern', 'ICT', '2026-03-19', 'Marnie Rabutin', 'Teacher', '03', 'January', '2026', 'ETHEL', '2026-02-28 17:55:03', 'JOSILYN S. SOLANA EdD, CESO V', 'Schools Division Superintendent', 'Head', 'Administrative Officer IV (HRMO II)'),
(10, 'Mica Abogado', 'Head Teacher', 'ICT Office', '2026-03-02', 'Kristel Sala', 'Teacher', '3', 'February', '2026', 'ETHEL S. ACUÑA', '2026-03-02 05:54:53', ' ', ' ', ' ', 'Administrative Officer IV (HRMO II)'),
(11, '1', '2', '3', '2026-03-17', '4', '5', '6', '7', '8', '12', '2026-03-02 18:15:20', ' 9', ' 10', ' 11', '13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assumption_records`
--
ALTER TABLE `assumption_records`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assumption_records`
--
ALTER TABLE `assumption_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
