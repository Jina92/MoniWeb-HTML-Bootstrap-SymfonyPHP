-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3308
-- Generation Time: Jun 08, 2021 at 01:21 PM
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
  `SessionId` varchar(100) DEFAULT NULL,
  `Username` varchar(50) NOT NULL,
  `PlanType` varchar(30) DEFAULT NULL,
  `LogTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Action` varchar(50) NOT NULL,
  `ResponseCode` int(4) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `actionlog`
--

INSERT INTO `actionlog` (`LogId`, `ClientIP`, `SessionId`, `Username`, `PlanType`, `LogTime`, `Action`, `ResponseCode`) VALUES
(803, '::1', '21hruj1i7n0rmqfd3goj84772q', '', NULL, '2021-06-07 23:57:00', 'myplan', 401),
(804, '::1', 'tmn2uoi644e6da52o3qhlvkd7a', '', NULL, '2021-06-07 23:57:01', 'login', 401),
(805, '::1', 'nmbfe8pcom9353uburcjr3kufl', '', NULL, '2021-06-07 23:57:02', 'login', 401),
(806, '::1', 'nmbfe8pcom9353uburcjr3kufl', '', NULL, '2021-06-07 23:58:12', 'logout', 200),
(807, '::1', 'nmbfe8pcom9353uburcjr3kufl', '', NULL, '2021-06-07 23:58:13', 'register', 500),
(808, '::1', 'bdhfh6tedb645gffss4kgahjkk', '', NULL, '2021-06-07 23:58:15', 'myplan', 401),
(809, '::1', '0r4tk1g681ft4ka5g7vu5il5vf', '', NULL, '2021-06-07 23:58:16', 'login', 401),
(810, '::1', 'ods92vo6l4lghghmh3plicordl', '', NULL, '2021-06-07 23:58:16', 'login', 401),
(811, '::1', 'ods92vo6l4lghghmh3plicordl', '', NULL, '2021-06-07 23:58:17', 'updateProfile', 401),
(812, '::1', 'ods92vo6l4lghghmh3plicordl', '', NULL, '2021-06-07 23:59:14', 'register', 500),
(813, '::1', 'ods92vo6l4lghghmh3plicordl', '', NULL, '2021-06-07 23:59:15', 'myplan', 401),
(814, '::1', 'ahgbnnar7u0746h0chtersh1ku', '', NULL, '2021-06-07 23:59:17', 'login', 401),
(815, '::1', 'tj5d9ude6g83lpqgbkocedtfvf', '', NULL, '2021-06-07 23:59:17', 'login', 401),
(816, '::1', 'tj5d9ude6g83lpqgbkocedtfvf', 'test009@email.com', 'Free', '2021-06-08 00:00:11', 'register', 201),
(817, '::1', 'tj5d9ude6g83lpqgbkocedtfvf', 'test009@email.com', 'Free', '2021-06-08 00:00:13', 'myplan', 200),
(818, '::1', 'dafnsdtvql305d32611g4paklo', '', NULL, '2021-06-08 00:00:14', 'login', 401),
(819, '::1', 'kmbon4fq4rv92od51sc43a39e0', '', NULL, '2021-06-08 00:00:14', 'login', 401),
(820, '::1', 'kmbon4fq4rv92od51sc43a39e0', '', NULL, '2021-06-08 00:00:15', 'editURL', 400),
(821, '::1', 'kmbon4fq4rv92od51sc43a39e0', 'test0010@email.com', 'Free', '2021-06-08 00:02:51', 'register', 201),
(822, '::1', 'kmbon4fq4rv92od51sc43a39e0', 'test0010@email.com', 'Free', '2021-06-08 00:02:52', 'myplan', 200),
(823, '::1', 'hnp9qkbdjksrvlvhadpao8r2d6', '', NULL, '2021-06-08 00:02:54', 'login', 401),
(824, '::1', 'eahni2tv844a6ggdudl04p2q66', '', NULL, '2021-06-08 00:02:54', 'login', 401),
(825, '::1', 'eahni2tv844a6ggdudl04p2q66', '', NULL, '2021-06-08 00:02:55', 'logout', 200),
(826, '::1', 'eahni2tv844a6ggdudl04p2q66', 'test0011@email.com', 'Free', '2021-06-08 00:09:21', 'register', 201),
(827, '::1', '2tdkersrnor6s5np5qv0glteau', 'test0011@email.com', 'Free', '2021-06-08 00:09:22', 'myplan', 200),
(828, '::1', 'rnifkj15pfsms4nt0d37ngh2km', '', NULL, '2021-06-08 00:09:23', 'login', 401),
(829, '::1', 'q7nso5a53skf84g1tjjlrfnndd', 'test0011@email.com', 'Free', '2021-06-08 00:09:24', 'login', 200),
(830, '::1', 'q7nso5a53skf84g1tjjlrfnndd', 'test0011@email.com', 'Free', '2021-06-08 00:09:24', 'myplan', 200),
(831, '::1', 'bg9ohkqr6opgeb1ee5unq5n8jj', '', NULL, '2021-06-08 00:47:07', 'isloggedin', 401),
(832, '::1', 'bg9ohkqr6opgeb1ee5unq5n8jj', 'test3@email.com', 'Standard', '2021-06-08 00:47:14', 'login', 200),
(833, '::1', 'bg9ohkqr6opgeb1ee5unq5n8jj', 'test3@email.com', 'Standard', '2021-06-08 00:47:16', 'report', 200),
(834, '::1', 'bg9ohkqr6opgeb1ee5unq5n8jj', 'test3@email.com', 'Standard', '2021-06-08 01:29:11', 'isloggedin', 200),
(835, '::1', 'bg9ohkqr6opgeb1ee5unq5n8jj', 'test1@email.com', 'Standard', '2021-06-08 10:42:32', 'login', 200),
(836, '::1', 'bg9ohkqr6opgeb1ee5unq5n8jj', 'test1@email.com', 'Standard', '2021-06-08 10:42:47', 'logout', 200),
(837, '::1', '6imf12qsv5g082g105diob03ob', 'test1@email.com', 'Standard', '2021-06-08 10:44:26', 'login', 200),
(838, '::1', '6imf12qsv5g082g105diob03ob', 'test1@email.com', 'Standard', '2021-06-08 10:44:33', 'myplan', 200),
(839, '::1', '6imf12qsv5g082g105diob03ob', 'test1@email.com', 'Standard', '2021-06-08 10:44:36', 'myplan', 200),
(840, '::1', '6imf12qsv5g082g105diob03ob', 'test1@email.com', 'Standard', '2021-06-08 10:44:37', 'myplan', 200),
(841, '::1', '6imf12qsv5g082g105diob03ob', 'test1@email.com', 'Standard', '2021-06-08 10:44:39', 'myplan', 200);

-- --------------------------------------------------------

--
-- Table structure for table `adminuser`
--

CREATE TABLE `adminuser` (
  `AdminId` int(11) UNSIGNED NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `RegisterDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `adminuser`
--

INSERT INTO `adminuser` (`AdminId`, `Email`, `Password`, `FirstName`, `LastName`, `RegisterDate`) VALUES
(1, 'admin1@email.com', '$2y$10$Skz8yeqyAvkz5TVO5dNdLudXfeRzTJFUn5KQCuIWFt.tHw6c92iMO', 'Tim', 'Tam', '0000-00-00');

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
  `Theme` varchar(10) NOT NULL DEFAULT 'Light',
  `RegisterDate` date NOT NULL,
  `Active` int(1) NOT NULL DEFAULT '1',
  `CancelDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerId`, `Email`, `Password`, `FirstName`, `LastName`, `PhoneNo`, `Address`, `Suburb`, `State`, `Postcode`, `Country`, `Theme`, `RegisterDate`, `Active`, `CancelDate`) VALUES
(1, 'test11@email.com', '$2y$10$Skz8yeqyAvkz5TVO5dNdLudXfeRzTJFUn5KQCuIWFt.tHw6c92iMO', 'test', 'test', '+11222333', 'test', 'test', 'QLD', '', 'Australia', 'Light', '2021-05-04', 0, '2021-05-16'),
(2, 'user@email.com', '$2y$10$c8q/MeEfm9YvYqDzUVdEEeUrevL7pqpZTTJS7rUgD92F/A97Zjbba', 'user', 'user', '+11222333', 'test', 'test', 'QLD', '', 'Australia', 'Light', '2021-05-14', 1, NULL),
(3, 'test1@email.com', '$2y$10$Qot.Yv2WDivGWj5.UaQ8oOwipnMIp6hIuHAyNEv0eZpC8xp5Rz5t2', 'TTT', 'QQQ', '0111011101', 'add', 'southbank', 'qld', '', 'Australia', 'Light', '2021-05-17', 1, NULL),
(4, 'test2@email.com', '$2y$10$qSNHpvBuM5wQLG44Se5m6.kM8pprBKhZchv3Pbffu7Jgm7GS2zplW', 'AAA', 'BBB', '+11222333', 'suburbA', 'test', 'QLD', '', 'Australia', 'Light', '2021-05-17', 1, NULL),
(5, 'test3@email.com', '$2y$10$xyKvrW9qPmRc9LDOdBCCAO0i06DQrDi9QjyRGJYfVnfGWDN5Y38Bq', 'BBB', 'bbb', '+11222333', 'Berry Street ', 'SouthBank', 'QLD', '1234', 'Australia', 'Light', '2021-05-17', 1, NULL),
(6, 'test4@email.com', '$2y$10$v2Coj8tokdH4jRonN8.QOOfoA04AGRHzu62hkpKZUjMDLXXCZOCGq', 'CCC', 'ccc', '+11222333', 'test', 'test', 'QLD', '', 'Australia', 'Light', '2021-05-17', 0, '2021-05-20'),
(7, 'test009@email.com', '$2y$10$TJwEjenUuIaei47yL04fPOjSmEOpHBlg0ZhdwTm4ZlWQS.GIKY436', 'test', 'test', '0110111222', '12 south street', 'SouthBank', 'QLD', '4112', 'Australia', 'Light', '2021-06-08', 1, NULL),
(8, 'test0010@email.com', '$2y$10$lKLlWOVYU10bR8gQ5Fsu1ObgYYYF.r9alUVYIk43Xbsa67p/vgINi', 'test', 'test', '0110111222', '12 south street', 'SouthBank', 'QLD', '4112', 'Australia', 'Light', '2021-06-08', 1, NULL),
(9, 'test0011@email.com', '$2y$10$pood00EfKtvFxKDiXfFnj.ikUI74hEwfEtwxLpIPQkEnXqQrPAs.C', 'test', 'test', '0110111222', '12 south street', 'SouthBank', 'QLD', '4112', 'Australia', 'Light', '2021-06-08', 1, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customerplan`
--

INSERT INTO `customerplan` (`CustomerPlanId`, `CustomerId`, `paymentId`, `PaidDate`, `Price`, `StartDate`, `EndDate`, `PlanId`) VALUES
(1, 3, NULL, NULL, NULL, '2021-05-17', NULL, 2),
(2, 1, NULL, NULL, NULL, '2021-05-17', NULL, 2),
(3, 2, NULL, NULL, NULL, '2021-05-14', NULL, 1),
(5, 4, NULL, NULL, NULL, '2021-05-17', NULL, 1),
(6, 5, NULL, NULL, NULL, '2021-05-18', NULL, 2),
(7, 6, NULL, NULL, NULL, '2021-05-17', NULL, 1),
(8, 7, NULL, NULL, NULL, '2021-06-08', NULL, 1),
(9, 8, NULL, NULL, NULL, '2021-06-08', NULL, 1),
(10, 9, NULL, NULL, NULL, '2021-06-08', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customerplanurl`
--

CREATE TABLE `customerplanurl` (
  `UrlId` int(11) UNSIGNED NOT NULL,
  `URL` varchar(50) DEFAULT NULL,
  `IPaddress` varchar(30) DEFAULT NULL,
  `CustomerPlanId` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customerplanurl`
--

INSERT INTO `customerplanurl` (`UrlId`, `URL`, `IPaddress`, `CustomerPlanId`) VALUES
(1, 'www.google.com', NULL, 2),
(2, 'www.12312.com', NULL, 2),
(3, 'www.ktkt123123.com', NULL, 2),
(4, '', NULL, 2),
(5, '', NULL, 2),
(6, NULL, NULL, 3),
(7, NULL, NULL, 3),
(8, NULL, NULL, 3),
(9, NULL, NULL, 3),
(10, NULL, NULL, 3),
(16, NULL, NULL, 2),
(17, NULL, NULL, 2),
(18, NULL, NULL, 2),
(19, NULL, NULL, 2),
(20, NULL, NULL, 2),
(21, NULL, NULL, 2),
(22, NULL, NULL, 2),
(23, NULL, NULL, 2),
(24, NULL, NULL, 2),
(25, NULL, NULL, 2),
(26, NULL, NULL, 2),
(27, NULL, NULL, 2),
(28, NULL, NULL, 2),
(29, NULL, NULL, 2),
(30, NULL, NULL, 2),
(31, NULL, NULL, 2),
(32, NULL, NULL, 2),
(33, NULL, NULL, 2),
(34, NULL, NULL, 2),
(35, NULL, NULL, 2),
(36, NULL, NULL, 2),
(37, NULL, NULL, 2),
(38, NULL, NULL, 2),
(39, NULL, NULL, 2),
(40, NULL, NULL, 2),
(41, NULL, NULL, 2),
(42, NULL, NULL, 2),
(43, NULL, NULL, 2),
(44, NULL, NULL, 2),
(45, NULL, NULL, 2),
(46, NULL, NULL, 2),
(47, NULL, NULL, 2),
(48, NULL, NULL, 2),
(49, NULL, NULL, 2),
(50, NULL, NULL, 2),
(51, NULL, NULL, 2),
(52, NULL, NULL, 2),
(53, NULL, NULL, 2),
(54, NULL, NULL, 2),
(55, NULL, NULL, 2),
(56, NULL, NULL, 2),
(57, NULL, NULL, 2),
(58, NULL, NULL, 2),
(59, NULL, NULL, 2),
(60, NULL, NULL, 2),
(61, NULL, NULL, 1),
(62, NULL, NULL, 1),
(63, NULL, NULL, 1),
(64, NULL, NULL, 1),
(65, NULL, NULL, 1),
(66, NULL, NULL, 1),
(67, NULL, NULL, 1),
(68, NULL, NULL, 1),
(69, NULL, NULL, 1),
(70, NULL, NULL, 1),
(71, NULL, NULL, 1),
(72, NULL, NULL, 1),
(73, NULL, NULL, 1),
(74, NULL, NULL, 1),
(75, NULL, NULL, 1),
(76, NULL, NULL, 1),
(77, NULL, NULL, 1),
(78, NULL, NULL, 1),
(79, NULL, NULL, 1),
(80, NULL, NULL, 1),
(81, 'www.google.com', NULL, 5),
(82, 'www.12312.com', NULL, 5),
(83, '', NULL, 5),
(84, '', NULL, 5),
(85, '', NULL, 5),
(86, 'www.google.com', NULL, 6),
(87, 'www.12312.com', NULL, 6),
(88, '', NULL, 6),
(89, '', NULL, 6),
(90, '', NULL, 6),
(91, NULL, NULL, 6),
(92, NULL, NULL, 6),
(93, NULL, NULL, 6),
(94, NULL, NULL, 6),
(95, NULL, NULL, 6),
(96, NULL, NULL, 6),
(97, NULL, NULL, 6),
(98, NULL, NULL, 6),
(99, NULL, NULL, 6),
(100, NULL, NULL, 6),
(101, NULL, NULL, 6),
(102, NULL, NULL, 6),
(103, NULL, NULL, 6),
(104, NULL, NULL, 6),
(105, NULL, NULL, 6),
(106, NULL, NULL, 7),
(107, NULL, NULL, 7),
(108, NULL, NULL, 7),
(109, NULL, NULL, 7),
(110, NULL, NULL, 7),
(111, NULL, NULL, 8),
(112, NULL, NULL, 8),
(113, NULL, NULL, 8),
(114, NULL, NULL, 8),
(115, NULL, NULL, 8),
(116, NULL, NULL, 9),
(117, NULL, NULL, 9),
(118, NULL, NULL, 9),
(119, NULL, NULL, 9),
(120, NULL, NULL, 9),
(121, NULL, NULL, 10),
(122, NULL, NULL, 10),
(123, NULL, NULL, 10),
(124, NULL, NULL, 10),
(125, NULL, NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `monitorstatus`
--

CREATE TABLE `monitorstatus` (
  `StatusId` int(11) UNSIGNED NOT NULL,
  `UrlId` int(11) UNSIGNED NOT NULL,
  `MonitorTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ResultStatus` int(3) UNSIGNED NOT NULL,
  `ErrorStatus` int(3) DEFAULT NULL,
  `ErrorDesc` text CHARACTER SET utf8 COLLATE utf8_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `monitorstatus`
--

INSERT INTO `monitorstatus` (`StatusId`, `UrlId`, `MonitorTime`, `ResultStatus`, `ErrorStatus`, `ErrorDesc`) VALUES
(1, 81, '2021-06-04 03:21:42', 200, NULL, NULL),
(2, 82, '2021-06-04 03:21:44', 500, NULL, NULL),
(3, 83, '2021-06-04 03:21:44', 0, NULL, NULL),
(4, 84, '2021-06-04 03:21:44', 0, NULL, NULL),
(5, 85, '2021-06-04 03:21:44', 0, NULL, NULL),
(6, 61, '2021-06-04 03:21:44', 200, NULL, NULL),
(7, 62, '2021-06-04 03:21:49', 0, NULL, NULL),
(8, 63, '2021-06-04 03:21:49', 0, NULL, NULL),
(9, 64, '2021-06-04 03:21:49', 0, NULL, NULL),
(10, 65, '2021-06-04 03:21:49', 0, NULL, NULL),
(11, 1, '2021-06-04 03:21:53', 200, NULL, NULL),
(12, 2, '2021-06-04 03:21:55', 500, NULL, NULL),
(13, 3, '2021-06-04 03:21:55', 0, NULL, NULL),
(14, 4, '2021-06-04 03:21:55', 0, NULL, NULL),
(15, 5, '2021-06-04 03:21:55', 0, NULL, NULL),
(16, 86, '2021-06-04 03:21:57', 200, NULL, NULL),
(17, 87, '2021-06-04 03:21:59', 500, NULL, NULL),
(18, 88, '2021-06-04 03:21:59', 0, NULL, NULL),
(19, 89, '2021-06-04 03:21:59', 0, NULL, NULL),
(20, 90, '2021-06-04 03:21:59', 0, NULL, NULL),
(21, 81, '2021-06-06 01:45:22', 200, NULL, NULL),
(22, 82, '2021-06-06 01:45:27', 0, NULL, NULL),
(23, 83, '2021-06-06 01:45:27', 0, NULL, NULL),
(24, 84, '2021-06-06 01:45:27', 0, NULL, NULL),
(25, 85, '2021-06-06 01:45:27', 0, NULL, NULL),
(26, 61, '2021-06-06 01:45:28', 200, NULL, NULL),
(27, 62, '2021-06-06 01:45:33', 0, NULL, NULL),
(28, 63, '2021-06-06 01:45:33', 0, NULL, NULL),
(29, 64, '2021-06-06 01:45:33', 0, NULL, NULL),
(30, 65, '2021-06-06 01:45:33', 0, NULL, NULL),
(31, 1, '2021-06-06 01:45:33', 200, NULL, NULL),
(32, 2, '2021-06-06 01:45:38', 0, NULL, NULL),
(33, 3, '2021-06-06 01:45:38', 0, NULL, NULL),
(34, 4, '2021-06-06 01:45:38', 0, NULL, NULL),
(35, 5, '2021-06-06 01:45:38', 0, NULL, NULL),
(36, 86, '2021-06-06 01:45:39', 200, NULL, NULL),
(37, 87, '2021-06-06 01:45:39', 500, NULL, NULL),
(38, 88, '2021-06-06 01:45:39', 0, NULL, NULL),
(39, 89, '2021-06-06 01:45:39', 0, NULL, NULL),
(40, 90, '2021-06-06 01:45:39', 0, NULL, NULL),
(41, 81, '2021-06-06 01:45:47', 200, NULL, NULL),
(42, 82, '2021-06-06 01:45:48', 500, NULL, NULL),
(43, 83, '2021-06-06 01:45:48', 0, NULL, NULL),
(44, 84, '2021-06-06 01:45:48', 0, NULL, NULL),
(45, 85, '2021-06-06 01:45:48', 0, NULL, NULL),
(46, 61, '2021-06-06 01:45:48', 200, NULL, NULL),
(47, 62, '2021-06-06 01:45:50', 500, NULL, NULL),
(48, 63, '2021-06-06 01:45:50', 0, NULL, NULL),
(49, 64, '2021-06-06 01:45:50', 0, NULL, NULL),
(50, 65, '2021-06-06 01:45:50', 0, NULL, NULL),
(51, 1, '2021-06-06 01:45:50', 200, NULL, NULL),
(52, 2, '2021-06-06 01:45:51', 500, NULL, NULL),
(53, 3, '2021-06-06 01:45:51', 0, NULL, NULL),
(54, 4, '2021-06-06 01:45:51', 0, NULL, NULL),
(55, 5, '2021-06-06 01:45:51', 0, NULL, NULL),
(56, 86, '2021-06-06 01:45:51', 200, NULL, NULL),
(57, 87, '2021-06-06 01:45:53', 500, NULL, NULL),
(58, 88, '2021-06-06 01:45:53', 0, NULL, NULL),
(59, 89, '2021-06-06 01:45:53', 0, NULL, NULL),
(60, 90, '2021-06-06 01:45:53', 0, NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE `plan` (
  `PlanId` int(5) UNSIGNED NOT NULL,
  `Type` varchar(30) DEFAULT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `MaxNumURL` varchar(100) DEFAULT NULL,
  `CheckFrequency` int(3) DEFAULT NULL,
  `ReportPeriod` int(2) UNSIGNED DEFAULT NULL,
  `NotificationPeriod` int(1) UNSIGNED DEFAULT NULL,
  `NotificationMethod` int(1) UNSIGNED DEFAULT '1',
  `Price` decimal(5,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`PlanId`, `Type`, `Description`, `MaxNumURL`, `CheckFrequency`, `ReportPeriod`, `NotificationPeriod`, `NotificationMethod`, `Price`) VALUES
(1, 'Free', 'Default free plan', '5', 60, 1, 1, 1, '0.00'),
(2, 'Standard', ' Standard plan', '20', 10, 2, 2, 2, '5.00'),
(3, 'Premium', 'Premium plan', '50', 1, 3, 3, 2, '10.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actionlog`
--
ALTER TABLE `actionlog`
  ADD PRIMARY KEY (`LogId`);

--
-- Indexes for table `adminuser`
--
ALTER TABLE `adminuser`
  ADD PRIMARY KEY (`AdminId`),
  ADD UNIQUE KEY `Email` (`Email`);

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
  MODIFY `LogId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=842;

--
-- AUTO_INCREMENT for table `adminuser`
--
ALTER TABLE `adminuser`
  MODIFY `AdminId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customerplan`
--
ALTER TABLE `customerplan`
  MODIFY `CustomerPlanId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customerplanurl`
--
ALTER TABLE `customerplanurl`
  MODIFY `UrlId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `monitorstatus`
--
ALTER TABLE `monitorstatus`
  MODIFY `StatusId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

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
