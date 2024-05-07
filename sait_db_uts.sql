-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2024 at 06:22 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sait_db_uts`
--

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(10) NOT NULL,
  `nama` varchar(20) DEFAULT NULL,
  `alamat` varchar(40) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `alamat`, `tanggal_lahir`) VALUES
('sv_001', 'Joko', 'Bantul', '1999-12-07'),
('sv_002', 'Paul', 'Sleman', '2000-10-06'),
('sv_003', 'Andy', 'Surabaya', '2000-02-09');

-- --------------------------------------------------------

--
-- Table structure for table `matakuliah`
--

CREATE TABLE `matakuliah` (
  `kode_mk` varchar(10) NOT NULL,
  `nama_mk` varchar(255) DEFAULT NULL,
  `sks` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matakuliah`
--

INSERT INTO `matakuliah` (`kode_mk`, `nama_mk`, `sks`) VALUES
('svpl_001', 'Database', 2),
('svpl_002', 'Kecerdasan Artifisial', 2),
('svpl_003', 'Interoperabilitas', 2);

-- --------------------------------------------------------

--
-- Table structure for table `perkuliahan`
--

CREATE TABLE `perkuliahan` (
  `id_perkuliahan` int(5) NOT NULL,
  `nim` varchar(10) DEFAULT NULL,
  `kode_mk` varchar(10) DEFAULT NULL,
  `nilai` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perkuliahan`
--

INSERT INTO `perkuliahan` (`id_perkuliahan`, `nim`, `kode_mk`, `nilai`) VALUES
(2, 'sv_001', 'svpl_002', 90),
(3, 'sv_001', 'svpl_003', 88),
(4, 'sv_002', 'svpl_001', 92),
(5, 'sv_002', 'svpl_002', 85),
(6, 'sv_002', 'svpl_003', 89),
(7, 'sv_003', 'svpl_001', 88),
(8, 'sv_003', 'svpl_002', 91),
(9, 'sv_003', 'svpl_003', 88),
(22, 'sv_001', 'svpl_001', 88);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_nilai_mahasiswa`
-- (See below for the actual view)
--
CREATE TABLE `view_nilai_mahasiswa` (
`nim` varchar(10)
,`nama` varchar(20)
,`alamat` varchar(40)
,`tanggal_lahir` date
,`kode_mk` varchar(10)
,`nama_mk` varchar(255)
,`sks` int(2)
,`nilai` double
);

-- --------------------------------------------------------

--
-- Structure for view `view_nilai_mahasiswa`
--
DROP TABLE IF EXISTS `view_nilai_mahasiswa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_nilai_mahasiswa`  AS SELECT `mahasiswa`.`nim` AS `nim`, `mahasiswa`.`nama` AS `nama`, `mahasiswa`.`alamat` AS `alamat`, `mahasiswa`.`tanggal_lahir` AS `tanggal_lahir`, `perkuliahan`.`kode_mk` AS `kode_mk`, `matakuliah`.`nama_mk` AS `nama_mk`, `matakuliah`.`sks` AS `sks`, `perkuliahan`.`nilai` AS `nilai` FROM ((`mahasiswa` join `perkuliahan` on(`mahasiswa`.`nim` = `perkuliahan`.`nim`)) join `matakuliah` on(`perkuliahan`.`kode_mk` = `matakuliah`.`kode_mk`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`kode_mk`);

--
-- Indexes for table `perkuliahan`
--
ALTER TABLE `perkuliahan`
  ADD PRIMARY KEY (`id_perkuliahan`),
  ADD KEY `nim` (`nim`),
  ADD KEY `kode_mk` (`kode_mk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `perkuliahan`
--
ALTER TABLE `perkuliahan`
  MODIFY `id_perkuliahan` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `perkuliahan`
--
ALTER TABLE `perkuliahan`
  ADD CONSTRAINT `perkuliahan_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`),
  ADD CONSTRAINT `perkuliahan_ibfk_2` FOREIGN KEY (`kode_mk`) REFERENCES `matakuliah` (`kode_mk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
