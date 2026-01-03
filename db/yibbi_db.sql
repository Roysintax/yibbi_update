-- Database: `yibbi_db`
-- Created from index.html content analysis

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_title`, `logo`, `favicon`, `phone`, `email`, `address`, `copyright_text`, `footer_about_text`, `footer_about_image`) VALUES
(1, 'Hafsa Home', 'assets/images/logo/01.png', 'assets/images/x-icon/01.png', '+800-123-4567 6587', 'admin@Hafsa.com', 'Beverley, New York 224 US', '&copy;2025 <a href=\"index.html\">Yayasan YIBBI</a>', 'Energistically coordinate highly efficient procesr partnerships befor revolutionar growth strategie improvement', 'assets/images/footer/footer-middle/01.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `social_media`
--

CREATE TABLE `social_media` (
  `id` int(11) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `icon_class` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order_index` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `social_media`
--

INSERT INTO `social_media` (`id`, `platform`, `icon_class`, `url`, `is_active`, `order_index`) VALUES
(1, 'Facebook', 'fab fa-facebook-messenger', '#', 1, 1),
(2, 'Twitter', 'fab fa-twitter', '#', 1, 2),
(3, 'Vimeo', 'fab fa-vimeo-v', '#', 1, 3),
(4, 'Skype', 'fab fa-skype', '#', 1, 4),
(5, 'Wifi', 'fas fa-wifi', '#', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` text DEFAULT NULL,
  `button_text` varchar(50) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT '#',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order_index` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `image`, `title`, `subtitle`, `button_text`, `button_link`, `is_active`, `order_index`) VALUES
(1, 'assets/images/banner/01.png', 'And Allah Invites To The Home Of Peace', 'The most beloved actions to Allah are those performed consistently, even if they are few', 'Donate Now', '#', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `about_section`
--

CREATE TABLE `about_section` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `heading` text NOT NULL,
  `subheading` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `button_text` varchar(50) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT '#'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `about_section`
--

INSERT INTO `about_section` (`id`, `title`, `heading`, `subheading`, `description`, `image`, `button_text`, `button_link`) VALUES
(1, 'About Our History', 'Islamic Center For Muslims To Achieve Spiritual Goals', 'Our Promise To Uphold The Trust Placed.', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Modi molestias culpa reprehenderit delectus, ullam harum, voluptatum numquam ati nesciunt odit quis corrupti magni quam consequatur sint ipsum tecto exercitationem, illo quisquam. Reprehenderit ut placeat cum adantium nam magnam blanditiis sequi modi! Nesciunt, repudiandae eos eniam quod maxime corrupti eligendi ea in animi.', 'assets/images/about/02.png', 'Ask About Islam', '#');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `button_text` varchar(50) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT '#',
  `order_index` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `title`, `description`, `image`, `button_text`, `button_link`, `order_index`) VALUES
(1, 'Quran Studies', 'Lorem ipsum dolor sit, amet is consectetur adipisicing elit.Its expedita porro natus', 'assets/images/feature/01.png', 'Sponsor Now!', '#', 1),
(2, 'Islamic Classes', 'Lorem ipsum dolor sit, amet is consectetur adipisicing elit.Its expedita porro natus', 'assets/images/feature/02.png', 'Donate Now!', '#', 2),
(3, 'Islamic Awareness', 'Lorem ipsum dolor sit, amet is consectetur adipisicing elit.Its expedita porro natus', 'assets/images/feature/03.png', 'Join Us!', '#', 3),
(4, 'Islamic Services', 'Lorem ipsum dolor sit, amet is consectetur adipisicing elit.Its expedita porro natus', 'assets/images/feature/04.png', 'Get Involved!', '#', 4);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `link` varchar(255) DEFAULT '#'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `subtitle`, `description`, `image`, `icon`, `category`, `link`) VALUES
(1, 'Mosque Development', 'Building Upgrades', 'Lorem ipsum, dolor sit amet sectetur adipisicing elit. Vel dicta beatae del voluptas apelas de.', 'assets/images/service/01.jpg', 'assets/images/service/01.png', 'Building', '#');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `type` enum('urgent','regular','sidebar') NOT NULL DEFAULT 'regular',
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `raised_amount` varchar(50) DEFAULT NULL,
  `goal_amount` varchar(50) DEFAULT NULL,
  `percentage` int(11) DEFAULT 0,
  `button_text` varchar(50) DEFAULT 'Donate Now',
  `link` varchar(255) DEFAULT '#'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `type`, `title`, `subtitle`, `description`, `image`, `raised_amount`, `goal_amount`, `percentage`, `button_text`, `link`) VALUES
(1, 'urgent', 'Free And Complete Guide To All Muslims', 'Urgent Campaign', NULL, NULL, '$24,000', '$34,900', 50, 'Donate Now', '#'),
(2, 'sidebar', 'Donations For The Nobel Causes', 'Help The Poor', 'Give the best quality of security systems and facility of latest technlogy for the people get awesome.', NULL, NULL, NULL, 0, 'See All Causes', '#'),
(3, 'regular', 'American Muslim: Choosing Remain Still This Ramadan', 'food distribution', NULL, 'assets/images/program/02.jpg', '$24,000', '$34,900', 50, 'Donate Now', '#');

-- --------------------------------------------------------

--
-- Table structure for table `faiths`
--

CREATE TABLE `faiths` (
  `id` int(11) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `order_index` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faiths`
--

INSERT INTO `faiths` (`id`, `slug`, `title`, `subtitle`, `description`, `image`, `icon`, `order_index`) VALUES
(1, 'shahadah', 'Shahadah', '(Faith)', 'The Shahadah, is an Islamic creed, one of the Five Pillars of Islam and part of the Adhan. It reads: \"I bear witness that there is no deity but God, and I bear witness that Muhammad is the messenger of God.\"', 'assets/images/faith/01.png', 'assets/images/faith/faith-icons/01.png', 1),
(2, 'prayer', 'Salaah', '(Prayer)', 'Each Muslim should pray five times a day: in the morning, at noon, in the afternoon, after sunset, and early at night. These prayers can be said anywhere, prayers that are said in company of others are better than those said alone.', 'assets/images/faith/02.png', 'assets/images/faith/faith-icons/02.png', 2),
(3, 'ramadan', 'Sawm', '(Fasting)', 'Each Muslim should pray five times a day: in the morning, at noon, in the afternoon, after sunset, and early at night. These prayers can be said anywhere, prayers that are said in company of others are better than those said alone.', 'assets/images/faith/03.png', 'assets/images/faith/faith-icons/03.png', 3),
(4, 'jakat', 'Zakat', '(Almsgiving)', 'Each Muslim should pray five times a day: in the morning, at noon, in the afternoon, after sunset, and early at night. These prayers can be said anywhere, prayers that are said in company of others are better than those said alone.', 'assets/images/faith/04.png', 'assets/images/faith/faith-icons/04.png', 4),
(5, 'hajj', 'Hajj', '(Pilgrimage)', 'Each Muslim should pray five times a day: in the morning, at noon, in the afternoon, after sunset, and early at night. These prayers can be said anywhere, prayers that are said in company of others are better than those said alone.', 'assets/images/faith/05.png', 'assets/images/faith/faith-icons/05.png', 5);

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` int(11) NOT NULL,
  `author_intro` varchar(255) DEFAULT 'Quote From Prophat',
  `author_name` varchar(255) NOT NULL,
  `quote_text` text NOT NULL,
  `source` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`id`, `author_intro`, `author_name`, `quote_text`, `source`, `is_active`) VALUES
(1, 'Quote From Prophat', 'Hazrat Mohammod (s) Said', '\"It is Better For Any Of You To Carry A Load Of Firewood On His Own Back Than To Beg From Someone Else\"', 'Riyadh-Us-Saleheen, Chapter 59, hadith 540', 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `count_down_target` varchar(100) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `date`, `location`, `image`, `count_down_target`, `is_featured`) VALUES
(1, 'Helping Hands For Poor People Marriage Event', NULL, 'December 24,2021', 'New York AK United States', 'assets/images/event/01.jpg', 'July 05, 2021 21:14:01', 1),
(2, 'If Islam Teaches Peace, Why Are there Radical Muslims?', NULL, 'December 24,2021', 'New York AK United States', 'assets/images/event/02.jpg', NULL, 0),
(3, 'American Muslim: Choosing Remain Still This Ramadan', NULL, 'December 24,2021', 'New York AK United States', 'assets/images/event/03.jpg', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(20) DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@yafsa.com', 'admin'); -- Password default: admin (MD5)

--
-- Indexes for dumped tables
--

ALTER TABLE `settings` ADD PRIMARY KEY (`id`);
ALTER TABLE `social_media` ADD PRIMARY KEY (`id`);
ALTER TABLE `banners` ADD PRIMARY KEY (`id`);
ALTER TABLE `about_section` ADD PRIMARY KEY (`id`);
ALTER TABLE `features` ADD PRIMARY KEY (`id`);
ALTER TABLE `services` ADD PRIMARY KEY (`id`);
ALTER TABLE `programs` ADD PRIMARY KEY (`id`);
ALTER TABLE `faiths` ADD PRIMARY KEY (`id`);
ALTER TABLE `quotes` ADD PRIMARY KEY (`id`);
ALTER TABLE `events` ADD PRIMARY KEY (`id`);
ALTER TABLE `users` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

ALTER TABLE `settings` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `social_media` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `banners` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `about_section` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `features` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `services` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `programs` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `faiths` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `quotes` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `events` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
