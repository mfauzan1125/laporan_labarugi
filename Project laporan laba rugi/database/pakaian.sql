-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2024 at 07:14 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pakaian`
--

-- --------------------------------------------------------

--
-- Table structure for table `pakaian`
--

CREATE TABLE `pakaian` (
  `id` int(11) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis` enum('baju','celana','aksesoris') NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pakaian`
--

INSERT INTO `pakaian` (`id`, `kode`, `nama`, `jenis`, `harga`, `tanggal`) VALUES
(7, '001', 'KEMEJA LENGAN PENDEK', 'baju', '300000.00', '2024-10-31'),
(8, '002', 'KEMEJA', 'baju', '200000.00', '2024-10-31'),
(9, '003', 'GAMIS', 'baju', '300000.00', '2024-10-31'),
(10, '004', 'KOKO', 'baju', '300000.00', '2024-10-31'),
(11, '005', 'SERAGAM SD', 'baju', '300000.00', '2024-10-31'),
(12, '006', 'SERAGAM SMP', 'baju', '300000.00', '2024-11-01'),
(13, '007', 'SERAGAM SMA', 'baju', '400000.00', '2024-11-01'),
(14, '008', 'JEANS', 'celana', '200000.00', '2024-11-01'),
(15, '009', 'KAOS HITAM', 'baju', '50000.00', '2024-10-31'),
(16, '010', 'KAOS PUTIH', 'baju', '50000.00', '2024-11-01'),
(17, '011', 'JORDAN', 'baju', '800000.00', '2024-11-01'),
(18, '012', 'KAOS POLO', 'baju', '600000.00', '2024-11-01'),
(19, '013', 'JAM TANGAN ', 'aksesoris', '1000000.00', '2024-09-01'),
(20, '014', 'CELANA PENDEK', 'celana', '100000.00', '2024-09-01'),
(21, '015', 'SERAGAM PRAMUKA', 'baju', '300000.00', '2024-09-01'),
(22, '016', 'KAOS JORDAN', 'baju', '500000.00', '2024-11-01'),
(23, '017', 'SERAGAM SMA', 'baju', '300000.00', '2024-09-01'),
(24, '002', 'KEMEJA', 'baju', '300000.00', '2024-11-02'),
(25, '001', 'KEMEJA LENGAN PENDEK', 'baju', '300000.00', '2024-11-02'),
(26, '018', 'CELANA POLO', 'celana', '400000.00', '2024-11-03'),
(27, '003', 'GAMIS', 'baju', '300000.00', '2024-10-30'),
(28, '007', 'SERAGAM SMA', 'baju', '500000.00', '2024-11-03'),
(29, '001', 'KEMEJA LENGAN PENDEK', 'baju', '400000.00', '2024-11-04');

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int(11) NOT NULL,
  `jenis_pengeluaran` enum('listrik','air','gaji') NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengeluaran`
--

INSERT INTO `pengeluaran` (`id`, `jenis_pengeluaran`, `jumlah`, `tanggal`) VALUES
(1, 'listrik', '500000.00', '2024-10-31'),
(2, 'air', '250000.00', '2024-11-01'),
(3, 'gaji', '800000.00', '2024-10-31'),
(4, 'gaji', '1000000.00', '2024-09-01'),
(5, 'listrik', '500000.00', '2024-11-01'),
(6, 'air', '250000.00', '2024-10-01');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `kode_pakaian` varchar(50) NOT NULL,
  `nama_pakaian` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `tanggal`, `kode_pakaian`, `nama_pakaian`, `jumlah`, `harga`, `total`) VALUES
(1, '2024-10-31', '001', 'KEMEJA', 2, '200000.00', '400000.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'fauzan', 'admin'),
(2, 'user', 'fauzan', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pakaian`
--
ALTER TABLE `pakaian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pakaian`
--
ALTER TABLE `pakaian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
