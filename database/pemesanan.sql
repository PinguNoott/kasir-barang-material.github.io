-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Agu 2024 pada 08.46
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pemesanan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(255) DEFAULT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `harga_jual` varchar(255) DEFAULT NULL,
  `harga_beli` varchar(255) DEFAULT NULL,
  `stok` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `foto` varchar(255) NOT NULL,
  `delete` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `kode_barang`, `nama_barang`, `harga_jual`, `harga_beli`, `stok`, `status`, `create_at`, `create_by`, `update_at`, `update_by`, `foto`, `delete`) VALUES
(6, '12345', 'pinguin', '700000', '675000', '10', 'tersedia', NULL, NULL, NULL, NULL, 'penguin.png', '0'),
(9, 'oke', 'abc', '15000', '10000', '8', 'tersedia', NULL, NULL, NULL, NULL, 'cthujianAVG.PNG', '0'),
(10, 'aaa', 'telur ', '20000', '10000', '6', 'tersedia', NULL, NULL, NULL, NULL, 'egg.jpg', '0'),
(28, 'oke', 'oke', '12000', '2000', '15', 'tersedia', NULL, NULL, NULL, NULL, 'favicon.png', '0'),
(30, 'oke', 'tess', '2222', '10000', '45', 'tersedia', NULL, NULL, NULL, NULL, 'logo.psd', '1'),
(31, 'aaa', 'abcde', '120008', '100007', '13', 'tersedia', NULL, NULL, NULL, NULL, 'admin.jpg', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangkeluar`
--

CREATE TABLE `barangkeluar` (
  `id_bkeluar` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` varchar(255) DEFAULT NULL,
  `delete` enum('0','1') DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `tanggal` int(11) NOT NULL,
  `kode_keranjang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `barangkeluar`
--

INSERT INTO `barangkeluar` (`id_bkeluar`, `id_barang`, `jumlah`, `delete`, `create_at`, `create_by`, `update_at`, `update_by`, `tanggal`, `kode_keranjang`) VALUES
(62, 4, '8', '0', '2024-07-29 13:09:55', 9, '2024-08-06 13:18:20', 9, 0, ''),
(63, 3, '1', '0', '2024-07-29 13:09:55', 9, NULL, NULL, 0, ''),
(64, 5, '1', '1', '2024-07-29 13:09:55', 9, NULL, NULL, 0, ''),
(65, 2, '1', '0', '2024-07-30 11:20:28', 9, NULL, NULL, 0, ''),
(66, 3, '1', '0', '2024-07-30 11:20:29', 9, NULL, NULL, 0, ''),
(67, 3, '1', '0', '2024-08-01 10:34:22', 9, NULL, NULL, 0, ''),
(68, 1, '1', '1', '2024-08-01 11:47:36', 9, NULL, NULL, 0, ''),
(69, 1, '1', '1', '2024-08-01 13:09:46', 9, NULL, NULL, 0, ''),
(71, 1, '15', '1', '2024-08-06 07:22:20', 9, NULL, NULL, 2024, 'CPP-0013'),
(72, 1, '15', '0', '2024-08-06 07:22:21', 9, NULL, NULL, 2024, 'CPP-0013'),
(74, 1, '1', '1', '2024-08-06 11:13:55', 9, '2024-08-06 11:14:07', 9, 2024, 'CPP-0020'),
(75, 2, '3', '0', '2024-08-06 11:20:09', 9, NULL, NULL, 2024, 'CPP-0022'),
(76, 1, '1', '1', '2024-08-06 11:20:10', 9, NULL, NULL, 2024, 'CPP-0022'),
(77, 2, '3', '0', '2024-08-06 11:20:11', 9, NULL, NULL, 2024, 'CPP-0022'),
(78, 1, '1', '0', '2024-08-06 11:20:13', 9, NULL, NULL, 2024, 'CPP-0022'),
(79, 1, '1', '0', '2024-08-06 11:24:26', 9, NULL, NULL, 2024, 'CPP-0001'),
(80, 2, '1', '0', '2024-08-06 11:24:26', 9, NULL, NULL, 2024, 'CPP-0001'),
(81, 2, '2', '1', '2024-08-06 13:06:30', 9, NULL, NULL, 2024, 'CPP-0004'),
(82, 1, '2', '0', '2024-08-06 13:13:33', 9, NULL, NULL, 2024, ''),
(83, 1, '1', '1', '2024-08-06 13:13:39', 9, NULL, NULL, 2024, ''),
(84, 7, '8', '0', '2024-08-06 13:15:12', 9, NULL, NULL, 2024, ''),
(85, 11, '2', '0', '2024-08-06 13:38:05', 9, NULL, NULL, 2024, ''),
(86, 1, '7', '0', '2024-08-06 13:39:38', 9, NULL, NULL, 2024, ''),
(87, 1, '7', '0', '2024-08-06 13:39:39', 9, NULL, NULL, 2024, ''),
(88, 1, '7', '0', '2024-08-06 13:40:59', 9, NULL, NULL, 2024, ''),
(89, 1, '1', '0', '2024-08-06 13:47:16', 9, NULL, NULL, 2024, 'CPP-0006'),
(90, 1, '7', '0', '2024-08-06 13:48:32', 9, NULL, NULL, 2024, 'CPP-0006'),
(91, 2, '1', '0', '2024-08-06 13:48:55', 9, NULL, NULL, 2024, 'CPP-0006'),
(92, 1, '1', '0', '2024-08-07 11:58:09', 9, NULL, NULL, 2024, 'CPP-0008'),
(93, 1, '1', '0', '2024-08-07 12:04:03', 9, NULL, NULL, 2024, 'CPP-0009'),
(94, 5, '1', '0', '2024-08-07 12:44:43', 9, NULL, NULL, 2024, 'CPP-0011'),
(95, 3, '3', '0', '2024-08-07 12:50:01', 9, NULL, NULL, 2024, 'CPP-0014'),
(96, 5, '1', '0', '2024-08-07 12:51:42', 9, NULL, NULL, 2024, 'CPP-0016'),
(98, 6, '2', '0', '2024-08-07 13:07:29', 16, NULL, NULL, 2024, 'CPP-0019'),
(99, 6, '1', '0', '2024-08-07 13:25:23', 9, NULL, NULL, 2024, 'CPP-0020'),
(100, 10, '1', '0', '2024-08-07 13:25:23', 9, NULL, NULL, 2024, 'CPP-0020'),
(101, 11, '1', '1', '2024-08-07 13:25:23', 9, NULL, NULL, 2024, 'CPP-0020'),
(102, 10, '2', '1', '2024-08-07 19:37:23', 9, '2024-08-07 21:44:36', 9, 2024, 'CPP-0021'),
(103, 1, '1', '0', '2024-08-07 21:44:39', 9, NULL, NULL, 2024, 'CPP-0021'),
(104, 10, '2', '0', '2024-08-07 21:45:28', 9, NULL, NULL, 2024, ''),
(105, 1, '4', '0', '2024-08-07 21:47:00', 9, '2024-08-07 21:47:55', 9, 2024, 'CPP-0017'),
(106, 1, '1', '0', '2024-08-07 21:49:16', 9, NULL, NULL, 2024, 'CPP-0023'),
(107, 1, '1', '0', '2024-08-07 21:49:59', 9, NULL, NULL, 2024, 'CPP-0024'),
(108, 1, '3', '0', '2024-08-07 22:32:34', 9, NULL, NULL, 2024, 'CPP-0025'),
(109, 6, '2', '0', '2024-08-08 08:23:54', 9, '2024-08-08 10:52:36', 9, 2024, 'CPP-0044'),
(110, 6, '2', '0', '2024-08-08 08:31:52', 9, '2024-08-08 10:52:36', 9, 2024, 'CPP-0044'),
(111, 6, '1', '0', '2024-08-08 10:53:54', 9, NULL, NULL, 2024, 'CPP-0045'),
(112, 9, '1', '0', '2024-08-08 11:28:48', 9, NULL, NULL, 2024, 'CPP-0002'),
(113, 6, '1', '0', '2024-08-08 11:29:22', 9, NULL, NULL, 2024, 'CPP-0002'),
(114, 6, '1', '0', '2024-08-08 11:29:23', 9, NULL, NULL, 2024, 'CPP-0002'),
(115, 6, '1', '0', '2024-08-08 11:29:23', 9, NULL, NULL, 2024, 'CPP-0002'),
(116, 6, '1', '0', '2024-08-08 11:29:56', 9, NULL, NULL, 2024, 'CPP-0002'),
(117, 6, '1', '0', '2024-08-08 11:32:21', 9, NULL, NULL, 2024, 'CPP-0001'),
(118, 9, '1', '0', '2024-08-08 11:32:21', 9, NULL, NULL, 2024, 'CPP-0001'),
(119, 31, '1', '0', '2024-08-08 12:01:32', 35, NULL, NULL, 2024, 'CPP-0002'),
(120, 9, '1', '0', '2024-08-08 12:02:18', 35, NULL, NULL, 2024, 'CPP-0004'),
(121, 31, '2', '0', '2024-08-08 12:03:10', 35, NULL, NULL, 2024, 'CPP-0005');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangmasuk`
--

CREATE TABLE `barangmasuk` (
  `id_bmasuk` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `delete` enum('0','1') DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `barangmasuk`
--

INSERT INTO `barangmasuk` (`id_bmasuk`, `id_barang`, `quantity`, `delete`, `create_at`, `create_by`, `update_at`, `update_by`, `tanggal`) VALUES
(15, 2, '1', '0', '2024-07-28 17:06:41', 1, NULL, NULL, '0000-00-00'),
(17, 2, '-2', '0', '2024-08-06 12:55:34', 9, NULL, NULL, '0000-00-00'),
(18, 1, '2', '0', '2024-08-07 19:35:11', 9, NULL, NULL, '0000-00-00'),
(19, 10, '4', '0', '2024-08-07 19:40:26', 9, NULL, NULL, '0000-00-00'),
(20, 6, '10', '0', '2024-08-07 19:40:36', 9, NULL, NULL, '0000-00-00'),
(21, 12, '3', '0', '2024-08-07 19:40:44', 9, NULL, NULL, '0000-00-00'),
(22, 1, '8', '0', '2024-08-08 10:51:36', 9, NULL, NULL, '0000-00-00');

--
-- Trigger `barangmasuk`
--
DELIMITER $$
CREATE TRIGGER `updatastok` AFTER INSERT ON `barangmasuk` FOR EACH ROW BEGIN
    -- Update the stock in the barang table
    UPDATE barang
    SET stok = stok + NEW.quantity
    WHERE id_barang = NEW.id_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updatedelete` AFTER DELETE ON `barangmasuk` FOR EACH ROW BEGIN
    -- Update the stock in the barang table
    UPDATE barang
    SET stok = stok - OLD.quantity
    WHERE id_barang = OLD.id_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id_Keranjang` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_pt` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `kode_keranjang` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `create_by` varchar(255) NOT NULL,
  `status` enum('pending','checkout') NOT NULL,
  `deletek` enum('0','1') NOT NULL,
  `update_at` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `keranjang`
--

INSERT INTO `keranjang` (`id_Keranjang`, `id_user`, `id_pt`, `id_barang`, `create_at`, `kode_keranjang`, `quantity`, `create_by`, `status`, `deletek`, `update_at`, `update_by`, `username`) VALUES
(103, 9, NULL, 6, '2024-08-08 11:32:11', 'CPP-0001', '1', '9', 'checkout', '0', '0000-00-00 00:00:00', 0, ''),
(104, 9, NULL, 9, '2024-08-08 11:32:11', 'CPP-0001', '1', '9', 'checkout', '0', '0000-00-00 00:00:00', 0, ''),
(105, 35, NULL, 31, '2024-08-08 12:01:26', 'CPP-0002', '1', '35', 'checkout', '0', '0000-00-00 00:00:00', 0, ''),
(106, 35, NULL, 9, '2024-08-08 12:02:12', 'CPP-0003', '1', '35', 'pending', '0', '0000-00-00 00:00:00', 0, ''),
(107, 35, NULL, 9, '2024-08-08 12:02:13', 'CPP-0004', '1', '35', 'checkout', '0', '0000-00-00 00:00:00', 0, ''),
(108, 35, NULL, 31, '2024-08-08 12:03:06', 'CPP-0005', '2', '35', 'checkout', '0', '0000-00-00 00:00:00', 0, '');

--
-- Trigger `keranjang`
--
DELIMITER $$
CREATE TRIGGER `keranjang` AFTER UPDATE ON `keranjang` FOR EACH ROW Begin 
IF OLD.status = 'pending' AND NEW.status = 'checkout' THEN UPDATE barang SET stok = stok - NEW.quantity WHERE id_barang = NEW.id_barang;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `nota`
--

CREATE TABLE `nota` (
  `id_nota` int(11) NOT NULL,
  `nomor_transaksi` varchar(255) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `jumlah_transaksi` varchar(255) NOT NULL,
  `create_at` datetime NOT NULL,
  `create_by` int(11) NOT NULL,
  `update_at` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `delete` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nota`
--

INSERT INTO `nota` (`id_nota`, `nomor_transaksi`, `tanggal_transaksi`, `jumlah_transaksi`, `create_at`, `create_by`, `update_at`, `update_by`, `delete`) VALUES
(36, 'CTP-1', '2024-08-08', '715000', '2024-08-08 11:32:21', 9, '0000-00-00 00:00:00', 0, '0'),
(37, 'CTP-2', '2024-08-08', '120000', '2024-08-08 12:01:32', 35, '0000-00-00 00:00:00', 0, '0'),
(38, 'CTP-3', '2024-08-08', '15000', '2024-08-08 12:02:18', 35, '0000-00-00 00:00:00', 0, '0'),
(39, 'CTP-4', '2024-08-08', '240000', '2024-08-08 12:03:10', 35, '0000-00-00 00:00:00', 0, '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting`
--

CREATE TABLE `setting` (
  `id_setting` int(11) NOT NULL,
  `judul_website` varchar(255) NOT NULL,
  `tab_icon` varchar(255) NOT NULL,
  `menu_icon` varchar(255) NOT NULL,
  `login_icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `setting`
--

INSERT INTO `setting` (`id_setting`, `judul_website`, `tab_icon`, `menu_icon`, `login_icon`) VALUES
(1, 'Cipta Puri Powerindo', 'cipta puri-01.png', 'cipta puri-01.png', 'cipta puri-01.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `no_transaksi` varchar(255) DEFAULT NULL,
  `kode_keranjang` varchar(255) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `create_by` varchar(255) NOT NULL,
  `status_transaksi` enum('Done','Pending','On The Way') NOT NULL,
  `update_at` varchar(255) NOT NULL,
  `update_by` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `total_transaksi` varchar(255) NOT NULL,
  `deletet` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `no_transaksi`, `kode_keranjang`, `id_user`, `create_at`, `tanggal`, `create_by`, `status_transaksi`, `update_at`, `update_by`, `alamat`, `total_transaksi`, `deletet`) VALUES
(49, 'CTP-1', 'CPP-0001', NULL, '2024-08-08 11:32:21', '2024-08-08', '9', 'Done', '', '', '', '', '0'),
(50, 'CTP-2', 'CPP-0002', NULL, '2024-08-08 12:01:32', '2024-08-08', '35', 'Done', '', '', '', '', '0'),
(51, 'CTP-3', 'CPP-0004', NULL, '2024-08-08 12:02:18', '2024-08-08', '35', 'Done', '', '', '', '', '0'),
(52, 'CTP-4', 'CPP-0005', NULL, '2024-08-08 12:03:10', '2024-08-08', '35', 'Done', '', '', '', '', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `level` enum('1','2','3') DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL,
  `id_pt` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `delete` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `level`, `username`, `password`, `no_telp`, `id_pt`, `foto`, `update_by`, `update_at`, `create_at`, `email`, `delete`) VALUES
(35, '1', 'admin', 'c4ca4238a0b923820dcc509a6f75849b', NULL, NULL, 'admin.jpg', NULL, NULL, NULL, '', '0'),
(38, '3', 'pelanggan', 'c81e728d9d4c2f636f067f89cc14862c', NULL, NULL, 'admin.jpg', NULL, NULL, NULL, 'ahahaha@gmail.com', '0'),
(39, '3', 'wew', 'c4ca4238a0b923820dcc509a6f75849b', NULL, NULL, 'admin.jpg', NULL, NULL, NULL, 'ahahaha@gmail.com', '1'),
(40, '3', 'ayam', 'c4ca4238a0b923820dcc509a6f75849b', NULL, NULL, 'admin.jpg', NULL, NULL, NULL, 'baiclayburg@gmailcom', '1'),
(41, '3', 'tesaja', 'eccbc87e4b5ce2fe28308fd9f2a7baf3', NULL, NULL, 'admin.jpg', NULL, NULL, NULL, 'rawitcanva@gmail.com', '1');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`) USING BTREE;

--
-- Indeks untuk tabel `barangkeluar`
--
ALTER TABLE `barangkeluar`
  ADD PRIMARY KEY (`id_bkeluar`) USING BTREE;

--
-- Indeks untuk tabel `barangmasuk`
--
ALTER TABLE `barangmasuk`
  ADD PRIMARY KEY (`id_bmasuk`) USING BTREE;

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_Keranjang`) USING BTREE;

--
-- Indeks untuk tabel `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id_nota`);

--
-- Indeks untuk tabel `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`) USING BTREE;

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`) USING BTREE;

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `barangkeluar`
--
ALTER TABLE `barangkeluar`
  MODIFY `id_bkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT untuk tabel `barangmasuk`
--
ALTER TABLE `barangmasuk`
  MODIFY `id_bmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_Keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT untuk tabel `nota`
--
ALTER TABLE `nota`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `setting`
--
ALTER TABLE `setting`
  MODIFY `id_setting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
