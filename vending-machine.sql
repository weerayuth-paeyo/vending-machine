-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2021 at 09:16 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vending-machine`
--

-- --------------------------------------------------------

--
-- Table structure for table `money_amount`
--
-- Error reading structure for table vending-machine.money_amount: #1932 - Table 'vending-machine.money_amount' doesn't exist in engine
-- Error reading data for table vending-machine.money_amount: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `vending-machine`.`money_amount`' at line 1

-- --------------------------------------------------------

--
-- Table structure for table `money_type`
--

CREATE TABLE `money_type` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `value` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `money_type`
--

INSERT INTO `money_type` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, '1 บาท', 1, '2021-10-13 07:14:46', '2021-10-13 07:37:12'),
(2, '2 บาท', 2, '2021-10-13 07:14:46', '2021-10-13 07:37:12'),
(3, '5 บาท', 5, '2021-10-13 07:24:42', '2021-10-13 07:37:12'),
(4, '10 บาท', 10, '2021-10-13 07:24:42', '2021-10-13 07:37:12'),
(5, '20 บาท', 20, '2021-10-13 07:24:42', '2021-10-13 07:37:12'),
(6, '50 บาท', 50, '2021-10-13 07:24:42', '2021-10-13 07:37:12'),
(7, '100 บาท', 100, '2021-10-13 07:24:42', '2021-10-13 07:37:12'),
(8, '500 บาท', 500, '2021-10-13 07:24:42', '2021-10-13 07:37:12'),
(9, '1000 บาท', 1000, '2021-10-13 07:24:42', '2021-10-13 07:37:12');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `amount` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `amount`, `created_at`, `updated_at`) VALUES
(8, 'เลย์', 50, 4, '2021-10-12 23:34:32', '2021-10-13 20:14:19'),
(10, 'ตะวัน', 30, 2, '2021-10-12 23:35:22', '2021-10-14 22:06:01'),
(14, 'ขนมมัด', 35, 8, '2021-10-13 20:00:53', '2021-10-13 21:54:42'),
(15, 'โดโซะ', 22, 8, '2021-10-13 20:02:07', '2021-10-13 20:02:07');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'จัดการ', '2021-10-13 19:15:15', '2021-10-13 19:15:15'),
(2, 'ทั่วไป', '2021-10-13 19:15:15', '2021-10-13 19:15:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 1,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', '$2y$10$ghivYYqdE78e6ko6TDiqb.XaRP.3nPjPHGkkOuxqt8ZsZf1FAnd/G', '2021-10-13 18:55:38', '2021-10-14 00:30:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `money_type`
--
ALTER TABLE `money_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `money_type`
--
ALTER TABLE `money_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
