-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 16, 2025 at 06:23 PM
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
  `Memorial` varchar(255) NOT NULL,
  `Memorial Location` varchar(255) NOT NULL,
  `Memorial Info` varchar(255) NOT NULL,
  `Postcode` varchar(255) NOT NULL,
  `District` varchar(255) NOT NULL
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
  `Service No` varchar(255) NOT NULL,
  `Age` int(11) NOT NULL,
  `Date of Death` date NOT NULL,
  `Rank` varchar(255) NOT NULL,
  `Regiment` varchar(255) NOT NULL,
  `Unit` varchar(255) NOT NULL,
  `Cemetery` varchar(255) NOT NULL,
  `Grave Ref` varchar(255) NOT NULL,
  `Info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Biography Information`
--
ALTER TABLE `Biography Information`
  ADD PRIMARY KEY (`Service no`);

--
-- Indexes for table `Bradford and surrounding townships Great War Roll of Honour`
--
ALTER TABLE `Bradford and surrounding townships Great War Roll of Honour`
  ADD PRIMARY KEY (`Service no`);

--
-- Indexes for table `Bradford Memorials`
--
ALTER TABLE `Bradford Memorials`
  ADD PRIMARY KEY (`Service no`);

--
-- Indexes for table `Newspaper References`
--
ALTER TABLE `Newspaper References`
  ADD PRIMARY KEY (`Service no`);

--
-- Indexes for table `Those Buried in Bradford`
--
ALTER TABLE `Those Buried in Bradford`
  ADD PRIMARY KEY (`Service No`);

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
  ADD CONSTRAINT `bradford and surrounding townships great war roll of honour_ibfk_1` FOREIGN KEY (`Service no`) REFERENCES `Those Buried in Bradford` (`Service No`);

--
-- Constraints for table `Bradford Memorials`
--
ALTER TABLE `Bradford Memorials`
  ADD CONSTRAINT `bradford memorials_ibfk_1` FOREIGN KEY (`Service no`) REFERENCES `Those Buried in Bradford` (`Service No`);

--
-- Constraints for table `Newspaper References`
--
ALTER TABLE `Newspaper References`
  ADD CONSTRAINT `newspaper references_ibfk_1` FOREIGN KEY (`Service no`) REFERENCES `Those Buried in Bradford` (`Service No`);

--
-- Constraints for table `Those Buried in Bradford`
--
ALTER TABLE `Those Buried in Bradford`
  ADD CONSTRAINT `those buried in bradford_ibfk_1` FOREIGN KEY (`Service No`) REFERENCES `Biography Information` (`Service no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
