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
  `kode_gejala` varchar(10) NOT NULL,
  `nama_gejala` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gejala`
--

INSERT INTO `gejala` (`id_gejala`, `kode_gejala`, `nama_gejala`) VALUES
(1, 'G001', 'Apakah tubuh Anda cenderung kurus dan tinggi?'),
(2, 'G002', 'Apakah lemak tubuh Anda rendah (tidak mudah menyimpan lemak)?'),
(3, 'G003', 'Apakah Anda kesulitan menambah massa otot?'),
(4, 'G004', 'Apakah Anda memiliki bahu lebar dan pinggang ramping?'),
(5, 'G005', 'Apakah otot Anda mudah berkembang saat berolahraga?'),
(6, 'G006', 'Apakah Anda mudah naik dan turun berat badan?'),
(7, 'G007', 'Apakah bentuk tubuh Anda bulat dan mudah menyimpan lemak?'),
(8, 'G008', 'Apakah metabolisme tubuh Anda lambat?'),
(9, 'G009', 'Apakah Anda sulit menurunkan berat badan meskipun sudah berusaha?'),
(10, 'G010', 'Apakah tubuh Anda terlihat tinggi dan ramping?'),
(11, 'G011', 'Apakah Anda memiliki tulang kecil dan pergelangan tangan kecil?'),
(12, 'G012', 'Apakah Anda cepat merasa lapar dan sering makan?'),
(13, 'G013', 'Apakah Anda memiliki lemak perut yang sulit hilang?'),
(14, 'G014', 'Apakah Anda memiliki massa otot alami tanpa latihan berat?'),
(15, 'G015', 'Apakah tubuh Anda tampak proporsional dan seimbang?'),
(16, 'G016', 'Apakah berat badan Anda cenderung stabil dalam jangka panjang?'),
(17, 'G017', 'Apakah Anda memiliki paha dan pinggul yang besar?'),
(18, 'G018', 'Apakah Anda sulit tetap ramping meskipun rutin berolahraga?');

-- --------------------------------------------------------

--
-- Table structure for table `know_base`
--

CREATE TABLE `know_base` (
  `id` int NOT NULL,
  `id_gejala` int NOT NULL,
  `id_kondisi` int NOT NULL,
  `value_cf` decimal(3,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `know_base`
--

INSERT INTO `know_base` (`id`, `id_gejala`, `id_kondisi`, `value_cf`) VALUES
(1, 1, 1, 0.90),
(2, 2, 1, 0.80),
(3, 3, 1, 0.80),
(4, 4, 2, 0.90),
(5, 5, 2, 0.90),
(6, 6, 2, 0.80),
(7, 7, 3, 0.90),
(8, 8, 3, 0.80),
(9, 9, 3, 0.90),
(10, 10, 1, 0.90),
(11, 11, 1, 0.70),
(12, 12, 1, 0.60),
(13, 13, 3, 0.80),
(14, 14, 2, 0.80),
(15, 15, 2, 0.80),
(16, 16, 2, 0.60),
(17, 17, 3, 0.70),
(18, 18, 3, 0.80),
(19, 5, 1, 0.30),
(20, 7, 1, 0.10),
(21, 1, 2, 0.40),
(22, 2, 2, 0.60),
(23, 7, 2, 0.20),
(24, 8, 2, 0.30),
(25, 2, 3, 0.20),
(26, 3, 3, 0.40),
(27, 5, 3, 0.50),
(28, 6, 3, 0.60);

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
(1, 'K001', 'Ectomorph', 'Ectomorph adalah tipe tubuh yang cenderung kurus dan tinggi dengan metabolisme yang sangat cepat. Karakteristik utama meliputi: tulang kecil, dada rata, bahu dan pinggang sempit, lemak tubuh dan massa otot rendah, serta kesulitan menambah berat badan. Orang dengan tipe ini umumnya memiliki toleransi karbohidrat yang tinggi dan memerlukan asupan kalori lebih banyak untuk menambah massa tubuh.'),
(2, 'K002', 'Mesomorph', 'Mesomorph adalah tipe tubuh yang secara alami atletis dan berotot. Karakteristik utama meliputi: tulang sedang hingga besar, torso solid dan berotot, bahu lebar dengan pinggang sempit, lemak tubuh rendah hingga sedang, serta kemampuan mudah menambah dan mengurangi berat badan. Tipe ini merespons dengan baik terhadap latihan beban dan memiliki keseimbangan metabolisme yang efisien.'),
(3, 'K003', 'Endomorph', 'Endomorph adalah tipe tubuh yang cenderung mudah menyimpan lemak dengan metabolisme yang lebih lambat. Karakteristik utama meliputi: tulang besar, lebih banyak massa tubuh secara keseluruhan, pinggang dan pinggul lebar, lemak tubuh tinggi, serta kesulitan menurunkan berat badan. Orang dengan tipe ini umumnya sensitif terhadap karbohidrat dan memerlukan kontrol diet yang lebih ketat serta aktivitas kardio yang rutin.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id_gejala`),
  ADD UNIQUE KEY `unique_kode_gejala` (`kode_gejala`);

--
-- Indexes for table `know_base`
--
ALTER TABLE `know_base`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gejala` (`id_gejala`),
  ADD KEY `fk_kondisi` (`id_kondisi`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  ADD CONSTRAINT `fk_gejala` FOREIGN KEY (`id_gejala`) REFERENCES `gejala` (`id_gejala`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kondisi` FOREIGN KEY (`id_kondisi`) REFERENCES `kondisi` (`id_kondisi_tubuh`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;