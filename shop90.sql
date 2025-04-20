-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 09:01 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop90`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `created_at`, `updated_at`, `image`) VALUES
(1, 'เสื้อผ้า', 'เนื้อห\r\n', '2025-03-28 04:37:13', '2025-03-28 04:50:13', 'product3_hover_1.jpg'),
(2, 'dd', 'dd', '2025-03-28 04:46:51', '2025-03-28 04:46:51', 'product3_2.jpg'),
(3, 'กระเป๋า', 'สวยมาก2', '2025-03-28 04:50:31', '2025-03-30 00:00:05', 'product4_hover.jpeg'),
(4, 'vdvevev', 'กฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหก', '2025-03-29 07:11:45', '2025-04-20 05:21:11', 'boss.png'),
(5, 'ก', 'กฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหกกฟหกฟหกหฟกฟหกฟหก', '2025-04-20 05:00:41', '2025-04-20 05:27:26', 'product7.jpeg'),
(6, 'กฟ', 'กฟ', '2025-04-20 05:29:16', '2025-04-20 05:34:10', 'boss.png'),
(7, 'กฟ', 'กฟ', '2025-04-20 05:34:17', '2025-04-20 05:34:17', 'cart.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('y','n','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `price`, `quantity`, `created_at`, `updated_at`, `status`) VALUES
(72, 1, 17, '20.00', 1, '2025-04-19 23:17:47', '2025-04-19 23:17:47', 'y'),
(73, 2, 17, '20.00', 1, '2025-04-19 23:20:10', '2025-04-19 23:20:10', 'y'),
(76, 1, 16, '50.00', 5, '2025-04-20 02:00:13', '2025-04-20 02:00:19', 'y');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_image`) VALUES
(1, 'เสื้อผ้า', 'product6.jpeg'),
(3, 'เพลง', 'back7.jpg'),
(4, 'ของใช้', 'p70.jpg'),
(5, 'ของเล่น', '07.jpg'),
(6, 'อื่นๆ', '08.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `complaint_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`complaint_id`, `user_id`, `title`, `description`, `created_at`, `updated_at`, `status`) VALUES
(1, 2, '11', '11', '2025-04-17 13:20:20', '2025-04-20 13:03:48', 'n'),
(4, 1, 'ข้อความจาก phone (หน้า Contact Us)', 'อีเมลผู้ติดต่อ: langth0007@gmail.com\n\nข้อความ:\ndad', '2025-04-17 13:30:51', '2025-04-17 13:39:29', 'y'),
(5, 1, 'ข้อความจาก phone (หน้า Contact Us)', 'อีเมลผู้ติดต่อ: langth0007@gmail.com\n\nข้อความ:\ndad ลองลบ', '2025-04-17 13:31:09', '2025-04-17 14:12:17', 'y'),
(6, 1, 'ข้อความจาก phone (หน้า Contact Us)', 'อีเมลผู้ติดต่อ: langth0007@gmail.com\n\nข้อความ:\nda', '2025-04-17 13:31:22', '2025-04-17 14:13:44', 'n'),
(7, 1, 'ข้อความจาก phone ', 'dadada', '2025-04-17 13:33:21', '2025-04-17 13:39:37', 'y'),
(8, 1, '???? ข้อความใหม่จาก phone ', 'กฟกฟฟ', '2025-04-17 13:34:57', '2025-04-17 14:12:42', 'y'),
(9, 1, 'ข้อความใหม่จาก phone ', 'dad', '2025-04-17 13:36:19', '2025-04-20 13:05:31', 'n'),
(10, 1, 'ข้อความใหม่จาก phone ', '122', '2025-04-20 13:00:34', '2025-04-20 13:03:38', 'y'),
(11, 1, 'ข้อความใหม่จาก phone ', '111', '2025-04-20 13:01:42', '2025-04-20 13:07:45', 'n'),
(12, 1, 'ข้อความใหม่จาก phone ', 'กฟ', '2025-04-20 13:03:27', '2025-04-20 13:07:21', 'n');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(255) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('รอดำเนินการ','กำลังจัดส่ง','สำเร็จ','ยกเลิก') NOT NULL DEFAULT 'รอดำเนินการ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_id`, `total_price`, `created_at`, `status`) VALUES
(1, 1, 0, '0.00', '2025-03-27 10:00:16', 'รอดำเนินการ'),
(5, 1, 0, '1250.00', '2025-03-28 04:21:02', 'รอดำเนินการ');

-- --------------------------------------------------------

--
-- Table structure for table `order_history`
--

CREATE TABLE `order_history` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `delivery_company` varchar(100) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `shipping_address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('รอดำเนินการ','กำลังจัดส่ง','จัดส่งแล้ว') DEFAULT 'รอดำเนินการ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_history`
--

INSERT INTO `order_history` (`order_id`, `user_id`, `product_id`, `quantity`, `price`, `total`, `tracking_number`, `delivery_company`, `order_date`, `shipping_address`, `phone`, `status`) VALUES
(1, 1, 17, 2, '10.00', '20.00', '25555', 'Kerry Express', '2025-04-04 00:00:00', '25', '25', 'กำลังจัดส่ง'),
(2, 1, 20, 4, '20.00', '80.00', NULL, NULL, '2025-04-05 12:27:05', '1203/61', '0615867257', 'จัดส่งแล้ว'),
(3, 1, 21, 1, '120.00', '120.00', '25555', 'Flash Express', '2025-04-04 00:00:00', '1203/64', '0615867257', 'จัดส่งแล้ว'),
(4, 2, 16, 2, '50.00', '100.00', '25555', 'Kerry Express', '2025-04-14 00:00:00', '1212', '212', 'กำลังจัดส่ง'),
(5, 1, 17, 1, '10.00', '10.00', '25555', 'Kerry Express', '2025-04-06 09:59:15', '1203/61', '0615867257', 'กำลังจัดส่ง'),
(6, 1, 21, 3, '120.00', '360.00', NULL, NULL, '2025-04-06 09:59:15', '1203/61', '0615867257', 'จัดส่งแล้ว'),
(7, 1, 17, 6, '20.00', '120.00', NULL, NULL, '2025-04-07 14:48:00', '1203/61', '0615867257', 'รอดำเนินการ'),
(8, 1, 16, 2, '50.00', '100.00', '25555', 'Flash Express', '2025-04-05 00:00:00', '41/5', '0615867257', 'จัดส่งแล้ว'),
(9, 1, 17, 1, '20.00', '20.00', NULL, NULL, '2025-04-19 13:48:55', '1203/61', '0615867257', 'จัดส่งแล้ว'),
(10, 2, 21, 4, '120.00', '480.00', '25555', 'Flash Express', '2025-05-02 00:00:00', '2022', '0615867257', 'จัดส่งแล้ว'),
(11, 1, 17, 1, '20.00', '20.00', NULL, NULL, '2025-04-20 11:09:13', '1203/61', '0615867257', 'รอดำเนินการ'),
(12, 1, 16, 1, '50.00', '50.00', NULL, NULL, '2025-04-20 11:09:13', '1203/61', '0615867257', 'รอดำเนินการ');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_image_hover` varchar(255) DEFAULT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_description` text DEFAULT NULL,
  `product_rating` decimal(2,1) DEFAULT 0.0,
  `product_stock` int(255) NOT NULL,
  `category_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_image`, `product_image_hover`, `product_price`, `product_description`, `product_rating`, `product_stock`, `category_id`) VALUES
(16, 'กระเป๋าสีขาว', 'product4_hover.jpeg', 'product4_1.jpg', '100.00', 'TAIDU กระเป๋าสะพายไหล่ กระเป๋าสะพายข้างวินเทจยุค 90\'s สุดเท่ วัสดุโพลีเอสเตอร์ ความจุขนาดใหญ่', '2.5', 100, '2'),
(17, 'เสื้อยืดลายกราฟิก', 'product3_2.jpg', 'product3_hover.jpg', '90.00', 'เสื้อวินเทจยุค90  SMELLS LIKE โครตเท่(ส่งเร้ว )✅ของแท้100%', '2.0', 500, '1'),
(20, 'เทปเพลงครูในดวงใจ', 'f599936357c2dc7f745cf84990691192.jpg', 'birhb5.jpg', '120.00', 'เทปเพลงมือ2สภาพดีผ่านการเทสเสียงแล้วทุกม้วนก่อนลงขายคับ\r\n\r\nปกและม้วนสภาพสวย สนใจเลือกซื้อไปฟังไปสะสมกันได้เลยคาบซื้อกับเรามั่นใจได้ในคุณภาพสินค้าและบริการหลังการขาย \r\nสนใจสอบถามรายละเอียดเกี่ยวกับสินค้าแชทมาได้เลยนะค้าบ\r\nจะรีบเข้ามาตอบครับ', '2.0', 20, '3'),
(21, 'เทปเพลงคาราบาวอัลบั้ม วณิพก', 'yd.jpg', 'ja.jpg', '120.00', 'ขายเทปเพลง เพลงเพื่อชีวิต\r\nอัลบั้ม : ‪วณิพก\r\nนักร้อง : คาราบาว\r\nคุณภาพ : มีปกเทป มีม้วนเทป ทดสอบเสียงแล้วปกติพร้อมฟัง\r\n- สินค้าได้ทำการตรวจเช็คคุณภาพของเสียงให้อยู่ในสภาพพร้อมใช้งาน\r\n- ได้ทำการซีลพลาสติกเพื่อป้องกันฝุ่น', '2.0', 20, '3'),
(22, 'เทปเพลงเพื่อชีวิต คาราบาว ชุด กินใจ', 'd3.jpg', '8k.jpg', '120.00', 'เทปคาสเซ็ท สภาพดี ตลับเทปตรงกับปกกล่องเทป\r\nเจ้าของร้านได้ตรวจดูด้วยสายตาทุกม้วน เส้นเทปไม่ขาด\r\nตัวตลับเทปไม่แตกหัก อยู่สภาพสมบูรณ์\r\nตัวกล่องเทปอาจจะมีรอยร้าว ขีดข่วนบ้างตามสภาพที่ผ่านมา\r\nเจ้าของร้านไม่มีเครื่องที่จะทดลองฟัง ทำให้ไม่สามารถรู้ได้ว่าเสียงของเพลงในเทปจะเป็นเช่นไร  แนะนำให้เก็บสะสมเท่านั้น ไม่สามารถรับรองเรื่องของคุณภาพเสียงได้ครับ', '0.0', 20, '3'),
(23, 'เสื้อวง Kiss ปี 2010 Size S สินค้าลิขสิทธิ์แท้ 100%', 'um.jpg', 'vf.jpg', '1200.00', '	\r\nKiss ปี 2010 Size S อก 19.5“ ยาว 27” ผ้าคอตต้อน 100 เข็บคู่ ไม่มีข้าง สภาพ 100% ป้ายคอ Ten', '0.0', 5, '1'),
(24, 'เสื้อวง AC-DC ลิขสิทธิ์แท้100%', 'l4.jpg', '2x.jpg', '1100.00', 'เสื้อวง AC-DC ลิขสิทธิ์แท้100%\r\n\r\nป้ายGildan\r\nปี 2017\r\nSize พร้อมส่ง\r\nS อก18”ความยาว28”\r\nM อก20”ความยาว29”\r\nL อก22”ความยาว30”\r\nXl อก24”ความยาว31”', '0.0', 5, '1'),
(25, 'เสื้อวง DEF LEPPARD ลิขสิทธิ์แท้100%', 'uw.jpg', 'z6.jpg', '950.00', 'เสื้อวง DEF LEPPARD ลิขสิทธิ์แท้100%\r\nป้าย Gildan\r\nSize พร้อมส่ง\r\nM อก20” ความยาว29”\r\nL อก22” ความยาว30”\r\nXL อก24”ความยาว30.5”', '0.0', 5, '1'),
(26, 'เก้าอี้ตัดผมโบราณ หลังกลม ยุคพระนคร', '462920691_8470437399703916_8220377031588916959_n.jpg', '463033316_8470437379703918_6538883070512336489_n (2).jpg', '15200.00', 'เก้าอี้ตัดผมชาย หลังกลม ในยุคของพระนคร', '0.0', 1, '4'),
(27, 'ตะเกียงเจ้าพายุ', '7m.jpg', '6u.jpg', '890.00', 'ขนาดเล็ก\r\n\r\nสูง 7 นิ้ว \r\n\r\nกว้าง 5 นิ้ว\r\n\r\n- เป็นของใหม่\r\n\r\n- สามารถ ใช้งาน จุดไฟ ได้จริงๆ\r\n\r\n- เติมน้ำมันได้จริง\r\n\r\n- เปลี่ยนใส้ได้\r\n\r\n- วัสดุเป็นโลหะ\r\n\r\n- ประดับ ตกแต่ง ของแต่งบ้าน ร้าน โรงแรม รีสอร์ท แนวของเก่าโบราณ วินเทจ Vintage', '0.0', 3, '4'),
(28, 'ทามาก๊อต', 'o6zyqfb5cfy4Eg1OphM-o.jpg', 'o70fsg6b4TR6dq0QXVD-o.jpg', '120.00', 'ทามาก๊อตของเล่นยุค90', '0.0', 80, '5'),
(29, 'หมากฝรั่ง บุหรี่ตราแมวดำ', 'b2ed0c0d7c8675d631b5612d46f1bdd6.jpg', 'images.jpg', '10.00', 'เด็กไทยที่รู้จักมานี ก็คงต้องรู้จักหมากฝรั่งแมวดำอันนี้เป็นแน่แท้ แม้ว่าเราจะห่างกับมานีมานะมาเเล้วแสนไกล แต่รู้หรือไม่ อีบุหรี่แมวดำนี่ก็ยังผลิตมาอย่างต่อเนื่อง ไม่เชื่อก็ดูวันหมดอายุสิ', '0.0', 200, '5'),
(30, 'จานสังกะสีเคลือบ สีขาว (แบบยกโหล)', '4g.jpg', '50.jpg', '400.00', 'จานสังกะสีเคลือบ8 (20ซม.) กระต่าย /ยกโหล 12 ใบ\r\nEnamelware เป็นเครื่องครัวแบบอเมริกันที่สร้างขึ้นในยุค 1870 ทำจากเหล็กคุณภาพสูงจากนั้นเคลือบด้วยแก้วในเตาอบที่ร้อนมาก การเคลือบ Enamel เป็นการเคลือบ ที่ทำใส่อนุภาคของแก้วลงไปบนผิวของภาชนะโลหะ ทำให้ได้ผิวที่เรียบลื้น, ไม่ติดและไม่ไม่ทำปฏิกริยากับอาหาร ภาชนะที่เคลือบ Enamel ปลอดภัยต่อสุขภาพ, สวยงาม และทนต่อความร้อนสูงได้ดี เนื่องจากเนื้อ Enamel นั้นเรียบสนิทไม่ค่อยมีรูพรุ่นทำให้ทำความสะอาดแล้วมีคราบอาหารหรือเชื้อโรคตกค้างน้อยมาก\r\nข้อด้อยของ Enamel ก็คืออาจจะกระเทาะได้ เพราะ Enamel คือการเคลือบด้วยแก้วจึงไม่ทนต่อการกระแทก แต่ถ้าได้รับการดูแลดีๆ ภาชนะเคลือบ enamel นี่จะทนชั่วลูกชั่วหลานแบบที่เราเคยเห็นคนรุ่นพ่อรุ่นแม่เราใช้แน่นอน\r\n', '0.0', 700, '4'),
(31, 'ช้อนสังกะสี (สีเขียว แบบ โหลนึง)', '07291a63-46c6-43cb-a68a-6f378bfd5ca9.jpg', 'e8705fe0-ef3a-4a3e-a444-51d890fcace2.jpg', '300.00', 'ช้อนสังกะสี (สีเขียว) แบบบาง เป็นของเก่าเก็บ ไม่ผ่านการใช้งาน เริ่มหายากขึ้นทุกวัน มีไม่มาก', '0.0', 90, '4'),
(32, 'เตารีดเตาถ่าน', 'S31a8a534e72f4c298ff01bec85bf5140b.jpg', 'Sb8258daacff84c83805364a38ea9e62dd.jpg', '350.00', 'เตารีดแบบโบราณ ใช้รีดผ้าของคนสมัยก่อน', '0.0', 5, '4'),
(34, 'เสื้อยืดลายกราฟิก2', '07291a63-46c6-43cb-a68a-6f378bfd5ca9.jpg', '67e85f17b5252.jpg', '100.00', 'กฟมาd', '0.0', 1100, '1'),
(39, 'ชื่อสินค้า', '463033316_8470437379703918_6538883070512336489_n (2).jpg', '462920691_8470437399703916_8220377031588916959_n.jpg', '100.00', NULL, '0.0', 55, 'ของใช้');

-- --------------------------------------------------------

--
-- Table structure for table `product_detail`
--

CREATE TABLE `product_detail` (
  `product_detail_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `product_care_instructions` text DEFAULT NULL,
  `product_additional_info` text DEFAULT NULL,
  `reviews_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_detail`
--

INSERT INTO `product_detail` (`product_detail_id`, `product_id`, `product_description`, `product_care_instructions`, `product_additional_info`, `reviews_id`) VALUES
(14, 16, 'TAIDU กระเป๋าสะพายไหล่ กระเป๋าสะพายข้างวินเทจยุค 90\'s สุดเท่ วัสดุโพลีเอสเตอร์ ความจุขนาดใหญ่', NULL, 'สไตล์: เทรนด์สตรีท\r\n\r\nวัสดุ: ผ้าใบแคนวาส\r\n\r\nรูปร่างกระเป๋า: สี่เหลี่ยมแนวนอน\r\n\r\nวิธีการเปิด: ซิป\r\n\r\nโครงสร้างภายในของกระเป๋า: กระเป๋าโทรศัพท์มือถือ, กระเป๋าเอกสาร\r\n\r\nหมายเลขรากของสายรัด: เดี่ยว\r\n\r\nขนาดกระเป๋า: กลาง', 0),
(15, 17, 'เสื้อวินเทจยุค90  SMELLS LIKE โครตเท่(ส่งเร้ว )✅ของแท้100%', NULL, 'เสื้อวินเทจยุค90 ผ้าคอตตอน ✅ของแท้\r\n\r\nSALE 180฿(จากปกติ 290.-)\r\n\r\n----------------------------------------\r\n\r\nSIZE : Over size ใส่ได้ทั้งชายและหญิง\r\n\r\nอก 44-46\" ยาว 28 นิ้ว\r\n\r\nผ้า Cotton ฟอกดำ 100% \r\n\r\n---------------------------------------\r\n\r\n#เสื้อวินเทจ #เสื้อโอเวอร์ไซส์ #เสื้อราคาถูก', 0),
(18, 20, 'เทปเพลงมือ2สภาพดีผ่านการเทสเสียงแล้วทุกม้วนก่อนลงขายคับ\r\n\r\nปกและม้วนสภาพสวย สนใจเลือกซื้อไปฟังไปสะสมกันได้เลยคาบซื้อกับเรามั่นใจได้ในคุณภาพสินค้าและบริการหลังการขาย \r\nสนใจสอบถามรายละเอียดเกี่ยวกับสินค้าแชทมาได้เลยนะค้าบ\r\nจะรีบเข้ามาตอบครับ', NULL, 'มีทั้งหมด12เพลง\r\nA\r\n1ครูในดวงใจ\r\n2ตามรอยไม้เรียว\r\n3แบ่งปัน\r\n4ดช.ปึกแป้นปึก\r\n5นางฟ้าบ้านไพร\r\n6เสียงก้อนจากบ้านไกล\r\nB\r\n1นักสู้ครูไทย\r\n2ขออยู่ตรงนี้\r\n3ชีวิตครูอึ่ง\r\n4ภาพของหนู\r\n5เรือจ้างกลางใจ\r\n6ครูในดวงใจ', 0),
(19, 21, 'ขายเทปเพลง เพลงเพื่อชีวิต\r\nอัลบั้ม : ‪วณิพก\r\nนักร้อง : คาราบาว\r\nคุณภาพ : มีปกเทป มีม้วนเทป ทดสอบเสียงแล้วปกติพร้อมฟัง\r\n- สินค้าได้ทำการตรวจเช็คคุณภาพของเสียงให้อยู่ในสภาพพร้อมใช้งาน\r\n- ได้ทำการซีลพลาสติกเพื่อป้องกันฝุ่น', NULL, 'หน้า1                                             หน้า2\r\n1วณิพก                                          1บวชหน้าไฟ\r\n2ถึกควายทุย                                   2SUMMER Hill\r\n3หรอย                                           3หัวลำโพง\r\n4ไม้ไผ่                                           4จับกัง\r\n5ดอกจาน                                       5ล้อเกวียน', 0),
(20, 22, 'เทปคาสเซ็ท สภาพดี ตลับเทปตรงกับปกกล่องเทป\r\nเจ้าของร้านได้ตรวจดูด้วยสายตาทุกม้วน เส้นเทปไม่ขาด\r\nตัวตลับเทปไม่แตกหัก อยู่สภาพสมบูรณ์\r\nตัวกล่องเทปอาจจะมีรอยร้าว ขีดข่วนบ้างตามสภาพที่ผ่านมา\r\nเจ้าของร้านไม่มีเครื่องที่จะทดลองฟัง ทำให้ไม่สามารถรู้ได้ว่าเสียงของเพลงในเทปจะเป็นเช่นไร  แนะนำให้เก็บสะสมเท่านั้น ไม่สามารถรับรองเรื่องของคุณภาพเสียงได้ครับ', NULL, '', 0),
(21, 23, '	\r\nKiss ปี 2010 Size S อก 19.5“ ยาว 27” ผ้าคอตต้อน 100 เข็บคู่ ไม่มีข้าง สภาพ 100% ป้ายคอ Ten', NULL, '-', 0),
(22, 24, 'เสื้อวง AC-DC ลิขสิทธิ์แท้100%\r\n\r\nป้ายGildan\r\nปี 2017\r\nSize พร้อมส่ง\r\nS อก18”ความยาว28”\r\nM อก20”ความยาว29”\r\nL อก22”ความยาว30”\r\nXl อก24”ความยาว31”', NULL, '-', 0),
(23, 25, 'เสื้อวง DEF LEPPARD ลิขสิทธิ์แท้100%\r\nป้าย Gildan\r\nSize พร้อมส่ง\r\nM อก20” ความยาว29”\r\nL อก22” ความยาว30”\r\nXL อก24”ความยาว30.5”', NULL, '-', 0),
(24, 26, 'เก้าอี้ตัดผมชาย หลังกลม ในยุคของพระนคร', NULL, '-', 0),
(25, 27, 'ขนาดเล็ก\r\n\r\nสูง 7 นิ้ว \r\n\r\nกว้าง 5 นิ้ว\r\n\r\n- เป็นของใหม่\r\n\r\n- สามารถ ใช้งาน จุดไฟ ได้จริงๆ\r\n\r\n- เติมน้ำมันได้จริง\r\n\r\n- เปลี่ยนใส้ได้\r\n\r\n- วัสดุเป็นโลหะ\r\n\r\n- ประดับ ตกแต่ง ของแต่งบ้าน ร้าน โรงแรม รีสอร์ท แนวของเก่าโบราณ วินเทจ Vintage', NULL, '-', 0),
(26, 28, 'ทามาก๊อตของเล่นยุค90', NULL, '-', 0),
(27, 29, 'เด็กไทยที่รู้จักมานี ก็คงต้องรู้จักหมากฝรั่งแมวดำอันนี้เป็นแน่แท้ แม้ว่าเราจะห่างกับมานีมานะมาเเล้วแสนไกล แต่รู้หรือไม่ อีบุหรี่แมวดำนี่ก็ยังผลิตมาอย่างต่อเนื่อง ไม่เชื่อก็ดูวันหมดอายุสิ', NULL, '-', 0),
(28, 30, 'จานสังกะสีเคลือบ8 (20ซม.) กระต่าย /ยกโหล 12 ใบ\r\nEnamelware เป็นเครื่องครัวแบบอเมริกันที่สร้างขึ้นในยุค 1870 ทำจากเหล็กคุณภาพสูงจากนั้นเคลือบด้วยแก้วในเตาอบที่ร้อนมาก การเคลือบ Enamel เป็นการเคลือบ ที่ทำใส่อนุภาคของแก้วลงไปบนผิวของภาชนะโลหะ ทำให้ได้ผิวที่เรียบลื้น, ไม่ติดและไม่ไม่ทำปฏิกริยากับอาหาร ภาชนะที่เคลือบ Enamel ปลอดภัยต่อสุขภาพ, สวยงาม และทนต่อความร้อนสูงได้ดี เนื่องจากเนื้อ Enamel นั้นเรียบสนิทไม่ค่อยมีรูพรุ่นทำให้ทำความสะอาดแล้วมีคราบอาหารหรือเชื้อโรคตกค้างน้อยมาก\r\nข้อด้อยของ Enamel ก็คืออาจจะกระเทาะได้ เพราะ Enamel คือการเคลือบด้วยแก้วจึงไม่ทนต่อการกระแทก แต่ถ้าได้รับการดูแลดีๆ ภาชนะเคลือบ enamel นี่จะทนชั่วลูกชั่วหลานแบบที่เราเคยเห็นคนรุ่นพ่อรุ่นแม่เราใช้แน่นอน\r\n', NULL, '-', 0),
(29, 31, 'ช้อนสังกะสี (สีเขียว) แบบบาง เป็นของเก่าเก็บ ไม่ผ่านการใช้งาน เริ่มหายากขึ้นทุกวัน มีไม่มาก', NULL, '-', 0),
(30, 32, 'เตารีดแบบโบราณ ใช้รีดผ้าของคนสมัยก่อน', NULL, '-', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_discounts`
--

CREATE TABLE `product_discounts` (
  `discount_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `discount_percentage` float NOT NULL,
  `discounted_price` float NOT NULL,
  `discount_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_discounts`
--

INSERT INTO `product_discounts` (`discount_id`, `product_id`, `discount_percentage`, `discounted_price`, `discount_date`) VALUES
(1, 17, 77.7778, 20, '2025-04-03 06:58:35'),
(5, 16, 50, 50, '2025-04-03 07:40:31'),
(6, 20, 58.3333, 50, '2025-04-03 07:40:44'),
(8, 21, 83.3333, 20, '2025-04-20 04:57:03'),
(9, 26, 86.8421, 2000, '2025-04-20 04:57:21'),
(10, 39, 50, 50, '2025-04-20 05:00:03');

-- --------------------------------------------------------

--
-- Table structure for table `product_ratings`
--

CREATE TABLE `product_ratings` (
  `rating_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` float NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_ratings`
--

INSERT INTO `product_ratings` (`rating_id`, `product_id`, `user_id`, `rating`, `created_at`, `order_id`) VALUES
(14, 17, 1, 2, '2025-04-19 09:19:04', 9),
(16, 17, 1, 2, '2025-04-19 09:31:56', 1),
(17, 21, 2, 3, '2025-04-19 09:43:55', 10),
(18, 21, 1, 1, '2025-04-20 03:35:47', 6),
(19, 20, 1, 2, '2025-04-20 04:05:00', 2),
(20, 20, 1, 2, '2025-04-20 04:05:43', 2),
(21, 16, 1, 2, '2025-04-20 04:06:02', 8);

-- --------------------------------------------------------

--
-- Table structure for table `sell_offers`
--

CREATE TABLE `sell_offers` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_description` text DEFAULT NULL,
  `submitted_at` datetime DEFAULT current_timestamp(),
  `user_id` int(255) NOT NULL,
  `sell_offers_status` int(2) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_stock` int(255) NOT NULL,
  `category_id` int(2) NOT NULL,
  `product_image_hover` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sell_offers`
--

INSERT INTO `sell_offers` (`id`, `product_name`, `email`, `product_image`, `product_description`, `submitted_at`, `user_id`, `sell_offers_status`, `product_price`, `product_stock`, `category_id`, `product_image_hover`) VALUES
(11, 'dasdasd', 'langth0007@gmail.com', '1745130601_boss.png', '47', '2025-04-20 13:30:01', 1, 1, '100.00', 25, 1, ''),
(12, 'ชื่อสินค้า', 'akhri22@gmail.com', '1745131153_boss.png', '252525', '2025-04-20 13:39:13', 1, 1, '100.00', 25, 1, ''),
(13, 'ชื่อสินค้า', 'akhri22@gmail.com', '1745131555_boss.png', '25', '2025-04-20 13:45:55', 1, 1, '100.00', 25, 5, '1745131555_hover_birhb5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `user_type` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) NOT NULL DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `phone_number`, `address`, `user_type`, `created_at`, `profile_image`) VALUES
(1, 'phone', 'langth0007@gmail.com', '$2y$10$ruce7xTCrUc.L.ArMZN7XeS3vgw75Ct.kkJeZh2mtMHHXC/Ja877K', '0800000000', 'ererfdf', 'admin', '2025-03-21 18:16:44', 'pro1.jpg'),
(2, 'earth', 'akhri22@gmail.com', '$2y$10$EclNM89HTOq8oefoiFvvbePCa1MRySsPgzqwV4EU.pGxt0REKh0bO', '0000066', '55/555', 'customer', '2025-03-26 11:04:51', 'pro2.jpg'),
(3, 'wwww', 'a@a.a', '$2y$10$/XoV1xaZZu5ZW82aF2Kf8OrnBRL6Bx00jOk06fZ.S9rNCRgAVjKK6', '0584465486', 'บ้านเลขที่ 123, ตำบล gg, อำเภอ gg, จังหวัด th, 12321', 'customer', '2025-04-03 06:05:17', 'default.png'),
(4, 'wwww2', 'a2@a.a', '$2y$10$kfEX9tpp6AVYKZjLstOnT.XQL6F7h.pilAc3YzUp6ap2I1LqAtVKa', '0585154855', 'บ้านเลขที่ 123, ตำบล dd, อำเภอ dd, จังหวัด th, 51588', 'customer', '2025-04-03 06:07:13', 'default.png'),
(5, 'phone2', 'a3@a.a', '$2y$10$w/gQTV4omDbUEJtaXdytueUr.umpGr8IiwGmIwb8zX9asfg64vgOy', '0885485568', 'บ้านเลขที่ 321, ตำบล ggd, อำเภอ gd, จังหวัด th, 12555', 'customer', '2025-04-03 06:08:46', 'default.png'),
(6, 'terry2', 'a4@a.a', '$2y$10$m8ycj3Puxu1YR9uChNwJlev96umtNBYb1hcBdbE8yWtk5xQg3N.nu', '0854445555', 'บ้านเลขที่ 215, ตำบล gh, อำเภอ gh, จังหวัด th, 15888', 'customer', '2025-04-03 06:09:36', 'default.png'),
(7, 'terryd', 'ds@a.a', '$2y$10$dax/Q1YXl7smTmfa6kr7lui..QnRoBvUOdiFfh5Zzo91dP6b1vNeu', '0584465487', 'บ้านเลขที่ 123, ตำบล ggd, อำเภอ gd, จังหวัด th, 21555', 'customer', '2025-04-03 06:10:37', 'default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`complaint_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_detail`
--
ALTER TABLE `product_detail`
  ADD PRIMARY KEY (`product_detail_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_discounts`
--
ALTER TABLE `product_discounts`
  ADD PRIMARY KEY (`discount_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sell_offers`
--
ALTER TABLE `sell_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_history`
--
ALTER TABLE `order_history`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `product_detail`
--
ALTER TABLE `product_detail`
  MODIFY `product_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `product_discounts`
--
ALTER TABLE `product_discounts`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_ratings`
--
ALTER TABLE `product_ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `sell_offers`
--
ALTER TABLE `sell_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_history`
--
ALTER TABLE `order_history`
  ADD CONSTRAINT `order_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `order_history_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `product_detail`
--
ALTER TABLE `product_detail`
  ADD CONSTRAINT `product_detail_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `product_discounts`
--
ALTER TABLE `product_discounts`
  ADD CONSTRAINT `product_discounts_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD CONSTRAINT `product_ratings_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `product_ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
