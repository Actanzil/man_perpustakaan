-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2024 at 02:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_buku`
--

CREATE TABLE `tb_buku` (
  `id_buku` int(11) NOT NULL,
  `kode_buku` char(5) NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `penulis_buku` varchar(50) NOT NULL,
  `penerbit_buku` varchar(50) NOT NULL,
  `tahun_terbit` date NOT NULL,
  `stock` bigint(20) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

--
-- Dumping data for table `tb_buku`
--

INSERT INTO `tb_buku` (`id_buku`, `kode_buku`, `judul_buku`, `penulis_buku`, `penerbit_buku`, `tahun_terbit`, `stock`, `gambar`) VALUES
(262, '12345', 'Kumpulan Dongeng Cerita Rakyat Nusantara', 'Kak Rara Z', 'Gramedia', '2016-03-10', 7, 'Kumpulan Dongeng Cerita Rakyat Nusantara.jpg'),
(263, '12123', 'Kumpulan Cerita Ragam Indonesia', 'Tim Kumpul Dongeng Surabaya', 'Togamas', '2021-11-21', 5, 'Kumpulan_Cerita_Ragam_Indonesia_COVER.jpg'),
(264, '12346', 'Cerita Anak Binatang: Burung Hantu', 'Nabila Anwar', 'Gramedia', '2020-03-31', 6, 'cerita anak binatang burung hantu.jpg'),
(265, '12347', 'Filsafat [di] Indonesia Manusia dan Budaya', 'A.setyo Wibowo', 'Gramedia', '2019-11-17', 2, 'Filsafat [di] Indonesia Manusia dan Budaya.jpg'),
(266, '12348', 'Sejarah Islam di Jawa', 'Kamil Hamid Baidawi', 'Gramedia', '2020-02-02', 6, 'Sejarah Islam di Jawa.jpg'),
(267, '12349', 'Buku Pegangan Penanganan Insiden Siber', 'Onno W Purbo, Jimmy Alberto, Hafizhan Irawan, Dkk', 'Gramedia', '2024-03-04', 5, 'Buku Pegangan Penanganan Insiden Siber.jpg'),
(268, '12350', 'Rekayasa Perangkat Lunak - Buku 1, Pendekatan Prak', 'Roger S. Pressman, Ph.D.', 'Gramedia', '2023-02-19', 11, 'Rekayasa Perangkat Lunak - Buku 1, Pendekatan Praktisi Edisi 7.jpg'),
(269, '12351', 'Strategi Pembelajaran Ppkn', 'D.Hj.Etin Solihatin,M.Pd.', 'Gramedia', '2018-08-06', 5, 'Strategi_Pembelajaran_Ppkn.jpg'),
(270, '12352', 'The Power of Jalur Langit Jurnal Muslimah', 'Redaksi Kawan Pustaka', 'Togamas', '2023-01-23', 7, 'The Power of Jalur Langit Jurnal Muslimah.jpg'),
(271, '12353', 'Math Tricks SD/MI', 'Lianna Nathania', 'Togamas', '2023-06-09', 7, 'Math Tricks SDMI.jpg'),
(272, '12354', 'Adakah Orang Sepertiku?', 'Lucia Song', 'Togamas', '2023-12-28', 4, 'togamas_16604_Adakah_Orang_Sepertiku_.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_buku_keluar`
--

CREATE TABLE `tb_buku_keluar` (
  `id_keluar` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_buku_keluar`
--

INSERT INTO `tb_buku_keluar` (`id_keluar`, `id_buku`, `id_user`, `tanggal`, `jumlah`, `keterangan`) VALUES
(6, 263, 18, '2024-04-05', 1, 'Peminjaman oleh Mahasiswa'),
(7, 262, 18, '2024-04-05', 1, 'Pinjaman Divisi Pemasaran'),
(8, 272, 23, '2024-04-05', 1, 'Peminjaman oleh Siswa'),
(9, 267, 22, '2024-04-05', 2, 'Sewa oleh Wali Kelas 6'),
(10, 264, 23, '2024-04-05', 1, 'Peminjaman oleh Siswa'),
(11, 265, 24, '2024-04-05', 2, 'Sewa oleh Wali Kelas 2'),
(12, 263, 25, '2024-04-05', 1, 'Pinjaman Divisi Pemasaran'),
(13, 262, 7, '2024-04-05', 1, 'Peminjaman oleh Siswa'),
(14, 271, 18, '2024-04-05', 1, 'Peminjaman oleh Siswa'),
(15, 268, 19, '2024-04-05', 4, 'Sewa oleh Wali Kelas 5'),
(16, 266, 20, '2024-04-05', 1, 'Peminjaman oleh Siswa'),
(17, 269, 21, '2024-04-05', 3, 'Sewa oleh Wali Kelas 4'),
(18, 270, 22, '2024-04-05', 1, 'Peminjaman oleh Siswa'),
(19, 272, 24, '2024-05-01', 2, 'Peminjaman oleh Siswa'),
(20, 267, 25, '2024-05-02', 2, 'Peminjaman oleh Siswa'),
(21, 264, 7, '2024-05-13', 2, 'Peminjaman oleh Siswa'),
(22, 265, 18, '2024-05-14', 3, 'Sewa oleh Wali Kelas 5'),
(23, 263, 19, '2024-05-15', 2, 'Peminjaman oleh Siswa'),
(24, 262, 20, '2024-05-16', 1, 'Peminjaman oleh Siswa'),
(25, 271, 21, '2024-05-21', 3, 'Sewa oleh Wali Kelas 4'),
(26, 268, 21, '2024-05-22', 6, 'Sewa oleh Wali Kelas 6'),
(27, 266, 22, '2024-05-23', 1, 'Peminjaman oleh Siswa'),
(28, 269, 23, '2024-05-24', 2, 'Sewa oleh Wali Kelas 5'),
(29, 270, 24, '2024-05-24', 1, 'Peminjaman oleh Siswa');

-- --------------------------------------------------------

--
-- Table structure for table `tb_buku_masuk`
--

CREATE TABLE `tb_buku_masuk` (
  `id_masuk` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_buku_masuk`
--

INSERT INTO `tb_buku_masuk` (`id_masuk`, `id_buku`, `id_user`, `tanggal`, `jumlah`, `keterangan`) VALUES
(5, 263, 7, '2024-04-04', 2, 'Restock dari distributor'),
(6, 272, 19, '2024-04-04', 1, 'Restock dari distributor'),
(7, 267, 20, '2024-04-04', 2, 'Restock dari distributor'),
(8, 264, 21, '2024-04-04', 3, 'Restock dari distributor'),
(9, 265, 22, '2024-04-04', 1, 'Pengembalian oleh Siswa'),
(10, 263, 23, '2024-04-04', 2, 'Promosi Produk Baru'),
(11, 262, 24, '2024-04-04', 4, 'Restock dari distributor'),
(12, 271, 25, '2024-04-04', 1, 'Pengembalian oleh Siswa'),
(22, 268, 7, '2024-04-04', 1, 'Restock dari distributor'),
(23, 266, 18, '2024-04-04', 2, 'Promosi Produk Baru'),
(24, 269, 19, '2024-04-04', 1, 'Pengembalian oleh Siswa'),
(25, 269, 20, '2024-04-04', 1, 'Restock dari distributor'),
(26, 270, 21, '2024-04-04', 1, 'Pengembalian oleh Siswa'),
(27, 272, 23, '2024-05-03', 1, 'Pengembalian oleh Siswa'),
(28, 267, 24, '2024-05-04', 2, 'Pengembalian oleh Wali Kelas 4'),
(29, 264, 25, '2024-05-06', 1, 'Pengembalian oleh Siswa'),
(30, 265, 7, '2024-05-07', 1, 'Pengembalian oleh Siswa'),
(31, 263, 18, '2024-05-08', 1, 'Pengembalian oleh Wali Kelas 3'),
(32, 262, 19, '2024-05-09', 1, 'Pengembalian oleh Siswa'),
(33, 271, 20, '2024-05-10', 5, 'Restock dari distributor'),
(34, 268, 21, '2024-05-13', 5, 'Promosi Produk Baru'),
(35, 266, 22, '2024-05-15', 1, 'Pengembalian oleh Siswa'),
(36, 269, 23, '2024-05-16', 3, 'Pengembalian oleh Wali Kelas 5'),
(37, 270, 24, '2024-05-20', 3, 'Pengembalian oleh Siswa');

-- --------------------------------------------------------

--
-- Table structure for table `tb_laporan`
--

CREATE TABLE `tb_laporan` (
  `id_laporan` int(11) NOT NULL,
  `kode_laporan` varchar(20) NOT NULL,
  `judul_laporan` varchar(255) NOT NULL,
  `bulan` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal` date NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_laporan`
--

INSERT INTO `tb_laporan` (`id_laporan`, `kode_laporan`, `judul_laporan`, `bulan`, `keterangan`, `tanggal`, `id_user`) VALUES
(3, 'ASI3', 'Laporan Bulan Mei 2024', '2024-05', 'Berikut ini merupakan laporan bulan Mei Tahun 2024', '2024-05-23', 18),
(5, 'ASI4', 'Laporan Bulan April 2024', '2024-04', 'Berikut ini merupakan laporan bulan April Tahun 2024', '2024-04-27', 7);

-- --------------------------------------------------------

--
-- Table structure for table `tb_tag`
--

CREATE TABLE `tb_tag` (
  `id_tag` int(11) NOT NULL,
  `nama_tag` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_tag`
--

INSERT INTO `tb_tag` (`id_tag`, `nama_tag`) VALUES
(1, 'Petualangan'),
(2, 'Fantasi'),
(3, 'Dongeng'),
(4, 'Hewan'),
(5, 'Misteri'),
(6, 'Fabel'),
(7, 'Mitologi'),
(8, 'Cerita Pendek'),
(9, 'Sejarah'),
(10, 'Sains'),
(11, 'Biografi'),
(12, 'Seni dan Kerajinan'),
(13, 'Geografi'),
(14, 'Teknologi'),
(15, 'Alam'),
(16, 'Budaya'),
(17, 'Cerita Bergambar'),
(18, 'Bergambar Edukasi'),
(19, 'Bergambar Interaktif'),
(20, 'Matematika'),
(21, 'Bahasa Indonesia'),
(22, 'Bahasa Inggris'),
(23, 'Ilmu Pengetahuan Alam (IPA)'),
(24, 'Ilmu Pengetahuan Sosial (IPS)'),
(25, 'Pendidikan Jasmani'),
(26, 'Seni dan Budaya'),
(27, 'Agama'),
(28, 'Petualangan'),
(29, 'Superhero'),
(30, 'Edukasi'),
(31, 'Mewarnai'),
(32, 'Teka-Teki'),
(33, 'Kerajinan Tangan'),
(34, 'Permainan dan Puzzle'),
(35, 'Rakyat Indonesia'),
(36, 'Rakyat Dunia'),
(37, 'Legenda Lokal'),
(38, 'Kepemimpinan'),
(39, 'Persahabatan'),
(40, 'Emosi dan Perasaan'),
(41, 'Menghargai Perbedaan'),
(42, 'Keterampilan Sosial'),
(43, 'Kebersihan Diri'),
(44, 'Pola Makan Sehat'),
(45, 'Olahraga'),
(46, 'Kesehatan Mental'),
(47, 'Pelestarian Lingkungan'),
(48, 'Kehidupan Liar'),
(49, 'Ekosistem'),
(50, 'Kamus'),
(51, 'Ensiklopedia'),
(52, 'Atlas');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tag_buku`
--

CREATE TABLE `tb_tag_buku` (
  `id_tag_buku` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_tag_buku`
--

INSERT INTO `tb_tag_buku` (`id_tag_buku`, `id_buku`, `id_tag`) VALUES
(23, 262, 18),
(24, 262, 17),
(25, 262, 3),
(26, 262, 35),
(27, 262, 9),
(30, 264, 18),
(31, 264, 17),
(32, 264, 8),
(33, 264, 3),
(34, 264, 35),
(35, 265, 16),
(36, 265, 30),
(37, 265, 26),
(38, 266, 27),
(39, 266, 16),
(40, 266, 35),
(41, 266, 9),
(42, 267, 30),
(43, 267, 51),
(44, 267, 10),
(45, 267, 14),
(46, 268, 30),
(47, 268, 51),
(48, 268, 14),
(49, 269, 30),
(50, 269, 51),
(51, 269, 24),
(52, 269, 35),
(53, 269, 9),
(54, 270, 27),
(55, 270, 18),
(56, 270, 30),
(57, 270, 40),
(58, 270, 35),
(59, 271, 30),
(60, 271, 23),
(61, 271, 20),
(62, 271, 10),
(63, 272, 21),
(64, 272, 18),
(65, 272, 30),
(66, 272, 40),
(67, 272, 46),
(68, 272, 26),
(71, 263, 18),
(72, 263, 2),
(73, 263, 24),
(74, 263, 42),
(75, 263, 35),
(76, 263, 9);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `level` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `email`, `level`, `foto`) VALUES
(7, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 'admin@perpustakaan.com', 'Superadmin', 'pattrick.png'),
(18, 'joseph', 'cb07901c53218323c4ceacdea4b23c98', 'Joseph Stuard', 'joseph@perpustakaan.com', 'Admin', 'doctors-3.jpg'),
(19, 'ahmad', '61243c7b9a4022cb3f8dc3106767ed12', 'Ahmad Iriawan', 'ahmad@perpustakaan.com', 'Admin', 'messages-3.jpg'),
(20, 'kayla', '16616347a7a5a764fe271009b247211a', 'Kayla Andien', 'kayla@perpustakaan.com', 'Admin', 'messages-2.jpg'),
(21, 'sriyul', '12ecfe5f8321351faa5cb8b679732547', 'Sri Yuliani', 'sriyul@perpustakaan.com', 'Admin', 'messages-1.jpg'),
(22, 'boys', '5c43757a81cf6101f302b5428017ae43', 'Boy Sukendra', 'boys@perpustakaan.com', 'Admin', 'testimonials-5.jpg'),
(23, 'alex', '534b44a19bf18d20b71ecc4eb77c572f', 'Alexandra Indrawari', 'alexandra@perpustakaan.com', 'Admin', 'testimonials-2.jpg'),
(24, 'yanuar', '94fced7d9e42731aea466c6fd447d73a', 'Yanuar Mahendra', 'yanuar@perpustakaan.com', 'Admin', 'comments-5.jpg'),
(25, 'ivanka', '998f905dd551980ff88112bf4e2f04dd', 'Ivanka Sovia', 'ivanka@perpustakaan.com', 'Admin', 'comments-1.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_buku`
--
ALTER TABLE `tb_buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `tb_buku_keluar`
--
ALTER TABLE `tb_buku_keluar`
  ADD PRIMARY KEY (`id_keluar`);

--
-- Indexes for table `tb_buku_masuk`
--
ALTER TABLE `tb_buku_masuk`
  ADD PRIMARY KEY (`id_masuk`);

--
-- Indexes for table `tb_laporan`
--
ALTER TABLE `tb_laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indexes for table `tb_tag`
--
ALTER TABLE `tb_tag`
  ADD PRIMARY KEY (`id_tag`);

--
-- Indexes for table `tb_tag_buku`
--
ALTER TABLE `tb_tag_buku`
  ADD PRIMARY KEY (`id_tag_buku`),
  ADD KEY `id_tag` (`id_tag`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_buku`
--
ALTER TABLE `tb_buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;

--
-- AUTO_INCREMENT for table `tb_buku_keluar`
--
ALTER TABLE `tb_buku_keluar`
  MODIFY `id_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tb_buku_masuk`
--
ALTER TABLE `tb_buku_masuk`
  MODIFY `id_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tb_laporan`
--
ALTER TABLE `tb_laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_tag`
--
ALTER TABLE `tb_tag`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `tb_tag_buku`
--
ALTER TABLE `tb_tag_buku`
  MODIFY `id_tag_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_buku_keluar`
--
ALTER TABLE `tb_buku_keluar`
  ADD CONSTRAINT `tb_buku_keluar_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_buku_keluar_ibfk_3` FOREIGN KEY (`id_buku`) REFERENCES `tb_buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_buku_masuk`
--
ALTER TABLE `tb_buku_masuk`
  ADD CONSTRAINT `tb_buku_masuk_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_buku_masuk_ibfk_3` FOREIGN KEY (`id_buku`) REFERENCES `tb_buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_laporan`
--
ALTER TABLE `tb_laporan`
  ADD CONSTRAINT `tb_laporan_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_tag_buku`
--
ALTER TABLE `tb_tag_buku`
  ADD CONSTRAINT `tb_tag_buku_ibfk_1` FOREIGN KEY (`id_tag`) REFERENCES `tb_tag` (`id_tag`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_tag_buku_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `tb_buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
