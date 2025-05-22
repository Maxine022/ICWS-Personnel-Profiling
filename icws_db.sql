-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2025 at 09:54 AM
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
-- Database: `icws_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `coc`
--

CREATE TABLE `coc` (
  `certificatecomp_id` int(5) NOT NULL,
  `jo_id` int(5) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `date_usage` date DEFAULT NULL,
  `ActJust` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `earned_hours` int(11) NOT NULL,
  `used_hours` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contractservice_record`
--

CREATE TABLE `contractservice_record` (
  `serviceRecord_id` int(5) NOT NULL,
  `contractservice_id` int(5) NOT NULL,
  `yearService` int(5) NOT NULL,
  `contractStart` date NOT NULL,
  `contractEnd` date NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contract_service`
--

CREATE TABLE `contract_service` (
  `contractservice_id` int(5) NOT NULL,
  `personnel_id` int(5) DEFAULT NULL,
  `salaryRate` int(5) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contract_service`
--

INSERT INTO `contract_service` (`contractservice_id`, `personnel_id`, `salaryRate`, `createdAt`, `updatedAt`) VALUES
(1, 231, 22050, '2025-05-22 07:53:55', '2025-05-22 07:53:55'),
(2, 232, 0, '2025-05-22 07:53:37', '2025-05-22 07:53:37'),
(3, 233, 501, '2025-05-22 07:53:37', '2025-05-22 07:53:37');

-- --------------------------------------------------------

--
-- Table structure for table `intern`
--

CREATE TABLE `intern` (
  `intern_id` int(5) NOT NULL,
  `fullName` varchar(255) DEFAULT NULL,
  `contactNo` bigint(11) DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `hoursNo` int(4) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `division` varchar(100) DEFAULT NULL,
  `supervisorName` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `intern`
--

INSERT INTO `intern` (`intern_id`, `fullName`, `contactNo`, `school`, `course`, `hoursNo`, `startDate`, `endDate`, `division`, `supervisorName`, `createdAt`, `updatedAt`) VALUES
(1, 'Baraquel, Jielven Rose B.', 9361796032, 'Mindanao State University - Iligan Institute of Technology', 'BS Information Technology', 490, '2025-02-11', '2025-05-23', 'Administrative and Planning Division', 'John Ryan Dela Cruz', '2025-05-09 07:53:10', '2025-05-15 08:42:24'),
(2, 'Lesondra, Maxine Joyce M.', 9476461569, 'Mindanao State University - Iligan Institute of Technology', 'BS Information Technology', 490, '2025-02-11', '2025-05-20', 'Administrative and Planning Division', 'John Ryan Dela Cruz', '2025-05-15 02:52:12', '2025-05-16 02:01:34'),
(3, 'Baldovi, Britzil P. ', 9318196307, 'Mindanao State University - Iligan Institute of Technology', 'BS Information Technology', 490, '2025-02-18', '2025-05-27', 'Administrative and Planning Division', 'John Ryan Dela Cruz', '2025-05-15 02:54:21', '2025-05-15 08:41:42'),
(4, 'Ancog, Thea A.', 9056042107, 'Mindanao State University - Iligan Institute of Technology', 'BS Information Technology', 490, '2025-02-11', '2025-02-26', 'Administrative and Planning Division', 'John Ryan Dela Cruz', '2025-05-15 02:59:45', '2025-05-20 01:11:14'),
(5, 'Loberanes, Danny Boy Jr. L.', 9951371229, 'Mindanao State University - Iligan Institute of Technology', 'BS Information Technology', 490, '2025-02-11', '2025-05-27', 'Administrative and Planning Division', 'John Ryan Dela Cruz', '2025-05-15 03:00:22', '2025-05-15 08:42:05'),
(6, 'Amer, Rohaifah G.', 0, '', '', 160, '2025-05-07', '2025-06-04', 'Customer Services Division', 'Loubelle Rubio', '2025-05-15 03:08:24', '2025-05-16 02:01:52'),
(7, 'Cali, Jyacinth Jude P. ', 0, '', '', 160, '2025-05-07', '2025-06-04', 'Waterworks Planning and Engineering Division', 'Jaime Sato', '2025-05-15 08:39:01', '2025-05-16 02:00:49'),
(8, 'Doagon, Mark Henry M.', 0, '', '', 160, '2025-04-09', '2025-06-04', 'Operation Division', 'Jaime Sato', '2025-05-16 02:00:34', '2025-05-16 07:26:32'),
(9, 'Malik, Abdulhassib A.', 0, '', '', 160, '2025-05-07', '2025-06-04', 'Customer Services Division', 'None', '2025-05-16 02:34:43', '2025-05-16 02:38:45'),
(10, 'Megalbio, John Lenon B.', 0, '', '', 160, '2025-05-07', '2025-06-04', 'Customer Services Division', 'None', '2025-05-16 02:38:28', '2025-05-16 02:38:57'),
(11, 'Noval, Alyzsa Kim B.', 0, '', '', 160, '2025-05-07', '2025-06-04', 'Customer Services Division', 'N/A', '2025-05-16 02:40:16', '2025-05-16 02:40:16'),
(12, 'Queroa, Lykah Niah E.', 0, '', '', 160, '2025-05-07', '2025-06-04', 'Administrative and Planning Division', 'John Ryan Dela Cruz', '2025-05-16 02:41:40', '2025-05-16 02:41:40'),
(13, 'Tomondog, Shahara A.', 0, '', '', 160, '2025-05-07', '2025-06-04', 'Customer Services Division', 'Loubelle Rubio', '2025-05-16 02:42:48', '2025-05-16 02:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `job_order`
--

CREATE TABLE `job_order` (
  `jo_id` int(5) NOT NULL,
  `personnel_id` int(5) DEFAULT NULL,
  `salaryRate` float(10,2) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_order`
--

INSERT INTO `job_order` (`jo_id`, `personnel_id`, `salaryRate`, `createdAt`, `updatedAt`) VALUES
(1, 56, 426.46, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(2, 57, 449.92, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(3, 58, 426.46, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(4, 59, 402.01, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(5, 60, 449.92, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(6, 61, 426.46, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(7, 62, 449.92, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(8, 63, 426.46, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(9, 64, 558.73, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(10, 65, 426.46, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(11, 66, 449.92, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(12, 67, 0.00, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(13, 68, 0.00, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(14, 69, 501.14, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(15, 70, 449.92, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(16, 71, 529.10, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(17, 72, 0.00, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(18, 73, 0.00, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(19, 74, 474.78, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(20, 75, 449.92, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(21, 76, 402.01, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(22, 77, 402.01, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(23, 78, 449.92, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(24, 79, 449.92, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(25, 80, 402.01, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(26, 81, 449.92, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(27, 82, 474.78, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(28, 83, 449.92, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(29, 84, 474.78, '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(30, 85, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(31, 86, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(32, 87, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(33, 88, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(34, 89, 449.92, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(35, 90, 474.78, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(36, 91, 449.92, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(37, 92, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(38, 93, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(39, 94, 474.78, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(40, 95, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(41, 96, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(42, 97, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(43, 98, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(44, 99, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(45, 100, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(46, 101, 501.14, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(47, 102, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(48, 103, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(49, 104, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(50, 105, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(51, 106, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(52, 107, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(53, 108, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(54, 109, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(55, 110, 792.92, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(56, 111, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(57, 112, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(58, 113, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(59, 114, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(60, 115, 501.14, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(61, 116, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(62, 117, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(63, 118, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(64, 119, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(65, 120, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(66, 121, 529.10, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(67, 122, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(68, 123, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(69, 124, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(70, 125, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(71, 126, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(72, 127, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(73, 128, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(74, 129, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(75, 130, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(76, 131, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(77, 132, 792.92, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(78, 133, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(79, 134, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(80, 135, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(81, 136, 474.78, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(82, 137, 658.73, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(83, 138, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(84, 139, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(85, 140, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(86, 141, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(87, 142, 405.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(88, 143, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(89, 144, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(90, 145, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(91, 146, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(92, 147, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(93, 148, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(94, 149, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(95, 150, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(96, 151, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(97, 152, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(98, 153, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(99, 154, 474.78, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(100, 155, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(101, 156, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(102, 157, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(103, 158, 474.78, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(104, 159, 474.78, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(105, 160, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(106, 161, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(107, 162, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(108, 163, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(109, 164, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(110, 165, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(111, 166, 474.78, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(112, 167, 474.78, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(113, 168, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(114, 169, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(115, 170, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(116, 171, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(117, 172, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(118, 173, 474.78, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(119, 174, 474.78, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(120, 175, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(121, 176, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(122, 177, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(123, 178, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(124, 179, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(125, 180, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(126, 181, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(127, 182, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(128, 183, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(129, 184, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(130, 185, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(131, 186, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(132, 187, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(133, 188, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(134, 189, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(135, 190, 501.14, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(136, 191, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(137, 192, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(138, 193, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(139, 194, 405.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(140, 195, 658.73, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(141, 196, 405.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(142, 197, 405.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(143, 198, 405.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(144, 199, 658.73, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(145, 200, 474.78, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(146, 201, 405.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(147, 202, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(148, 203, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(149, 204, 405.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(150, 205, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(151, 206, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(152, 207, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(153, 208, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(154, 209, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(155, 210, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(156, 211, 658.73, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(157, 212, 658.73, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(158, 213, 405.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(159, 214, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(160, 215, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(161, 216, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(162, 217, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(163, 218, 405.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(164, 219, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(165, 220, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(166, 221, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(167, 222, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(168, 223, 405.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(169, 224, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(170, 225, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(171, 226, 405.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(172, 227, 792.92, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(173, 228, 426.46, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(174, 229, 402.01, '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(175, 230, 0.00, '2025-05-22 07:52:58', '2025-05-22 07:52:58');

-- --------------------------------------------------------

--
-- Table structure for table `personnel`
--

CREATE TABLE `personnel` (
  `personnel_id` int(5) NOT NULL,
  `Emp_No` varchar(100) NOT NULL,
  `emp_type` enum('Regular','Job Order','Contract') NOT NULL,
  `emp_status` enum('Active','Inactive') NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `unit` varchar(100) NOT NULL,
  `section` varchar(100) NOT NULL,
  `team` varchar(255) NOT NULL,
  `operator` varchar(255) NOT NULL,
  `division` varchar(255) DEFAULT NULL,
  `contact_number` bigint(11) DEFAULT NULL,
  `sex` enum('Male','Female') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personnel`
--

INSERT INTO `personnel` (`personnel_id`, `Emp_No`, `emp_type`, `emp_status`, `full_name`, `position`, `unit`, `section`, `team`, `operator`, `division`, `contact_number`, `sex`, `birthdate`, `address`, `profile_picture`, `createdAt`, `updatedAt`) VALUES
(1, 'A', 'Regular', 'Active', 'LOIDA P. ABARCA', 'ACCOUNTING CLERK III', '', '', '', '', '', 0, 'Female', '1975-07-21', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(2, 'B', 'Regular', 'Active', 'CARLOS M. ACTUB', 'METER READER III', '', '', '', '', '', 0, 'Male', '1970-11-04', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(3, 'C', 'Regular', 'Active', 'NEIL G. ALICAYA', 'METER READER I', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(4, 'D', 'Regular', 'Active', 'PAQUITO G. ALIVIO', 'PLUMBING & TINNING INSPECTOR II', '', '', '', '', '', 0, 'Male', '1975-03-21', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(5, 'E', 'Regular', 'Active', 'CHRISTIAN NOEL C. AMBOS', 'PLUMBER I', '', '', '', '', '', 0, 'Male', '1983-11-29', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(6, 'F', 'Regular', 'Active', 'JOEL L. ANDOT', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1966-06-16', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(7, 'G', 'Regular', 'Active', 'ELADITA G. ALORRO', '', '', '', '', '', '', 0, 'Female', '1961-05-08', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(8, 'H', 'Regular', 'Active', 'ADLAI O. ARCILLA', '', '', '', '', '', '', 0, 'Male', '1989-01-02', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(9, 'I', 'Regular', 'Active', 'DENNIS LL. AUSTRIA', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1976-09-28', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(10, 'J', 'Regular', 'Active', 'KATHLEENE MARIE S. AVENIDO', 'MEDICAL TECHNOLOGY I', '', '', '', '', '', 0, 'Female', '1999-08-03', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(11, 'K', 'Regular', 'Active', 'WENEFREDO JR M. BALANAY', 'WELDER II', '', '', '', '', '', 0, 'Male', '1971-06-04', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(12, 'L', 'Regular', 'Active', 'KENT P. BANTILLAN', 'PLUMBER I', '', '', '', '', '', 0, 'Male', '1981-10-07', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(13, 'M', 'Regular', 'Active', 'JAY ANTONIO E. BARSUMO', 'ENGINEER IV', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(14, 'N', 'Regular', 'Active', 'SALVADOR JR. L. CABILI', 'ELECTRICIAN II', '', '', '', '', '', 0, 'Male', '1966-11-10', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(15, 'O', 'Regular', 'Active', 'ARNOLD C. CALIMPON', 'WELL DRILLER I', '', '', '', '', '', 0, 'Male', '1989-09-03', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(16, 'P', 'Regular', 'Active', 'GLEEN P. CAMBAYA', 'WELL DRILLER II', '', '', '', '', '', 0, 'Male', '1970-05-07', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(17, 'Q', 'Regular', 'Active', 'CIRILO JR. J. CANGKE', 'WELL DRILLER I', '', '', '', '', '', 0, 'Male', '1969-01-31', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(18, 'R', 'Regular', 'Active', 'GERARDO C. CLET', 'METER READER II', '', '', '', '', '', 0, 'Male', '1966-09-25', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(19, 'S', 'Regular', 'Active', 'NOEL D. CORONEL', 'SENIOR BOOKKEEPER', '', '', '', '', '', 0, 'Male', '1961-07-18', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(20, 'T', 'Regular', 'Active', 'SITTIE AISHA M. DACSLA', 'CLERK III', '', '', '', '', '', 0, 'Female', '1993-08-29', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(21, 'U', 'Regular', 'Active', 'ELMER G. DAJAO', 'WELL DRILLER II', '', '', '', '', '', 0, 'Male', '1962-08-12', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(22, 'V', 'Regular', 'Active', 'LOQUITO T. DALAYAO', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1970-10-17', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(23, 'W', 'Regular', 'Active', 'JOHN RYAN C. DELA CRUZ', 'SPVNG ADMIN OFFICER', '', '', '', '', '', 0, 'Male', '1983-01-02', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(24, 'X', 'Regular', 'Active', 'PABLO III P. DELOS REYES', 'WELL DRILLER II', '', '', '', '', '', 0, 'Male', '1965-04-23', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(25, 'Y', 'Regular', 'Active', 'RYNAN L. EVANGELISTA', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1976-11-11', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(26, 'Z', 'Regular', 'Active', 'FERDINAND V. FERNANDEZ', 'WELL DRILLER II', '', '', '', '', '', 0, 'Male', '1962-09-11', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(27, 'AA', 'Regular', 'Active', 'GODOFREDO D. GUMADLAS JR.', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1969-10-23', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(28, 'AB', 'Regular', 'Active', 'DENNIS P. GUMISONG', 'ENGINEERING ASSISTANT', '', '', '', '', '', 0, 'Male', '1988-04-29', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(29, 'AC', 'Regular', 'Active', 'FAIDAH A. GURO', 'METER READER I', '', '', '', '', '', 0, 'Female', '1986-09-20', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(30, 'AD', 'Regular', 'Active', 'STEPHEN M. INTALIGANDO', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1979-09-17', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(31, 'AE', 'Regular', 'Active', 'FREDDERICK B. ISEK', 'ENGINEERING ASSISTANT', '', '', '', '', '', 0, 'Male', '1976-05-10', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(32, 'AF', 'Regular', 'Active', 'LARRY A. JIMENA', 'ENGINEERING ASSISTANT', '', '', '', '', '', 0, 'Male', '1983-12-06', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(33, 'AG', 'Regular', 'Active', 'GLENDON B. LONOY', 'WELL DRILLER I', '', '', '', '', '', 0, 'Male', '1989-06-23', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(34, 'AH', 'Regular', 'Active', 'RAFAEL A. LONOY', 'MECHANIC III', '', '', '', '', '', 0, 'Male', '1964-02-26', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(35, 'AI', 'Regular', 'Active', 'JAY S. LUNA', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1972-02-17', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(36, 'AJ', 'Regular', 'Active', 'EDELL D. MAATA', 'INFO. TECH OFFICER', '', '', '', '', '', 0, 'Male', '1965-09-03', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(37, 'AK', 'Regular', 'Active', 'EDGARDO A. MANATA', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1967-02-28', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(38, 'AL', 'Regular', 'Active', 'EDWIN M. MONTANCES', 'ENGINEER III', '', '', '', '', '', 0, 'Male', '1967-01-12', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(39, 'AM', 'Regular', 'Active', 'DERWIN B. MUÑASQUE', 'PIPEFITTER FOREMAN', '', '', '', '', '', 0, 'Male', '1968-03-19', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(40, 'AN', 'Regular', 'Active', 'RONALDO S. NATINGA', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1965-02-07', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(41, 'AO', 'Regular', 'Active', 'ZENUN NAZ C. NUNEZ', 'WELL DRILLER I', '', '', '', '', '', 0, 'Male', '1986-11-26', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(42, 'AP', 'Regular', 'Active', 'MICHAEL P. ONDEN', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1981-02-24', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(43, 'AQ', 'Regular', 'Active', 'HUBERT G. REYES', 'ENGINEER III', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(44, 'AR', 'Regular', 'Active', 'RANULFO B. ROXAS', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1964-09-11', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(45, 'AS', 'Regular', 'Active', 'LOUBELLE O. RUBIO', 'ACCOUNTING CLERK III', '', '', '', '', '', 0, 'Female', '1971-12-28', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(46, 'AT', 'Regular', 'Active', 'LARRY H. SABUERO', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1975-01-01', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(47, 'AU', 'Regular', 'Active', 'JAIME C. SATO', 'CITY GOV\'T DEPT HEAD II', '', '', '', '', '', 0, 'Male', '1960-11-27', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(48, 'AV', 'Regular', 'Active', 'SHERWIN P. SEARES', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1973-08-12', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(49, 'AW', 'Regular', 'Active', 'VIRGILIO V. SEROJE', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1967-03-25', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(50, 'AX', 'Regular', 'Active', 'MIGUELITO B. TORRES', 'METER READER II', '', '', '', '', '', 0, 'Male', '1972-01-29', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(51, 'AY', 'Regular', 'Active', 'SAKINA M. TUCODAN', 'METER READER II', '', '', '', '', '', 0, 'Female', '1962-01-03', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(52, 'AZ', 'Regular', 'Active', 'JERRY RUEL L. TUMANDA', 'MECHANIC II', '', '', '', '', '', 0, 'Male', '1979-05-01', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(53, 'BA', 'Regular', 'Active', 'RICHARD L. VALDEMOZA', 'WELL DRILLER I', '', '', '', '', '', 0, 'Male', '1993-02-09', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(54, 'BB', 'Regular', 'Active', 'GLENN C. VILLACIN', 'ENGINEER I', '', '', '', '', '', 0, 'Male', '1973-05-05', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(55, 'BC', 'Regular', 'Active', 'MARVIN S. ZAYAS', 'MECHANIC II', '', '', '', '', '', 0, 'Male', '1980-07-24', '', '', '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(56, 'BD', 'Job Order', 'Active', 'MIRAFLOR P. ABIOL', 'Administrative Assistant V', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Female', '1982-09-22', 'BRGY. HINAPLANON', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(57, 'BE', 'Job Order', 'Active', 'JUNAIMA B. ACTUB', 'Administrative Assistant VI', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Female', '1982-04-24', 'BRGY. PALAO', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(58, 'BF', 'Job Order', 'Active', 'RITCHEL L. ARCEGA', 'Administrative Assistant V', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Female', '1973-08-14', 'BRGY. HINAPLANON', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(59, 'BG', 'Job Order', 'Active', 'WENIFREDA F. AMOR', 'Administrative Assistant III', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Male', '1983-11-02', 'BRGY. PALAO', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(60, 'BH', 'Job Order', 'Active', 'CLARIENCE B. CUBAR', 'Administrative Assistant VI', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Female', '1984-12-25', 'BRGY. DEL CARMEN', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(61, 'BI', 'Job Order', 'Active', 'EMMA C. LU', 'Administrative Assistant V', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Female', '1967-08-12', 'BRGY. LUINAB', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(62, 'BJ', 'Job Order', 'Active', 'RYAN ANTHONY E. MAGLASANG', 'Administrative Assistant VI (Guard)', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Male', '1983-04-15', 'BRGY. SAN MIGUEL', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(63, 'BK', 'Job Order', 'Active', 'FELIX SR. MUNDALA', 'Administrative Assistant V (Guard)', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Male', '1998-08-13', 'BRGY. HINAPLANON', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(64, 'BL', 'Job Order', 'Active', 'MARIA CECILIA C. MUTYA', 'Senior Administrative Assistant IV', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Female', '2000-01-30', 'BRGY. SARAY', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(65, 'BM', 'Job Order', 'Active', 'TEODELITA P. REUYAN', 'Administrative Assistant V', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Female', NULL, 'BRGY. BAGONG SILANG', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(66, 'BN', 'Job Order', 'Active', 'CHRISTIANNE JAMES L. SATO', 'Administrative Assistant VI (Guard)', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Male', NULL, 'BRGY. PALAO', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(67, 'BO', 'Job Order', 'Active', 'REY A. BALONGAG', 'Administrative Assistant VI', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Male', NULL, '', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(68, 'BP', 'Job Order', 'Active', 'HELEN E. NADAYAG', 'Senior Administrative Assistant IV', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Female', NULL, '', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(69, 'BQ', 'Job Order', 'Active', 'JEFFRY N. ECHAVEZ', 'Senior Administrative Assistant I', '', '', '', '', 'ENGINEERING AND PLANNING', 0, 'Male', '1975-05-01', 'BRGY. TAMBO HINAPLANON', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(70, 'BR', 'Job Order', 'Active', 'JUANITO R. REMEDIOS', 'Admininistrative Assistant V', '', '', '', '', 'ENGINEERING AND PLANNING', 0, 'Male', '1969-03-02', 'BRGY. TUBOD', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(71, 'BS', 'Job Order', 'Active', 'FERNANIE C. REUYAN', 'Senior Admininistrative Assistant II', '', '', '', '', 'ENGINEERING AND PLANNING', 0, 'Female', '1966-11-11', 'BRGY. TIPANOY', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(72, 'BT', 'Job Order', 'Active', 'ENSUGO O. AMANODIN JR. ', 'Senior Administrative Assistant II', '', '', '', '', 'ENGINEERING AND PLANNING', 0, 'Male', NULL, '', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(73, 'BU', 'Job Order', 'Active', 'JOSEPH B. KIRIT', '', '', '', '', '', 'ENGINEERING AND PLANNING', 0, 'Male', NULL, '', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(74, 'BV', 'Job Order', 'Active', 'YOLANDO S. ABA-A', 'Administrative Assistant VI', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', '1947-12-21', 'BRGY. PALAO', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(75, 'BW', 'Job Order', 'Active', 'KEVIN ZAR A. AGCAOILI', 'Administrative Assistant V', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', '1990-02-23', 'BRGY. SUAREZ', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(76, 'BX', 'Job Order', 'Active', 'LENELYN S. ASO', 'Administrative Assistant III', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', '1966-01-20', 'BRGY. TIPANOY', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(77, 'BY', 'Job Order', 'Active', 'CHERRIEL T. BALABA', 'Administrative Assistant III', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', '1971-01-03', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(78, 'BZ', 'Job Order', 'Active', 'FARRAH M. BARDOQUILLO', 'Administrative Assistant V', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', '1974-07-31', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(79, 'CA', 'Job Order', 'Active', 'LENIE B. BINERBA', 'Administrative Assistant V', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', '1977-04-23', 'BRGY. POBLACION', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(80, 'CB', 'Job Order', 'Active', 'MARIA BUSTAMANTE', 'Administrative Assistant III', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', '1991-11-14', 'BRGY. UBALDO LAYA', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(81, 'CC', 'Job Order', 'Active', 'MARK E. CABELLO', 'Administrative Assistant V', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', NULL, '', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(82, 'CD', 'Job Order', 'Active', 'JAY G. CAMINONG', 'Administrative Assistant VI', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', '1980-04-15', 'BRGY. TIPANOY', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(83, 'CE', 'Job Order', 'Active', 'ALAN A. CORRO', 'Administrative Assistant V', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', '1988-07-13', 'BRGY. SARAY', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(84, 'CF', 'Job Order', 'Active', 'JOEY L. DOROTHEO', 'Administrative Assistant VI', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', '1958-12-16', 'BRGY. MARIA CRISTINA', '', '2025-05-22 07:52:57', '2025-05-22 07:52:57'),
(85, 'CG', 'Job Order', 'Active', 'DOREEN O. ESLIT', 'Administrative Assistant III', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', '1974-02-26', 'BRGY. SAN ROQUE', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(86, 'CH', 'Job Order', 'Active', 'NOEL A. FERIANILA', 'Administrative Assistant IV', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', '1985-03-09', 'BRGY. TUBOD', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(87, 'CI', 'Job Order', 'Active', 'MARICHU B. FERRER', 'Administrative Assistant III', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(88, 'CJ', 'Job Order', 'Active', 'ROUTEL P. FLORES', 'Administrative Assistant III', '', '', '', '', 'CUSTOMER SERVICE', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(89, 'CK', 'Job Order', 'Active', 'GILBERT HENSIS', 'Administrative Assistant V', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', '1975-07-27', 'BRGY. TIPANOY', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(90, 'CL', 'Job Order', 'Active', 'DELMA M. MONTEROLA', 'Administrative Assistant VI', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', '1983-01-13', 'BRGY. TIPANOY', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(91, 'CM', 'Job Order', 'Active', 'ARTURO R. NANAMAN', 'Administrative Assistant V', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(92, 'CN', 'Job Order', 'Active', 'ROSEVEL P. NARBASA', 'Administrative Assistant III', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(93, 'CO', 'Job Order', 'Active', 'GIL B. PABLEO', 'Administrative Assistant IV', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', '1959-03-26', 'BRGY. TIPANOY', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(94, 'CP', 'Job Order', 'Active', 'MAYVILLE C. PADAYHAG', 'Senior Administrative Assistant I', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', '1992-03-07', 'BRGY. TIPANOY', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(95, 'CQ', 'Job Order', 'Active', 'JENALYN D. PORRAS', 'Administrative Assistant III', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(96, 'CR', 'Job Order', 'Active', 'RIZA P. RESTOJAS', 'Administrative Assistant III', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', '1989-05-21', 'BRGY. TIPANOY', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(97, 'CS', 'Job Order', 'Active', 'LIZAMIL A. TABA', 'Administrative Assistant IV', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(98, 'CT', 'Job Order', 'Active', 'MICAH NIÑA S. VILLANUEVA', 'Administrative Assistant IV', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', NULL, '', '', '2025-05-22 07:53:23', '2025-05-22 07:53:23'),
(99, 'CU', 'Job Order', 'Active', 'AMELITA C. QUIMADA', 'Administrative Assistant IV', '', '', '', '', '', 0, 'Female', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(100, 'CV', 'Job Order', 'Active', 'YOLANDA O. ALBA?O', 'Senior Administrative Assistant I', '', '', '', '', 'PLANNING AND ENGINEERING', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(101, 'CW', 'Job Order', 'Active', 'ARMANDO L. ALFECHE', 'Senior Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Female', '1968-10-22', 'BRGY. MARIA CRISTINA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(102, 'CX', 'Job Order', 'Active', 'JOHN RYAN L. ALFECHE', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1966-09-02', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(103, 'CY', 'Job Order', 'Active', 'RICHARD M. AMBITO', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1998-08-12', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(104, 'CZ', 'Job Order', 'Active', 'JOHN CARLO S. BATITAO', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1977-10-30', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(105, 'DA', 'Job Order', 'Active', 'ELMER JR C. CABOL', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1999-12-16', 'BRGY.MAHAYAHAY', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(106, 'DB', 'Job Order', 'Active', 'ALFONSO A. CANTINA', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1995-10-26', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(107, 'DC', 'Job Order', 'Active', 'CECILIO C. EMBORONG', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1953-11-20', 'BRGY. MARIA CRISTINA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(108, 'DD', 'Job Order', 'Active', 'JONATHAN ESCOTO', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1972-02-14', 'BRGY. STA ELENA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(109, 'DE', 'Job Order', 'Active', 'RJ CHRISTIAN A. JAGONIO', 'Supervising Administrative Officer', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '0960-03-13', 'BRGY. TIPANOY', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(110, 'DF', 'Job Order', 'Active', 'JAIME E. JAYLO', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1978-12-25', 'BRGY. PALAO', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(111, 'DG', 'Job Order', 'Active', 'ENRIQUE H. LARGADO', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1965-01-14', 'BRGY. HINAPLANON', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(112, 'DH', 'Job Order', 'Active', 'RODY A. LEGASPI', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1980-03-31', 'BRGY. UBALDO LAYA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(113, 'DI', 'Job Order', 'Active', 'ROEL L. LOPERA', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1959-08-05', 'Brgy. Tipanoy', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(114, 'DJ', 'Job Order', 'Active', 'MINDAYA P. MACALA', 'Senior Administrative Assistant I', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1971-07-21', 'Brgy. Lambaguhon', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(115, 'DK', 'Job Order', 'Active', 'NESTOR C. NEMENSO', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Female', '1968-09-05', 'Brgy. Tubod', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(116, 'DL', 'Job Order', 'Active', 'ROLANDO C. VERGARA', 'Administrative Assistant V', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1971-08-02', 'Brgy. Ditucalan', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(117, 'DM', 'Job Order', 'Active', 'SOFRONIO M. ABIAN', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(118, 'DN', 'Job Order', 'Active', 'JULIAN V. ACTUB', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(119, 'DO', 'Job Order', 'Active', 'CLAUDIO C. ACMAD', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(120, 'DP', 'Job Order', 'Active', 'ABEL T. ADMAIN', 'Senior Administrative Assistant II', '', '', '', '', 'PRODUCTION', 0, 'Male', '1969-07-15', 'BRGY. HINAPLANON', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(121, 'DQ', 'Job Order', 'Active', 'CAMSARY T. ADMAIN', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Female', '1960-11-16', 'BRGY. HINAPLANON', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(122, 'DR', 'Job Order', 'Active', 'JEHARIM M. ALAWI', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1974-04-12', 'BRGY. TAMBACAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(123, 'DS', 'Job Order', 'Active', 'MERLO JOHN T. ALSONADO', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(124, 'DT', 'Job Order', 'Active', 'EMILIO AMAMANGPANG', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1989-04-17', 'BRGY. MARIA CRISTINA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(125, 'DU', 'Job Order', 'Active', 'ALI AMPUAN', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1962-11-10', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(126, 'DV', 'Job Order', 'Active', 'ASHNAWI A. ASIS', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1965-06-16', 'BRGY. BALOI', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(127, 'DW', 'Job Order', 'Active', 'EDGAR N. BADO', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1982-09-27', 'BRGY. TUBOD', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(128, 'DX', 'Job Order', 'Active', 'RUEL E. BADO', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1960-06-29', 'BRGY. HINAPLANON', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(129, 'DY', 'Job Order', 'Active', 'ZENITH A. BADO', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(130, 'DZ', 'Job Order', 'Active', 'MARIBEL M. BARIOGA', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1976-11-07', 'BRGY. UPPER HINAPLANON', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(131, 'EA', 'Job Order', 'Active', 'SOBAIR D. BARUANG', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Female', '1967-02-02', 'BRGY. HINAPLANON', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(132, 'EB', 'Job Order', 'Active', 'JUNREY C. BOOC', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(133, 'EC', 'Job Order', 'Active', 'RAMILITO R. CABALLERO', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1981-10-20', 'BRGY. UPPER TOMINOBO', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(134, 'ED', 'Job Order', 'Active', 'REY A. CABANILLA', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1979-12-05', 'BRGY. LUINAB', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(135, 'EE', 'Job Order', 'Active', 'MIGUEL B. CABILI', 'Administrative Assistant VI', '', '', '', '', 'PRODUCTION', 0, 'Male', '1971-09-01', 'BRGY. UPPER TOMINOBO', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(136, 'EF', 'Job Order', 'Active', 'WEDELYN P. CADIVIDA', 'Senior Administrative Assistant V', '', '', '', '', 'PRODUCTION', 0, 'Male', '1960-09-03', 'BRGY. TIPANOY', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(137, 'EG', 'Job Order', 'Active', 'MARLONY. CAITOM', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Female', '1987-06-20', 'BRGY. STO. ROSARIO', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(138, 'EH', 'Job Order', 'Active', 'SEITH ELIJAH C. CALABIO', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1983-03-10', 'BRGY. TOMAS CABILI', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(139, 'EI', 'Job Order', 'Active', 'RICKY M. CALISO', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(140, 'EJ', 'Job Order', 'Active', 'ERIC T. CANETE', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(141, 'EK', 'Job Order', 'Active', 'BENVINIDO C. CANOY', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '2001-08-13', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(142, 'EL', 'Job Order', 'Active', 'BOYET C. CANOY', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1976-02-17', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(143, 'EM', 'Job Order', 'Active', 'EDMON L. CANOY', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1979-11-11', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(144, 'EN', 'Job Order', 'Active', 'ROMEL C. CANTILA', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1992-09-22', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(145, 'EO', 'Job Order', 'Active', 'ZOSIMO T. CANTILA', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(146, 'EP', 'Job Order', 'Active', 'ANUAR M. CAPAL', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1984-03-03', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(147, 'EQ', 'Job Order', 'Active', 'VICENTE T. CATAMBACAN', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1961-01-01', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(148, 'ER', 'Job Order', 'Active', 'JACK L. CORDOVA', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1963-08-01', 'BRGY. UPPER TOMINOBO', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(149, 'ES', 'Job Order', 'Active', 'ELVIE M. CRISTORIA', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(150, 'ET', 'Job Order', 'Active', 'COSAIN M. DACSLA', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Female', '1968-10-18', 'BRGY. TOMAS CABILI', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(151, 'EU', 'Job Order', 'Active', 'MOH\'D HAMID D. DACSLA', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1995-08-18', 'BRGY. MARIA CRISTINA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(152, 'EV', 'Job Order', 'Active', 'SIRAD JR. M. DACSLA', 'Administrative Assistant V', '', '', '', '', 'PRODUCTION', 0, 'Male', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(153, 'EW', 'Job Order', 'Active', 'EFIEDO P. DURAN', 'Administrative Assistant VI', '', '', '', '', 'PRODUCTION', 0, 'Male', '1992-12-11', 'BRGY. MARIA CRISTINA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(154, 'EX', 'Job Order', 'Active', 'LOUIE JAYLO S. ESCARAN', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1982-05-13', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(155, 'EY', 'Job Order', 'Active', 'JEAN B. ESTO', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1959-10-23', 'BRGY. MARIA CRISTINA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(156, 'EZ', 'Job Order', 'Active', 'ANTONIO N. GENERALAO', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1990-08-05', 'BRGY. TIPANOY', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(157, 'FA', 'Job Order', 'Active', 'DONATO B. GUMBA', 'Administrative Assistant VI', '', '', '', '', 'PRODUCTION', 0, 'Male', NULL, 'BRGY. UPPER TOMINOBO', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(158, 'FB', 'Job Order', 'Active', 'MARIO WARLITO A. IMPAT', 'Administrative Assistant VI', '', '', '', '', 'PRODUCTION', 0, 'Male', '1965-07-30', 'BRGY. MARIA CRISTINA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(159, 'FC', 'Job Order', 'Active', 'BENITA B. LABIAN', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1961-05-06', 'BRGY. KIWALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(160, 'FD', 'Job Order', 'Active', 'DINDO D. LAHOYLAHOY', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Female', '1955-04-14', 'BRGY. DALIPUGA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(161, 'FE', 'Job Order', 'Active', 'ELIZALDE C. LOBATON', 'Administrative Assistant IV', '', '', '', '', 'PRODUCTION', 0, 'Male', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(162, 'FF', 'Job Order', 'Active', 'SAYPODIEN T. MACALANDONG', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Female', '1983-11-15', 'BRGY. DEL CARMEN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(163, 'FG', 'Job Order', 'Active', 'FELIPA MANOS', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Female', '1964-07-08', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(164, 'FH', 'Job Order', 'Active', 'NHIKIE BOY C. MAQUILAN', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(165, 'FI', 'Job Order', 'Active', 'RONILLO A. MATA', 'Administrative Assistant VI', '', '', '', '', 'PRODUCTION', 0, 'Female', '1959-06-07', 'BRGY. DALIPUGA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(166, 'FJ', 'Job Order', 'Active', 'FELIX JR. D. MICAYABAS', 'Administrative Assistant VI', '', '', '', '', 'PRODUCTION', 0, 'Male', '1979-11-08', 'BRGY. HINAPLANON', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(167, 'FK', 'Job Order', 'Active', 'METCHIL B. MONTESA', 'Administrative Assistant VI', '', '', '', '', 'PRODUCTION', 0, 'Male', '1956-11-10', 'BRGY. MARIA CRISTINA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(168, 'FL', 'Job Order', 'Active', 'NIELSON B. NIETES', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(169, 'FM', 'Job Order', 'Active', 'ARVIN REY D. OBACH', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1977-11-06', 'BRGY. HINAPLANON', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(170, 'FN', 'Job Order', 'Active', 'JERWYNN D. OBACH', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1972-08-05', 'BRGY. TOMINOBO', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(171, 'FO', 'Job Order', 'Active', 'RODOLFO D. OBACH', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1978-01-05', 'BRGY. TOMINOBO', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(172, 'FP', 'Job Order', 'Active', 'ROSALINO S. OUANO', 'Administrative Assistant VI', '', '', '', '', 'PRODUCTION', 0, 'Male', '1981-11-01', 'BRGY. TOMAS CABILI', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(173, 'FQ', 'Job Order', 'Active', 'LORETO R. PAGALING', 'Administrative Assistant VI', '', '', '', '', 'PRODUCTION', 0, 'Male', '1954-10-02', 'BRGY. STA FILOMENA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(174, 'FR', 'Job Order', 'Active', 'BILL RONALD A. PEPITO', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', NULL, 'BRGY. STA FILOMENA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(175, 'FS', 'Job Order', 'Active', 'JOVANNE H. PONCE', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1959-05-05', 'BRGY. MARIA CRISTINA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(176, 'FT', 'Job Order', 'Active', 'DOMINGO M. RATERTA JR.', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(177, 'FU', 'Job Order', 'Active', 'ROY O. RAUDE', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1983-11-08', 'BRGY. MARIA CRISTINA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(178, 'FV', 'Job Order', 'Active', 'JONATHAN D. SANCHEZ', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1981-11-15', 'BRGY. SUAREZ', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(179, 'FW', 'Job Order', 'Active', 'JETHRO D. SILAO', 'Administrative Assistant IV', '', '', '', '', 'PRODUCTION', 0, 'Male', '1992-02-24', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(180, 'FX', 'Job Order', 'Active', 'GIOVANNI SOLANO', 'Administrative Assistant IV', '', '', '', '', 'PRODUCTION', 0, 'Male', '1958-06-14', 'BRGY. MARIA CRISTINA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(181, 'FY', 'Job Order', 'Active', 'CERILO JR. T. TABEROS', 'Administrative Assistant IV', '', '', '', '', 'PRODUCTION', 0, 'Male', '1981-07-19', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(182, 'FZ', 'Job Order', 'Active', 'ALINOR L. TANGGO', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1963-09-23', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(183, 'GA', 'Job Order', 'Active', 'RODULFO P. VARGAS', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(184, 'GB', 'Job Order', 'Active', 'JOSE VERGARA', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1959-07-20', 'BRGY. UPPER TOMINOBO', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(185, 'GC', 'Job Order', 'Active', 'VERGARA, JOSE', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1977-12-02', 'BRY. SAN ROQUE', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(186, 'GD', 'Job Order', 'Active', 'JONIZ V. CABILI', '', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(187, 'GE', 'Job Order', 'Active', 'RONALD L. ABUEME', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, 'Male', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(188, 'GF', 'Job Order', 'Active', 'EDISON S. ACTUB', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, 'Male', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(189, 'GG', 'Job Order', 'Active', 'FELIPE C. ACTUB', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, 'Male', '1969-10-05', 'BRGY. STA FELOMINA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(190, 'GH', 'Job Order', 'Active', 'JUNALYN V. ACTUB', 'Senior Administrative Assistant III', '', '', '', '', 'OPERATION', 0, 'Female', '1992-06-19', 'BRGY. TIBANGA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(191, 'GI', 'Job Order', 'Active', 'ZOREN DAVE A. AGOSTO', 'Administrative Assistant III', '', '', '', '', 'OPERATION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(192, 'GJ', 'Job Order', 'Active', 'JESSIE S. AMBALONG', 'Administrative Assistant III', '', '', '', '', 'OPERATION', 0, 'Male', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(193, 'GK', 'Job Order', 'Active', 'ANTONIO L. BACARA', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, 'Male', '1966-05-11', 'BRGY. TIPANOY', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(194, 'GL', 'Job Order', 'Active', 'LOUIS PHILIP V. BAULA', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1995-04-02', 'BRGY. TUBOD', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(195, 'GM', 'Job Order', 'Active', 'RICARDO BERNAT', 'Administrative Assistant V', '', '', '', '', 'OPERATION', 0, 'Male', '1965-01-21', 'BRGY. PALAO', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(196, 'GN', 'Job Order', 'Active', 'RONNIE A. CABILTES', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1974-01-04', 'BRGY. TIPANOY', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(197, 'GO', 'Job Order', 'Active', 'JOAR J. CABTALAN', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1962-08-24', 'BRGY. DEL CARMEN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(198, 'GP', 'Job Order', 'Active', 'RICKY D. CALIMPON', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1976-01-04', 'BRGY. VILLA VERDE', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(199, 'GQ', 'Job Order', 'Active', 'HERJIFRE C. CHATTO', 'Senior Administrative Assistant V', '', '', '', '', 'OPERATION', 0, 'Female', '1966-05-29', 'BRGY. TIBANGA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(200, 'GR', 'Job Order', 'Active', 'FAHDIYAH M. DACSLA', 'Senior Administrative Assistant III', '', '', '', '', 'OPERATION', 0, 'Female', '1994-06-23', 'BRGY. MARIA CRISTINA', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(201, 'GS', 'Job Order', 'Active', 'LUIS T. DEL PILAR', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1962-08-25', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(202, 'GT', 'Job Order', 'Active', 'NOZART B. DELOS REYES', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, 'Male', '1973-12-05', 'BRGY. TIPANOY', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(203, 'GU', 'Job Order', 'Active', 'TRAZON III B. DELOS REYES', 'Administrative Assistant III', '', '', '', '', 'OPERATION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(204, 'GV', 'Job Order', 'Active', 'MARIO C. EDOSMA', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1963-06-08', 'BRGY. VILLA VERDE', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(205, 'GW', 'Job Order', 'Active', 'NESTOR JR. B. ELECION', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, 'Male', '1989-10-27', 'BRGY. PALAO', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(206, 'GX', 'Job Order', 'Active', 'EDGARDO R. EJARA', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, 'Male', '1963-05-07', 'BRGY. HINAPLANON', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(207, 'GY', 'Job Order', 'Active', 'JASPHER IAN  V. ENTICA', 'Administrative Assistant III', '', '', '', '', 'OPERATION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(208, 'GZ', 'Job Order', 'Active', 'RUSTY EMMANUEL G. FERNANDEZ', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, 'Male', '1972-11-14', 'BRGY. TUBOD', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(209, 'HA', 'Job Order', 'Active', 'FERNANDO A. GARCIA', 'Administrative Assistant III', '', '', '', '', 'OPERATION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(210, 'HB', 'Job Order', 'Active', 'JUDE GAYOSA', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(211, 'HC', 'Job Order', 'Active', 'CANDELARIO B. GUINIT', ' Senior Administrative Assistant V', '', '', '', '', 'OPERATION', 0, 'Male', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(212, 'HD', 'Job Order', 'Active', 'EDISON B. GALLETO', ' Senior Administrative Assistant V', '', '', '', '', 'OPERATION', 0, 'Male', '1969-10-16', 'BRGY. TAMBACAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(213, 'HE', 'Job Order', 'Active', 'JOVEN I. GENERALAO', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1977-10-15', 'BRGY. DITUCALAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(214, 'HF', 'Job Order', 'Active', 'IGLUPAS, JUSSEF DANES P.', 'Administrative Assistant III', '', '', '', '', 'OPERATION', 0, '', '1971-07-09', 'BRGY.TIPANOY', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(215, 'HG', 'Job Order', 'Active', 'ELFRED N. IGLUPAS', 'Administrative Assistant III', '', '', '', '', 'OPERATION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(216, 'HH', 'Job Order', 'Active', 'MANSUETO D. MAATA ', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, '', '1960-10-09', 'BRGY. PALAO', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(217, 'HI', 'Job Order', 'Active', 'JOEY A. MIGUELA', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(218, 'HJ', 'Job Order', 'Active', 'JOEL L. PASCUA', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1969-10-13', 'BRGY. ABUNO', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(219, 'HK', 'Job Order', 'Active', 'ELMER B. REYES', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, 'Male', '1956-08-01', 'BRGY. FUENTES', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(220, 'HL', 'Job Order', 'Active', 'CESAR L. RIVERA', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, '', '1976-07-28', 'BRGY. TIPANOY', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(221, 'HM', 'Job Order', 'Active', 'ROLANDO A. SABADUQUIA', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, 'Male', '1963-07-18', 'BRGY. TUBOD', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(222, 'HN', 'Job Order', 'Active', 'GIOVANNIE S. SALGADO', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(223, 'HO', 'Job Order', 'Active', 'RODULFO SARANZA', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1979-12-06', 'BRGY. POBLACION', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(224, 'HP', 'Job Order', 'Active', 'RAMON JR. C. SENAJON', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(225, 'HQ', 'Job Order', 'Active', 'JAMES LEMAR G. SURBAN', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(226, 'HR', 'Job Order', 'Active', 'DANIEL A. TIGLAO', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1962-12-18', 'BRGY. TIPANOY', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(227, 'HS', 'Job Order', 'Active', 'JOSE JR. G. TUBIL', 'Supervising Administrative Officer', '', '', '', '', 'OPERATION', 0, 'Male', '1957-07-16', 'BRGY. TOMAS CABILI', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(228, 'HT', 'Job Order', 'Active', 'CRISANTIN R. VELASCO', 'Administrative Assistant III', '', '', '', '', 'OPERATION', 0, 'Male', '1983-07-15', 'BRGY. HINAPLANON', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(229, 'HU', 'Job Order', 'Active', 'VELORIA, CREZ JOUIE', 'Administrative Assistant III', '', '', '', '', 'OPERATION', 0, 'Female', '1998-01-17', 'BRGY. TAMBACAN', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(230, 'HV', 'Job Order', 'Active', 'VISTO, ROSSDALE JOHN I.', '', '', '', '', '', '', 0, '', NULL, '', '', '2025-05-22 07:52:58', '2025-05-22 07:52:58'),
(231, 'IA', 'Contract', 'Active', 'LORENA L. CABAC', 'Engineer III', '', '', '', '', 'Operation Division', 0, 'Female', '1990-07-06', 'BRGY.PALAO', '', '2025-05-22 07:53:55', '2025-05-22 07:53:55'),
(232, 'IB', 'Contract', 'Active', 'FELIX JR C. SONIDO', 'Focal Person', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Male', '1955-09-09', '', '', '2025-05-22 07:53:37', '2025-05-22 07:53:37'),
(233, 'IC', 'Contract', 'Active', 'JOSE II R. ONG', 'Administrative Assistant IV', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Male', '1969-05-05', 'BRGY. TIPANOY', '', '2025-05-22 07:53:37', '2025-05-22 07:53:37');

-- --------------------------------------------------------

--
-- Table structure for table `reg_emp`
--

CREATE TABLE `reg_emp` (
  `regEmp_id` int(5) NOT NULL,
  `personnel_id` int(5) DEFAULT NULL,
  `salary_id` int(5) DEFAULT NULL,
  `plantillaNo` int(5) DEFAULT NULL,
  `acaPera` float(10,2) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reg_emp`
--

INSERT INTO `reg_emp` (`regEmp_id`, `personnel_id`, `salary_id`, `plantillaNo`, `acaPera`, `createdAt`, `updatedAt`) VALUES
(1, 1, 1, 69, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(2, 2, 2, 41, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(3, 3, 3, 0, 0.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(4, 4, 4, 27, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(5, 5, 5, 33, 0.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(6, 6, 6, 35, 0.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(7, 7, 7, 25, 0.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(8, 8, 8, 78, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(9, 9, 9, 30, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(10, 10, 10, 0, 0.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(11, 11, 11, 67, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(12, 12, 12, 0, 0.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(13, 13, 13, 0, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(14, 14, 14, 66, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(15, 15, 15, 54, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(16, 16, 16, 62, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(17, 17, 17, 61, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(18, 18, 18, 43, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(19, 19, 19, 5, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(20, 20, 20, 0, 0.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(21, 21, 21, 57, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(22, 22, 22, 48, 0.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(23, 23, 23, 90, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(24, 24, 24, 53, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(25, 25, 25, 34, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(26, 26, 26, 56, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(27, 27, 27, 36, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(28, 28, 28, 16, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(29, 29, 29, 63, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(30, 30, 30, 29, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(31, 31, 31, 15, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(32, 32, 32, 12, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(33, 33, 33, 64, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(34, 34, 34, 60, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(35, 35, 35, 18, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(36, 36, 36, 68, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(37, 37, 37, 31, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(38, 38, 38, 13, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(39, 39, 39, 52, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(40, 40, 40, 28, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(41, 41, 41, 59, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(42, 42, 42, 37, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(43, 43, 43, 8, 0.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(44, 44, 44, 38, 0.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(45, 45, 45, 70, 0.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(46, 46, 46, 44, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(47, 47, 47, 1, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(48, 48, 48, 21, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(49, 49, 49, 47, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(50, 50, 50, 42, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(51, 51, 51, 77, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(52, 52, 52, 88, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(53, 53, 53, 55, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(54, 54, 54, 39, 2000.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(55, 55, 55, 0, 0.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47');

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `salary_id` int(5) NOT NULL,
  `personnel_id` int(5) DEFAULT NULL,
  `salaryGrade` bigint(20) DEFAULT NULL,
  `step` bigint(10) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `monthlySalary` float(10,2) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`salary_id`, `personnel_id`, `salaryGrade`, `step`, `level`, `monthlySalary`, `createdAt`, `updatedAt`) VALUES
(1, 1, 8, 2, '1st level NS', 20720.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(2, 2, 9, 5, '1st level NS', 23162.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(3, 3, 4, 0, '', 16209.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(4, 4, 10, 2, '2nd level NS', 24585.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(5, 5, 3, 0, '', 15265.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(6, 6, 5, 0, '', 17205.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(7, 7, 0, 0, '', 0.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(8, 8, 6, 2, '1st level NS', 18396.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(9, 9, 5, 2, '1st level NS', 17338.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(10, 10, 11, 0, '', 28512.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(11, 11, 6, 2, '1st level NS', 18396.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(12, 12, 3, 0, '', 15265.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(13, 13, 22, 2, '', 75952.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(14, 14, 6, 2, '1st level NS', 18396.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(15, 15, 3, 2, '1st level NS', 15384.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(16, 16, 5, 8, '1st level NS', 18151.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(17, 17, 3, 2, '1st level NS', 15384.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(18, 18, 6, 2, '1st level NS', 18255.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(19, 19, 9, 2, '1st level NS', 22404.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(20, 20, 6, 0, '', 18.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(21, 21, 5, 1, '', 17338.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(22, 22, 5, 0, '', 17205.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(23, 23, 22, 8, '1st level NS', 74836.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(24, 24, 5, 5, '1st level NS', 18151.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(25, 25, 5, 8, '1st level NS', 17739.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(26, 26, 5, 3, '', 17739.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(27, 27, 5, 2, '1st level NS', 17739.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(28, 28, 8, 5, '1st level NS', 20720.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(29, 29, 4, 5, '1st level NS', 16714.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(30, 30, 5, 2, '1st level NS', 17739.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(31, 31, 8, 2, '1st level NS', 20720.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(32, 32, 8, 2, '1st level NS', 20720.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(33, 33, 3, 2, '1st level NS', 15384.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(34, 34, 9, 5, '1st level NS', 22404.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(35, 35, 5, 8, '2nd level Sprv', 17739.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(36, 36, 22, 5, '1st level NS', 82999.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(37, 37, 5, 2, '2nd level Sprv', 17739.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(38, 38, 19, 2, '1st level NS', 54649.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(39, 39, 8, 8, '1st level NS', 20720.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(40, 40, 5, 2, '1st level NS', 18151.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(41, 41, 3, 2, '1st level NS', 15384.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(42, 42, 5, 2, '1st level NS', 17338.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(43, 43, 5, 0, '', 53873.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(44, 44, 8, 0, '', 17338.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(45, 45, 5, 0, '', 20534.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(46, 46, 5, 2, '1st level NS', 17338.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(47, 47, 22, 2, '2nd level Sprv', 75952.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(48, 48, 5, 5, '1st level NS', 17739.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(49, 49, 5, 2, '1st level NS', 17338.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(50, 50, 6, 8, '1st level NS', 19261.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(51, 51, 6, 8, '1st level NS', 19261.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(52, 52, 6, 2, '1st level NS', 18396.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(53, 53, 3, 2, '1st level NS', 15384.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(54, 54, 12, 1, '', 30705.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47'),
(55, 55, 6, 0, '', 18.00, '2025-05-22 07:52:47', '2025-05-22 07:52:47');

-- --------------------------------------------------------

--
-- Table structure for table `service_record`
--

CREATE TABLE `service_record` (
  `record_id` int(5) NOT NULL,
  `personnel_id` int(5) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `position` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(5) NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fullName` varchar(100) NOT NULL,
  `remember_token` varchar(100) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `fullName`, `remember_token`, `createdAt`, `updatedAt`) VALUES
(1, 'johnryan.delacruz', '$2y$10$iC6e.l/.M1CMn//2J0nzcuaVjKVtEV2HSUoTBL2kfDe4h4MnXoBNO', 'John Ryan Dela Cruz', '', '2025-04-04 03:33:39', '2025-05-08 01:08:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coc`
--
ALTER TABLE `coc`
  ADD PRIMARY KEY (`certificatecomp_id`),
  ADD KEY `jobOrder_id` (`jo_id`);

--
-- Indexes for table `contractservice_record`
--
ALTER TABLE `contractservice_record`
  ADD PRIMARY KEY (`serviceRecord_id`),
  ADD KEY `record_ibfk_1` (`contractservice_id`);

--
-- Indexes for table `contract_service`
--
ALTER TABLE `contract_service`
  ADD PRIMARY KEY (`contractservice_id`),
  ADD KEY `personnel_id` (`personnel_id`);

--
-- Indexes for table `intern`
--
ALTER TABLE `intern`
  ADD PRIMARY KEY (`intern_id`);

--
-- Indexes for table `job_order`
--
ALTER TABLE `job_order`
  ADD PRIMARY KEY (`jo_id`),
  ADD KEY `personnel_id` (`personnel_id`);

--
-- Indexes for table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`personnel_id`);

--
-- Indexes for table `reg_emp`
--
ALTER TABLE `reg_emp`
  ADD PRIMARY KEY (`regEmp_id`),
  ADD KEY `personnel_id` (`personnel_id`),
  ADD KEY `salary_id` (`salary_id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`salary_id`),
  ADD KEY `fk_salary_personnel` (`personnel_id`);

--
-- Indexes for table `service_record`
--
ALTER TABLE `service_record`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `personnel_id` (`personnel_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coc`
--
ALTER TABLE `coc`
  MODIFY `certificatecomp_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contractservice_record`
--
ALTER TABLE `contractservice_record`
  MODIFY `serviceRecord_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contract_service`
--
ALTER TABLE `contract_service`
  MODIFY `contractservice_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `intern`
--
ALTER TABLE `intern`
  MODIFY `intern_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `job_order`
--
ALTER TABLE `job_order`
  MODIFY `jo_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `personnel_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT for table `reg_emp`
--
ALTER TABLE `reg_emp`
  MODIFY `regEmp_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `salary_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `service_record`
--
ALTER TABLE `service_record`
  MODIFY `record_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coc`
--
ALTER TABLE `coc`
  ADD CONSTRAINT `coc_ibfk_1` FOREIGN KEY (`jo_id`) REFERENCES `job_order` (`jo_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contractservice_record`
--
ALTER TABLE `contractservice_record`
  ADD CONSTRAINT `record_ibfk_1` FOREIGN KEY (`contractservice_id`) REFERENCES `contract_service` (`contractservice_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contract_service`
--
ALTER TABLE `contract_service`
  ADD CONSTRAINT `contractservice_record` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`personnel_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_order`
--
ALTER TABLE `job_order`
  ADD CONSTRAINT `job_order_ibfk_1` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`personnel_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reg_emp`
--
ALTER TABLE `reg_emp`
  ADD CONSTRAINT `reg_emp_ibfk_1` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`personnel_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reg_emp_ibfk_2` FOREIGN KEY (`salary_id`) REFERENCES `salary` (`salary_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `fk_salary_personnel` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`personnel_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_record`
--
ALTER TABLE `service_record`
  ADD CONSTRAINT `personnel_id` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`personnel_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
