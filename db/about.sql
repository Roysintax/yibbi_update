-- Membuka dan menggunakan Database yibbi_db
-- Pastikan database yibbi_db sudah dibuat sebelumnya
USE yibbi_db;

-- ================================================================
-- Bagian 1: Tabel Pengaturan Halaman About (About Settings)
-- Menyimpan judul header dan breadcrumb halaman about
-- ================================================================

-- Menghapus tabel about_settings jika sudah ada sebelumnya
DROP TABLE IF EXISTS `about_settings`;

-- Membuat tabel about_settings
CREATE TABLE `about_settings` (
  -- Kolom id sebagai primary key
  `id` int(11) NOT NULL AUTO_INCREMENT,
  -- Kolom header_title untuk judul besar di banner atas (Misal: About Our Hafsa)
  `header_title` varchar(255) DEFAULT NULL,
  -- Kolom header_breadcrumb untuk teks breadcrumb aktif (Misal: About)
  `header_breadcrumb` varchar(100) DEFAULT NULL,
  -- Primary key
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Memasukkan data dummy untuk about_settings
INSERT INTO `about_settings` (`id`, `header_title`, `header_breadcrumb`) VALUES
(
  1, 
  'About Our Hafsa', 
  'About'
);


-- ================================================================
-- Bagian 2: Tabel Konten Utama About (History Section)
-- Menyimpan konten 'About Our History'
-- ================================================================

-- Menghapus tabel about_history jika sudah ada
DROP TABLE IF EXISTS `about_history`;

-- Membuat tabel about_history (sebelumnya about_main_content)
CREATE TABLE `about_history` (
  -- Kolom id
  `id` int(11) NOT NULL AUTO_INCREMENT,
  -- Kolom sub_title (Judul kecil di atas)
  `sub_title` varchar(255) DEFAULT NULL,
  -- Kolom main_title (Judul utama yang besar)
  `main_title` varchar(255) DEFAULT NULL,
  -- Kolom highlight_text (Teks tebal/janji)
  `highlight_text` varchar(255) DEFAULT NULL,
  -- Kolom description (Deskripsi paragraf)
  `description` text DEFAULT NULL,
  -- Kolom button_text (Teks tombol aksi)
  `button_text` varchar(100) DEFAULT NULL,
  -- Kolom button_link (Link tujuan tombol)
  `button_link` varchar(255) DEFAULT '#',
  -- Kolom image_main (Gambar utama samping)
  `image_main` varchar(255) DEFAULT NULL,
  -- Primary key
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Memasukkan data dummy untuk about_history
INSERT INTO `about_history` (`id`, `sub_title`, `main_title`, `highlight_text`, `description`, `button_text`, `button_link`, `image_main`) VALUES
(
  1, 
  'About Our History', 
  'Islamic Center For Muslims To Achieve Spiritual Goals', 
  'Our Promise To Uphold The Trust Placed.', 
  'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Modi molestias culpa reprehenderit delectus, ullam harum, voluptatum numquam ati nesciunt odit quis corrupti magni quam consequatur sint ipsum tecto exercitationem, illo quisquam. Reprehenderit ut placeat cum adantium nam magnam blanditiis sequi modi! Nesciunt, repudiandae eos eniam quod maxime corrupti eligendi ea in animi.',
  'Ask About Islam', 
  'https://wa.me/628123456789', 
  'assets/images/about/02.png'
);


-- ================================================================
-- Bagian 3: Tabel Fitur About (About Features)
-- Menyimpan 4 kartu fitur (Quran Studies, dll.)
-- ================================================================

-- Menghapus tabel about_features jika sudah ada
DROP TABLE IF EXISTS `about_features`;

-- Membuat tabel about_features
CREATE TABLE `about_features` (
  -- Kolom id
  `id` int(11) NOT NULL AUTO_INCREMENT,
  -- Kolom title (Judul fitur)
  `title` varchar(255) NOT NULL,
  -- Kolom description (Deskripsi pendek fitur)
  `description` text DEFAULT NULL,
  -- Kolom image (Gambar ikon fitur)
  `image` varchar(255) DEFAULT NULL,
  -- Kolom button_text (Teks tombol, misal: Donate Now)
  `button_text` varchar(100) DEFAULT NULL,
  -- Kolom button_link (Link tujuan tombol)
  `button_link` varchar(255) DEFAULT '#',
  -- Primary key
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Memasukkan data dummy untuk about_features
INSERT INTO `about_features` (`title`, `description`, `image`, `button_text`) VALUES
-- Fitur 1
('Quran Studies', 'Lorem ipsum dolor sit, amet is consectetur adipisicing elit.Its expedita porro natus', 'assets/images/feature/01.png', 'Sponsor Now!'),
-- Fitur 2
('Islamic Classes', 'Lorem ipsum dolor sit, amet is consectetur adipisicing elit.Its expedita porro natus', 'assets/images/feature/02.png', 'Donate Now!'),
-- Fitur 3
('Islamic Awareness', 'Lorem ipsum dolor sit, amet is consectetur adipisicing elit.Its expedita porro natus', 'assets/images/feature/03.png', 'Join Us!'),
-- Fitur 4
('Islamic Services', 'Lorem ipsum dolor sit, amet is consectetur adipisicing elit.Its expedita porro natus', 'assets/images/feature/04.png', 'Get Involved!');


-- ================================================================
-- Bagian 4: Tabel Ulama/Tim (Scholars)
-- Menyimpan data anggota tim ulama
-- ================================================================

-- Menghapus tabel scholars jika sudah ada
DROP TABLE IF EXISTS `scholars`;

-- Membuat tabel scholars
CREATE TABLE `scholars` (
  -- Kolom id
  `id` int(11) NOT NULL AUTO_INCREMENT,
  -- Kolom name (Nama ulama)
  `name` varchar(255) NOT NULL,
  -- Kolom title (Gelar/Jabatan)
  `title` varchar(255) DEFAULT NULL,
  -- Kolom image (Foto profil)
  `image` varchar(255) DEFAULT NULL,
  -- Link sosial media (default # jika tidak ada)
  `social_twitter` varchar(255) DEFAULT '#',
  `social_behance` varchar(255) DEFAULT '#',
  `social_instagram` varchar(255) DEFAULT '#',
  `social_vimeo` varchar(255) DEFAULT '#',
  `social_linkedin` varchar(255) DEFAULT '#',
  -- Primary key
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Memasukkan data dummy scholars
INSERT INTO `scholars` (`name`, `title`, `image`) VALUES
('Hamad Bin Jasim', 'Hafiz Quran Scholor', 'assets/images/team/01.jpg'),
('Sayyida Al-Hijaazi', 'Hafiz Quran Scholor', 'assets/images/team/02.jpg'),
('Ashraf Al-Maktum', 'Hafiz Quran Scholor', 'assets/images/team/03.jpg'),
('Ayesha Binte Alif', 'Hafiz Quran Scholor', 'assets/images/team/04.jpg');


-- ================================================================
-- Bagian 5: Tabel Kutipan (About Quote)
-- Menyimpan kutipan motivasi/hadits
-- ================================================================

-- Menghapus tabel about_quote jika sudah ada
DROP TABLE IF EXISTS `about_quote`;

-- Membuat tabel about_quote
CREATE TABLE `about_quote` (
  -- Kolom id
  `id` int(11) NOT NULL AUTO_INCREMENT,
  -- Kolom quote_text (Isi kutipan)
  `quote_text` text NOT NULL,
  -- Kolom quote_author (Penulis/Sumber kutipan utama, misal: Hazrat Mohammod (s) Said)
  `quote_author` varchar(255) DEFAULT NULL,
  -- Kolom quote_source (Referensi tambahan, misal: Riyadh-Us-Saleheen...)
  `quote_source` varchar(255) DEFAULT NULL,
  -- Kolom is_active (Status aktif/tidak)
  `is_active` tinyint(1) DEFAULT 1,
  -- Primary key
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Memasukkan data dummy quote
INSERT INTO `about_quote` (`quote_text`, `quote_author`, `quote_source`) VALUES
(
  '"It is Better For Any Of You To Carry A Load Of Firewood On His Own Back Than To Beg From Someone Else"', 
  'Hazrat Mohammod (s) Said', 
  'Riyadh-Us-Saleheen, Chapter 59, hadith 540'
);


-- ================================================================
-- Bagian 6: Tabel Rukun Islam (Faith / Pillars of Islam)
-- Menyimpan data tab Shahadah, Salaah, dll.
-- ================================================================

-- Menghapus tabel about_faith jika sudah ada
DROP TABLE IF EXISTS `about_faith`;

-- Membuat tabel about_faith
CREATE TABLE `about_faith` (
  -- Kolom id
  `id` int(11) NOT NULL AUTO_INCREMENT,
  -- Kolom identifier (ID unik untuk tab HTML, misal: shahadah, prayer)
  `identifier` varchar(50) NOT NULL,
  -- Kolom title (Judul rukun, misal: Shahadah)
  `title` varchar(100) NOT NULL,
  -- Kolom subtitle (Subjudul dalam kurung, misal: Faith)
  `subtitle` varchar(100) DEFAULT NULL,
  -- Kolom description (Penjelasan rukun)
  `description` text DEFAULT NULL,
  -- Kolom image (Gambar ilustrasi rukun)
  `image` varchar(255) DEFAULT NULL,
  -- Kolom icon (Ikon kecil untuk navigasi tab)
  `icon` varchar(255) DEFAULT NULL,
  -- Kolom order_index (Urutan tampilan)
  `order_index` int(11) DEFAULT 0,
  -- Primary key
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Memasukkan data dummy rukun islam
INSERT INTO `about_faith` (`identifier`, `title`, `subtitle`, `description`, `image`, `icon`, `order_index`) VALUES
('shahadah', 'Shahadah', 'Faith', 'The Shahadah, is an Islamic creed, one of the Five Pillars of Islam and part of the Adhan. It reads: "I bear witness that there is no deity but God, and I bear witness that Muhammad is the messenger of God."', 'assets/images/faith/01.png', 'assets/images/faith/faith-icons/01.png', 1),
('prayer', 'Salaah', 'Prayer', 'Each Muslim should pray five times a day: in the morning, at noon, in the afternoon, after sunset, and early at night.', 'assets/images/faith/02.png', 'assets/images/faith/faith-icons/02.png', 2),
('ramadan', 'Sawm', 'Fasting', 'Each Muslim should pray five times a day: in the morning, at noon, in the afternoon, after sunset, and early at night.', 'assets/images/faith/03.png', 'assets/images/faith/faith-icons/03.png', 3),
('jakat', 'Zakat', 'Almsgiving', 'Each Muslim should pray five times a day: in the morning, at noon, in the afternoon, after sunset, and early at night.', 'assets/images/faith/04.png', 'assets/images/faith/faith-icons/04.png', 4),
('hajj', 'Hajj', 'Pilgrimage', 'Each Muslim should pray five times a day: in the morning, at noon, in the afternoon, after sunset, and early at night.', 'assets/images/faith/05.png', 'assets/images/faith/faith-icons/05.png', 5);
