-- Database: `about_db` (or part of `yibbi_db` specifically for About Page)
-- Created from about.html content analysis
-- File Name: about.sql

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Table structure for table `scholars`
-- Deskripsi: Tabel ini menyimpan data para ulama atau anggota tim yang ditampilkan di halaman About.
-- Kolom:
-- id: Primary Key
-- name: Nama lengkap scholar (misal: Hamad Bin Jasim)
-- title: Gelar atau jabatan (misal: Hafiz Quran Scholor)
-- image: Path ke gambar profil (misal: assets/images/team/01.jpg)
-- social_twitter: Link profil Twitter
-- social_behance: Link profil Behance
-- social_instagram: Link profil Instagram
-- social_vimeo: Link profil Vimeo
-- social_linkedin: Link profil LinkedIn
--

CREATE TABLE `scholars` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `social_twitter` varchar(255) DEFAULT '#',
  `social_behance` varchar(255) DEFAULT '#',
  `social_instagram` varchar(255) DEFAULT '#',
  `social_vimeo` varchar(255) DEFAULT '#',
  `social_linkedin` varchar(255) DEFAULT '#'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `scholars`
-- Menyisipkan data dummy yang diambil langsung dari file about.html
--

INSERT INTO `scholars` (`id`, `name`, `title`, `image`, `social_twitter`, `social_behance`, `social_instagram`, `social_vimeo`, `social_linkedin`) VALUES
(1, 'Hamad Bin Jasim', 'Hafiz Quran Scholor', 'assets/images/team/01.jpg', '#', '#', '#', '#', '#'),
(2, 'Sayyida Al-Hijaazi', 'Hafiz Quran Scholor', 'assets/images/team/02.jpg', '#', '#', '#', '#', '#'),
(3, 'Ashraf Al-Maktum', 'Hafiz Quran Scholor', 'assets/images/team/03.jpg', '#', '#', '#', '#', '#'),
(4, 'Ayesha Binte Alif', 'Hafiz Quran Scholor', 'assets/images/team/04.jpg', '#', '#', '#', '#', '#');

-- --------------------------------------------------------

--
-- Table structure for table `about_main_content`
-- Deskripsi: Tabel ini menyimpan konten utama bagian About (div lab-inner), termasuk judul, deskripsi, dan tombol aksi.
-- Kolom:
-- id: Primary Key (biasanya hanya ada 1 baris data untuk ini)
-- sub_title: Judul kecil di atas (misal: About Our History)
-- main_title: Judul utama (misal: Islamic Center For Muslims...)
-- highlight_text: Teks yang disorot (misal: Our Promise To Uphold...)
-- description: Deskripsi paragraf lengkap
-- button_text: Teks pada tombol (misal: Ask About Islam)
-- button_link: Link URL tujuan saat tombol diklik (bisa link WA atau halaman lain)
-- image_main: Gambar utama (jika perlu dinamis)
--

CREATE TABLE `about_main_content` (
  `id` int(11) NOT NULL, -- Kolom ID unik
  `sub_title` varchar(255) DEFAULT NULL, -- Sub-judul bagian
  `main_title` varchar(255) DEFAULT NULL, -- Judul utama bagian
  `highlight_text` varchar(255) DEFAULT NULL, -- Teks highlight / janji
  `description` text DEFAULT NULL, -- Deskripsi lengkap paragraf
  `button_text` varchar(50) DEFAULT 'Ask About Islam', -- Teks tombol
  `button_link` varchar(255) DEFAULT '#', -- Link tujuan tombol
  `image_main` varchar(255) DEFAULT 'assets/images/about/02.png' -- Path gambar samping
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; -- Menggunakan engine InnoDB dan charset utf8mb4

--
-- Dumping data for table `about_main_content`
-- Menyisipkan data awal sesuai konten about.html saat ini
--

INSERT INTO `about_main_content` (`id`, `sub_title`, `main_title`, `highlight_text`, `description`, `button_text`, `button_link`, `image_main`) VALUES
(1, -- ID
 'About Our History', -- Data Sub Title
 'Islamic Center For Muslims To Achieve Spiritual Goals', -- Data Main Title
 'Our Promise To Uphold The Trust Placed.', -- Data Highlight
 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Modi molestias culpa reprehenderit delectus, ullam harum, voluptatum numquam ati nesciunt odit quis corrupti magni quam consequatur sint ipsum tecto exercitationem, illo quisquam. Reprehenderit ut placeat cum adantium nam magnam blanditiis sequi modi! Nesciunt, repudiandae eos eniam quod maxime corrupti eligendi ea in animi.', -- Data Deskripsi
 'Ask About Islam', -- Data Teks Tombol
 'https://wa.me/628123456789', -- Data Link Tombol (Contoh ke WhatsApp)
 'assets/images/about/02.png'); -- Data Gambar

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `about_features`
-- Deskripsi: Tabel ini menyimpan data fitur-fitur yang ditampilkan di halaman About (bisa jadi sama dengan di index, tapi ini khusus file ini).
--

CREATE TABLE `about_features` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `button_text` varchar(50) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT '#'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `about_features`
--

INSERT INTO `about_features` (`id`, `title`, `description`, `image`, `button_text`, `button_link`) VALUES
(1, 'Quran Studies', 'Lorem ipsum dolor sit, amet is consectetur adipisicing elit.Its expedita porro natus', 'assets/images/feature/01.png', 'Sponsor Now!', '#'),
(2, 'Islamic Classes', 'Lorem ipsum dolor sit, amet is consectetur adipisicing elit.Its expedita porro natus', 'assets/images/feature/02.png', 'Donate Now!', '#'),
(3, 'Islamic Awareness', 'Lorem ipsum dolor sit, amet is consectetur adipisicing elit.Its expedita porro natus', 'assets/images/feature/03.png', 'Join Us!', '#'),
(4, 'Islamic Services', 'Lorem ipsum dolor sit, amet is consectetur adipisicing elit.Its expedita porro natus', 'assets/images/feature/04.png', 'Get Involved!', '#');

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

ALTER TABLE `scholars` ADD PRIMARY KEY (`id`);
ALTER TABLE `about_features` ADD PRIMARY KEY (`id`);
ALTER TABLE `about_main_content` ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

ALTER TABLE `scholars` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `about_features` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `about_main_content` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
