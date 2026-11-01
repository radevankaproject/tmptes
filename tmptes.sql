-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2019 at 04:50 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql_skripsi_tes`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_uji`
--

CREATE TABLE `data_uji` (
  `id` int(11) NOT NULL,
  `koridorID` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tahun` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_uji`
--

INSERT INTO `data_uji` (`id`, `koridorID`, `jumlah`, `tahun`) VALUES
(1, 1, 1044502, 2018),
(2, 2, 167492, 2018),
(3, 3, 50092, 2018),
(4, 4, 1283, 2018),
(5, 5, 390490, 2018),
(6, 6, 102815, 2018),
(7, 7, 623546, 2018),
(8, 8, 79763, 2018),
(9, 9, 242608, 2018),
(10, 10, 160815, 2018),
(11, 11, 140570, 2018),
(12, 12, 16617, 2018),
(13, 13, 14753, 2018),
(14, 14, 6635, 2018),
(15, 15, 19541, 2018),
(16, 16, 6576, 2018),
(17, 17, 187063, 2018),
(18, 18, 41480, 2018),
(19, 19, 21761, 2018),
(20, 20, 6995, 2018),
(21, 21, 26072, 2018),
(22, 22, 10630, 2018),
(23, 23, 148464, 2018),
(24, 24, 38791, 2018),
(25, 25, 13194, 2018),
(26, 26, 14180, 2018);

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `id` int(11) NOT NULL,
  `jenisTiket` varchar(10) NOT NULL,
  `hargaTiket` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id`, `jenisTiket`, `hargaTiket`) VALUES
(1, 'Umum', 4000),
(2, 'Pelajar', 3000);

-- --------------------------------------------------------

--
-- Table structure for table `koridor`
--

CREATE TABLE `koridor` (
  `id` int(11) NOT NULL,
  `jenisID` int(11) NOT NULL,
  `koridor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `koridor`
--

INSERT INTO `koridor` (`id`, `jenisID`, `koridor`) VALUES
(1, 1, 'Koridor 01'),
(2, 2, 'Koridor 01'),
(3, 1, 'Koridor 1A'),
(4, 2, 'Koridor 1A'),
(5, 1, 'Koridor 02'),
(6, 2, 'Koridor 02'),
(7, 1, 'Koridor 03'),
(8, 2, 'Koridor 03'),
(9, 1, 'Koridor 4A'),
(10, 2, 'Koridor 4A'),
(11, 1, 'Koridor 4B'),
(12, 2, 'Koridor 4B'),
(13, 1, 'Koridor 4C'),
(14, 2, 'Koridor 4C'),
(15, 1, 'Koridor 05'),
(16, 2, 'Koridor 05'),
(17, 1, 'Koridor 06'),
(18, 2, 'Koridor 06'),
(19, 1, 'Koridor 7A'),
(20, 2, 'Koridor 7A'),
(21, 1, 'Koridor 7B'),
(22, 2, 'Koridor 7B'),
(23, 1, 'Koridor 8A'),
(24, 2, 'Koridor 8A'),
(25, 1, 'Koridor 8B'),
(26, 2, 'Koridor 8B');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `pengaturan` varchar(20) NOT NULL,
  `value` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`pengaturan`, `value`) VALUES
('alpa', 0.5);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id` int(11) NOT NULL,
  `koridorID` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tahun` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `koridorID`, `jumlah`, `tahun`) VALUES
(1, 1, 1052325, 2015),
(2, 1, 959375, 2016),
(3, 1, 1051108, 2017),
(4, 1, 1044502, 2018),
(5, 2, 268515, 2015),
(6, 2, 192320, 2016),
(7, 2, 195248, 2017),
(8, 2, 167492, 2018),
(9, 3, 26332, 2017),
(10, 3, 50092, 2018),
(11, 4, 669, 2017),
(12, 4, 1283, 2018),
(13, 5, 343074, 2015),
(14, 5, 299022, 2016),
(15, 5, 353398, 2017),
(16, 5, 390490, 2018),
(17, 6, 101231, 2015),
(18, 6, 72510, 2016),
(19, 6, 95618, 2017),
(20, 6, 102815, 2018),
(21, 7, 480943, 2015),
(22, 7, 443860, 2016),
(23, 7, 478886, 2017),
(24, 7, 623546, 2018),
(25, 8, 90611, 2015),
(26, 8, 52269, 2016),
(27, 8, 58423, 2017),
(28, 8, 79763, 2018),
(29, 9, 171292, 2015),
(30, 9, 168365, 2016),
(31, 9, 196293, 2017),
(32, 9, 242608, 2018),
(33, 10, 135807, 2015),
(34, 10, 117850, 2016),
(35, 10, 128423, 2017),
(36, 10, 160815, 2018),
(37, 11, 175563, 2015),
(38, 11, 113144, 2016),
(39, 11, 128068, 2017),
(40, 11, 140570, 2018),
(41, 12, 46477, 2015),
(42, 12, 21191, 2016),
(43, 12, 15368, 2017),
(44, 12, 16617, 2018),
(45, 13, 14753, 2018),
(46, 14, 6635, 2018),
(47, 15, 40504, 2015),
(48, 15, 25258, 2016),
(49, 15, 14358, 2017),
(50, 15, 19541, 2018),
(51, 16, 8009, 2015),
(52, 16, 7567, 2016),
(53, 16, 2600, 2017),
(54, 16, 6576, 2018),
(55, 17, 215257, 2015),
(56, 17, 143772, 2016),
(57, 17, 160091, 2017),
(58, 17, 187063, 2018),
(59, 18, 50665, 2015),
(60, 18, 29647, 2016),
(61, 18, 27161, 2017),
(62, 18, 41480, 2018),
(63, 19, 140058, 2015),
(64, 19, 59489, 2016),
(65, 19, 22302, 2017),
(66, 19, 21761, 2018),
(67, 20, 48054, 2015),
(68, 19, 27355, 2016),
(69, 20, 8684, 2017),
(70, 20, 6995, 2018),
(71, 21, 8217, 2017),
(72, 21, 26072, 2018),
(73, 22, 2104, 2017),
(74, 22, 10630, 2018),
(75, 23, 155891, 2015),
(76, 23, 119794, 2016),
(77, 23, 92294, 2017),
(78, 23, 148464, 2018),
(79, 24, 44651, 2015),
(80, 24, 27283, 2016),
(81, 24, 23399, 2017),
(82, 24, 38791, 2018),
(83, 25, 19890, 2015),
(84, 25, 9543, 2016),
(85, 25, 7804, 2017),
(86, 25, 13194, 2018),
(87, 26, 21018, 2015),
(88, 26, 10894, 2016),
(89, 26, 10205, 2017),
(90, 26, 14180, 2018);

-- --------------------------------------------------------

--
-- Table structure for table `prediksi`
--

CREATE TABLE `prediksi` (
  `id` int(11) NOT NULL,
  `koridorID` int(11) DEFAULT NULL,
  `jenisID` int(11) DEFAULT NULL,
  `prediksi` int(12) DEFAULT NULL,
  `aktual` int(11) DEFAULT NULL,
  `error` int(11) DEFAULT NULL,
  `mape` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `nama`, `username`, `password`, `level`) VALUES
(1, 'Administrator', 'admin', 'admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_uji`
--
ALTER TABLE `data_uji`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `koridor`
--
ALTER TABLE `koridor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prediksi`
--
ALTER TABLE `prediksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_uji`
--
ALTER TABLE `data_uji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `koridor`
--
ALTER TABLE `koridor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `prediksi`
--
ALTER TABLE `prediksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
