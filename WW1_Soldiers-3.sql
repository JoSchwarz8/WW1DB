-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 23, 2025 at 04:34 PM
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
-- Database: `WW1 Soldiers`
--

-- --------------------------------------------------------

--
-- Table structure for table `Biography Information`
--

CREATE TABLE `Biography Information` (
  `Surname` varchar(255) NOT NULL,
  `Forename` varchar(255) NOT NULL,
  `Service no` varchar(255) NOT NULL,
  `Regiment` varchar(255) NOT NULL,
  `Biography` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Bradford and surrounding townships Great War Roll of Honour`
--

CREATE TABLE `Bradford and surrounding townships Great War Roll of Honour` (
  `Surname` varchar(255) NOT NULL,
  `Forename` varchar(255) NOT NULL,
  `Service no` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Electoral Ward` varchar(255) NOT NULL,
  `Town` varchar(255) NOT NULL,
  `Age` int(11) NOT NULL,
  `Rank` varchar(255) NOT NULL,
  `Regiment` varchar(255) NOT NULL,
  `Unit` varchar(255) NOT NULL,
  `Other Regiment` varchar(255) NOT NULL,
  `Other Unit` varchar(255) NOT NULL,
  `Other Service no` varchar(255) NOT NULL,
  `Medals` varchar(255) NOT NULL,
  `Enlistment Date` date NOT NULL,
  `Discharge Date` date NOT NULL,
  `Death (in service) Date` date NOT NULL,
  `Misc info (Nroh)` text NOT NULL,
  `Misc info (cwgc)` text NOT NULL,
  `Cemetery/Memorial` varchar(255) NOT NULL,
  `Cemetery/Memorial Ref` varchar(255) NOT NULL,
  `Cemetery/Memorial Country` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Bradford Memorials`
--

CREATE TABLE `Bradford Memorials` (
  `Surname` varchar(255) NOT NULL,
  `Forename` varchar(255) NOT NULL,
  `Service no` varchar(255) NOT NULL,
  `Memorial_ID` int(50) NOT NULL,
  `Memorial` varchar(255) NOT NULL,
  `Memorial Location` varchar(255) NOT NULL,
  `Memorial Info` varchar(255) NOT NULL,
  `Postcode` varchar(255) NOT NULL,
  `District` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Login_attempts`
--

CREATE TABLE `Login_attempts` (
  `Username` varchar(10) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Newspaper References`
--

CREATE TABLE `Newspaper References` (
  `Surname` varchar(255) NOT NULL,
  `Forename` varchar(255) NOT NULL,
  `Service no` varchar(255) NOT NULL,
  `Rank` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Regiment` varchar(255) NOT NULL,
  `Unit` varchar(255) NOT NULL,
  `Ref_ID` int(50) NOT NULL,
  `Article Description` text NOT NULL,
  `Newspaper Name` varchar(255) NOT NULL,
  `Paper Date` date NOT NULL,
  `Page/Column` varchar(255) NOT NULL,
  `Photo Incl.` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Those Buried in Bradford`
--

CREATE TABLE `Those Buried in Bradford` (
  `Surname` varchar(255) NOT NULL,
  `Forename` varchar(255) NOT NULL,
  `Service no` varchar(255) NOT NULL,
  `Age` int(11) NOT NULL,
  `Burial_ID` int(50) NOT NULL,
  `Date of Death` date NOT NULL,
  `Rank` varchar(255) NOT NULL,
  `Regiment` varchar(255) NOT NULL,
  `Unit` varchar(255) NOT NULL,
  `Cemetery` varchar(255) NOT NULL,
  `Grave Ref` varchar(255) NOT NULL,
  `Info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `User_details`
--

CREATE TABLE `User_details` (
  `User Type` varchar(10) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Biography Information`
--
ALTER TABLE `Biography Information`
  ADD PRIMARY KEY (`Surname`,`Regiment`),
  ADD UNIQUE KEY `idx_service_no` (`Service no`),
  ADD UNIQUE KEY `unique_service_no` (`Service no`);

--
-- Indexes for table `Bradford and surrounding townships Great War Roll of Honour`
--
ALTER TABLE `Bradford and surrounding townships Great War Roll of Honour`
  ADD PRIMARY KEY (`Surname`,`Service no`,`Address`),
  ADD KEY `Service no` (`Service no`);

--
-- Indexes for table `Bradford Memorials`
--
ALTER TABLE `Bradford Memorials`
  ADD PRIMARY KEY (`Memorial_ID`,`Memorial`),
  ADD UNIQUE KEY `Service no` (`Service no`);

--
-- Indexes for table `Login_attempts`
--
ALTER TABLE `Login_attempts`
  ADD PRIMARY KEY (`Password`,`Date`);

--
-- Indexes for table `Newspaper References`
--
ALTER TABLE `Newspaper References`
  ADD PRIMARY KEY (`Ref_ID`,`Newspaper Name`,`Paper Date`),
  ADD UNIQUE KEY `Service no` (`Service no`);

--
-- Indexes for table `Those Buried in Bradford`
--
ALTER TABLE `Those Buried in Bradford`
  ADD PRIMARY KEY (`Burial_ID`,`Date of Death`),
  ADD UNIQUE KEY `Service No` (`Service no`);

--
-- Indexes for table `User_details`
--
ALTER TABLE `User_details`
  ADD PRIMARY KEY (`Password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Bradford Memorials`
--
ALTER TABLE `Bradford Memorials`
  MODIFY `Memorial_ID` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Newspaper References`
--
ALTER TABLE `Newspaper References`
  MODIFY `Ref_ID` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Those Buried in Bradford`
--
ALTER TABLE `Those Buried in Bradford`
  MODIFY `Burial_ID` int(50) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Biography Information`
--
ALTER TABLE `Biography Information`
  ADD CONSTRAINT `biography information_ibfk_1` FOREIGN KEY (`Service no`) REFERENCES `Bradford and surrounding townships Great War Roll of Honour` (`Service no`);

--
-- Constraints for table `Bradford and surrounding townships Great War Roll of Honour`
--
ALTER TABLE `Bradford and surrounding townships Great War Roll of Honour`
  ADD CONSTRAINT `bradford and surrounding townships great war roll of honour_ibfk_1` FOREIGN KEY (`Service no`) REFERENCES `Bradford Memorials` (`Service no`);

--
-- Constraints for table `Bradford Memorials`
--
ALTER TABLE `Bradford Memorials`
  ADD CONSTRAINT `bradford memorials_ibfk_1` FOREIGN KEY (`Service no`) REFERENCES `Bradford and surrounding townships Great War Roll of Honour` (`Service no`);

--
-- Constraints for table `Newspaper References`
--
ALTER TABLE `Newspaper References`
  ADD CONSTRAINT `newspaper references_ibfk_1` FOREIGN KEY (`Service no`) REFERENCES `Bradford and surrounding townships Great War Roll of Honour` (`Service no`);

--
-- Constraints for table `Those Buried in Bradford`
--
ALTER TABLE `Those Buried in Bradford`
  ADD CONSTRAINT `those buried in bradford_ibfk_1` FOREIGN KEY (`Service no`) REFERENCES `Bradford and surrounding townships Great War Roll of Honour` (`Service no`);

--
-- Constraints for table `User_details`
--
ALTER TABLE `User_details`
  ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`Password`) REFERENCES `Login_attempts` (`Password`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
