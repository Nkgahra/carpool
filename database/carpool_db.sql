-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 08, 2026 at 05:09 AM
-- Server version: 11.8.8-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u500152941_carpool`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('Super Admin','Admin') DEFAULT 'Admin',
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) DEFAULT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `redirect_url` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `state_name` varchar(100) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contacts`
--

CREATE TABLE `emergency_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_name` varchar(100) DEFAULT NULL,
  `relation_name` varchar(100) DEFAULT NULL,
  `mobile` char(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `emergency_contacts`
--

INSERT INTO `emergency_contacts` (`id`, `user_id`, `contact_name`, `relation_name`, `mobile`, `created_at`) VALUES
(1, 26, 'Brother', 'Brother', '8059393996', '2026-06-30 19:10:23'),
(3, 26, 'Getb', 'Hfg', '9717736785', '2026-06-30 19:11:51'),
(4, 28, 'Dost', 'Dost', '8080808080', '2026-07-01 04:04:41'),
(5, 31, 'hi', 'hi', '7474747474', '2026-07-01 06:50:18'),
(6, 37, 'Bhai', 'Bhai', '8059393996', '2026-07-02 14:58:36');

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `favourite_user` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `live_locations`
--

CREATE TABLE `live_locations` (
  `id` int(11) NOT NULL,
  `ride_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `location_type` enum('driver','passenger') DEFAULT 'driver',
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `speed` decimal(6,2) DEFAULT NULL,
  `heading` decimal(6,2) DEFAULT NULL,
  `accuracy` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `live_locations`
--

INSERT INTO `live_locations` (`id`, `ride_id`, `user_id`, `latitude`, `longitude`, `location_type`, `updated_at`, `speed`, `heading`, `accuracy`) VALUES
(1, 17, 33, 28.49292431, 77.09452932, 'driver', '2026-07-01 17:09:23', NULL, NULL, NULL),
(2, 18, 33, 28.49276800, 77.09416167, 'driver', '2026-07-01 17:52:40', NULL, NULL, NULL),
(3, 23, 39, 28.49294686, 77.09430104, 'driver', '2026-07-02 19:00:17', NULL, NULL, NULL),
(4, 22, 38, 28.49295396, 77.09430925, 'driver', '2026-07-02 18:55:30', NULL, NULL, NULL),
(5, 21, 38, 28.49295396, 77.09430925, 'driver', '2026-07-02 18:55:57', NULL, NULL, NULL),
(6, 26, 43, 28.49294418, 77.09431165, 'driver', '2026-07-07 15:52:26', NULL, NULL, NULL),
(7, 27, 43, 28.49294417, 77.09431167, 'driver', '2026-07-07 15:58:34', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mobile` char(10) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `attempt_time` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `is_read`, `created_at`) VALUES
(1, 12, 'New Ride Request', 'Naveen requested 1 seat(s) for your ride.', 0, '2026-06-28 16:13:09'),
(2, 12, 'New Ride Request', 'Naveen requested 1 seat(s) for your ride.', 0, '2026-06-28 16:18:15'),
(3, 24, 'New Ride Request', 'Naveen Ydv requested 1 seat(s) for your ride.', 1, '2026-06-30 15:59:26'),
(4, 24, 'New Ride Request', 'Naveen Ydv requested 3 seat(s) for your ride.', 1, '2026-06-30 16:01:00'),
(5, 24, 'New Ride Request', 'Naveen Ydv requested 2 seat(s) for your ride.', 1, '2026-06-30 16:08:11'),
(6, 24, 'New Ride Request', 'Naveen Ydv requested 2 seat(s) for your ride.', 1, '2026-06-30 16:09:40'),
(7, 24, 'New Ride Request', 'Naveen Ydv requested 2 seat(s) for your ride.', 1, '2026-06-30 16:10:28'),
(8, 24, 'New Ride Request', 'Naveen Ydv requested 2 seat(s) for your ride.', 1, '2026-06-30 16:13:47'),
(9, 24, 'New Ride Request', 'Naveen Ydv requested 1 seat(s) for your ride.', 1, '2026-06-30 16:19:03'),
(10, 25, 'Ride Request Accepted', 'Your ride request has been accepted.', 0, '2026-06-30 16:23:49'),
(11, 24, 'New Ride Request', 'Naveen requested 1 seat(s) for your ride.', 0, '2026-06-30 18:07:36'),
(12, 26, 'Ride Request Accepted', 'Your ride request has been accepted.', 0, '2026-06-30 18:07:50'),
(13, 33, 'New Ride Request', 'Jaakn requested 1 seat(s) for your ride.', 1, '2026-07-01 17:01:43'),
(14, 34, 'Ride Request Accepted', 'Your ride request has been accepted.', 0, '2026-07-01 17:02:15'),
(15, 33, 'New Ride Request', 'Naveensj requested 2 seat(s) for your ride.', 1, '2026-07-01 17:46:58'),
(16, 35, 'Ride Request Accepted', 'Your ride request has been accepted.', 1, '2026-07-01 17:47:23'),
(17, 33, 'New Ride Request', 'Naveensj requested 1 seat(s) for your ride.', 0, '2026-07-01 18:01:51'),
(18, 35, 'Ride Request Accepted', 'Your ride request has been accepted.', 0, '2026-07-01 18:02:00'),
(19, 36, 'New Ride Request', 'Ravi requested 1 seat(s) for your ride.', 1, '2026-07-02 15:00:24'),
(20, 37, 'Ride Request Accepted', 'Your ride request has been accepted.', 1, '2026-07-02 15:00:58'),
(21, 38, 'New Ride Request', 'Ravi requested 1 seat(s) for your ride.', 1, '2026-07-02 18:15:11'),
(22, 37, 'Ride Request Accepted', 'Your ride request has been accepted.', 1, '2026-07-02 18:15:34'),
(23, 38, 'New Ride Request', 'Ravi requested 1 seat(s) for your ride.', 1, '2026-07-02 18:19:39'),
(24, 37, 'Ride Request Accepted', 'Your ride request has been accepted.', 1, '2026-07-02 18:20:15'),
(25, 39, 'New Ride Request', 'Rao Sahab requested 1 seat(s) for your ride.', 1, '2026-07-02 18:22:23'),
(26, 38, 'Ride Request Accepted', 'Your ride request has been accepted.', 1, '2026-07-02 18:22:45'),
(27, 38, 'New Ride Request', 'Hanej requested 1 seat(s) for your ride.', 1, '2026-07-02 19:18:44'),
(28, 43, 'New Ride Request', 'test requested 1 seat(s) for your ride.', 1, '2026-07-07 15:46:25'),
(29, 42, 'Ride Request Accepted', 'Your ride request has been accepted by the driver.', 1, '2026-07-07 15:46:35'),
(30, 42, 'Driver Reached Pickup', 'Your driver has reached the pickup location.', 1, '2026-07-07 15:47:02'),
(31, 43, 'New Ride Request', 'wtwert requested 1 seat(s) for your ride.', 1, '2026-07-07 15:53:49'),
(32, 44, 'Ride Request Accepted', 'Your ride request has been accepted by the driver.', 1, '2026-07-07 15:54:16'),
(33, 44, 'Driver Reached Pickup', 'Your driver has reached the pickup location.', 1, '2026-07-07 15:56:09');

-- --------------------------------------------------------

--
-- Table structure for table `notification_queue`
--

CREATE TABLE `notification_queue` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sos_id` int(11) DEFAULT NULL,
  `notification_type` enum('sms','whatsapp','email','push') NOT NULL,
  `recipient` varchar(150) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('Pending','Processing','Sent','Failed') DEFAULT 'Pending',
  `provider_response` text DEFAULT NULL,
  `retry_count` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `sent_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_queue`
--

INSERT INTO `notification_queue` (`id`, `user_id`, `sos_id`, `notification_type`, `recipient`, `subject`, `message`, `status`, `provider_response`, `retry_count`, `created_at`, `sent_at`) VALUES
(1, 26, 15, 'sms', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.49294889294,77.094298901167\r\n\r\nTime:\r\n30 Jun 2026 07:26 PM', 'Sent', 'Dummy WhatsApp success', 1, '2026-06-30 19:26:02', '2026-06-30 19:50:01'),
(2, 26, 15, 'sms', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.49294889294,77.094298901167\r\n\r\nTime:\r\n30 Jun 2026 07:26 PM', 'Sent', 'Dummy WhatsApp success', 1, '2026-06-30 19:26:02', '2026-06-30 19:50:01'),
(3, 26, 16, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.49294889632,77.094298918723\r\n\r\nTime:\r\n30 Jun 2026 08:15 PM', 'Pending', NULL, 0, '2026-06-30 20:15:26', NULL),
(4, 26, 16, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.49294889632,77.094298918723\r\n\r\nTime:\r\n30 Jun 2026 08:15 PM', 'Pending', NULL, 0, '2026-06-30 20:15:26', NULL),
(5, 26, 17, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948886776,77.094298926783\r\n\r\nTime:\r\n30 Jun 2026 08:16 PM', 'Pending', NULL, 0, '2026-06-30 20:16:03', NULL),
(6, 26, 17, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948886776,77.094298926783\r\n\r\nTime:\r\n30 Jun 2026 08:16 PM', 'Pending', NULL, 0, '2026-06-30 20:16:03', NULL),
(7, 26, 18, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948869844,77.094298961276\r\n\r\nTime:\r\n30 Jun 2026 08:24 PM', 'Pending', NULL, 0, '2026-06-30 20:24:27', NULL),
(8, 26, 18, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948869844,77.094298961276\r\n\r\nTime:\r\n30 Jun 2026 08:24 PM', 'Pending', NULL, 0, '2026-06-30 20:24:27', NULL),
(9, 26, 19, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.49294886664,77.094298956734\r\n\r\nTime:\r\n30 Jun 2026 08:24 PM', 'Pending', NULL, 0, '2026-06-30 20:24:39', NULL),
(10, 26, 19, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.49294886664,77.094298956734\r\n\r\nTime:\r\n30 Jun 2026 08:24 PM', 'Pending', NULL, 0, '2026-06-30 20:24:39', NULL),
(11, 26, 20, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948862662,77.094298955191\r\n\r\nTime:\r\n30 Jun 2026 08:34 PM', 'Pending', NULL, 0, '2026-06-30 20:34:09', NULL),
(12, 26, 20, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948862662,77.094298955191\r\n\r\nTime:\r\n30 Jun 2026 08:34 PM', 'Pending', NULL, 0, '2026-06-30 20:34:09', NULL),
(13, 26, 21, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948862823,77.094298955843\r\n\r\nTime:\r\n30 Jun 2026 08:34 PM', 'Pending', NULL, 0, '2026-06-30 20:34:25', NULL),
(14, 26, 21, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948862823,77.094298955843\r\n\r\nTime:\r\n30 Jun 2026 08:34 PM', 'Pending', NULL, 0, '2026-06-30 20:34:25', NULL),
(15, 26, 22, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948862957,77.094298956366\r\n\r\nTime:\r\n30 Jun 2026 08:45 PM', 'Pending', NULL, 0, '2026-06-30 20:45:10', NULL),
(16, 26, 22, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948862957,77.094298956366\r\n\r\nTime:\r\n30 Jun 2026 08:45 PM', 'Pending', NULL, 0, '2026-06-30 20:45:10', NULL),
(17, 26, 23, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948834531,77.094298944316\r\n\r\nTime:\r\n30 Jun 2026 08:47 PM', 'Pending', NULL, 0, '2026-06-30 20:47:51', NULL),
(18, 26, 23, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948834531,77.094298944316\r\n\r\nTime:\r\n30 Jun 2026 08:47 PM', 'Pending', NULL, 0, '2026-06-30 20:47:51', NULL),
(19, 26, 24, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948856651,77.094298947924\r\n\r\nTime:\r\n30 Jun 2026 08:48 PM', 'Pending', NULL, 0, '2026-06-30 20:48:42', NULL),
(20, 26, 24, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948856651,77.094298947924\r\n\r\nTime:\r\n30 Jun 2026 08:48 PM', 'Pending', NULL, 0, '2026-06-30 20:48:42', NULL),
(21, 26, 25, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948860935,77.094298953635\r\n\r\nTime:\r\n30 Jun 2026 08:52 PM', 'Pending', NULL, 0, '2026-06-30 20:52:44', NULL),
(22, 26, 25, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948860935,77.094298953635\r\n\r\nTime:\r\n30 Jun 2026 08:52 PM', 'Pending', NULL, 0, '2026-06-30 20:52:44', NULL),
(23, 26, 26, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948860928,77.094298951921\r\n\r\nTime:\r\n30 Jun 2026 08:53 PM', 'Pending', NULL, 0, '2026-06-30 20:53:06', NULL),
(24, 26, 26, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948860928,77.094298951921\r\n\r\nTime:\r\n30 Jun 2026 08:53 PM', 'Pending', NULL, 0, '2026-06-30 20:53:06', NULL),
(25, 26, 27, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948860925,77.094298951073\r\n\r\nTime:\r\n30 Jun 2026 08:53 PM', 'Pending', NULL, 0, '2026-06-30 20:53:17', NULL),
(26, 26, 27, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948860925,77.094298951073\r\n\r\nTime:\r\n30 Jun 2026 08:53 PM', 'Pending', NULL, 0, '2026-06-30 20:53:17', NULL),
(27, 26, 28, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948860923,77.094298950568\r\n\r\nTime:\r\n30 Jun 2026 08:53 PM', 'Pending', NULL, 0, '2026-06-30 20:53:28', NULL),
(28, 26, 28, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948860923,77.094298950568\r\n\r\nTime:\r\n30 Jun 2026 08:53 PM', 'Pending', NULL, 0, '2026-06-30 20:53:28', NULL),
(29, 26, 29, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948860921,77.094298950116\r\n\r\nTime:\r\n30 Jun 2026 08:53 PM', 'Pending', NULL, 0, '2026-06-30 20:53:51', NULL),
(30, 26, 29, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948860921,77.094298950116\r\n\r\nTime:\r\n30 Jun 2026 08:53 PM', 'Pending', NULL, 0, '2026-06-30 20:53:51', NULL),
(31, 26, 30, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948862792,77.094298956557\r\n\r\nTime:\r\n30 Jun 2026 08:57 PM', 'Pending', NULL, 0, '2026-06-30 20:57:30', NULL),
(32, 26, 30, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948862792,77.094298956557\r\n\r\nTime:\r\n30 Jun 2026 08:57 PM', 'Pending', NULL, 0, '2026-06-30 20:57:30', NULL),
(33, 26, 31, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948829131,77.094298944999\r\n\r\nTime:\r\n30 Jun 2026 09:02 PM', 'Pending', NULL, 0, '2026-06-30 21:02:25', NULL),
(34, 26, 31, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948829131,77.094298944999\r\n\r\nTime:\r\n30 Jun 2026 09:02 PM', 'Pending', NULL, 0, '2026-06-30 21:02:25', NULL),
(35, 26, 32, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948834675,77.09429894563\r\n\r\nTime:\r\n30 Jun 2026 09:04 PM', 'Pending', NULL, 0, '2026-06-30 21:04:15', NULL),
(36, 26, 32, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948834675,77.09429894563\r\n\r\nTime:\r\n30 Jun 2026 09:04 PM', 'Pending', NULL, 0, '2026-06-30 21:04:15', NULL),
(37, 26, 33, 'whatsapp', '9717736785', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948864809,77.094298963431\r\n\r\nTime:\r\n30 Jun 2026 09:32 PM', 'Pending', NULL, 0, '2026-06-30 21:32:43', NULL),
(38, 26, 33, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492948864809,77.094298963431\r\n\r\nTime:\r\n30 Jun 2026 09:32 PM', 'Pending', NULL, 0, '2026-06-30 21:32:43', NULL),
(39, 26, 33, 'whatsapp', '919717736785', NULL, '🚨 EMERGENCY SOS ALERT\n\nUser: Naveen\nMobile: 7878787877\nLocation: U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\nMap: https://maps.google.com/?q=28.49294886,77.09429896\nTime: 30 Jun 2026 09:32 PM', 'Pending', NULL, 0, '2026-06-30 22:16:07', NULL),
(40, 26, 33, 'whatsapp', '918059393996', NULL, '🚨 EMERGENCY SOS ALERT\n\nUser: Naveen\nMobile: 7878787877\nLocation: U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\nMap: https://maps.google.com/?q=28.49294886,77.09429896\nTime: 30 Jun 2026 09:32 PM', 'Pending', NULL, 0, '2026-06-30 22:16:07', NULL),
(41, 28, 35, 'whatsapp', '8080808080', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nArjan Garh, National Highway 236, 1, Aya Nagar, Aya Nagar Phase New, Aya Nagar Phase 2, Aya Nagar, Aya Nagar, New Delhi, Delhi 110047, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.480923824545,77.125953910577\r\n\r\nTime:\r\n01 Jul 2026 04:07 AM', 'Pending', NULL, 0, '2026-07-01 04:07:05', NULL),
(42, 28, 35, 'whatsapp', '918080808080', NULL, '🚨 EMERGENCY SOS ALERT\n\nUser: Sudha\nMobile: 9191919192\nLocation: Arjan Garh, National Highway 236, 1, Aya Nagar, Aya Nagar Phase New, Aya Nagar Phase 2, Aya Nagar, Aya Nagar, New Delhi, Delhi 110047, India\nMap: https://maps.google.com/?q=28.48092382,77.12595391\nTime: 01 Jul 2026 04:07 AM', 'Pending', NULL, 0, '2026-07-01 04:09:41', NULL),
(43, 28, 35, 'whatsapp', '918080808080', NULL, '🚨 EMERGENCY SOS ALERT\n\nUser: Sudha\nMobile: 9191919192\nLocation: Arjan Garh, National Highway 236, 1, Aya Nagar, Aya Nagar Phase New, Aya Nagar Phase 2, Aya Nagar, Aya Nagar, New Delhi, Delhi 110047, India\nMap: https://maps.google.com/?q=28.48092382,77.12595391\nTime: 01 Jul 2026 04:07 AM', 'Pending', NULL, 0, '2026-07-01 04:09:56', NULL),
(44, 37, 39, 'whatsapp', '8059393996', NULL, 'EMERGENCY SOS ALERT\r\n\r\nA user has triggered an emergency alert.\r\n\r\nLocation:\r\nU8/4, U-8 Rd, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India\r\n\r\nGoogle Maps:\r\nhttps://maps.google.com/?q=28.492946883165,77.094301004027\r\n\r\nTime:\r\n02 Jul 2026 05:57 PM', 'Pending', NULL, 0, '2026-07-02 17:57:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `otp_logs`
--

CREATE TABLE `otp_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mobile` char(10) NOT NULL,
  `otp` char(6) NOT NULL,
  `purpose` enum('register','forgot_pin') NOT NULL,
  `attempts` tinyint(4) DEFAULT 0,
  `is_verified` tinyint(4) DEFAULT 0,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otp_logs`
--

INSERT INTO `otp_logs` (`id`, `mobile`, `otp`, `purpose`, `attempts`, `is_verified`, `expires_at`, `created_at`) VALUES
(54, '8059363996', '997019', 'register', 0, 0, '2026-06-28 11:52:00', '2026-06-28 11:47:00');

-- --------------------------------------------------------

--
-- Table structure for table `remember_tokens`
--

CREATE TABLE `remember_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `token_hash` char(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_abuse`
--

CREATE TABLE `report_abuse` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reported_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reported_user` bigint(20) UNSIGNED DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('Pending','Resolved') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `review_by` bigint(20) UNSIGNED DEFAULT NULL,
  `review_to` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(4) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `booking_id`, `review_by`, `review_to`, `rating`, `review`, `created_at`) VALUES
(1, 1, 25, 24, 4, 'Good', '2026-06-30 16:59:56'),
(2, 9, 38, 39, 5, 'ok', '2026-07-02 18:56:32');

-- --------------------------------------------------------

--
-- Table structure for table `rides`
--

CREATE TABLE `rides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ride_code` varchar(20) DEFAULT NULL,
  `driver_id` bigint(20) UNSIGNED NOT NULL,
  `ride_type` enum('car','bike') NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `pickup_address` varchar(255) NOT NULL,
  `pickup_lat` decimal(10,8) DEFAULT NULL,
  `pickup_lng` decimal(11,8) DEFAULT NULL,
  `destination_address` varchar(255) NOT NULL,
  `destination_lat` decimal(10,8) DEFAULT NULL,
  `destination_lng` decimal(11,8) DEFAULT NULL,
  `ride_date` date NOT NULL,
  `ride_time` time NOT NULL,
  `available_seats` tinyint(4) NOT NULL,
  `fare` decimal(10,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `distance` decimal(10,2) DEFAULT 0.00,
  `duration` int(11) DEFAULT 0,
  `fuel_cost` decimal(10,2) DEFAULT 0.00,
  `status` enum('active','full','driver_reached','started','completed','cancelled') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rides`
--

INSERT INTO `rides` (`id`, `ride_code`, `driver_id`, `ride_type`, `vehicle_id`, `pickup_address`, `pickup_lat`, `pickup_lng`, `destination_address`, `destination_lat`, `destination_lng`, `ride_date`, `ride_time`, `available_seats`, `fare`, `notes`, `distance`, `duration`, `fuel_cost`, `status`, `created_at`, `updated_at`) VALUES
(6, 'RD2606287655', 12, 'car', 1, 'gurugram', NULL, NULL, 'panipat', NULL, NULL, '2026-06-29', '17:41:00', 1, 350.00, 'customnotes | Verified Users Only ✔', 0.00, 0, 0.00, 'active', '2026-06-28 11:45:51', '2026-06-28 11:45:51'),
(7, 'RD2606283081', 12, 'car', 1, 'kanina', NULL, NULL, 'gahra', NULL, NULL, '2026-06-28', '18:05:00', 1, 100.00, 'No Smoking 🚭', 0.00, 0, 0.00, 'active', '2026-06-28 12:06:02', '2026-06-28 12:06:02'),
(8, 'RD2606285724', 15, 'car', 7, 'ew', NULL, NULL, 'wew', NULL, NULL, '2026-06-29', '19:48:00', 1, 100.00, '', 0.00, 0, 0.00, 'active', '2026-06-28 13:48:39', '2026-06-28 13:48:39'),
(9, 'RD2606287662', 19, 'car', 8, 'Jaipur, Rajasthan, India', NULL, NULL, 'Delhi', NULL, NULL, '2026-06-29', '00:44:00', 1, 100.00, '', 0.00, 0, 0.00, 'active', '2026-06-28 18:45:14', '2026-06-28 18:45:14'),
(10, 'RD2606283540', 19, 'car', 8, 'Mahendergarh, Bhai Parmanand Colony, Mukherjee Nagar, New Delhi, Delhi, India', NULL, NULL, 'Gurugram', NULL, NULL, '2026-06-29', '00:52:00', 1, 100.00, '', 0.00, 0, 0.00, 'active', '2026-06-28 18:53:03', '2026-06-28 18:53:03'),
(11, 'RD2606285578', 20, 'car', 9, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 28.49294930, 77.09429944, 'Delhi, India', 28.70405920, 77.10249020, '2026-06-29', '01:04:00', 1, 100.00, 'Be On Time ⏰', 0.00, 0, 0.00, 'active', '2026-06-28 19:04:30', '2026-06-28 19:04:30'),
(12, 'RD2606285596', 16, 'car', 10, 'Kanina, Haryana 123027, India', 28.33005960, 76.30858250, 'Gahra, Haryana 123027, India', 28.36446560, 76.31379500, '2026-06-29', '01:13:00', 1, 100.00, '', 4.00, 10, 0.00, 'active', '2026-06-28 19:13:24', '2026-06-28 19:13:24'),
(13, 'RD2606303494', 24, 'car', 12, '8/9, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 28.49293503, 77.09423855, 'Delhi, India', 28.70405920, 77.10249020, '2026-07-01', '20:49:00', 2, 100.00, '', 35.00, 63, 0.00, 'completed', '2026-06-30 14:50:07', '2026-06-30 16:36:20'),
(14, 'RD2606303583', 24, 'car', 12, '8/9, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 28.49295626, 77.09423354, 'Delhi, India', 28.70405920, 77.10249020, '2026-07-01', '00:07:00', 0, 100.00, '', 35.00, 63, 0.00, 'started', '2026-06-30 18:07:22', '2026-06-30 18:09:17'),
(15, 'RD2607015610', 30, 'car', 13, 'Dholpur House, UPSC, Man Singh Road Area, New Delhi, Delhi 110069, India', 28.60910000, 77.22760000, 'Agra, Uttar Pradesh, India', 27.17667010, 78.00807450, '2026-07-02', '12:16:00', 1, 300.00, 'No Smoking 🚭', 209.00, 199, 0.00, 'active', '2026-07-01 06:17:09', '2026-07-01 06:17:09'),
(16, 'RD2607019397', 31, 'bike', 14, 'Dholpur House, UPSC, Man Singh Road Area, New Delhi, Delhi 110069, India', 28.60910000, 77.22760000, 'New Delhi, Delhi 110037, India', 28.55614370, 77.09996230, '2026-07-01', '12:55:00', 1, 100.00, '', 19.00, 33, 0.00, 'active', '2026-07-01 06:56:49', '2026-07-01 06:56:49'),
(17, 'RD2607013918', 33, 'car', 15, 'Phase 3, Cyber City, Road Number 19, U bLock ,DLF, DLF Cyber City, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 28.49383900, 77.09346500, 'Gahra, Haryana 123027, India', 28.36446560, 76.31379500, '2026-07-02', '22:58:00', 0, 100.00, '', 113.00, 142, 0.00, 'completed', '2026-07-01 16:59:33', '2026-07-01 17:09:23'),
(18, 'RD2607012325', 33, 'car', 15, 'Kanina, Haryana 123027, India', 28.33005960, 76.30858250, 'Hisar, Haryana, India', 29.14918750, 75.72165270, '2026-07-02', '23:45:00', 1, 100.00, '', 158.00, 159, 0.00, 'completed', '2026-07-01 17:45:45', '2026-07-01 17:50:57'),
(19, 'RD2607013648', 33, 'car', 15, 'U8/49, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 28.49298527, 77.09453005, 'Kanina, Haryana 123027, India', 28.33005960, 76.30858250, '2026-07-02', '00:00:00', 0, 100.00, '', 110.00, 135, 0.00, 'full', '2026-07-01 18:00:56', '2026-07-01 18:02:00'),
(20, 'RD2607025636', 36, 'car', 17, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 28.49294795, 77.09429693, 'Sujapur, Haryana 123021, India', 28.13286050, 76.31378450, '2026-07-03', '20:54:00', 3, 320.00, 'This is a test ride | Verified Users Only ✔ | Light Luggage 🎒', 104.00, 121, 0.00, 'active', '2026-07-02 14:55:32', '2026-07-02 15:00:58'),
(21, 'RD2607029486', 38, 'car', 18, 'U8/4, U-8 Rd, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 28.49295478, 77.09431244, 'Delhi, India', 28.70405920, 77.10249020, '2026-07-02', '00:14:00', 0, 100.00, '', 35.00, 63, 0.00, 'completed', '2026-07-02 18:14:32', '2026-07-02 18:54:51'),
(22, 'RD2607027443', 38, 'bike', 18, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 28.49296669, 77.09427498, 'Surat, Gujarat, India', 21.17024010, 72.83106070, '2026-07-03', '00:17:00', 0, 100.00, '', 1095.00, 1008, 0.00, 'completed', '2026-07-02 18:18:00', '2026-07-02 18:38:03'),
(23, 'RD2607023022', 39, 'car', 19, 'U8/4, U-8 Rd, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 28.49294688, 77.09430102, 'Jaipur, Rajasthan, India', 26.91243360, 75.78727090, '2026-07-03', '00:21:00', 0, 100.00, '', 278.00, 236, 0.00, 'completed', '2026-07-02 18:21:58', '2026-07-02 18:28:20'),
(24, 'RD2607028451', 38, 'car', 18, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 28.49296501, 77.09426770, 'Surat, Gujarat, India', 21.17024010, 72.83106070, '2026-07-04', '01:17:00', 1, 100.00, '', 1095.00, 1008, 0.00, 'active', '2026-07-02 19:18:17', '2026-07-02 19:18:17'),
(25, 'RD2607078679', 40, 'car', 20, 'UPSC Bhavan, Shahjahan Rd, UPSC, Man Singh Road Area, New Delhi, Delhi 110069, India', 28.60775782, 77.22633159, 'Gurugram, Haryana, India', 28.45949650, 77.02663830, '2026-07-08', '11:11:00', 6, 100.00, '', 31.00, 52, 0.00, 'active', '2026-07-07 05:11:36', '2026-07-07 05:11:36'),
(26, 'RD2607078471', 43, 'car', 22, 'Delhi, India', 28.70405920, 77.10249020, 'Surat, Gujarat, India', 21.19806190, 72.82975850, '2026-07-08', '21:45:00', 2, 100.00, '', 1127.00, 1054, 0.00, 'cancelled', '2026-07-07 15:45:43', '2026-07-07 15:52:41'),
(27, 'RD2607076567', 43, 'bike', 22, 'New Delhi, Delhi 110037, India', 28.55614370, 77.09996230, 'Kanina, Haryana 123027, India', 28.33005960, 76.30858250, '2026-07-08', '21:52:00', 0, 100.00, '', 117.00, 145, 0.00, 'completed', '2026-07-07 15:53:04', '2026-07-07 15:58:38'),
(28, 'RD2607071025', 43, 'car', 22, 'Delhi, India', 28.70405920, 77.10249020, 'Kanina, Haryana 123027, India', 28.33005960, 76.30858250, '2026-07-08', '23:07:00', 1, 100.00, '', 105.00, 165, 0.00, 'active', '2026-07-07 17:07:42', '2026-07-07 17:07:42');

-- --------------------------------------------------------

--
-- Table structure for table `ride_bookings`
--

CREATE TABLE `ride_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_code` varchar(15) DEFAULT NULL,
  `ride_id` bigint(20) UNSIGNED NOT NULL,
  `passenger_id` bigint(20) UNSIGNED NOT NULL,
  `seats` tinyint(4) DEFAULT 1,
  `total_fare` decimal(10,2) DEFAULT NULL,
  `booking_status` enum('Pending','Accepted','Rejected','Cancelled','Completed') DEFAULT 'Pending',
  `payment_status` enum('Pending','Paid','Refunded') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ride_bookings`
--

INSERT INTO `ride_bookings` (`id`, `booking_code`, `ride_id`, `passenger_id`, `seats`, `total_fare`, `booking_status`, `payment_status`, `created_at`) VALUES
(1, 'BK2606303643', 13, 25, 1, 100.00, 'Completed', 'Pending', '2026-06-30 16:23:49'),
(2, 'BK2606306853', 14, 26, 1, 100.00, '', 'Pending', '2026-06-30 18:07:50'),
(3, 'BK2607019372', 17, 34, 1, 100.00, 'Completed', 'Pending', '2026-07-01 17:02:15'),
(4, 'BK2607012472', 18, 35, 2, 200.00, 'Completed', 'Pending', '2026-07-01 17:47:23'),
(5, 'BK2607014571', 19, 35, 1, 100.00, 'Accepted', 'Pending', '2026-07-01 18:02:00'),
(6, 'BK2607025923', 20, 37, 1, 320.00, 'Accepted', 'Pending', '2026-07-02 15:00:58'),
(7, 'BK2607021747', 21, 37, 1, 100.00, 'Completed', 'Pending', '2026-07-02 18:15:34'),
(8, 'BK2607025084', 22, 37, 1, 100.00, 'Completed', 'Pending', '2026-07-02 18:20:15'),
(9, 'BK2607021497', 23, 38, 1, 100.00, 'Completed', 'Pending', '2026-07-02 18:22:45'),
(10, 'BK2607072892', 26, 42, 1, 100.00, '', 'Pending', '2026-07-07 15:46:35'),
(11, 'BK2607078533', 27, 44, 1, 100.00, '', 'Pending', '2026-07-07 15:54:16');

-- --------------------------------------------------------

--
-- Table structure for table `ride_requests`
--

CREATE TABLE `ride_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ride_id` bigint(20) UNSIGNED NOT NULL,
  `passenger_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` int(20) NOT NULL,
  `requested_seats` tinyint(4) DEFAULT 1,
  `message` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Accepted','Rejected','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ride_requests`
--

INSERT INTO `ride_requests` (`id`, `ride_id`, `passenger_id`, `booking_id`, `requested_seats`, `message`, `status`, `created_at`) VALUES
(11, 13, 25, 0, 1, '', 'Accepted', '2026-06-30 16:19:03'),
(12, 14, 26, 0, 1, '', 'Accepted', '2026-06-30 18:07:36'),
(13, 17, 34, 0, 1, '', 'Accepted', '2026-07-01 17:01:43'),
(14, 18, 35, 0, 2, 'Okhi', 'Accepted', '2026-07-01 17:46:58'),
(15, 19, 35, 0, 1, '', 'Accepted', '2026-07-01 18:01:51'),
(16, 20, 37, 0, 1, 'Hi need 1 seat', 'Accepted', '2026-07-02 15:00:24'),
(17, 21, 37, 0, 1, '', 'Accepted', '2026-07-02 18:15:11'),
(18, 22, 37, 0, 1, '', 'Accepted', '2026-07-02 18:19:39'),
(19, 23, 38, 0, 1, '', 'Accepted', '2026-07-02 18:22:23'),
(20, 24, 39, 0, 1, '', 'Pending', '2026-07-02 19:18:44'),
(21, 26, 42, 10, 1, '', 'Accepted', '2026-07-07 15:46:25'),
(22, 27, 44, 11, 1, '', 'Accepted', '2026-07-07 15:53:49');

-- --------------------------------------------------------

--
-- Table structure for table `ride_stops`
--

CREATE TABLE `ride_stops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ride_id` bigint(20) UNSIGNED NOT NULL,
  `stop_name` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `stop_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sos_live_locations`
--

CREATE TABLE `sos_live_locations` (
  `id` int(11) NOT NULL,
  `sos_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `address` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sos_logs`
--

CREATE TABLE `sos_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ride_id` int(11) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('Open','Resolved','False Alarm') DEFAULT 'Open',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `resolved_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sos_logs`
--

INSERT INTO `sos_logs` (`id`, `user_id`, `ride_id`, `latitude`, `longitude`, `address`, `message`, `status`, `created_at`, `resolved_at`) VALUES
(12, 26, NULL, 28.49294891, 77.09429889, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 18:50:44', '2026-06-30 18:56:45'),
(13, 26, NULL, 28.49294890, 77.09429889, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 18:57:11', '2026-06-30 19:19:19'),
(14, 26, NULL, 28.49294890, 77.09429890, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 19:18:24', '2026-06-30 19:19:22'),
(15, 26, NULL, 28.49294889, 77.09429890, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 19:26:02', '2026-06-30 20:17:00'),
(16, 26, NULL, 28.49294890, 77.09429892, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 20:15:26', '2026-06-30 20:17:05'),
(17, 26, NULL, 28.49294889, 77.09429893, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 20:16:03', '2026-06-30 20:17:02'),
(18, 26, NULL, 28.49294887, 77.09429896, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 20:24:27', '2026-06-30 20:25:11'),
(19, 26, NULL, 28.49294887, 77.09429896, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 20:24:39', '2026-06-30 20:25:14'),
(20, 26, NULL, 28.49294886, 77.09429896, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 20:34:09', '2026-06-30 20:36:21'),
(21, 26, NULL, 28.49294886, 77.09429896, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 20:34:25', '2026-06-30 20:36:18'),
(22, 26, NULL, 28.49294886, 77.09429896, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 20:45:10', '2026-06-30 20:47:39'),
(23, 26, NULL, 28.49294883, 77.09429894, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 20:47:51', '2026-06-30 20:48:17'),
(24, 26, NULL, 28.49294886, 77.09429895, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 20:48:42', '2026-06-30 20:48:50'),
(25, 26, NULL, 28.49294886, 77.09429895, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 20:52:44', '2026-06-30 20:52:54'),
(26, 26, NULL, 28.49294886, 77.09429895, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 20:53:06', '2026-06-30 20:53:09'),
(27, 26, NULL, 28.49294886, 77.09429895, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 20:53:17', '2026-06-30 20:53:20'),
(28, 26, NULL, 28.49294886, 77.09429895, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 20:53:28', '2026-06-30 20:53:43'),
(29, 26, NULL, 28.49294886, 77.09429895, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 20:53:51', '2026-06-30 20:53:54'),
(30, 26, NULL, 28.49294886, 77.09429896, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 20:57:30', '2026-06-30 20:57:44'),
(31, 26, NULL, 28.49294883, 77.09429894, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 21:02:25', '2026-06-30 21:03:38'),
(32, 26, NULL, 28.49294883, 77.09429895, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 21:04:15', '2026-06-30 21:34:05'),
(33, 26, NULL, 28.49294886, 77.09429896, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 21:32:43', '2026-06-30 22:16:36'),
(34, 27, NULL, 28.49294860, 77.09429961, 'U8/6, Galli No 16, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-06-30 22:19:30', '2026-06-30 22:20:25'),
(35, 28, NULL, 28.48092382, 77.12595391, 'Arjan Garh, National Highway 236, 1, Aya Nagar, Aya Nagar Phase New, Aya Nagar Phase 2, Aya Nagar, Aya Nagar, New Delhi, Delhi 110047, India', 'Emergency SOS triggered', 'Resolved', '2026-07-01 04:07:05', '2026-07-01 04:11:19'),
(36, 30, NULL, 28.60910000, 77.22760000, 'Dholpur House, UPSC, Man Singh Road Area, New Delhi, Delhi 110069, India', 'Emergency SOS triggered', 'Resolved', '2026-07-01 06:11:28', '2026-07-01 06:46:18'),
(37, 30, NULL, 28.60910000, 77.22760000, 'Dholpur House, UPSC, Man Singh Road Area, New Delhi, Delhi 110069, India', 'Emergency SOS triggered', 'Resolved', '2026-07-01 06:14:03', '2026-07-01 06:46:24'),
(38, 31, NULL, 28.60910000, 77.22760000, 'Dholpur House, UPSC, Man Singh Road Area, New Delhi, Delhi 110069, India', 'Emergency SOS triggered', 'Resolved', '2026-07-01 06:47:37', '2026-07-01 06:48:23'),
(39, 37, NULL, 28.49294688, 77.09430100, 'U8/4, U-8 Rd, U Block, DLF Phase 3, Sector 24, Gurugram, Haryana 122002, India', 'Emergency SOS triggered', 'Resolved', '2026-07-02 17:57:38', '2026-07-02 17:57:52');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_no` varchar(20) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('Open','Pending','Resolved','Closed') DEFAULT 'Open',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_code` varchar(12) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `mobile` char(10) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `pin` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT 5.0,
  `total_rides` int(11) DEFAULT 0,
  `wallet_balance` decimal(10,2) DEFAULT 0.00,
  `is_verified` tinyint(1) DEFAULT 0,
  `status` enum('Active','Blocked','Deleted') DEFAULT 'Active',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_code`, `full_name`, `mobile`, `email`, `pin`, `gender`, `dob`, `profile_photo`, `city_id`, `rating`, `total_rides`, `wallet_balance`, `is_verified`, `status`, `last_login`, `created_at`, `updated_at`) VALUES
(12, 'WC2606281504', 'NaveenYadav', '8059393996', NULL, '$2y$10$iOjc3Ox4Zmxx3ZtdcAYv8eSoyXdkJD2MNtEAiA7ENMVSQCOFcVYRa', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-06-28 11:08:13', '2026-06-28 11:08:13'),
(13, 'WC2606284013', 'Hh', '8860250967', NULL, '$2y$10$ghOSuHB..mhGNI0DC3.mlOB.8da0LYTIhphjxfb9oyIxGE6p6mOKq', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-06-28 12:26:48', '2026-06-28 12:26:48'),
(14, 'WC2606287874', 'Naman Yadav', '7000000000', 'nkgahra0395@gmail.com', '$2y$10$rV6Ke3TJy3CMcd.BejiNpep8cuM5PXY7pcZjKj3mFr7srfpXWegaW', 'Female', '2026-06-28', NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-06-28 13:12:30', '2026-06-28 14:06:55'),
(15, 'WC2606289500', 'naveenyadav', '8059393999', '', '$2y$10$OyMRbTJN4LhjXEDkIND3YupwvaDIm8Ou5uGpTO9.fpMRJA4tPVCF6', 'Male', '1000-10-24', NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-06-28 13:43:38', '2026-06-28 14:02:30'),
(16, 'WC2606285303', 'rani', '8059393998', NULL, '$2y$10$QJCADmK1IjE0c7U6VuNO/eGKgFaimAfaG.eB4TvSQZ4gZPPvA.WEi', 'Female', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-06-28 14:10:12', '2026-06-28 14:10:12'),
(17, 'WC2606287914', 'Naveen', '8059393991', NULL, '$2y$10$E1T4UhdkqVrTzLksXkQf8OW3I6Zrh1Kc1N0eEu4SQyde7U7vsWxRK', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-06-28 15:58:28', '2026-06-28 15:58:28'),
(18, 'WC2606296557', 'Naveen', '8059393992', NULL, '$2y$10$LnKAuV/1AsaPIgserCiXFOmTuxlhyoObI6nybhASX049KG.rm6LYi', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-06-28 18:34:46', '2026-06-28 18:34:46'),
(19, 'WC2606294531', 'Naveen', '8059393995', NULL, '$2y$10$AVTc.R0YwSdL.k2cYVYBfuvVqfQ7I00kqoZ8HrVHX6KmFFZ66Byai', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-06-28 18:35:30', '2026-06-28 18:35:30'),
(20, 'WC2606298237', 'Naveen', '8059393994', NULL, '$2y$10$OltvRJw/000ax3aB6kuNy.iLgXqWPGXVy8f1u1CzQuaKYzOvX7U02', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-06-28 19:03:13', '2026-06-28 19:03:13'),
(21, 'WC2606298861', 'Shinu', '8080808080', NULL, '$2y$10$7QQVCP7.orZmnQG3Bg6kvOGyu3YIhz1xqZ5yPAkjzXnuUQcOJEp4y', 'Female', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-06-28 19:54:57', '2026-06-28 19:54:57'),
(22, 'WC2606298316', 'Naveen', '8181818181', NULL, '$2y$10$3.vnHU3E.T2hu1SYpB8VyekU2ldCjlkjbIf67wTyV4DTOlyYK7JFu', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-06-29 06:43:00', '2026-06-29 06:43:00'),
(23, 'WC2606293906', 'Naveen', '9191919191', NULL, '$2y$10$4bC5Tt8CMuGUdfBJ84YcyOyI1rFbyvFjYTk2/qmj36YWgrD0Z2MH6', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-06-29 08:19:40', '2026-06-29 08:19:40'),
(24, 'WC2606304675', 'NaveenYadav', '8059045012', NULL, '$2y$10$zkua8j9dSQVD/TB4n6CaWe90FQZKaDiQ7LUJuyF.qbQHZKJtwmQti', 'Male', NULL, NULL, NULL, 4.0, 0, 0.00, 1, 'Active', NULL, '2026-06-30 13:50:17', '2026-06-30 16:59:56'),
(25, 'WC2606304636', 'Naveen Yadv', '7878787878', NULL, '$2y$10$8fbK8dkxGO3daK.utRetAOxVsV6iYP2JbEl6P50YMwFnpLfxNIIq6', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-06-30 15:33:30', '2026-06-30 17:46:30'),
(26, 'WC2606309628', 'Naveen', '7878787877', NULL, '$2y$10$AncLH9J9Q5WMy9VuP1AJTeBZlOe0LW1ZJrcHocrrtDcOh2onf0Vsa', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-06-30 17:48:17', '2026-06-30 17:48:47'),
(27, 'WC2607013819', 'Rani', '8080808081', NULL, '$2y$10$iL3uab.3.GynaIOCXIWYde1BHz/hOl0f88e1ejCtKiEAIhY9kMmPK', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-06-30 22:19:18', '2026-06-30 22:19:18'),
(28, 'WC2607016486', 'Sonu', '9191919192', NULL, '$2y$10$aLlQI3uz1nitWxXpu8R6pOxggFh3sJ09BXw131b8RJ/bjg4y5U7m6', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-01 04:03:58', '2026-07-01 05:29:22'),
(29, 'WC2607016688', 'hi', '8059363636', NULL, '$2y$10$dgg9.EVYybuB3Anbn7DrKeMLDvbX/7MP15bt3ttMx1DC8.3d2tLz6', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-01 05:28:13', '2026-07-01 05:28:13'),
(30, 'WC2607015234', 'UPSC', '8989898989', NULL, '$2y$10$9inoJAz0kxpVzN/qK8FNvetAmURIvAD/5gAYYQEkJgTWKD36G/sEK', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-01 06:10:27', '2026-07-01 06:10:27'),
(31, 'WC2607016682', 'Naveen', '7474747474', NULL, '$2y$10$5Xf8YfLhFXsTMXtRjfM2a.Dru9Il8kOe7xPgilp1Uuo0kjIV1B/Ky', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-01 06:45:36', '2026-07-01 06:45:36'),
(32, 'WC2607018549', 'Narayan', '9090909090', NULL, '$2y$10$sOBl9UhS6Kf9bjTbI6HOvuRLmv25srGSjoUZEBmOR7XwJkuNFsOk6', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-01 15:31:50', '2026-07-01 15:31:50'),
(33, 'WC2607017678', 'nvn', '9898989890', NULL, '$2y$10$B3IJKMlecAP5a3WOSh9iSOlL9SMtICM98X4ny/BHzOdzckkrMLEWu', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-01 16:58:01', '2026-07-01 16:58:01'),
(34, 'WC2607017273', 'Jaakn', '9898989599', NULL, '$2y$10$MmVJ3rg5Uc7mGmd0ScxOa.d2KzzaLokaSANPkIiZ.96EUMX/1zqcO', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-01 17:01:02', '2026-07-01 17:01:02'),
(35, 'WC2607018514', 'Naveensj', '8585858484', NULL, '$2y$10$KGbVrvE9oPDC6G1ryavFbeb7evFPei1Oo1xToGaoLVZ9/EotpvCKi', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-01 17:46:28', '2026-07-01 17:46:28'),
(36, 'WC2607029923', 'Naveen', '9090129090', NULL, '$2y$10$ahLiWt4Ap/PdVlF4jS8uwuvszwhew.JvA/W.UiNJ7W4POjbGl0L/6', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-02 14:51:32', '2026-07-02 14:51:32'),
(37, 'WC2607028375', 'Ravi', '9797979446', NULL, '$2y$10$oK3nIh7CKGSZ2/7f3XMGd.zw5VLykJdfi9NNbF07FJg0R5iutWwFC', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-02 14:58:12', '2026-07-02 14:58:12'),
(38, 'WC2607028429', 'Rao Sahab', '9012343534', NULL, '$2y$10$Rn6ZXZAB3b3YF1WH6vWd1um5zzfR4P9hB3vrvPteYjLzHfW18ItcC', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-02 17:55:50', '2026-07-02 17:55:50'),
(39, 'WC2607022985', 'Hanej', '8787545434', NULL, '$2y$10$dHEeT95JKQN8zicFU4nMUOkCxCxCKHXgIIv35/iopvayfVyk8h1H.', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-02 18:21:30', '2026-07-02 18:21:30'),
(40, 'WC2607072932', 'Rahul', '7070707070', NULL, '$2y$10$WFa.wGeIlKrryjEHPbjj/eIW1GYWwaFudE3tZoTCyxKkKdGlW1sGi', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-07 05:08:53', '2026-07-07 05:08:53'),
(41, 'WC2607072631', 'Sudha yadav', '8888552555', NULL, '$2y$10$rFYZG4eEXVIqejxkX6OqauSJJ6p1rp7Fvdy/GjRnaU5Q/L8.CPO02', 'Female', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-07 12:37:19', '2026-07-07 12:38:05'),
(42, 'WC2607075910', 'test', '9876578887', NULL, '$2y$10$tP1sZaidl1FSTdkdz2G78upx09SMuDfYgEoxdLPdbzXybdihEoIdW', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-07 14:37:29', '2026-07-07 14:37:29'),
(43, 'WC2607078740', 'Bcch', '8754125885', NULL, '$2y$10$XYs6bq1gUf/6Y.2f7apvu.QP5jVMkKB3dOqs0DjxpLmUPghPU1MVG', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-07 15:44:54', '2026-07-07 15:44:54'),
(44, 'WC2607073673', 'wtwert', '9087987868', NULL, '$2y$10$ie4PwphBx6wZNDCDJSDfueGypNNCph0DcJWlYv6B4XMbUL2TMGqv.', 'Male', NULL, NULL, NULL, 5.0, 0, 0.00, 1, 'Active', NULL, '2026-07-07 15:52:13', '2026-07-07 15:52:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_documents`
--

CREATE TABLE `user_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `document_type` enum('Aadhaar','Driving Licence','RC','Insurance') DEFAULT NULL,
  `document_number` varchar(100) DEFAULT NULL,
  `document_file` varchar(255) DEFAULT NULL,
  `verification_status` enum('Pending','Verified','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `browser` varchar(150) DEFAULT NULL,
  `platform` varchar(150) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `last_activity` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_type` enum('car','bike') DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `vehicle_number` varchar(20) DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  `total_seats` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `user_id`, `vehicle_type`, `brand`, `model`, `vehicle_number`, `color`, `total_seats`, `status`, `created_at`) VALUES
(1, 12, 'car', 'Hyundai', 'i20', 'HR20AB1234', 'White', 4, 1, '2026-06-28 11:40:52'),
(2, 13, 'bike', 'Honda', 'Activa', 'HR23A3939', 'Green', 1, 1, '2026-06-28 12:30:33'),
(4, 12, 'bike', 'bike121d', 'bikeewf', 'HR3434H', 'Ooer', 2, 0, '2026-06-28 12:32:11'),
(5, 14, 'car', 'Defender', '130', 'HR82A9999', 'Black', 4, 1, '2026-06-28 13:13:27'),
(7, 15, 'car', 'w', 'ww', 'W', 'w', 3, 1, '2026-06-28 13:48:05'),
(8, 19, 'car', 'K', 'M', 'M', 'M', 4, 1, '2026-06-28 18:44:54'),
(9, 20, 'car', 'Mskkx', 'Xxxxxx', 'SZXX', 'Zxxx', 3, 1, '2026-06-28 19:04:11'),
(10, 16, 'car', 'jh', 'hgf', 'HG', 'hg', 2, 1, '2026-06-28 19:13:03'),
(11, 23, 'bike', 'Royal EnField', 'Bullet 350', 'HR33A2345', 'Black', 1, 1, '2026-06-29 08:21:13'),
(12, 24, 'car', 'd', 'd', 'D', 'd', 4, 1, '2026-06-30 14:49:40'),
(13, 30, 'car', 'KIA SONET', 'SONET', 'DL12DA4559', 'IMPERIAL BLUE', 4, 1, '2026-07-01 06:16:07'),
(14, 31, 'bike', 'ffgh', 'gds', 'DFGHS', 'dfhs', 1, 1, '2026-07-01 06:53:42'),
(15, 33, 'car', 'ew', 'e', 'E', 'we', 3, 1, '2026-07-01 16:58:47'),
(16, 35, 'bike', 'Isjs', 'Zz', 'ZZZ', 'Zz', 2, 1, '2026-07-01 17:59:20'),
(17, 36, 'car', 'Hyundai', 'Aura', 'HR82A8782', 'White', 4, 1, '2026-07-02 14:54:18'),
(18, 38, 'car', 'jkh', 'ghf', 'GH', 'gh', 3, 1, '2026-07-02 18:14:08'),
(19, 39, 'car', 'Ss', 'Szzszx', 'SZ', 'Sss', 3, 1, '2026-07-02 18:21:46'),
(20, 40, 'car', 'Maruti', 'Grand Vitara', 'HR45F6867', 'White', 4, 1, '2026-07-07 05:10:57'),
(21, 42, 'bike', 'hero', 'splendor', 'HT5DDF', 'red', 1, 1, '2026-07-07 14:39:42'),
(22, 43, 'car', 'H c', 'Bbv', 'HHBV', 'Bn', 4, 1, '2026-07-07 15:45:24');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_brands`
--

CREATE TABLE `vehicle_brands` (
  `id` int(11) NOT NULL,
  `vehicle_type` enum('Car','Bike') NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_models`
--

CREATE TABLE `vehicle_models` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `model_name` varchar(100) NOT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `balance` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wallet_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_code` varchar(20) DEFAULT NULL,
  `type` enum('Credit','Debit') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Success','Failed') DEFAULT 'Success',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `favourite_user` (`favourite_user`);

--
-- Indexes for table `live_locations`
--
ALTER TABLE `live_locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_ride_user` (`ride_id`,`user_id`),
  ADD KEY `ride_id` (`ride_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_mobile` (`mobile`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notification_queue`
--
ALTER TABLE `notification_queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_logs`
--
ALTER TABLE `otp_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_mobile` (`mobile`);

--
-- Indexes for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`);

--
-- Indexes for table `report_abuse`
--
ALTER TABLE `report_abuse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `reported_by` (`reported_by`),
  ADD KEY `reported_user` (`reported_user`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `review_by` (`review_by`),
  ADD KEY `review_to` (`review_to`);

--
-- Indexes for table `rides`
--
ALTER TABLE `rides`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ride_code` (`ride_code`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `vehicle_id` (`vehicle_id`),
  ADD KEY `status` (`status`),
  ADD KEY `ride_date` (`ride_date`);

--
-- Indexes for table `ride_bookings`
--
ALTER TABLE `ride_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `ride_id` (`ride_id`),
  ADD KEY `passenger_id` (`passenger_id`);

--
-- Indexes for table `ride_requests`
--
ALTER TABLE `ride_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ride_id` (`ride_id`),
  ADD KEY `passenger_id` (`passenger_id`);

--
-- Indexes for table `ride_stops`
--
ALTER TABLE `ride_stops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ride_id` (`ride_id`);

--
-- Indexes for table `sos_live_locations`
--
ALTER TABLE `sos_live_locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_sos_user` (`sos_id`,`user_id`);

--
-- Indexes for table `sos_logs`
--
ALTER TABLE `sos_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_no` (`ticket_no`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_code` (`user_code`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD KEY `idx_mobile` (`mobile`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_brands`
--
ALTER TABLE `vehicle_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_models`
--
ALTER TABLE `vehicle_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_code` (`transaction_code`),
  ADD KEY `idx_wallet` (`wallet_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `live_locations`
--
ALTER TABLE `live_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `notification_queue`
--
ALTER TABLE `notification_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `otp_logs`
--
ALTER TABLE `otp_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_abuse`
--
ALTER TABLE `report_abuse`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rides`
--
ALTER TABLE `rides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `ride_bookings`
--
ALTER TABLE `ride_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ride_requests`
--
ALTER TABLE `ride_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `ride_stops`
--
ALTER TABLE `ride_stops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sos_live_locations`
--
ALTER TABLE `sos_live_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `sos_logs`
--
ALTER TABLE `sos_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `vehicle_brands`
--
ALTER TABLE `vehicle_brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_models`
--
ALTER TABLE `vehicle_models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD CONSTRAINT `emergency_contacts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`favourite_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  ADD CONSTRAINT `remember_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_abuse`
--
ALTER TABLE `report_abuse`
  ADD CONSTRAINT `report_abuse_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `ride_bookings` (`id`),
  ADD CONSTRAINT `report_abuse_ibfk_2` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `report_abuse_ibfk_3` FOREIGN KEY (`reported_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `ride_bookings` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`review_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`review_to`) REFERENCES `users` (`id`);

--
-- Constraints for table `rides`
--
ALTER TABLE `rides`
  ADD CONSTRAINT `fk_rides_driver` FOREIGN KEY (`driver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rides_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ride_bookings`
--
ALTER TABLE `ride_bookings`
  ADD CONSTRAINT `ride_bookings_ibfk_1` FOREIGN KEY (`ride_id`) REFERENCES `rides` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ride_bookings_ibfk_2` FOREIGN KEY (`passenger_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ride_requests`
--
ALTER TABLE `ride_requests`
  ADD CONSTRAINT `ride_requests_ibfk_1` FOREIGN KEY (`ride_id`) REFERENCES `rides` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ride_requests_ibfk_2` FOREIGN KEY (`passenger_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ride_stops`
--
ALTER TABLE `ride_stops`
  ADD CONSTRAINT `ride_stops_ibfk_1` FOREIGN KEY (`ride_id`) REFERENCES `rides` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD CONSTRAINT `support_tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD CONSTRAINT `user_documents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicle_models`
--
ALTER TABLE `vehicle_models`
  ADD CONSTRAINT `vehicle_models_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `vehicle_brands` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD CONSTRAINT `wallet_transactions_ibfk_1` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
