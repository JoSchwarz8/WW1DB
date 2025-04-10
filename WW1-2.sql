-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 04:56 PM
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
-- Database: `ww1-2`
--

-- --------------------------------------------------------

--
-- Table structure for table `biography_information`
--

CREATE TABLE `biography_information` (
  `Surname` varchar(255) NOT NULL,
  `Forename` varchar(255) NOT NULL,
  `Regiment` varchar(255) NOT NULL,
  `Service no` varchar(255) NOT NULL,
  `Biography` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `burials`
--

CREATE TABLE `burials` (
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

--
-- Dumping data for table `burials`
--

INSERT INTO `burials` (`Surname`, `Forename`, `DoB`, `Medals`, `Date of Death`, `Rank`, `Service Number`, `Regiment`, `Battalion`, `Cemetery`, `Grave Reference`, `Info`, `Burial_ID`) VALUES
('Ackrel', 'William Frank', '34', 'Not recorded', '1919-04-12', 'Driver', 'T/341931', 'Royal Army Service Corps', 'Not Known', 'Undercliffe Cemetery', 'Section E. Grave 458 (Unconsecrated)', 'Born in Beswick, Manchester, the son of William and Mary Ackrel of 37, Airedale Crescent, Bradford and the husband of Lily Ackrel (nee Brayshaw) whom he married in 1909. They lived at  46, Lonsdale Road, Bradford. He had previously volunteered to join the Army but had been rejected as medically unfit. However in February 1918 he was allowed to join the Army and after training he was sent to Ireland where he was engaged with the horse transport of his unit. Whilst in the service of his country he caught broncho - pnuemonia from which he died. Prior to his enlistment he was employed as a Tram Conductor. His grave has a Commonwealth War Grave Headstone.', 1),
('Ackroyd', 'Fred Stowell', '32', 'Not recorded', '1918-11-28', 'Corporal', '233608', 'Royal Air Force', 'Calshot (Hants).', 'Bowling Cemetery', 'Section V, Grave 167 (Consecrated)', 'Born in Little Horton, Bradford, the son of Rowland and Eliza Ackroyd and the husband of Annie Ackroyd (nee Metcalfe) whom he married in 1908.. Both his parents died when he was young and in 1901 he was placed into the Nutter Orphanage in Great Horton, Bradford. He joined the RAF in 1917 before which he was employed as a Clerk. His grave has a Commonwealth War Grave Headstone.', 2),
('Ackroyd', 'Samuel', '44', 'Not recorded', '1916-07-27', 'Corporal', '72225', 'Royal Engineers', 'Not Known', 'Scholemoor Cemetery', 'Section B, Grave 492 (Consecrated)', 'The son of James and Agnes Ackroyd and the husband of Elizabeth Ackroyd (nee Doolam) whom he married in 1895 in Bradford. They lived at 21, Jermyn Street, Church Bank, Bradford. He died in the War Hospital, Thornton. His grave has a Commonwealth War Grave Headstone.', 3),
('Allan', 'John Edward', '28', 'Not recorded', '1919-03-08', 'Air Mechanic 2nd Class', '23994', 'Royal Air Force', 'Not Known', 'Bowling Cemetery', 'Section X, Grave 1474 (Consecrated)', 'Born in York the son of the John William and Sarah Allan. He joined the RAF in February 1916 and in March 1918 he was discharged as unfit for duties after contracting Tuberculosis, from which he died of in the Seacroft Military Hospital, Leeds. His grave has a Commonwealth War Grave Headstone.', 4),
('Ambler', 'George', '23', 'Not recorded', '1917-08-03', 'Second Lieutenant', 'None', 'West Yorkshire Regiment  (Prince of Waless Own)', 'Not Known', 'Undercliffe Cemetery', 'Section H, Grave 796 (Consecrated)', 'The son of the late John and his second wife Edith Alice Ambler of Heaton Mount, Bradford. He joined the Army in 1915 and was promoted to Lieutenant in January 1917. He was wounded in the arm at Beaumont Hamel in early May 1917 and when he recovered he rejoined his unit in late May 1917. At the battle of Loos, in July 1917, he was again wounded and died of these wounds at the 3rd London General Hospital, Wandsworth Common, London. He is interned in a Family Grave with his name commemorated on the side.', 5),
('Ambler', 'George', '23', 'Not recorded', '1917-08-03', 'Second Lieutenant', 'None', 'West Yorkshire Regiment  (Prince of Waless Own)', 'Not Known', 'Undercliffe Cemetery', 'Section H, Grave 796 (Consecrated)', 'The son of the late John and his second wife Edith Alice Ambler of Heaton Mount, Bradford. He joined the Army in 1915 and was promoted to Lieutenant in January 1917. He was wounded in the arm at Beaumont Hamel in early May 1917 and when he recovered he rejoined his unit in late May 1917. At the battle of Loos, in July 1917, he was again wounded and died of these wounds at the 3rd London General Hospital, Wandsworth Common, London. He is interned in a Family Grave with his name commemorated on the side.', 6),
('Amyes', 'Thomas', '37', 'Not recorded', '1919-08-29', 'Lance Corporal', '29102', 'Royal Field Artillery', '35th Brigade', 'Bowling Cemetery', 'Section X, Grave 952 (Consecrated)', 'The son of Henry and Mary Amyes and the husband of Marian Walton Amyes (nee Hill), of 14, Gibson Street, Leeds Road, Bradford whom he married in 1914. He had previously enlisted into the Army in 1898 and was on reserve when he was called up in 1914. He was discharged in August 1918 as medically unfit due to sickness from which he died at his home. His grave has a Commonwealth War Grave Headstone.', 7),
('Andrews', 'George', '24', 'Not recorded', '1920-02-01', 'Private', 'M/40125', 'Royal Army Service Corps', 'Motor Transport', 'Bowling Cemetery', 'Section U, Grave 590 (Consecrated)', 'The son of William and Rosina Andrews. He lived at 103, St Stephens Road, Bowling  having previously lived at 213, Rooley Lane and 41, Dalcross Street. Prior to his enlistment he was employed as a Cloth Roller. He died at the Royal Victoria Hospital. His grave has a Commonwealth War Grave Headstone.', 8),
('Anness', 'Walter', '38', 'Not recorded', '1918-07-07', 'Private', '20134', 'Suffolk Regiment', '9th Battalion', 'Scholemoor Cemetery', 'Section 3, Grave 2084 (Consecrated)', 'Born in Epsworth, Lincolnshire to William and Alice Ada Anness. Prior to his enlistment he was living in Thetford , Norfolk and was employed as a farm labourer. He was living with his sister at 39, Burnley Road, Colne whilst recovering from Broncial Pneumonia from which he died at the St Lukes War Hospital, Bradford. His grave has a Commonwealth War Grave Headstone and he shares his final resting place with seven other fallen soldiers.', 9);

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
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `Username` varchar(10) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `memorials`
--

CREATE TABLE `memorials` (
  `Surname` varchar(255) NOT NULL,
  `Forename` varchar(255) NOT NULL,
  `Regiment` varchar(100) NOT NULL,
  `Battalion` varchar(255) NOT NULL,
  `Unit` varchar(255) NOT NULL,
  `Memorial` varchar(255) NOT NULL,
  `Memorial Location` varchar(255) NOT NULL,
  `Memorial Info` varchar(255) NOT NULL,
  `Postcode` varchar(255) NOT NULL,
  `District` varchar(255) NOT NULL,
  `Photo_Available` text NOT NULL,
  `Memorial_ID` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memorials`
--

INSERT INTO `memorials` (`Surname`, `Forename`, `Regiment`, `Battalion`, `Unit`, `Memorial`, `Memorial Location`, `Memorial Info`, `Postcode`, `District`, `Photo_Available`, `Memorial_ID`) VALUES
('Airey', 'Harry', 'West Yorkshire Regiment', 'Not recorded', '', 'All Saints Church, Little Horton', 'Little Horton Green, Little Horton', 'Inside Memorial Chapel', 'BD5 0NG', 'Little Horton', 'No', 1),
('Airey', 'Harry', 'West Yorkshire Regiment', 'Not recorded', '', 'All Saints Church, Little Horton', 'Little Horton Green, Little Horton', 'Inside Memorial Chapel', 'BD5 0NG', 'Little Horton', 'No', 2),
('Allen', 'John W', 'Not recorded', 'Not recorded', '', 'All Saints Church, Little Horton', 'Little Horton Green, Little Horton', 'Large Plaque inside church', 'BD5 0NG', 'Little Horton', 'No', 3),
('Baines', 'Arthur', 'Not recorded', 'Not recorded', '', 'All Saints Church, Little Horton', 'Little Horton Green, Little Horton', 'Large Plaque inside church', 'BD5 0NG', 'Little Horton', 'No', 4),
('Bannister', 'John W', 'Not recorded', 'Not recorded', '', 'All Saints Church, Little Horton', 'Little Horton Green, Little Horton', 'Large Plaque inside church', 'BD5 0NG', 'Little Horton', 'No', 5),
('Bannister', 'John W', 'West Yorkshire Regiment', 'Not recorded', '', 'All Saints Church, Little Horton', 'Little Horton Green, Little Horton', 'Inside Memorial Chapel', 'BD5 0NG', 'Little Horton', 'No', 6),
('Bird', 'Albert H', 'Not recorded', 'Not recorded', '', 'All Saints Church, Little Horton', 'Little Horton Green, Little Horton', 'Large Plaque inside church', 'BD5 0NG', 'Little Horton', 'No', 7),
('Binns', 'Charles', 'Not recorded', 'Not recorded', '', 'All Saints Church, Little Horton', 'Little Horton Green, Little Horton', 'Large Plaque inside church', 'BD5 0NG', 'Little Horton', 'No', 8),
('Bingham', 'Charles', 'Not recorded', 'Not recorded', '', 'All Saints Church, Little Horton', 'Little Horton Green, Little Horton', 'Large Plaque inside church', 'BD5 0NG', 'Little Horton', 'No', 9),
('Bentley', 'Joseph E', 'Not recorded', 'Not recorded', '', 'All Saints Church, Little Horton', 'Little Horton Green, Little Horton', 'Large Plaque inside church', 'BD5 0NG', 'Little Horton', 'No', 10);

-- --------------------------------------------------------

--
-- Table structure for table `newspaper_ref`
--

CREATE TABLE `newspaper_ref` (
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
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `User Type` varchar(10) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `burials`
--
ALTER TABLE `burials`
  ADD PRIMARY KEY (`Burial_ID`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`Password`,`Date`);

--
-- Indexes for table `memorials`
--
ALTER TABLE `memorials`
  ADD PRIMARY KEY (`Memorial_ID`,`Memorial`);

--
-- Indexes for table `newspaper_ref`
--
ALTER TABLE `newspaper_ref`
  ADD PRIMARY KEY (`Ref_ID`,`Newspaper Name`,`Paper Date`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`Password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `burials`
--
ALTER TABLE `burials`
  MODIFY `Burial_ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `memorials`
--
ALTER TABLE `memorials`
  MODIFY `Memorial_ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `newspaper_ref`
--
ALTER TABLE `newspaper_ref`
  MODIFY `Ref_ID` int(50) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
