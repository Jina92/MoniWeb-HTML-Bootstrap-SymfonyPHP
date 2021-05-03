-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3308
-- Generation Time: May 03, 2021 at 09:40 AM
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
  `LogId` int(11) UNSIGNED NOT NULL,
  `ClientIP` varchar(30) NOT NULL,
  `SessionId` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Username` varchar(50) NOT NULL,
  `PlanType` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `LogTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Action` varchar(50) NOT NULL,
  `ResponseCode` int(4) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `actionlog`
--

INSERT INTO `actionlog` (`LogId`, `ClientIP`, `SessionId`, `Username`, `PlanType`, `LogTime`, `Action`, `ResponseCode`) VALUES
(1, '::1', 'rpi0thf2p0m85lh2ee0lji38be', '', NULL, '2021-05-03 06:40:48', 'isloggedin', 401),
(2, '::1', 'rpi0thf2p0m85lh2ee0lji38be', '', NULL, '2021-05-03 06:40:50', 'isloggedin', 401),
(3, '::1', 'rpi0thf2p0m85lh2ee0lji38be', '', NULL, '2021-05-03 06:40:50', 'isloggedin', 401),
(4, '::1', 'rpi0thf2p0m85lh2ee0lji38be', '', NULL, '2021-05-03 06:40:51', 'isloggedin', 401),
(5, '::1', 'rpi0thf2p0m85lh2ee0lji38be', '', NULL, '2021-05-03 06:44:56', 'isloggedin', 401);

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
  `Theme` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Light',
  `RegisterDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
-- Indexes for dumped tables
--

--
-- Indexes for table `actionlog`
--
ALTER TABLE `actionlog`
  ADD PRIMARY KEY (`LogId`);

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
  MODIFY `LogId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customerplan`
--
ALTER TABLE `customerplan`
  MODIFY `CustomerPlanId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customerplanurl`
--
ALTER TABLE `customerplanurl`
  MODIFY `UrlId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monitorstatus`
--
ALTER TABLE `monitorstatus`
  MODIFY `StatusId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PaymentId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

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
