-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Nov 2023 pada 02.26
-- Versi server: 10.4.18-MariaDB
-- Versi PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alat`
--

CREATE TABLE `alat` (
  `idalat` int(11) NOT NULL,
  `namaalat` varchar(25) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `deskalat` varchar(100) DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `alat`
--

INSERT INTO `alat` (`idalat`, `namaalat`, `kategori`, `deskalat`, `tanggal`, `status`) VALUES
(8, 'Epson L350', 'Printer', 'warna hitam bergaris', '2023-02-21 00:43:44', 'Rusak'),
(9, 'Canon D1300', 'Kamera', 'Layar LCD kotor dan ber-vignette', '2023-02-21 00:44:23', 'Diperbaiki'),
(10, 'Epson D700', 'Printer', 'Rusak Total', '2023-02-21 00:50:43', 'Harus Diganti'),
(11, 'Lampu Payung', 'Alat Foto', 'Kotor, warna payung menguning', '2023-02-21 11:39:24', 'Diperbaiki'),
(13, 'Epson L3210', 'Printer', 'tidak bisa menarik kertas yang lebih tebal dari 75g', '2023-02-22 01:57:35', 'Diperbaiki'),
(14, 'Canon D1300', 'Kamera', 'Kerusakan sudah ditangani', '2023-02-22 02:00:16', 'Baik'),
(15, 'Lampu Payung', 'Alat Foto', 'Kerusakan sudah ditangani', '2023-02-22 02:02:22', 'Baik'),
(17, 'Epson L3210', 'Printer', 'Kerusakan sudah ditangani', '2023-02-22 04:22:12', 'Baik'),
(18, 'Epson L350', 'Printer', 'Rusak Total', '2023-02-22 04:22:49', 'Harus Diganti'),
(19, 'Epson L3210', 'Printer', 'tidak bisa menarik kertas yang lebih tebal dari 75g', '2023-06-19 06:21:52', 'Rusak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aset`
--

CREATE TABLE `aset` (
  `idaset` int(11) NOT NULL,
  `namaaset` varchar(150) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `jenis` varchar(200) NOT NULL,
  `kondisi` varchar(50) NOT NULL,
  `tglinput` date NOT NULL,
  `tglupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `aset`
--

INSERT INTO `aset` (`idaset`, `namaaset`, `jumlah`, `jenis`, `kondisi`, `tglinput`, `tglupdate`) VALUES
(1, 'Ruko 2 Lantai', 1, 'Bangunan Tetap', 'Baik Seluruhnya', '2023-10-23', '2023-10-23 15:16:53'),
(2, 'Mobil GRAND MAX', 1, 'Kendaraan', 'Baik Seluruhnya', '2023-10-23', '2023-10-23 15:17:28'),
(4, 'Meja Kayu', 9, 'Barang Non-Elektronik', 'Baik Seluruhnya', '2023-11-04', '2023-11-04 05:56:41'),
(5, 'Etalase Kaca', 17, 'Barang Non-Elektronik', 'Baik Seluruhnya', '2021-01-22', '2023-11-07 01:13:00'),
(6, 'Alat Potong Kertas', 2, 'Barang Non-Elektronik', 'Baik Seluruhnya', '2022-12-15', '2023-11-07 01:40:41'),
(7, 'Alat Jilit Spiral', 2, 'Barang Non-Elektronik', 'Rusak Sebagian', '2015-03-12', '2023-11-07 01:41:53'),
(8, 'Cermin Besar', 1, 'Barang Non-Elektronik', 'Baik Seluruhnya', '2020-06-10', '2023-11-07 01:42:48'),
(9, 'Jas', 5, 'Barang Non-Elektronik', 'Baik Seluruhnya', '2019-01-10', '2023-11-07 01:43:22'),
(10, 'Dasi Hitam', 2, 'Barang Non-Elektronik', 'Baik Seluruhnya', '2020-09-01', '2023-11-07 01:43:53'),
(11, 'Pel Lantai', 3, 'Barang Non-Elektronik', 'Baik Seluruhnya', '2023-02-01', '2023-11-07 01:44:46'),
(12, 'Lampu', 12, 'Barang Elektronik', 'Baik Seluruhnya', '2016-05-18', '2023-11-07 01:45:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keluar`
--

CREATE TABLE `keluar` (
  `idkeluar` int(11) NOT NULL,
  `idtransaksi` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `keterangan` varchar(30) NOT NULL,
  `qty` int(11) NOT NULL,
  `satuan` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `keluar`
--

INSERT INTO `keluar` (`idkeluar`, `idtransaksi`, `idbarang`, `tanggal`, `keterangan`, `qty`, `satuan`) VALUES
(1, 1, 17, '2023-11-07 05:52:20', 'terjual', 5, 'pcs'),
(2, 1, 18, '2023-11-07 05:52:20', 'terjual', 5, 'pcs'),
(3, 1, 20, '2023-11-07 05:52:20', 'terjual', 10, 'pcs');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `iduser` int(11) NOT NULL,
  `email` varchar(75) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`iduser`, `email`, `password`) VALUES
(1, 'anggatausendiri@gmail.com', 'bismillah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `idtransaksi` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `qty` int(11) NOT NULL,
  `idsupplier` int(11) NOT NULL,
  `nota` varchar(20) NOT NULL,
  `satuan` varchar(4) NOT NULL,
  `hargamasuk` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idtransaksi`, `idbarang`, `tanggal`, `qty`, `idsupplier`, `nota`, `satuan`, `hargamasuk`) VALUES
(6, 6, 15, '2023-11-07 01:04:07', 20, 1, 'EP-31103', 'pcs', '160000'),
(7, 7, 17, '2023-11-07 01:09:09', 100, 3, '2175', 'pcs', '400000'),
(8, 7, 18, '2023-11-07 01:09:10', 200, 9, '66754421', 'pcs', '700000'),
(9, 7, 20, '2023-11-07 01:09:10', 50, 1, '643187111', 'pcs', '50000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemasukan`
--

CREATE TABLE `pemasukan` (
  `idpemasukan` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `namabarang` varchar(200) NOT NULL,
  `harga` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemasukan`
--

INSERT INTO `pemasukan` (`idpemasukan`, `tanggal`, `namabarang`, `harga`) VALUES
(1, '2023-11-08 01:18:13', 'Coca-cola botol 0,5 L', '20000'),
(2, '2023-11-08 01:18:13', 'Indomilk Stroberi Botol', '17500'),
(3, '2023-11-08 01:18:13', 'ID Card plastik uk. B3', '25000'),
(5, '2023-11-08 01:22:26', 'Bayar Fotocopy & Cetak Foto', '35000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `idpengeluaran` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `namabarang` varchar(200) NOT NULL,
  `harga` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengeluaran`
--

INSERT INTO `pengeluaran` (`idpengeluaran`, `tanggal`, `namabarang`, `harga`) VALUES
(5, '2023-11-07 04:56:46', 'Epson 003 Magenta', '160000'),
(6, '2023-11-07 04:56:47', 'Coca-cola botol 0,5 L', '400000'),
(7, '2023-11-07 04:56:47', 'Indomilk Stroberi Botol', '700000'),
(8, '2023-11-07 04:56:47', 'ID Card plastik uk. B3', '50000'),
(9, '2023-11-07 05:57:25', 'Uang Makan Harian', '105000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `idpesanan` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `namabarang` varchar(75) NOT NULL,
  `kategori` varchar(75) NOT NULL,
  `qty` int(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`idpesanan`, `tanggal`, `namabarang`, `kategori`, `qty`) VALUES
(35, '2023-08-24 14:41:52', 'Kertas Folio Bergaris', 'Kertas', 300),
(36, '2023-08-24 14:37:28', 'Faber-Castell Pensil Warna isi 12', 'Alat Tulis', 100),
(37, '2023-08-24 14:38:15', 'Alat Lem Tembak', 'Elektronik', 15),
(38, '2023-08-24 14:39:12', 'E-Print 001/003 Yellow', 'Tinta Printer', 50),
(39, '2023-08-24 14:46:46', 'Aqua Botol Uk. 600ml', 'minuman', 100),
(40, '2023-08-24 14:47:55', 'Buku Gambar A3', 'Alat Tulis', 30),
(41, '2023-08-24 14:49:48', 'Cartridge Epson', 'Suku Cadang Printer', 20),
(42, '2023-08-24 14:52:12', 'Keyboard Genius', 'Elektronik', 5),
(43, '2023-08-24 14:53:09', 'Bingkai 8\" x 10\"', 'Bingkai Foto', 40),
(44, '2023-08-24 14:53:51', 'Tasbih Digital 3 tombol', 'Elektronik', 20),
(45, '2023-08-25 06:24:30', 'Epson 003 Magenta', 'Tinta Printer', 100),
(46, '2023-08-25 06:25:47', 'SIDU A4 Putih 75g', 'Kertas', 100),
(47, '2023-08-25 06:25:47', 'Epson 003 Black', 'Tinta Printer', 100);

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok`
--

CREATE TABLE `stok` (
  `idbarang` int(11) NOT NULL,
  `namabarang` varchar(100) NOT NULL,
  `kategori` varchar(75) NOT NULL,
  `stok` int(11) NOT NULL,
  `image` varchar(99) DEFAULT NULL,
  `satuan` varchar(15) NOT NULL,
  `harga` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `stok`
--

INSERT INTO `stok` (`idbarang`, `namabarang`, `kategori`, `stok`, `image`, `satuan`, `harga`) VALUES
(15, 'Epson 003 Magenta', 'Tinta Printer', 40, '38d9d2adc5561b9f5e9651c382fed13b.jpg', 'pcs', '100000'),
(16, 'SIDU A4 Putih 75g', 'Kertas', 10, '508436c1a4e0ff6c3e76ce6a42ee9e7e.jpg', 'rim', '50000'),
(17, 'Coca-cola botol 0,5 L', 'minuman', 295, '35042c05f676d93d3bd28691dc7fca3d.jpg', 'pcs', '4000'),
(18, 'Indomilk Stroberi Botol', 'minuman', 395, '62e6f92d09bb894e82f9d2670c46990f.jpg', 'pcs', '3500'),
(19, 'Epson 003 Black', 'Tinta Printer', 15, 'e48c82d716b7a36633adaf1e6d5cb683.jpg', 'pcs', '100000'),
(20, 'ID Card plastik uk. B3', 'Peralatan Kantor', 135, '94e72df2ca40ec84f6b9736695c1dbae.jpg', 'pcs', '2500'),
(63, 'Sticky Notes 76 x 51 mm', 'Peralatan Kantor', 49, 'c08112123bc34b1163df53b5fb2c4515.jpg', 'pack', '7000'),
(64, 'Zebra Sarasa Clip 0.5 Black', 'Alat Tulis', 100, 'ce2a04adb660fcd2a23182411def233e.jpg', 'pcs', '20000'),
(65, 'Pentel Graph 1000', 'Alat Tulis', 50, '1fe5df42c0e8ebf0edaa897a9137ee0e.jpg', 'pcs', '200000'),
(66, 'ABC Alkaline AAA isi 7', 'Elektronik', 14, 'c4fdec7ff492cee2c02ee5cdfc1fe9ed.jpg', 'pack', '50000'),
(67, 'Karton Board A4', 'Peralatan Kantor', 100, '4ddcbf731a72c2ab3a14d39271ec40aa.jpg', 'ply', '5000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `idsupplier` int(11) NOT NULL,
  `namasupplier` varchar(150) NOT NULL,
  `kategorisupplier` varchar(75) NOT NULL,
  `nomorsupplier` varchar(50) NOT NULL,
  `alamat` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`idsupplier`, `namasupplier`, `kategorisupplier`, `nomorsupplier`, `alamat`) VALUES
(1, 'Jaya Mas Stationery', 'Kertas', '(0511) 6753834', 'Jl. Kuripan Banjarmasin'),
(2, 'AZ Print', 'Foto Ukuran Besar', '0852 2134 5781', 'Jl. Kuripan Banjarmasin'),
(3, 'Coca Cola Banjarbaru', 'Minuman Ringan', '0813 5153 1870', 'Jl. A. Yani km.25 Landasan Ulin'),
(4, 'Indoeskrim Gambut', 'Es Krim', '0853 2178 6743', 'Jl. A. Yani km.15 Gambut'),
(5, 'Percetakan \"INAYAH\"', 'Buku Agama', '0878 5224 901', 'Pertokoan Berlian N0.1C Martapura'),
(6, 'Coca-Cola Banjarmasin', 'Minuman Ringan', '0821-5838-4070', 'Jl. A. Yani Km.19,5 Liang Anggang'),
(7, 'Aice Banjarmasin', 'Es Krim', '0811-5127-733', 'Jl. A. Yani km.15 Gambut Kab. Banjar'),
(8, 'Twincom Banjarbaru', 'Aksesoris Komputer', '0878 5224 901', 'Jl. A. Yani km.25 Landasan Ulin'),
(9, 'PT. Indofood CBP Sukses Makmur', 'Snack dan Minuman', '0813 5153 1870', 'Jl. A. Yani Km.19,5 Liang Anggang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksikeluar`
--

CREATE TABLE `transaksikeluar` (
  `idtransaksi` int(11) NOT NULL,
  `kodetransaksi` char(15) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksikeluar`
--

INSERT INTO `transaksikeluar` (`idtransaksi`, `kodetransaksi`, `tanggal`, `jumlah`) VALUES
(1, 'EX231107008', '2023-11-07 05:52:20', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksimasuk`
--

CREATE TABLE `transaksimasuk` (
  `idtransaksi` int(11) NOT NULL,
  `kodetransaksi` char(15) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pengirim` varchar(100) NOT NULL,
  `penerima` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksimasuk`
--

INSERT INTO `transaksimasuk` (`idtransaksi`, `kodetransaksi`, `tanggal`, `pengirim`, `penerima`, `jumlah`) VALUES
(6, 'EN231107001', '2023-11-07 01:04:07', 'Fahrin', 'Riska', 1),
(7, 'EN231107007', '2023-11-07 01:09:09', 'Fauzan', 'Inah', 3);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`idalat`);

--
-- Indeks untuk tabel `aset`
--
ALTER TABLE `aset`
  ADD PRIMARY KEY (`idaset`);

--
-- Indeks untuk tabel `keluar`
--
ALTER TABLE `keluar`
  ADD PRIMARY KEY (`idkeluar`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`);

--
-- Indeks untuk tabel `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indeks untuk tabel `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD PRIMARY KEY (`idpemasukan`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`idpengeluaran`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`idpesanan`);

--
-- Indeks untuk tabel `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`idbarang`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`idsupplier`);

--
-- Indeks untuk tabel `transaksikeluar`
--
ALTER TABLE `transaksikeluar`
  ADD PRIMARY KEY (`idtransaksi`);

--
-- Indeks untuk tabel `transaksimasuk`
--
ALTER TABLE `transaksimasuk`
  ADD PRIMARY KEY (`idtransaksi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alat`
--
ALTER TABLE `alat`
  MODIFY `idalat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `aset`
--
ALTER TABLE `aset`
  MODIFY `idaset` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `keluar`
--
ALTER TABLE `keluar`
  MODIFY `idkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pemasukan`
--
ALTER TABLE `pemasukan`
  MODIFY `idpemasukan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `idpengeluaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `idpesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT untuk tabel `stok`
--
ALTER TABLE `stok`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `idsupplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `transaksikeluar`
--
ALTER TABLE `transaksikeluar`
  MODIFY `idtransaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transaksimasuk`
--
ALTER TABLE `transaksimasuk`
  MODIFY `idtransaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
