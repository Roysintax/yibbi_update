-- Membuka Database yibbi_db untuk memastikan tabel dibuat di database yang benar
-- (Pastikan Anda sudah membuat database yibbi_db sebelumnya)
USE yibbi_db;

-- ================================================================
-- Bagian 1: Tabel Pengaturan Halaman Kontak (Contact Settings)
-- Menyimpan judul, deskripsi, dan URL peta Google Maps
-- ================================================================

-- Menghapus tabel contact_settings jika sudah ada sebelumnya agar tidak terjadi error saat pembuatan ulang
DROP TABLE IF EXISTS `contact_settings`;

-- Membuat struktur tabel contact_settings
CREATE TABLE `contact_settings` (
  -- Kolom id sebagai primary key (kunci utama) yang unik untuk setiap baris
  `id` int(11) NOT NULL AUTO_INCREMENT,
  -- Kolom header_title untuk menyimpn judul di bagian header halaman (Banner atas)
  `header_title` varchar(255) DEFAULT NULL,
  -- Kolom form_title untuk menyimpan judul di atas formulir kontak
  `form_title` varchar(255) DEFAULT NULL,
  -- Kolom form_description untuk menyimpan deskripsi singkat di atas formulir kontak
  `form_description` text DEFAULT NULL,
  -- Kolom map_url untuk menyimpan URL embed dari Google Maps (iframe src)
  `map_url` text DEFAULT NULL,
  -- Menetapkan kolom id sebagai PRIMARY KEY
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Memasukkan data awal (dummy data) yang diambil dari file contact.php saat ini
INSERT INTO `contact_settings` (`id`, `header_title`, `form_title`, `form_description`, `map_url`) VALUES
(
  1, 
  'Contact us via mail', 
  'Don\'t Be A Stranger Just Say Hello.', 
  'We do fast phone repair. In most to repair your device in just minutes, li we’ll normally get con nection inutes, we’ll normally ge.', 
  'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3652.227736753981!2d90.38698831452395!3d23.739256984594892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b85c740f17d1%3A0xdd3daab8c90eb11f!2sCodexCoder!5e0!3m2!1sbn!2sbd!4v1610134370994!5m2!1sbn!2sbd'
);


-- ================================================================
-- Bagian 2: Tabel Informasi Kontak (Contact Info)
-- Menyimpan kartu informasi seperti Alamat, Telepon, Email, Website
-- ================================================================

-- Menghapus tabel contact_info jika sudah ada sebelumnya
DROP TABLE IF EXISTS `contact_info`;

-- Membuat struktur tabel contact_info
CREATE TABLE `contact_info` (
  -- Kolom id sebagai primary key
  `id` int(11) NOT NULL AUTO_INCREMENT,
  -- Kolom title untuk judul informasi (Contoh: "Office Address", "Phone Number")
  `title` varchar(100) DEFAULT NULL,
  -- Kolom description untuk isi informasi (Contoh: "1201 park street...", "+22698 745...")
  `description` varchar(255) DEFAULT NULL,
  -- Kolom icon untuk menyimpan path gambar ikon atau nama class ikon
  `icon` varchar(255) DEFAULT NULL,
  -- Kolom type untuk mengkategorikan jenis info (opsional, berguna untuk logika frontend)
  `type` enum('address', 'phone', 'email', 'website', 'other') DEFAULT 'other',
  -- Kolom order_index untuk mengatur urutan tampilan
  `order_index` int(11) DEFAULT 0,
  -- Menetapkan kolom id sebagai PRIMARY KEY
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Memasukkan data awal (dummy data) sesuai dengan 4 kotak info di contact.php
INSERT INTO `contact_info` (`title`, `description`, `icon`, `type`, `order_index`) VALUES
-- Data 1: Alamat Kantor
('Office Address', '1201 park street, Fifth Avenue', 'assets/images/contact/01.png', 'address', 1),
-- Data 2: Nomor Telepon
('Phone Number', '+22698 745 632,02 982 745', 'assets/images/contact/02.png', 'phone', 2),
-- Data 3: Kirim Email
('Send Mail', 'adminHafsa@gmil.com', 'assets/images/contact/03.png', 'email', 3),
-- Data 4: Website Kami
('Our Website', 'www.Hafsa-charity.com', 'assets/images/contact/04.png', 'website', 4);


-- ================================================================
-- Bagian 3: Tabel Pesan Kontak (Contact Messages)
-- Menyimpan pesan yang dikirim oleh pengguna melalui formulir kontak
-- ================================================================

-- Menghapus tabel contact_messages jika sudah ada
DROP TABLE IF EXISTS `contact_messages`;

-- Membuat struktur tabel contact_messages
CREATE TABLE `contact_messages` (
  -- Kolom id sebagai primary key
  `id` int(11) NOT NULL AUTO_INCREMENT,
  -- Kolom name untuk menyimpan nama pengirim
  `name` varchar(100) NOT NULL,
  -- Kolom email untuk menyimpan email pengirim
  `email` varchar(100) NOT NULL,
  -- Kolom subject untuk menyimpan subjek pesan (opsional)
  `subject` varchar(255) DEFAULT NULL,
  -- Kolom message untuk menyimpan isi pesan
  `message` text NOT NULL,
  -- Kolom created_at untuk mencatat waktu pesan dikirim (otomatis diisi waktu sekarang)
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  -- Kolom is_read untuk menandai apakah pesan pesan sudah dibaca admin (0: belum, 1: sudah)
  `is_read` tinyint(1) DEFAULT 0,
  -- Menetapkan kolom id sebagai PRIMARY KEY
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data dummy untuk tabel pesan (opsional, hanya untuk contoh)
INSERT INTO `contact_messages` (`name`, `email`, `subject`, `message`) VALUES
('User Test', 'test@example.com', 'Halo Admin', 'Ini adalah pesan tes untuk memastikan database berfungsi.');
