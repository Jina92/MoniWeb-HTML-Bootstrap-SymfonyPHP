-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3308
-- Generation Time: Mar 28, 2021 at 11:46 PM
-- Server version: 8.0.18
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moniweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `actionlog`
--

CREATE TABLE `actionlog` (
  `StatusId` int(11) UNSIGNED NOT NULL,
  `UrlId` int(11) UNSIGNED DEFAULT NULL,
  `MonitorTime` timestamp NULL DEFAULT NULL,
  `ResultStatus` int(3) UNSIGNED DEFAULT NULL,
  `Description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerId` int(11) UNSIGNED NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `PhoneNo` varchar(15) NOT NULL,
  `Address` varchar(30) NOT NULL,
  `Suburb` varchar(20) DEFAULT NULL,
  `State` varchar(15) DEFAULT NULL,
  `Postcode` varchar(10) DEFAULT NULL,
  `Country` varchar(25) NOT NULL,
  `Theme` varchar(10) NOT NULL DEFAULT 'light',
  `RegisterDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerId`, `Email`, `Password`, `FirstName`, `LastName`, `PhoneNo`, `Address`, `Suburb`, `State`, `Postcode`, `Country`, `Theme`, `RegisterDate`) VALUES
(2, 'test@email.com', '$2y$10$CVvICv1siLHzVAKuHad3/eAQvLSN0QeftDdTJm8ALCGHzYkGGCqdi', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'Australia', 'light', '2021-03-26');

-- --------------------------------------------------------

--
-- Table structure for table `customerplan`
--

CREATE TABLE `customerplan` (
  `CustomerPlanId` int(11) UNSIGNED NOT NULL,
  `CustomerId` int(11) UNSIGNED DEFAULT NULL,
  `paymentId` int(11) UNSIGNED DEFAULT NULL,
  `PaidDate` date DEFAULT NULL,
  `Price` decimal(3,2) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `PlanId` int(5) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customerplan`
--

INSERT INTO `customerplan` (`CustomerPlanId`, `CustomerId`, `paymentId`, `PaidDate`, `Price`, `StartDate`, `EndDate`, `PlanId`) VALUES
(12, 2, NULL, NULL, NULL, '2021-03-26', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `customerplanurl`
--

CREATE TABLE `customerplanurl` (
  `UrlId` int(11) UNSIGNED NOT NULL,
  `URL` varchar(50) DEFAULT NULL,
  `IPaddress` varchar(30) DEFAULT NULL,
  `CustomerPlanId` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customerplanurl`
--

INSERT INTO `customerplanurl` (`UrlId`, `URL`, `IPaddress`, `CustomerPlanId`) VALUES
(14, 'google.com', NULL, 12),
(15, 'machbase.com', NULL, 12),
(16, 'tafe.edu.kr', NULL, 12),
(17, 'naver.com', NULL, 12),
(18, '', NULL, 12),
(19, NULL, NULL, 12),
(20, NULL, NULL, 12),
(21, NULL, NULL, 12),
(22, NULL, NULL, 12),
(23, NULL, NULL, 12),
(24, NULL, NULL, 12),
(25, NULL, NULL, 12),
(26, NULL, NULL, 12),
(27, NULL, NULL, 12),
(28, NULL, NULL, 12),
(29, NULL, NULL, 12),
(30, NULL, NULL, 12),
(31, NULL, NULL, 12),
(32, NULL, NULL, 12),
(33, NULL, NULL, 12),
(34, NULL, NULL, 12),
(35, NULL, NULL, 12),
(36, NULL, NULL, 12),
(37, NULL, NULL, 12),
(38, NULL, NULL, 12),
(39, NULL, NULL, 12),
(40, NULL, NULL, 12),
(41, NULL, NULL, 12),
(42, NULL, NULL, 12),
(43, NULL, NULL, 12),
(44, NULL, NULL, 12),
(45, NULL, NULL, 12),
(46, NULL, NULL, 12),
(47, NULL, NULL, 12),
(48, NULL, NULL, 12),
(49, NULL, NULL, 12),
(50, NULL, NULL, 12),
(51, NULL, NULL, 12),
(52, NULL, NULL, 12),
(53, NULL, NULL, 12),
(54, NULL, NULL, 12),
(55, NULL, NULL, 12),
(56, NULL, NULL, 12),
(57, NULL, NULL, 12),
(58, NULL, NULL, 12),
(59, NULL, NULL, 12),
(60, NULL, NULL, 12),
(61, NULL, NULL, 12),
(62, NULL, NULL, 12),
(63, NULL, NULL, 12);

-- --------------------------------------------------------

--
-- Table structure for table `monitorstatus`
--

CREATE TABLE `monitorstatus` (
  `StatusId` int(11) UNSIGNED NOT NULL,
  `UrlId` int(11) UNSIGNED DEFAULT NULL,
  `MonitorTime` timestamp NULL DEFAULT NULL,
  `ResultStatus` int(3) UNSIGNED DEFAULT NULL,
  `Description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `monitorstatus`
--

INSERT INTO `monitorstatus` (`StatusId`, `UrlId`, `MonitorTime`, `ResultStatus`, `Description`) VALUES
(1, 16, '2021-03-28 02:41:14', 6, 'Could not resolve host: tafe.edu.au'),
(2, 18, '2021-03-28 02:41:17', 3, ''),
(3, 16, '2021-03-28 02:43:32', 6, 'Could not resolve host: tafe.edu.au'),
(4, 18, '2021-03-28 02:43:35', 3, ''),
(5, 16, '2021-03-28 02:43:50', 6, 'Could not resolve host: tafe.edu.au'),
(6, 18, '2021-03-28 02:43:53', 3, ''),
(7, 16, '2021-03-28 02:45:59', 6, 'Could not resolve host: tafe.edu.au'),
(8, 18, '2021-03-28 02:46:02', 3, ''),
(9, 16, '2021-03-28 06:18:13', 6, 'Could not resolve host: tafe.edu.au'),
(10, 18, '2021-03-28 06:18:16', 3, ''),
(11, 16, '2021-03-28 06:19:54', 6, 'Could not resolve host: tafe.edu.au'),
(12, 18, '2021-03-28 06:19:56', 3, ''),
(13, 16, '2021-03-28 06:21:29', 6, 'Could not resolve host: tafe.edu.au'),
(14, 18, '2021-03-28 06:21:32', 3, ''),
(15, 16, '2021-03-28 06:21:40', 6, 'Could not resolve host: tafe.edu.au'),
(16, 18, '2021-03-28 06:21:43', 3, ''),
(17, 16, '2021-03-28 06:41:17', 6, 'Could not resolve host: tafe.edu.au'),
(18, 16, '2021-03-28 06:41:40', 6, 'Could not resolve host: tafe.edu.au'),
(19, 18, '2021-03-28 06:41:42', 3, ''),
(20, 16, '2021-03-28 11:58:00', 6, 'Could not resolve host: tafe.edu.kr'),
(21, 18, '2021-03-28 11:58:01', 3, ''),
(22, 16, '2021-03-28 11:59:36', 6, 'Could not resolve host: tafe.edu.kr'),
(23, 18, '2021-03-28 11:59:36', 3, ''),
(24, 16, '2021-03-28 12:01:16', 6, 'Could not resolve host: tafe.edu.kr'),
(25, 18, '2021-03-28 12:01:16', 3, ''),
(26, 16, '2021-03-28 12:01:24', 6, 'Could not resolve host: tafe.edu.kr'),
(27, 18, '2021-03-28 12:01:25', 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PaymentId` int(11) UNSIGNED NOT NULL,
  `CardNo` varchar(16) DEFAULT NULL,
  `ExpireDate` date DEFAULT NULL,
  `CCV` varchar(3) DEFAULT NULL,
  `NomeOnCard` varchar(30) DEFAULT NULL,
  `CustomerId` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE `plan` (
  `PlanId` int(5) UNSIGNED NOT NULL,
  `Type` varchar(30) DEFAULT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `MaxNumURL` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `CheckFrequency` int(3) DEFAULT NULL,
  `ReportPeriod` int(2) UNSIGNED DEFAULT NULL,
  `NotificationPeriod` int(1) UNSIGNED DEFAULT NULL,
  `NotificationMethod` int(1) UNSIGNED DEFAULT '1',
  `Price` decimal(5,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`PlanId`, `Type`, `Description`, `MaxNumURL`, `CheckFrequency`, `ReportPeriod`, `NotificationPeriod`, `NotificationMethod`, `Price`) VALUES
(1, 'Free', 'Default free plan', '5', 60, 1, 1, 1, '0.00'),
(2, 'Standard', ' Standard plan', '20', 10, 2, 2, 2, '5.00'),
(3, 'Premium', 'Premium plan', '50', 1, 3, 3, 2, '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE `temp` (
  `dt` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `temp`
--

INSERT INTO `temp` (`dt`) VALUES
('2021-03-21'),
('2021-03-21'),
('2021-03-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actionlog`
--
ALTER TABLE `actionlog`
  ADD PRIMARY KEY (`StatusId`),
  ADD KEY `fk_actionlog_customerplanurl` (`UrlId`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerId`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `customerplan`
--
ALTER TABLE `customerplan`
  ADD PRIMARY KEY (`CustomerPlanId`),
  ADD KEY `fk_cusomerplan_customer` (`CustomerId`),
  ADD KEY `fk_customerplan_payment` (`paymentId`),
  ADD KEY `fk_customerplan_plan` (`PlanId`);

--
-- Indexes for table `customerplanurl`
--
ALTER TABLE `customerplanurl`
  ADD PRIMARY KEY (`UrlId`),
  ADD KEY `fk_costomerplanurl_customerplan` (`CustomerPlanId`);

--
-- Indexes for table `monitorstatus`
--
ALTER TABLE `monitorstatus`
  ADD PRIMARY KEY (`StatusId`),
  ADD KEY `fk_mstatus_url` (`UrlId`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentId`),
  ADD KEY `fk_payment_customer` (`CustomerId`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`PlanId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actionlog`
--
ALTER TABLE `actionlog`
  MODIFY `StatusId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customerplan`
--
ALTER TABLE `customerplan`
  MODIFY `CustomerPlanId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customerplanurl`
--
ALTER TABLE `customerplanurl`
  MODIFY `UrlId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `monitorstatus`
--
ALTER TABLE `monitorstatus`
  MODIFY `StatusId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PaymentId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actionlog`
--
ALTER TABLE `actionlog`
  ADD CONSTRAINT `fk_actionlog_customerplanurl` FOREIGN KEY (`UrlId`) REFERENCES `customerplanurl` (`UrlId`);

--
-- Constraints for table `customerplan`
--
ALTER TABLE `customerplan`
  ADD CONSTRAINT `fk_cusomerplan_customer` FOREIGN KEY (`CustomerId`) REFERENCES `customer` (`CustomerId`),
  ADD CONSTRAINT `fk_customerplan_payment` FOREIGN KEY (`paymentId`) REFERENCES `payment` (`PaymentId`),
  ADD CONSTRAINT `fk_customerplan_plan` FOREIGN KEY (`PlanId`) REFERENCES `plan` (`PlanId`);

--
-- Constraints for table `customerplanurl`
--
ALTER TABLE `customerplanurl`
  ADD CONSTRAINT `fk_costomerplanurl_customerplan` FOREIGN KEY (`CustomerPlanId`) REFERENCES `customerplan` (`CustomerPlanId`);

--
-- Constraints for table `monitorstatus`
--
ALTER TABLE `monitorstatus`
  ADD CONSTRAINT `fk_mstatus_url` FOREIGN KEY (`UrlId`) REFERENCES `customerplanurl` (`UrlId`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_customer` FOREIGN KEY (`CustomerId`) REFERENCES `customer` (`CustomerId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
