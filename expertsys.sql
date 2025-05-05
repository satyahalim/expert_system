-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 02, 2025 at 03:17 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `expertsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `gejala`
--

CREATE TABLE `gejala` (
  `id_gejala` int NOT NULL,
  `kode_gejala` varchar(100) NOT NULL,
  `nama_gejala` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gejala`
--

INSERT INTO `gejala` (`id_gejala`, `kode_gejala`, `nama_gejala`) VALUES
(1, 'G001', 'Tubuh cenderung kurus dan tinggi'),
(2, 'G002', 'Lemak tubuh rendah (tidak mudah menyimpan lemak)'),
(3, 'G003', 'Kesulitan menambah massa otot'),
(4, 'G004', 'Bahu lebar dan pinggang ramping'),
(5, 'G005', 'Otot mudah berkembang saat olahraga'),
(6, 'G006', 'Mudah naik dan turun berat badan'),
(7, 'G007', 'Bentuk tubuh bulat dan mudah menyimpan lemak'),
(8, 'G008', 'Metabolisme lambat (mudah gemuk walau makan sedikit)'),
(9, 'G009', 'Sulit menurunkan berat badan meski sudah berusaha'),
(10, 'G010', 'Tubuh Anda terlihat tinggi dan ramping'),
(11, 'G011', 'Anda memiliki tulang kecil dan pergelangan tangan kecil'),
(12, 'G012', 'Anda cepat merasa lapar dan sering makan'),
(13, 'G013', 'Anda memiliki lemak perut yang sulit hilang'),
(14, 'G014', 'Anda memiliki massa otot alami (tanpa latihan berat)'),
(15, 'G015', 'Tubuh Anda tampak proporsional tanpa kelebihan/kekurangan'),
(16, 'G016', 'Berat badan Anda cenderung stabil dalam jangka panjang'),
(17, 'G017', 'Anda memiliki paha dan pinggul yang besar'),
(18, 'G018', 'Anda merasa sulit tetap ramping meski rutin berolahraga');

-- --------------------------------------------------------

--
-- Table structure for table `know_base`
--

CREATE TABLE `know_base` (
  `id` int NOT NULL,
  `id_gejala` int NOT NULL,
  `id_kondisi` int NOT NULL,
  `value_cf` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `know_base`
--

INSERT INTO `know_base` (`id`, `id_gejala`, `id_kondisi`, `value_cf`) VALUES
(1, 1, 1, 0.9),
(2, 2, 1, 0.8),
(3, 3, 1, 0.7),
(4, 4, 2, 0.8),
(5, 5, 2, 0.8),
(6, 6, 2, 0.7),
(7, 7, 3, 0.9),
(8, 8, 3, 0.8),
(9, 9, 3, 0.8),
(10, 10, 1, 0.7),
(11, 11, 1, 0.6),
(12, 12, 3, 0.5),
(13, 13, 3, 0.8),
(14, 14, 2, 0.7),
(15, 15, 2, 0.6),
(16, 16, 2, 0.5),
(17, 17, 3, 0.7),
(18, 18, 3, 0.6);

-- --------------------------------------------------------

--
-- Table structure for table `kondisi`
--

CREATE TABLE `kondisi` (
  `id_kondisi_tubuh` int NOT NULL,
  `kode_kondisi` varchar(100) NOT NULL,
  `kondisi` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kondisi`
--

INSERT INTO `kondisi` (`id_kondisi_tubuh`, `kode_kondisi`, `kondisi`, `deskripsi`) VALUES
(1, 'K001', 'Ectomorph', 'Bertubuh kurus, metabolisme cepat, sulit menambah massa otot dan lemak.'),
(2, 'K002', 'Mesomorph', 'Tubuh atletis, proporsional, mudah membentuk otot dan menyesuaikan berat.'),
(3, 'K003', 'Endomorph', 'Bertubuh bulat, mudah menyimpan lemak, metabolisme lambat.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id_gejala`);

--
-- Indexes for table `know_base`
--
ALTER TABLE `know_base`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_gejala` (`id_gejala`),
  ADD KEY `fk_id_kondisi` (`id_kondisi`);

--
-- Indexes for table `kondisi`
--
ALTER TABLE `kondisi`
  ADD PRIMARY KEY (`id_kondisi_tubuh`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gejala`
--
ALTER TABLE `gejala`
  MODIFY `id_gejala` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `know_base`
--
ALTER TABLE `know_base`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `kondisi`
--
ALTER TABLE `kondisi`
  MODIFY `id_kondisi_tubuh` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `know_base`
--
ALTER TABLE `know_base`
  ADD CONSTRAINT `fk_id_gejala` FOREIGN KEY (`id_gejala`) REFERENCES `gejala` (`id_gejala`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_id_kondisi` FOREIGN KEY (`id_kondisi`) REFERENCES `kondisi` (`id_kondisi_tubuh`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
