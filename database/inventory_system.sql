-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 12, 2020 at 08:44 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_status` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `brand_status`) VALUES
(1, 'Samsung', '1'),
(6, 'Apple', '1'),
(7, 'LG', '1'),
(8, 'Huawei ', '1'),
(15, 'Sony', '1'),
(16, 'Adidas', '1'),
(17, 'Nike', '1'),
(18, 'Puma', '1');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_category` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_category`, `category_name`, `category_status`) VALUES
(1, 0, 'Electronic', '1'),
(5, 0, 'Books', '1'),
(6, 1, 'Mobile', '1'),
(8, 1, 'Laptop', '1'),
(10, 5, 'Programming', '1'),
(11, 5, 'Science ', '1'),
(13, 0, 'Clothes', '1'),
(20, 0, 'Appliances', '1'),
(22, 13, 'T-shirts', '1'),
(24, 20, 'Refrigerator', '1'),
(25, 20, 'Smart TV', '1'),
(57, 0, 'Fashion', '1'),
(58, 0, 'Sports', '1'),
(59, 57, 'Man\'s Fashion', '1'),
(60, 57, 'Women\'s Fashion', '1'),
(61, 0, 'Toys and Gams', '1'),
(62, 61, 'Baby toys', '1'),
(63, 61, 'Grown up toys', '1'),
(64, 0, 'Home', '1'),
(66, 64, 'Kitchen', '1'),
(68, 64, 'Living room', '1');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `order_date` date NOT NULL,
  `sub_total` double NOT NULL,
  `gst` double NOT NULL,
  `discount` double NOT NULL,
  `net_total` double NOT NULL,
  `paid` double NOT NULL,
  `due` double NOT NULL,
  `payment_type` tinytext NOT NULL,
  `invoice_pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `customer_name`, `order_date`, `sub_total`, `gst`, `discount`, `net_total`, `paid`, `due`, `payment_type`, `invoice_pdf`) VALUES
(18, 'Mohammed Hassan', '2020-07-11', 95400, 17172, 500, 112072, 112072, 0, 'Cash', 'uploads/invoices/18_2020-11-08.pdf'),
(20, 'Hassan Ali', '2020-07-11', 57500, 10350, 2000, 65850, 65850, 0, 'Cash', 'uploads/invoices/20_2020-11-08.pdf'),
(21, 'Sara Khaled', '2020-07-11', 10700, 1926, 100, 12526, 12526, 0, 'Cash', 'uploads/invoices/21_2020-11-08.pdf'),
(24, 'Yasser Abdualrahman', '2020-07-11', 11000, 1980, 50, 12930, 12930, 0, 'Cash', 'uploads/invoices/24_2020-11-08.pdf'),
(25, 'Husam Hssan', '2020-07-11', 14200, 2556, 100, 16656, 16656, 0, 'Cash', 'uploads/invoices/25_2020-11-09.pdf'),
(26, 'Thamer Alhassan', '2020-07-11', 14000, 2520, 400, 16120, 16120, 0, 'Cash', 'uploads/invoices/26_2020-11-09.pdf'),
(27, 'Osama Mohammed', '2020-07-11', 14000, 2520, 200, 16320, 16320, 0, 'Cash', 'uploads/invoices/27_2020-11-07.pdf'),
(28, 'Hana Hani', '2020-09-11', 2150, 387, 100, 2437, 2437, 0, 'Cash', 'uploads/invoices/28_2020-11-09.pdf'),
(29, 'Sara Slaman', '2020-09-11', 8000, 1440, 0, 9440, 0, 9440, 'Cash', 'uploads/invoices/29_2020-11-09.pdf'),
(30, 'Qasim Hsaan', '2020-09-11', 10700, 1926, 200, 12426, 12426, 0, 'Cash', 'uploads/invoices/30_2020-11-09.pdf'),
(31, 'Husam Hassan', '2020-09-11', 10500, 1890, 100, 12290, 12290, 0, 'Cash', 'uploads/invoices/31_2020-11-09.pdf'),
(32, 'Saleh Alhssan', '2020-09-11', 7800, 1404, 300, 8904, 8904, 0, 'Cash', 'uploads/invoices/32_2020-11-09.pdf'),
(33, 'Faris Ali', '2020-09-11', 7000, 1260, 200, 8060, 8060, 0, 'Cash', 'uploads/invoices/33_2020-11-09.pdf'),
(34, 'Dana Nasser', '2020-09-11', 1150, 207, 149.99, 1207.01, 1207.01, 0, 'Cash', 'uploads/invoices/34_2020-11-09.pdf'),
(35, 'John Doe', '2020-09-11', 7000, 1260, 100, 8160, 8160, 0, 'Cash', 'uploads/invoices/35_2020-11-12.pdf'),
(37, 'Traver Kemmil', '2020-09-11', 6700, 1206, 50, 7856, 7856, 0, 'Cash', 'uploads/invoices/37_2020-11-12.pdf'),
(38, 'Leian Slaman', '2020-09-11', 1850, 333, 100, 2083, 2083, 0, 'Cash', 'uploads/invoices/38_2020-11-12.pdf'),
(39, 'Slaman Saleh', '2020-09-11', 10200, 1836, 5000, 7036, 7036, 0, 'Cash', 'uploads/invoices/39_2020-11-12.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`id`, `invoice_id`, `product_name`, `price`, `qty`) VALUES
(39, 18, 'Samsung Galaxy S20 128GB Cosmic Gray', 3500, 20),
(40, 18, 'IPhone 11 64GB White', 3500, 3),
(41, 18, 'IPhone 11 256GB Blue', 3800, 3),
(42, 18, 'IPhone 11 64GB White', 3500, 1),
(46, 20, 'IPhone 11 64GB White', 3500, 1),
(47, 20, 'IPhone 11 pro 256GB Gold', 4000, 4),
(48, 20, 'IPhone 11 256GB Blue', 3800, 10),
(49, 21, 'IPhone 11 pro 256GB Gold', 4000, 1),
(50, 21, 'IPhone 11 64GB White', 3500, 1),
(51, 21, 'IPhone 11 128GB Red', 3200, 1),
(58, 24, 'IPhone 11 pro 256GB Gold', 4000, 1),
(59, 24, 'Samsung Galaxy S20 128GB Cosmic Gray', 3500, 1),
(60, 24, 'IPhone 11 64GB White', 3500, 1),
(61, 25, 'IPhone 11 64GB White', 3500, 1),
(62, 25, 'IPhone 11 pro 256GB Gold', 4000, 1),
(63, 25, 'Samsung Galaxy S20 128GB Cosmic Gray', 3500, 1),
(64, 25, 'IPhone 11 128GB Red', 3200, 1),
(65, 26, 'IPhone 11 64GB White', 3500, 1),
(66, 26, 'Samsung Galaxy S20 128GB Cosmic Gray', 3500, 1),
(67, 26, 'IPhone 11 128GB Red', 3200, 1),
(68, 26, 'IPhone 11 256GB Blue', 3800, 1),
(69, 27, 'IPhone 11 64GB White', 3500, 1),
(70, 27, 'Samsung Galaxy S20 128GB Cosmic Gray', 3500, 1),
(71, 27, 'IPhone 11 128GB Red', 3200, 1),
(72, 27, 'IPhone 11 256GB Blue', 3800, 1),
(73, 28, 'Adidas Men UltraBoost, Running, Sports Shoes, black', 300, 3),
(74, 28, 'Nike Women Tanjun, Low-top Sneakers, black', 250, 5),
(75, 29, 'Adidas Men UltraBoost, Running, Sports Shoes, black', 300, 10),
(76, 29, 'Nike Women Tanjun, Low-top Sneakers, black', 250, 20),
(77, 30, 'IPhone 11 64GB White', 3500, 1),
(78, 30, 'IPhone 11 pro 256GB Gold', 4000, 1),
(79, 30, 'IPhone 11 128GB Red', 3200, 1),
(80, 31, 'IPhone 11 64GB White', 3500, 1),
(81, 31, 'IPhone 11 256GB Blue', 3800, 1),
(82, 31, 'IPhone 11 128GB Red', 3200, 1),
(83, 32, 'IPhone 11 pro 256GB Gold', 4000, 1),
(84, 32, 'Samsung Galaxy S20 128GB Cosmic Gray', 3500, 1),
(85, 32, 'Adidas Men UltraBoost, Running, Sports Shoes, black', 300, 1),
(86, 33, 'IPhone 11 64GB White', 3500, 1),
(87, 33, 'Samsung Galaxy S20 128GB Cosmic Gray', 3500, 1),
(88, 34, 'Adidas Men UltraBoost, Running, Sports Shoes, black', 300, 3),
(89, 34, 'Nike Women Tanjun, Low-top Sneakers, black', 250, 1),
(90, 35, 'IPhone 11 64GB White', 3500, 1),
(91, 35, 'Samsung Galaxy S20 128GB Cosmic Gray', 3500, 1),
(94, 37, 'IPhone 11 128GB Red', 3200, 1),
(95, 37, 'IPhone 11 64GB White', 3500, 1),
(96, 38, 'Nike Women Tanjun, Low-top Sneakers, black', 250, 5),
(97, 38, 'Adidas Men UltraBoost, Running, Sports Shoes, black', 300, 2),
(98, 39, 'Samsung Galaxy S20 128GB Cosmic Gray', 3500, 1),
(99, 39, 'IPhone 11 64GB White', 3500, 1),
(100, 39, 'IPhone 11 128GB Red', 3200, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(15,2) NOT NULL,
  `product_stock` int(11) NOT NULL,
  `product_added_date` date NOT NULL,
  `product_status` enum('1','0') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand_id`, `product_name`, `product_price`, `product_stock`, `product_added_date`, `product_status`) VALUES
(1, 6, 6, 'IPhone 11 64GB White', '3500.00', 177, '2020-10-31', '1'),
(2, 6, 6, 'IPhone 11 pro 256GB Gold', '4000.00', 32, '2020-10-31', '1'),
(3, 6, 1, 'Samsung Galaxy S20 128GB Cosmic Gray', '3500.00', 320, '2020-10-31', '1'),
(7, 6, 6, 'IPhone 11 128GB Red', '3200.00', 91, '2020-10-31', '1'),
(11, 59, 16, 'Adidas Men UltraBoost, Running, Sports Shoes, black', '300.00', 30, '2020-11-08', '1'),
(12, 60, 17, 'Nike Women Tanjun, Low-top Sneakers, black', '250.00', 69, '2020-11-08', '1'),
(13, 20, 1, 'Samsung Refrigerator, 18.6 Cu.ft,Elegant Inox', '1499.00', 47, '2020-11-10', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_type` enum('Admin','Manager','User') NOT NULL DEFAULT 'User',
  `user_last_login` datetime NOT NULL DEFAULT current_timestamp(),
  `user_notes` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `user_email`, `user_password`, `user_type`, `user_last_login`, `user_notes`, `avatar`, `created_at`) VALUES
(1, 'Admin', 'admin@inventorysystem.com', '$2y$10$JIz2HN6oR.M/RyHfcJsbIONWeiw9yxrb/qlLno6/1RvGvSP8cyh.O', 'Admin', '2020-11-12 06:47:58', '', 'uploads/avatars/1604876605images (1).png', '2020-10-29 10:56:42'),
(2, 'Test', 'test@test.com', '$2y$10$7kD0Tw0uLrBFZbVKPNui.eT01lErLvi9o0gvu1wN8UpFdCxP9kUdK', 'User', '2020-10-29 12:05:30', '', NULL, '2020-10-29 11:16:18'),
(3, 'Test1', 'test1@test.com', '$2y$10$ECN4BwelRQr4XtfEQWgZK.70fBCokn36vYvhus05GVKrCDzNptlsy', 'User', '2020-10-29 12:05:43', '', NULL, '2020-10-29 12:02:46'),
(4, 'jenan', 'jenan@test.com', '$2y$10$I1LCNlhqCeIqm0hbcCcs7uULWqrYzFLfmE8FlNAY4ZCvxvoYuim0.', 'User', '2020-10-29 12:45:12', '', NULL, '2020-10-29 12:45:12'),
(5, 'hasan', 'hasan@gmail.com', '$2y$10$FeesslT7HlgJ0iaqQ8bJ7OzLIp9ZMMBxkAnFseATB/QNdoowoscOG', 'User', '2020-10-29 12:46:58', '', NULL, '2020-10-29 12:46:58'),
(6, 'abbas', 'abbas20@gmail.com', '$2y$10$HM8d1JLkL7/Z523DCkShzOwcbv9FiY35F7uoBg/KUWvbd833oBrra', 'User', '2020-10-29 12:50:08', '', NULL, '2020-10-29 12:50:08'),
(7, 'ola', 'oali@gmail.com', '$2y$10$kedr65CjyWQFAXpEucUQTum/qPt3sQ3KHQRUSC561sLkjUc7CMlfS', 'User', '2020-10-30 10:00:22', '', NULL, '2020-10-30 10:00:22'),
(8, 'husam', 'hhasn@gmail.com', '$2y$10$.IqBjHMQd4qvL1TxjY6FJeO4hCuCLEi/eO9zCXl/tPCoL0vz06hXe', 'User', '2020-10-30 10:05:05', '', NULL, '2020-10-30 10:05:05'),
(9, 'husam', 'aa@gmail.com', '$2y$10$OdGZyDoAYVRctwF44U4ABOqSukaKwi09deTcLP7h9QM9WNJWXokHO', 'User', '2020-10-30 10:07:12', '', NULL, '2020-10-30 10:07:12'),
(11, 'sara', 'smohamed@gmail.com', '$2y$10$ess4B15jWUwQUjCHXWMCI.bFHn.Dd7jMTM6ZyjrnMKlNGp.eUQ6Di', 'User', '2020-10-30 10:15:18', '', NULL, '2020-10-30 10:15:18'),
(12, 'Ahmed', 'ahmed@ahemd.com', '$2y$10$V41cl/pgt9oSrwz6a8YUGe9k4mnAbzQZE4uIwj6mBYkkh7/Vtc2uS', 'User', '2020-11-08 23:09:14', '', 'uploads/avatars/1605079202hacked.png', '2020-11-08 23:09:05'),
(17, 'user_test', 'user@inventorysystem.com', '$2y$10$s3W3TNvxaxR1.tmTYWa4A.VQqIOxggqlMm8eZPhKUlWO5r4WUlWoS', 'User', '2020-11-12 01:59:43', '', 'uploads/avatars/1605146393defualt.png', '2020-11-11 07:55:59'),
(18, 'managerv', 'manager@inventorysystem.com', '$2y$10$Rf27Pa42dYN9J2gKBGlF3ed4MD/nHh7bgPHU1xOY87IUZG/hu69Um', 'Manager', '2020-11-12 01:57:52', '', 'uploads/avatars/1605146365defualt.png', '2020-11-11 07:56:48'),
(21, 'test', 'test@test.test', '$2y$10$ymCDDTYEna7qBcUGQmMIOeQDJFBb80AD4T8qbeLka0efjiWg4D76C', 'Admin', '2020-11-12 06:32:17', '', NULL, '2020-11-12 06:29:50'),
(23, 'new', 'new@new.new', '$2y$10$yoBGL3oj/NuRtDD4SlLwDOBKK3b3OAVBGHH9/0E/LIcxHJbL6Wj6C', 'User', '2020-11-12 06:41:50', '', NULL, '2020-11-12 06:41:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brand_name` (`brand_name`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_invoice_details` (`invoice_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_category` (`category_id`),
  ADD KEY `product_brand` (`brand_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD CONSTRAINT `invoice_invoice_details` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `product_brand` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
