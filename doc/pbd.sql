-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2022 at 08:42 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pbd`
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
(128, 0, '', '', ''),
(131, 0, '', '', ''),
(150, 4, 'asdasdasdasd', 'asdASD', 'ASDASDsssssssssssssssssssssssssssssssssssssssssss2222222swwewewewe');

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
(4, 70, 'Hosni Marco');

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
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `nombre`, `phone`, `password`, `reg_date`) VALUES
(70, 'hosni.marco@gmail.com', 'Hosni Marco', 659376740, '74b87337454200d4d33f80c4663dc5e5', '2022-06-23 09:44:52');

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
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuarios_temp`
--

INSERT INTO `usuarios_temp` (`id`, `email`, `nombre`, `phone`, `password`, `reg_date`) VALUES
(91, 'hosni.marc3o@gmail.com', 'wwww', 659376740, 'e34a8899ef6468b74f8a1048419ccc8b', '2022-06-23 09:51:20');

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `listas`
--
ALTER TABLE `listas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `usuarios_temp`
--
ALTER TABLE `usuarios_temp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
