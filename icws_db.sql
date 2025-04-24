-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2025 at 04:45 AM
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
  `jobOrder_id` int(5) DEFAULT NULL,
  `startingDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `ActJust` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contract_service`
--

CREATE TABLE `contract_service` (
  `contractservice_id` int(5) NOT NULL,
  `personnel_id` int(5) DEFAULT NULL,
  `salaryRate` decimal(10,2) DEFAULT NULL,
  `yearsService` int(11) DEFAULT NULL,
  `contractStart` date DEFAULT NULL,
  `contractEnd` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intern`
--

CREATE TABLE `intern` (
  `intern_id` int(5) NOT NULL,
  `fullName` varchar(255) DEFAULT NULL,
  `contactNo` varchar(255) DEFAULT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `job_order`
--

CREATE TABLE `job_order` (
  `jo_id` int(5) NOT NULL,
  `personnel_id` int(5) DEFAULT NULL,
  `salary_id` int(5) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personnel`
--

CREATE TABLE `personnel` (
  `personnel_id` int(5) NOT NULL,
  `Emp_No` varchar(10) NOT NULL,
  `emp_type` enum('Regular','Job Order','Contract') NOT NULL,
  `emp_status` enum('Active','Inactive') NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `division` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `sex` enum('Male','Female') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personnel`
--

INSERT INTO `personnel` (`personnel_id`, `Emp_No`, `emp_type`, `emp_status`, `full_name`, `position`, `division`, `contact_number`, `sex`, `birthdate`, `address`, `createdAt`, `updatedAt`) VALUES
(1, 'ICWS-001', 'Regular', 'Active', 'Maxine Lesondra', 'Developer', '13/23/2002', '963812', 'Female', '0000-00-00', 'Luinab, Iligan City', '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(2, 'ICWS-002', 'Regular', 'Active', 'Kathleen Holt', 'Admin Assistant', 'IT', '771755', 'Male', '0000-00-00', '056 Kelly Isle, Lisahaven, HI 94416', '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(3, 'ICWS-003', 'Regular', 'Active', 'Chad Moore', 'Developer', 'Finance', '151009', 'Female', '0000-00-00', '461 Norman Brooks, West Margaretton, KS 65426', '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(4, 'ICWS-004', 'Regular', 'Active', 'Lauren Taylor', 'Developer', 'HR', '444422', 'Female', '0000-00-00', 'USNV Perez, FPO AA 02296', '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(5, 'ICWS-005', 'Regular', 'Active', 'James Lopez', 'Data Analyst', 'IT', '593672', 'Female', '0000-00-00', 'PSC 4607, Box 2904, APO AA 03478', '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(6, 'ICWS-006', 'Regular', 'Active', 'Madison Perkins', 'Engineer', 'HR', '790992', 'Female', '0000-00-00', '9500 Roy Bypass, West Alexanderstad, IN 35607', '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(7, 'ICWS-007', 'Regular', 'Active', 'Deborah Davis', 'Coordinator', 'IT', '311124', 'Male', '0000-00-00', '9602 Ryan Fords Suite 775, Sharonport, MI 68753', '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(8, 'ICWS-008', 'Regular', 'Active', 'Zachary Saunders', 'Developer', 'IT', '693448', 'Female', '0000-00-00', '6668 Reyes Forks Suite 687, Lopeztown, NM 48872', '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(9, 'ICWS-009', 'Regular', 'Active', 'Anthony Owens', 'Developer', 'HR', '900550', 'Female', '0000-00-00', '320 Jonathan Brook, Lake Brittanyport, HI 43453', '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(10, 'ICWS-010', 'Regular', 'Active', 'Todd Meza', 'Data Analyst', 'Finance', '703541', 'Female', '0000-00-00', '070 Salinas Plains, Davidland, AL 48234', '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(11, 'ICWS-011', 'Regular', 'Active', 'Katie Juarez', 'Engineer', 'HR', '807567', 'Female', '0000-00-00', '119 Ross Trail Suite 472, North Kurt, AZ 52066', '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(12, 'ICWS-012', 'Regular', 'Active', 'Mrs. Christina Lawrence', 'Admin Assistant', 'Logistics', '763515', 'Male', '0000-00-00', '367 Kimberly Ville Suite 777, Brendahaven, MT 10096', '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(13, 'ICWS-013', 'Regular', 'Active', 'Emily Mills', 'Engineer', 'Logistics', '575549', 'Male', '0000-00-00', '2341 Chelsea Shore, Travisshire, OH 18952', '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(14, 'ICWS-014', 'Regular', 'Active', 'Deborah Burke', 'Admin Assistant', 'HR', '277641', 'Male', '0000-00-00', '6065 Lopez Track Apt. 388, Denniston, ND 81988', '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(15, 'ICWS-015', 'Regular', 'Active', 'Philip Perez', 'Engineer', 'HR', '839751', 'Female', '0000-00-00', '248 Jones Turnpike, Stokesville, WV 89136', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(16, 'ICWS-016', 'Regular', 'Active', 'Roberto Hansen', 'Data Analyst', 'Finance', '509867', 'Female', '0000-00-00', '794 Andrews Springs Suite 663, Jeremyberg, TN 41354', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(17, 'ICWS-017', 'Regular', 'Active', 'Anthony Aguilar', 'Data Analyst', 'Operations', '150289', 'Female', '0000-00-00', '4131 Ronnie Rue Suite 349, North Kimberlyfurt, DE 69381', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(18, 'ICWS-018', 'Regular', 'Active', 'Heather Carney', 'Developer', 'Operations', '127821', 'Male', '0000-00-00', '5423 Edwin Curve, Alexanderside, WA 85738', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(19, 'ICWS-019', 'Regular', 'Active', 'Stephanie Rush', 'Coordinator', 'Operations', '855725', 'Female', '0000-00-00', '164 Erica Dale Apt. 429, East Johnnyview, MS 96428', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(20, 'ICWS-020', 'Regular', 'Active', 'Patricia Lee', 'Developer', 'HR', '173992', 'Female', '0000-00-00', '59231 Amber Burgs, Wandatown, MS 09352', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(21, 'ICWS-021', 'Regular', 'Active', 'James Smith', 'Data Analyst', 'IT', '969642', 'Male', '0000-00-00', '783 Juan Courts, Wallacechester, LA 87372', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(22, 'ICWS-022', 'Regular', 'Active', 'Mary Norris', 'Data Analyst', 'Finance', '703226', 'Female', '0000-00-00', '377 Rocha Parks Apt. 987, Christinaville, WA 05021', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(23, 'ICWS-023', 'Regular', 'Active', 'Scott Ramirez', 'Engineer', 'Logistics', '384835', 'Female', '0000-00-00', '55280 Le Tunnel, New Kaitlyn, TX 54365', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(24, 'ICWS-024', 'Regular', 'Active', 'Dana Howell', 'Data Analyst', 'Operations', '940257', 'Female', '0000-00-00', '25111 Larry Pass Suite 875, Port Phillip, AZ 52170', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(25, 'ICWS-025', 'Regular', 'Active', 'Dylan Glover', 'Coordinator', 'Finance', '507719', 'Male', '0000-00-00', '48795 Laurie Turnpike Suite 554, North Patriciaport, AR 75528', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(26, 'ICWS-026', 'Regular', 'Active', 'Mark Mills', 'Data Analyst', 'IT', '823228', 'Female', '0000-00-00', '186 Harper Terrace Suite 279, Crawfordview, NM 33477', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(27, 'ICWS-027', 'Regular', 'Active', 'Matthew Brewer', 'Engineer', 'Finance', '378834', 'Male', '0000-00-00', '815 Ashley Road Apt. 431, New Royhaven, AR 23360', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(28, 'ICWS-028', 'Regular', 'Active', 'Tamara Smith', 'Coordinator', 'Logistics', '608690', 'Male', '0000-00-00', '7906 Bradshaw Cliff Apt. 678, East Larry, MA 58687', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(29, 'ICWS-029', 'Regular', 'Active', 'Danielle Price', 'Coordinator', 'Operations', '124447', 'Female', '0000-00-00', '22764 Quinn Curve, New Jeffrey, CO 68847', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(30, 'ICWS-030', 'Regular', 'Active', 'Todd Silva', 'Coordinator', 'HR', '901467', 'Male', '0000-00-00', '141 Sims Lock Apt. 581, South Kathryn, AZ 87615', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(31, 'ICWS-031', 'Regular', 'Active', 'Charles Jensen', 'Coordinator', 'IT', '181203', 'Female', '0000-00-00', '176 Daniel Loop, Staceyland, VA 39349', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(32, 'ICWS-032', 'Regular', 'Active', 'Kenneth Bell', 'Coordinator', 'IT', '303819', 'Female', '0000-00-00', '5027 Timothy Green Apt. 638, Thomasport, FL 58862', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(33, 'ICWS-033', 'Regular', 'Active', 'Mr. Michael Krueger', 'Coordinator', 'HR', '830521', 'Male', '0000-00-00', '2408 David Forge Suite 094, Jennaview, ME 84241', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(34, 'ICWS-034', 'Regular', 'Active', 'Brandon Mclean', 'Admin Assistant', 'HR', '429295', 'Male', '0000-00-00', '3834 Susan Roads, South Brandiport, MN 05547', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(35, 'ICWS-035', 'Regular', 'Active', 'Eric Ramirez', 'Coordinator', 'Operations', '553107', 'Male', '0000-00-00', '6030 Nicholas Branch, Castrotown, SD 83546', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(36, 'ICWS-036', 'Regular', 'Active', 'Paul Cole', 'Engineer', 'IT', '767886', 'Male', '0000-00-00', '15848 Sean Drive, Port Jacqueline, IA 30518', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(37, 'ICWS-037', 'Regular', 'Active', 'Kimberly Newman', 'Coordinator', 'Finance', '821795', 'Female', '0000-00-00', '3609 Martinez Tunnel, Jeffreymouth, IA 60240', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(38, 'ICWS-038', 'Regular', 'Active', 'Christopher Phillips', 'Engineer', 'IT', '480362', 'Female', '0000-00-00', '54904 Petersen Centers Suite 458, Navarroside, SD 37753', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(39, 'ICWS-039', 'Regular', 'Active', 'Michael Johnson', 'Coordinator', 'HR', '731375', 'Female', '0000-00-00', '27370 Miller Walk, Reevesmouth, MD 72845', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(40, 'ICWS-040', 'Regular', 'Active', 'Randall Peterson', 'Developer', 'Operations', '547812', 'Female', '0000-00-00', '04100 Wanda Locks, Gonzalezhaven, SC 26721', '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(41, 'ICWS-041', 'Regular', 'Active', 'Colleen Garcia', 'Engineer', 'HR', '735000', 'Male', '0000-00-00', '1833 Susan Falls Suite 093, West Stevenfort, CA 09972', '2025-04-23 08:10:18', '2025-04-23 08:10:18');

-- --------------------------------------------------------

--
-- Table structure for table `personnel_history`
--

CREATE TABLE `personnel_history` (
  `history_id` int(5) NOT NULL,
  `personnel_id` int(5) NOT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reg_emp`
--

CREATE TABLE `reg_emp` (
  `regEmp_id` int(5) NOT NULL,
  `personnel_id` int(5) DEFAULT NULL,
  `salary_id` int(5) DEFAULT NULL,
  `plantillaNo` int(5) DEFAULT NULL,
  `acaPera` int(5) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reg_emp`
--

INSERT INTO `reg_emp` (`regEmp_id`, `personnel_id`, `salary_id`, `plantillaNo`, `acaPera`, `createdAt`, `updatedAt`) VALUES
(145, 1, 147, 13, 3, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(146, 2, 148, 71, 1, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(147, 3, 149, 96, 5, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(148, 4, 150, 78, 1, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(149, 5, 151, 68, 3, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(150, 6, 152, 38, 5, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(151, 7, 153, 81, 5, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(152, 8, 154, 20, 3, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(153, 9, 155, 58, 2, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(154, 10, 156, 64, 3, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(155, 11, 157, 32, 1, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(156, 12, 158, 32, 1, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(157, 13, 159, 9, 3, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(158, 14, 160, 80, 2, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(159, 15, 161, 86, 4, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(160, 16, 162, 85, 3, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(161, 17, 163, 43, 5, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(162, 18, 164, 4, 1, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(163, 19, 165, 45, 1, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(164, 20, 166, 50, 2, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(165, 21, 167, 64, 5, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(166, 22, 168, 26, 5, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(167, 23, 169, 96, 3, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(168, 24, 170, 9, 4, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(169, 25, 171, 66, 3, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(170, 26, 172, 44, 2, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(171, 27, 173, 21, 3, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(172, 28, 174, 21, 4, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(173, 29, 175, 11, 3, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(174, 30, 176, 58, 5, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(175, 31, 177, 79, 2, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(176, 32, 178, 36, 2, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(177, 33, 179, 83, 5, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(178, 34, 180, 25, 5, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(179, 35, 181, 62, 3, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(180, 36, 182, 16, 2, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(181, 37, 183, 22, 1, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(182, 38, 184, 8, 2, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(183, 39, 185, 20, 5, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(184, 40, 186, 68, 4, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(185, 41, 187, 98, 5, '2025-04-23 08:10:18', '2025-04-23 08:10:18');

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `salary_id` int(5) NOT NULL,
  `personnel_id` int(5) DEFAULT NULL,
  `salaryGrade` int(2) DEFAULT NULL,
  `step` enum('1','2','3','4','5','6','7','8') DEFAULT NULL,
  `level` int(2) DEFAULT NULL,
  `monthlySalary` bigint(8) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`salary_id`, `personnel_id`, `salaryGrade`, `step`, `level`, `monthlySalary`, `createdAt`, `updatedAt`) VALUES
(147, 1, 2, '2', 2, 15035, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(148, 2, 22, '8', 1, 86369, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(149, 3, 27, '3', 1, 0, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(150, 4, 16, '1', 1, 0, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(151, 5, 7, '7', 2, 0, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(152, 6, 9, '3', 1, 0, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(153, 7, 25, '1', 2, 0, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(154, 8, 31, '2', 2, 0, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(155, 9, 13, '7', 2, 0, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(156, 10, 3, '5', 2, 0, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(157, 11, 17, '4', 2, 0, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(158, 12, 28, '7', 1, 0, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(159, 13, 4, '8', 2, 0, '2025-04-23 08:10:17', '2025-04-23 08:10:17'),
(160, 14, 13, '2', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(161, 15, 30, '2', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(162, 16, 33, '2', 1, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(163, 17, 19, '1', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(164, 18, 8, '2', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(165, 19, 31, '5', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(166, 20, 14, '5', 1, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(167, 21, 18, '3', 1, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(168, 22, 24, '5', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(169, 23, 1, '6', 1, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(170, 24, 3, '8', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(171, 25, 3, '4', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(172, 26, 18, '3', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(173, 27, 25, '6', 1, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(174, 28, 11, '7', 1, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(175, 29, 23, '3', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(176, 30, 21, '1', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(177, 31, 24, '5', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(178, 32, 25, '5', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(179, 33, 14, '7', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(180, 34, 13, '2', 1, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(181, 35, 7, '3', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(182, 36, 12, '6', 1, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(183, 37, 18, '5', 1, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(184, 38, 6, '8', 1, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(185, 39, 18, '7', 1, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(186, 40, 32, '3', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18'),
(187, 41, 31, '8', 2, 0, '2025-04-23 08:10:18', '2025-04-23 08:10:18');

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
  `email` varchar(32) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fullName` varchar(100) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `fullName`, `createdAt`, `updatedAt`, `remember_token`) VALUES
(1, 'thea@gmail.com', '123', 'Thea Ancog', '2025-04-04 03:33:39', '2025-04-21 04:49:28', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coc`
--
ALTER TABLE `coc`
  ADD PRIMARY KEY (`certificatecomp_id`),
  ADD KEY `jobOrder_id` (`jobOrder_id`);

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
  ADD KEY `personnel_id` (`personnel_id`),
  ADD KEY `salary_id` (`salary_id`);

--
-- Indexes for table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`personnel_id`);

--
-- Indexes for table `personnel_history`
--
ALTER TABLE `personnel_history`
  ADD PRIMARY KEY (`history_id`);

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
-- AUTO_INCREMENT for table `contract_service`
--
ALTER TABLE `contract_service`
  MODIFY `contractservice_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intern`
--
ALTER TABLE `intern`
  MODIFY `intern_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_order`
--
ALTER TABLE `job_order`
  MODIFY `jo_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `personnel_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `personnel_history`
--
ALTER TABLE `personnel_history`
  MODIFY `history_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reg_emp`
--
ALTER TABLE `reg_emp`
  MODIFY `regEmp_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `salary_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `service_record`
--
ALTER TABLE `service_record`
  MODIFY `record_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  ADD CONSTRAINT `coc_ibfk_1` FOREIGN KEY (`jobOrder_id`) REFERENCES `job_order` (`jo_id`);

--
-- Constraints for table `contract_service`
--
ALTER TABLE `contract_service`
  ADD CONSTRAINT `contract_service_ibfk_1` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`personnel_id`);

--
-- Constraints for table `job_order`
--
ALTER TABLE `job_order`
  ADD CONSTRAINT `job_order_ibfk_1` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`personnel_id`),
  ADD CONSTRAINT `job_order_ibfk_2` FOREIGN KEY (`salary_id`) REFERENCES `salary` (`salary_id`);

--
-- Constraints for table `reg_emp`
--
ALTER TABLE `reg_emp`
  ADD CONSTRAINT `reg_emp_ibfk_1` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`personnel_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reg_emp_ibfk_2` FOREIGN KEY (`salary_id`) REFERENCES `salary` (`salary_id`) ON DELETE CASCADE;

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
