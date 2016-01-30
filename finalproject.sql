-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2016 at 12:37 AM
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
-- Table structure for table `chatroom`
--

CREATE TABLE `chatroom` (
  `id_known` int(11) NOT NULL,
  `login1` varchar(64) CHARACTER SET utf8 NOT NULL,
  `login2` varchar(64) CHARACTER SET utf8 NOT NULL,
  `date` datetime NOT NULL,
  `message` text NOT NULL,
  `messageread` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chatroom`
--

INSERT INTO `chatroom` (`id_known`, `login1`, `login2`, `date`, `message`, `messageread`) VALUES
(11, 'yujia21', 'Renan', '2016-01-12 00:13:50', 'Hello! This is a first message!', 0),
(12, 'yujia21', 'dominique', '2016-01-12 00:14:00', 'Bonjour! ', 1),
(13, 'yujia21', 'olivier', '2016-01-12 00:14:06', 'Bonjour! ', 1),
(14, 'olivier', 'yujia21', '2016-01-12 00:19:31', 'Bonjour !', 1),
(15, 'dominique', 'olivier', '2016-01-12 00:21:19', 'Alors...', 1),
(16, 'dominique', 'Renan', '2016-01-12 00:21:28', 'Salut !', 0),
(17, 'dominique', 'yujia21', '2016-01-12 00:21:34', 'Yo !', 1),
(18, 'olivier', 'yujia21', '2016-01-20 15:28:11', 'Oh hello', 1),
(19, 'olivier', 'Renan', '2016-01-20 19:17:38', 'Hello from Olivier!', 0),
(20, 'olivier', 'yujia21', '2016-01-20 19:17:51', 'Do you check your messages?!', 1),
(21, 'olivier', 'dominique', '2016-01-20 19:17:58', 'Comme ça!', 0),
(22, 'yujia21', 'dominique', '2016-01-21 17:47:16', 'hello', 1),
(23, 'yujia21', 'olivier', '2016-01-29 15:49:42', 'hello', 1),
(24, 'olivier', 'yujia21', '2016-01-29 20:02:32', 'This is a new msg', 0),
(25, 'jonseetch', 'yujia21', '2016-01-29 20:58:11', '^^', 1),
(26, 'jonseetch', 'yujia21', '2016-01-29 20:58:17', '"/\\"', 1),
(27, 'jonseetch', 'yujia21', '2016-01-29 21:00:17', '~~~~', 1),
(28, 'cutewei97', 'yujia21', '2016-01-30 00:33:03', 'Sis!', 1),
(29, 'cutewei97', 'yujia21', '2016-01-30 00:34:13', 'Sis!', 1),
(30, 'cutewei97', 'yujia21', '2016-01-30 00:41:51', 'Sis!', 1),
(31, 'cutewei97', 'renan', '2016-01-30 00:46:39', 'hey', 0),
(32, 'cutewei97', 'renan', '2016-01-30 00:47:12', 'hey', 0),
(33, 'cutewei97', 'renan', '2016-01-30 00:47:59', 'hey', 0),
(34, 'yujia21', 'cutewei97', '2016-01-30 00:56:04', 'Bro!', 1),
(35, 'yujia21', 'cutewei97', '2016-01-30 00:56:46', 'Bro!', 1),
(36, 'yujia21', 'cutewei97', '2016-01-30 00:58:04', 'test update', 1),
(37, 'yujia21', 'cutewei97', '2016-01-30 01:00:10', 'another test', 1),
(38, 'cutewei97', 'yujia21', '2016-01-30 01:00:22', 'doesn''t work', 1),
(39, 'cutewei97', 'yujia21', '2016-01-30 01:01:07', 'doesn''t work', 1),
(40, 'cutewei97', 'yujia21', '2016-01-30 01:01:22', 'doesn''t work', 1),
(41, 'yujia21', 'cutewei97', '2016-01-30 10:53:57', 'hey', 1),
(42, 'yujia21', 'cutewei97', '2016-01-30 10:54:15', 'does it work now', 1),
(43, 'yujia21', 'cutewei97', '2016-01-30 10:54:44', 'try', 1),
(44, 'yujia21', 'cutewei97', '2016-01-30 11:00:31', 'lol', 1),
(45, 'yujia21', 'Renan', '2016-01-30 20:38:18', 'yo', 0),
(46, 'cutewei97', 'yujia21', '2016-01-30 20:38:48', 'hahaha', 1),
(47, 'dominique', 'gautier', '2016-01-30 23:26:34', 'hello!', 0),
(48, 'dominique', 'gautier', '2016-01-30 23:26:59', 'another message!', 0),
(49, 'dominique', 'yujia21', '2016-01-30 23:27:09', 'Heya', 1),
(50, 'dominique', 'yujia21', '2016-01-30 23:28:06', 'Heya', 1),
(51, 'dominique', 'yujia21', '2016-01-30 23:29:10', 'More messaging', 1),
(52, 'yujia21', 'dominique', '2016-01-30 23:29:16', 'hello', 1),
(53, 'dominique', 'yujia21', '2016-01-30 23:51:16', 'More messaging', 1),
(54, 'yujia21', 'dominique', '2016-01-30 23:51:24', 'test', 1),
(55, 'dominique', 'yujia21', '2016-01-30 23:52:34', 'More messaging', 1),
(56, 'yujia21', 'dominique', '2016-01-30 23:52:43', '', 1),
(57, 'dominique', 'yujia21', '2016-01-30 23:58:49', 'More messaging', 1),
(58, 'yujia21', 'dominique', '2016-01-30 23:59:03', 'still doesn''t work', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `message` text NOT NULL,
  `name` varchar(64) NOT NULL,
  `commentread` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `email`, `message`, `name`, `commentread`) VALUES
(16, 'dominique.rossin@liafa.jussieu.fr', '', 'Dominique Rossin', 1),
(17, 'dominique.rossin@liafa.jussieu.fr', 'Oh', 'Dominique Rossin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `known_languages`
--

CREATE TABLE `known_languages` (
  `id_known` int(11) NOT NULL,
  `login` varchar(64) NOT NULL,
  `language_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `ratedlevel` int(11) NOT NULL,
  `conversations` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `known_languages`
--

INSERT INTO `known_languages` (`id_known`, `login`, `language_id`, `level`, `ratedlevel`, `conversations`) VALUES
(2, 'Renan', 2, 90, 90, 3),
(3, 'Renan', 3, 70, 70, 9),
(4, 'Renan', 4, 60, 0, 0),
(5, 'Renan', 5, 100, 0, 0),
(12, 'yujia21', 2, 90, 90, 6),
(13, 'yujia21', 8, 80, 0, 0),
(14, 'yujia21', 3, 70, 79, 2),
(15, 'olivier', 3, 95, 100, 1),
(16, 'olivier', 2, 85, 0, 0),
(17, 'dominique', 2, 80, 0, 0),
(18, 'dominique', 3, 95, 0, 0),
(21, 'cutewei97', 2, 90, 0, 0),
(22, 'cutewei97', 8, 90, 0, 0),
(23, 'gautier', 3, 100, 0, 0),
(25, 'jonseetch', 2, 90, 0, 0),
(26, 'jonseetch', 8, 70, 0, 0),
(27, 'gautier', 6, 20, 0, 0),
(28, 'gautier', 2, 80, 0, 0);

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
-- Table structure for table `rating_requests`
--

CREATE TABLE `rating_requests` (
  `idknown` int(11) NOT NULL,
  `login1` varchar(64) CHARACTER SET utf8 NOT NULL,
  `login2` varchar(64) CHARACTER SET utf8 NOT NULL,
  `language_id` int(11) NOT NULL,
  `ratedlevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating_requests`
--

INSERT INTO `rating_requests` (`idknown`, `login1`, `login2`, `language_id`, `ratedlevel`) VALUES
(6, 'yujia21', 'Renan', 2, 90),
(7, 'yujia21', 'Renan', 3, 70),
(9, 'olivier', 'dominique', 3, 90),
(10, 'jonseetch', 'yujia21', 8, 80);

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
  `email` varchar(128) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`login`, `password`, `name`, `lastname`, `birthdate`, `email`, `admin`) VALUES
('cutewei97', '009e944a62e5ce86c719a428c2a0e30f5d19a593', 'Yi Wei', 'Cheong', '1997-06-25', 'yiwei97@gmail.com', 0),
('dominique', '663194f2b9123a38cd9e2e2811f8d2fd387b765e', 'Dominique', 'Rossin', '1980-01-01', 'dominique.rossin@liafa.jussieu.fr', 1),
('gautier', '14f4d297a2ae0a94a75744e9d2b88cf6c9eae763', 'gautier', 'houriez', '1995-01-18', 'houriez.g@gmail.com', 0),
('jonseetch', 'cc2f55b99e53efbcfa567a7a20da406417281c2e', 'Jonathan', 'Seet', '1994-04-28', 'jonseetch@gmail.com', 0),
('olivier', '9cc140dd813383e134e7e365b203780da9376438', 'Olivier', 'Serre', '1980-01-01', 'olivier.serre@polytechnique.edu', 0),
('Renan', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Renan', 'Fernandes Moreira', '1995-01-17', 'renan.fm@hotmail.com', 1),
('yujia21', 'c919163779ab49d74a23b847e280b78c6f7292f3', 'Yu Jia', 'Cheong', '1994-03-22', 'yu-jia.cheong@polytechnique.edu', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chatroom`
--
ALTER TABLE `chatroom`
  ADD PRIMARY KEY (`id_known`),
  ADD KEY `login1` (`login1`,`login2`),
  ADD KEY `recipient` (`login2`),
  ADD KEY `messageread` (`messageread`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `name` (`name`),
  ADD KEY `commentread` (`commentread`);

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
-- Indexes for table `rating_requests`
--
ALTER TABLE `rating_requests`
  ADD PRIMARY KEY (`idknown`),
  ADD KEY `login1` (`login1`) USING BTREE,
  ADD KEY `login2` (`login2`) USING BTREE,
  ADD KEY `language_id` (`language_id`,`ratedlevel`) USING BTREE;

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chatroom`
--
ALTER TABLE `chatroom`
  MODIFY `id_known` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `known_languages`
--
ALTER TABLE `known_languages`
  MODIFY `id_known` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `langues`
--
ALTER TABLE `langues`
  MODIFY `langue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `rating_requests`
--
ALTER TABLE `rating_requests`
  MODIFY `idknown` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `chatroom`
--
ALTER TABLE `chatroom`
  ADD CONSTRAINT `recipient` FOREIGN KEY (`login2`) REFERENCES `utilisateurs` (`login`),
  ADD CONSTRAINT `sender` FOREIGN KEY (`login1`) REFERENCES `utilisateurs` (`login`);

--
-- Constraints for table `known_languages`
--
ALTER TABLE `known_languages`
  ADD CONSTRAINT `language_constraint` FOREIGN KEY (`language_id`) REFERENCES `langues` (`langue_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `login_constraint` FOREIGN KEY (`login`) REFERENCES `utilisateurs` (`login`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rating_requests`
--
ALTER TABLE `rating_requests`
  ADD CONSTRAINT `language` FOREIGN KEY (`language_id`) REFERENCES `langues` (`langue_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
