-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 09:32 AM
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
(1, 'ICWS 001', 'Regular', 'Active', 'Jielven Rose Baraquel', 'IT Officer', 'IT Division', '09361796032', 'Female', '1211-12-23', '23', '2025-04-20 04:53:49', '2025-04-20 04:53:49'),
(2, 'ICWS 002', 'Regular', 'Active', 'Maxine Joyce Lesondra', 'HR Officer', 'IT Division', '2', 'Female', '3211-02-23', '2', '2025-04-17 14:27:35', '2025-04-17 14:27:35'),
(3, 'ICWS 003', 'Regular', 'Active', 'Thea Ancog', 'HR Officer', 'IT Division', '32', 'Female', '3121-12-23', 'd', '2025-04-17 14:44:58', '2025-04-17 14:44:58'),
(4, 'ICWS 004', 'Regular', 'Active', 'Danny Boy Loberanes', 'HR Officer', 'IT Division', '232', 'Male', '0312-02-23', '2', '2025-04-20 02:42:27', '2025-04-20 02:42:27'),
(5, 'TMX 132', 'Regular', 'Active', 'Jielven', 'HR Officer', 'IT Division', '41', 'Female', '3433-03-24', 'yg', '2025-04-20 06:03:45', '2025-04-20 06:03:45'),
(6, 'FJS2', 'Regular', 'Active', 'Jielven Rose Baraquel', 'HR Officer', 'IT Division', '09361796032', 'Female', '2002-10-17', 'Magoong, Linamon, Lanao del Nrote', '2025-04-20 06:37:14', '2025-04-20 06:37:14');

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
(1, 7, 2, 232, 2, '2025-04-17 14:16:46', '2025-04-17 14:16:46'),
(2, 1, 4, 3, 0, '2025-04-17 14:27:13', '2025-04-20 04:27:24'),
(3, 2, 5, 232, 2, '2025-04-17 14:27:35', '2025-04-17 14:27:35'),
(4, 3, 6, 123, 2, '2025-04-17 14:44:58', '2025-04-17 14:44:58'),
(5, 4, 7, 123, 2, '2025-04-20 02:42:27', '2025-04-20 02:42:27'),
(6, 5, 8, 5, 2, '2025-04-20 06:03:45', '2025-04-20 06:03:45'),
(7, 6, 9, 0, 2, '2025-04-20 06:37:14', '2025-04-20 06:38:03');

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
(2, 7, 22, '', 0, 2, '2025-04-17 14:16:46', '2025-04-17 14:16:46'),
(3, 8, 2, '2', 2, 2, '2025-04-17 14:19:16', '2025-04-17 14:19:16'),
(4, 1, 0, '2', 2, 0, '2025-04-20 04:30:22', '2025-04-20 04:30:22'),
(5, 2, 2, '2', 2, 2, '2025-04-17 14:27:35', '2025-04-17 14:27:35'),
(6, 3, 2, '2', 2, 2, '2025-04-17 14:44:58', '2025-04-17 14:44:58'),
(7, 4, 2, '2', 2, 2, '2025-04-20 02:42:27', '2025-04-20 02:42:27'),
(8, 5, 2, '2', 2, 2, '2025-04-20 06:03:45', '2025-04-20 06:03:45'),
(9, 6, 2, '2', 2, 2, '2025-04-20 06:37:14', '2025-04-20 06:37:14');

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
  `division` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_record`
--

INSERT INTO `service_record` (`record_id`, `personnel_id`, `startDate`, `endDate`, `position`, `division`) VALUES
(29, 5, '2025-04-03', '2025-04-16', 'HR Assistant', 'HR '),
(30, 5, '2025-04-03', '2025-04-16', 'HR Assistant', 'HR '),
(31, 5, '2025-04-10', '2025-04-21', 'HR Assistant', 'HR '),
(32, 5, '2025-04-10', '2025-04-21', 'HR Assistant', 'HR '),
(33, 6, '2025-04-04', '2025-04-20', 'HR Assistant', 'HR ');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(5) NOT NULL,
  `email` varchar(32) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `createdAt`, `updatedAt`, `remember_token`) VALUES
(1, 'thea@gmail.com', '123', '2025-04-04 03:33:39', '2025-04-04 03:33:39', NULL);

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
  MODIFY `personnel_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personnel_history`
--
ALTER TABLE `personnel_history`
  MODIFY `history_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reg_emp`
--
ALTER TABLE `reg_emp`
  MODIFY `regEmp_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `salary_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `service_record`
--
ALTER TABLE `service_record`
  MODIFY `record_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
  ADD CONSTRAINT `reg_emp_ibfk_1` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`personnel_id`),
  ADD CONSTRAINT `reg_emp_ibfk_2` FOREIGN KEY (`salary_id`) REFERENCES `salary` (`salary_id`);

--
-- Constraints for table `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `fk_salary_personnel` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`personnel_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_record`
--
ALTER TABLE `service_record`
  ADD CONSTRAINT `personnel_id` FOREIGN KEY (`personnel_id`) REFERENCES `personnel` (`personnel_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
