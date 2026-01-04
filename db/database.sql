-- ========================================================================
-- YIBBI Database - Complete Schema
-- ========================================================================
-- Database: yibbi_db
-- Description: Complete database schema untuk Yayasan YIBBI website
-- Includes: Settings, Banners, About, Features, Services, Programs, 
--           Events, Contact, Blog, Comments, etc.
-- ========================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- CREATE DATABASE
-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS `yibbi_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `yibbi_db`;

-- ========================================================================
-- SECTION 1: GENERAL SETTINGS
-- ========================================================================

-- Table: settings
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_title` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `copyright_text` text DEFAULT NULL,
  `footer_about_title` varchar(255) DEFAULT 'About Hafsa',
  `footer_about_text` text DEFAULT NULL,
  `footer_about_image` varchar(255) DEFAULT NULL,
  `whatsapp_donation` varchar(20) DEFAULT '6281234567890',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `settings` (`id`, `site_title`, `logo`, `favicon`, `phone`, `email`, `address`, `copyright_text`, `footer_about_text`, `footer_about_image`, `whatsapp_donation`) VALUES
(1, 'Hafsa Home', 'assets/images/logo/01.png', 'assets/images/x-icon/01.png', '+800-123-4567 6587', 'admin@Hafsa.com', 'Beverley, New York 224 US', '&copy;2025 <a href=\"index.html\">Yayasan YIBBI</a>', 'Energistically coordinate highly efficient procesr partnerships befor revolutionar growth strategie improvement', 'assets/images/footer/footer-middle/01.jpg', '6281234567890');

-- Table: social_media
CREATE TABLE `social_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `platform` varchar(50) NOT NULL,
  `icon_class` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order_index` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `social_media` (`id`, `platform`, `icon_class`, `url`, `is_active`, `order_index`) VALUES
(1, 'Facebook', 'fab fa-facebook-messenger', '#', 1, 1),
(2, 'Twitter', 'fab fa-twitter', '#', 1, 2),
(3, 'Vimeo', 'fab fa-vimeo-v', '#', 1, 3),
(4, 'Skype', 'fab fa-skype', '#', 1, 4),
(5, 'Wifi', 'fas fa-wifi', '#', 1, 5);

-- ========================================================================
-- SECTION 2: HOMEPAGE SECTIONS
-- ========================================================================

-- Table: banners (Hero Section)
CREATE TABLE `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` text DEFAULT NULL,
  `button_text` varchar(50) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT '#',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order_index` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `banners` (`id`, `image`, `title`, `subtitle`, `button_text`, `button_link`, `is_active`, `order_index`) VALUES
(1, 'assets/images/banner/01.png', 'And Allah Invites To The Home Of Peace', 'The most beloved actions to Allah are those performed consistently, even if they are few', 'Donate Now', '#', 1, 0);

-- Table: about_section
CREATE TABLE `about_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `mission_title` varchar(255) DEFAULT NULL,
  `mission_description` text DEFAULT NULL,
  `vision_title` varchar(255) DEFAULT NULL,
  `vision_description` text DEFAULT NULL,
  `button_text` varchar(50) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT '#',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `about_section` (`id`, `title`, `subtitle`, `description`, `image`, `mission_title`, `mission_description`, `vision_title`, `vision_description`, `button_text`, `button_link`) VALUES
(1, 'Welcome To Our Islamic Team', 'About Our Team', 'Enthusiastically recaptiualize multifunctional imperatives vis-a-vis high standards in ROI. Assertively transition economically.', 'assets/images/about/01.png', 'Our Mission', 'Continually productize compelling quality elucidated', 'Our Vision', 'Continually productize compelling quality elucidated', 'Read More', '#');

-- Table: features
CREATE TABLE `features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(500) NOT NULL,
  `button_text` varchar(100) DEFAULT 'Read More',
  `button_link` varchar(500) DEFAULT '#',
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `display_order` (`display_order`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `features` (`id`, `title`, `description`, `image`, `button_text`, `button_link`, `display_order`, `is_active`) VALUES
(1, 'Donate for Food', 'Continua scale empowered metrics with cost effective innovation', 'assets/images/feature/icon/01.png', 'Read More', '#', 1, 1),
(2, 'Scholarship fund', 'Continua scale empowered metrics with cost effective innovation', 'assets/images/feature/icon/02.png', 'Read More', '#', 2, 1),
(3, 'Become A Member', 'Continua scale empowered metrics with cost effective innovation', 'assets/images/feature/icon/03.png', 'Read More', '#', 3, 1),
(4, 'Join A Community', 'Continua scale empowered metrics with cost effective innovation', 'assets/images/feature/icon/04.png', 'Read More', '#', 4, 1);

-- Table: services
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `image` varchar(500) NOT NULL,
  `icon` varchar(500) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `display_order` (`display_order`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `services` (`id`, `title`, `subtitle`, `description`, `image`, `icon`, `display_order`, `is_active`) VALUES
(1, 'Al Quran Reading', 'Listen Our Imam Leader', 'Continually promote virtual mater athrough ethically mindshare optimal scenar myaciate team driven innovate Rapidiously myaciat', 'assets/images/services/01.jpg', 'assets/images/services/icon/01.png', 1, 1),
(2, 'Islamic Studies', 'Fiqh And Aqeedah', 'Continually promote virtual mater athrough ethically mindshare optimal scenar myaciate team driven innovate Rapidiously myaciat', 'assets/images/services/02.jpg', 'assets/images/services/icon/02.png', 2, 1),
(3, 'Learn Quran', 'From Qualified Teachers', 'Continually promote virtual mater athrough ethically mindshare optimal scenar myaciate team driven innovate Rapidiously myaciat', 'assets/images/services/03.jpg', 'assets/images/services/icon/03.png', 3, 1);

-- Table: programs
CREATE TABLE `programs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `amount_raised` decimal(10,2) DEFAULT 0.00,
  `target_amount` decimal(10,2) DEFAULT 0.00,
  `category` varchar(100) DEFAULT NULL,
  `type` enum('regular','urgent') DEFAULT 'regular',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `programs` (`id`, `title`, `description`, `image`, `amount_raised`, `target_amount`, `category`, `type`, `is_active`) VALUES
(1, 'Ramdan Food Program', 'Continually productize compelling quality for packed in business. Professionally whiteboard top-line results whereas cutting-edge competencies.', 'assets/images/campaign/01.jpg', 2545.00, 4000.00, 'Food', 'regular', 1),
(2, 'Education For All Children', 'Continually productize compelling quality for packed in business. Professionally whiteboard top-line results whereas cutting-edge competencies.', 'assets/images/campaign/02.jpg', 3257.00, 5000.00, 'Education', 'regular', 1),
(3, 'Medicine For All Children', 'Continually productize compelling quality for packed in business. Professionally whiteboard top-line results whereas cutting-edge competencies.', 'assets/images/campaign/03.jpg', 1548.00, 3500.00, 'Medical', 'regular', 1);

-- Table: faiths (Rukun Islam)
CREATE TABLE `faiths` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) NOT NULL,
  `order_index` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `faiths` (`id`, `title`, `description`, `icon`, `order_index`) VALUES
(1, 'Shahadah', 'Continually prdtize compelling quality packed Professionally Synergistically the', 'assets/images/faith/icon/01.png', 1),
(2, 'Salat', 'Continually prdtize compelling quality packed Professionally Synergistically the', 'assets/images/faith/icon/02.png', 2),
(3, 'Saom', 'Continually prdtize compelling quality packed Professionally Synergistically the', 'assets/images/faith/icon/03.png', 3),
(4, 'Zakat', 'Continually prdtize compelling quality packed Professionally Synergistically the', 'assets/images/faith/icon/04.png', 4),
(5, 'Hajj', 'Continually prdtize compelling quality packed Professionally Synergistically the', 'assets/images/faith/icon/05.png', 5);

-- Table: quotes
CREATE TABLE `quotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_text` text NOT NULL,
  `author` varchar(255) DEFAULT 'Quran',
  `background_image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `quotes` (`id`, `quote_text`, `author`, `background_image`, `is_active`) VALUES
(1, 'Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas. Dramatically maintain clicks-and-mortar functional solutions', 'Prophet Muhammad (PBUH)', 'assets/images/quote/01.jpg', 1);

-- ========================================================================
-- SECTION 3: EVENTS
-- ========================================================================

CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `event_date` datetime NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `organizer` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `events` (`id`, `title`, `description`, `image`, `event_date`, `location`, `organizer`, `category`, `is_featured`, `is_active`) VALUES
(1, 'Zakat Distribution 2025', 'Join us in our annual zakat distribution program', 'assets/images/event/01.jpg', '2025-03-15 10:00:00', 'Main Hall', 'Islamic Center', 'Charity', 1, 1),
(2, 'Quran Recitation Contest', 'Annual Quran recitation competition for all ages', 'assets/images/event/02.jpg', '2025-04-20 14:00:00', 'Auditorium', 'Youth Committee', 'Education', 1, 1),
(3, 'Iftar Program', 'Community iftar during Ramadan', 'assets/images/event/03.jpg', '2025-05-10 18:30:00', 'Community Center', 'Mosque Committee', 'Community', 0, 1),
(4, 'Islamic Finance Workshop', 'Learn about Islamic banking and finance', 'assets/images/event/04.jpg', '2025-06-05 09:00:00', 'Conference Room', 'Education Team', 'Workshop', 0, 1);

-- ========================================================================
-- SECTION 4: CONTACT
-- ========================================================================

CREATE TABLE `contact_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header_title` varchar(255) DEFAULT 'Contact us via mail',
  `form_title` varchar(255) DEFAULT 'Don''t Be A Stranger Just Say Hello.',
  `form_description` text DEFAULT NULL,
  `map_url` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `contact_settings` (`id`, `header_title`, `form_title`, `form_description`, `map_url`) VALUES
(1, 'Contact us via mail', 'Don''t Be A Stranger Just Say Hello.', 'We do fast phone repair. In most of the cases we can repair your device in just minutes.', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.666742540389!2d106.82493937475534!3d-6.175392393814705!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5d2e5e6e471%3A0x3d2ad6e1e0e9bcc8!2sJakarta!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid');

CREATE TABLE `contact_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `order_index` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `contact_info` (`id`, `icon`, `title`, `description`, `order_index`) VALUES
(1, 'assets/images/contact/icon/01.png', 'Office Address', '1201 park street, Fifth Avenue', 1),
(2, 'assets/images/contact/icon/02.png', 'Phone Number', '+800-123-4567 6587', 2),
(3, 'assets/images/contact/icon/03.png', 'Send Email', 'admin@hafsa.com', 3),
(4, 'assets/images/contact/icon/04.png', 'Our Website', 'www.hafsa.com', 4);

-- ========================================================================
-- SECTION 5: BLOG SYSTEM
-- ========================================================================

-- Table: blog_categories
CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text,
  `count` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `description`, `count`) VALUES
(1, 'Islamic Studies', 'islamic-studies', 'Articles about Islamic education and studies', 15),
(2, 'Community', 'community', 'Community events and activities', 23),
(3, 'Charity', 'charity', 'Charity programs and initiatives', 18);

-- Table: blog_tags
CREATE TABLE `blog_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `blog_tags` (`id`, `name`, `slug`) VALUES
(1, 'Quran', 'quran'),
(2, 'Hadith', 'hadith'),
(3, 'Ramadan', 'ramadan'),
(4, 'Charity', 'charity'),
(5, 'Education', 'education'),
(6, 'Community', 'community');

-- Table: blog_authors
CREATE TABLE `blog_authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `email` varchar(100),
  `bio` text,
  `avatar` varchar(255) DEFAULT 'assets/images/author/default.jpg',
  `twitter` varchar(50),
  `behance` varchar(50),
  `instagram` varchar(50),
  `vimeo` varchar(50),
  `linkedin` varchar(50),
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `blog_authors` (`id`, `name`, `slug`, `email`, `bio`, `avatar`) VALUES
(1, 'Rassel Hossain', 'rassel-hossain', 'rassel@hafsa.com', 'Islamic scholar and community leader', 'assets/images/author/01.jpg');

-- Table: blog_posts
CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text,
  `content` longtext NOT NULL,
  `image` varchar(255),
  `author` varchar(100) DEFAULT 'Admin',
  `author_id` int(11) DEFAULT NULL,
  `published_at` datetime DEFAULT current_timestamp(),
  `comment_count` int(11) DEFAULT 0,
  `type` enum('standard','slide','video','quote') DEFAULT 'standard',
  `video_url` varchar(500),
  `quote_text` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_author` (`author_id`),
  CONSTRAINT `fk_author` FOREIGN KEY (`author_id`) REFERENCES `blog_authors` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `excerpt`, `content`, `image`, `author`, `author_id`, `published_at`, `comment_count`, `type`) VALUES
(1, 'Continually Proactive Services Through Business', 'continually-proactive-services', 'Seamlessly visualize quality intellectual capital without superior collaboration and idea-sharing.', '<p>Seamlessly visualize quality intellectual capital without superior collaboration and idea-sharing. Holistically pontificate installed base portals after maintainable products.</p>', 'assets/images/blog/01.jpg', 'Admin', 1, '2025-01-03 10:00:00', 3, 'standard');

-- Table: blog_post_categories
CREATE TABLE `blog_post_categories` (
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`category_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `blog_post_categories_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blog_post_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `blog_post_categories` (`post_id`, `category_id`) VALUES (1, 1);

-- Table: blog_post_tags
CREATE TABLE `blog_post_tags` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`tag_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `blog_post_tags_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blog_post_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `blog_tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `blog_post_tags` (`post_id`, `tag_id`) VALUES (1, 1), (1, 2);

-- Table: blog_comments
CREATE TABLE `blog_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `author_name` varchar(100) NOT NULL,
  `author_email` varchar(100) NOT NULL,
  `author_website` varchar(255),
  `author_avatar` varchar(255) DEFAULT 'assets/images/blog/author/01.jpg',
  `content` text NOT NULL,
  `status` enum('pending','approved','spam') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `blog_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blog_comments_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `blog_comments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================================================
-- SECTION 6: ABOUT HISTORY
-- ========================================================================

CREATE TABLE `about_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `achievements_title` varchar(255) DEFAULT 'Our Achievements',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `about_history` (`id`, `title`, `subtitle`, `description`, `image`, `achievements_title`) VALUES
(1, 'Our History', 'Since 1990', 'Yayasan YIBBI has been serving the community for over 30 years with dedication and commitment to Islamic values.', 'assets/images/about/history.jpg', 'Our Achievements');

CREATE TABLE `about_achievements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) NOT NULL,
  `number` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `order_index` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `about_achievements` (`id`, `icon`, `number`, `title`, `order_index`) VALUES
(1, 'assets/images/about/icon/01.png', '30+', 'Years of Service', 1),
(2, 'assets/images/about/icon/02.png', '5000+', 'Community Members', 2),
(3, 'assets/images/about/icon/03.png', '100+', 'Programs', 3);

-- ========================================================================
-- AUTO INCREMENT RESET
-- ========================================================================

ALTER TABLE `settings` AUTO_INCREMENT=2;
ALTER TABLE `social_media` AUTO_INCREMENT=6;
ALTER TABLE `banners` AUTO_INCREMENT=2;
ALTER TABLE `about_section` AUTO_INCREMENT=2;
ALTER TABLE `features` AUTO_INCREMENT=5;
ALTER TABLE `services` AUTO_INCREMENT=4;
ALTER TABLE `programs` AUTO_INCREMENT=4;
ALTER TABLE `faiths` AUTO_INCREMENT=6;
ALTER TABLE `quotes` AUTO_INCREMENT=2;
ALTER TABLE `events` AUTO_INCREMENT=5;
ALTER TABLE `contact_settings` AUTO_INCREMENT=2;
ALTER TABLE `contact_info` AUTO_INCREMENT=5;
ALTER TABLE `blog_categories` AUTO_INCREMENT=4;
ALTER TABLE `blog_tags` AUTO_INCREMENT=7;
ALTER TABLE `blog_authors` AUTO_INCREMENT=2;
ALTER TABLE `blog_posts` AUTO_INCREMENT=2;
ALTER TABLE `blog_comments` AUTO_INCREMENT=1;
ALTER TABLE `about_history` AUTO_INCREMENT=2;
ALTER TABLE `about_achievements` AUTO_INCREMENT=4;

COMMIT;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- ========================================================================
-- SECTION 7: COMING SOON
-- ========================================================================

CREATE TABLE IF NOT EXISTS `coming_soon_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT 'Coming Soon',
  `logo` varchar(255) DEFAULT 'assets/images/logo/01.png',
  `target_date` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `coming_soon_settings` (`id`, `title`, `logo`, `target_date`, `is_active`) VALUES
(1, 'Coming Soon', 'assets/images/logo/01.png', '2025-12-31 23:59:59', 1);


-- ========================================================================
-- SECTION 8: CONTACT MESSAGES
-- ========================================================================

CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ========================================================================
-- SECTION 9: DONATION SYSTEM
-- ========================================================================

CREATE TABLE IF NOT EXISTS `payment_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(100) NOT NULL COMMENT 'Nama bank atau e-wallet (BCA, BNI, Mandiri, Gopay, dll)',
  `account_number` varchar(50) NOT NULL COMMENT 'Nomor rekening atau nomor e-wallet',
  `account_name` varchar(100) NOT NULL COMMENT 'Nama pemilik rekening',
  `account_type` enum('bank','ewallet') NOT NULL DEFAULT 'bank' COMMENT 'Jenis akun pembayaran',
  `icon` varchar(255) DEFAULT NULL COMMENT 'Path ke icon bank/ewallet',
  `display_order` int(11) DEFAULT 0 COMMENT 'Urutan tampilan',
  `is_active` tinyint(1) DEFAULT 1 COMMENT 'Status aktif',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `display_order` (`display_order`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Data rekening pembayaran untuk donasi';

INSERT INTO `payment_accounts` (`id`, `bank_name`, `account_number`, `account_name`, `account_type`, `display_order`, `is_active`) VALUES
(1, 'BCA', '1234567890', 'Yayasan YIBBI', 'bank', 1, 1),
(2, 'BNI', '0987654321', 'Yayasan YIBBI', 'bank', 2, 1),
(3, 'Mandiri', '1122334455', 'Yayasan YIBBI', 'bank', 3, 1),
(4, 'GoPay', '081234567890', 'Yayasan YIBBI', 'ewallet', 4, 1);

CREATE TABLE IF NOT EXISTS `donations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `donor_name` varchar(100) NOT NULL COMMENT 'Nama donatur',
  `donor_email` varchar(100) DEFAULT NULL COMMENT 'Email donatur',
  `donor_phone` varchar(20) DEFAULT NULL COMMENT 'Nomor HP donatur',
  `payment_account_id` int(11) NOT NULL COMMENT 'ID rekening tujuan transfer',
  `amount` decimal(10,2) NOT NULL COMMENT 'Jumlah donasi',
  `payment_proof` varchar(255) NOT NULL COMMENT 'Path ke bukti pembayaran',
  `message` text DEFAULT NULL COMMENT 'Pesan dari donatur (optional)',
  `status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending' COMMENT 'Status verifikasi donasi',
  `admin_notes` text DEFAULT NULL COMMENT 'Catatan dari admin',
  `verified_at` datetime DEFAULT NULL COMMENT 'Waktu verifikasi',
  `verified_by` int(11) DEFAULT NULL COMMENT 'Admin yang verifikasi',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `payment_account_id` (`payment_account_id`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`),
  CONSTRAINT `fk_donations_payment_account` FOREIGN KEY (`payment_account_id`) REFERENCES `payment_accounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Data donasi dari donatur';


-- ========================================================================
-- SECTION 10: VIEWS
-- ========================================================================

CREATE OR REPLACE VIEW `blog_post_with_author` AS
SELECT 
    p.id, p.title, p.slug, p.image, p.content, p.excerpt, p.published_at, p.comment_count, 
    p.type, p.video_url, p.quote_text,
    a.id AS author_id, a.name AS author_name, a.slug AS author_slug, a.email AS author_email, 
    a.avatar AS author_avatar, a.bio AS author_bio, a.twitter AS author_twitter, 
    a.behance AS author_behance, a.instagram AS author_instagram, a.vimeo AS author_vimeo, 
    a.linkedin AS author_linkedin
FROM `blog_posts` p
LEFT JOIN `blog_authors` a ON p.author_id = a.id;

CREATE OR REPLACE VIEW `blog_comments_with_replies` AS
SELECT 
    c.id, c.post_id, c.parent_id, c.author_name, c.author_email, c.author_website, 
    c.author_avatar, c.content, c.status, c.created_at, c.updated_at,
    p.author_name AS parent_author_name, p.created_at AS parent_created_at
FROM `blog_comments` c
LEFT JOIN `blog_comments` p ON c.parent_id = p.id;

-- ========================================================================
-- SECTION 11: SCHOLARS
-- ========================================================================

CREATE TABLE IF NOT EXISTS `scholars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `detail_image` varchar(255) DEFAULT NULL COMMENT 'Larger image for single page',
  `bio` text DEFAULT NULL COMMENT 'Short intro paragraph',
  `personal_statement` text DEFAULT NULL COMMENT 'Longer personal statement',
  `scholar_address` varchar(255) DEFAULT NULL,
  `scholar_email` varchar(255) DEFAULT NULL,
  `scholar_phone` varchar(50) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `language_skills` text DEFAULT NULL COMMENT 'JSON: [{"name":"English","percent":80},...]',
  `awards` text DEFAULT NULL COMMENT 'JSON: [{"image":"path","year":"2016"},...]',
  `social_twitter` varchar(255) DEFAULT '#',
  `social_behance` varchar(255) DEFAULT '#',
  `social_instagram` varchar(255) DEFAULT '#',
  `social_vimeo` varchar(255) DEFAULT '#',
  `social_linkedin` varchar(255) DEFAULT '#',
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `scholars` (`id`, `name`, `title`, `image`, `detail_image`, `bio`, `personal_statement`, `scholar_address`, `scholar_email`, `scholar_phone`, `website`, `language_skills`, `awards`, `display_order`, `is_active`) VALUES
(1, 'Hamad Bin Jasim', 'Hafiz Quran Scholor', 'assets/images/team/01.jpg', 'assets/images/team/team-single.jpg', 'Enthusias expedite client-focused growth strategies whereas a client-centered infrastructur intrinsicl grow optimal e-tailers or rather than effective information.', 'Expedite client-focused growth strateges whereas client centere infrastruc. Intrinsicly grow optimal anetailers rather than effective information ollaboratv optimize andin partnerships and hamres frictionless deliverable roactively.', 'Suite 2 & 7, Melbourne, Australia', 'hamad@example.com', '+021 548 736 982', 'www.example.com', '[{"name":"English","percent":80},{"name":"Arabic","percent":90},{"name":"Urdu","percent":70}]', '[{"image":"assets/images/team/award/01.png","year":"Award 2016"},{"image":"assets/images/team/award/02.png","year":"Award 2017"},{"image":"assets/images/team/award/03.png","year":"Award 2018"}]', 1, 1),
(2, 'Sayyida Al-Hijaazi', 'Hafiz Quran Scholor', 'assets/images/team/02.jpg', 'assets/images/team/team-single.jpg', 'A dedicated scholar with expertise in Islamic studies and Quranic teachings.', 'Passionate about spreading knowledge and guiding the community towards spiritual growth.', 'New York, USA', 'sayyida@example.com', '+1 234 567 890', 'www.example.com', '[{"name":"English","percent":85},{"name":"Arabic","percent":95},{"name":"French","percent":60}]', '[{"image":"assets/images/team/award/01.png","year":"Award 2017"}]', 2, 1),
(3, 'Ashraf Al-Maktum', 'Hafiz Quran Scholor', 'assets/images/team/03.jpg', 'assets/images/team/team-single.jpg', 'Enthusias expedite client-focused growth strategies whereas a client-centered infrastructur.', 'Expedite client-focused growth strateges whereas client centere infrastruc Intrinsicly grow optimal anetailers.', 'Suite 2 & 7, Melbourne, Australia', 'ashrafalmuktag@gmail.com', '+021 548 736 982', 'www.admintheking.com', '[{"name":"English","percent":80},{"name":"Hindi","percent":70},{"name":"Bangla","percent":60}]', '[{"image":"assets/images/team/award/01.png","year":"Award 2016"},{"image":"assets/images/team/award/02.png","year":"Award 2017"},{"image":"assets/images/team/award/03.png","year":"Award 2018"}]', 3, 1),
(4, 'Ayesha Binte Alif', 'Hafiz Quran Scholor', 'assets/images/team/04.jpg', 'assets/images/team/team-single.jpg', 'Expert in Quranic recitation and Islamic jurisprudence.', 'Dedicated to teaching and preserving Islamic traditions for future generations.', 'Dubai, UAE', 'ayesha@example.com', '+971 50 123 4567', 'www.example.com', '[{"name":"Arabic","percent":95},{"name":"English","percent":75},{"name":"Urdu","percent":85}]', '[{"image":"assets/images/team/award/02.png","year":"Award 2019"}]', 4, 1),
(5, 'Hamad Bin Jasim', 'Hafiz Quran Scholor', 'assets/images/team/05.jpg', 'assets/images/team/team-single.jpg', 'Senior scholar with decades of experience.', 'Committed to community service and education.', 'London, UK', 'hamad2@example.com', '+44 20 1234 5678', 'www.example.com', '[{"name":"English","percent":90},{"name":"Arabic","percent":85}]', '[]', 5, 1),
(6, 'Sayyida Al-Hijaazi', 'Hafiz Quran Scholor', 'assets/images/team/06.jpg', 'assets/images/team/team-single.jpg', 'Renowned teacher and mentor.', 'Focused on youth education and empowerment.', 'Cairo, Egypt', 'sayyida2@example.com', '+20 2 1234 5678', 'www.example.com', '[{"name":"Arabic","percent":95},{"name":"English","percent":70}]', '[]', 6, 1),
(7, 'Ashraf Al-Maktum', 'Hafiz Quran Scholor', 'assets/images/team/07.jpg', 'assets/images/team/team-single.jpg', 'Specialist in Tajweed and Quranic sciences.', 'Passionate about preserving the art of Quranic recitation.', 'Istanbul, Turkey', 'ashraf2@example.com', '+90 212 123 4567', 'www.example.com', '[{"name":"Turkish","percent":90},{"name":"Arabic","percent":85},{"name":"English","percent":65}]', '[]', 7, 1),
(8, 'Ayesha Binte Alif', 'Hafiz Quran Scholor', 'assets/images/team/08.jpg', 'assets/images/team/team-single.jpg', 'Expert in womens Islamic education.', 'Leading initiatives for female scholars worldwide.', 'Kuala Lumpur, Malaysia', 'ayesha2@example.com', '+60 3 1234 5678', 'www.example.com', '[{"name":"Malay","percent":95},{"name":"Arabic","percent":80},{"name":"English","percent":75}]', '[]', 8, 1);


-- ========================================================================
-- SECTION 12: GALLERY (NEW)
-- ========================================================================

CREATE TABLE IF NOT EXISTS `gallery_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `display_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `gallery_categories` (`id`, `name`, `slug`, `display_order`) VALUES
(1, 'Show All', '*', 1),
(2, 'eid-ul-adha', 'eid-ul-adha', 2),
(3, 'eid-ul-fitr', 'eid-ul-fitr', 3),
(4, 'ramadan', 'ramadan', 4),
(5, 'shab-e-barat', 'shab-e-barat', 5);

CREATE TABLE IF NOT EXISTS `gallery_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `categories` varchar(255) NOT NULL COMMENT 'Space separated slugs for filtering',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `gallery_items` (`id`, `title`, `subtitle`, `image`, `categories`) VALUES
(1, 'The Image Title Goes Here', 'Subtitle Here', 'assets/images/gallery/mason/01.jpg', 'eid-ul-adha eid-ul-fitr'),
(2, 'The Image Title Goes Here', 'Subtitle Here', 'assets/images/gallery/mason/02.jpg', 'ramadan'),
(3, 'The Image Title Goes Here', 'Subtitle Here', 'assets/images/gallery/mason/03.jpg', 'ramadan shab-e-barat'),
(4, 'The Image Title Goes Here', 'Subtitle Here', 'assets/images/gallery/mason/04.jpg', 'ramadan eid-ul-fitr'),
(5, 'The Image Title Goes Here', 'Subtitle Here', 'assets/images/gallery/mason/05.jpg', 'shab-e-barat eid-ul-fitr'),
(6, 'The Image Title Goes Here', 'Subtitle Here', 'assets/images/gallery/mason/06.jpg', 'eid-ul-fitr eid-ul-adha'),
(7, 'The Image Title Goes Here', 'Subtitle Here', 'assets/images/gallery/mason/09.jpg', 'ramadan shab-e-barat'),
(8, 'The Image Title Goes Here', 'Subtitle Here', 'assets/images/gallery/mason/08.jpg', 'ramadan eid-ul-fitr'),
(9, 'The Image Title Goes Here', 'Subtitle Here', 'assets/images/gallery/mason/07.jpg', 'ramadan eid-ul-adha');


-- ========================================================================
-- SECTION 13: USERS (ADMIN)
-- ========================================================================

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@hafsa.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); -- password: password
