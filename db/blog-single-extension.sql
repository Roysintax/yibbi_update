-- ========================================================================
-- EXTENSION DATABASE UNTUK BLOG-SINGLE.PHP
-- ========================================================================
-- File: blog-single-extension.sql
-- Deskripsi: File ini adalah extension dari blog.sql yang sudah ada.
-- Menambahkan tabel untuk fitur-fitur di halaman blog-single.php seperti:
-- 1. Sistem Komentar (Comments) dengan nested replies
-- 2. Informasi Author/Penulis
-- 3. Data untuk navigasi Previous/Next Article
--
-- INSTRUKSI PENGGUNAAN:
-- File ini menambahkan tabel baru yang EXTENDS blog.sql yang sudah ada.
-- Jalankan blog.sql terlebih dahulu, kemudian jalankan file ini.
-- ========================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"; -- Mode SQL: nonaktifkan auto value on zero untuk konsistensi
START TRANSACTION; -- Mulai transaksi database
SET time_zone = "+00:00"; -- Set timezone ke UTC +00:00

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */; -- Backup setting character set client
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */; -- Backup setting character set results
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */; -- Backup setting collation
/*!40101 SET NAMES utf8mb4 */; -- Set encoding ke UTF-8 mb4 (mendukung emoji dan karakter khusus)

-- --------------------------------------------------------
-- SECTION 1: TABEL BLOG_AUTHORS (Informasi Penulis)
-- --------------------------------------------------------

--
-- Struktur tabel untuk `blog_authors`
-- Deskripsi: Tabel ini menyimpan informasi lengkap tentang penulis/author artikel.
-- Pada blog-single.php, ada section "Author Box" yang menampilkan foto, nama,
-- bio, dan social media author. Data ini diambil dari tabel ini.
--
-- Kolom-kolom:
-- - id: ID unik untuk setiap autor (Primary Key, Auto Increment)
-- - name: Nama lengkap penulis (misal: "Rassel Hossain")
-- - slug: URL-friendly version dari nama (misal: "rassel-hossain")
-- - email: Email penulis (untuk admin dan notifikasi)
-- - avatar: Path ke foto profil penulis (misal: "assets/images/blog/author2.png")
-- - bio: Biografi singkat penulis (ditampilkan di author box)
-- - twitter: Username Twitter penulis (opsional)
-- - behance: Username Behance penulis (opsional)
-- - instagram: Username Instagram penulis (opsional)
-- - vimeo: Username Vimeo penulis (opsional)
-- - linkedin: Username LinkedIn penulis (opsional)
-- - created_at: Timestamp kapan author dibuat
--

CREATE TABLE `blog_authors` ( -- Membuat tabel blog_authors
  `id` int(11) NOT NULL, -- ID unik penulis, tipe integer, tidak boleh kosong
  `name` varchar(255) NOT NULL, -- Nama penulis, maksimal 255 karakter, wajib diisi
  `slug` varchar(255) NOT NULL, -- Slug URL penulis, maksimal 255 karakter, wajib diisi
  `email` varchar(255) DEFAULT NULL, -- Email penulis, opsional (boleh kosong)
  `avatar` varchar(500) DEFAULT 'assets/images/blog/author2.png', -- Path foto penulis, default ke gambar default
  `bio` text DEFAULT NULL, -- Biografi penulis, tipe text (panjang), opsional
  `twitter` varchar(100) DEFAULT NULL, -- Username Twitter, maksimal 100 karakter, opsional
  `behance` varchar(100) DEFAULT NULL, -- Username Behance, maksimal 100 karakter, opsional
  `instagram` varchar(100) DEFAULT NULL, -- Username Instagram, maksimal 100 karakter, opsional
  `vimeo` varchar(100) DEFAULT NULL, -- Username Vimeo, maksimal 100 karakter, opsional
  `linkedin` varchar(100) DEFAULT NULL, -- Username LinkedIn, maksimal 100 karakter, opsional
  `created_at` datetime DEFAULT current_timestamp() -- Timestamp pembuatan record, default waktu sekarang
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; -- Engine InnoDB untuk transaksi, charset UTF-8 mb4

--
-- Dumping data untuk tabel `blog_authors`
-- Menambahkan data sample author sesuai yang ditampilkan di blog-single.php
--

INSERT INTO `blog_authors` (`id`, `name`, `slug`, `email`, `avatar`, `bio`, `twitter`, `behance`, `instagram`, `vimeo`, `linkedin`) VALUES
(1, 'Robot Smith', 'robot-smith', 'robot@example.com', 'assets/images/blog/author2.png', 'Competently conceptualize alternative synergy and technically and niche markets. Efficiently impact technically sound outsourcing rath tnclicks-and-mortar best practices.', 'robotsmith', 'robotsmith', 'robotsmith', 'robotsmith', 'robot-smith'), -- Data author pertama (Robot Smith) yang muncul di blog posts
(2, 'Rassel Hossain', 'rassel-hossain', 'rassel@example.com', 'assets/images/blog/author2.png', 'Competently conceptualize alternative synergy and technically and niche markets. Efficiently impact technically sound outsourcing rath tnclicks-and-mortar best practices.', 'rasselhossain', 'rasselhossain', 'rasselhossain', 'rasselhossain', 'rassel-hossain'); -- Data author kedua (Rassel Hossain) - tampil di author box blog-single.php

-- --------------------------------------------------------
-- SECTION 2: TABEL BLOG_COMMENTS (Sistem Komentar)
-- --------------------------------------------------------

--
-- Struktur tabel untuk `blog_comments`
-- Deskripsi: Tabel ini menyimpan semua komentar yang ditulis oleh pengunjung
-- pada artikel blog. Di blog-single.php, ada section "Comments" yang menampilkan
-- daftar komentar dan form untuk menambah komentar baru.
--
-- Fitur Nested Comments (Komentar Bersarang):
-- Tabel ini mendukung nested replies (balasan komentar) dengan menggunakan
-- kolom 'parent_id'. Jika parent_id = NULL, berarti komentar utama.
-- Jika parent_id = ID komentar lain, berarti ini adalah reply/balasan.
--
-- Kolom-kolom:
-- - id: ID unik komentar (Primary Key, Auto Increment)
-- - post_id: ID artikel blog yang dikomentari (Foreign Key ke blog_posts)
-- - parent_id: ID komentar parent jika ini adalah reply, NULL jika komentar utama
-- - author_name: Nama orang yang berkomentar
-- - author_email: Email orang yang berkomentar  
-- - author_website: Website orang yang berkomentar (opsional)
-- - author_avatar: Path foto profil (default ke gambar generic)
-- - content: Isi komentar
-- - status: Status komentar (pending/approved/spam) untuk moderasi
-- - created_at: Waktu komentar dibuat
-- - updated_at: Waktu komentar terakhir diupdate
--

CREATE TABLE `blog_comments` ( -- Membuat tabel blog_comments
  `id` int(11) NOT NULL, -- ID unik komentar, tipe integer, tidak boleh kosong
  `post_id` int(11) NOT NULL, -- ID artikel yang dikomentari, wajib diisi (Foreign Key)
  `parent_id` int(11) DEFAULT NULL, -- ID parent comment untuk nested replies, NULL jika komentar utama
  `author_name` varchar(255) NOT NULL, -- Nama pemberi komentar, maksimal 255 karakter, wajib diisi
  `author_email` varchar(255) NOT NULL, -- Email pemberi komentar, maksimal 255 karakter, wajib diisi
  `author_website` varchar(500) DEFAULT NULL, -- Website pemberi komentar, opsional
  `author_avatar` varchar(500) DEFAULT 'assets/images/team/05.jpg', -- Path avatar, default ke gambar team
  `content` text NOT NULL, -- Isi komentar, tipe text, wajib diisi
  `status` enum('pending','approved','spam') DEFAULT 'pending', -- Status moderasi: pending (menunggu), approved (disetujui), spam
  `created_at` datetime DEFAULT current_timestamp(), -- Timestamp kapan komentar dibuat, default waktu sekarang
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp() -- Timestamp update terakhir, auto-update saat record berubah
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; -- Engine InnoDB, charset UTF-8 mb4

--
-- Dumping data untuk tabel `blog_comments`
-- Menambahkan sample comments sesuai yang ditampilkan di blog-single.php
-- Ada 2 komentar utama dan 1 reply (nested comment)
--

INSERT INTO `blog_comments` (`id`, `post_id`, `parent_id`, `author_name`, `author_email`, `author_website`, `author_avatar`, `content`, `status`, `created_at`) VALUES
(1, 1, NULL, 'Linsa Faith', 'linsa@example.com', 'https://example.com', 'assets/images/team/05.jpg', 'The inner sanctuary, I throw myself down among the tall grass bye the trckli stream and, as I lie close to the earth', 'approved', '2018-10-05 12:41:00'), -- Komentar utama pertama oleh Linsa Faith (parent_id = NULL)
(2, 1, 1, 'James Jusse', 'james@example.com', NULL, 'assets/images/team/06.jpg', 'A wonderful serenity has taken possession of my entire soul, like these sweet mornings spring which I enjoy with my whole heart', 'approved', '2018-10-05 13:15:00'); -- Reply ke komentar #1 oleh James Jusse (parent_id = 1)

-- --------------------------------------------------------
-- SECTION 3: UPDATE TABEL BLOG_POSTS (Menambahkan kolom author_id)
-- --------------------------------------------------------

--
-- Menambahkan kolom `author_id` ke tabel `blog_posts` yang sudah ada
-- Kolom ini akan menjadi Foreign Key yang menghubungkan post dengan author
-- Ini diperlukan agar setiap post bisa memiliki author detail lengkap
--

ALTER TABLE `blog_posts` -- Mengubah struktur tabel blog_posts yang sudah ada
  ADD `author_id` int(11) DEFAULT 1 AFTER `author`; -- Menambahkan kolom author_id setelah kolom author, default ke ID 1 (Robot Smith)

--
-- Catatan: Kolom `author` varchar yang lama tetap ada untuk backward compatibility.
-- Kolom `author_id` yang baru digunakan untuk relasi ke tabel blog_authors.
-- Dalam implementasi, gunakan author_id untuk mendapatkan data author lengkap.
--

-- --------------------------------------------------------
-- SECTION 4: FOREIGN KEYS & CONSTRAINTS
-- --------------------------------------------------------

--
-- Indeks untuk tabel `blog_authors`
-- Primary Key untuk memastikan setiap author punya ID unik
--

ALTER TABLE `blog_authors` -- Mengubah tabel blog_authors
  ADD PRIMARY KEY (`id`), -- Menambahkan Primary Key pada kolom id
  ADD UNIQUE KEY `slug` (`slug`), -- Menambahkan Unique Key pada slug (tidak boleh ada slug yang sama)
  ADD UNIQUE KEY `email` (`email`); -- Menambahkan Unique Key pada email (tidak boleh ada email yang sama)

--
-- Indeks untuk tabel `blog_comments`
-- Primary Key dan Foreign Keys untuk relasi data
--

ALTER TABLE `blog_comments` -- Mengubah tabel blog_comments
  ADD PRIMARY KEY (`id`), -- Menambahkan Primary Key pada kolom id
  ADD KEY `post_id` (`post_id`), -- Menambahkan Index pada post_id untuk performa query
  ADD KEY `parent_id` (`parent_id`), -- Menambahkan Index pada parent_id untuk query nested comments
  ADD KEY `status` (`status`); -- Menambahkan Index pada status untuk filter komentar approved/pending

--
-- AUTO_INCREMENT untuk tabel yang di-dump
-- Mengatur nilai awal auto increment untuk ID
--

ALTER TABLE `blog_authors` -- Mengubah tabel blog_authors
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3; -- Set id sebagai Auto Increment, mulai dari 3 (karena sudah ada 2 record)

ALTER TABLE `blog_comments` -- Mengubah tabel blog_comments
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3; -- Set id sebagai Auto Increment, mulai dari 3 (karena sudah ada 2 record)

--
-- Constraint untuk tabel `blog_comments`
-- Menambahkan Foreign Key constraints untuk menjaga integritas data
--

ALTER TABLE `blog_comments` -- Mengubah tabel blog_comments
  ADD CONSTRAINT `fk_comment_post` -- Membuat constraint bernama fk_comment_post
    FOREIGN KEY (`post_id`) -- Kolom post_id adalah Foreign Key
    REFERENCES `blog_posts` (`id`) -- Merujuk ke kolom id di tabel blog_posts
    ON DELETE CASCADE -- Jika post dihapus, semua comment di post itu juga ikut terhapus
    ON UPDATE CASCADE, -- Jika ID post diupdate, otomatis update di comments juga
  ADD CONSTRAINT `fk_comment_parent` -- Membuat constraint bernama fk_comment_parent
    FOREIGN KEY (`parent_id`) -- Kolom parent_id adalah Foreign Key
    REFERENCES `blog_comments` (`id`) -- Merujuk ke kolom id di tabel blog_comments sendiri (self-referencing)
    ON DELETE CASCADE -- Jika parent comment dihapus, semua reply-nya ikut terhapus
    ON UPDATE CASCADE; -- Jika ID parent diupdate, otomatis update di child comments

--
-- Constraint untuk tabel `blog_posts`  
-- Menghubungkan post dengan author
--

ALTER TABLE `blog_posts` -- Mengubah tabel blog_posts
  ADD CONSTRAINT `fk_post_author` -- Membuat constraint bernama fk_post_author
    FOREIGN KEY (`author_id`) -- Kolom author_id adalah Foreign Key
    REFERENCES `blog_authors` (`id`) -- Merujuk ke kolom id di tabel blog_authors
    ON DELETE SET NULL -- Jika author dihapus, author_id di post menjadi NULL (post tidak ikut terhapus)
    ON UPDATE CASCADE; -- Jika ID author diupdate, otomatis update di posts juga

-- --------------------------------------------------------
-- SECTION 5: VIEWS (Opsional) - View untuk mempermudah query
-- --------------------------------------------------------

--
-- View: `blog_post_with_author`
-- Deskripsi: View ini menggabungkan data post dengan author secara otomatis.
-- Memudahkan query untuk menampilkan post beserta info author lengkap
-- di halaman blog-single.php tanpa harus JOIN manual.
--

CREATE OR REPLACE VIEW `blog_post_with_author` AS -- Membuat atau replace view bernama blog_post_with_author
SELECT  -- Memilih kolom-kolom yang akan dimunculkan di view
    p.id, -- ID post dari tabel blog_posts
    p.title, -- Judul post
    p.slug, -- Slug post
    p.image, -- Gambar post
    p.content, -- Konten post
    p.excerpt, -- Ringkasan post
    p.published_at, -- Tanggal publish
    p.comment_count, -- Jumlah komentar
    p.type, -- Tipe post (standard/video/quote/slide)
    p.video_url, -- URL video (jika ada)
    p.quote_text, -- Text quote (jika ada)
    a.id AS author_id, -- ID author
    a.name AS author_name, -- Nama author
    a.slug AS author_slug, -- Slug author
    a.email AS author_email, -- Email author
    a.avatar AS author_avatar, -- Foto author
    a.bio AS author_bio, -- Bio author
    a.twitter AS author_twitter, -- Twitter author
    a.behance AS author_behance, -- Behance author
    a.instagram AS author_instagram, -- Instagram author
    a.vimeo AS author_vimeo, -- Vimeo author
    a.linkedin AS author_linkedin -- LinkedIn author
FROM `blog_posts` p -- Dari tabel blog_posts dengan alias p
LEFT JOIN `blog_authors` a ON p.author_id = a.id; -- LEFT JOIN dengan blog_authors agar post tanpa author tetap muncul

--
-- View: `blog_comments_with_replies`
-- Deskripsi: View ini menampilkan komentar beserta info parent comment (jika ada).
-- Memudahkan untuk menampilkan nested comments di halaman blog-single.php
--

CREATE OR REPLACE VIEW `blog_comments_with_replies` AS -- Membuat atau replace view bernama blog_comments_with_replies
SELECT -- Memilih kolom-kolom yang akan dimunculkan di view
    c.id, -- ID komentar
    c.post_id, -- ID post yang dikomentari
    c.parent_id, -- ID parent comment (NULL jika komentar utama)
    c.author_name, -- Nama pemberi komentar
    c.author_email, -- Email pemberi komentar
    c.author_website, -- Website pemberi komentar
    c.author_avatar, -- Avatar pemberi komentar
    c.content, -- Isi komentar
    c.status, -- Status komentar (pending/approved/spam)
    c.created_at, -- Waktu komentar dibuat
    c.updated_at, -- Waktu komentar diupdate
    p.author_name AS parent_author_name, -- Nama author dari parent comment
    p.created_at AS parent_created_at -- Waktu parent comment dibuat
FROM `blog_comments` c -- Dari tabel blog_comments dengan alias c
LEFT JOIN `blog_comments` p ON c.parent_id = p.id; -- LEFT JOIN dengan dirinya sendiri untuk mendapat info parent comment

COMMIT; -- Commit semua perubahan database

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */; -- Restore setting character set client
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */; -- Restore setting character set results
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */; -- Restore setting collation

-- ========================================================================
-- END OF FILE
-- ========================================================================
-- 
-- CATATAN PENGGUNAAN:
-- 
-- 1. File ini HARUS dijalankan SETELAH blog.sql
-- 2. Untuk menampilkan blog post dengan author di blog-single.php:
--    SELECT * FROM blog_post_with_author WHERE slug = 'slug-artikel'
--
-- 3. Untuk menampilkan komentar (termasuk replies):
--    SELECT * FROM blog_comments_with_replies 
--    WHERE post_id = 1 AND status = 'approved' 
--    ORDER BY created_at ASC
--
-- 4. Untuk insert komentar baru:
--    INSERT INTO blog_comments (post_id, author_name, author_email, content) 
--    VALUES (1, 'Nama', 'email@example.com', 'Isi komentar')
--
-- 5. Untuk insert reply ke komentar:
--    INSERT INTO blog_comments (post_id, parent_id, author_name, author_email, content)
--    VALUES (1, 1, 'Nama', 'email@example.com', 'Isi balasan')
--
-- ========================================================================
