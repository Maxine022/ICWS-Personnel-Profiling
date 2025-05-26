-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 07:18 AM
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
  `used_hours` int(11) DEFAULT NULL,
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
  `salaryRate` float(10,2) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contract_service`
--

INSERT INTO `contract_service` (`contractservice_id`, `personnel_id`, `salaryRate`, `createdAt`, `updatedAt`) VALUES
(4, 466, 22050.40, '2025-05-26 05:17:44', '2025-05-26 05:17:44'),
(5, 467, 0.00, '2025-05-23 01:39:44', '2025-05-23 01:39:44'),
(6, 468, 501.00, '2025-05-23 01:39:44', '2025-05-23 01:39:44');

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
(3, 'Baldovi, Britzil P. ', 9318196307, 'Mindanao State University - Iligan Institute of Technology', '', 490, '2025-02-17', '2025-05-27', 'Administrative and Planning Division', 'John Ryan Dela Cruz', '2025-05-15 02:54:21', '2025-05-23 03:45:30'),
(4, 'Ancog, Thea A.', 9056042107, 'Mindanao State University - Iligan Institute of Technology', '', 490, '2025-02-11', '2025-02-26', 'Administrative and Planning Division', 'John Ryan Dela Cruz', '2025-05-15 02:59:45', '2025-05-24 09:47:51'),
(5, 'Loberanes, Danny Boy Jr. L.', 9951371229, 'Mindanao State University - Iligan Institute of Technology', 'BS Information Technology', 490, '2025-02-11', '2025-05-27', 'Administrative and Planning Division', 'John Ryan Dela Cruz', '2025-05-15 03:00:22', '2025-05-15 08:42:05'),
(6, 'Amer, Rohaifah G.', 0, '', '', 160, '2025-05-07', '2025-06-04', 'Customer Services Division', 'Loubelle Rubio', '2025-05-15 03:08:24', '2025-05-22 08:20:40'),
(7, 'Cali, Jyacinth Jude P. ', 0, '', '', 160, '2025-05-07', '2025-06-04', 'Waterworks Planning and Engineering Division', 'Jaime Sato', '2025-05-15 08:39:01', '2025-05-16 02:00:49'),
(8, 'Dragon, Mark Henry M.', 0, '', '', 160, '2025-04-09', '2025-06-04', 'Operation Division', 'Jaime Sato', '2025-05-16 02:00:34', '2025-05-22 08:17:31'),
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
(176, 291, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(177, 292, 449.92, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(178, 293, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(179, 294, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(180, 295, 449.92, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(181, 296, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(182, 297, 449.92, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(183, 298, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(184, 299, 558.73, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(185, 300, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(186, 301, 449.92, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(187, 302, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(188, 303, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(189, 304, 501.14, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(190, 305, 449.92, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(191, 306, 529.10, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(192, 307, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(193, 308, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(194, 309, 474.78, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(195, 310, 449.92, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(196, 311, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(197, 312, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(198, 313, 449.92, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(199, 314, 449.92, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(200, 315, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(201, 316, 449.92, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(202, 317, 474.78, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(203, 318, 449.92, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(204, 319, 474.78, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(205, 320, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(206, 321, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(207, 322, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(208, 323, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(209, 324, 449.92, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(210, 325, 474.78, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(211, 326, 449.92, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(212, 327, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(213, 328, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(214, 329, 474.78, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(215, 330, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(216, 331, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(217, 332, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(218, 333, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(219, 334, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(220, 335, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(221, 336, 501.14, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(222, 337, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(223, 338, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(224, 339, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(225, 340, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(226, 341, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(227, 342, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(228, 343, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(229, 344, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(230, 345, 792.92, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(231, 346, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(232, 347, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(233, 348, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(234, 349, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(235, 350, 501.14, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(236, 351, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(237, 352, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(238, 353, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(239, 354, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(240, 355, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(241, 356, 529.10, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(242, 357, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(243, 358, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(244, 359, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(245, 360, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(246, 361, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(247, 362, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(248, 363, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(249, 364, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(250, 365, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(251, 366, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(252, 367, 792.92, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(253, 368, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(254, 369, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(255, 370, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(256, 371, 474.78, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(257, 372, 658.73, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(258, 373, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(259, 374, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(260, 375, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(261, 376, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(262, 377, 405.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(263, 378, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(264, 379, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(265, 380, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(266, 381, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(267, 382, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(268, 383, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(269, 384, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(270, 385, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(271, 386, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(272, 387, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(273, 388, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(274, 389, 474.78, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(275, 390, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(276, 391, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(277, 392, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(278, 393, 474.78, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(279, 394, 474.78, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(280, 395, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(281, 396, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(282, 397, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(283, 398, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(284, 399, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(285, 400, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(286, 401, 474.78, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(287, 402, 474.78, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(288, 403, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(289, 404, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(290, 405, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(291, 406, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(292, 407, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(293, 408, 474.78, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(294, 409, 474.78, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(295, 410, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(296, 411, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(297, 412, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(298, 413, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(299, 414, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(300, 415, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(301, 416, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(302, 417, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(303, 418, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(304, 419, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(305, 420, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(306, 421, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(307, 422, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(308, 423, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(309, 424, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(310, 425, 501.14, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(311, 426, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(312, 427, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(313, 428, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(314, 429, 405.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(315, 430, 658.73, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(316, 431, 405.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(317, 432, 405.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(318, 433, 405.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(319, 434, 658.73, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(320, 435, 474.78, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(321, 436, 405.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(322, 437, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(323, 438, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(324, 439, 405.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(325, 440, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(326, 441, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(327, 442, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(328, 443, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(329, 444, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(330, 445, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(331, 446, 658.73, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(332, 447, 658.73, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(333, 448, 405.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(334, 449, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(335, 450, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(336, 451, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(337, 452, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(338, 453, 405.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(339, 454, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(340, 455, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(341, 456, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(342, 457, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(343, 458, 405.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(344, 459, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(345, 460, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(346, 461, 405.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(347, 462, 792.92, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(348, 463, 426.46, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(349, 464, 402.01, '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(350, 465, 0.00, '2025-05-23 01:39:30', '2025-05-23 01:39:30');

-- --------------------------------------------------------

--
-- Table structure for table `jo_work_experience`
--

CREATE TABLE `jo_work_experience` (
  `experience_id` int(5) NOT NULL,
  `personnel_id` int(5) NOT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `position_title` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `monthly_salary` float(10,2) DEFAULT NULL,
  `updatedAt` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jo_work_experience`
--

INSERT INTO `jo_work_experience` (`experience_id`, `personnel_id`, `date_from`, `date_to`, `position_title`, `department`, `monthly_salary`, `updatedAt`) VALUES
(1, 309, '2025-05-01', '2025-05-05', 'JS', 'JS', 232.12, '2025-05-23');

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
(236, 'ICWSR001', 'Regular', 'Active', 'ABARCA, LOIDA P. ', 'ACCOUNTING CLERK III', '', 'Billing', '', '', 'Customer Services Division', 9167849884, 'Female', '1975-06-21', 'SCIONS SUBD., TOMAS CABILI, ILIGAN CITY', '', '2025-05-23 03:34:15', '2025-05-23 03:34:15'),
(237, 'ICWSR002', 'Regular', 'Active', 'ACTUB, CARLOS M. ', 'METER READER III', '', 'METERING', '', '', 'Customer Services Division', 9177161140, 'Male', '1970-11-04', 'P11, TOWNSITE, DALIPUGA, ILIGAN CITY', '', '2025-05-23 03:40:06', '2025-05-23 03:40:06'),
(238, 'ICWSR003', 'Regular', 'Active', 'ALICAYA, NEIL G. ', 'METER READER I', '', '', '', '', '', 0, 'Male', '0000-00-00', '', '', '2025-05-23 03:53:01', '2025-05-23 03:53:01'),
(239, 'ICWSR004', 'Regular', 'Active', 'ALIVIO, PAQUITO G. ', 'PLUMBING & TINNING INSPECTOR II', 'CONNECTION MANAGEMENT', 'DISTRIBUTION', '', '', 'Operations Division', 9050270280, 'Male', '1975-03-21', 'P15, MARIANVILLE, TIPANOY, ILIGAN CITY', '', '2025-05-23 03:45:27', '2025-05-23 03:45:27'),
(240, 'ICWSR005', 'Regular', 'Active', 'AMBOS, KHRISTIAN NOEL C. ', 'PLUMBER I', 'LEAK REPAIR AND DETECTION', 'DISTRIBUTION', '', '', 'Operations Division', 9368812120, 'Male', '1983-11-29', 'P16, DOVE, ISABEL VILLAGE, PALAO, ILIGAN CITY', '', '2025-05-23 04:00:23', '2025-05-23 04:00:23'),
(241, 'ICWSR006', 'Regular', 'Active', 'ANDOT, JOEL L. ', 'PLUMBER II', 'LEAK DETECTION', 'DISTRIBUTION', '', '', 'Operations Division', 9530465245, 'Male', '1966-06-16', 'FUENTES, MARIA CRISTINA, ILIGAN CITY', '', '2025-05-23 04:02:56', '2025-05-23 04:02:56'),
(242, 'ICWSRET001', 'Regular', 'Inactive', 'ALORRO, ELADITA G. ', '', '', '', '', '', '', 0, 'Female', '0000-00-00', 'BRGY. HINAPLANON', '', '2025-05-23 03:53:42', '2025-05-23 03:53:42'),
(243, 'H', 'Regular', 'Active', 'ARCILLA, ADLAI O. ', '', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 01:40:30', '2025-05-23 01:40:30'),
(244, 'I', 'Regular', 'Active', 'AUSTRIA, DENNIS LL. ', 'PLUMBER II', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:08:09', '2025-05-23 03:08:09'),
(245, 'J', 'Regular', 'Active', 'AVENIDO, KATHLEENE MARIE S. ', 'MEDICAL TECHNOLOGY I', '', '', '', '', '', 0, 'Female', '1999-08-03', '', '', '2025-05-23 03:36:54', '2025-05-23 03:36:54'),
(246, 'K', 'Regular', 'Active', 'BALANAY, WENEFREDO JR M. ', 'WELDER II', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:02:13', '2025-05-23 03:02:13'),
(247, 'L', 'Regular', 'Active', 'BANTILLAN, KENT P. ', 'PLUMBER I', '', '', '', '', '', 0, 'Male', '1981-10-07', '', '', '2025-05-23 03:39:40', '2025-05-23 03:39:40'),
(248, 'M', 'Regular', 'Active', 'BARSUMO, JAY ANTONIO E. ', 'ENGINEER IV', '', '', '', '', '', 0, 'Male', '0000-00-00', '', '', '2025-05-23 03:40:38', '2025-05-23 03:40:38'),
(249, 'N', 'Regular', 'Active', 'CABILI, SALVADOR JR. L. ', 'ELECTRICIAN II', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:07:06', '2025-05-23 03:07:06'),
(250, 'O', 'Regular', 'Active', 'CALIMPON, ARNOLD C. ', 'WELL DRILLER I', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 02:58:00', '2025-05-23 02:58:00'),
(251, 'P', 'Regular', 'Active', 'CAMBAYA, GLEEN P. ', 'WELL DRILLER II', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:30:17', '2025-05-23 03:30:17'),
(252, 'Q', 'Regular', 'Active', 'CANGKE, CIRILO JR. J. ', 'WELL DRILLER I', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:00:22', '2025-05-23 03:00:22'),
(253, 'R', 'Regular', 'Active', 'CLET, GERARDO C. ', 'METER READER II', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:29:59', '2025-05-23 03:29:59'),
(254, 'S', 'Regular', 'Active', 'CORONEL, NOEL D. ', 'SENIOR BOOKKEEPER', '', '', '', '', '', 0, 'Male', '1961-07-18', '', '', '2025-05-23 03:44:36', '2025-05-23 03:44:36'),
(255, 'T', 'Regular', 'Active', 'DACSLA, SITTIE AISHA M. ', 'CLERK III', '', '', '', '', '', 0, 'Female', NULL, '', '', '2025-05-23 03:05:29', '2025-05-23 03:05:29'),
(256, 'U', 'Regular', 'Active', 'DAJAO, ELMER G. ', 'WELL DRILLER II', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:15:35', '2025-05-23 03:15:35'),
(257, 'V', 'Regular', 'Active', 'DALAYAO, LOQUITO T. ', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1970-10-17', '', '', '2025-05-23 03:40:20', '2025-05-23 03:40:20'),
(258, 'W', 'Regular', 'Active', 'DELA CRUZ, JOHN RYAN C. ', 'SPVNG ADMIN OFFICER', '', '', '', '', '', 0, 'Male', '1983-01-02', '', '', '2025-05-23 03:37:11', '2025-05-23 03:37:11'),
(259, 'X', 'Regular', 'Active', 'DELOS REYES, PABLO III P. ', 'WELL DRILLER II', '', '', '', '', '', 0, 'Male', '1965-04-23', '', '', '2025-05-23 03:47:28', '2025-05-23 03:47:28'),
(260, 'Y', 'Regular', 'Active', 'EVANGELISTA, RYNAN L. ', 'PLUMBER II', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:09:26', '2025-05-23 03:09:26'),
(261, 'Z', 'Regular', 'Active', 'FERNANDEZ, FERDINAND V. ', 'WELL DRILLER II', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:23:11', '2025-05-23 03:23:11'),
(262, 'AA', 'Regular', 'Active', 'GUMADLAS, GODOFREDO D.  JR.', 'PLUMBER II', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 02:00:42', '2025-05-23 02:00:42'),
(263, 'AB', 'Regular', 'Active', 'GUMISONG, DENNIS P. ', 'ENGINEERING ASSISTANT', '', '', '', '', '', 0, 'Male', '0000-00-00', '', '', '2025-05-23 03:35:04', '2025-05-23 03:35:04'),
(264, 'AC', 'Regular', 'Active', 'GURO, FAIDAH A. ', 'METER READER I', '', '', '', '', '', 0, 'Female', NULL, '', '', '2025-05-23 03:16:14', '2025-05-23 03:16:14'),
(265, 'AD', 'Regular', 'Active', 'INTALIGANDO, STEPHEN M. ', 'PLUMBER II', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:04:40', '2025-05-23 03:04:40'),
(266, 'AE', 'Regular', 'Active', 'ISEK, FREDDERICK B. ', 'ENGINEERING ASSISTANT', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:29:12', '2025-05-23 03:29:12'),
(267, 'AF', 'Regular', 'Active', 'JIMENA, LARRY A. ', 'ENGINEERING ASSISTANT', '', '', '', '', '', 0, 'Male', '1983-12-06', '', '', '2025-05-23 03:36:37', '2025-05-23 03:36:37'),
(268, 'AG', 'Regular', 'Active', 'LONOY, GLENDON B. ', 'WELL DRILLER I', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:30:37', '2025-05-23 03:30:37'),
(269, 'AH', 'Regular', 'Active', 'LONOY, RAFAEL A. ', 'MECHANIC III', '', '', '', '', '', 0, 'Male', '1964-02-26', '', '', '2025-05-23 03:47:49', '2025-05-23 03:47:49'),
(270, 'AI', 'Regular', 'Active', 'LUNA, JAY S. ', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1972-02-17', '', '', '2025-05-23 03:39:59', '2025-05-23 03:39:59'),
(271, 'AJ', 'Regular', 'Active', 'MAATA, EDELL D. ', 'INFO. TECH OFFICER', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:09:51', '2025-05-23 03:09:51'),
(272, 'AK', 'Regular', 'Active', 'MANATA, EDGARDO A. ', 'PLUMBER II', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:10:09', '2025-05-23 03:10:09'),
(273, 'AL', 'Regular', 'Active', 'MONTANCES, EDWIN M. ', 'ENGINEER III', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:12:45', '2025-05-23 03:12:45'),
(274, 'AM', 'Regular', 'Active', 'MUÑASQUE, DERWIN B. ', 'PIPEFITTER FOREMAN', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:09:03', '2025-05-23 03:09:03'),
(275, 'AN', 'Regular', 'Active', 'NATINGA, RONALDO S. ', 'PLUMBER II', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:12:58', '2025-05-23 03:12:58'),
(276, 'AO', 'Regular', 'Active', 'NUNEZ, ZENUN NAZ C. ', 'WELL DRILLER I', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:01:28', '2025-05-23 03:01:28'),
(277, 'AP', 'Regular', 'Active', 'ONDEN, MICHAEL P. ', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1981-02-24', '', '', '2025-05-23 03:44:54', '2025-05-23 03:44:54'),
(278, 'AQ', 'Regular', 'Active', 'REYES, HUBERT G. ', 'ENGINEER III', '', '', '', '', '', 0, 'Male', '0000-00-00', '', '', '2025-05-23 03:35:25', '2025-05-23 03:35:25'),
(279, 'AR', 'Regular', 'Active', 'ROXAS, RANULFO B. ', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1964-09-11', '', '', '2025-05-23 03:48:30', '2025-05-23 03:48:30'),
(280, 'AS', 'Regular', 'Active', 'RUBIO, LOUBELLE O. ', 'ACCOUNTING CLERK III', '', '', '', '', '', 0, 'Female', '1971-12-28', '', '', '2025-05-23 03:41:14', '2025-05-23 03:41:14'),
(281, 'AT', 'Regular', 'Active', 'SABUERO, LARRY H. ', 'PLUMBER II', '', '', '', '', '', 0, 'Male', '1975-01-01', '', '', '2025-05-23 03:36:17', '2025-05-23 03:36:17'),
(282, 'AU', 'Regular', 'Active', 'SATO, JAIME C. ', 'CITY GOV\'T DEPT HEAD II', '', '', '', '', '', 0, 'Male', '1960-11-27', '', '', '2025-05-23 03:35:51', '2025-05-23 03:35:51'),
(283, 'AV', 'Regular', 'Active', 'SEARES, SHERWIN P. ', 'PLUMBER II', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:07:28', '2025-05-23 03:07:28'),
(284, 'AW', 'Regular', 'Active', 'SEROJE, VIRGILIO V. ', 'PLUMBER II', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:02:47', '2025-05-23 03:02:47'),
(285, 'AX', 'Regular', 'Active', 'TORRES, MIGUELITO B. ', 'METER READER II', '', '', '', '', '', 0, 'Male', '1972-01-29', '', '', '2025-05-23 03:44:20', '2025-05-23 03:44:20'),
(286, 'AY', 'Regular', 'Active', 'TUCODAN, SAKINA M. ', 'METER READER II', '', '', '', '', '', 0, 'Female', NULL, '', '', '2025-05-23 03:08:05', '2025-05-23 03:08:05'),
(287, 'AZ', 'Regular', 'Active', 'TUMANDA, JERRY RUEL L. ', 'MECHANIC II', '', '', '', '', '', 0, 'Male', '1979-05-01', '', '', '2025-05-23 03:37:27', '2025-05-23 03:37:27'),
(288, 'BA', 'Regular', 'Active', 'VALDEMOZA, RICHARD L. ', 'WELL DRILLER I', '', '', '', '', '', 0, 'Male', '1993-02-09', '', '', '2025-05-23 03:48:09', '2025-05-23 03:48:09'),
(289, 'BB', 'Regular', 'Active', 'VILLACIN, GLENN C. ', 'ENGINEER I', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:31:11', '2025-05-23 03:31:11'),
(290, 'BC', 'Regular', 'Active', 'ZAYAS, MARVIN S. ', 'MECHANIC II', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:08:56', '2025-05-23 03:08:56'),
(291, 'ICWSJ001ADMIN', 'Job Order', 'Active', 'ABIOL, MIRAFLOR P. ', 'Administrative Assistant V', '', '', '', '', 'Administrative and Planning Division', 9174586320, 'Female', '1982-09-22', 'BRGY. HINAPLANON', '', '2025-05-23 03:35:26', '2025-05-23 03:35:26'),
(292, 'BE', 'Job Order', 'Active', 'JUNAIMA B. ACTUB', 'Administrative Assistant VI', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Female', '1982-04-24', 'BRGY. PALAO', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(293, 'BF', 'Job Order', 'Active', 'RITCHEL L. ARCEGA', 'Administrative Assistant V', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Female', '1973-08-14', 'BRGY. HINAPLANON', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(294, 'BG', 'Job Order', 'Active', 'AMOR, WENIFREDA F. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1983-11-02', 'BRGY. PALAO', '', '2025-05-23 03:01:56', '2025-05-23 03:01:56'),
(295, 'BH', 'Job Order', 'Active', 'CUBAR, CLARIENCE B. ', 'Administrative Assistant VI', '', '', '', '', '', 0, 'Female', '1984-12-25', 'BRGY. DEL CARMEN', '', '2025-05-23 03:57:50', '2025-05-23 03:57:50'),
(296, 'ICWSJ002ADMIN', 'Job Order', 'Active', 'LU, EMMA C. ', 'Administrative Assistant V', '', 'ADMIN', '', '', 'Administrative and Planning Division', 99999999999, 'Female', '1967-08-12', 'BRGY. LUINAB', '', '2025-05-23 07:11:41', '2025-05-23 07:11:41'),
(297, 'BJ', 'Job Order', 'Active', 'MAGLASANG, RYAN ANTHONY E. ', 'Administrative Assistant VI (Guard)', '', '', '', '', '', 0, 'Male', '1983-04-15', 'BRGY. SAN MIGUEL', '', '2025-05-23 03:09:42', '2025-05-23 03:09:42'),
(298, 'BK', 'Job Order', 'Active', 'MUNDALA, FELIX SR. ', 'Administrative Assistant V (Guard)', '', '', '', '', '', 0, 'Male', '1998-08-13', 'BRGY. HINAPLANON', '', '2025-05-23 07:17:01', '2025-05-23 07:17:01'),
(299, 'BL', 'Job Order', 'Active', 'MARIA CECILIA C. MUTYA', 'Senior Administrative Assistant IV', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Female', '2000-01-30', 'BRGY. SARAY', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(300, 'BM', 'Job Order', 'Active', 'REUYAN, TEODELITA P. ', 'Administrative Assistant V', '', '', '', '', '', 0, 'Female', NULL, 'BRGY. BAGONG SILANG', '', '2025-05-23 03:04:23', '2025-05-23 03:04:23'),
(301, 'BN', 'Job Order', 'Active', 'SATO, CHRISTIANNE JAMES L. ', 'Administrative Assistant VI (Guard)', '', '', '', '', '', 0, 'Male', NULL, 'BRGY. PALAO', '', '2025-05-23 03:57:11', '2025-05-23 03:57:11'),
(302, 'BO', 'Job Order', 'Active', 'REY A. BALONGAG', 'Administrative Assistant VI', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Male', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(303, 'BP', 'Job Order', 'Active', 'HELEN E. NADAYAG', 'Senior Administrative Assistant IV', '', '', '', '', 'ADMINISTRATIVE AND PLANNING', 0, 'Female', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(304, 'BQ', 'Job Order', 'Active', 'JEFFRY N. ECHAVEZ', 'Senior Administrative Assistant I', '', '', '', '', 'ENGINEERING AND PLANNING', 0, 'Male', '1975-05-01', 'BRGY. TAMBO HINAPLANON', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(305, 'BR', 'Job Order', 'Active', 'JUANITO R. REMEDIOS', 'Admininistrative Assistant V', '', '', '', '', 'ENGINEERING AND PLANNING', 0, 'Male', '1969-03-02', 'BRGY. TUBOD', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(306, 'BS', 'Job Order', 'Active', 'REUYAN, FERNANIE C. ', 'Senior Admininistrative Assistant II', '', '', '', '', '', 0, 'Female', '1966-11-11', 'BRGY. TIPANOY', '', '2025-05-23 07:17:45', '2025-05-23 07:17:45'),
(307, 'BT', 'Job Order', 'Active', 'AMANODIN JR., ENSUGO O. ', 'Senior Administrative Assistant II', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 07:12:59', '2025-05-23 07:12:59'),
(308, 'BU', 'Job Order', 'Active', 'JOSEPH B. KIRIT', '', '', '', '', '', 'ENGINEERING AND PLANNING', 0, 'Male', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(309, 'BV', 'Job Order', 'Active', 'ABA-A, YOLANDO S. ', 'Administrative Assistant VI', '', '', '', '', '', 0, 'Male', '1947-12-22', 'BRGY. PALAO', '', '2025-05-23 03:31:16', '2025-05-23 03:31:16'),
(310, 'BW', 'Job Order', 'Active', 'KEVIN ZAR A. AGCAOILI', 'Administrative Assistant V', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', '1990-02-23', 'BRGY. SUAREZ', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(311, 'BX', 'Job Order', 'Active', 'LENELYN S. ASO', 'Administrative Assistant III', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', '1966-01-20', 'BRGY. TIPANOY', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(312, 'BY', 'Job Order', 'Active', 'BALABA, CHERRIEL T. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Female', '1971-01-03', 'BRGY. DITUCALAN', '', '2025-05-23 03:56:43', '2025-05-23 03:56:43'),
(313, 'BZ', 'Job Order', 'Active', 'BARDOQUILLO, FARRAH M. ', 'Administrative Assistant V', '', '', '', '', '', 0, 'Female', '1974-07-31', 'BRGY. DITUCALAN', '', '2025-05-23 07:14:40', '2025-05-23 07:14:40'),
(314, 'CA', 'Job Order', 'Active', 'LENIE B. BINERBA', 'Administrative Assistant V', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', '1977-04-23', 'BRGY. POBLACION', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(315, 'CB', 'Job Order', 'Active', 'MARIA BUSTAMANTE', 'Administrative Assistant III', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', '1991-11-14', 'BRGY. UBALDO LAYA', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(316, 'CC', 'Job Order', 'Active', 'MARK E. CABELLO', 'Administrative Assistant V', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(317, 'CD', 'Job Order', 'Active', 'JAY G. CAMINONG', 'Administrative Assistant VI', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', '1980-04-15', 'BRGY. TIPANOY', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(318, 'CE', 'Job Order', 'Active', 'CORRO, ALAN A. ', 'Administrative Assistant V', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', '1988-07-13', 'BRGY. SARAY', '', '2025-05-23 01:40:51', '2025-05-23 01:40:51'),
(319, 'CF', 'Job Order', 'Active', 'JOEY L. DOROTHEO', 'Administrative Assistant VI', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', '1958-12-16', 'BRGY. MARIA CRISTINA', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(320, 'CG', 'Job Order', 'Active', 'ESLIT, DOREEN O. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1974-02-26', 'BRGY. SAN ROQUE', '', '2025-05-23 04:03:08', '2025-05-23 04:03:08'),
(321, 'CH', 'Job Order', 'Active', 'NOEL A. FERIANILA', 'Administrative Assistant IV', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', '1985-03-09', 'BRGY. TUBOD', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(322, 'CI', 'Job Order', 'Active', 'MARICHU B. FERRER', 'Administrative Assistant III', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(323, 'CJ', 'Job Order', 'Active', 'FLORES, ROUTEL P. ', 'Administrative Assistant III', '', '', '', '', '', 0, '', NULL, '', '', '2025-05-23 03:10:48', '2025-05-23 03:10:48'),
(324, 'CK', 'Job Order', 'Active', 'HENSIS, GILBERT ', 'Administrative Assistant V', '', '', '', '', '', 0, 'Male', '1975-07-27', 'BRGY. TIPANOY', '', '2025-05-23 07:19:33', '2025-05-23 07:19:33'),
(325, 'CL', 'Job Order', 'Active', 'MONTEROLA, DELMA M. ', 'Administrative Assistant VI', '', '', '', '', '', 0, 'Female', '1983-01-13', 'BRGY. TIPANOY', '', '2025-05-23 04:01:54', '2025-05-23 04:01:54'),
(326, 'CM', 'Job Order', 'Active', 'NANAMAN, ARTURO R. ', 'Administrative Assistant V', '', '', '', '', 'Customer Services Division', 0, 'Male', NULL, '', '', '2025-05-23 02:16:00', '2025-05-23 02:16:00'),
(327, 'CN', 'Job Order', 'Active', 'NARBASA, ROSEVEL P. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:11:22', '2025-05-23 03:11:22'),
(328, 'CO', 'Job Order', 'Active', 'GIL B. PABLEO', 'Administrative Assistant IV', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', '1959-03-26', 'BRGY. TIPANOY', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(329, 'CP', 'Job Order', 'Active', 'MAYVILLE C. PADAYHAG', 'Senior Administrative Assistant I', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', '1992-03-07', 'BRGY. TIPANOY', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(330, 'CQ', 'Job Order', 'Active', 'JENALYN D. PORRAS', 'Administrative Assistant III', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(331, 'CR', 'Job Order', 'Active', 'RIZA P. RESTOJAS', 'Administrative Assistant III', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Female', '1989-05-21', 'BRGY. TIPANOY', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(332, 'CS', 'Job Order', 'Active', 'LIZAMIL A. TABA', 'Administrative Assistant IV', '', '', '', '', 'CUSTOMER SERVICE', 0, 'Male', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(333, 'CT', 'Job Order', 'Active', 'MICAH NIÑA S. VILLANUEVA', 'Administrative Assistant IV', '', '', '', '', '', 0, 'Female', NULL, '', '', '2025-05-23 02:17:04', '2025-05-23 02:17:04'),
(334, 'CU', 'Job Order', 'Active', 'QUIMADA, AMELITA C. ', 'Administrative Assistant IV', '', '', '', '', '', 0, 'Female', NULL, '', '', '2025-05-23 01:47:15', '2025-05-23 01:47:15'),
(335, 'CV', 'Job Order', 'Active', 'ALBAÑO, YOLANDA O. ', 'Senior Administrative Assistant I', '', '', '', '', '', 0, 'Female', NULL, '', '', '2025-05-23 02:17:38', '2025-05-23 02:17:38'),
(336, 'CW', 'Job Order', 'Active', 'ALFECHE, ARMANDO L. ', 'Senior Administrative Assistant III', '', '', '', '', 'Waterworks Planning and Engineering Division', 0, 'Female', '1968-10-22', 'BRGY. MARIA CRISTINA', '', '2025-05-24 09:45:13', '2025-05-24 09:45:13'),
(337, 'CX', 'Job Order', 'Active', 'JOHN RYAN L. ALFECHE', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1966-09-02', 'BRGY. DITUCALAN', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(338, 'CY', 'Job Order', 'Active', 'RICHARD M. AMBITO', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1998-08-12', 'BRGY. DITUCALAN', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(339, 'CZ', 'Job Order', 'Active', 'JOHN CARLO S. BATITAO', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1977-10-30', 'BRGY. DITUCALAN', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(340, 'DA', 'Job Order', 'Active', 'CABOL, ELMER JR C. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1999-12-16', 'BRGY.MAHAYAHAY', '', '2025-05-23 07:08:39', '2025-05-23 07:08:39'),
(341, 'DB', 'Job Order', 'Active', 'CANTINA, ALFONSO A. ', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1995-10-26', 'BRGY. DITUCALAN', '', '2025-05-23 01:41:29', '2025-05-23 01:41:29'),
(342, 'DC', 'Job Order', 'Active', 'EMBORONG, CECILIO C. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1953-11-20', 'BRGY. MARIA CRISTINA', '', '2025-05-23 03:55:14', '2025-05-23 03:55:14'),
(343, 'DD', 'Job Order', 'Active', 'JONATHAN ESCOTO', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1972-02-14', 'BRGY. STA ELENA', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(344, 'DE', 'Job Order', 'Active', 'RJ CHRISTIAN A. JAGONIO', 'Supervising Administrative Officer', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '0960-03-13', 'BRGY. TIPANOY', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(345, 'DF', 'Job Order', 'Active', 'JAIME E. JAYLO', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1978-12-25', 'BRGY. PALAO', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(346, 'DG', 'Job Order', 'Active', 'LARGADO, ENRIQUE H. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1965-01-14', 'BRGY. HINAPLANON', '', '2025-05-23 07:13:19', '2025-05-23 07:13:19'),
(347, 'DH', 'Job Order', 'Active', 'RODY A. LEGASPI', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1980-03-31', 'BRGY. UBALDO LAYA', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(348, 'DI', 'Job Order', 'Active', 'ROEL L. LOPERA', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1959-08-05', 'Brgy. Tipanoy', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(349, 'DJ', 'Job Order', 'Active', 'MINDAYA P. MACALA', 'Senior Administrative Assistant I', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Male', '1971-07-21', 'Brgy. Lambaguhon', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(350, 'DK', 'Job Order', 'Active', 'NESTOR C. NEMENSO', 'Administrative Assistant III', '', '', '', '', 'PLANNING AND ENGINEERING', 0, 'Female', '1968-09-05', 'Brgy. Tubod', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(351, 'DL', 'Job Order', 'Active', 'VERGARA, ROLANDO C. ', 'Administrative Assistant V', '', '', '', '', '', 0, 'Male', '1971-08-02', 'Brgy. Ditucalan', '', '2025-05-23 03:16:17', '2025-05-23 03:16:17'),
(352, 'DM', 'Job Order', 'Active', 'ABIAN, SOFRONIO M. ', 'Administrative Assistant III', '', '', '', '', '', 0, '', NULL, '', '', '2025-05-23 03:04:58', '2025-05-23 03:04:58'),
(353, 'DN', 'Job Order', 'Active', 'JULIAN V. ACTUB', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, '', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(354, 'DO', 'Job Order', 'Active', 'ACMAD, CLAUDIO C. ', 'Administrative Assistant III', '', '', '', '', '', 0, '', NULL, '', '', '2025-05-23 03:59:16', '2025-05-23 03:59:16'),
(355, 'DP', 'Job Order', 'Active', 'ADMAIN, ABEL T. ', 'Senior Administrative Assistant II', '', '', '', '', 'PRODUCTION', 0, 'Male', '1969-07-15', 'BRGY. HINAPLANON', '', '2025-05-23 01:40:07', '2025-05-23 01:40:07'),
(356, 'DQ', 'Job Order', 'Active', 'ADMAIN, CAMSARY T. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Female', '1960-11-16', 'BRGY. HINAPLANON', '', '2025-05-23 03:54:29', '2025-05-23 03:54:29'),
(357, 'DR', 'Job Order', 'Active', 'JEHARIM M. ALAWI', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1974-04-12', 'BRGY. TAMBACAN', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(358, 'DS', 'Job Order', 'Active', 'MERLO JOHN T. ALSONADO', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, '', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(359, 'DT', 'Job Order', 'Active', 'AMAMANGPANG, EMILIO ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1989-04-17', 'BRGY. MARIA CRISTINA', '', '2025-05-23 07:10:53', '2025-05-23 07:10:53'),
(360, 'DU', 'Job Order', 'Active', 'AMPUAN, ALI ', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1962-11-10', 'BRGY. DITUCALAN', '', '2025-05-23 01:41:42', '2025-05-23 01:41:42'),
(361, 'DV', 'Job Order', 'Active', 'ASIS, ASHNAWI A. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1965-06-16', 'BRGY. BALOI', '', '2025-05-23 02:19:32', '2025-05-23 02:19:32'),
(362, 'DW', 'Job Order', 'Active', 'BADO, EDGAR N. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1982-09-27', 'BRGY. TUBOD', '', '2025-05-23 04:03:39', '2025-05-23 04:03:39'),
(363, 'DX', 'Job Order', 'Active', 'BADO, RUEL E. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1960-06-29', 'BRGY. HINAPLANON', '', '2025-05-23 03:10:17', '2025-05-23 03:10:17'),
(364, 'DY', 'Job Order', 'Active', 'BADO, ZENITH A. ', 'Administrative Assistant III', '', '', '', '', '', 0, '', NULL, '', '', '2025-05-23 03:01:41', '2025-05-23 03:01:41'),
(365, 'DZ', 'Job Order', 'Active', 'MARIBEL M. BARIOGA', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1976-11-07', 'BRGY. UPPER HINAPLANON', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(366, 'EA', 'Job Order', 'Active', 'BARUANG, SOBAIR D. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Female', '1967-02-02', 'BRGY. HINAPLANON', '', '2025-05-23 03:05:14', '2025-05-23 03:05:14'),
(367, 'EB', 'Job Order', 'Active', 'JUNREY C. BOOC', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(368, 'EC', 'Job Order', 'Active', 'RAMILITO R. CABALLERO', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1981-10-20', 'BRGY. UPPER TOMINOBO', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(369, 'ED', 'Job Order', 'Active', 'REY A. CABANILLA', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1979-12-05', 'BRGY. LUINAB', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(370, 'EE', 'Job Order', 'Active', 'MIGUEL B. CABILI', 'Administrative Assistant VI', '', '', '', '', 'PRODUCTION', 0, 'Male', '1971-09-01', 'BRGY. UPPER TOMINOBO', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(371, 'EF', 'Job Order', 'Active', 'CADIVIDA, WEDELYN P. ', 'Senior Administrative Assistant V', '', '', '', '', '', 0, 'Male', '1960-09-03', 'BRGY. TIPANOY', '', '2025-05-23 03:02:26', '2025-05-23 03:02:26'),
(372, 'EG', 'Job Order', 'Active', 'MARLONY. CAITOM', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Female', '1987-06-20', 'BRGY. STO. ROSARIO', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(373, 'EH', 'Job Order', 'Active', 'CALABIO, SEITH ELIJAH C. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1983-03-10', 'BRGY. TOMAS CABILI', '', '2025-05-23 03:06:14', '2025-05-23 03:06:14'),
(374, 'EI', 'Job Order', 'Active', 'RICKY M. CALISO', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, '', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(375, 'EJ', 'Job Order', 'Active', 'CANETE, ERIC T. ', 'Administrative Assistant III', '', '', '', '', '', 0, '', NULL, '', '', '2025-05-23 07:13:46', '2025-05-23 07:13:46'),
(376, 'EK', 'Job Order', 'Active', 'CANOY, BENVINIDO C. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '2001-08-13', 'BRGY. DITUCALAN', '', '2025-05-23 03:00:17', '2025-05-23 03:00:17'),
(377, 'EL', 'Job Order', 'Active', 'CANOY, BOYET C. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1976-02-17', 'BRGY. DITUCALAN', '', '2025-05-23 03:54:05', '2025-05-23 03:54:05'),
(378, 'EM', 'Job Order', 'Active', 'CANOY, EDMON L.', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1979-11-11', 'BRGY. DITUCALAN', '', '2025-05-23 04:05:23', '2025-05-23 04:05:23'),
(379, 'EN', 'Job Order', 'Active', 'CANTILA, ROMEL C. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1992-09-22', 'BRGY. DITUCALAN', '', '2025-05-23 03:15:27', '2025-05-23 03:15:27'),
(380, 'EO', 'Job Order', 'Active', 'CANTILA, ZOSIMO T.', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:00:40', '2025-05-23 03:00:40'),
(381, 'EP', 'Job Order', 'Active', 'CAPAL, ANUAR M. ', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1984-03-03', 'BRGY. DITUCALAN', '', '2025-05-23 01:48:12', '2025-05-23 01:48:12'),
(382, 'EQ', 'Job Order', 'Active', 'CATAMBACAN, VICENTE T. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1961-01-01', 'BRGY. DITUCALAN', '', '2025-05-23 03:03:05', '2025-05-23 03:03:05'),
(383, 'ER', 'Job Order', 'Active', 'JACK L. CORDOVA', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1963-08-01', 'BRGY. UPPER TOMINOBO', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(384, 'ES', 'Job Order', 'Active', 'CRISTORIA, ELVIE M. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 07:10:32', '2025-05-23 07:10:32'),
(385, 'ET', 'Job Order', 'Active', 'DACSLA, COSAIN M. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Female', '1968-10-18', 'BRGY. TOMAS CABILI', '', '2025-05-23 03:59:52', '2025-05-23 03:59:52'),
(386, 'EU', 'Job Order', 'Active', 'MOH\'D HAMID D. DACSLA', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1995-08-18', 'BRGY. MARIA CRISTINA', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(387, 'EV', 'Job Order', 'Active', 'DACSLA, SIRAD JR. M.', 'Administrative Assistant V', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:05:55', '2025-05-23 03:05:55'),
(388, 'EW', 'Job Order', 'Active', 'DURAN, EFIEDO P. ', 'Administrative Assistant VI', '', '', '', '', '', 0, 'Male', '1992-12-11', 'BRGY. MARIA CRISTINA', '', '2025-05-23 04:05:24', '2025-05-23 04:05:24'),
(389, 'EX', 'Job Order', 'Active', 'LOUIE JAYLO S. ESCARAN', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1982-05-13', 'BRGY. DITUCALAN', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(390, 'EY', 'Job Order', 'Active', 'JEAN B. ESTO', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1959-10-23', 'BRGY. MARIA CRISTINA', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(391, 'EZ', 'Job Order', 'Active', 'GENERALAO, ANTONIO N. ', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1990-08-05', 'BRGY. TIPANOY', '', '2025-05-23 01:47:53', '2025-05-23 01:47:53'),
(392, 'FA', 'Job Order', 'Active', 'GUMBA, DONATO B. ', 'Administrative Assistant VI', '', '', '', '', '', 0, 'Male', NULL, 'BRGY. UPPER TOMINOBO', '', '2025-05-23 04:03:03', '2025-05-23 04:03:03'),
(393, 'FB', 'Job Order', 'Active', 'MARIO WARLITO A. IMPAT', 'Administrative Assistant VI', '', '', '', '', 'PRODUCTION', 0, 'Male', '1965-07-30', 'BRGY. MARIA CRISTINA', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(394, 'FC', 'Job Order', 'Active', 'LABIAN, BENITA B. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1961-05-06', 'BRGY. KIWALAN', '', '2025-05-23 02:18:13', '2025-05-23 02:18:13'),
(395, 'FD', 'Job Order', 'Active', 'LAHOYLAHOY, DINDO D. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Female', '1955-04-14', 'BRGY. DALIPUGA', '', '2025-05-23 04:02:24', '2025-05-23 04:02:24'),
(396, 'FE', 'Job Order', 'Active', 'LOBATON, ELIZALDE C. ', 'Administrative Assistant IV', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 07:10:10', '2025-05-23 07:10:10'),
(397, 'FF', 'Job Order', 'Active', 'MACALANDONG, SAYPODIEN T. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Female', '1983-11-15', 'BRGY. DEL CARMEN', '', '2025-05-23 03:06:30', '2025-05-23 03:06:30'),
(398, 'FG', 'Job Order', 'Active', 'MANOS, FELIPA ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Female', '1964-07-08', 'BRGY. DITUCALAN', '', '2025-05-23 07:14:57', '2025-05-23 07:14:57'),
(399, 'FH', 'Job Order', 'Active', 'NHIKIE BOY C. MAQUILAN', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, '', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(400, 'FI', 'Job Order', 'Active', 'MATA, RONILLO A. ', 'Administrative Assistant VI', '', '', '', '', '', 0, 'Female', '1959-06-07', 'BRGY. DALIPUGA', '', '2025-05-23 03:12:37', '2025-05-23 03:12:37'),
(401, 'FJ', 'Job Order', 'Active', 'MICAYABAS, FELIX JR. D. ', 'Administrative Assistant VI', '', '', '', '', '', 0, 'Male', '1979-11-08', 'BRGY. HINAPLANON', '', '2025-05-23 07:15:33', '2025-05-23 07:15:33'),
(402, 'FK', 'Job Order', 'Active', 'METCHIL B. MONTESA', 'Administrative Assistant VI', '', '', '', '', 'PRODUCTION', 0, 'Male', '1956-11-10', 'BRGY. MARIA CRISTINA', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(403, 'FL', 'Job Order', 'Active', 'NIELSON B. NIETES', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, '', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(404, 'FM', 'Job Order', 'Active', 'OBACH, ARVIN REY D.', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1977-11-06', 'BRGY. HINAPLANON', '', '2025-05-23 02:16:29', '2025-05-23 02:16:29'),
(405, 'FN', 'Job Order', 'Active', 'JERWYNN D. OBACH', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1972-08-05', 'BRGY. TOMINOBO', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(406, 'FO', 'Job Order', 'Active', 'RODOLFO D. OBACH', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1978-01-05', 'BRGY. TOMINOBO', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(407, 'FP', 'Job Order', 'Active', 'OUANO, ROSALINO S. ', 'Administrative Assistant VI', '', '', '', '', '', 0, 'Male', '1981-11-01', 'BRGY. TOMAS CABILI', '', '2025-05-23 03:11:38', '2025-05-23 03:11:38'),
(408, 'FQ', 'Job Order', 'Active', 'LORETO R. PAGALING', 'Administrative Assistant VI', '', '', '', '', 'PRODUCTION', 0, 'Male', '1954-10-02', 'BRGY. STA FILOMENA', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(409, 'FR', 'Job Order', 'Active', 'PEPITO, BILL RONALD A. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', NULL, 'BRGY. STA FILOMENA', '', '2025-05-23 03:53:42', '2025-05-23 03:53:42'),
(410, 'FS', 'Job Order', 'Active', 'PONCE, JOVANNE H. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1959-05-05', 'BRGY. MARIA CRISTINA', '', '2025-05-23 07:18:26', '2025-05-23 07:18:26'),
(411, 'FT', 'Job Order', 'Active', 'RATERTA JR., DOMINGO M. ', 'Administrative Assistant III', '', '', '', '', '', 0, '', NULL, '', '', '2025-05-23 04:02:43', '2025-05-23 04:02:43'),
(412, 'FU', 'Job Order', 'Active', 'RAUDE, ROY O. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1983-11-08', 'BRGY. MARIA CRISTINA', '', '2025-05-23 03:10:32', '2025-05-23 03:10:32'),
(413, 'FV', 'Job Order', 'Active', 'JONATHAN D. SANCHEZ', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1981-11-15', 'BRGY. SUAREZ', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(414, 'FW', 'Job Order', 'Active', 'JETHRO D. SILAO', 'Administrative Assistant IV', '', '', '', '', 'PRODUCTION', 0, 'Male', '1992-02-24', 'BRGY. DITUCALAN', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(415, 'FX', 'Job Order', 'Active', 'SOLANO, GIOVANNI ', 'Administrative Assistant IV', '', '', '', '', '', 0, 'Male', '1958-06-14', 'BRGY. MARIA CRISTINA', '', '2025-05-23 07:19:52', '2025-05-23 07:19:52'),
(416, 'FY', 'Job Order', 'Active', 'TABEROS, CERILO JR. T. ', 'Administrative Assistant IV', '', '', '', '', '', 0, 'Male', '1981-07-19', 'BRGY. DITUCALAN', '', '2025-05-23 03:55:54', '2025-05-23 03:55:54'),
(417, 'FZ', 'Job Order', 'Active', 'TANGGO, ALINOR L.', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1963-09-23', 'BRGY. DITUCALAN', '', '2025-05-23 01:42:14', '2025-05-23 01:42:14'),
(418, 'GA', 'Job Order', 'Active', 'RODULFO P. VARGAS', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(419, 'GB', 'Job Order', 'Active', 'JOSE VERGARA', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1959-07-20', 'BRGY. UPPER TOMINOBO', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(420, 'GC', 'Job Order', 'Active', 'VERGARA, JOSE', 'Administrative Assistant III', '', '', '', '', 'PRODUCTION', 0, 'Male', '1977-12-02', 'BRY. SAN ROQUE', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(421, 'GD', 'Job Order', 'Active', 'CABILI, JONIZ V.', '', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 04:00:30', '2025-05-23 04:00:30'),
(422, 'GE', 'Job Order', 'Active', 'ABUEME, RONALD L. ', 'Administrative Assistant IV', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:13:12', '2025-05-23 03:13:12'),
(423, 'GF', 'Job Order', 'Active', 'ACTUB, EDISON S. ', 'Administrative Assistant IV', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 04:04:49', '2025-05-23 04:04:49'),
(424, 'GG', 'Job Order', 'Active', 'ACTUB, FELIPE C. ', 'Administrative Assistant IV', '', '', '', '', '', 0, 'Male', '1969-10-05', 'BRGY. STA FELOMINA', '', '2025-05-23 07:15:15', '2025-05-23 07:15:15'),
(425, 'GH', 'Job Order', 'Active', 'JUNALYN V. ACTUB', 'Senior Administrative Assistant III', '', '', '', '', 'OPERATION', 0, 'Female', '1992-06-19', 'BRGY. TIBANGA', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(426, 'GI', 'Job Order', 'Active', 'AGOSTO, ZOREN DAVE A. ', 'Administrative Assistant III', '', '', '', '', '', 0, '', NULL, '', '', '2025-05-23 03:01:01', '2025-05-23 03:01:01'),
(427, 'GJ', 'Job Order', 'Active', 'JESSIE S. AMBALONG', 'Administrative Assistant III', '', '', '', '', 'OPERATION', 0, 'Male', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(428, 'GK', 'Job Order', 'Active', 'BACARA, ANTONIO L. ', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, 'Male', '1966-05-11', 'BRGY. TIPANOY', '', '2025-05-23 01:47:40', '2025-05-23 01:47:40'),
(429, 'GL', 'Job Order', 'Active', 'LOUIS PHILIP V. BAULA', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1995-04-02', 'BRGY. TUBOD', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(430, 'GM', 'Job Order', 'Active', 'RICARDO BERNAT', 'Administrative Assistant V', '', '', '', '', 'OPERATION', 0, 'Male', '1965-01-21', 'BRGY. PALAO', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(431, 'GN', 'Job Order', 'Active', 'CABILTES, RONNIE A. ', 'Administrative Assistant I', '', '', '', '', '', 0, 'Male', '1974-01-04', 'BRGY. TIPANOY', '', '2025-05-23 03:12:16', '2025-05-23 03:12:16'),
(432, 'GO', 'Job Order', 'Active', 'JOAR J. CABTALAN', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1962-08-24', 'BRGY. DEL CARMEN', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(433, 'GP', 'Job Order', 'Active', 'RICKY D. CALIMPON', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1976-01-04', 'BRGY. VILLA VERDE', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(434, 'GQ', 'Job Order', 'Active', 'HERJIFRE C. CHATTO', 'Senior Administrative Assistant V', '', '', '', '', 'OPERATION', 0, 'Female', '1966-05-29', 'BRGY. TIBANGA', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(435, 'GR', 'Job Order', 'Active', 'DACSLA, FAHDIYAH M. ', 'Senior Administrative Assistant III', '', '', '', '', '', 0, 'Female', '1994-06-23', 'BRGY. MARIA CRISTINA', '', '2025-05-23 07:14:20', '2025-05-23 07:14:20'),
(436, 'GS', 'Job Order', 'Active', 'LUIS T. DEL PILAR', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1962-08-25', 'BRGY. DITUCALAN', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(437, 'GT', 'Job Order', 'Active', 'NOZART B. DELOS REYES', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, 'Male', '1973-12-05', 'BRGY. TIPANOY', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(438, 'GU', 'Job Order', 'Active', 'DELOS REYES, TRAZON III B. ', 'Administrative Assistant III', '', '', '', '', '', 0, '', NULL, '', '', '2025-05-23 03:04:09', '2025-05-23 03:04:09'),
(439, 'GV', 'Job Order', 'Active', 'MARIO C. EDOSMA', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1963-06-08', 'BRGY. VILLA VERDE', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(440, 'GW', 'Job Order', 'Active', 'NESTOR JR. B. ELECION', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, 'Male', '1989-10-27', 'BRGY. PALAO', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(441, 'GX', 'Job Order', 'Active', 'EJARA, EDGARDO R.', 'Administrative Assistant IV', '', '', '', '', '', 0, 'Male', '1963-05-07', 'BRGY. HINAPLANON', '', '2025-05-23 04:04:11', '2025-05-23 04:04:11'),
(442, 'GY', 'Job Order', 'Active', 'JASPHER IAN  V. ENTICA', 'Administrative Assistant III', '', '', '', '', 'OPERATION', 0, '', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(443, 'GZ', 'Job Order', 'Active', 'FERNANDEZ, RUSTY EMMANUEL G. ', 'Administrative Assistant IV', '', '', '', '', '', 0, 'Male', '1972-11-14', 'BRGY. TUBOD', '', '2025-05-23 03:09:58', '2025-05-23 03:09:58'),
(444, 'HA', 'Job Order', 'Active', 'GARCIA, FERNANDO A. ', 'Administrative Assistant III', '', '', '', '', '', 0, '', NULL, '', '', '2025-05-23 07:16:01', '2025-05-23 07:16:01'),
(445, 'HB', 'Job Order', 'Active', 'JUDE GAYOSA', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, '', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(446, 'HC', 'Job Order', 'Active', 'GUINIT, CANDELARIO B. ', ' Senior Administrative Assistant V', '', '', '', '', '', 0, 'Male', NULL, '', '', '2025-05-23 03:53:13', '2025-05-23 03:53:13'),
(447, 'HD', 'Job Order', 'Active', 'GALLETO, EDISON B. ', ' Senior Administrative Assistant V', '', '', '', '', '', 0, 'Male', '1969-10-16', 'BRGY. TAMBACAN', '', '2025-05-23 04:04:33', '2025-05-23 04:04:33'),
(448, 'HE', 'Job Order', 'Active', 'JOVEN I. GENERALAO', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1977-10-15', 'BRGY. DITUCALAN', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(449, 'HF', 'Job Order', 'Active', 'IGLUPAS, JUSSEF DANES P.', 'Administrative Assistant III', '', '', '', '', 'OPERATION', 0, '', '1971-07-09', 'BRGY.TIPANOY', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(450, 'HG', 'Job Order', 'Active', 'IGLUPAS, ELFRED N. ', 'Administrative Assistant III', '', '', '', '', '', 0, '', NULL, '', '', '2025-05-23 04:05:45', '2025-05-23 04:05:45'),
(451, 'HH', 'Job Order', 'Active', 'MANSUETO D. MAATA ', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, '', '1960-10-09', 'BRGY. PALAO', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(452, 'HI', 'Job Order', 'Active', 'JOEY A. MIGUELA', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, '', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(453, 'HJ', 'Job Order', 'Active', 'JOEL L. PASCUA', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1969-10-13', 'BRGY. ABUNO', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(454, 'HK', 'Job Order', 'Active', 'REYES, ELMER B. ', 'Administrative Assistant IV', '', '', '', '', '', 0, 'Male', '1956-08-01', 'BRGY. FUENTES', '', '2025-05-23 07:08:16', '2025-05-23 07:08:16'),
(455, 'HL', 'Job Order', 'Active', 'RIVERA, CESAR L. ', 'Administrative Assistant IV', '', '', '', '', '', 0, '', '1976-07-28', 'BRGY. TIPANOY', '', '2025-05-23 03:56:21', '2025-05-23 03:56:21'),
(456, 'HM', 'Job Order', 'Active', 'ROLANDO A. SABADUQUIA', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, 'Male', '1963-07-18', 'BRGY. TUBOD', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(457, 'HN', 'Job Order', 'Active', 'SALGADO, GIOVANNIE S. ', 'Administrative Assistant IV', '', '', '', '', '', 0, '', NULL, '', '', '2025-05-23 07:19:17', '2025-05-23 07:19:17'),
(458, 'HO', 'Job Order', 'Active', 'RODULFO SARANZA', 'Administrative Assistant I', '', '', '', '', 'OPERATION', 0, 'Male', '1979-12-06', 'BRGY. POBLACION', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(459, 'HP', 'Job Order', 'Active', 'RAMON JR. C. SENAJON', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, '', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(460, 'HQ', 'Job Order', 'Active', 'JAMES LEMAR G. SURBAN', 'Administrative Assistant IV', '', '', '', '', 'OPERATION', 0, '', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(461, 'HR', 'Job Order', 'Active', 'TIGLAO, DANIEL A. ', 'Administrative Assistant I', '', '', '', '', '', 0, 'Male', '1962-12-18', 'BRGY. TIPANOY', '', '2025-05-23 04:01:30', '2025-05-23 04:01:30'),
(462, 'HS', 'Job Order', 'Active', 'JOSE JR. G. TUBIL', 'Supervising Administrative Officer', '', '', '', '', 'OPERATION', 0, 'Male', '1957-07-16', 'BRGY. TOMAS CABILI', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(463, 'HT', 'Job Order', 'Active', 'VELASCO, CRISANTIN R. ', 'Administrative Assistant III', '', '', '', '', '', 0, 'Male', '1983-07-15', 'BRGY. HINAPLANON', '', '2025-05-23 04:01:05', '2025-05-23 04:01:05'),
(464, 'HU', 'Job Order', 'Active', 'VELORIA, CREZ JOUIE', 'Administrative Assistant III', '', '', '', '', 'OPERATION', 0, 'Female', '1998-01-17', 'BRGY. TAMBACAN', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(465, 'HV', 'Job Order', 'Active', 'VISTO, ROSSDALE JOHN I.', '', '', '', '', '', '', 0, '', NULL, '', '', '2025-05-23 01:39:30', '2025-05-23 01:39:30'),
(466, 'IA', 'Contract', 'Active', 'CABAC, LORENA L. ', 'Engineer III', '', '', '', '', '', 0, 'Female', '1990-07-06', 'BRGY.PALAO', '', '2025-05-23 02:04:59', '2025-05-23 02:04:59'),
(467, 'IB', 'Contract', 'Active', 'SONIDO, FELIX JR C. ', 'Focal Person', '', '', '', '', '', 0, 'Male', '1955-09-09', '', '', '2025-05-23 02:04:44', '2025-05-23 02:04:44'),
(468, 'IC', 'Contract', 'Active', 'ONG, JOSE II R. ', 'Administrative Assistant IV', '', '', '', '', '', 0, 'Male', '1969-05-05', 'BRGY. TIPANOY', '', '2025-05-23 02:05:15', '2025-05-23 02:05:15'),
(469, 'ICWSR056', 'Regular', 'Active', 'MOLO, MAHDI STEVEN J. ', 'LOCAL ASSESSMENT OPERATION OFFICER II', '', '', '', '', 'Operations Division', 9158976607, 'Male', '1980-05-27', 'PALA-O, ILIGAN CITY', '', '2025-05-23 03:48:14', '2025-05-23 03:48:14');

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
(58, 236, 58, 69, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(59, 237, 59, 41, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(60, 238, 60, 0, 0.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(61, 239, 61, 27, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(62, 240, 62, 33, 2000.00, '2025-05-23 01:39:16', '2025-05-23 03:51:34'),
(63, 241, 63, 32, 2000.00, '2025-05-23 01:39:16', '2025-05-23 04:02:56'),
(64, 242, 64, 25, 0.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(65, 243, 65, 78, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(66, 244, 66, 30, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(67, 245, 67, 0, 0.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(68, 246, 68, 67, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(69, 247, 69, 0, 0.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(70, 248, 70, 0, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(71, 249, 71, 66, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(72, 250, 72, 54, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(73, 251, 73, 62, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(74, 252, 74, 61, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(75, 253, 75, 43, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(76, 254, 76, 5, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(77, 255, 77, 0, 0.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(78, 256, 78, 57, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(79, 257, 79, 48, 0.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(80, 258, 80, 90, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(81, 259, 81, 53, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(82, 260, 82, 34, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(83, 261, 83, 56, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(84, 262, 84, 36, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(85, 263, 85, 16, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(86, 264, 86, 63, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(87, 265, 87, 29, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(88, 266, 88, 15, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(89, 267, 89, 12, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(90, 268, 90, 64, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(91, 269, 91, 60, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(92, 270, 92, 18, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(93, 271, 93, 68, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(94, 272, 94, 31, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(95, 273, 95, 13, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(96, 274, 96, 52, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(97, 275, 97, 28, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(98, 276, 98, 59, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(99, 277, 99, 37, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(100, 278, 100, 8, 0.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(101, 279, 101, 38, 0.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(102, 280, 102, 70, 0.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(103, 281, 103, 44, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(104, 282, 104, 1, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(105, 283, 105, 21, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(106, 284, 106, 47, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(107, 285, 107, 42, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(108, 286, 108, 77, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(109, 287, 109, 88, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(110, 288, 110, 55, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(111, 289, 111, 39, 2000.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(112, 290, 112, 0, 0.00, '2025-05-23 01:39:16', '2025-05-23 01:39:16'),
(113, 469, 113, 1, 2000.00, '2025-05-23 02:36:57', '2025-05-23 02:36:57');

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
(58, 236, 8, 2, '1', 20720.00, '2025-05-23 03:23:28', '2025-05-23 03:23:28'),
(59, 237, 9, 5, '1', 23162.00, '2025-05-23 03:21:40', '2025-05-23 03:21:40'),
(60, 238, 4, 0, '0', 16209.00, '2025-05-23 03:43:51', '2025-05-23 03:43:51'),
(61, 239, 10, 2, '1', 24585.00, '2025-05-23 03:38:57', '2025-05-23 03:38:57'),
(62, 240, 3, 1, '1', 15265.00, '2025-05-23 03:51:34', '2025-05-23 03:51:34'),
(63, 241, 5, 1, '1', 17205.00, '2025-05-23 04:02:56', '2025-05-23 04:02:56'),
(64, 242, 0, 0, '0', 0.00, '2025-05-23 03:15:12', '2025-05-23 03:15:12'),
(65, 243, 6, 2, '0', 18396.00, '2025-05-23 01:40:30', '2025-05-23 01:40:30'),
(66, 244, 5, 2, '0', 17338.00, '2025-05-23 03:08:09', '2025-05-23 03:08:09'),
(67, 245, 11, 0, '0', 28512.00, '2025-05-23 03:36:54', '2025-05-23 03:36:54'),
(68, 246, 6, 2, '0', 18396.00, '2025-05-23 03:02:13', '2025-05-23 03:02:13'),
(69, 247, 3, 0, '0', 15265.00, '2025-05-23 03:39:40', '2025-05-23 03:39:40'),
(70, 248, 22, 2, '0', 75952.00, '2025-05-23 03:40:38', '2025-05-23 03:40:38'),
(71, 249, 6, 2, '0', 18396.00, '2025-05-23 03:07:06', '2025-05-23 03:07:06'),
(72, 250, 3, 2, '0', 15384.00, '2025-05-23 01:59:14', '2025-05-23 01:59:14'),
(73, 251, 5, 8, '0', 18151.00, '2025-05-23 03:30:17', '2025-05-23 03:30:17'),
(74, 252, 3, 2, '0', 15384.00, '2025-05-23 03:00:22', '2025-05-23 03:00:22'),
(75, 253, 6, 2, '0', 18255.00, '2025-05-23 03:29:59', '2025-05-23 03:29:59'),
(76, 254, 9, 2, '0', 22404.00, '2025-05-23 03:44:36', '2025-05-23 03:44:36'),
(77, 255, 6, 0, '0', 18.00, '2025-05-23 03:05:29', '2025-05-23 03:05:29'),
(78, 256, 5, 1, '0', 17338.00, '2025-05-23 03:15:35', '2025-05-23 03:15:35'),
(79, 257, 5, 0, '0', 17205.00, '2025-05-23 03:40:20', '2025-05-23 03:40:20'),
(80, 258, 22, 8, '0', 74836.00, '2025-05-23 03:37:11', '2025-05-23 03:37:11'),
(81, 259, 5, 5, '0', 18151.00, '2025-05-23 03:47:28', '2025-05-23 03:47:28'),
(82, 260, 5, 8, '0', 17739.00, '2025-05-23 03:09:26', '2025-05-23 03:09:26'),
(83, 261, 5, 3, '0', 17739.00, '2025-05-23 03:23:11', '2025-05-23 03:23:11'),
(84, 262, 5, 2, '0', 17739.00, '2025-05-23 02:00:42', '2025-05-23 02:00:42'),
(85, 263, 8, 5, '0', 20720.00, '2025-05-23 03:08:39', '2025-05-23 03:08:39'),
(86, 264, 4, 5, '0', 16714.00, '2025-05-23 03:16:14', '2025-05-23 03:16:14'),
(87, 265, 5, 2, '0', 17739.00, '2025-05-23 03:04:40', '2025-05-23 03:04:40'),
(88, 266, 8, 2, '0', 20720.00, '2025-05-23 03:29:12', '2025-05-23 03:29:12'),
(89, 267, 8, 2, '0', 20720.00, '2025-05-23 03:36:37', '2025-05-23 03:36:37'),
(90, 268, 3, 2, '0', 15384.00, '2025-05-23 03:30:37', '2025-05-23 03:30:37'),
(91, 269, 9, 5, '0', 22404.00, '2025-05-23 03:47:49', '2025-05-23 03:47:49'),
(92, 270, 5, 8, '0', 17739.00, '2025-05-23 03:39:59', '2025-05-23 03:39:59'),
(93, 271, 22, 5, '0', 82999.00, '2025-05-23 03:09:51', '2025-05-23 03:09:51'),
(94, 272, 5, 2, '0', 17739.00, '2025-05-23 03:10:09', '2025-05-23 03:10:09'),
(95, 273, 19, 2, '0', 54649.00, '2025-05-23 03:12:45', '2025-05-23 03:12:45'),
(96, 274, 8, 8, '0', 20720.00, '2025-05-23 03:09:03', '2025-05-23 03:09:03'),
(97, 275, 5, 2, '0', 18151.00, '2025-05-23 03:12:58', '2025-05-23 03:12:58'),
(98, 276, 3, 2, '0', 15384.00, '2025-05-23 03:01:28', '2025-05-23 03:01:28'),
(99, 277, 5, 2, '0', 17338.00, '2025-05-23 03:44:54', '2025-05-23 03:44:54'),
(100, 278, 5, 0, '0', 53873.00, '2025-05-23 03:35:25', '2025-05-23 03:35:25'),
(101, 279, 8, 0, '0', 17338.00, '2025-05-23 03:48:30', '2025-05-23 03:48:30'),
(102, 280, 5, 0, '0', 20534.00, '2025-05-23 03:41:14', '2025-05-23 03:41:14'),
(103, 281, 5, 2, '0', 17338.00, '2025-05-23 03:36:17', '2025-05-23 03:36:17'),
(104, 282, 22, 2, '0', 75952.00, '2025-05-23 03:35:51', '2025-05-23 03:35:51'),
(105, 283, 5, 5, '0', 17739.00, '2025-05-23 03:07:28', '2025-05-23 03:07:28'),
(106, 284, 5, 2, '0', 17338.00, '2025-05-23 03:02:47', '2025-05-23 03:02:47'),
(107, 285, 6, 8, '0', 19261.00, '2025-05-23 03:44:20', '2025-05-23 03:44:20'),
(108, 286, 6, 8, '0', 19261.00, '2025-05-23 03:08:05', '2025-05-23 03:08:05'),
(109, 287, 6, 2, '0', 18396.00, '2025-05-23 03:37:27', '2025-05-23 03:37:27'),
(110, 288, 3, 2, '0', 15384.00, '2025-05-23 03:48:09', '2025-05-23 03:48:09'),
(111, 289, 12, 1, '0', 30705.00, '2025-05-23 03:31:11', '2025-05-23 03:31:11'),
(112, 290, 6, 0, '0', 18.00, '2025-05-23 03:08:56', '2025-05-23 03:08:56'),
(113, 469, 16, 2, '3', 0.00, '2025-05-23 03:48:14', '2025-05-23 03:48:14');

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

--
-- Dumping data for table `service_record`
--

INSERT INTO `service_record` (`record_id`, `personnel_id`, `startDate`, `endDate`, `position`, `company`) VALUES
(1, 236, '2010-08-12', '2014-08-07', 'METRO AIDE I', 'CEMO'),
(2, 236, '2014-08-08', '2021-01-31', 'METRO AIDE II', 'CEMO'),
(3, 236, '2021-02-01', '2025-05-28', 'ACCOUNTING CLERK III', 'ICWS'),
(4, 237, '1999-12-31', '2009-01-01', 'METER READER II', 'ICWS'),
(5, 237, '2009-12-31', '2025-05-23', 'METER READER III', 'ICWS'),
(6, 469, '2023-09-04', '2024-12-04', 'LOCAL ASSESSMENT OPERATION OFFICER II', 'CASSO'),
(7, 469, '2024-12-05', '2025-05-23', 'LOCAL ASSESSMENT OPERATION OFFICER II', 'ICWS'),
(8, 240, '2025-02-10', '2025-05-23', 'PLUMBER I', 'ICWS'),
(9, 239, '1998-11-02', '2020-01-01', 'PLUMBER II', 'ICWS'),
(10, 241, '2025-02-10', '2025-05-23', 'PLUMBER II', 'ICWS');

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
-- Indexes for table `jo_work_experience`
--
ALTER TABLE `jo_work_experience`
  ADD PRIMARY KEY (`experience_id`),
  ADD KEY `personnel_id` (`personnel_id`) USING BTREE;

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
  MODIFY `certificatecomp_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `contractservice_record`
--
ALTER TABLE `contractservice_record`
  MODIFY `serviceRecord_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contract_service`
--
ALTER TABLE `contract_service`
  MODIFY `contractservice_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `intern`
--
ALTER TABLE `intern`
  MODIFY `intern_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `job_order`
--
ALTER TABLE `job_order`
  MODIFY `jo_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=351;

--
-- AUTO_INCREMENT for table `jo_work_experience`
--
ALTER TABLE `jo_work_experience`
  MODIFY `experience_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `personnel_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=470;

--
-- AUTO_INCREMENT for table `reg_emp`
--
ALTER TABLE `reg_emp`
  MODIFY `regEmp_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `salary_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `service_record`
--
ALTER TABLE `service_record`
  MODIFY `record_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- Constraints for table `jo_work_experience`
--
ALTER TABLE `jo_work_experience`
  ADD CONSTRAINT `jo_work_experience_ibfk_1` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`personnel_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
