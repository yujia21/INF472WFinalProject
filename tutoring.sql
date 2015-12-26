-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2015 at 11:52 PM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tutoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `known_languages`
--

CREATE TABLE `known_languages` (
  `id_known` int(11) NOT NULL,
  `login` varchar(64) NOT NULL,
  `level` int(11) NOT NULL,
  `language` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `known_languages`
--

INSERT INTO `known_languages` (`id_known`, `login`, `level`, `language`) VALUES
(13, 'Renan', 90, 'english'),
(14, 'Renan', 100, 'portuguese'),
(15, 'Renan', 80, 'french'),
(16, 'Renan', 70, 'spanish'),
(17, 'yj', 100, 'english'),
(18, 'Henrique', 100, 'portuguese'),
(19, 'Henrique', 80, 'french'),
(20, 'Henrique', 70, 'english'),
(21, 'Henrique', 50, 'spanish');

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
(8, 'chinese'),
(2, 'english'),
(3, 'french'),
(7, 'german'),
(6, 'italian'),
(5, 'portuguese'),
(4, 'spanish');

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
('Henrique', '8cb2237d0679ca88db6464eac60da96345513964', 'Henrique', 'Gasparini Fiuza do Nascimento', '1996-02-23', 'henriquegfn@gmail.com'),
('Renan', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Renan', 'Fernandes Moreira', '1995-01-17', 'renanfm17@gmail.com'),
('yj', '4d13fcc6eda389d4d679602171e11593eadae9b9', 'test', 'testy', '1994-03-22', 'lala@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `known_languages`
--
ALTER TABLE `known_languages`
  ADD PRIMARY KEY (`id_known`),
  ADD KEY `login` (`login`),
  ADD KEY `language` (`language`);

--
-- Indexes for table `langues`
--
ALTER TABLE `langues`
  ADD PRIMARY KEY (`langue_id`),
  ADD KEY `langue` (`langue`);

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
  MODIFY `id_known` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
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
  ADD CONSTRAINT `language_constraint` FOREIGN KEY (`language`) REFERENCES `langues` (`langue`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `login_constraint` FOREIGN KEY (`login`) REFERENCES `utilisateurs` (`login`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
