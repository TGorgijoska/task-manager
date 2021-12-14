-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 31, 2021 at 04:44 PM
-- Server version: 5.6.34
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `cekori`
--

CREATE TABLE `cekori` (
  `id` int(11) NOT NULL,
  `zadaci_id` int(11) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `opis` text,
  `zavrsen` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cekori`
--

INSERT INTO `cekori` (`id`, `zadaci_id`, `ime`, `opis`, `zavrsen`) VALUES
(3, 6, 'дел 1', NULL, 0),
(4, 6, 'дел 2', NULL, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `denesni_zadaci`
-- (See below for the actual view)
--
CREATE TABLE `denesni_zadaci` (
`korisnikId` int(11)
,`proektIme` varchar(50)
,`zadacaIme` varchar(50)
,`prioritet` varchar(10)
,`deadline` date
);

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `date_created` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `username`, `email`, `password`, `date_created`) VALUES
(10, 'TatjanaG', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proekti`
--

CREATE TABLE `proekti` (
  `ime` varchar(50) NOT NULL,
  `korisnik_id` int(11) NOT NULL,
  `opis` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `proekti`
--

INSERT INTO `proekti` (`ime`, `korisnik_id`, `opis`) VALUES
('Информациски системи', 10, '');

-- --------------------------------------------------------

--
-- Table structure for table `zadaci`
--

CREATE TABLE `zadaci` (
  `id` int(11) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `opis` text,
  `proekt_id` varchar(20) NOT NULL,
  `prioritet` varchar(10) NOT NULL,
  `deadline` date DEFAULT NULL,
  `zavrsen` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zadaci`
--

INSERT INTO `zadaci` (`id`, `ime`, `opis`, `proekt_id`, `prioritet`, `deadline`, `zavrsen`) VALUES
(5, 'Домашно1', NULL, 'Информациски системи', 'низок', '2021-06-06', 0),
(6, 'Домашно2', NULL, 'Информациски системи', 'низок', '2021-06-07', 0);

-- --------------------------------------------------------

--
-- Structure for view `denesni_zadaci`
--
DROP TABLE IF EXISTS `denesni_zadaci`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `denesni_zadaci`  AS  select `k`.`id` AS `korisnikId`,`p`.`ime` AS `proektIme`,`z`.`ime` AS `zadacaIme`,`z`.`prioritet` AS `prioritet`,`z`.`deadline` AS `deadline` from ((`korisnici` `k` join `proekti` `p`) join `zadaci` `z`) where ((`k`.`id` = `p`.`korisnik_id`) and (`p`.`ime` = `z`.`proekt_id`) and (`z`.`zavrsen` = 0) and (`z`.`deadline` = curdate())) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cekori`
--
ALTER TABLE `cekori`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zadaci_id` (`zadaci_id`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proekti`
--
ALTER TABLE `proekti`
  ADD PRIMARY KEY (`ime`,`korisnik_id`),
  ADD KEY `korisnik_id` (`korisnik_id`);

--
-- Indexes for table `zadaci`
--
ALTER TABLE `zadaci`
  ADD PRIMARY KEY (`id`,`proekt_id`),
  ADD KEY `proekt_id` (`proekt_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cekori`
--
ALTER TABLE `cekori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `zadaci`
--
ALTER TABLE `zadaci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cekori`
--
ALTER TABLE `cekori`
  ADD CONSTRAINT `cekori_ibfk_1` FOREIGN KEY (`zadaci_id`) REFERENCES `zadaci` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `proekti`
--
ALTER TABLE `proekti`
  ADD CONSTRAINT `proekti_ibfk_1` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnici` (`id`);

--
-- Constraints for table `zadaci`
--
ALTER TABLE `zadaci`
  ADD CONSTRAINT `zadaci_ibfk_1` FOREIGN KEY (`proekt_id`) REFERENCES `proekti` (`ime`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
