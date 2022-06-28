-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: sql11.freemysqlhosting.net
-- Generation Time: Jun 28, 2022 at 10:43 AM
-- Server version: 5.5.62-0ubuntu0.14.04.1
-- PHP Version: 7.0.33-0ubuntu0.16.04.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql11502507`
--

-- --------------------------------------------------------

--
-- Table structure for table `listaobjetos`
--

CREATE TABLE `listaobjetos` (
  `id` int(10) NOT NULL,
  `idlist` int(10) NOT NULL,
  `task` varchar(30) NOT NULL,
  `lenguage` varchar(30) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `listaobjetos`
--

INSERT INTO `listaobjetos` (`id`, `idlist`, `task`, `lenguage`, `descripcion`) VALUES
(152, 5, 'asdasdasdddddddd', 'asdasd', 'asdasdasdasd'),
(154, 5, 'aasdasd', 'asdasd', 'asdasdasdasdasdasd'),
(155, 5, 'asdasd', 'asdasd', 'asdasdasdasdasd');

-- --------------------------------------------------------

--
-- Table structure for table `listas`
--

CREATE TABLE `listas` (
  `id` int(10) NOT NULL,
  `iduser` int(10) NOT NULL,
  `tablename` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `listas`
--

INSERT INTO `listas` (`id`, `iduser`, `tablename`) VALUES
(5, 71, 'Hosni Marco');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `phone` int(9) NOT NULL,
  `password` char(32) CHARACTER SET latin1 NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `token` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `nombre`, `phone`, `password`, `reg_date`, `token`) VALUES
(71, 'hosni.marco@gmail.com', 'Hosni Marco', 659376740, '74b87337454200d4d33f80c4663dc5e5', '2022-06-28 10:03:14', '');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_temp`
--

CREATE TABLE `usuarios_temp` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `phone` int(9) NOT NULL,
  `password` char(32) CHARACTER SET latin1 NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuarios_temp`
--

INSERT INTO `usuarios_temp` (`id`, `email`, `nombre`, `phone`, `password`, `reg_date`) VALUES
(92, 'asdasd@gmail.com', 'asdasdasd', 123123123, 'a8f5f167f44f4964e6c998dee827110c', '2022-06-28 07:10:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `listaobjetos`
--
ALTER TABLE `listaobjetos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listas`
--
ALTER TABLE `listas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios_temp`
--
ALTER TABLE `usuarios_temp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `listaobjetos`
--
ALTER TABLE `listaobjetos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;
--
-- AUTO_INCREMENT for table `listas`
--
ALTER TABLE `listas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT for table `usuarios_temp`
--
ALTER TABLE `usuarios_temp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
