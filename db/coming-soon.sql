-- Database: `coming_soon_db` (atau bagian dari `yibbi_db` untuk halaman Coming Soon)
-- File ini dibuat berdasarkan analisa file coming-soon.html
-- Tujuan: Menyimpan konfigurasi dinamis untuk halaman Coming Soon

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Table structure for table `coming_soon_settings`
-- Deskripsi: Tabel ini menyimpan pengaturan utama untuk halaman Coming Soon.
-- Memungkinkan admin mengubah tanggal hitung mundur, logo, dan judul tanpa mengedit kode HTML.
-- Kolom:
-- id: Primary Key unik (biasanya hanya 1 baris).
-- title: Judul halaman utama (misal: "Coming Soon").
-- logo: Path file gambar logo yang ditampilkan (misal: "assets/images/logo/01.png").
-- target_date: Tanggal dan waktu tujuan hitung mundur (format: YYYY-MM-DD HH:MM:SS).
-- is_active: Status apakah mode coming soon aktif atau tidak (1 = aktif, 0 = tidak).
--

CREATE TABLE `coming_soon_settings` (
  `id` int(11) NOT NULL, -- Kolom ID, integer, tidak boleh kosong.
  `title` varchar(255) DEFAULT 'Coming Soon', -- Judul Halaman, default 'Coming Soon'.
  `logo` varchar(255) DEFAULT 'assets/images/logo/01.png', -- Path Logo, default logo bawaan.
  `target_date` datetime DEFAULT NULL, -- Tanggal target countdown.
  `is_active` tinyint(1) DEFAULT 1, -- Status aktif, default 1 (aktif).
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(), -- Waktu pembuatan data.
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() -- Waktu update terakhir otomatis.
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; -- Menggunakan engine InnoDB dan charset utf8mb4.

--
-- Dumping data for table `coming_soon_settings`
-- Menyisipkan data awal sesuai dengan nilai hardcoded di coming-soon.html.
-- Tanggal target diambil dari atribut data-date="July 31, 2021 21:14:01".
--

INSERT INTO `coming_soon_settings` (`id`, `title`, `logo`, `target_date`, `is_active`) VALUES
(1, -- ID data pertama
 'Coming Soon', -- Judul yang ditampilkan
 'assets/images/logo/01.png', -- Path gambar logo
 '2021-07-31 21:14:01', -- Konversi "July 31, 2021 21:14:01" ke format datetime SQL
 1); -- Set status aktif

-- --------------------------------------------------------

--
-- Indexes for dumped tables
-- Menambahkan indeks Primary Key untuk performa pencarian.
--

ALTER TABLE `coming_soon_settings` ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
-- Mengatur agar kolom ID bertambah secara otomatis.
--

ALTER TABLE `coming_soon_settings` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
