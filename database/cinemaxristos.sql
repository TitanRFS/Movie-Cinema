-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2023 at 01:15 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cinemaxristos`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `searchmovie` (IN `movie` VARCHAR(1000))  NO SQL SELECT * from movies where Movie_Name like CONCAT('%', movie, '%')$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', '1234'),
('admin', '12345'),
('admin', '$2y$10$7jrkV1JK');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `username` varchar(200) NOT NULL,
  `movie` varchar(200) NOT NULL,
  `theatre` varchar(200) NOT NULL,
  `date` varchar(100) NOT NULL,
  `movie_time` varchar(100) NOT NULL,
  `location` varchar(200) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`username`, `movie`, `theatre`, `date`, `movie_time`, `location`, `id`) VALUES
('user', 'Avengers:Endgame', 'CineKronio', '15-22-2022', '22:00', 'Serres', 10),
('user1', 'MI-Fallout(2018)', 'Village', '16-12-2022', '10:00', 'Thessaloniki', 11);

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `Movie_Name` varchar(50) NOT NULL,
  `Actor` varchar(25) NOT NULL,
  `Actress` varchar(25) NOT NULL,
  `Release_date` varchar(50) NOT NULL,
  `Director` varchar(50) NOT NULL,
  `Movie_id` int(100) NOT NULL,
  `poster` varchar(300) NOT NULL,
  `RunTime` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `ActorImg` varchar(300) NOT NULL,
  `ActressImg` varchar(400) NOT NULL,
  `Description` varchar(4000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`Movie_Name`, `Actor`, `Actress`, `Release_date`, `Director`, `Movie_id`, `poster`, `RunTime`, `type`, `ActorImg`, `ActressImg`, `Description`) VALUES
('Avengers:Endgame', 'Robert Downey .JR', 'Elisabeth Olshen', '2020-10-10', 'Russo Brothers', 29, 'Images/avengers.jpg', '3 hr ', 'Action', 'Images/licensed-image.jpg', 'Images/licensed-image (1).jpg', 'After half of all life is snapped away by Thanos, the Avengers are left scattered and divided.\nNow with a way to reverse the damage, the Avengers and their allies must assemble once more and learn to put differences aside in order to work together and set things right.\n'),
('MI-Fallout (2018)', 'Tom Cruise', 'Rebecca Ferguson', '2018-08-10', 'Christopher Nolan', 30, 'Images/MISSION-IMPOSSIBLE-FALLOUT.jpg', '2 hr 20 min', 'Action', 'Images/licencsed-image.jpg(2)', 'Images/723292_v9_bc.jpg', 'Ethan Hunt and his IMF team, along with some familiar allies,\nrace against time after a mission gone wrong.');

-- --------------------------------------------------------

--
-- Table structure for table `theatres`
--

CREATE TABLE `theatres` (
  `Theatre_id` int(200) NOT NULL,
  `Theatre_Name` varchar(200) NOT NULL,
  `Location` varchar(300) NOT NULL,
  `Movie_Name` varchar(200) NOT NULL,
  `time1` varchar(200) NOT NULL,
  `time2` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `theatres`
--

INSERT INTO `theatres` (`Theatre_id`, `Theatre_Name`, `Location`, `Movie_Name`, `time1`, `time2`) VALUES
(3, 'CineKronio', 'Serres', 'Avengers:Endgame', '22:00', ''),
(4, 'Village', 'Thessaloniki', 'MI-Fallout (2018)', '13:00', '10:00'),
(5, 'Square', 'Athens', 'MI-Fallout (2018)', '20:00', ''),
(5, 'Square', 'Athens', 'Avengers:Endgame', '23:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `timings`
--

CREATE TABLE `timings` (
  `id` int(200) NOT NULL,
  `showtime` varchar(200) NOT NULL,
  `Theatre_Name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `timings`
--

INSERT INTO `timings` (`id`, `showtime`, `Theatre_Name`) VALUES
(5, '13:00', 'CineKronio'),
(6, '10:00', 'Village');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `email`, `password`) VALUES
('user', 'user@gmail.com', '$2y$10$7jrkV1JKffwwHisbfiAYWus/glfJrGeo.ZwCctJVq4lbB3xD29W1y'),
('user1', 'user1@gmail.com', '$2y$10$7jrkV1JKffwwHisbfiAYWus/glfJrGeo.ZwCctJVq4lbB3xD29W1y'),
('user2', 'user2@gmail.com', '123456'),
('xristos', 'xristos@gmail.com', '1234');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
