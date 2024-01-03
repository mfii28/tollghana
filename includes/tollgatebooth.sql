-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2024 at 03:49 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tollgatebooth`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`admin_id`, `username`, `email`, `password`, `full_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@support.com', '$2y$10$hashed_password_here', '', '2024-01-03 02:16:40', '2024-01-03 02:16:40');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(255) NOT NULL,
  `momo_number` varchar(255) DEFAULT NULL,
  `amount` decimal(10,0) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`transaction_id`, `user_id`, `updated_at`, `created_at`, `payment_method`, `momo_number`, `amount`) VALUES
(1, 17, '2024-01-01 15:55:02', '2024-01-01 15:54:35', 'mobile_money', '0542877425', 70);

-- --------------------------------------------------------

--
-- Table structure for table `earning`
--

CREATE TABLE `earning` (
  `earning_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `earnings_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `earning`
--

INSERT INTO `earning` (`earning_id`, `user_id`, `amount`, `earnings_date`) VALUES
(1, 17, 30.00, '2024-01-01 15:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `qrcodes`
--

CREATE TABLE `qrcodes` (
  `qrcode_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `qr_code_data` text DEFAULT NULL,
  `qr_code_image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `qrcodes`
--

INSERT INTO `qrcodes` (`qrcode_id`, `user_id`, `qr_code_data`, `qr_code_image_path`, `created_at`) VALUES
(5, 21, 'http://localhost/tollGate/profile_page.php?user_id=21', 'user_qrcodes/user_21.png', '2024-01-03 00:25:23'),
(6, 22, 'http://localhost/tollGate/profile_page.php?user_id=22', 'user_qrcodes/user_22.png', '2024-01-03 00:29:22'),
(7, 23, 'http://localhost/tollGate/profile_page.php?user_id=23', 'C:\\xampp\\htdocs\\tollGate\\auth/user_qrcodes/user_23.png', '2024-01-03 00:30:58'),
(8, 24, 'http://localhost/tollGate/profile_page.php?user_id=24', 'user_qrcodes/user_24.png', '2024-01-03 01:40:05'),
(9, 25, 'http://localhost/tollGate/profile_page.php?user_id=25', '../user_qrcodes/user_25.png', '2024-01-03 02:06:58');

-- --------------------------------------------------------

--
-- Table structure for table `toll_access`
--

CREATE TABLE `toll_access` (
  `id` int(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `round` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `toll_booths`
--

CREATE TABLE `toll_booths` (
  `toll_booth_id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `toll_subscribe`
--

CREATE TABLE `toll_subscribe` (
  `subscription_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `subscription_type` int(11) NOT NULL,
  `plan_type` int(11) DEFAULT NULL,
  `subscription_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `toll_subscribe`
--

INSERT INTO `toll_subscribe` (`subscription_id`, `user_id`, `subscription_type`, `plan_type`, `subscription_date`) VALUES
(0, 17, 1, NULL, '2024-01-01 15:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `toll_booth_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(255) NOT NULL,
  `momo_number` varchar(255) DEFAULT NULL,
  `amount` decimal(10,0) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `transactions`
--
DELIMITER $$
CREATE TRIGGER `update_earning_after_payment` AFTER INSERT ON `transactions` FOR EACH ROW BEGIN
    DECLARE plan_price DECIMAL(10, 2);

    -- Assuming you have a way to determine the plan price based on the transaction
    -- Set the plan_price variable accordingly

    INSERT INTO `earning` (`user_id`, `amount`, `earnings_date`)
    VALUES (NEW.user_id, plan_price, NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `profile_picture` longblob DEFAULT NULL,
  `qrcode_img` longblob DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `full_name`, `address`, `phone_number`, `reset_token`, `reset_token_expiry`, `profile_picture`, `qrcode_img`, `gender`, `first_name`, `last_name`) VALUES
(17, 'user41430807', 'manuelgo@gmail.com', '$2y$10$e9sMWrFZD8ZgzRJY2jVe5eC.pisCgBDCH6C0CfHgkcQxj0Zh5L8mW', 'Emmanuel Tetteh', '2332', '0543679145', 'e61a2c9ecf5f55bca7a678c05977657c5e48fc2c39dec5900643f457dc920a9e', '2024-01-01 17:52:29', 0x2e2f75706c6f61642f363239613333636638356462362e6a7067, NULL, 'Male', 'Emmanuel', 'Tetteh'),
(18, 'user27653934', 'manuelfii28@gmail.com', '$2y$10$GL/lvOncqFVn3Q44/4KDHeVIKzCtRm4Uz6WRLuOq7R0JpUnde6eEe', 'manuelkofi92 ', NULL, NULL, 'c3c32766466516ff9ba0dd96e0689c9db7c616aeff41667b07487fbb527d66f4', '2024-01-02 16:42:26', NULL, NULL, NULL, NULL, NULL),
(19, 'user22381810', 'modsigning@gmail.com', '$2y$10$cBYKB4o2sm0Q092NyPvdVu6jvpCA1siO5walEr8oh5eIQKce6k7dW', 'manuelkofi92@gmail.com', NULL, NULL, '55ab63b7c38353d69d8ed5b588d13480ffa6ec874dcba87962de3e4017593c3d', '2024-01-03 02:16:07', NULL, NULL, NULL, NULL, NULL),
(20, 'user48997306', 'manuelfii2809@gmail.com', '$2y$10$r9TCbj1S3D6hkGIENCCoCeCDJr6Yxnsxp5odEOIqVVui1a7iuDmWu', 'tetteh Emmauel', NULL, NULL, '36cc058906fc1ac68e80c35f20d8d8e2e536ae69addec27fb543dd280709db0c', '2024-01-03 02:21:17', NULL, NULL, NULL, NULL, NULL),
(21, 'user80540275', 'manuelfii8@gmail.com', '$2y$10$KRLBRoaqMRX55broTsdR4egIt9vHmy0OKqsqPcTP/JxMm1kAYFgvi', 'tetteh Emmauel', NULL, NULL, '58837ae21f6e303990a70152d032bf3f6cd01191ee69a4916e3f8d56091b827f', '2024-01-03 02:25:22', NULL, NULL, NULL, NULL, NULL),
(22, 'user9805467', 'manuelgo2@gmail.com', '$2y$10$hb/40/SE0N8GawglyC0B7..8Gy8RA2ALJdiwAxiT5JFzScrBIZiEC', 'Manuel Tetteh', NULL, NULL, '6fe8244a5ed2a336e0a9ab05e8cf96c213cfd2fd69658e5c3ba53ab9f44a94d6', '2024-01-03 02:29:21', NULL, NULL, NULL, NULL, NULL),
(23, 'user26420332', 'manuelkofi921@gmail.com', '$2y$10$1BflYT/uSO1iGP/ewm3Nd.7TiyKVBlgA4UwkuqpjHYmDfT5frKncK', 'manuelkofi921@gmail.com', NULL, NULL, '3f3592437199cefd589fbac864f32fbb5a1b3b9110d4cefb17ab3228dcee5273', '2024-01-03 02:30:57', NULL, NULL, NULL, NULL, NULL),
(24, 'user63053282', 'sarahmensahansahj@gmail.com', '$2y$10$MQWdi7L.4UAw2aLJcg9zgOKgUErW22N.jty3kQXNJP8YJzfqJaENy', 'Emmnauel Asiedu Tettehs', NULL, NULL, '0630386702b9e32218f02a463b2bcf4536c4e34bf961039239e5963b6efa936e', '2024-01-03 03:40:05', NULL, NULL, NULL, NULL, NULL),
(25, 'user56354090', 'manuelfii2866@gmail.com', '$2y$10$gpVdO73lGbLKfd09yYs3x.h4oy3M0Z5OaGSreD.ilWu9CMIj7fc3K', 'manuelfii2866@gmail.com', NULL, NULL, '529a057e4af6e6a73c79a79145e13623351a2884f43a01856ba4242e3a5dcfac', '2024-01-03 04:06:58', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vehicle_type` enum('Private car','4x4 Vehicles','Minibuses','motorbike','Heavy Goods Vehicles','Triclyes') NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `toll_amount` decimal(10,2) DEFAULT 0.00,
  `toll_subscriber` tinyint(1) DEFAULT 0,
  `paid_status` tinyint(1) DEFAULT 0,
  `registration_number` varchar(255) NOT NULL,
  `last_toll_paid_date` datetime DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `colour` varchar(255) DEFAULT NULL,
  `insurance_company` varchar(255) DEFAULT NULL,
  `photo` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `user_id`, `vehicle_type`, `owner_name`, `toll_amount`, `toll_subscriber`, `paid_status`, `registration_number`, `last_toll_paid_date`, `model`, `year`, `colour`, `insurance_company`, `photo`) VALUES
(7, 17, 'motorbike', '', 1.00, 0, 0, '12323', NULL, 'Others', 2018, 'Red', 'eco mog', 0x363539326530306236633838335f63727970746f2d322e6a7067);

--
-- Triggers `vehicles`
--
DELIMITER $$
CREATE TRIGGER `toll_amount` BEFORE INSERT ON `vehicles` FOR EACH ROW BEGIN
    CASE NEW.vehicle_type
        WHEN 'Private car' THEN
            SET NEW.toll_amount = 2.00;
        WHEN '4x4 Vehicles' THEN
            SET NEW.toll_amount = 5.00;
        WHEN 'motorbike' THEN
            SET NEW.toll_amount = 1.00;
        WHEN 'Triclyes' THEN
            SET NEW.toll_amount = 1.00;
        WHEN 'Heavy Goods Vehicles' THEN
            SET NEW.toll_amount = 30.00;
        WHEN 'Minibuses' THEN
            SET NEW.toll_amount = 1.00;
    END CASE;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `earning`
--
ALTER TABLE `earning`
  ADD PRIMARY KEY (`earning_id`),
  ADD KEY `user_id_idx` (`user_id`);

--
-- Indexes for table `qrcodes`
--
ALTER TABLE `qrcodes`
  ADD PRIMARY KEY (`qrcode_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `toll_access`
--
ALTER TABLE `toll_access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `toll_booths`
--
ALTER TABLE `toll_booths`
  ADD PRIMARY KEY (`toll_booth_id`);

--
-- Indexes for table `toll_subscribe`
--
ALTER TABLE `toll_subscribe`
  ADD PRIMARY KEY (`subscription_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `toll_booth_id` (`toll_booth_id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `earning`
--
ALTER TABLE `earning`
  MODIFY `earning_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `qrcodes`
--
ALTER TABLE `qrcodes`
  MODIFY `qrcode_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `earning`
--
ALTER TABLE `earning`
  ADD CONSTRAINT `earning_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `qrcodes`
--
ALTER TABLE `qrcodes`
  ADD CONSTRAINT `qrcodes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `toll_access`
--
ALTER TABLE `toll_access`
  ADD CONSTRAINT `toll_access_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
