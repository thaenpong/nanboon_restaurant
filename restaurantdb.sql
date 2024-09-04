-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 18, 2024 at 11:03 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurantdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(2, 'อาหารอีสาน'),
(3, 'ส้มตำ'),
(4, 'ต้ม'),
(5, 'อาหารตามสั่ง'),
(6, 'เครื่องเคียง'),
(13, 'เครื่องดื่ม');

-- --------------------------------------------------------

--
-- Table structure for table `desks`
--

CREATE TABLE `desks` (
  `id` int(11) NOT NULL,
  `label` varchar(50) NOT NULL,
  `sheets` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `takeAway` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `desks`
--

INSERT INTO `desks` (`id`, `label`, `sheets`, `status`, `takeAway`) VALUES
(1, 'โต๊ะ 1', 7, 1, 0),
(2, 'โต๊ะ 2', 12, 1, 0),
(3, 'โต๊ะ 3', 4, 0, 0),
(4, 'โต๊ะ 4', 4, 1, 0),
(5, 'โต๊ะ 5', 6, 1, 0),
(6, 'โต๊ะ 6', 4, 1, 0),
(20, 'กลับบ้าน', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `detail` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `categorieId` int(11) NOT NULL,
  `discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `price`, `detail`, `image`, `status`, `categorieId`, `discount`) VALUES
(1, 'ไก่อบฟาง', 200, '', '1.jpg', 1, 5, 10),
(2, 'ตำปูปลาร้ากุ้งสด', 50, '', '2.webp', 1, 3, 0),
(3, 'ต้มไก่', 50, '', '3.jpg', 1, 4, 0),
(4, 'แกงอ่อม', 50, '', '52.jpg', 1, 4, 2),
(5, 'ต้มจืดวุ้นเส้น', 60, '', '5.jpg', 1, 4, 0),
(6, 'ต้มจืดไข่น้ำ', 60, '', '6.jpg', 1, 4, 0),
(7, 'ยำไก่บ้าน', 160, '', '7.jpg', 1, 3, 0),
(8, 'ไก่บ้านผัดพริกลาบ', 180, '', '8.jpg', 1, 13, 0),
(9, 'แหนม', 15, '', '9.jpg', 1, 5, 0),
(10, 'แหนมห่อไข่', 60, '', '10.jpg', 1, 13, 0),
(11, 'ตำปูปลาร้า', 40, '', '11.jpg', 1, 3, 0),
(12, 'ตำแตง', 40, '', '12.webp', 1, 3, 0),
(13, 'ตำไทย', 40, '', '13.jpg', 1, 3, 0),
(27, 'ไก่ทอด', 55, '', '27.webp', 1, 6, 0),
(53, 'ข้าวเหนียว', 10, '', '53.jpg', 1, 6, 0),
(54, 'ข้าวสวย', 10, '', '54.jpg', 1, 6, 0),
(55, 'ข้าวไข่เจียว', 30, '', '55.jpg', 1, 5, 0),
(56, 'ลาบหมูสุก', 60, '', '56.jpg', 1, 2, 0),
(57, 'ลาบหมูดิบ', 60, '', '57.jpg', 1, 2, 0),
(58, 'น้ำตกหมู', 60, '', '58.jpg', 1, 2, 0),
(59, 'กระเพรา', 40, '', '59.webp', 1, 5, 0),
(60, 'ข้าวผัดหมู', 35, '', '60.jpg', 1, 5, 0),
(61, 'น้ำเปล่าขวดเล็ก', 10, '', '61.webp', 1, 13, 0),
(62, 'น้ำเปล่าขวดใหญ่', 20, '', '62.avif', 1, 13, 0),
(63, 'แป็ปซี่ (เล็ก)', 15, '', '63.webp', 1, 13, 0),
(64, 'แป็ปซี่ (ใหญ่)', 25, '', '64.jfif', 1, 13, 0),
(65, 'เบียร์ช้าง', 60, '', '65.png', 0, 13, 0),
(66, 'เบียรลีโอ', 70, '', '66.jpg', 1, 13, 0),
(67, 'เบียรสิงห์', 80, '', '67.jfif', 1, 13, 0),
(68, 'น้ำแข็ง', 15, '', '68.jpg', 1, 13, 0),
(69, 'ไข่ดาว', 7, '', '69.webp', 1, 5, 0),
(70, 'ไข่เจียว', 10, '', '70.jfif', 1, 5, 0),
(71, 'ผัดเผ็ดหมูป่า', 80, '', NULL, 1, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `menuId` int(11) NOT NULL,
  `quantity` varchar(11) NOT NULL,
  `note` varchar(255) NOT NULL,
  `createAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `discount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`id`, `orderId`, `menuId`, `quantity`, `note`, `createAt`, `discount`) VALUES
(4, 214, 1, '3', 'เผ็ด', '2024-03-10 14:51:17', 180),
(5, 214, 1, '2', 'หวาน', '2024-03-10 14:51:17', 120),
(6, 214, 3, '1', '', '2024-03-10 14:51:17', 0),
(7, 215, 11, '1', '', '2024-04-11 09:21:11', 0),
(8, 215, 7, '1', '', '2024-04-11 09:21:11', 0),
(9, 215, 12, '1', '', '2024-04-11 09:21:11', 0),
(10, 216, 1, '5', '5', '2024-04-12 07:22:52', 100),
(11, 217, 3, '1', '', '2024-04-12 08:10:13', 0),
(12, 217, 4, '1', '', '2024-04-12 08:10:13', 1),
(13, 218, 1, '2', '', '2024-04-12 08:10:21', 20),
(14, 219, 2, '6', '1', '2024-04-18 02:57:19', 0),
(15, 220, 3, '1', 'เผ็ด', '2024-04-18 03:50:24', 0),
(16, 221, 7, '1', 'เผ็ด', '2024-04-18 03:50:38', 0),
(17, 222, 3, '3', '', '2024-04-18 08:53:30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `deskId` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `doneAt` datetime DEFAULT NULL,
  `paytype` int(11) NOT NULL,
  `printed` tinyint(1) NOT NULL,
  `day_queue` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `userId`, `deskId`, `status`, `createdAt`, `doneAt`, `paytype`, `printed`, `day_queue`) VALUES
(214, 1, 1, 0, '2024-04-10 21:51:17', '2024-04-10 21:53:10', 1, 0, 1),
(215, 1, 2, 0, '2024-04-11 16:21:11', '2024-04-11 16:22:42', 0, 0, 1),
(216, 1, 5, 0, '2024-04-12 14:22:52', '2024-04-12 14:23:01', 0, 0, 1),
(217, 1, 1, 0, '2024-04-12 15:10:13', '2024-04-18 10:49:57', 1, 1, 2),
(218, 1, 2, 0, '2024-04-12 15:10:20', '2024-04-18 10:49:57', 1, 0, 3),
(219, 1, 4, 0, '2024-04-18 09:57:19', '2024-04-18 10:46:14', 1, 1, 1),
(220, 1, 1, 0, '2024-04-18 10:50:24', '2024-04-18 11:00:19', 1, 1, 2),
(221, 1, 2, 0, '2024-04-18 10:50:38', '2024-04-18 11:00:19', 1, 1, 3),
(222, 1, 3, 1, '2024-04-18 15:41:21', NULL, 0, 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `role` varchar(255) NOT NULL,
  `isactive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `username`, `password`, `role`, `isactive`) VALUES
(1, 'กนกวรรณ', 'ทัศนพันธ์เพชร', 'manager', '1122', 'manager', 1),
(2, 'ศุภรัตน์', 'ตาธารา', 'admin', '1234', 'admin', 1),
(3, 'อภิสิทธิ์', 'ขันนา', 'employee', 'aaaaaa', 'employee', 1),
(10, 'มงคล', 'ใจเบิกบาล', 'employee 2', '5678', 'employee', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `desks`
--
ALTER TABLE `desks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_label` (`label`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `categorieId` (`categorieId`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderId` (`orderId`),
  ADD KEY `menuId` (`menuId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `deskId` (`deskId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `desks`
--
ALTER TABLE `desks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`categorieId`) REFERENCES `categories` (`id`);

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`menuId`) REFERENCES `menus` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`deskId`) REFERENCES `desks` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
