-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 11:37 AM
-- Server version: 8.0.36
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vivalavida_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `Employee_ID` int NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Contact_Number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`Employee_ID`, `First_Name`, `Last_Name`, `Username`, `Email`, `Contact_Number`, `Password`, `Role`) VALUES
(1, 'Admin', 'Admin', 'Admin', 'Admin@gmail.com', NULL, '$2y$12$iCw8rWyVnz61VheCNb52..Da5QvacX3UlqcbspITOB4U0xUqIM.8i', 'Admin'),
(2, 'Carl', 'Bundalian', 'Carlo', 'carlo@gmail.com', '09123456789', '$2y$12$Ka8giOb3g76o3RMzVBbQV.7nAmfmOMd6eDddcRahA3yvZJdW4SKTO', 'Employee'),
(3, 'Johan', 'Bryek', 'johan', 'johan@gmail.com', '09234567899', '$2y$12$7xEM0hlzPlEnX0SG4R4DMO3CaXm8pQ/cS/VoD3j2DTiESFjBIZhA2', 'Employee'),
(4, 'Jonas Vince', 'Macawile', 'Jonas', 'jonasemperor@gmail.com', '09507373644', '$2y$12$Is67y3nkBhv4zCWJgn6V.OaFkpKiGV3O3FlAwjmpdb7u2tK4i7flW', 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `guitar`
--

CREATE TABLE `guitar` (
  `GuitarID` int NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Brand` varchar(50) NOT NULL,
  `Model` varchar(50) NOT NULL,
  `Guitar_Picture` varchar(255) NOT NULL,
  `Fretboard_Material` varchar(50) NOT NULL,
  `Neck_Material` varchar(50) NOT NULL,
  `Body_Material` varchar(50) NOT NULL,
  `Body_Shape` varchar(50) NOT NULL,
  `Number_of_Strings` int NOT NULL,
  `Number_of_Frets` int NOT NULL,
  `Price` decimal(11,2) NOT NULL,
  `Stocks` int NOT NULL,
  `Description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guitar`
--

INSERT INTO `guitar` (`GuitarID`, `Type`, `Brand`, `Model`, `Guitar_Picture`, `Fretboard_Material`, `Neck_Material`, `Body_Material`, `Body_Shape`, `Number_of_Strings`, `Number_of_Frets`, `Price`, `Stocks`, `Description`) VALUES
(1, 'Acoustic', 'History', 'Heg-120', '../image retrieverv2/guitar gallery/History Classical Heg-120.png', 'Spruce', 'Maple', 'Alder', 'Classical', 6, 22, 45000.00, 91, 'Discover the rich tones of the HEG 120 History Guitar. Crafted with precision, it features a mahogany body, rosewood fretboard, and vintage-style pickups. Perfect for professionals and enthusiasts, this guitar delivers timeless sound and unparalleled play'),
(2, 'Acoustic', 'Manuel Rodriguez', 'D-C', '../image retrieverv2/guitar gallery/Manuel Rodriguez Natural.png', 'Ebony', 'Mahogany', 'Mahogany', 'Classical', 6, 19, 47000.00, 91, 'Experience the elegance of the Manuel Rodriguez Natural Guitar. Handcrafted with a solid cedar top and Indian rosewood body, it offers warm, resonant tones. Designed for classical and flamenco players, this guitar combines tradition.'),
(3, 'Acoustic', 'Gibson', 'Dove Original', '../image retrieverv2/guitar gallery/Gibson Dove Original.png', 'Rosewood', 'Maple', 'Maple', 'Dreadnought', 6, 20, 50000.00, 85, 'Gibson Dove Original Guitar: Featuring a solid spruce top and flame maple body, it offers clear, balanced tones with iconic aesthetics. Known for its ornate pickguard and rich sound, it\'s perfect for players seeking timeless style.'),
(4, 'Acoustic', 'History', 'NT S3 VNT', '../image retrieverv2/guitar gallery/History NT S3 NVT.png', 'Spruce', 'Mahogany', 'Spruce', 'S Shape', 6, 21, 49000.00, 98, 'History NT-S3 NVT Guitar: Crafted with precision, it features a solid spruce top and rosewood back for warm, resonant tones. Its natural finish highlights elegant craftsmanship, offering comfort and exceptional sound quality for dedicated musicians.'),
(5, 'Bass', 'Fender', 'Vintage II 1966', '../image retrieverv2/guitar gallery/Fender Bass Olymnpic White v2.png', 'Olympic White', 'Maple', 'Alder', 'Jazz Bass', 4, 20, 115000.00, 89, 'Fender Vintage II 1966 Jazz Bass: A classic reissue, it boasts an alder body, slim \'60s neck profile, and vintage-style pickups for rich, punchy tones. Perfect for pros and enthusiasts, it delivers authentic retro style and legendary sound.'),
(6, 'Electric', 'Epiphone', 'Les Paul Standard 60\'s', '../image retrieverv2/guitar gallery/Epiphone Les Paul Standard 60\'s.png', 'Laurel', 'Mahogany', 'Mahogany', 'Single Cutaway', 6, 22, 43000.00, 89, 'Epiphone Les Paul Standard 60\'s: A tribute to the golden era, it features a mahogany body, slim taper neck, and ProBucker pickups. This guitar delivers the iconic Les Paul tone with modern reliability and vintage-inspired elegance.'),
(7, 'Electric', 'Fender', 'Player Mustang', '../image retrieverv2/guitar gallery/Fender Player Mustang.png', 'Pau Ferro', 'Pau Ferro', 'Alder', 'Double Cutaway', 6, 22, 38000.00, 91, 'Fender Mustang Player: Compact and versatile, this guitar features a sleek offset body, a modern C-shaped neck, and Alnico single-coil pickups, delivering dynamic tones perfect for alternative, rock, and indie styles.'),
(8, 'Electric', 'Fender', 'American Performer Startocaster', '../image retrieverv2/guitar gallery/Fender Startocoaster Honey Burst.png', 'Rosewood', 'Maple', 'Alder', 'S Style', 6, 22, 110000.00, 96, 'Fender American Stratocaster: A legendary guitar with a sleek contoured body, modern Deep C neck, and V-Mod II single-coil pickups, offering unparalleled tone, playability, and versatility for all music genres.'),
(9, 'Electric', 'Fender', 'American Vintage Telecaster', '../image retrieverv2/guitar gallery/Fender American Vintage Telecaster.png', 'Maple', 'Maple', 'Ash', 'T Style', 6, 21, 125000.00, 81, 'Fender American Vintage Telecaster: A timeless electric guitar with a classic ash or alder body, crisp twangy sound, and vintage-style single-coil pickups, delivering authentic Telecaster tone and exceptional craftsmanship.'),
(10, 'Electric', 'Ibanez', 'Telecaster AZS2209 Prestige', '../image retrieverv2/guitar gallery/Ibanez TELECASTER AZS2209 PRESTIGE.png', 'Roasted Maple', 'Roasted Maple', 'Roasted Maple', 'Single Cutaway', 6, 22, 117288.00, 91, 'Telecaster AZS2209 Prestige Antique Turquoise: A stunning electric guitar with an antique turquoise finish, featuring an alder body, roasted maple neck, and Seymour Duncan pickups, delivering rich, dynamic tones and superior.'),
(11, 'Electric', 'Squier', 'Avril Lavigne Telecaster', '../image retrieverv2/guitar gallery/Avril Lavigne Telecaster.jpg', 'Rosewood', 'Maple', 'Basswood', 'T Style', 6, 22, 100000.00, 91, 'Squier Avril Lavigne Telecaster: A signature model inspired by the iconic pop-punk artist, featuring a sleek white body, black pickguard, and a fast-playing maple neck, perfect for rock enthusiasts looking for that signature Avril Lavigne style and tone.'),
(12, 'fsdfsdf', 'Fender', 'fsdfsdf', '../image retrieverv2/guitar gallery/466327498_884325180526151_6420327135708667275_n.jpg', 'fsfsdf', 'fsdfds', 'fsdfsdf', 'fsdfsd', 6, 21, 45000.00, 99, 'waw gitar ');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `Transaction_ID` int NOT NULL,
  `User_ID` int DEFAULT NULL,
  `Employee_ID` int DEFAULT NULL,
  `Transaction_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Payment_Method` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Cash',
  `Amount_Due` decimal(11,2) NOT NULL,
  `Amount_Paid` decimal(11,2) NOT NULL,
  `Sukli` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`Transaction_ID`, `User_ID`, `Employee_ID`, `Transaction_Date`, `Payment_Method`, `Amount_Due`, `Amount_Paid`, `Sukli`) VALUES
(1, 2, 2, '2024-11-25 04:04:25', 'Cash', 45000.00, 45000.00, 0.00),
(2, 1, 2, '2024-11-25 04:05:38', 'Cash', 81000.00, 81000.00, 0.00),
(3, 3, 2, '2024-11-25 04:06:04', 'Cash', 250000.00, 250000.00, 0.00),
(4, 4, 2, '2024-11-25 04:06:46', 'Cash', 110000.00, 110000.00, 0.00),
(5, 5, 2, '2024-11-25 04:07:23', 'Cash', 87000.00, 1000000.00, 913000.00),
(6, 6, 2, '2024-11-25 04:08:16', 'Cash', 43000.00, 50000.00, 7000.00),
(7, 6, 2, '2024-11-25 04:08:44', 'Cash', 115000.00, 120000.00, 5000.00),
(8, 7, 2, '2024-11-25 04:09:51', 'Cash', 125000.00, 130000.00, 5000.00),
(9, 8, 2, '2024-11-25 04:11:17', 'Cash', 320000.00, 500000.00, 180000.00),
(10, 9, 2, '2024-11-25 04:12:21', 'Cash', 400288.00, 500000.00, 99712.00),
(11, 10, 2, '2024-11-25 04:12:52', 'Cash', 110000.00, 150000.00, 40000.00),
(12, 12, 2, '2024-11-25 04:16:48', 'Cash', 43000.00, 500000.00, 457000.00),
(13, 13, 2, '2024-11-25 04:17:27', 'Cash', 45000.00, 50000.00, 5000.00),
(14, 13, 2, '2024-11-25 04:18:06', 'Cash', 125000.00, 145000.00, 20000.00),
(15, 10, 2, '2024-11-25 04:18:36', 'Cash', 38000.00, 50000.00, 12000.00),
(16, 12, 2, '2024-11-25 04:19:09', 'Cash', 43000.00, 50000.00, 7000.00),
(17, 12, 2, '2024-11-25 04:19:56', 'Cash', 50000.00, 50000.00, 0.00),
(18, 2, 2, '2024-11-25 04:20:49', 'Cash', 47000.00, 60000.00, 13000.00),
(19, 12, 2, '2024-11-25 04:21:11', 'Cash', 50000.00, 50000.00, 0.00),
(20, 2, 2, '2024-11-25 04:21:57', 'Cash', 645864.00, 700000.00, 54136.00),
(21, 3, 2, '2024-11-25 04:22:45', 'Cash', 375000.00, 500000.00, 125000.00),
(22, 6, 2, '2024-11-25 04:23:54', 'Cash', 125000.00, 130000.00, 5000.00),
(23, 10, 2, '2024-11-25 04:24:47', 'Cash', 43000.00, 43000.00, 0.00),
(24, 4, 2, '2024-11-25 04:25:12', 'Cash', 158000.00, 200000.00, 42000.00),
(25, 1, 2, '2024-11-25 04:25:43', 'Cash', 632576.00, 700000.00, 67424.00),
(26, 1, 2, '2024-11-25 04:25:55', 'Cash', 507576.00, 600000.00, 92424.00),
(27, 4, 2, '2024-11-25 04:26:18', 'Cash', 100000.00, 100000.00, 0.00),
(28, 7, 2, '2024-11-25 04:27:05', 'Cash', 175000.00, 200000.00, 25000.00),
(29, 7, 2, '2024-11-25 04:27:18', 'Cash', 275000.00, 300000.00, 25000.00),
(30, 13, 2, '2024-11-25 04:27:37', 'Cash', 322000.00, 322000.00, 0.00),
(31, 16, 3, '2024-11-25 06:33:06', 'Cash', 45000.00, 46000.00, 1000.00),
(32, 15, 3, '2024-11-25 06:35:10', 'Cash', 45000.00, 450000.00, 405000.00);

-- --------------------------------------------------------

--
-- Table structure for table `urder`
--

CREATE TABLE `urder` (
  `Order_ID` int NOT NULL,
  `Transaction_ID` int NOT NULL,
  `Guitar_ID` int NOT NULL,
  `Quantity` int NOT NULL,
  `Total_Price` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `urder`
--

INSERT INTO `urder` (`Order_ID`, `Transaction_ID`, `Guitar_ID`, `Quantity`, `Total_Price`) VALUES
(1, 1, 1, 1, 45000.00),
(2, 2, 6, 1, 43000.00),
(3, 2, 7, 1, 38000.00),
(4, 3, 3, 5, 250000.00),
(5, 4, 8, 1, 110000.00),
(6, 5, 4, 1, 49000.00),
(7, 5, 7, 1, 38000.00),
(8, 6, 6, 1, 43000.00),
(9, 7, 5, 1, 115000.00),
(10, 8, 9, 1, 125000.00),
(11, 9, 2, 6, 282000.00),
(12, 10, 9, 1, 125000.00),
(13, 10, 10, 1, 117288.00),
(14, 10, 6, 1, 43000.00),
(15, 10, 5, 1, 115000.00),
(16, 11, 8, 1, 110000.00),
(17, 12, 6, 1, 43000.00),
(18, 13, 1, 1, 45000.00),
(19, 14, 9, 1, 125000.00),
(20, 15, 7, 1, 38000.00),
(21, 16, 6, 1, 43000.00),
(22, 17, 3, 1, 50000.00),
(23, 18, 2, 1, 47000.00),
(24, 19, 3, 1, 50000.00),
(25, 20, 1, 4, 180000.00),
(26, 20, 7, 3, 114000.00),
(27, 20, 10, 3, 351864.00),
(28, 21, 9, 3, 375000.00),
(29, 22, 9, 1, 125000.00),
(30, 23, 6, 1, 43000.00),
(31, 24, 6, 1, 43000.00),
(32, 24, 5, 1, 115000.00),
(33, 25, 6, 1, 43000.00),
(34, 25, 5, 2, 230000.00),
(35, 25, 10, 2, 234576.00),
(36, 25, 9, 1, 125000.00),
(37, 26, 6, 1, 43000.00),
(38, 26, 5, 2, 230000.00),
(39, 26, 10, 2, 234576.00),
(40, 27, 11, 1, 100000.00),
(41, 28, 9, 1, 125000.00),
(42, 28, 3, 1, 50000.00),
(43, 29, 9, 1, 125000.00),
(44, 29, 3, 3, 150000.00),
(45, 30, 9, 1, 125000.00),
(46, 30, 3, 3, 150000.00),
(47, 30, 2, 1, 47000.00),
(48, 31, 1, 1, 45000.00),
(49, 32, 1, 1, 45000.00);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_ID` int NOT NULL,
  `First_Name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Last_Name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Age` int DEFAULT NULL,
  `Contact_Number` varchar(20) DEFAULT NULL,
  `Address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Profile_Picture` varchar(255) DEFAULT NULL,
  `Role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'User',
  `Purchase_Status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `First_Name`, `Last_Name`, `Age`, `Contact_Number`, `Address`, `Username`, `Password`, `Email`, `Profile_Picture`, `Role`, `Purchase_Status`) VALUES
(1, 'John', 'Santos', NULL, '09234756374', NULL, 'john', '$2y$12$z4Ogj0iEvuN.p5NdUzT4yeMQU7Hm6vwskdYvUYFINooVvK4RZX6.6', 'john.santos@gmail.com', NULL, 'User', 'Walk-in'),
(2, 'Maria', 'Reyes', NULL, '09874323366', NULL, 'maria', '$2y$12$CIG1gvasr5vWh8dJGR1CR.zpbp37AlBofYq7TYACJOLQG2cXcPi56', 'maria.reyes@gmail.com', NULL, 'User', 'Walk-in'),
(3, 'Juan', 'Cruz', NULL, '09777665555', NULL, 'juan', '$2y$12$/AeoeVHQqvq131lQqhtv.uoenZO1iDxRgT2.u37rAgsL6JYVLUDPO', 'juan.cruz@gmail.com', NULL, 'User', 'Walk-in'),
(4, 'Ana ', 'Dela Cruz', NULL, '09999445666', NULL, 'ana', '$2y$12$IdqUUG/43NK8yoKnSC/e9..Sxx99uhSq4nHmAmBbMQa2lx/XKeOlq', 'ana.delacruz@gmail.com', NULL, 'User', 'Walk-in'),
(5, 'Pedro', 'Torres', NULL, '09887766666', NULL, 'pedro', '$2y$12$50Q1v3t47U2RHNFuNesYM.qarARYLXjlYohfRf5bkP.HS6vIbM7Te', 'pedro.torres@gmail.com', NULL, 'User', 'Walk-in'),
(6, 'Rosa', 'Lopez', NULL, '09883343434', NULL, 'rosa', '$2y$12$8uxOllfLFpjiU2inTrw.1.mTgZq655WFnep.Hp5HZ6CzHevSC4xUC', 'rosa.lopez@gmail.com', NULL, 'User', 'Walk-in'),
(7, 'Jose', 'Bautista', NULL, '09234654444', NULL, 'jose', '$2y$12$ulrVJivYJE3wzJxNcMpEdOcrLX0J1MhGyoFS71zuWIeQTt6MyMZK2', 'jose.bautista@gmail.com', NULL, 'User', 'Walk-in'),
(8, 'Carmen', 'Hernandez', NULL, '09343427777', NULL, 'carmen', '$2y$12$neRFeug/kvsXrQAxlU80Ve5K3FzY4Oxi0pNg.glREqkzpJFNaxEXy', 'carmen.hernandez@gmail.com', NULL, 'User', 'Walk-in'),
(9, 'Miguel', 'Ramos', NULL, '09888765555', NULL, 'miguel', '$2y$12$3fjqrQbj5glh3OB/feQHgOhTDDXdUNON1umlcsXz3uJ/N2qDvRXgy', 'miguel.ramos@gmail.com', NULL, 'User', 'Walk-in'),
(10, 'Elena', 'Mendoza', NULL, '09574434322', NULL, 'elena', '$2y$12$mJmwfcJWigIKflpwRb6PLOAEXWbLdE6KwPwOdj.gS3HeO4fN91Fp.', 'elena.mendoza@gmail.com', NULL, 'User', 'Walk-in'),
(11, 'Syrene', 'Flores', NULL, '09877743434', NULL, 'syrene', '$2y$12$pkVbVocqD2lJXxaAV2zSVebI20Xq9reS.VdKCQT.bTVuLb8.hHBry', 'syrene.flores@gmail.com', NULL, 'User', NULL),
(12, 'Arby', 'Jamoralin', NULL, '09823111566', NULL, 'arby', '$2y$12$cmVWpTFRUL9ig9WlECSeu.BgecAuxRwCAGyMJiqOpB4pBNKCwjkzK', 'arby@gmail.com', NULL, 'User', 'Walk-in'),
(13, 'Rhogie', 'Ladia', NULL, '09545454545', NULL, 'rhogie', '$2y$12$t.HrNlsTowMtHJwSIcT2xuYAC8XV2vnI1pLE7C61yL7eo4nSCLLbm', 'rhogie@gmail.com', NULL, 'User', 'Walk-in'),
(14, 'Mae', 'Santos', NULL, '09877765444', NULL, 'mae', '$2y$12$PddbwaEFRAMXIzc7eCteSuyUNl1cI4.K0.85ZEzheHmDoAa4O/36K', 'mae@gmail.com', NULL, 'User', NULL),
(15, 'axcelll', 'axcelll', 19, '0923455677', 'dasma, cavite', 'martin', '$2y$12$PUfEGiO3BduBU/f.f.v6L.8bSDVzd.6gISA6SnInJkQZn1m5BZOPq', 'mart@gmail.com', NULL, 'User', 'Walk-in'),
(16, 'Jesselle', 'Alijah', NULL, '09878787777', NULL, 'jess', '$2y$12$Q92QFPZCOg5ExQEY41Oibu.HbGiPLaklFpEnxT2d1LKkRcxx0lUdm', 'jess@gmail.com', NULL, 'User', 'Walk-in'),
(17, NULL, NULL, NULL, NULL, NULL, 'Adam', '$2y$12$CPgiM4naiFMp0kaD.qXWlueg8vCZVWQFWKU/sXiF8pHpOpyYYjGve', 'adam@gmail.com', NULL, 'User', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`Employee_ID`);

--
-- Indexes for table `guitar`
--
ALTER TABLE `guitar`
  ADD PRIMARY KEY (`GuitarID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`Transaction_ID`),
  ADD KEY `transaction_ibfk_1` (`Employee_ID`),
  ADD KEY `transaction_ibfk_2` (`User_ID`);

--
-- Indexes for table `urder`
--
ALTER TABLE `urder`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `urder_ibfk_3` (`Transaction_ID`),
  ADD KEY `urder_ibfk_2` (`Guitar_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `Employee_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `guitar`
--
ALTER TABLE `guitar`
  MODIFY `GuitarID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `Transaction_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `urder`
--
ALTER TABLE `urder`
  MODIFY `Order_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`Employee_ID`) REFERENCES `employee` (`Employee_ID`) ON DELETE SET NULL ON UPDATE RESTRICT,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE SET NULL ON UPDATE RESTRICT;

--
-- Constraints for table `urder`
--
ALTER TABLE `urder`
  ADD CONSTRAINT `urder_ibfk_2` FOREIGN KEY (`Guitar_ID`) REFERENCES `guitar` (`GuitarID`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `urder_ibfk_3` FOREIGN KEY (`Transaction_ID`) REFERENCES `transaction` (`Transaction_ID`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
