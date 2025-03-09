-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 09, 2025 at 07:01 PM
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
-- Database: `WW1`
--

-- --------------------------------------------------------

--
-- Table structure for table `Biography_Information`
--

CREATE TABLE `Biography_Information` (
  `Surname` varchar(255) NOT NULL,
  `Forename` varchar(255) NOT NULL,
  `Regiment` varchar(255) NOT NULL,
  `Service no` varchar(255) NOT NULL,
  `Biography` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Burials`
--

CREATE TABLE `Burials` (
  `Surname` varchar(255) NOT NULL,
  `Forename` varchar(255) NOT NULL,
  `DoB` varchar(255) NOT NULL,
  `Medals` varchar(100) NOT NULL,
  `Date of Death` varchar(10) NOT NULL,
  `Rank` varchar(255) NOT NULL,
  `Service Number` varchar(255) NOT NULL,
  `Regiment` varchar(255) NOT NULL,
  `Battalion` varchar(255) NOT NULL,
  `Cemetery` varchar(255) NOT NULL,
  `Grave Reference` varchar(255) NOT NULL,
  `Info` text NOT NULL,
  `Burial_ID` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gwroh`
--

CREATE TABLE `gwroh` (
  `Surname` varchar(255) NOT NULL,
  `Forename` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Electoral Ward` varchar(255) NOT NULL,
  `Town` varchar(255) NOT NULL,
  `Rank` varchar(255) NOT NULL,
  `Regiment` varchar(255) NOT NULL,
  `Battalion` varchar(255) NOT NULL,
  `Company` varchar(100) NOT NULL,
  `Age` int(11) NOT NULL,
  `Service no` varchar(255) NOT NULL,
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
-- Table structure for table `Memorials`
--

CREATE TABLE `Memorials` (
  `Surname` varchar(255) NOT NULL,
  `Forename` varchar(255) NOT NULL,
  `Regiment` varchar(100) NOT NULL,
  `Unit` varchar(255) NOT NULL,
  `Memorial` varchar(255) NOT NULL,
  `Memorial Location` varchar(255) NOT NULL,
  `Memorial Info` varchar(255) NOT NULL,
  `Postcode` varchar(255) NOT NULL,
  `District` varchar(255) NOT NULL,
  `Photo_Available` text NOT NULL,
  `Memorial_ID` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Newspaper_ref`
--

CREATE TABLE `Newspaper_ref` (
  `Surname` varchar(255) NOT NULL,
  `Forename` varchar(255) NOT NULL,
  `Rank` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Regiment` varchar(255) NOT NULL,
  `Unit` varchar(255) NOT NULL,
  `Article Comment` text NOT NULL,
  `Newspaper Name` varchar(255) NOT NULL,
  `Paper Date` date NOT NULL,
  `Page/Column` varchar(255) NOT NULL,
  `Photo Incl.` text NOT NULL,
  `Ref_ID` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `User_details`
--

CREATE TABLE `User_details` (
  `User Type` varchar(10) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Burials`
--
ALTER TABLE `Burials`
  ADD PRIMARY KEY (`Burial_ID`);

--
-- Indexes for table `Login_attempts`
--
ALTER TABLE `Login_attempts`
  ADD PRIMARY KEY (`Password`,`Date`);

--
-- Indexes for table `Memorials`
--
ALTER TABLE `Memorials`
  ADD PRIMARY KEY (`Memorial_ID`,`Memorial`);

--
-- Indexes for table `Newspaper_ref`
--
ALTER TABLE `Newspaper_ref`
  ADD PRIMARY KEY (`Ref_ID`,`Newspaper Name`,`Paper Date`);

--
-- Indexes for table `User_details`
--
ALTER TABLE `User_details`
  ADD PRIMARY KEY (`Password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Burials`
--
ALTER TABLE `Burials`
  MODIFY `Burial_ID` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Memorials`
--
ALTER TABLE `Memorials`
  MODIFY `Memorial_ID` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Newspaper_ref`
--
ALTER TABLE `Newspaper_ref`
  MODIFY `Ref_ID` int(50) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Biography_Information`
--
ALTER TABLE `Biography_Information`
  ADD CONSTRAINT `biography_information_ibfk_1` FOREIGN KEY (`Service no`) REFERENCES `WW1 Soldiers`.`Bradford and surrounding townships Great War Roll of Honour` (`Service no`);

--
-- Constraints for table `gwroh`
--
ALTER TABLE `gwroh`
  ADD CONSTRAINT `gwroh_ibfk_1` FOREIGN KEY (`Service no`) REFERENCES `WW1 Soldiers`.`Bradford Memorials` (`Service no`);

--
-- Constraints for table `Memorials`
--
ALTER TABLE `Memorials`
  ADD CONSTRAINT `memorials_ibfk_1` FOREIGN KEY (`Unit`) REFERENCES `WW1 Soldiers`.`Bradford and surrounding townships Great War Roll of Honour` (`Service no`);

--
-- Constraints for table `User_details`
--
ALTER TABLE `User_details`
  ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`Password`) REFERENCES `ww1 soldiers`.`Login_attempts` (`Password`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
