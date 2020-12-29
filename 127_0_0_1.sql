-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2020 at 05:27 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nsi_koperasi`
--
CREATE DATABASE IF NOT EXISTS `nsi_koperasi` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `nsi_koperasi`;

-- --------------------------------------------------------

--
-- Table structure for table `backup_db`
--

CREATE TABLE `backup_db` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_backup` varchar(255) NOT NULL,
  `pathdb` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `backup_db`
--

INSERT INTO `backup_db` (`id`, `tanggal`, `nama_backup`, `pathdb`, `created_by`) VALUES
(0, '2020-11-19', 'Backup-Database-Koperasi-11-19-2020-20-21-05.sql', '', 'admin'),
(0, '2020-11-19', 'Backup-Database-Koperasi-11-19-2020-20-21-59.sql', '', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `bendahara`
--

CREATE TABLE `bendahara` (
  `id` int(225) NOT NULL,
  `tanggal` date NOT NULL,
  `uraian` varchar(255) NOT NULL,
  `jumlah` int(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bendahara`
--

INSERT INTO `bendahara` (`id`, `tanggal`, `uraian`, `jumlah`, `created_by`) VALUES
(1, '2020-12-01', 'jajal', 1000000, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `biaya_umum`
--

CREATE TABLE `biaya_umum` (
  `id` int(255) NOT NULL,
  `tanggal` date NOT NULL,
  `uraian` varchar(255) NOT NULL,
  `untuk_kas` int(255) NOT NULL,
  `jumlah` int(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `dari_akun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `biaya_umum`
--

INSERT INTO `biaya_umum` (`id`, `tanggal`, `uraian`, `untuk_kas`, `jumlah`, `created_by`, `dari_akun`) VALUES
(1, '2020-12-18', 'ATK', 1, 30000, 'admin', 111);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('d1e924c02932432aabab44fd8aae48bd', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36', 1609171473, 'a:4:{s:9:\"user_data\";s:0:\"\";s:5:\"login\";b:1;s:6:\"u_name\";s:5:\"admin\";s:5:\"level\";s:5:\"admin\";}');

-- --------------------------------------------------------

--
-- Table structure for table `desc_neraca`
--

CREATE TABLE `desc_neraca` (
  `id` int(11) NOT NULL,
  `id_type_desc_neraca` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `desc_neraca`
--

INSERT INTO `desc_neraca` (`id`, `id_type_desc_neraca`, `title`) VALUES
(0, 1, 'Deskripsi 1');

-- --------------------------------------------------------

--
-- Table structure for table `jns_akun`
--

CREATE TABLE `jns_akun` (
  `id` bigint(20) NOT NULL,
  `kd_aktiva` varchar(5) DEFAULT NULL,
  `jns_trans` varchar(50) NOT NULL,
  `akun` enum('Aktiva','Pasiva') DEFAULT NULL,
  `laba_rugi` enum('','PENDAPATAN','BIAYA') NOT NULL DEFAULT '',
  `pemasukan` enum('Y','N') DEFAULT NULL,
  `pengeluaran` enum('Y','N') DEFAULT NULL,
  `aktif` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `jns_akun`
--

INSERT INTO `jns_akun` (`id`, `kd_aktiva`, `jns_trans`, `akun`, `laba_rugi`, `pemasukan`, `pengeluaran`, `aktif`) VALUES
(5, 'A4', 'Piutang Usaha', 'Aktiva', '', 'Y', 'Y', 'Y'),
(6, 'A5', 'Piutang Karyawan', 'Aktiva', '', 'N', 'Y', 'N'),
(7, 'A6', 'Pinjaman Anggota', 'Aktiva', '', NULL, NULL, 'Y'),
(8, 'A7', 'Piutang Anggota', 'Aktiva', '', 'Y', 'Y', 'N'),
(9, 'A8', 'Persediaan Barang', 'Aktiva', '', 'N', 'Y', 'Y'),
(10, 'A9', 'Biaya Dibayar Dimuka', 'Aktiva', '', 'N', 'Y', 'Y'),
(11, 'A10', 'Perlengkapan Usaha', 'Aktiva', '', 'N', 'Y', 'Y'),
(17, 'C', 'Aktiva Tetap Berwujud', 'Aktiva', '', NULL, NULL, 'Y'),
(18, 'C1', 'Peralatan Kantor', 'Aktiva', '', 'N', 'Y', 'Y'),
(19, 'C2', 'Inventaris Kendaraan', 'Aktiva', '', 'N', 'Y', 'Y'),
(20, 'C3', 'Mesin', 'Aktiva', '', 'N', 'Y', 'Y'),
(21, 'C4', 'Aktiva Tetap Lainnya', 'Aktiva', '', 'Y', 'N', 'Y'),
(26, 'E', 'Modal Pribadi', 'Aktiva', '', NULL, NULL, 'N'),
(27, 'E1', 'Prive', 'Aktiva', '', 'Y', 'Y', 'N'),
(28, 'F', 'Utang', 'Pasiva', '', NULL, NULL, 'Y'),
(29, 'F1', 'Utang Usaha', 'Pasiva', '', 'Y', 'Y', 'Y'),
(31, 'K3', 'Pengeluaran Lainnya', 'Aktiva', '', 'N', 'Y', 'N'),
(32, 'F4', 'Simpanan Sukarela', 'Pasiva', '', NULL, NULL, 'Y'),
(33, 'F6', 'Utang Pajak', 'Pasiva', '', 'Y', 'Y', 'Y'),
(36, 'H', 'Utang Jangka Panjang', 'Pasiva', '', NULL, NULL, 'Y'),
(37, 'H1', 'Utang Bank', 'Pasiva', '', 'Y', 'Y', 'Y'),
(38, 'H2', 'Obligasi', 'Pasiva', '', 'Y', 'Y', 'N'),
(39, 'I', 'Modal', 'Pasiva', '', NULL, NULL, 'Y'),
(40, 'I1', 'Simpanan Pokok', 'Pasiva', '', NULL, NULL, 'Y'),
(41, 'I2', 'Simpanan Wajib', 'Pasiva', '', NULL, NULL, 'Y'),
(42, 'I3', 'Modal Awal', 'Pasiva', '', 'Y', 'Y', 'Y'),
(43, 'I4', 'Modal Penyertaan', 'Pasiva', '', 'Y', 'Y', 'N'),
(44, 'I5', 'Modal Sumbangan', 'Pasiva', '', 'Y', 'Y', 'Y'),
(45, 'I6', 'Modal Cadangan', 'Pasiva', '', 'Y', 'Y', 'Y'),
(47, 'J', 'Pendapatan', 'Pasiva', 'PENDAPATAN', NULL, NULL, 'Y'),
(48, 'J1', 'Pembayaran Angsuran', 'Pasiva', '', NULL, NULL, 'Y'),
(49, 'J2', 'Pendapatan Lainnya', 'Pasiva', 'PENDAPATAN', 'Y', 'N', 'Y'),
(50, 'K', 'Beban', 'Aktiva', '', NULL, NULL, 'Y'),
(52, 'K2', 'Beban Gaji Karyawan', 'Aktiva', 'BIAYA', 'N', 'Y', 'Y'),
(53, 'K3', 'Biaya Listrik dan Air', 'Aktiva', 'BIAYA', 'N', 'Y', 'Y'),
(54, 'K4', 'Biaya Transportasi', 'Aktiva', 'BIAYA', 'N', 'Y', 'Y'),
(60, 'K10', 'Biaya Lainnya', 'Aktiva', 'BIAYA', 'N', 'Y', 'Y'),
(110, 'TRF', 'Transfer Antar Kas', NULL, '', NULL, NULL, 'N'),
(111, 'A11', 'Permisalan', 'Aktiva', '', 'Y', 'Y', 'Y'),
(112, 'F5', 'Simpanan Khusus', 'Pasiva', '', 'N', 'N', 'Y'),
(113, 'ASD', 'ASD', 'Aktiva', '', 'Y', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `jns_angsuran`
--

CREATE TABLE `jns_angsuran` (
  `id` bigint(20) NOT NULL,
  `ket` int(11) NOT NULL,
  `aktif` enum('Y','T','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `jns_angsuran`
--

INSERT INTO `jns_angsuran` (`id`, `ket`, `aktif`) VALUES
(14, 1, 'Y'),
(15, 2, 'Y'),
(16, 3, 'Y'),
(17, 4, 'Y'),
(18, 5, 'Y'),
(19, 6, 'Y'),
(20, 7, 'Y'),
(21, 8, 'Y'),
(22, 9, 'Y'),
(23, 10, 'Y'),
(25, 11, 'Y'),
(26, 12, 'Y'),
(27, 15, 'Y'),
(28, 20, 'Y'),
(29, 24, 'Y'),
(30, 30, 'Y'),
(31, 36, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `jns_simpan`
--

CREATE TABLE `jns_simpan` (
  `id` int(5) NOT NULL,
  `jns_simpan` varchar(30) NOT NULL,
  `inisial` varchar(225) DEFAULT NULL,
  `jumlah` double NOT NULL,
  `tampil` enum('Y','T') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `jns_simpan`
--

INSERT INTO `jns_simpan` (`id`, `jns_simpan`, `inisial`, `jumlah`, `tampil`) VALUES
(32, 'Simpanan Sukarela', 'simpanansukarela', 0, 'Y'),
(40, 'Simpanan Pokok', 'simpananpokok', 50000, 'Y'),
(41, 'Simpanan Wajib', 'simpananwajib', 300000, 'Y'),
(112, 'Simpanan Khusus', 'simpanankhusus', 100000, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `nama_kas_tbl`
--

CREATE TABLE `nama_kas_tbl` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(225) CHARACTER SET latin1 NOT NULL,
  `aktif` enum('Y','T') CHARACTER SET latin1 NOT NULL,
  `tmpl_simpan` enum('Y','T') CHARACTER SET latin1 NOT NULL,
  `tmpl_penarikan` enum('Y','T') CHARACTER SET latin1 NOT NULL,
  `tmpl_pinjaman` enum('Y','T') CHARACTER SET latin1 NOT NULL,
  `tmpl_bayar` enum('Y','T') CHARACTER SET latin1 NOT NULL,
  `tmpl_pemasukan` enum('Y','T') NOT NULL,
  `tmpl_pengeluaran` enum('Y','T') NOT NULL,
  `tmpl_transfer` enum('Y','T') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `nama_kas_tbl`
--

INSERT INTO `nama_kas_tbl` (`id`, `nama`, `aktif`, `tmpl_simpan`, `tmpl_penarikan`, `tmpl_pinjaman`, `tmpl_bayar`, `tmpl_pemasukan`, `tmpl_pengeluaran`, `tmpl_transfer`) VALUES
(1, 'Kas Tunai', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(2, 'Kas Besar', 'Y', 'T', 'T', 'Y', 'T', 'Y', 'Y', 'Y'),
(3, 'Bank BNI', 'Y', 'T', 'T', 'T', 'T', 'Y', 'Y', 'Y'),
(4, 'TKD', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `pekerjaan`
--

CREATE TABLE `pekerjaan` (
  `id_kerja` varchar(5) NOT NULL,
  `jenis_kerja` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `pekerjaan`
--

INSERT INTO `pekerjaan` (`id_kerja`, `jenis_kerja`) VALUES
('1', 'TNI'),
('2', 'PNS'),
('3', 'Karyawan Swasta'),
('4', 'Guru'),
('5', 'Buruh'),
('6', 'Tani'),
('7', 'Pedagang'),
('8', 'Wiraswasta'),
('9', 'Mengurus Rumah Tangga'),
('99', 'Lainnya'),
('98', 'Pensiunan'),
('97', 'Penjahit'),
('1', 'TNI'),
('2', 'PNS'),
('3', 'Karyawan Swasta'),
('4', 'Guru'),
('5', 'Buruh'),
('6', 'Tani'),
('7', 'Pedagang'),
('8', 'Wiraswasta'),
('9', 'Mengurus Rumah Tangga'),
('99', 'Lainnya'),
('98', 'Pensiunan'),
('97', 'Penjahit');

-- --------------------------------------------------------

--
-- Table structure for table `pembagian_shu_labarugi`
--

CREATE TABLE `pembagian_shu_labarugi` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kode` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `persentase` float NOT NULL,
  `tahun` int(11) NOT NULL,
  `create_date` date NOT NULL,
  `create_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembagian_shu_labarugi`
--

INSERT INTO `pembagian_shu_labarugi` (`id`, `nama`, `kode`, `type`, `persentase`, `tahun`, `create_date`, `create_by`) VALUES
(0, 'Dana Cadangan', 'DC', '1', 15, 0, '2020-12-04', '0'),
(5, 'Bagian Anggota', 'BA', '1', 10, 0, '2020-12-04', '0'),
(6, 'Simpanan Anggota', 'SA', '2', 25, 0, '2020-12-06', '0'),
(7, 'Pinjaman Anggota', 'PA', '2', 25, 0, '2020-12-06', '0'),
(8, 'Dana Pengurus', 'DP', '1', 15, 0, '2020-12-06', '0'),
(9, 'Dana Karyawan', 'DK', '1', 15, 0, '2020-12-06', '0'),
(10, 'Dana Pendidikan', 'DPend', '1', 10, 0, '2020-12-06', '0'),
(11, 'Dana Pembangunan', 'DPem', '1', 11, 0, '2020-12-06', '0'),
(12, 'Dana Sosial', 'DS', '1', 11, 0, '2020-12-06', '0');

-- --------------------------------------------------------

--
-- Table structure for table `suku_bunga`
--

CREATE TABLE `suku_bunga` (
  `id` int(10) NOT NULL,
  `opsi_key` varchar(20) NOT NULL,
  `opsi_val` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `suku_bunga`
--

INSERT INTO `suku_bunga` (`id`, `opsi_key`, `opsi_val`) VALUES
(1, 'bg_tab', '0'),
(2, 'bg_pinjam', '2'),
(3, 'biaya_adm', '1500'),
(4, 'denda', '1000'),
(5, 'denda_hari', '15'),
(6, 'dana_cadangan', '50'),
(7, 'jasa_anggota', '0'),
(8, 'dana_pengurus', '30'),
(9, 'dana_karyawan', '0'),
(10, 'pinjaman_anggota', '30'),
(11, 'dana_sosial', '30'),
(12, 'jasa_usaha', '0'),
(13, 'jasa_modal', '0'),
(14, 'pjk_pph', '5'),
(15, 'pinjaman_bunga_tipe', 'A'),
(16, 'bagian_anggota', '30'),
(17, 'simpanan_anggota', '30'),
(18, 'dana_karyawan', '0'),
(19, 'dana_pendidikan', '30'),
(20, 'dana_pembangunan', '30'),
(21, 'dana_sosial', '30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_anggota`
--

CREATE TABLE `tbl_anggota` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(255) CHARACTER SET latin1 NOT NULL,
  `identitas` varchar(255) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `tmp_lahir` varchar(225) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `status` varchar(30) NOT NULL,
  `agama` varchar(30) NOT NULL,
  `departement` varchar(255) NOT NULL,
  `pekerjaan` varchar(30) NOT NULL,
  `alamat` text CHARACTER SET latin1 NOT NULL,
  `kota` varchar(255) NOT NULL,
  `notelp` varchar(12) NOT NULL,
  `tgl_daftar` date NOT NULL,
  `jabatan_id` int(10) NOT NULL,
  `aktif` enum('Y','N') NOT NULL,
  `pass_word` varchar(225) NOT NULL,
  `file_pic` varchar(225) NOT NULL,
  `created_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_anggota`
--

INSERT INTO `tbl_anggota` (`id`, `nama`, `identitas`, `jk`, `tmp_lahir`, `tgl_lahir`, `status`, `agama`, `departement`, `pekerjaan`, `alamat`, `kota`, `notelp`, `tgl_daftar`, `jabatan_id`, `aktif`, `pass_word`, `file_pic`, `created_date`) VALUES
(1, 'Dra. Mariana, M.Si', '196708081993032005/126207', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'khatolik', 'QWE', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '576b7-capture.png', '2020-11-18 20:21:58'),
(2, 'Abdul Manaf, S.Sos, M.Si', '196210171985031014/086554', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(3, 'Eko Parawiyanto, S.AP', '196407191985031008/126026', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(4, 'Budi Purnama, S.ST', '196906301993031004/126163', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(5, 'Sumiarsih', '196208281994012001/117950', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(6, 'Yaya', '197101152007011021/168216', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(7, 'Imam Kanapi, S.Sos', '197902282007011015/168331', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(8, 'Slamet Rianto', '196509141988031005/126314', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(9, 'Tata Sasmita, S.AP', '196402111996031001/119317', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(10, 'Edi Muhammaddiah', '197307172007011030/166102', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(11, 'Mohamad Fauzi', '198009092014081005/188612', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(12, 'Agus mulyadi', '197504192007011011/166827', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(13, 'Rossyanah Rachmawati, A.Md', '198707162011012025/181356', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(14, 'Hasan', '196501121989031005/125901', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(15, 'Fatmawati Sinaga, S.Sos', '197106221993032001/126263', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(16, 'Christina Mauliate Napitupulu', '196308061990032005/126237', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(17, 'Sri Darmini, S. AP', '196008311982012002/125951', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(18, 'Rita Indah Yulistanti, S.ST, M.Si', '196907231990032002/126295', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(19, 'Ratna Tri Jayanti, A.Md', '198301042011012010/181550', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(20, 'Dianto Tiwa', '198410022008011007/170008', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(21, 'Muhamad Imron Sumadi', '198103172007011006/168624', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(22, 'Yenti Kemala, AKS', '196906271998032003/125910', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(23, 'Evi Agustiawati, S.Sos', '196708141990052001/114350', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(24, 'Jamiatur Rosyidah', '197209281996032002/119938', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(25, 'Hanny Desto, SE', '197512262010011010/178534', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(26, 'Desty Anggraini, A.Md', '198812142011012009/181497', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(27, 'Pirmansyah', '197604302008011015/170006', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'Sekretariat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(28, 'Chaidir, S.Sos, M.Si', '196608181990031008', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(29, 'Dra. Sri Widowati, M.Si', '196601281992012001/126053', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(30, 'Danu Rachmad Sambayu', '197912142008011017/170567', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(31, 'Ahmad Saiun', '198012012007011007/168673', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(32, 'Dini Andriyani Indra Utami, S.Sos', '198402232010012031/177909', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(33, 'Ira Ayu Puspita, S.Psi', '198708042011012015/012015', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(34, 'Titi Purwanti, SE, MAP', '197102081993032002/126499', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(35, 'Ramlan Nuzul, S.Ag', '197410102007011039/168333', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(36, 'Drs. Hendri', '196607301993031004/126129', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(37, 'Jamrotun', '196304041984031006/125963', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(38, 'Ani Nasariani Komalawati, BSW', '196506201989012002/126039', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(39, 'Sumarso', '196708221989071002/113220', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(40, 'Aminullah', '197312222007011016/167179', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(41, 'Lenny Mariani Manurung, S.Sos', '198311232010012027/178316', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(42, 'Slamet Sumono', '197310022007011014/166091', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(43, 'Jahroni', '196205031991121002/126080', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(44, 'Hasan', '197502222007011021/168265', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(45, 'Mursan', '196808031989021001/112431', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'Bidang Rehabilitasi Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(46, 'Dra. Susy Dwi Harini, MM', '196705251993032008/126870', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'Bidang Pemberdayaan Sosial dan Penanggulangan Kemiskinan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(47, 'Dahrul Oktavian, S.Sos', '198410022010011021/177961', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'Bidang Pemberdayaan Sosial dan Penanggulangan Kemiskinan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(48, 'Bahruddin', '197308082007011022/168251', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'Bidang Pemberdayaan Sosial dan Penanggulangan Kemiskinan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(49, 'Eny Suhaeni', '196709051989072001/113228', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'Bidang Pemberdayaan Sosial dan Penanggulangan Kemiskinan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(50, 'Dra. Theresia Hermin Sunar I', '196708051993032010/122250', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'Bidang Pemberdayaan Sosial dan Penanggulangan Kemiskinan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(51, 'Sumantri', '197007142008011016/170023', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'Bidang Pemberdayaan Sosial dan Penanggulangan Kemiskinan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(52, 'Rani Nurani, S.Sos, M.Si', '197408051998032002/123879', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'Bidang Pemberdayaan Sosial dan Penanggulangan Kemiskinan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(53, 'Upi Suprihatini, S. AP', '196405161989022002/112211', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'Bidang Pemberdayaan Sosial dan Penanggulangan Kemiskinan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(54, 'Titi Priyatini', '196305231985092001/100280', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'Bidang Pemberdayaan Sosial dan Penanggulangan Kemiskinan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(55, 'Sunarto', '196404211988031009/126016', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'Bidang Pemberdayaan Sosial dan Penanggulangan Kemiskinan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(56, 'Hartono, SH', '197205032006041013/165653', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'Bidang Pemberdayaan Sosial dan Penanggulangan Kemiskinan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(57, 'Winny Wahyuni, SH', '198012112009022001/183324', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'Bidang Pemberdayaan Sosial dan Penanggulangan Kemiskinan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(58, 'Toipah', '197607102007012021/166104', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'Bidang Pemberdayaan Sosial dan Penanggulangan Kemiskinan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(59, 'Susanto', '197208131998031006/124957', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'Bidang Pemberdayaan Sosial dan Penanggulangan Kemiskinan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(60, 'H. Tarmijo Damanik, AKS, MM', '196212191986021006/122047', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'Bidang Perlindungan Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(61, 'Sahrul, S.Sos', '196607041989031006/112452', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'Bidang Perlindungan Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(62, 'I. Wayan Budi Arta', '197703122007011021/168210', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'Bidang Perlindungan Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(63, 'Moh Jaya ', '196306021985031005/087000', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'Bidang Perlindungan Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(64, 'Idha Mahardikawati, S.Psi', '198608172015042001/185077', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'Bidang Perlindungan Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(65, 'Kartinah', '197707292007012019/168632', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'Bidang Perlindungan Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(66, 'Warman', '197101011989031001/112136', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'Bidang Perlindungan Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(67, 'Asta Devin Loriana, SH', '196903221997032003/126028', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'Bidang Perlindungan Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(68, 'Wessy La Riza, S.Sos', '198306142010012037/177958', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'Bidang Perlindungan Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(69, 'Supartono', '196702191988031003/111268', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'Bidang Perlindungan Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(70, 'Nano Triyono', '197810062008011011/170007', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'Bidang Perlindungan Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(71, 'H. Nurshobah, S.Ag, M.Si', '197212251998031007/123633', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'Bidang Perlindungan Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(72, 'Saman Hudi', '198205072007011008/168585', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'Bidang Perlindungan Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(73, 'Jauhar Rosyidi', '198212132007011007/168735', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'Bidang Perlindungan Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(74, 'Apriati', '196904271995032001/118815', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'Bidang Perlindungan Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(75, 'Shely Widyanti', '198208202010012037/177728', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'Bidang Perlindungan Sosial', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(76, 'Drs. Heri Suhartono', '196306041990031009/118579', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'Bidang Pengembangan Penyelenggaraan Kesos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(77, 'Miftah Hulhuda, S. Ag, M.Si', '196505131998031002/123669', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'Bidang Pengembangan Penyelenggaraan Kesos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(78, 'Prasetya Abdillah, S.Sos', '198111162010011016/177912', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'Bidang Pengembangan Penyelenggaraan Kesos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(79, 'Sri Astuti', '196608092007012013/166334', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'Bidang Pengembangan Penyelenggaraan Kesos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(80, 'Achmad Zen, S.Kom', '197912222006041014/165651', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'Bidang Pengembangan Penyelenggaraan Kesos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(81, 'Gufran', '197606082008011012/170031', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'Bidang Pengembangan Penyelenggaraan Kesos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(82, 'Stella Hayuning Anandawari, SE', '198010242014082003/188636', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'Bidang Pengembangan Penyelenggaraan Kesos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(83, 'Tito Yuono', '197606292007011005/166098', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'Bidang Pengembangan Penyelenggaraan Kesos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(84, 'Diana, S.Sos, M.Soc Wk', '197312141998032002/123796', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'Bidang Pengembangan Penyelenggaraan Kesos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(85, 'Acep Adang Imansyah, SH', '197112252006041026/165243', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'Bidang Pengembangan Penyelenggaraan Kesos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(86, 'Ivan Cahyadi', '197712092007011011/166449', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'Bidang Pengembangan Penyelenggaraan Kesos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(87, 'Saharudin', '196604261986121001/108916', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'Bidang Pengembangan Penyelenggaraan Kesos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(88, 'Adi Sulistiono', '197712102014121003/187314', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'Bidang Pengembangan Penyelenggaraan Kesos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(89, 'Dra. Susana Budi S, M.Si', '196710161993032002/125940', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(90, 'H. Ahmad Taufiq H , S.Ag', '196602211989021003/112117', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(91, 'Siti Rokhayati, S.AP', '197102041992022001/126256', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(92, 'Dwi Handayani, SE', '198808182010012017/177452', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(93, 'Haryanto', '197207042008011020/170010', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(94, 'Nawi', '197312182007012013/168726', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(95, 'Dewi Aryati Ningrum, S.Sos', '\'198304222010012027/178848', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(96, 'Dicky Setiawan', '197907172007011021', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(97, 'Sutirta', '196501181993031002/126392', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(98, 'Agus Kurniawan', '197108162007011028/166087', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(99, 'Alan Buyung Maulana', '197911072007011010/168668', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(100, 'Maria Risda Pasaribu, SE', '196707201989022001/112148', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(101, 'Suyati', '196407121985032006/125961', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(102, 'Pawit Paulida', '197001042014082001', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(103, 'Dahlia Tamar, SE', '196009241983032013/126169', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(104, 'Tunji Susanto', '196301141986031006/126476', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(105, 'Winarno', '197307071992031001/125915', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(106, 'H. Fadillah', '196508131989031017/112867', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(107, 'Suciati, S.AP', '196007071981032004/126252', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(108, 'Budiana', '197212121996031003/119658', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(109, 'Syahid, S.Sos', '196610181989101001/113644', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(110, 'Lismaria', '196501301988032001/125965', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(111, 'Yuli Susanti, AKS, M.Si', '196807201989022002/112208', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(112, 'Usman', '197010052007011051/168225', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(113, 'Rabihatun Noor, S.Sos, M.Si', '196603224989022001/112103', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(114, 'Esly BR Haloho', '196312311985032075/126221', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(115, 'Arief Sampurno', '196512051989031007/126974', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(116, 'Asep Supriatna, S.Sos, M.Si', '197101051998031004/123637', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(117, 'Carno', '197808222007011012/166041', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(118, 'Festarini, S. Pd', '197207161999012001/126454', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(119, 'Tri Widiarto Wismo', '197107162007011017/168679', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(120, 'Reflizarti, SE, MM', '196201011993032007/126180', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(121, 'Waluyo Santoso', '197001062007011023/166111', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(122, 'Dhona Susanty', '197708232008012017/170036', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Pusat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(123, 'Drs. H. Aji Antoko', '196512091993031006/126224', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(124, 'Rosihan Arsyad, S.Sos, M.Si', '197103011998031004/124508', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(125, 'Mindaryati', '197204142007012021/168209', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(126, 'Chandra Puspa Pamungkas', '198109212007011008/168740', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(127, 'Purwanto', '196103251984031003/126316', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(128, 'Handi Novianto', '198201262008011015/170020', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(129, 'Widia Rusiana, SE', '196207231983032007/125966', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(130, 'Ester Lumban Tobing', '196203071990032001/126475', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(131, 'Kiryanto', '197706082008011023/170022', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(132, 'Gamaluddin, SE, M.Si', '196504131992031012/125960', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(133, 'Trelling Hutabarat', '196510301988022002/126243', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(134, 'Rita Marleine BR. Panjaitan', '196103051982022003/126864', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(135, 'Mochamad Yusuf, S.Sos', '198106152010011034/177695', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(136, 'Melda Yunita Sagala, SE', '197905302011012005/181617', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(137, 'Arfiah', '196010151981052001/126074', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(138, 'Marspel, S.Sos', '196111261985081001/103612', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(139, 'Zaenuri', '196507092007011021/168628', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(140, 'Wahyudi, SH, M.Si', '196304051988011001/126959', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(141, 'Dewi Mardiyati', '196803211991032005/126494', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(142, 'Drs. Putu Suryawan Putrasena', '196511271994031002/126317', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(143, 'Agus Susanto Mamunto', '197512282008011012/170033', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(144, 'Irwan Tony', '196508111992031004/126010', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(145, 'Maria Imaculata Dacosta', '196012101983032010/126305', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(146, 'Maria April Astuti AT, S.Sos, M.Si', '196204071983022003/126381', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(147, 'Imam Ma\'shum', '197905192007011012/168674', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(148, 'Joko Basuki', '197903062008011029/170032', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(149, 'Anna Nufika', '197707012006042027/165278', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(150, 'Afrizon', '196108171984031006/125934', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Utara', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(151, 'H. Surya. A, SE. M.Si', '196205141986031008/126418', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(152, 'Sutawijaya, S.Sos, M.Si', '196705301989021002/112139', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(153, 'Yuni Purwaningsih, S.Sos', '197406111994032003/118097', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(154, 'Suhari', '197407132007011017/167198', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(155, 'Dedi Budi Raharjo', '197203302007011014/168238', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(156, 'Hadi Purnomo', '197003222007011014/167104', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(157, 'Sukarman', '196904111989021001/125946', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(158, 'Yudi Susanto', '197004081993031006/125984', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(159, 'Raden Iwan Sosiawan', '196605072007011041/166078', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(160, 'Edi Rosadi', '196804282007011026/166420', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(161, 'Warnita', '196505101989031017/112423', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(162, 'Fatmawati, AKS, M.Si', '196705161989032005/112451', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(163, 'Sudarminingsih', '196601311987032005/126281', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(164, 'Markaban', '196211091990031005/125950', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(165, 'Lukman', '196308121986121001/108932', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(166, 'Ridwan, AKS', '196608081990031005/126310', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(167, 'Johan Wahyudi', '197707122007011019/166051', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(168, 'Andjar Eman Sukisno, ST', '196807191990031008/126960', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(169, 'Aripin', '196705042007011051/168223', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(170, 'Drs. Antoni Jenner Tarigan', '196011191989031006/126193', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(171, 'Suwarso', '196405262007011012/166066', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(172, 'Muarif, S.Sos', '196511081986121002/108930', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(173, 'Asep Syahrial, S.Sos', '196905051997031005/122459', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(174, 'Ferry Hermawan', '197202182007011023/166072', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(175, 'Lasma Lusiana Pasaribu, M.Si', '196711031992032002/126286', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(176, 'Muhammad Ali', '196108171983031036/125864', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(177, 'R. Heru Prastowo', '196212261989031006/125920', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(178, 'Supriyadi, S.Sos', '196506071990081001/114502', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(179, 'Agus Romansyah', '197902212007011004/168697', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Barat', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(180, 'Mursidin, AKS, M.Si', '196410121987111001/125949', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(181, 'Hj. Nasriwati, SH', '196302021990032003/126219', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(182, 'Suwarsih', '197905152007012027/166047', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(183, 'Dainel Rusdi, SE', '198008032007011006/166106', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58');
INSERT INTO `tbl_anggota` (`id`, `nama`, `identitas`, `jk`, `tmp_lahir`, `tgl_lahir`, `status`, `agama`, `departement`, `pekerjaan`, `alamat`, `kota`, `notelp`, `tgl_daftar`, `jabatan_id`, `aktif`, `pass_word`, `file_pic`, `created_date`) VALUES
(184, 'Purwariningsih ', '196403051991032006/126383', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(185, 'Eva Pebruariyatno', '197702182007011009/166428', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(186, 'Ansori, S.Sos, M.Si', '196505141989031005/112701', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(187, 'Gunawan', '196105311989031004/126957', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(188, 'Nasrah Ridawaty', '196209061992032002/126115', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(189, 'Aty Susmiati', '196108071986032005/126204', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(190, 'Sobirun', '196508291989031004/112814', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(191, 'Sarono', '196304061988031004/126869', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(192, 'Dra. Susiana, M.Si', '196709021994032008/126923', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(193, 'Husin Bawafi', '197503032007011026/167133', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(194, 'RA. Sekartadji', '197303312007011012/166054', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(195, 'Rosadelima Saragih', '196108171983032014/126389', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(196, 'Duriah Tulaliah, S.Sos', '196910051989032003/125918', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(197, 'Suyati', '197004141996032003/119528', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(198, 'Hatmini,  AKS', '196209221984032002/126110', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(199, 'Syafnirwan', '197207112007011019/167378', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(200, 'Sumadi, SST', '196810251989031003/112812', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(201, 'Aris Susilo Hadi', '196508051990031009/126495', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(202, 'Iwan Samsuar', '197509302007011015/166059', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(203, 'Titin Sumarni, S.Sos', '196506101988012003/126003', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(204, 'Bambang Susilo', '196807171990031007/126465', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(205, 'Dalmaji, S.Sos', '196308191989021001/112155', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(206, 'Elan Bahruroji', '197509042007011019/167253', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(207, 'Dra. Farah Darojati', '196012061989032003/126101', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(208, 'Sri Mulyati', '197401292007012016/167252', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(209, 'Suprapto Widodo, AKS', '196608261989021001/112199', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(210, 'Maimunah', '196303051986032005/126048', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(211, 'Khoeriyah', '196408031989022002/112212', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', ' Sudin Sosial Kota Administrasi Jakarta Selatan', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(212, 'Benny Martha A, S.Sos, MM', '196703171994031009/126341', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(213, 'Dra. Utari, M.Si', '196804061993032004/125929', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(214, 'Herwi Murtiningsih', '197107201993102001/126165', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(215, 'Kirwo', '197406272007011015/168252', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(216, 'Umiyati ', '196212241985032007/126249', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(217, 'Padoli', '197712082007011014/167270', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(218, 'Angela Fransisca, S.Sos', '198004282010012018/177910', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(219, 'Dadang Setya Pamuji', '196902131990101001/126160', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(220, 'Haryanto, SH, M.Si', '196411111987101001/110348', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(221, 'Anang', '197404142007011035/168212', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(222, 'Didik Kadaryanto', '197306242008011014/170005', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(223, 'M. Maskuri', '198001282008011015/171092', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(224, 'Asep Abdullah', '197011212007011021/168241', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(225, 'Abdul Haris Maruapey', '196206151992031006/126360', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(226, 'Edi Soma, S.Sos', '196604151996031003/119569', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(227, 'Abdul Salam, S.ST, M.Si', '196709041991031007/126361', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(228, 'Suci Oktavianti, A.Md', '198601012011012040/181801', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(229, 'Rahayu Retno Herwati', '196108121981032002/126045', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(230, 'Juhana', '196405061989021006/112589', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(231, 'Sugiarto', '196006251992011001/116321', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(232, 'Rika Budiyati', '196811081988032004/125914', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(233, 'Suhitarini Soemarto Putri, S.Kom', '196910031996032004/119932', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(234, 'Sumihar Silitonga', '19620615198603005/126319', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(235, 'Rukiyah Hutapea, SH, M.HUM', '196103021995012001/126480', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(236, 'Ida Damayanti', '198009182007012016/168274', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(237, 'Hj. Sohrah, S.Sos', '196212211985032009/126474', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(238, 'Jumhur', '197504192007011013/166092', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(239, 'Dra. Priska Damanik, M.Si', '196502201994032002/126374', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(240, 'Tatang Sutriana', '196508212008011006/170038', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(241, 'Israk, SH, M.H', '196612011994031009/126482', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(242, 'Welas Asih', '197107032007012030/166090', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(243, 'Munawaroh, S.Sos, M.Si', '196808281989022001/112158', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(244, 'Supriyadi', '197412242007011013/168217', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(245, 'Wanson Togar Sinaga, AKS', '196009281986031007/126326', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(246, 'M. Oka', '197702052007011020/168255', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(247, 'Susi Nurmaida Simanungkalit, S.Pd', '196804101989032006/126236', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(248, 'Saimin', '197705072007011029/167373', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(249, 'Dorti Rumintang, SH', '196304051990032005/126059', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(250, 'Ertiani Manurung', '197307272007012022/168250', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(251, 'Dra. Jubaedah', '196204011994032001/126429', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(252, 'Siti Aisyah', '196506101988122004/126014', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(253, 'Dini Anisah Mei, S.S', '197805072014122000', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'Sudin Sosial Kota Administrasi Jakarta Timur', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(254, 'Ahmad Juhandi, S. Ag', '197109131997031004/121782', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(255, 'Drs. Mujianto', '196208061985031007/87203', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(256, 'Mochammad Sana, S. Sos', '196305141986121001/108941', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(257, 'Tambah Suhadi, S. Sos, M. Si', '196309131989021002/112188', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(258, 'Eko Budi Riyanto, S. AP', '196910131991031004', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(259, 'Drs. Masroni', '196208261992031001/164277', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(260, 'Hj. Nur Komariyah, SH', '196308111985032005', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(261, 'Drs. Setia Rahmadi', '196110191993031004', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(262, 'Muh. Tahir, SP', '197110211998031005/123738', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(263, 'Saeful Nasri', '196106051992011001', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(264, 'Suningsih', '196407101986121002', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(265, 'Een Nuraeni', '196202271983022001', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '224bec3dd08832bc6a69873f15a50df406045f40', '', '2020-11-18 20:21:58'),
(266, 'Dindin Hary Apriyadi, M. Si', '197604182009121003/189929', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(267, 'Andayani, S. Sos. I', '198209302011011009/181267', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(268, 'Muhamad Nursawiji', '196503121997031004/121942', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(269, 'Tutut Widayati', '197204011997032003/121848', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(270, 'Ahmad Rivai', '197808282007011023/167134', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(271, 'Jaya Saputra', '197107092007011024/168263', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(272, 'Junta Sasmican', '197505312007011009/168243', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(273, 'Mulyadi', '197910122007011008/168657', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(274, 'Kiryadi', '197502012007011015/167395', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', ' Sekretariat Pusat Pengkajian dan Pengembangan Islam Jakarta', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(275, 'Vivi Kafilatul Jannah', '196605141992022001/126293', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(276, 'Siti Murtofingah, S.AP', '196706121989072001/113229', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(277, 'Elvanora, S.Sos', '196109171984032005/126257', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(278, 'Sri Mulyani.  S', '196508201986032009/126435', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(279, 'Sugiyono', '197707082007011017/166430', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(280, 'Singgih Suharso, S.Sos', '197605262007011016/166432', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(281, 'Wasri', '197808182007012016/166084', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(282, 'Nurli Tinambunan', '196911302007012016/168331', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(283, 'Harmani Riza, S.Sos', '196605061986032006/163494', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(284, 'Ponirah, S.Sos', '196007051993032003/126125', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(285, 'Dana Dewi Sipahutar', '197402021993032003/126402', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(286, 'Milikiyana Mahera', '198105182007012010/168189', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(287, 'Tasirin', '196812102007011044/166045', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(288, 'Mukinah', '196506102007012021/168258', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(289, 'Mia Rumsari, SH', '197008041999022001/126460', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(290, 'Fitri Yulianti', '198207202007012009/167396', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(291, 'Christina Saptarini', '197112102007012020/167064', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(292, 'Indah Susi Asmani', '196801042007011035/166067', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(293, 'Nur Azizah, S.K.M', '197706172007012019/168629', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(294, 'Ubaidilah', '196506221996031002/119781', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(295, 'Sugiyatni', '196309101985032008/126425', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(296, 'Hj. Ida Suryanti, S.E', '196105251982122001/077351', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(297, 'Riska Setiani', '198110042008012028/174641', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(298, 'Ilah', '197409092007012024/167202', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(299, 'Emasari', '196503161991112001/126095', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', ' PSAA Balita Tunas Bangsa ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(300, 'Dra. Marwianti', '196212271983022003/126349', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(301, 'Diah Hidayah Purnomowati,M.Si', '196509121992012001/126375', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(302, 'Sri Sumarti', '196306101989022002/112110', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(303, 'Murtini', '197207251992032003/126248', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(304, 'Suradi', '196605142007011030/168206', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(305, 'Agus Sasmita', '196910122007011030/167182', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(306, 'Lestriyani', '197804242007012019/168739', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(307, 'Endang Rusmiyati, S.Sos', '196103181990082001/114516', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(308, 'Suryana', '196105031986121001/108947', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(309, 'Hendro Sugiharto, S.ST', '197204091994031006/125935', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(310, 'Surini', '196908162007012029/167181', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(311, 'Tugiyanto', '196209171992031003/126308', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(312, 'Afniati', '196304161984102002/083817', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(313, 'Sumaryati', '196604111985092001/101156', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(314, 'Lis Barlianti, AKS', '196408191986032008/126212', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(315, 'Agus Nursalim', '197108031996031002/119323', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(316, 'Suhanis Trisunu', '197511262008011016/170566', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(317, 'Sukarti', '196305051985032009/126198', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(318, 'Suryadi HR', '196403021991031009/115368', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(319, 'Dra. Ira Mariyati, M.Si', '196611111989032008/112449', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(320, 'Sariman', '197508102007011033/168727', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(321, 'Marsinta Saragih', '196109101981103202/126358', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(322, 'Hasanudin', '198005162008011012/170024', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(323, 'Heru Sapto Gutomo', '196706202007011032', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(324, 'R. Iyah Juhaeriyah', 'SEMENTARA-007', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(325, 'Rosmawati', '196608051989032006/126315', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSAA Putra Utama 1 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(326, 'Dra. Maria Rosanna BR, M.Si', '196608051994032003/126151', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSAA Putra Utama 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(327, 'Agus Siswadi, S.Sos', '196206161988101002/126490', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSAA Putra Utama 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(328, 'Istanto', '197511272008011010/170029', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSAA Putra Utama 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(329, 'Euis Komariah', '197207232007012016/168704', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSAA Putra Utama 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(330, 'Edi Supardi', '198103082008011015/170025', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSAA Putra Utama 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(331, 'Anung Purwanti', '196006131983022001/126344', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSAA Putra Utama 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(332, 'Retno Widyanti', '196310081994082001/126440', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSAA Putra Utama 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(333, 'Sudimah', '196904052007012035/166082', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSAA Putra Utama 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(334, 'Moch. Nazar', '197508302008011017/171343', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSAA Putra Utama 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(335, 'Dede Djuariah', '196812192007012012/168631', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSAA Putra Utama 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(336, 'Mardelina Simanjuntak', '196211091984032007/125955', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSAA Putra Utama 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(337, 'Dra. Hj. Rd. Ucu Rahayu L, MM', '196806141993032008/126443', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(338, 'Dra. Wiwik Widiyati, M.Si', '196009221981032005/123205', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(339, 'Sri Andaryati', '197205112007012018/167108', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(340, 'Sulasmi', '196404271989072003/113219', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(341, 'Gusfarianty', '197808072007012025/168453', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(342, 'Saodah', '196810241989032004/125924', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(343, 'Al Jupri, SH, MH', '196106091986121002/108943', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(344, 'Reni Kuat Tiah', '197707022007012012/167203', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(345, 'Muhammad Rokib', '196709082007011036/168700', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(346, 'Yusup', '197407042007011024/166043', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(347, 'Devi Ayutya Wardhani, S.Psi', '198009042010012018/197932', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(348, 'Sopan Sofyan', '196108181989101002/113640', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(349, 'Budiarso', '197110062007011018/168695', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(350, 'Sukarno', '196107121981031004/126131', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(351, 'Enden Mulyaningsih, S.Sos', '196005211982032005/126058', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(352, 'Gura Susana Waittalong, S. Sos', '197812272010012016/177915', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(353, 'Salamun Maryadi, S.ST', '196705271989031005/112815', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(354, 'Hery Bertus Sutriyono', '196606272008011002/170045', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(355, 'Ningrum Kusumah', '197612252007012024/167205', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(356, 'Isnaini', '196010071980031002/067807', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(357, 'Khomsiatun, S.Sos', '196703051989022003/112147', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(358, 'Toya Romdoni', '197410162014081003/188550', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(359, 'Muhammad Hatip', '196803262008011005/1753440', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(360, 'Tugiyem', '196205102007012007/167132', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(361, 'Husin', '196201261988031003/126240', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', ' PSAA Putra Utama 3 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(362, 'Dikki Syarfin, S.Sos, MM', '196612101987081000', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(363, 'Hj. Ida Farida, SH', '196502081992022001/126041', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(364, 'Djaenuddin', '196406151989031007/112813', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(365, 'Yosep Setiawan', '198109262007011006/168671', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(366, 'Chaidir', '196912232007011019/166062', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(367, 'Efi Jamilah', '196806151992012001/125936', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(368, 'Indra Seno Aji', '198611122015041002/185440', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58');
INSERT INTO `tbl_anggota` (`id`, `nama`, `identitas`, `jk`, `tmp_lahir`, `tgl_lahir`, `status`, `agama`, `departement`, `pekerjaan`, `alamat`, `kota`, `notelp`, `tgl_daftar`, `jabatan_id`, `aktif`, `pass_word`, `file_pic`, `created_date`) VALUES
(369, 'Nurhayati', '198203162008012015/175408', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(370, 'Sri Subowati', '196005021984032005/126391', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(371, 'Dayat', '197304072007011017/168725', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(372, 'Herliyanti, S.Sos', '197010101996032002/119859', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(373, 'Sudarno', '198303052007011002/168630', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(374, 'Saepul Bahri', '198303192008011006/170035', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(375, 'Yusri Yani', '196807162007012026/168678', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(376, 'Nanik Marheni', '197204082007012023/168733', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(377, 'Ari Harsono K', '197701252007011009/166488', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(378, 'Warsito', '197811052007011018/167185', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', ' PSAA Putra Utama 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(379, 'H. Masyudi, S.ST, M.Si', '196602021989021002/112130', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(380, 'Dra. Rinawati, M.Si', '196311011987032007/126329', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(381, 'Diah Saptorini, S. AP', '196507171989022002/125968', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(382, 'Saodah', '196409241988102001/126356', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(383, 'Tono', '196711152007011023/166429', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(384, 'Sandi Hermanto', '198303212008011008/170040', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(385, 'Sarnubi Said', '197701212007011015/166525', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(386, 'Tasman Ariyanto', '196704242007011030/168670', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(387, 'Riduan', '196603121997031001/121325', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(388, 'Robi Abdul Rohim', '196403101986031016/126128', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(389, 'Pairah', '196609181994032005/125933', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(390, 'Akhmad Tarmiizi', '196807131989021001/112143', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(391, 'Sukarman', '196103221983031003/126929', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(392, 'Lala Komala Sari', '198006252007012011/166064', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(393, 'Hotman Naibaho, SE', '196512131993031005/126135', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(394, 'Eva Susanti Ikraman', '198007082007012013/166427', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(395, 'Sukiman', '197207082007011028/168683', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(396, 'Marwati', '197008302007012026/168699', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(397, 'Untung Triyono, S.AP', '196601112007011017/167196', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(398, 'Lina Hasanah', '198102072007012016/168224', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(399, 'Riswanto', '197204022007011031/166437', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(400, 'Abdul Hakim', '197408062007011020/168221', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(401, 'Sri Wahyuni', '196601101987032009/126012', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(402, 'Syaiman, AKS, M.Si', '196206051983021002/126106', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(403, 'Toniroh, SH, M.Si', '196406231999012001/126258', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(404, 'Eno Karseno', '1977022020070110117/168736', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(405, 'Oki Suprayawinata', '197610162007011014/168696', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(406, 'Warsiti', '196007151983032008/126385', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(407, 'Mohammad Yanuar Andriyanto', '197901242007011009/166490', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(408, 'T. Syahrul, SH', 'SEMENTARA-006', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(409, 'Yosfin Rimba  ', '196112201988032006/126330', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(410, 'Elly Murniasih', '197901172008012018/170037', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(411, 'Siti Handayani', '196404191993032003/126265', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(412, 'Samsudin', '19670512/169988', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(413, 'Tiolan Siti Latifah. S', '197712222007012022/168211', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(414, 'Farida Novianty, SH', '196911261998032004/126459', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(415, 'Winarti', '198312242007012006/168682', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(416, 'Kamiludin', '196502032007011032/166955', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(417, 'Iyus', '196703102007011037/168256', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(418, 'Supriyono', '196407171989021001/112123', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(419, 'Awaludin', '197207131994031009/126472', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(420, 'Diana siahaan', '196206111987032005/126093', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(421, 'Syaefudin', '197411092007011015/166470', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSBI Bangun Daya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(422, 'Drs. Irpan Jauhari, M.Si', '197007031990031002/165075', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSBL Harapan Sentosa 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(423, 'Dra. Hj. Arlina Meyrani', '196705051995012001/126500', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSBL Harapan Sentosa 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(424, 'Ati Kartini, S.Pd', '197312012007012017/168633', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSBL Harapan Sentosa 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(425, 'Asih Sudarmika', '196104251989032001/126214', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSBL Harapan Sentosa 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(426, 'Eryanti', '197808202007012019/166050', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSBL Harapan Sentosa 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(427, 'Siti Maslahat', '197801202008012021/170019', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSBL Harapan Sentosa 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(428, 'Haryono', '19770504200801125/170026', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSBL Harapan Sentosa 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(429, 'Puji Lestari', '198503202008012011/170003', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSBL Harapan Sentosa 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(430, 'Sumarno', '197003052007011030/166088', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSBL Harapan Sentosa 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(431, 'Dra. Misliati', '196711161989022002/112144', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSBL Harapan Sentosa 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(432, 'Tri Setianingsih', '198102272007012012/168275', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSBL Harapan Sentosa 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(433, 'Yayah', '196410052007012017/168295', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSBL Harapan Sentosa 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(434, 'Kemiran', '196909292007011033/166107', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSBL Harapan Sentosa 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(435, 'Purwani', '197003152007012028/166100', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSBL Harapan Sentosa 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(436, 'Yuni Eko Purwanto', '197206092007011026/168737', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSBL Harapan Sentosa 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(437, 'Dra. Tuti Sulistyaningsih, M.Si', '196311051989032001/126112', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(438, 'Siti Djulaeha, S.Sos, M.Si', '197009011996032003/126283', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(439, 'Sarimin', '196912101989031006/112808', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(440, 'I. Wayan Suwija', '197703042007011015/167068', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(441, 'Titin Sumarni', '197407231996032002/120059', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(442, 'Suranto', '196905101996031003/119459', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(443, 'Zumaroh', '197408012007012019/166083', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSBI Bangun Daya 1', 'PNS', 'Jakarta Selatan', 'Jakarta', '091280427672', '2000-01-01', 1, 'Y', '224bec3dd08832bc6a69873f15a50df406045f40', '5fa99e537a278.png', '2020-11-18 20:21:58'),
(444, 'Yasinta Restuning Ayu, S.Psi', '198412282011012012/181275', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(445, 'Ruminah, S.Pd', '196310081987032005/126092', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(446, 'Rusman', '198007252007011011/168222', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(447, 'Fajar Kasniyanti', '197012182007012012/168208', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(448, 'Inah Triyana', '196603072007012014/167066', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(449, 'Yanto', '196204232007011006/167225', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(450, 'Benny Mahmudin', '196007011983031006/126274', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(451, 'Surani, S.Sos', '196102211986032004/125989', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(452, 'Rianto Gultom, S.KM', '197807242007011013/168460', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(453, 'Mindra Setiawan', '197203212007011021/167078', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(454, 'Marni', '196911092007012025/168259', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(455, 'Syafrudin Alamsyah', '196812172007011017/167371', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(456, 'Sri Marsiyanti', '196211211986032006/126090', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(457, 'Siti Djenar', '197001231997032002/121592', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(458, 'Nurlaela, AKS', '196207251984032009/126149', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(459, 'Ida Nawangsih', '197204192007012011/168681', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(460, 'Lili Supriatmono', '196204072007011013/166954', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(461, 'Sriyanta', '196508181987101001/110347', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(462, 'Kasirun', '196408072007011017/168205', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(463, 'Ngatini, S.Pd, M.Si', '196008101985032010/126448', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(464, 'Teguh Hardiyono', '197911122007011011/167096', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(465, 'Dodih', '196609162007011018/168442', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(466, 'Buntaran', '196010152006041018/168851', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(467, 'Dra. Ika Hendarti', '196105111990032002/126867', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(468, 'Siti Mulyaningsih', '197808082007012033/168634', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(469, 'Badriyah Husin', '196409061989032004/086013', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(470, 'Ahi Hasanudin', '197607212007011010/168254', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(471, 'Maristela Lisdina Leli', '196512071989012001/131758', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSBL Harapan Sentosa 2 ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(472, 'Sarima, SH, M.Si', '196302241992032002/126194', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(473, 'Dra. Hj. Nurlaela', '196710101993032012/117434', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(474, 'Ahmad Taif, A.Md', '198109292011011009/181486', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(475, 'A. Mardiyana', '198503192008011004/171179', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(476, 'Irawati Purba', '196904052007012036/166096', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(477, 'Satiyem', '198012312008012048/170564', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(478, 'Dorman Sitio', '198307122008011012/174692', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(479, 'Gunawan Sukaton', '197804302008011015/170039', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(480, 'Rundiyani', '197009072007012033/166487', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(481, 'Drs. Saebun, M.Si', '196302151988031010/126408', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(482, 'Sita Kusuma Wardani', '198708202011012020/181279', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(483, 'Malik Margono', '198201142007011006/167126', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(484, 'Corry, S.Sos', '197910132010012011', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(485, 'Muh. Asrori', '197507112007011017/167136', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(486, 'Budiman Aratimbul S', '197702012007011000', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(487, 'Wasim', '19760742007011023/166332', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(488, 'Sukarmi', '196705142007012028/166105', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSBL Harapan Sentosa 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(489, 'Drs. H. Akmal T, M.Si', '196111051988031006/126321', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(490, 'Siti Komaryiah, S.Sos', '196401191985032007/086905', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(491, 'Basuki', '196303311987011001/108838', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(492, 'Suparna', '196506071988031006/126496', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(493, 'Prihatin Endang Warini', '196507271992032008/126364', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(494, 'Yuyun Wahyuni, S.Sos', '197112111997032002/121638', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(495, 'Tri Wahyuni, S.AP', '197312311993012003/126260', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(496, 'Suyono', '197710122007011013/167269', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(497, 'Teguh Winardi', '196812292014081002/188549', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(498, 'Aas Prastianti', '197810022007012009/167224', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(499, 'Turmini', '196808182007012047/168742', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(500, 'Dra. Dyan Windanarum G', '196311171989012001/126302', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(501, 'Sukapti, S.Sos', '196503131990062001/114403', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(502, 'Mujiono, AKS', '196506211989031006/112702', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(503, 'Halimatussakdiyah', '196701011991032012/126138', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(504, 'Pariyem', '197210152007012015/168260', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(505, 'Nurleni', '197902192007012016/167266', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(506, 'Mangiring Purba', '196507141993032007/126971', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(507, 'Siti Fatonah', '196912111990082002/114517', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(508, 'Marintan Tambunan, SE', '196112101985032006/103605', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(509, 'Musliha Syafei', '197910022007012013/167135', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(510, 'Tutik Lestari', '197905062007012018/168291', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '224bec3dd08832bc6a69873f15a50df406045f40', '', '2020-11-18 20:21:58'),
(511, 'Etty Rahmawati', '197903102007012019/166081', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(512, 'Suhar', '196801131989031004/112806', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(513, 'Mujiono (I/A)', '196509072007011028/168487', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(514, 'Tri Handayani, SH', '197205122006042025/165240', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(515, 'Samatrin', '197203172007011028/166042', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(516, 'Een Kurnaeni', '197105092007120117/166101', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(517, 'Endang Winarsih', '196206051983022002/126347', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(518, 'Ummi kalsum', '196710272008012011/170563', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(519, 'Mudjiati', '196405051986032020/126084', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSTW Budi Mulia 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(520, 'Ruddy Muchtar, S.Sos', '196311171985011001/084400', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(521, 'Sahril Musrori', '197802272007011008/166076', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(522, 'Hapas', '196112031987031004/109281', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(523, 'Mohamad Nasir', '197705252007011026/167183', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(524, 'Sutarmi', '197407202007012029/167197', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(525, 'Suharjo', '197302112007011014/166053', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(526, 'Hartati, S.ST', '197212221997032005/121637', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(527, 'Sri Utami, S.Pd. M. Si', '197303131997032003/121634', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(528, 'Slamet Riyadi', '197108282007011031/166110', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(529, 'Rasini', '197707182007012020/166094', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(530, 'Dra. Setyaningsih', '196710192006042007/165283', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(531, 'Joko Wasisto', '197903022007011018/168332', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(532, 'Surnilah', '196307111985032006/126978', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(533, 'Wagimin', '196205252007011009/167067', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(534, 'Pairan', '197806032007011017/167372', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(535, 'Drs. Iman Jaya', '196312201990031005/126287', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(536, 'Muslim, S.Pd.I', '196402201990081001/114551', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(537, 'Wiwin Hendayani', '197104242007012025/166431', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(538, 'Rasko', '197512062008011014/170034', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(539, 'Sri Tati Yulianti, S.Sos', '196203191992122001/125895', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(540, 'Sumintra', '197010122007011030/167161', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(541, 'Sutarti', '197903192007012015/169215', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSTW Budi Mulia 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(542, 'Drs. Marjito, M.Si', 'SEMENTARA-005', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(543, 'Budi Hastuti, S.Sos, M.Si', '196612191989022001/112134', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(544, 'Dandi Januarizko, S.Sos', '198501142010011017/100020', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(545, 'Larmi Istiati', '196409061989032004/112432', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(546, 'Masuroh', '197305202007012024/168219', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(547, 'Yanti Astuti', '196301091988032006/126962', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(548, 'Banon Krisyuniarti', '196706241989022001/112268', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(549, 'Wahyudi', 'SEMENTARA-004', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(550, 'Elisabeth Wjiati Utami, AKS', '197202131993132002/126145', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(551, 'Yuanita Bakar, SH', '196104281988112001/126176', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(552, 'Retno Wahyuni', 'SEMENTARA-003', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(553, 'Sofiawati', '196410191987032003/126955', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(554, 'Tarmuzi', '196610181989031007/112118', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(555, 'Yunur Nawangsih, S.KEP', '196805091990032005/123288', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(556, 'Winarni', '196912262007012017/168669', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(557, 'Sri Asih Kartika', '196812041989022001/112146', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(558, 'D. Yushardi', '196404201987031006/126311', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(559, 'Wahyuni', '196902152007012044/167165', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(560, 'Ronteta Ridarni Kurniati, S.ST', '196711021990032002/125932', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(561, 'Tasmin', '197304162007011018/166485', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSTW Budi Mulia 3', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(562, 'R. Yanti Affiyanti, S.Sos, M.Si', '196909231998032008/124563', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', ' PSTW Budi Mulia 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(563, 'H. Ruminto, AKS, MM', '196212141989031116/112427', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', ' PSTW Budi Mulia 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(564, 'Sanadi', '197809112007011018/166419', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', ' PSTW Budi Mulia 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(565, 'Sri Ramadhani Asda, A.Md', '198605182011012020/181755', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', ' PSTW Budi Mulia 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(566, 'Rudi Cahyadi', '197607212007011011/167186', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', ' PSTW Budi Mulia 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58');
INSERT INTO `tbl_anggota` (`id`, `nama`, `identitas`, `jk`, `tmp_lahir`, `tgl_lahir`, `status`, `agama`, `departement`, `pekerjaan`, `alamat`, `kota`, `notelp`, `tgl_daftar`, `jabatan_id`, `aktif`, `pass_word`, `file_pic`, `created_date`) VALUES
(567, 'Saurevi Januar Nababan', '196306201988032002/125952', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', ' PSTW Budi Mulia 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(568, 'Taufik', '197107022007011020/168707', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', ' PSTW Budi Mulia 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(569, 'Udin', '197509122007011025/167262', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', ' PSTW Budi Mulia 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(570, 'Sri Wahyuni, S.Sos, M.Si', '196504251995032001/118669', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', ' PSTW Budi Mulia 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(571, 'Rimson Lumban Gaol, SE', '196409201993031005/126487', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', ' PSTW Budi Mulia 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(572, 'Edi Wahyudi', '197104281993011001/126024', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', ' PSTW Budi Mulia 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(573, 'Eti Hastuti Nengsih', '196408162007012016/166085', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', ' PSTW Budi Mulia 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(574, 'Agus Handaka ', '196908011991031004/125947', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', ' PSTW Budi Mulia 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(575, 'Sugino', '196606241989101001/113641', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', ' PSTW Budi Mulia 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(576, 'Eros Roslina', '196007111985032006/125959', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', ' PSTW Budi Mulia 4', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(577, 'Prayitno, AKS', '196604051989021003/112120', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(578, 'H. Abdul Khair, S.Ag, M.Si', '196804241998031008/124308', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(579, 'Nina Rostina', '197807212007012009/166065', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(580, 'Jumar ', '196602061990031005/126085', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(581, 'Juliah', '197407142007012033/168253', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(582, 'Nasripulloh', '197901022007011014/168273', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(583, 'Igustinah, SAP', 'SEMENTARA-002', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(584, 'Gusmeli', '196108211990102001/126466', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(585, 'Umi Hannie', '198108302008012013/170004', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(586, 'Lili Ali', '196711092007011032/166109', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(587, 'Mudalifah', '196310101989032006/126378', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(588, 'Wardinah ', '196702051994031007/125986', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(589, 'Emy Widiastuti', '197108262007012013/166048', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(590, 'Atin Mulyana', '198105282007011010/168701', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(591, 'Gurnita', '196909122007011026/168207', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(592, 'Tuntas Andri', '198003272007011008/168676', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(593, 'Zaenab Kotta, S.Sos', '196509021987112001/126380', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(594, 'Emayati, SE, M.Si', '196904111996000222/122298', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(595, 'Jumiati', '198007212008012027/174642', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(596, 'Yustina Yuni Setyowati', '196006281992022001/125912', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(597, 'Supriyatni', '196410051985032004/087432', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSBD Budi Bhakti ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(598, 'Ngapuli Perangin Angin, AKS, M.Si', '196603221989031002/126393', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSBG Belaian Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(599, 'Rita Wigira Astuti, AKS', '196312041986032010/126105', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSBG Belaian Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(600, 'Arnah', '196405121989032006/112817', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSBG Belaian Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(601, 'Legimin', '196511301989031002/112807', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSBG Belaian Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(602, 'Saepudin', '198404282007011005/167398', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSBG Belaian Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(603, 'Jariyah', '197208032007012017/166491', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSBG Belaian Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(604, 'Masyhuri', '196312232007011014/167110', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSBG Belaian Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(605, 'Tumiran, S.AP', '196902071996031002/119320', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSBG Belaian Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(606, 'Suryani 1969', '196912141990032003/125900', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSBG Belaian Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(607, 'Ade Supriyanto', '197908072007011016/166089', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSBG Belaian Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(608, 'Suhartati', '197611242007012018/167200', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSBG Belaian Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(609, 'Mohammad Dasir, S.Sos', '196307152007011026/168286', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSBG Belaian Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(610, 'Poltak Marudut Munthe', '196710121990031012/126468', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSBG Belaian Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(611, 'Daryono', '197905052007011020/168239', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSBG Belaian Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(612, 'Asep Jaya Aceng', '197802042007011022/166071', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSBG Belaian Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(613, 'Sugiarto', 'SEMENTARA-001', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSBG Belaian Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(614, 'Saifudin, AKS', '196707261989021001/112116', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSBK Harapan Jaya ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(615, 'Yasozatulo Gea', '197201282007011014/166095', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSBK Harapan Jaya ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(616, 'Joharmin, S.AP', '196408051991021001/125958', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSBK Harapan Jaya ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(617, 'Rustam Herlambang', '197806242007011012/166108', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSBK Harapan Jaya ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(618, 'Margono', '196503131998031005/126143', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSBK Harapan Jaya ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(619, 'Maulana Yusuf', '197706152007011029/167245', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSBK Harapan Jaya ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(620, 'Juli Rindu, AKS', '196407251985031007/125987', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSBK Harapan Jaya ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(621, 'Hidayat', '196206151987031011/110076', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSBK Harapan Jaya ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(622, 'Bakri', '196711092008011008/170009', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSBK Harapan Jaya ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(623, 'Arif Mukti', '197307222007011014/166056', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSBK Harapan Jaya ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(624, 'Mastur Hendry Abdul Malik, S.Pd.I', '196409051986121001/108962', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSBK Harapan Jaya ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(625, 'Susan Jamine Z', '197004031990012001/', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSBK Harapan Jaya ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(626, 'Asep Nurjaman', '197111242007011022/168230', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSBK Harapan Jaya ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(627, 'Syarifudin', '196211101985031008/070337', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSBK Harapan Jaya ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(628, 'Muhammad Rusdi', '196510112008011005/170030', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSBK Harapan Jaya ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(629, 'Abdul Holik', '197207092007011024/165792', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSBK Harapan Jaya ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(630, 'Dra. Etty Supriatin, M.Si', '196304111993032003/117393', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSBKW Harapan Mulia ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(631, 'Dini Dhyana, AKS, MM', '197401211998032004/126453', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSBKW Harapan Mulia ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(632, 'Jaka Priatna', '196604161989021001/112156', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSBKW Harapan Mulia ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(633, 'Budi Suryanto', '197603082007011014/168214', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSBKW Harapan Mulia ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(634, 'Narmiyati', '197807062007012026/167374', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSBKW Harapan Mulia ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(635, 'Hardjo Bin Djakaria', '196312111990031004/126276', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSBKW Harapan Mulia ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(636, 'Darsini', '197910052007012027/166333', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSBKW Harapan Mulia ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(637, 'Pasi Pasriani', '197705202007012023/167201', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSBKW Harapan Mulia ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(638, 'Nurlena', '196603271990032005/125944', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSBKW Harapan Mulia ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(639, 'Sri Mulyati', '197310122007012019/167914', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSBKW Harapan Mulia ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(640, 'Yatini', '196209011989032002/125994', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSBKW Harapan Mulia ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(641, 'Sunanti', '196904221997032003/119429', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSBKW Harapan Mulia ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(642, 'Ahmad Saidudin', '196606041989031011/113221', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSBKW Harapan Mulia ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(643, 'Yahya B', '196209031989031008/126941', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSBKW Harapan Mulia ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(644, 'Sri Widiastuti', '197002061998032005/126282', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSBKW Harapan Mulia ', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(645, 'Mukhlisin, SE, M.Ag', '197108081998031005/124453', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(646, 'Nilam Sari, SH. M.Si', '196910011997032006/165369', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(647, 'Sri Wahyuni', '196508271989072001/113348', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(648, 'Gusar Marsaulina Hutapea', '196810081992032006/126485', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(649, 'Erniyati', '196606221989032007/112426', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(650, 'Elisabeth Painem', '196709072007012020/166070', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(651, 'Yani Handaningsih', '198010112007012014/166079', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(652, 'Idup Suryana', '197919192007011012/167375', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(653, 'Suwarni, SH', '196203021990082001/126239', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(654, 'Susmiyati', '197910112007012014/166336', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(655, 'Siti Murwati', '197407071993032003/126390', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(656, 'M. Asruri', '196104051995011001/126035', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(657, 'Djaenawi', '196005141993031003/126277', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(658, 'Ratu Fatin Hamamah', '196612231991122001/', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(659, 'Tiurma Junita manalu', '196506221996032001/119780', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(660, 'Wasiya', '197011182007011011/167204', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(661, 'Suharti', '196106221989032002/126262', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(662, 'Heru Agus Priyantono', '196308141989031020/113349', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(663, 'Kohar Hanadi', '196101061983021002/126213', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'PSBNRW Cahaya Batin', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(664, 'Ahmad Dumyani, SE, MM', '196106011987031004/157394', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'PSBR Taruna Jaya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(665, 'Dra. Rita Winarti', '196701031999012001/126255', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'PSBR Taruna Jaya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(666, 'Husniati', '197203111993032006/126445', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'PSBR Taruna Jaya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(667, 'Zahrotun Nasiha, S.Pd', '198202162007012008/168294', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'PSBR Taruna Jaya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(668, 'Sutini', '197208102007012031/168287', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'PSBR Taruna Jaya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(669, 'Saadah, BA', '196702061994022001/126266', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'PSBR Taruna Jaya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(670, 'Anton', '197803122007011014/168698', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'PSBR Taruna Jaya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(671, 'Sugeng Musafak', '197512172007011013/168231', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'PSBR Taruna Jaya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(672, 'Irwan Santoso, SH', '196302281991031004/126120', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'PSBR Taruna Jaya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(673, 'Een Rohaeni, SH', '196709062007012025/168738', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'PSBR Taruna Jaya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(674, 'Yatinah', '197709152007012026/168218', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'PSBR Taruna Jaya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(675, 'Dirah', '196407031986032005/126002', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'PSBR Taruna Jaya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(676, 'Eko Andriyanto', '197909232014081001/188575', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'PSBR Taruna Jaya 1', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(677, 'Drs. Harjanto, MM', '196308301996031002/119761', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'Panti Sosial Perlindungan Bhakti Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(678, 'RR. Sri Widarwati, S.Sos', '196012011985112002/117697', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'Panti Sosial Perlindungan Bhakti Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(679, 'Mawarni', '197208232007012021/167377', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'Panti Sosial Perlindungan Bhakti Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(680, 'Siti Nurhayati', '198010062008012023/170021', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'Panti Sosial Perlindungan Bhakti Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(681, 'Tri Murti Komariah', '196204181985032002/088085', 'L', 'Indonesia', '1945-07-25', 'Kawin', 'islam', 'Panti Sosial Perlindungan Bhakti Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(682, 'Yasin', '196607062007011042/166099', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'Panti Sosial Perlindungan Bhakti Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(683, 'Suprianto', '197308172014081002/188547', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'Panti Sosial Perlindungan Bhakti Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(684, 'Dwi Atini, AKS, M.Si', '196012271985032006/123506', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'Panti Sosial Perlindungan Bhakti Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(685, 'Surtiningsih', '196303151983032008/126342', 'L', 'Indonesia', '1945-07-29', 'Kawin', 'islam', 'Panti Sosial Perlindungan Bhakti Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(686, 'Agustinus Sujatmiko', '196909302007011031/168732', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'Panti Sosial Perlindungan Bhakti Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(687, 'Entis sutisna', '197505022007011029/166103', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'Panti Sosial Perlindungan Bhakti Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(688, 'Edi Setiyanto', '196901062007011030/168796', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'Panti Sosial Perlindungan Bhakti Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(689, 'Dian eva yanti', '197308252007012010/168677', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'Panti Sosial Perlindungan Bhakti Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(690, 'Rietma Chrismadantie', '198405012010012032/180053', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'Panti Sosial Perlindungan Bhakti Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(691, 'Edi Sumarto', '196408182007011024/167223', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'Panti Sosial Perlindungan Bhakti Kasih', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(692, 'Yayat Duhayat, SH, M.Si', '196608261994031004/121723', 'L', 'Indonesia', '1945-07-22', 'Kawin', 'islam', 'Panti Sosial Bina Remaja Taruna Jaya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(693, 'Indra Subekti', '196403021994031004/125927', 'L', 'Indonesia', '1945-07-23', 'Kawin', 'islam', 'Panti Sosial Bina Remaja Taruna Jaya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(694, 'H. Ujang Supena', '196302091984121003/084064', 'L', 'Indonesia', '1945-07-24', 'Kawin', 'islam', 'Panti Sosial Bina Remaja Taruna Jaya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(695, 'Juliana, SE', '196307141992032003/125913', 'L', 'Indonesia', '1945-07-26', 'Kawin', 'islam', 'Panti Sosial Bina Remaja Taruna Jaya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(696, 'Maemunah', '196011201991032002/126097', 'L', 'Indonesia', '1945-07-27', 'Kawin', 'islam', 'Panti Sosial Bina Remaja Taruna Jaya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(697, 'Dra. Dermi Whiyati', '196206031988032005/126877', 'L', 'Indonesia', '1945-07-28', 'Kawin', 'islam', 'Panti Sosial Bina Remaja Taruna Jaya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(698, 'Komarun', '196006022006041014/', 'L', 'Indonesia', '1960-06-02', 'Kawin', '', '', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(699, 'Dudung', '196708181997031007/121203', 'L', 'Indonesia', '1945-07-30', 'Kawin', 'islam', 'Panti Sosial Bina Remaja Taruna Jaya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(700, 'Ninna Salam ', '197109091992032005/126464', 'L', 'Indonesia', '1945-07-31', 'Kawin', 'islam', 'Panti Sosial Bina Remaja Taruna Jaya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(701, 'Agus Sugianto', '197408182007011028/167247', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'Panti Sosial Bina Remaja Taruna Jaya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(702, 'Rudi Hartono', '197805052007011034/168675', 'L', 'Indonesia', '1945-07-18', 'Kawin', 'islam', 'Panti Sosial Bina Remaja Taruna Jaya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(703, 'Muhammad Kurniawan, S.Sos', '197901142010011010/177913', 'L', 'Indonesia', '1945-07-19', 'Kawin', 'islam', 'Panti Sosial Bina Remaja Taruna Jaya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(704, 'Ibrahim', '198504132008011010/170565', 'L', 'Indonesia', '1945-07-20', 'Kawin', 'islam', 'Panti Sosial Bina Remaja Taruna Jaya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(705, 'Adi Sutomo', '197811062007011007/167386', 'L', 'Indonesia', '1945-07-21', 'Kawin', 'islam', 'Panti Sosial Bina Remaja Taruna Jaya 2', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(706, 'Murni Sianturi', '197007181990032002', 'P', 'Jakarta', '1970-07-18', '', '', '', '', 'Jakarta', 'Jakarta', '', '2017-12-31', 2, 'Y', '', '', '2020-11-18 20:21:58'),
(707, 'BAMBANG WIJONO', '196312142007011014/167160', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(708, 'DJAFAR MUCHLISIN', '196805191989021001/112207', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(709, 'NAWARI LESYANI', '196002071993032002/126122', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(710, 'NURI SAWITRI', '196410301990032004/126027', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(711, 'T SYAHRUL', '196008161986031011/105398', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(712, 'TOHAP SIHOMBING', '196001211981031007/126241', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(713, 'WAHYUDI (I/A)', '198102102007011005/166075', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(714, 'KARMINIDIATI', '196004201983022001/126007', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(715, 'MUNASROH', '196803091989031006/112425', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(716, 'OYATI', '197008191996032003/119861', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(717, 'ERNI TRI HARDIYANTI', '196002061989022002/126414', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(718, 'LASWITA', '196004211982032006/126229', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(719, 'LELY YULIYATI', '196707181996032001/126267', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(720, 'MAKMUN', '196004101981031010/125926', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(721, 'MARYATI', '196601291990102001/126439', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(723, 'NARDI', '197208142007011020/168204', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(724, 'SAHAT SIMARMATA', '196002141984031003/126235', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(725, 'SRI SISWANTI', '195812051988032001/126371', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(726, 'SRI SUTARMI', '196103011993032002/126384', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(727, 'SUHARTO', '197709172007011020/167180', 'L', 'Indonesia', '1945-07-17', 'Kawin', '', '', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '38cc9-apa-itu-manajemen-beserta-fungsi,-tujuan-dan-contohnya-timeline.jpg', '2020-11-18 20:21:58'),
(728, 'SUKARMA', '196002082006041016/168883', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(729, 'SURYANTI NINGSIH', '197109131997032006/121409', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(730, 'SUTIYONO', '197205242007011020/168266', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(731, 'CARDE', '198011112007011010/167178', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(732, 'WAHYU ABDILLAH', '198701032011011016/', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(733, 'PUTRI ASYAFIAH', '198701282010012019/178939', 'L', 'Indonesia', '1945-07-17', 'Kawin', 'islam', 'dinsos', 'PNS', 'Jakarta', 'Jakarta', '0', '2000-01-01', 2, 'Y', '2160c109727700b060019ee636b8dcb0109e7cd0', '', '2020-11-18 20:21:58'),
(734, 'Jumi', '001223311', 'L', 'Karawang', '1987-02-10', 'Kawin', 'islam', 'Produksi BOPP', 'Wiraswasta', '0', 'Jakarta Timur', '0894312', '2020-11-05', 0, 'Y', '224bec3dd08832bc6a69873f15a50df406045f40', '5fb65fe9e3565.png', '2020-11-18 20:21:58'),
(735, 'Ardian', '110022123', 'L', 'Ciliwung', '1945-07-27', 'Kawin', 'Lainnya', 'WH', 'PNS', '0', 'Slebew', '088123912', '2000-01-01', 0, '', '', '1', '2020-11-18 20:21:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id` bigint(20) NOT NULL,
  `nm_barang` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `harga` double NOT NULL,
  `jml_brg` int(11) NOT NULL,
  `ket` varchar(255) NOT NULL,
  `kode_barang` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_barang`
--

INSERT INTO `tbl_barang` (`id`, `nm_barang`, `type`, `merk`, `harga`, `jml_brg`, `ket`, `kode_barang`) VALUES
(1, 'Pinjaman Berjangka', '0', '0', 0, -5, '0', 'PBRJ'),
(3, 'Kompor Gas', '0', 'Rinai', 100000, 4, 'qwe', ''),
(4, 'Pinjaman Barang', '0', '0', 0, -4, '0', 'PNJMBRG'),
(5, 'Pinjaman Konsumtif', '0', '0', 0, -1, '0', 'PBRJ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengajuan`
--

CREATE TABLE `tbl_pengajuan` (
  `id` bigint(20) NOT NULL,
  `no_ajuan` int(11) NOT NULL,
  `ajuan_id` varchar(255) NOT NULL,
  `anggota_id` bigint(20) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `nominal` bigint(20) NOT NULL,
  `lama_ags` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `alasan` varchar(255) NOT NULL,
  `tgl_cair` date NOT NULL,
  `tgl_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pinjaman_d`
--

CREATE TABLE `tbl_pinjaman_d` (
  `id` bigint(20) NOT NULL,
  `tgl_bayar` datetime NOT NULL,
  `pinjam_id` bigint(20) NOT NULL,
  `angsuran_ke` bigint(20) NOT NULL,
  `jumlah_bayar` int(11) NOT NULL,
  `denda_rp` int(11) NOT NULL,
  `terlambat` int(11) NOT NULL,
  `ket_bayar` enum('Angsuran','Pelunasan','Bayar Denda') NOT NULL,
  `dk` enum('D','K') NOT NULL,
  `kas_id` bigint(20) NOT NULL,
  `jns_trans` bigint(20) NOT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_pinjaman_d`
--

INSERT INTO `tbl_pinjaman_d` (`id`, `tgl_bayar`, `pinjam_id`, `angsuran_ke`, `jumlah_bayar`, `denda_rp`, `terlambat`, `ket_bayar`, `dk`, `kas_id`, `jns_trans`, `update_data`, `user_name`, `keterangan`) VALUES
(1, '2020-12-23 23:39:00', 4, 1, 1500, 1000, 0, 'Angsuran', 'D', 1, 48, '0000-00-00 00:00:00', 'admin', ''),
(2, '2020-12-23 23:42:00', 6, 1, 307500, 0, 0, 'Pelunasan', 'D', 1, 48, '0000-00-00 00:00:00', 'admin', 'qwe'),
(3, '2020-12-28 01:22:00', 1, 1, 21900, 1000, 0, 'Angsuran', 'D', 1, 48, '0000-00-00 00:00:00', 'admin', 'qwertyuiop');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pinjaman_h`
--

CREATE TABLE `tbl_pinjaman_h` (
  `id` bigint(20) NOT NULL,
  `tgl_pinjam` datetime NOT NULL,
  `anggota_id` bigint(20) NOT NULL,
  `barang_id` bigint(20) NOT NULL,
  `lama_angsuran` bigint(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `bunga` float(10,2) NOT NULL,
  `biaya_adm` int(11) NOT NULL,
  `lunas` enum('Belum','Lunas') NOT NULL,
  `dk` enum('D','K') NOT NULL,
  `kas_id` bigint(20) NOT NULL,
  `jns_trans` bigint(20) NOT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `contoh` int(23) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_pinjaman_h`
--

INSERT INTO `tbl_pinjaman_h` (`id`, `tgl_pinjam`, `anggota_id`, `barang_id`, `lama_angsuran`, `jumlah`, `bunga`, `biaya_adm`, `lunas`, `dk`, `kas_id`, `jns_trans`, `update_data`, `user_name`, `keterangan`, `contoh`) VALUES
(1, '2020-12-13 13:03:00', 734, 3, 5, 100000, 2.00, 1500, 'Belum', 'K', 1, 7, '0000-00-00 00:00:00', 'admin', '123', 0),
(2, '2020-12-13 13:03:00', 734, 1, 5, 500000, 2.00, 1500, 'Belum', 'K', 1, 7, '0000-00-00 00:00:00', 'admin', '123', 0),
(3, '2020-12-13 13:03:00', 734, 5, 3, 2000000, 2.00, 1500, 'Belum', 'K', 1, 7, '0000-00-00 00:00:00', 'admin', '321', 0),
(4, '2020-12-13 13:03:00', 712, 1, 5, 122, 2.00, 1500, 'Belum', 'K', 2, 7, '0000-00-00 00:00:00', 'admin', '123', 0),
(5, '2020-12-13 13:03:00', 725, 3, 2, 100000, 2.00, 1500, 'Belum', 'K', 1, 7, '0000-00-00 00:00:00', 'admin', '123', 0),
(6, '2020-12-23 23:38:00', 356, 4, 1, 300000, 2.00, 1500, 'Lunas', 'K', 1, 7, '0000-00-00 00:00:00', 'admin', 'qwertyuiop', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting`
--

CREATE TABLE `tbl_setting` (
  `id` bigint(20) NOT NULL,
  `opsi_key` varchar(255) NOT NULL,
  `opsi_val` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_setting`
--

INSERT INTO `tbl_setting` (`id`, `opsi_key`, `opsi_val`) VALUES
(1, 'nama_lembaga', 'KOPERASI PEGAWAI DEPSOS PRS BEKASI'),
(2, 'nama_ketua', 'Ibu Ismawati'),
(3, 'hp_ketua', ''),
(4, 'alamat', 'Jl.hj mulyadi'),
(5, 'telepon', ''),
(6, 'kota', 'Jakarta'),
(7, 'email', ''),
(8, 'web', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trans_kas`
--

CREATE TABLE `tbl_trans_kas` (
  `id` bigint(20) NOT NULL,
  `tgl_catat` datetime NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `akun` enum('Pemasukan','Pengeluaran','Transfer') NOT NULL,
  `dari_kas_id` bigint(20) DEFAULT NULL,
  `untuk_kas_id` bigint(20) DEFAULT NULL,
  `jns_trans` bigint(20) DEFAULT NULL,
  `dk` enum('D','K') DEFAULT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_trans_kas`
--

INSERT INTO `tbl_trans_kas` (`id`, `tgl_catat`, `jumlah`, `keterangan`, `akun`, `dari_kas_id`, `untuk_kas_id`, `jns_trans`, `dk`, `update_data`, `user_name`) VALUES
(1, '2020-12-13 13:03:00', 100000, 'Penambahan Data Pinjaman Anggota - Jumi', 'Pengeluaran', 1, NULL, 7, 'K', '0000-00-00 00:00:00', 'admin'),
(2, '2020-12-13 13:03:00', 500000, 'Penambahan Data Pinjaman Anggota - Jumi', 'Pengeluaran', 1, NULL, 7, 'K', '0000-00-00 00:00:00', 'admin'),
(3, '2020-12-13 13:03:00', 2000000, 'Penambahan Data Pinjaman Anggota - Jumi', 'Pengeluaran', 1, NULL, 7, 'K', '0000-00-00 00:00:00', 'admin'),
(4, '2020-12-13 13:03:00', 122, 'Penambahan Data Pinjaman Anggota - TOHAP SIHOMBING', 'Pengeluaran', 2, NULL, 7, 'K', '0000-00-00 00:00:00', 'admin'),
(5, '2020-12-13 13:03:00', 100000, 'Penambahan Data Pinjaman Anggota - SRI SISWANTI', 'Pengeluaran', 1, NULL, 7, 'K', '0000-00-00 00:00:00', 'admin'),
(6, '2020-12-23 23:39:00', 1500, 'Pembayaran Angsuran Anggota - TOHAP SIHOMBING', 'Pemasukan', NULL, 1, 7, 'D', '0000-00-00 00:00:00', 'admin'),
(7, '2020-12-23 23:38:00', 300000, 'Penambahan Data Pinjaman Anggota - Isnaini', 'Pengeluaran', 1, NULL, 7, 'K', '0000-00-00 00:00:00', 'admin'),
(8, '2020-12-23 23:42:00', 307500, 'Pelunasan Pinjaman Anggota - Isnaini', 'Pemasukan', NULL, 1, 7, 'D', '0000-00-00 00:00:00', 'admin'),
(9, '2020-12-28 01:22:00', 21900, 'Pembayaran Angsuran Anggota - Jumi', 'Pemasukan', NULL, 1, 7, 'D', '0000-00-00 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trans_sp`
--

CREATE TABLE `tbl_trans_sp` (
  `id` bigint(20) NOT NULL,
  `tgl_transaksi` datetime NOT NULL,
  `anggota_id` bigint(20) NOT NULL,
  `jenis_id` int(5) NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `akun` enum('Setoran','Penarikan') NOT NULL,
  `dk` enum('D','K') NOT NULL,
  `kas_id` bigint(20) NOT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `nama_penyetor` varchar(255) NOT NULL,
  `no_identitas` varchar(20) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` bigint(20) NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `pass_word` varchar(255) NOT NULL,
  `aktif` enum('Y','N') NOT NULL,
  `level` enum('admin','operator','pinjaman') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `u_name`, `pass_word`, `aktif`, `level`) VALUES
(1, 'admin', '224bec3dd08832bc6a69873f15a50df406045f40', 'Y', 'admin'),
(4, 'user', 'e22b7d59cb35d199ab7e54ed0f2ef58f5da5347b', 'Y', 'operator'),
(5, 'pinjaman', 'efd2770f6782f7218be595baf2fc16bc7cf45143', 'Y', 'pinjaman'),
(6, 'lia', '0bc4e37a6d834e0cd23ffe66a0f61be1d04e57db', 'Y', 'admin'),
(7, 'nur', 'fc1529bc385d3ec3962a79b423fd5c94e911358f', 'Y', 'admin'),
(8, 'dita', 'c24dbe502ba626337ed111795481fef7696aa308', 'Y', 'admin'),
(9, 'rosyid', '3bea9a0adb3dca563f40a7d4e6cfaecf8e646f46', 'Y', 'admin'),
(10, 'iyan', '35b29e8737411c641240b492620b6a72a448630d', 'Y', 'admin'),
(11, 'operator', 'ff546a1143afce9c58af2a5bf001811fe3b7699a', 'Y', 'operator');

-- --------------------------------------------------------

--
-- Table structure for table `type_desc_neraca`
--

CREATE TABLE `type_desc_neraca` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `type_desc_neraca`
--

INSERT INTO `type_desc_neraca` (`id`, `title`) VALUES
(1, 'Bank');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_hitung_pinjaman`
-- (See below for the actual view)
--
CREATE TABLE `v_hitung_pinjaman` (
`id` bigint(20)
,`tgl_pinjam` datetime
,`anggota_id` bigint(20)
,`lama_angsuran` bigint(20)
,`jumlah` int(11)
,`bunga` float(10,2)
,`biaya_adm` int(11)
,`lunas` enum('Belum','Lunas')
,`dk` enum('D','K')
,`kas_id` bigint(20)
,`user_name` varchar(255)
,`pokok_angsuran` decimal(14,4)
,`bunga_pinjaman` double(17,0)
,`ags_per_bulan` double(17,0)
,`tempo` datetime
,`tagihan` double(17,0)
,`keterangan` varchar(255)
,`barang_id` bigint(20)
,`bln_sudah_angsur` bigint(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_transaksi`
-- (See below for the actual view)
--
CREATE TABLE `v_transaksi` (
`tbl` varchar(1)
,`id` bigint(20)
,`tgl` datetime
,`kredit` double
,`debet` double
,`dari_kas` bigint(20)
,`untuk_kas` bigint(20)
,`transaksi` bigint(20)
,`ket` varchar(255)
,`user` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `v_hitung_pinjaman`
--
DROP TABLE IF EXISTS `v_hitung_pinjaman`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_hitung_pinjaman`  AS SELECT `tbl_pinjaman_h`.`id` AS `id`, `tbl_pinjaman_h`.`tgl_pinjam` AS `tgl_pinjam`, `tbl_pinjaman_h`.`anggota_id` AS `anggota_id`, `tbl_pinjaman_h`.`lama_angsuran` AS `lama_angsuran`, `tbl_pinjaman_h`.`jumlah` AS `jumlah`, `tbl_pinjaman_h`.`bunga` AS `bunga`, `tbl_pinjaman_h`.`biaya_adm` AS `biaya_adm`, `tbl_pinjaman_h`.`lunas` AS `lunas`, `tbl_pinjaman_h`.`dk` AS `dk`, `tbl_pinjaman_h`.`kas_id` AS `kas_id`, `tbl_pinjaman_h`.`user_name` AS `user_name`, `tbl_pinjaman_h`.`jumlah`/ `tbl_pinjaman_h`.`lama_angsuran` AS `pokok_angsuran`, round(ceiling(`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran` * `tbl_pinjaman_h`.`bunga` / 100),-2) AS `bunga_pinjaman`, round(ceiling((`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran` * `tbl_pinjaman_h`.`bunga` / 100 + `tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran` + `tbl_pinjaman_h`.`biaya_adm`) * 100 / 100),-2) AS `ags_per_bulan`, `tbl_pinjaman_h`.`tgl_pinjam`+ interval `tbl_pinjaman_h`.`lama_angsuran` month AS `tempo`, round(ceiling((`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran` * `tbl_pinjaman_h`.`bunga` / 100 + `tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran` + `tbl_pinjaman_h`.`biaya_adm`) * 100 / 100),-2) * `tbl_pinjaman_h`.`lama_angsuran` AS `tagihan`, `tbl_pinjaman_h`.`keterangan` AS `keterangan`, `tbl_pinjaman_h`.`barang_id` AS `barang_id`, ifnull(max(`tbl_pinjaman_d`.`angsuran_ke`),0) AS `bln_sudah_angsur` FROM (`tbl_pinjaman_h` left join `tbl_pinjaman_d` on(`tbl_pinjaman_h`.`id` = `tbl_pinjaman_d`.`pinjam_id`)) GROUP BY `tbl_pinjaman_h`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `v_transaksi`
--
DROP TABLE IF EXISTS `v_transaksi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_transaksi`  AS SELECT 'A' AS `tbl`, `tbl_pinjaman_h`.`id` AS `id`, `tbl_pinjaman_h`.`tgl_pinjam` AS `tgl`, `tbl_pinjaman_h`.`jumlah` AS `kredit`, 0 AS `debet`, `tbl_pinjaman_h`.`kas_id` AS `dari_kas`, NULL AS `untuk_kas`, `tbl_pinjaman_h`.`jns_trans` AS `transaksi`, `tbl_pinjaman_h`.`keterangan` AS `ket`, `tbl_pinjaman_h`.`user_name` AS `user` FROM `tbl_pinjaman_h` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bendahara`
--
ALTER TABLE `bendahara`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `biaya_umum`
--
ALTER TABLE `biaya_umum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`) USING BTREE,
  ADD KEY `last_activity_idx` (`last_activity`) USING BTREE;

--
-- Indexes for table `jns_akun`
--
ALTER TABLE `jns_akun`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `kd_aktiva` (`kd_aktiva`) USING BTREE;

--
-- Indexes for table `jns_angsuran`
--
ALTER TABLE `jns_angsuran`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `jns_simpan`
--
ALTER TABLE `jns_simpan`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `nama_kas_tbl`
--
ALTER TABLE `nama_kas_tbl`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `pembagian_shu_labarugi`
--
ALTER TABLE `pembagian_shu_labarugi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suku_bunga`
--
ALTER TABLE `suku_bunga`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `identitas` (`identitas`) USING BTREE;

--
-- Indexes for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tbl_pengajuan`
--
ALTER TABLE `tbl_pengajuan`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `user_id` (`anggota_id`) USING BTREE;

--
-- Indexes for table `tbl_pinjaman_d`
--
ALTER TABLE `tbl_pinjaman_d`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `kas_id` (`kas_id`) USING BTREE,
  ADD KEY `user_name` (`user_name`) USING BTREE,
  ADD KEY `pinjam_id` (`pinjam_id`) USING BTREE,
  ADD KEY `jns_trans` (`jns_trans`) USING BTREE;

--
-- Indexes for table `tbl_pinjaman_h`
--
ALTER TABLE `tbl_pinjaman_h`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `anggota_id` (`anggota_id`) USING BTREE,
  ADD KEY `kas_id` (`kas_id`) USING BTREE,
  ADD KEY `user_name` (`user_name`) USING BTREE,
  ADD KEY `jns_trans` (`jns_trans`) USING BTREE,
  ADD KEY `barang_id` (`barang_id`) USING BTREE;

--
-- Indexes for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tbl_trans_kas`
--
ALTER TABLE `tbl_trans_kas`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `user_name` (`user_name`) USING BTREE,
  ADD KEY `dari_kas_id` (`dari_kas_id`,`untuk_kas_id`) USING BTREE,
  ADD KEY `untuk_kas_id` (`untuk_kas_id`) USING BTREE,
  ADD KEY `jns_trans` (`jns_trans`) USING BTREE;

--
-- Indexes for table `tbl_trans_sp`
--
ALTER TABLE `tbl_trans_sp`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `anggota_id` (`anggota_id`) USING BTREE,
  ADD KEY `jenis_id` (`jenis_id`) USING BTREE,
  ADD KEY `kas_id` (`kas_id`) USING BTREE,
  ADD KEY `user_name` (`user_name`) USING BTREE;

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `u_name` (`u_name`) USING BTREE;

--
-- Indexes for table `type_desc_neraca`
--
ALTER TABLE `type_desc_neraca`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bendahara`
--
ALTER TABLE `bendahara`
  MODIFY `id` int(225) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `biaya_umum`
--
ALTER TABLE `biaya_umum`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jns_akun`
--
ALTER TABLE `jns_akun`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `jns_angsuran`
--
ALTER TABLE `jns_angsuran`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `jns_simpan`
--
ALTER TABLE `jns_simpan`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `nama_kas_tbl`
--
ALTER TABLE `nama_kas_tbl`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pembagian_shu_labarugi`
--
ALTER TABLE `pembagian_shu_labarugi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `suku_bunga`
--
ALTER TABLE `suku_bunga`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=736;

--
-- AUTO_INCREMENT for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_pengajuan`
--
ALTER TABLE `tbl_pengajuan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pinjaman_d`
--
ALTER TABLE `tbl_pinjaman_d`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_pinjaman_h`
--
ALTER TABLE `tbl_pinjaman_h`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_trans_kas`
--
ALTER TABLE `tbl_trans_kas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_trans_sp`
--
ALTER TABLE `tbl_trans_sp`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_pengajuan`
--
ALTER TABLE `tbl_pengajuan`
  ADD CONSTRAINT `tbl_pengajuan_ibfk_1` FOREIGN KEY (`anggota_id`) REFERENCES `tbl_anggota` (`id`);

--
-- Constraints for table `tbl_pinjaman_d`
--
ALTER TABLE `tbl_pinjaman_d`
  ADD CONSTRAINT `tbl_pinjaman_d_ibfk_1` FOREIGN KEY (`pinjam_id`) REFERENCES `tbl_pinjaman_h` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pinjaman_d_ibfk_2` FOREIGN KEY (`kas_id`) REFERENCES `nama_kas_tbl` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pinjaman_d_ibfk_3` FOREIGN KEY (`user_name`) REFERENCES `tbl_user` (`u_name`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_pinjaman_d_ibfk_4` FOREIGN KEY (`jns_trans`) REFERENCES `jns_akun` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_pinjaman_h`
--
ALTER TABLE `tbl_pinjaman_h`
  ADD CONSTRAINT `tbl_pinjaman_h_ibfk_1` FOREIGN KEY (`anggota_id`) REFERENCES `tbl_anggota` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pinjaman_h_ibfk_2` FOREIGN KEY (`kas_id`) REFERENCES `nama_kas_tbl` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pinjaman_h_ibfk_3` FOREIGN KEY (`user_name`) REFERENCES `tbl_user` (`u_name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pinjaman_h_ibfk_4` FOREIGN KEY (`jns_trans`) REFERENCES `jns_akun` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pinjaman_h_ibfk_5` FOREIGN KEY (`barang_id`) REFERENCES `tbl_barang` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_trans_kas`
--
ALTER TABLE `tbl_trans_kas`
  ADD CONSTRAINT `tbl_trans_kas_ibfk_2` FOREIGN KEY (`user_name`) REFERENCES `tbl_user` (`u_name`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_trans_kas_ibfk_3` FOREIGN KEY (`dari_kas_id`) REFERENCES `nama_kas_tbl` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_trans_kas_ibfk_4` FOREIGN KEY (`untuk_kas_id`) REFERENCES `nama_kas_tbl` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_trans_kas_ibfk_5` FOREIGN KEY (`jns_trans`) REFERENCES `jns_akun` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_trans_sp`
--
ALTER TABLE `tbl_trans_sp`
  ADD CONSTRAINT `tbl_trans_sp_ibfk_1` FOREIGN KEY (`anggota_id`) REFERENCES `tbl_anggota` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_trans_sp_ibfk_2` FOREIGN KEY (`kas_id`) REFERENCES `nama_kas_tbl` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_trans_sp_ibfk_4` FOREIGN KEY (`jenis_id`) REFERENCES `jns_simpan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_trans_sp_ibfk_5` FOREIGN KEY (`user_name`) REFERENCES `tbl_user` (`u_name`) ON UPDATE CASCADE;
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `query` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_length` text COLLATE utf8_bin DEFAULT NULL,
  `col_collation` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) COLLATE utf8_bin DEFAULT '',
  `col_default` text COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `column_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `settings_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `export_type` varchar(10) COLLATE utf8_bin NOT NULL,
  `template_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `template_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"nsi_koperasi\",\"table\":\"bendahara\"},{\"db\":\"nsi_koperasi\",\"table\":\"biaya_umum\"},{\"db\":\"nsi_koperasi\",\"table\":\"pembagian_shu_labarugi\"},{\"db\":\"nsi_koperasi\",\"table\":\"tbl_barang\"},{\"db\":\"nsi_koperasi\",\"table\":\"jns_akun\"},{\"db\":\"nsi_koperasi\",\"table\":\"nama_kas_tbl\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `display_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `prefs` text COLLATE utf8_bin NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- Dumping data for table `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'nsi_koperasi', 'tbl_anggota', '{\"sorted_col\":\"anggota.nama\"}', '2020-12-23 16:35:09');

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text COLLATE utf8_bin NOT NULL,
  `schema_sql` text COLLATE utf8_bin DEFAULT NULL,
  `data_sql` longtext COLLATE utf8_bin DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') COLLATE utf8_bin DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2020-12-28 16:04:36', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL,
  `tab` varchar(64) COLLATE utf8_bin NOT NULL,
  `allowed` enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
