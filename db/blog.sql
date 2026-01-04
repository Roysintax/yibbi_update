-- Database: `blog_db` (or part of `yibbi_db` specifically for Blog Page)
-- Extracted from about.sql
-- File Name: blog.sql

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Section: Blog (from blog.html)
-- Bagian ini ditambahkan berdasarkan permintaan untuk halaman blog.html
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
-- Deskripsi: Tabel ini menyimpan kategori untuk artikel blog.
-- Mengatur pengelompokan artikel agar lebih terstruktur.
-- Kolom:
-- id: Identifikasi unik untuk setiap kategori (Primary Key).
-- name: Nama kategori (contoh: Business, Creative).
-- slug: Versi URL-friendly dari nama kategori (contoh: business, creative).
-- count: Jumlah artikel dalam kategori ini (opsional, bisa dihitung dinamis).
--

CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL, -- Kolom ID unik, tipe integer.
  `name` varchar(255) NOT NULL, -- Nama kategori, wajib diisi.
  `slug` varchar(255) NOT NULL, -- Slug URL kategori, wajib diisi.
  `count` int(11) DEFAULT 0 -- Jumlah artikel, default 0.
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; -- Menggunakan InnoDB dan charset UTF-8 mb4.

--
-- Dumping data for table `blog_categories`
-- Menyisipkan data dummy kategori sesuai widget "Post Categories" di blog.html.
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `count`) VALUES
(1, 'Business', 'business', 20), -- Kategori Business
(2, 'Creative', 'creative', 25), -- Kategori Creative
(3, 'Inspiation', 'inspiation', 30), -- Kategori Inspiation (Typo di HTML asli, disesuaikan)
(4, 'News', 'news', 28), -- Kategori News
(5, 'Photography', 'photography', 20), -- Kategori Photography
(6, 'Smart', 'smart', 26); -- Kategori Smart

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
-- Deskripsi: Tabel utama untuk menyimpan artikel blog.
-- Menampung semua informasi detail mengenai satu postingan.
-- Kolom:
-- id: Primary Key unik.
-- title: Judul artikel.
-- slug: URL-friendly title.
-- image: Path gambar utama/thumbnail.
-- content: Isi lengkap artikel (HTML).
-- excerpt: Ringkasan singkat artikel untuk tampilan list.
-- author: Nama penulis artikel.
-- published_at: Tanggal dan waktu publikasi.
-- comment_count: Jumlah komentar.
-- type: Tipe post (standard, slide, video, quote) - sesuai struktur HTML.
-- video_url: URL video jika tipe post adalah video.
-- quote_text: Teks kutipan jika tipe post adalah quote.
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL, -- ID unik postingan.
  `title` varchar(255) NOT NULL, -- Judul artikel.
  `slug` varchar(255) NOT NULL, -- Slug URL.
  `image` varchar(255) DEFAULT NULL, -- Gambar thumbnail.
  `content` text DEFAULT NULL, -- Isi artikel lengkap.
  `excerpt` text DEFAULT NULL, -- Ringkasan artikel.
  `author` varchar(100) DEFAULT 'Admin', -- Penulis, default Admin.
  `published_at` datetime DEFAULT current_timestamp(), -- Waktu publish.
  `comment_count` int(11) DEFAULT 0, -- Jumlah komentar.
  `type` enum('standard','slide','video','quote') DEFAULT 'standard', -- Tipe tampilan.
  `video_url` varchar(255) DEFAULT NULL, -- URL Video (opsional).
  `quote_text` text DEFAULT NULL -- Teks Quote (opsional).
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; -- Engine InnoDB.

--
-- Dumping data for table `blog_posts`
-- Menyisipkan data dummy artikel sesuai blog.html.
--

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `image`, `excerpt`, `author`, `published_at`, `comment_count`, `type`, `video_url`, `quote_text`) VALUES
(1, 'Continually proactive services', 'continually-proactive-services', 'assets/images/blog/01.jpg', 'It’s no secret that the digital industry is booming. from exciting startups to global brands...', 'Robot Smith', '2019-10-09 10:59:00', 9, 'standard', NULL, NULL), -- Artikel Standar
(2, 'Continually proactive services (Slide)', 'continually-proactive-services-slide', 'assets/images/blog/02.jpg', 'It’s no secret that the digital industry is booming. from exciting startups to global brands...', 'Robot Smith', '2019-10-09 10:59:00', 9, 'slide', NULL, NULL), -- Artikel Slider (Data gambar lain di tabel terpisah jika perlu, disederhanakan di sini)
(3, 'Continually proactive services (Video)', 'continually-proactive-services-video', 'assets/images/blog/03.jpg', 'It’s no secret that the digital industry is booming. from exciting startups to global brands...', 'Robot Smith', '2019-10-09 10:59:00', 9, 'video', 'https://www.youtube.com/embed/LjEwuC6J-Uk', NULL), -- Artikel Video
(4, 'Continually proactive services (Quote)', 'continually-proactive-services-quote', NULL, 'It’s no secret that the digital industry is booming. from exciting startups to global brands...', 'Robot Smith', '2019-10-09 10:59:00', 9, 'quote', NULL, 'Rapdiou Qntegrat Distrbute Supply Chains Through Markey Position Bestng Chans Throug Marke Posito Bestin Practces Ieractve Fashon Sound Qources Fashion Economically And Sound Qources'); -- Artikel Quote

-- --------------------------------------------------------

--
-- Table structure for table `blog_tags`
-- Deskripsi: Tabel untuk menyimpan tag/label artikel.
--

CREATE TABLE `blog_tags` (
  `id` int(11) NOT NULL, -- ID Tag.
  `name` varchar(100) NOT NULL, -- Nama Tag.
  `slug` varchar(100) NOT NULL -- Slug Tag.
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; -- Engine InnoDB.

--
-- Dumping data for table `blog_tags`
-- Menyisipkan data tag sesuai widget "Our Popular tags".
--

INSERT INTO `blog_tags` (`id`, `name`, `slug`) VALUES
(1, 'envato', 'envato'), -- Tag Envato
(2, 'themeforest', 'themeforest'), -- Tag Themeforest
(3, 'codecanyon', 'codecanyon'), -- Tag Codecanyon
(4, 'videohive', 'videohive'), -- Tag Videohive
(5, 'audiojungle', 'audiojungle'), -- Tag Audiojungle
(6, '3docean', '3docean'); -- Tag 3docean

-- --------------------------------------------------------

--
-- Table structure for table `blog_post_tags`
-- Deskripsi: Tabel Pivot (penghubung) antara Posts dan Tags.
-- Relasi Many-to-Many: Satu post bisa punya banyak tag, satu tag bisa ada di banyak post.
--

CREATE TABLE `blog_post_tags` (
  `post_id` int(11) NOT NULL, -- ID Post.
  `tag_id` int(11) NOT NULL -- ID Tag.
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; -- Engine InnoDB.

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

ALTER TABLE `blog_categories` ADD PRIMARY KEY (`id`); -- PK Category
ALTER TABLE `blog_posts` ADD PRIMARY KEY (`id`); -- PK Post
ALTER TABLE `blog_tags` ADD PRIMARY KEY (`id`); -- PK Tag
ALTER TABLE `blog_post_tags` ADD PRIMARY KEY (`post_id`, `tag_id`); -- PK Composite

--
-- AUTO_INCREMENT for dumped tables
--

ALTER TABLE `blog_categories` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7; -- Auto Inc Category
ALTER TABLE `blog_posts` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5; -- Auto Inc Post
ALTER TABLE `blog_tags` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7; -- Auto Inc Tag

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
