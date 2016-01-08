-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2016 at 02:59 PM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finalproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `known_languages`
--

CREATE TABLE `known_languages` (
  `id_known` int(11) NOT NULL,
  `login` varchar(64) NOT NULL,
  `language_id` int(11) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `known_languages`
--

INSERT INTO `known_languages` (`id_known`, `login`, `language_id`, `level`) VALUES
(2, 'Renan', 2, 90),
(3, 'Renan', 3, 70),
(4, 'Renan', 4, 60),
(5, 'Renan', 5, 100),
(12, 'yujia21', 2, 95),
(13, 'yujia21', 8, 70),
(14, 'yujia21', 3, 60),
(15, 'olivier', 3, 95),
(16, 'olivier', 2, 80),
(17, 'dominique', 2, 80),
(18, 'dominique', 3, 95);

-- --------------------------------------------------------

--
-- Table structure for table `langues`
--

CREATE TABLE `langues` (
  `langue_id` int(11) NOT NULL,
  `langue` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `langues`
--

INSERT INTO `langues` (`langue_id`, `langue`) VALUES
(2, 'english'),
(3, 'french'),
(4, 'spanish'),
(5, 'portuguese'),
(6, 'italian'),
(7, 'german'),
(8, 'chinese');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `login` varchar(64) NOT NULL,
  `password` varchar(40) NOT NULL,
  `name` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`login`, `password`, `name`, `lastname`, `birthdate`, `email`) VALUES
('dominique', '9cc140dd813383e134e7e365b203780da9376438', 'Dominique', 'Rossin', '1980-01-01', 'dominique.rossin@liafa.jussieu.fr'),
('olivier', '663194f2b9123a38cd9e2e2811f8d2fd387b765e', 'Olivier', 'Serre', '1980-01-01', 'olivier.serre@polytechnique.edu'),
('Renan', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Renan', 'Fernandes Moreira', '1995-01-17', 'renan.fm@hotmail.com'),
('yujia21', 'c919163779ab49d74a23b847e280b78c6f7292f3', 'Yu Jia', 'Cheong', '1994-03-22', 'odonut@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `known_languages`
--
ALTER TABLE `known_languages`
  ADD PRIMARY KEY (`id_known`),
  ADD KEY `login` (`login`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `langues`
--
ALTER TABLE `langues`
  ADD PRIMARY KEY (`langue_id`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `known_languages`
--
ALTER TABLE `known_languages`
  MODIFY `id_known` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `langues`
--
ALTER TABLE `langues`
  MODIFY `langue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `known_languages`
--
ALTER TABLE `known_languages`
  ADD CONSTRAINT `language_constraint` FOREIGN KEY (`language_id`) REFERENCES `langues` (`langue_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `login_constraint` FOREIGN KEY (`login`) REFERENCES `utilisateurs` (`login`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
