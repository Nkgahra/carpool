-- =========================================================
-- Database Schema: car_pool_db / u500152941_carpool
-- Description: Clean Database Schema and Sample Data for Car & Bike Pool Admin Application
-- =========================================================

CREATE DATABASE IF NOT EXISTS `u500152941_carpool` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `u500152941_carpool`;

-- ---------------------------------------------------------
-- 1. Admins Table
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('Super Admin', 'Admin') DEFAULT 'Admin',
  `status` TINYINT DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- 2. Users Table (Drivers & Passengers)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_code` VARCHAR(12) NOT NULL UNIQUE,
  `full_name` VARCHAR(100) NOT NULL,
  `mobile` CHAR(10) NOT NULL,
  `email` VARCHAR(150) DEFAULT NULL,
  `pin` VARCHAR(255) DEFAULT NULL,
  `gender` ENUM('Male','Female','Other') DEFAULT NULL,
  `rating` DECIMAL(2,1) DEFAULT 5.0,
  `total_rides` INT DEFAULT 0,
  `wallet_balance` DECIMAL(10,2) DEFAULT 0.00,
  `is_verified` TINYINT(1) DEFAULT 0,
  `status` ENUM('Active','Blocked','Deleted') DEFAULT 'Active',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- 3. Vehicles Table
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `vehicle_type` ENUM('car', 'bike') DEFAULT 'car',
  `brand` VARCHAR(50) DEFAULT NULL,
  `model` VARCHAR(50) DEFAULT NULL,
  `vehicle_number` VARCHAR(20) DEFAULT NULL,
  `color` VARCHAR(30) DEFAULT NULL,
  `total_seats` TINYINT DEFAULT NULL,
  `status` TINYINT DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- 4. Rides Table
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `rides` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `ride_code` VARCHAR(15) DEFAULT NULL,
  `driver_id` BIGINT UNSIGNED NOT NULL,
  `ride_type` ENUM('car', 'bike') DEFAULT 'car',
  `vehicle_id` BIGINT UNSIGNED NOT NULL,
  `pickup_address` VARCHAR(255) NOT NULL,
  `destination_address` VARCHAR(255) NOT NULL,
  `ride_date` DATE NOT NULL,
  `ride_time` TIME NOT NULL,
  `available_seats` TINYINT NOT NULL,
  `fare` DECIMAL(10,2) NOT NULL,
  `notes` TEXT DEFAULT NULL,
  `status` ENUM('active','full','driver_reached','started','completed','cancelled') DEFAULT 'active',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`driver_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- 5. Ride Bookings Table
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ride_bookings` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `booking_code` VARCHAR(15) DEFAULT NULL,
  `ride_id` BIGINT UNSIGNED NOT NULL,
  `passenger_id` BIGINT UNSIGNED NOT NULL,
  `seats` TINYINT DEFAULT 1,
  `total_fare` DECIMAL(10,2) DEFAULT NULL,
  `booking_status` ENUM('Pending','Accepted','Rejected','Cancelled','Completed') DEFAULT 'Pending',
  `payment_status` ENUM('Pending','Paid','Refunded') DEFAULT 'Pending',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`ride_id`) REFERENCES `rides`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`passenger_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================================
-- SAMPLE DUMMY DATA FOR TESTING
-- =========================================================

-- Insert Admin (Default Login: admin@gmail.com / Password: admin123)
INSERT INTO `admins` (`id`, `name`, `email`, `password`, `role`, `status`) VALUES
(1, 'System Admin', 'admin@gmail.com', '$2y$10$cmnbHaNS2EF0VYw9v4oKHeDnTDXDxQ5SE/vBqTxznlYjhc4ppJSoa', 'Super Admin', 1)
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Insert Sample Users
INSERT INTO `users` (`id`, `user_code`, `full_name`, `mobile`, `email`, `rating`, `status`) VALUES
(12, 'USR260612001', 'Rahul Sharma', '9876543210', 'rahul@example.com', 4.8, 'Active'),
(13, 'USR260613002', 'Anita Patel', '9812345678', 'anita@example.com', 4.9, 'Active'),
(14, 'USR260614003', 'Vikram Singh', '9711223344', 'vikram@example.com', 5.0, 'Active'),
(15, 'USR260615004', 'Priya Das', '9655443322', 'priya@example.com', 4.7, 'Active')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Insert Sample Vehicles
INSERT INTO `vehicles` (`id`, `user_id`, `vehicle_type`, `brand`, `model`, `vehicle_number`, `color`, `total_seats`) VALUES
(1, 12, 'car', 'Hyundai', 'i20', 'HR20AB1234', 'White', 4),
(2, 13, 'bike', 'Honda', 'Activa', 'HR23A3939', 'Green', 1),
(5, 14, 'car', 'Land Rover', 'Defender 130', 'HR82A9999', 'Black', 4)
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Insert Sample Rides
INSERT INTO `rides` (`id`, `ride_code`, `driver_id`, `ride_type`, `vehicle_id`, `pickup_address`, `destination_address`, `ride_date`, `ride_time`, `available_seats`, `fare`, `notes`, `status`) VALUES
(1, 'RD2606287655', 12, 'car', 1, 'Andheri West, Mumbai', 'Cyber City, Gurugram', '2026-08-10', '08:30:00', 2, 450.00, 'Verified Users Only', 'active'),
(2, 'RD2606289900', 13, 'bike', 2, 'Connaught Place, Delhi', 'Noida Sector 62', '2026-08-11', '09:00:00', 0, 150.00, 'Helmet provided', 'completed'),
(3, 'RD2606284433', 14, 'car', 5, 'Koramangala, Bengaluru', 'Electronic City, Bengaluru', '2026-08-12', '17:45:00', 3, 200.00, 'AC car', 'active')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Insert Sample Bookings
INSERT INTO `ride_bookings` (`id`, `booking_code`, `ride_id`, `passenger_id`, `seats`, `total_fare`, `booking_status`, `payment_status`) VALUES
(1, 'BK2606303643', 1, 15, 1, 450.00, 'Accepted', 'Paid'),
(2, 'BK2606306853', 2, 15, 1, 150.00, 'Completed', 'Paid'),
(3, 'BK2607019372', 3, 13, 1, 200.00, 'Pending', 'Pending')
ON DUPLICATE KEY UPDATE `id`=`id`;
