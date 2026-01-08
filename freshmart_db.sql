-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 03:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `freshmart_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `deliverinfo`
--

CREATE TABLE `deliverinfo` (
  `delivery_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT 'Australia',
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `deliverinfo`
--

INSERT INTO `deliverinfo` (`delivery_id`, `user_id`, `full_name`, `phone`, `address_line1`, `address_line2`, `city`, `state`, `postal_code`, `country`, `is_default`, `created_at`) VALUES
(1, 2, 'sdhsd 25', 'dss', '13 building, 76 hao Doupengshanlu', '', 'DuYun', 'Guizhou Province', NULL, 'AU', 0, '2025-04-20 05:52:15'),
(2, 2, 'sdhsd 25', 'dss', '13 building, 76 hao Doupengshanlu', '', 'DuYun', 'Guizhou Province', NULL, 'US', 0, '2025-04-20 09:56:35'),
(3, 2, 'sdhsd 25', 'dss', '13 building, 76 hao Doupengshanlu', '', 'DuYun', 'Guizhou Province', NULL, 'US', 0, '2025-04-20 10:03:58');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `delivery_id`, `total_amount`, `order_status`, `created_at`) VALUES
(1, 2, 1, 19.19, 'pending', '2025-04-20 08:27:04'),
(2, 2, 1, 19.19, 'pending', '2025-04-20 08:29:17'),
(3, 2, 1, 19.19, 'pending', '2025-04-20 08:38:45'),
(4, 2, 1, 19.19, 'pending', '2025-04-20 08:39:34'),
(5, 2, 1, 24.13, 'pending', '2025-04-20 09:11:26'),
(6, 2, 1, 24.13, 'pending', '2025-04-20 09:16:27'),
(7, 2, 1, 15.89, 'pending', '2025-04-20 09:19:25'),
(8, 2, 1, 172.51, 'pending', '2025-04-20 09:51:50'),
(9, 2, 2, 19.19, 'pending', '2025-04-20 09:56:49'),
(10, 2, 1, 19.19, 'pending', '2025-04-20 10:04:15'),
(11, 2, 2, 80.23, 'pending', '2025-04-20 10:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `unit_price`, `total_price`, `created_at`) VALUES
(1, 8, '68', 1, 8.04, 8.04, '2025-04-20 09:51:50'),
(2, 8, '141', 1, 61.43, 61.43, '2025-04-20 09:51:50'),
(3, 8, '121', 1, 94.61, 94.61, '2025-04-20 09:51:50'),
(4, 8, '92', 1, 35.57, 35.57, '2025-04-20 09:51:50'),
(5, 11, '154', 1, 4.50, 4.50, '2025-04-20 10:06:10'),
(6, 11, '78', 1, 66.63, 66.63, '2025-04-20 10:06:10'),
(7, 11, '155', 1, 4.49, 4.49, '2025-04-20 10:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_holder_name` varchar(100) NOT NULL,
  `card_number_last4` char(4) NOT NULL,
  `card_type` varchar(20) DEFAULT NULL,
  `expiry_month` tinyint(4) DEFAULT NULL,
  `expiry_year` smallint(6) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `user_id`, `card_holder_name`, `card_number_last4`, `card_type`, `expiry_month`, `expiry_year`, `is_default`, `created_at`) VALUES
(1, 2, 'kun wang', '9456', 'Unknown', 26, 2026, 0, '2025-04-20 07:22:13'),
(2, 2, 'kun wang', '9456', 'Unknown', 26, 2026, 0, '2025-04-20 07:27:27'),
(3, 2, 'kun wang', '9456', 'Unknown', 26, 2026, 0, '2025-04-20 07:28:00'),
(4, 2, 'kun wang', '9456', 'Unknown', 26, 2026, 0, '2025-04-20 07:29:48'),
(5, 2, 'kun wang', '9456', 'Unknown', 26, 2026, 0, '2025-04-20 07:30:12'),
(6, 2, 'kun wang', '9456', 'Unknown', 26, 2026, 0, '2025-04-20 07:30:55'),
(7, 2, 'kun wang', '9456', 'Unknown', 26, 2026, 0, '2025-04-20 07:31:08'),
(8, 2, 'kun wang', '9456', 'Unknown', 26, 2026, 0, '2025-04-20 07:31:35'),
(9, 2, 'kun wang', '9456', 'Unknown', 26, 2026, 0, '2025-04-20 07:42:01'),
(10, 2, 'kun wang', '9456', 'Unknown', 26, 2026, 0, '2025-04-20 07:50:00'),
(11, 2, 'kun wang', '9456', 'Unknown', 26, 2026, 0, '2025-04-20 07:58:15'),
(12, 2, 'kun wang', '1323', 'Unknown', 6, 2026, 0, '2025-04-20 09:56:49');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` varchar(10) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `unit_price` varchar(50) DEFAULT NULL,
  `details` varchar(50) DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `features` text DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `reviews_count` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `gallery` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `slug`, `category`, `price`, `original_price`, `unit_price`, `details`, `product_description`, `features`, `rating`, `reviews_count`, `image`, `gallery`, `created_at`) VALUES
('1', 'Apple', 'Organic Apple ', 'Fruits', 1.50, 2.00, '$1.50 per unit', 'Details of Product 1', 'Freshly picked Organic Apples, cultivated without the use of synthetic pesticides or fertilizers. Each apple is crisp, juicy, and packed with natural sweetness. Ideal for snacking, baking, or juicing, these apples are a delicious and healthy choice for the whole family. Sourced from certified organic farms to ensure the highest quality and sustainability category.', 'Feature1, Feature2, Feature3 for Product 1', 4.9, 8, '../assets/images/products/apple.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-16 13:01:04'),
('10', 'Potato', 'Organic Potato', 'Vegetables', 0.80, 0.80, '$0.80 per unit', 'Details of Product 10', 'Product 10 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 10', 4.5, 314, '../assets/images/products/potato.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-04 13:01:04'),
('100', 'Product 100', 'product-100', 'Fruits', 58.73, 70.43, '$19.58 per unit', 'Details of Product 100', 'Product 100 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 100', 2.9, 45, '../assets/images/products/product1.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-26 13:01:04'),
('101', 'Product 101', 'product-101', 'Fruits', 57.06, 73.51, '$19.02 per unit', 'Details of Product 101', 'Product 101 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 101', 4.3, 339, '../assets/images/products/product2.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-28 13:01:04'),
('102', 'Product 102', 'product-102', 'Home', 23.97, 35.46, '$23.97 per unit', 'Details of Product 102', 'Product 102 is a high-quality item from the Home category.', 'Feature1, Feature2, Feature3 for Product 102', 4.2, 7, '../assets/images/products/product3.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-05 13:01:04'),
('103', 'Product 103', 'product-103', 'Fresh', 30.58, 47.13, '$15.29 per unit', 'Details of Product 103', 'Product 103 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 103', 1.4, 339, '../assets/images/products/product4.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-18 13:01:04'),
('104', 'Product 104', 'product-104', 'Home', 18.92, 24.42, '$9.46 per unit', 'Details of Product 104', 'Product 104 is a high-quality item from the Home category.', 'Feature1, Feature2, Feature3 for Product 104', 2.7, 161, '../assets/images/products/product5.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-16 13:01:04'),
('105', 'Product 105', 'product-105', 'Pet Food', 28.91, 33.23, '$7.23 per unit', 'Details of Product 105', 'Product 105 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 105', 3.8, 194, '../assets/images/products/product6.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-23 13:01:04'),
('106', 'Product 106', 'product-106', 'Home', 63.83, 80.77, '$12.77 per unit', 'Details of Product 106', 'Product 106 is a high-quality item from the Home category.', 'Feature1, Feature2, Feature3 for Product 106', 3.9, 161, '../assets/images/products/product7.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-09 13:01:04'),
('107', 'Dog Food', 'Dog Food', 'Pet Food', 50.00, 60.00, '$50.00 per unit', 'Details of Product 107', 'Product 107 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 107', 4.6, 107, '../assets/images/products/dog_food.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-14 13:01:04'),
('108', 'Product 108', 'product-108', 'Meat & Seafood', 15.64, 34.67, '$3.13 per unit', 'Details of Product 108', 'Product 108 is a high-quality item from the Meat & Seafood category.', 'Feature1, Feature2, Feature3 for Product 108', 1.1, 301, '../assets/images/products/product9.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-02-03 13:01:04'),
('109', 'Product 109', 'product-109', 'Meat & Seafood', 16.90, 29.00, '$8.45 per unit', 'Details of Product 109', 'Product 109 is a high-quality item from the Meat & Seafood category.', 'Feature1, Feature2, Feature3 for Product 109', 2.6, 19, '../assets/images/products/product10.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-23 13:01:04'),
('11', 'Product 11', 'product-11', 'Dairy & Eggs', 57.76, 62.92, '$19.25 per unit', 'Details of Product 11', 'Product 11 is a high-quality item from the Dairy & Eggs category.', 'Feature1, Feature2, Feature3 for Product 11', 3.3, 423, '../assets/images/products/product2.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-02-03 13:01:04'),
('110', 'Product 110', 'product-110', 'Pet Food', 31.63, 33.23, '$10.54 per unit', 'Details of Product 110', 'Product 110 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 110', 4.2, 285, '../assets/images/products/product1.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-25 13:01:04'),
('111', 'Dish Soap', 'Dish Soap', 'Home', 6.50, 6.50, '$6.50 per unit', 'Details of Product 111', 'Product 111 is a high-quality item from the Home category.', 'Feature1, Feature2, Feature3 for Product 111', 4.0, 240, '../assets/images/products/dish_soap.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-10 14:01:04'),
('112', 'Product 112', 'product-112', 'Bakery', 31.07, 40.22, '$7.77 per unit', 'Details of Product 112', 'Product 112 is a high-quality item from the Bakery category.', 'Feature1, Feature2, Feature3 for Product 112', 1.4, 47, '../assets/images/products/product3.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-05 13:01:04'),
('113', 'Product 113', 'product-113', 'Frozen', 40.45, 45.35, '$10.11 per unit', 'Details of Product 113', 'Product 113 is a high-quality item from the Frozen category.', 'Feature1, Feature2, Feature3 for Product 113', 1.1, 268, '../assets/images/products/product4.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-04 13:01:04'),
('114', 'Product 114', 'product-114', 'Home', 40.81, 55.77, '$13.6 per unit', 'Details of Product 114', 'Product 114 is a high-quality item from the Home category.', 'Feature1, Feature2, Feature3 for Product 114', 4.4, 30, '../assets/images/products/product5.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-31 13:01:04'),
('115', 'Product 115', 'product-115', 'Home', 15.66, 34.69, '$15.66 per unit', 'Details of Product 115', 'Product 115 is a high-quality item from the Home category.', 'Feature1, Feature2, Feature3 for Product 115', 4.7, 178, '../assets/images/products/product6.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-04 13:01:04'),
('116', 'Product 116', 'product-116', 'Vegetables', 94.81, 112.88, '$94.81 per unit', 'Details of Product 116', 'Product 116 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 116', 3.9, 234, '../assets/images/products/product7.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-19 13:01:04'),
('117', 'Product 117', 'product-117', 'Dairy & Eggs', 41.80, 60.07, '$8.36 per unit', 'Details of Product 117', 'Product 117 is a high-quality item from the Dairy & Eggs category.', 'Feature1, Feature2, Feature3 for Product 117', 1.7, 382, '../assets/images/products/product8.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-01 13:01:04'),
('118', 'Carrot', 'Organic Carrot', 'Vegetables', 1.50, 1.50, '$1.50 per unit', 'Details of Product 118', 'Product 118 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 118', 4.9, 271, '../assets/images/products/carrot.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-28 13:01:04'),
('119', 'Product 119', 'product-119', 'Home', 97.41, 110.94, '$48.7 per unit', 'Details of Product 119', 'Product 119 is a high-quality item from the Home category.', 'Feature1, Feature2, Feature3 for Product 119', 1.0, 226, '../assets/images/products/product10.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-15 13:01:04'),
('12', 'Product 12', 'product-12', 'Bakery', 89.59, 92.89, '$44.8 per unit', 'Details of Product 12', 'Product 12 is a high-quality item from the Bakery category.', 'Feature1, Feature2, Feature3 for Product 12', 2.7, 309, '../assets/images/products/product3.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-30 13:01:04'),
('120', 'Product 120', 'product-120', 'Bakery', 75.98, 78.19, '$37.99 per unit', 'Details of Product 120', 'Product 120 is a high-quality item from the Bakery category.', 'Feature1, Feature2, Feature3 for Product 120', 1.9, 104, '../assets/images/products/product1.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-16 13:01:04'),
('121', 'Product 121', 'product-121', 'Fruits', 94.61, 108.34, '$94.61 per unit', 'Details of Product 121', 'Product 121 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 121', 3.1, 374, '../assets/images/products/product2.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-14 14:01:04'),
('122', 'Product 122', 'product-122', 'Fresh', 50.33, 64.45, '$12.58 per unit', 'Details of Product 122', 'Product 122 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 122', 1.5, 4, '../assets/images/products/product3.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-19 13:01:04'),
('123', 'Product 123', 'product-123', 'Frozen', 34.33, 52.32, '$11.44 per unit', 'Details of Product 123', 'Product 123 is a high-quality item from the Frozen category.', 'Feature1, Feature2, Feature3 for Product 123', 3.1, 465, '../assets/images/products/product4.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-25 13:01:04'),
('124', 'Product 124', 'product-124', 'Fruits', 23.41, 33.37, '$7.8 per unit', 'Details of Product 124', 'Product 124 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 124', 4.0, 73, '../assets/images/products/product5.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-02 13:01:04'),
('125', 'Product 125', 'product-125', 'Beverages', 71.47, 84.65, '$71.47 per unit', 'Details of Product 125', 'Product 125 is a high-quality item from the Beverages category.', 'Feature1, Feature2, Feature3 for Product 125', 1.8, 4, '../assets/images/products/product6.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-22 13:01:04'),
('126', 'Product 126', 'product-126', 'Bakery', 22.42, 27.88, '$22.42 per unit', 'Details of Product 126', 'Product 126 is a high-quality item from the Bakery category.', 'Feature1, Feature2, Feature3 for Product 126', 2.4, 491, '../assets/images/products/product7.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-02-22 13:01:04'),
('127', 'Product 127', 'product-127', 'Frozen', 28.81, 43.00, '$9.6 per unit', 'Details of Product 127', 'Product 127 is a high-quality item from the Frozen category.', 'Feature1, Feature2, Feature3 for Product 127', 2.8, 305, '../assets/images/products/product8.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-02-25 13:01:04'),
('128', 'Product 128', 'product-128', 'Dairy & Eggs', 37.84, 54.86, '$7.57 per unit', 'Details of Product 128', 'Product 128 is a high-quality item from the Dairy & Eggs category.', 'Feature1, Feature2, Feature3 for Product 128', 1.6, 26, '../assets/images/products/product9.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-22 13:01:04'),
('129', 'Product 129', 'product-129', 'Fresh', 67.16, 75.05, '$22.39 per unit', 'Details of Product 129', 'Product 129 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 129', 4.6, 378, '../assets/images/products/product10.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-06 13:01:04'),
('13', 'Product 13', 'product-13', 'Meat & Seafood', 85.96, 101.69, '$17.19 per unit', 'Details of Product 13', 'Product 13 is a high-quality item from the Meat & Seafood category.', 'Feature1, Feature2, Feature3 for Product 13', 4.2, 187, '../assets/images/products/product4.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-14 13:01:04'),
('130', 'Product 130', 'product-130', 'Fresh', 37.74, 53.54, '$37.74 per unit', 'Details of Product 130', 'Product 130 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 130', 4.5, 163, '../assets/images/products/product1.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-25 13:01:04'),
('131', 'Product 131', 'product-131', 'Vegetables', 48.06, 58.22, '$24.03 per unit', 'Details of Product 131', 'Product 131 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 131', 2.1, 182, '../assets/images/products/product2.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-22 13:01:04'),
('132', 'Product 132', 'product-132', 'Fresh', 43.02, 57.75, '$10.76 per unit', 'Details of Product 132', 'Product 132 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 132', 2.3, 404, '../assets/images/products/product3.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-20 13:01:04'),
('133', 'Product 133', 'product-133', 'Bakery', 49.56, 67.55, '$16.52 per unit', 'Details of Product 133', 'Product 133 is a high-quality item from the Bakery category.', 'Feature1, Feature2, Feature3 for Product 133', 4.7, 379, '../assets/images/products/product4.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-05 13:01:04'),
('134', 'Product 134', 'product-134', 'Fresh', 71.33, 86.84, '$14.27 per unit', 'Details of Product 134', 'Product 134 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 134', 4.0, 33, '../assets/images/products/product5.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-22 13:01:04'),
('135', 'Product 135', 'product-135', 'Beverages', 96.30, 107.51, '$24.07 per unit', 'Details of Product 135', 'Product 135 is a high-quality item from the Beverages category.', 'Feature1, Feature2, Feature3 for Product 135', 1.5, 77, '../assets/images/products/product6.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-01 13:01:04'),
('136', 'Product 136', 'product-136', 'Pet Food', 77.86, 89.06, '$19.46 per unit', 'Details of Product 136', 'Product 136 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 136', 1.2, 59, '../assets/images/products/product7.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-30 13:01:04'),
('137', 'Product 137', 'product-137', 'Fruits', 87.81, 88.90, '$29.27 per unit', 'Details of Product 137', 'Product 137 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 137', 1.7, 232, '../assets/images/products/product8.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-20 13:01:04'),
('138', 'Product 138', 'product-138', 'Dairy & Eggs', 46.58, 59.30, '$23.29 per unit', 'Details of Product 138', 'Product 138 is a high-quality item from the Dairy & Eggs category.', 'Feature1, Feature2, Feature3 for Product 138', 1.5, 19, '../assets/images/products/product9.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-02-24 13:01:04'),
('139', 'Product 139', 'product-139', 'Vegetables', 38.53, 48.61, '$19.27 per unit', 'Details of Product 139', 'Product 139 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 139', 3.1, 200, '../assets/images/products/product10.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-09 14:01:04'),
('14', 'Product 14', 'product-14', 'Bakery', 11.13, 30.43, '$5.57 per unit', 'Details of Product 14', 'Product 14 is a high-quality item from the Bakery category.', 'Feature1, Feature2, Feature3 for Product 14', 2.2, 36, '../assets/images/products/product5.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-22 13:01:04'),
('140', 'Product 140', 'product-140', 'Fresh', 35.61, 43.29, '$7.12 per unit', 'Details of Product 140', 'Product 140 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 140', 4.2, 304, '../assets/images/products/product1.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-10 13:01:04'),
('141', 'Product 141', 'product-141', 'Fruits', 61.43, 77.07, '$30.71 per unit', 'Details of Product 141', 'Product 141 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 141', 3.2, 17, '../assets/images/products/product2.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-05 13:01:04'),
('142', 'Product 142', 'product-142', 'Dairy & Eggs', 26.90, 29.84, '$13.45 per unit', 'Details of Product 142', 'Product 142 is a high-quality item from the Dairy & Eggs category.', 'Feature1, Feature2, Feature3 for Product 142', 4.8, 94, '../assets/images/products/product3.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-31 13:01:04'),
('143', 'Product 143', 'product-143', 'Fruits', 57.92, 65.78, '$14.48 per unit', 'Details of Product 143', 'Product 143 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 143', 3.9, 499, '../assets/images/products/product4.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-27 13:01:04'),
('144', 'Product 144', 'product-144', 'Fruits', 52.07, 66.80, '$26.04 per unit', 'Details of Product 144', 'Product 144 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 144', 2.8, 305, '../assets/images/products/product5.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-07 13:01:04'),
('145', 'Product 145', 'product-145', 'Beverages', 56.04, 69.59, '$14.01 per unit', 'Details of Product 145', 'Product 145 is a high-quality item from the Beverages category.', 'Feature1, Feature2, Feature3 for Product 145', 3.5, 52, '../assets/images/products/product6.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-14 14:01:04'),
('146', 'Product 146', 'product-146', 'Pet Food', 66.95, 73.98, '$66.95 per unit', 'Details of Product 146', 'Product 146 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 146', 3.9, 31, '../assets/images/products/product7.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-18 13:01:04'),
('147', 'Product 147', 'product-147', 'Frozen', 23.92, 29.07, '$23.92 per unit', 'Details of Product 147', 'Product 147 is a high-quality item from the Frozen category.', 'Feature1, Feature2, Feature3 for Product 147', 4.8, 258, '../assets/images/products/product8.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-28 13:01:04'),
('148', 'Product 148', 'product-148', 'Dairy & Eggs', 17.10, 25.44, '$5.7 per unit', 'Details of Product 148', 'Product 148 is a high-quality item from the Dairy & Eggs category.', 'Feature1, Feature2, Feature3 for Product 148', 1.3, 241, '../assets/images/products/product9.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-05 13:01:04'),
('149', 'Product 149', 'product-149', 'Fruits', 54.45, 62.83, '$54.45 per unit', 'Details of Product 149', 'Product 149 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 149', 4.6, 316, '../assets/images/products/product10.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-09 13:01:04'),
('15', 'Product 15', 'product-15', 'Meat & Seafood', 70.71, 74.59, '$14.14 per unit', 'Details of Product 15', 'Product 15 is a high-quality item from the Meat & Seafood category.', 'Feature1, Feature2, Feature3 for Product 15', 1.1, 283, '../assets/images/products/product6.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-09 13:01:04'),
('150', 'Product 150', 'product-150', 'Meat & Seafood', 99.89, 112.76, '$19.98 per unit', 'Details of Product 150', 'Product 150 is a high-quality item from the Meat & Seafood category.', 'Feature1, Feature2, Feature3 for Product 150', 1.7, 324, '../assets/images/products/product1.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-31 13:01:04'),
('151', 'Bondi Sands Wet Skin Sport Sunscreen SPF50', 'bondi-sands-sunscreen', 'Home', 9.00, 10.00, '$7.20 per 100ml', '125mL', 'High performance wet skin SPF50 sunscreen.', 'Premium Quality, Organic, Water Resistant', 4.8, 126, '../assets/images/products/sunscreen.jpg', '../assets/images/products/sunscreen.jpg', '2025-04-18 00:15:58'),
('152', 'Arnotts Tim Tam Chocolate Biscuits Original', 'tim-tam-chocolate-biscuits', 'Snacks', 3.00, 4.50, '$1.50 per 100g', '200g', 'Classic Tim Tam Original biscuits.', 'Premium Quality, Artisan, Australian Favourite', 4.9, 352, '../assets/images/products/tim-tam.jpg', '../assets/images/products/tim-tam.jpg', '2025-04-18 00:15:58'),
('153', 'Nescafe Cappuccino Coffee Sachets', 'nescafe-cappuccino-coffee', 'Beverages', 4.00, 5.00, '$0.40 per sachet', '10 pack', 'Instant cappuccino sachets with rich foam.', 'Premium Quality, Imported, Frothy Blend', 4.5, 414, '../assets/images/products/nescafe.jpg', '../assets/images/products/nescafe.jpg', '2025-04-18 00:15:58'),
('154', 'Kellogg\'s Nutri-Grain Protein Breakfast Cereal', 'kelloggs-nutri-grain-cereal', 'Cereal', 4.50, 6.00, '$0.96 per 100g', '470g', 'High-protein breakfast cereal for active lifestyles.', 'Premium Quality, High Protein, Classic Cereal', 4.7, 289, '../assets/images/products/nutri-grain.jpg', '../assets/images/products/nutri-grain.jpg', '2025-04-18 00:15:58'),
('155', 'Organic Milk', 'organic-milk', 'Dairy & Eggs', 4.49, 5.50, '$4.49 per litre', '1L', 'Certified organic milk, rich and fresh.', 'Organic, Full Cream, Fresh', 5.0, 98, '../assets/images/products/organic-milk.jpg', '../assets/images/products/organic-milk.jpg', '2025-04-18 00:15:58'),
('156', 'Organic Eggs', 'organic-eggs', 'Dairy & Eggs', 5.99, 6.49, '$1.00 per egg', '6 pack', 'Free-range organic eggs with bright yolks.', 'Organic, Free Range, Protein Rich', 4.5, 132, '../assets/images/products/organic-eggs.jpg', '../assets/images/products/organic-eggs.jpg', '2025-04-18 00:15:58'),
('157', 'Organic Spinach', 'organic-spinach', 'Vegetables', 3.29, 3.99, '$3.29 per bag', '250g bag', 'Fresh organic spinach, great for salads.', 'Organic, Washed, Rich in Iron', 4.4, 81, '../assets/images/products/organic-spinach.jpg', '../assets/images/products/organic-spinach.jpg', '2025-04-18 00:15:58'),
('158', 'Organic Bread', 'organic-bread', 'Bakery', 4.29, 5.29, '$4.29 per loaf', '400g', 'Whole grain organic bread, soft and nutritious.', 'Organic, Wholegrain, Soft Texture', 4.3, 74, '../assets/images/products/organic-bread.jpg', '../assets/images/products/organic-bread.jpg', '2025-04-18 00:15:58'),
('16', 'Product 16', 'product-16', 'Fresh', 69.80, 82.96, '$69.8 per unit', 'Details of Product 16', 'Product 16 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 16', 1.6, 475, '../assets/images/products/product7.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-14 13:01:04'),
('17', 'Product 17', 'product-17', 'Fruits', 79.21, 83.87, '$19.8 per unit', 'Details of Product 17', 'Product 17 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 17', 4.3, 243, '../assets/images/products/product8.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-02-10 13:01:04'),
('18', 'Product 18', 'product-18', 'Vegetables', 10.73, 22.33, '$2.68 per unit', 'Details of Product 18', 'Product 18 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 18', 1.3, 375, '../assets/images/products/product9.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-11 14:01:04'),
('19', 'Product 19', 'product-19', 'Home', 10.52, 22.01, '$5.26 per unit', 'Details of Product 19', 'Product 19 is a high-quality item from the Home category.', 'Feature1, Feature2, Feature3 for Product 19', 3.8, 280, '../assets/images/products/product10.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-17 13:01:04'),
('2', 'Product 2', 'product-2', 'Vegetables', 27.66, 45.09, '$9.22 per unit', 'Details of Product 2', 'Product 2 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 2', 1.2, 419, '../assets/images/products/product3.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-10 13:01:04'),
('20', 'Lamb', 'Organic Lamb', 'Meat & Seafood', 35.00, 35.00, '$35.00 per unit', 'Details of Product 20', 'Product 20 is a high-quality item from the Meat & Seafood category.', 'Feature1, Feature2, Feature3 for Product 20', 4.8, 144, '../assets/images/products/lamb.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-28 13:01:04'),
('21', 'Product 21', 'product-21', 'Fruits', 7.17, 24.64, '$7.17 per unit', 'Details of Product 21', 'Product 21 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 21', 1.2, 451, '../assets/images/products/product2.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-11 13:01:04'),
('22', 'Product 22', 'product-22', 'Beverages', 88.61, 107.70, '$22.15 per unit', 'Details of Product 22', 'Product 22 is a high-quality item from the Beverages category.', 'Feature1, Feature2, Feature3 for Product 22', 3.4, 342, '../assets/images/products/product3.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-16 13:01:04'),
('23', 'Product 23', 'product-23', 'Fresh', 31.93, 44.23, '$7.98 per unit', 'Details of Product 23', 'Product 23 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 23', 1.0, 482, '../assets/images/products/product4.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-17 13:01:04'),
('24', 'Product 24', 'product-24', 'Vegetables', 97.45, 116.81, '$48.73 per unit', 'Details of Product 24', 'Product 24 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 24', 2.2, 458, '../assets/images/products/product5.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-11 13:01:04'),
('25', 'Product 25', 'product-25', 'Fresh', 88.01, 97.42, '$29.34 per unit', 'Details of Product 25', 'Product 25 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 25', 4.7, 149, '../assets/images/products/product6.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-28 13:01:04'),
('26', 'Product 26', 'product-26', 'Frozen', 67.21, 76.81, '$67.21 per unit', 'Details of Product 26', 'Product 26 is a high-quality item from the Frozen category.', 'Feature1, Feature2, Feature3 for Product 26', 2.1, 367, '../assets/images/products/product7.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-10 14:01:04'),
('27', 'Product 27', 'product-27', 'Fruits', 80.33, 83.45, '$20.08 per unit', 'Details of Product 27', 'Product 27 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 27', 1.6, 424, '../assets/images/products/product8.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-08 13:01:04'),
('28', 'Chips', 'Frozen Chips', 'Frozen', 8.50, 8.50, '$8.5 per unit', 'Details of Product 28', 'Product 28 is a high-quality item from the Frozen category.', 'Feature1, Feature2, Feature3 for Product 28', 3.0, 5, '../assets/images/products/frozen_chips.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-20 13:01:04'),
('29', 'Product 29', 'product-29', 'Pet Food', 76.71, 92.76, '$38.35 per unit', 'Details of Product 29', 'Product 29 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 29', 4.3, 156, '../assets/images/products/product10.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-02-05 13:01:04'),
('3', 'Product 3', 'product-3', 'Pet Food', 25.64, 34.82, '$8.55 per unit', 'Details of Product 3', 'Product 3 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 3', 2.9, 444, '../assets/images/products/product4.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-05 13:01:04'),
('30', 'Product 30', 'product-30', 'Meat & Seafood', 53.44, 55.19, '$26.72 per unit', 'Details of Product 30', 'Product 30 is a high-quality item from the Meat & Seafood category.', 'Feature1, Feature2, Feature3 for Product 30', 3.9, 307, '../assets/images/products/product1.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-26 13:01:04'),
('31', 'Product 31', 'product-31', 'Vegetables', 24.15, 27.16, '$24.15 per unit', 'Details of Product 31', 'Product 31 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 31', 4.7, 244, '../assets/images/products/product2.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-28 13:01:04'),
('32', 'Product 32', 'product-32', 'Frozen', 85.92, 91.60, '$21.48 per unit', 'Details of Product 32', 'Product 32 is a high-quality item from the Frozen category.', 'Feature1, Feature2, Feature3 for Product 32', 3.5, 476, '../assets/images/products/product3.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-12 13:01:04'),
('33', 'Product 33', 'product-33', 'Vegetables', 92.69, 97.04, '$92.69 per unit', 'Details of Product 33', 'Product 33 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 33', 4.7, 164, '../assets/images/products/product4.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-21 13:01:04'),
('34', 'Product 34', 'product-34', 'Bakery', 13.67, 25.23, '$13.67 per unit', 'Details of Product 34', 'Product 34 is a high-quality item from the Bakery category.', 'Feature1, Feature2, Feature3 for Product 34', 3.7, 204, '../assets/images/products/product5.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-31 13:01:04'),
('35', 'Product 35', 'product-35', 'Home', 64.89, 73.53, '$64.89 per unit', 'Details of Product 35', 'Product 35 is a high-quality item from the Home category.', 'Feature1, Feature2, Feature3 for Product 35', 2.2, 180, '../assets/images/products/product6.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-02-04 13:01:04'),
('36', 'Product 36', 'product-36', 'Pet Food', 36.27, 40.43, '$12.09 per unit', 'Details of Product 36', 'Product 36 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 36', 4.2, 388, '../assets/images/products/product7.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-11 13:01:04'),
('37', 'Product 37', 'product-37', 'Beverages', 60.25, 79.12, '$20.08 per unit', 'Details of Product 37', 'Product 37 is a high-quality item from the Beverages category.', 'Feature1, Feature2, Feature3 for Product 37', 2.1, 211, '../assets/images/products/product8.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-16 13:01:04'),
('38', 'Product 38', 'product-38', 'Vegetables', 27.32, 45.72, '$13.66 per unit', 'Details of Product 38', 'Product 38 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 38', 4.5, 12, '../assets/images/products/product9.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-08 14:01:04'),
('39', 'Product 39', 'product-39', 'Pet Food', 87.82, 90.53, '$17.56 per unit', 'Details of Product 39', 'Product 39 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 39', 4.8, 465, '../assets/images/products/product10.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-03 13:01:04'),
('4', 'Product 4', 'product-4', 'Meat & Seafood', 61.35, 70.95, '$61.35 per unit', 'Details of Product 4', 'Product 4 is a high-quality item from the Meat & Seafood category.', 'Feature1, Feature2, Feature3 for Product 4', 4.5, 401, '../assets/images/products/product5.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-15 13:01:04'),
('40', 'Product 40', 'product-40', 'Fresh', 28.40, 32.64, '$14.2 per unit', 'Details of Product 40', 'Product 40 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 40', 4.2, 29, '../assets/images/products/product1.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-02-18 13:01:04'),
('41', 'Product 41', 'product-41', 'Home', 48.10, 53.55, '$48.1 per unit', 'Details of Product 41', 'Product 41 is a high-quality item from the Home category.', 'Feature1, Feature2, Feature3 for Product 41', 2.2, 275, '../assets/images/products/product2.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-12 13:01:04'),
('42', 'Product 42', 'product-42', 'Bakery', 69.18, 84.63, '$34.59 per unit', 'Details of Product 42', 'Product 42 is a high-quality item from the Bakery category.', 'Feature1, Feature2, Feature3 for Product 42', 1.6, 57, '../assets/images/products/product3.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-25 13:01:04'),
('43', 'Product 43', 'product-43', 'Fruits', 75.09, 93.60, '$25.03 per unit', 'Details of Product 43', 'Product 43 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 43', 4.6, 203, '../assets/images/products/product4.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-28 13:01:04'),
('44', 'Product 44', 'product-44', 'Pet Food', 29.89, 48.78, '$29.89 per unit', 'Details of Product 44', 'Product 44 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 44', 4.5, 57, '../assets/images/products/product5.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-15 13:01:04'),
('45', 'Product 45', 'product-45', 'Frozen', 36.12, 43.14, '$12.04 per unit', 'Details of Product 45', 'Product 45 is a high-quality item from the Frozen category.', 'Feature1, Feature2, Feature3 for Product 45', 4.2, 203, '../assets/images/products/product6.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-07 13:01:04'),
('46', 'Product 46', 'product-46', 'Bakery', 62.38, 80.73, '$20.79 per unit', 'Details of Product 46', 'Product 46 is a high-quality item from the Bakery category.', 'Feature1, Feature2, Feature3 for Product 46', 2.0, 459, '../assets/images/products/product7.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-02-11 13:01:04'),
('47', 'Product 47', 'product-47', 'Home', 80.46, 98.19, '$40.23 per unit', 'Details of Product 47', 'Product 47 is a high-quality item from the Home category.', 'Feature1, Feature2, Feature3 for Product 47', 3.1, 425, '../assets/images/products/product8.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-19 13:01:04'),
('48', 'Product 48', 'product-48', 'Fruits', 23.81, 41.93, '$7.94 per unit', 'Details of Product 48', 'Product 48 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 48', 4.6, 114, '../assets/images/products/product9.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-11 13:01:04'),
('49', 'Product 49', 'product-49', 'Bakery', 42.58, 55.90, '$8.52 per unit', 'Details of Product 49', 'Product 49 is a high-quality item from the Bakery category.', 'Feature1, Feature2, Feature3 for Product 49', 2.9, 383, '../assets/images/products/product10.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-15 13:01:04'),
('5', 'Product 5', 'product-5', 'Beverages', 32.63, 50.79, '$6.53 per unit', 'Details of Product 5', 'Product 5 is a high-quality item from the Beverages category.', 'Feature1, Feature2, Feature3 for Product 5', 2.9, 398, '../assets/images/products/product6.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-24 13:01:04'),
('50', 'Product 50', 'product-50', 'Dairy & Eggs', 19.12, 36.43, '$6.37 per unit', 'Details of Product 50', 'Product 50 is a high-quality item from the Dairy & Eggs category.', 'Feature1, Feature2, Feature3 for Product 50', 1.6, 430, '../assets/images/products/product1.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-01 13:01:04'),
('51', 'Product 51', 'product-51', 'Fruits', 76.13, 91.17, '$15.23 per unit', 'Details of Product 51', 'Product 51 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 51', 1.2, 242, '../assets/images/products/product2.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-02-22 13:01:04'),
('52', 'Product 52', 'product-52', 'Pet Food', 64.42, 65.74, '$21.47 per unit', 'Details of Product 52', 'Product 52 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 52', 1.9, 87, '../assets/images/products/product3.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-23 13:01:04'),
('53', 'Product 53', 'product-53', 'Pet Food', 90.36, 105.31, '$45.18 per unit', 'Details of Product 53', 'Product 53 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 53', 3.6, 214, '../assets/images/products/product4.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-15 13:01:04'),
('54', 'Product 54', 'product-54', 'Fresh', 53.13, 59.86, '$10.63 per unit', 'Details of Product 54', 'Product 54 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 54', 1.7, 490, '../assets/images/products/product5.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-10 14:01:04'),
('55', 'Product 55', 'product-55', 'Pet Food', 79.88, 82.80, '$26.63 per unit', 'Details of Product 55', 'Product 55 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 55', 2.7, 160, '../assets/images/products/product6.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-11 13:01:04'),
('56', 'Product 56', 'product-56', 'Meat & Seafood', 63.64, 72.09, '$31.82 per unit', 'Details of Product 56', 'Product 56 is a high-quality item from the Meat & Seafood category.', 'Feature1, Feature2, Feature3 for Product 56', 3.6, 356, '../assets/images/products/product7.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-14 14:01:04'),
('57', 'Yogurt', 'Yogurt with fruits', 'Dairy & Eggs', 2.50, 2.50, '$2.50 per unit', 'Details of Product 57', 'Product 57 is a high-quality item from the Dairy & Eggs category.', 'Feature1, Feature2, Feature3 for Product 57', 2.8, 145, '../assets/images/products/yogurt.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-15 13:01:04'),
('58', 'Product 58', 'product-58', 'Bakery', 61.80, 71.87, '$15.45 per unit', 'Details of Product 58', 'Product 58 is a high-quality item from the Bakery category.', 'Feature1, Feature2, Feature3 for Product 58', 2.7, 257, '../assets/images/products/product9.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-25 13:01:04'),
('59', 'Besom', 'Nice Besom', 'Home', 20.00, 20.00, '$20.00 per unit', 'Details of Product 59', 'Product 59 is a high-quality item from the Home category.', 'Feature1, Feature2, Feature3 for Product 59', 4.8, 171, '../assets/images/products/besom.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-27 13:01:04'),
('6', 'Product 6', 'product-6', 'Pet Food', 16.48, 29.28, '$5.49 per unit', 'Details of Product 6', 'Product 6 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 6', 3.0, 119, '../assets/images/products/product7.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-06 14:01:04'),
('60', 'Product 60', 'product-60', 'Fresh', 75.17, 92.85, '$25.06 per unit', 'Details of Product 60', 'Product 60 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 60', 2.9, 220, '../assets/images/products/product1.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-04 13:01:04'),
('61', 'Product 61', 'product-61', 'Meat & Seafood', 70.23, 84.47, '$14.05 per unit', 'Details of Product 61', 'Product 61 is a high-quality item from the Meat & Seafood category.', 'Feature1, Feature2, Feature3 for Product 61', 3.7, 327, '../assets/images/products/product2.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-21 13:01:04'),
('62', 'Product 62', 'product-62', 'Pet Food', 78.93, 82.80, '$26.31 per unit', 'Details of Product 62', 'Product 62 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 62', 4.6, 290, '../assets/images/products/product3.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-11 14:01:04'),
('63', 'Product 63', 'product-63', 'Dairy & Eggs', 65.82, 68.96, '$21.94 per unit', 'Details of Product 63', 'Product 63 is a high-quality item from the Dairy & Eggs category.', 'Feature1, Feature2, Feature3 for Product 63', 3.1, 150, '../assets/images/products/product4.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-02-28 13:01:04'),
('64', 'Product 64', 'product-64', 'Vegetables', 98.12, 103.08, '$32.71 per unit', 'Details of Product 64', 'Product 64 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 64', 3.3, 442, '../assets/images/products/product5.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-26 13:01:04'),
('65', 'Product 65', 'product-65', 'Home', 69.48, 88.49, '$23.16 per unit', 'Details of Product 65', 'Product 65 is a high-quality item from the Home category.', 'Feature1, Feature2, Feature3 for Product 65', 1.6, 464, '../assets/images/products/product6.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-14 14:01:04');
INSERT INTO `products` (`product_id`, `product_name`, `slug`, `category`, `price`, `original_price`, `unit_price`, `details`, `product_description`, `features`, `rating`, `reviews_count`, `image`, `gallery`, `created_at`) VALUES
('66', 'Product 66', 'product-66', 'Fresh', 70.41, 80.56, '$35.2 per unit', 'Details of Product 66', 'Product 66 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 66', 4.8, 348, '../assets/images/products/product7.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-29 13:01:04'),
('67', 'Product 67', 'product-67', 'Home', 87.78, 94.27, '$87.78 per unit', 'Details of Product 67', 'Product 67 is a high-quality item from the Home category.', 'Feature1, Feature2, Feature3 for Product 67', 1.8, 329, '../assets/images/products/product8.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-17 13:01:04'),
('68', 'Product 68', 'product-68', 'Fresh', 8.04, 14.71, '$2.68 per unit', 'Details of Product 68', 'Product 68 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 68', 4.8, 112, '../assets/images/products/product9.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-30 13:01:04'),
('69', 'Product 69', 'product-69', 'Vegetables', 90.46, 91.96, '$90.46 per unit', 'Details of Product 69', 'Product 69 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 69', 1.9, 98, '../assets/images/products/product10.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-22 13:01:04'),
('7', 'Product 7', 'product-7', 'Pet Food', 25.61, 34.06, '$12.8 per unit', 'Details of Product 7', 'Product 7 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 7', 3.9, 275, '../assets/images/products/product8.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-10 13:01:04'),
('70', 'Product 70', 'product-70', 'Beverages', 33.00, 51.64, '$33.0 per unit', 'Details of Product 70', 'Product 70 is a high-quality item from the Beverages category.', 'Feature1, Feature2, Feature3 for Product 70', 3.9, 392, '../assets/images/products/product1.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-12 14:01:04'),
('71', 'Product 71', 'product-71', 'Vegetables', 51.06, 68.35, '$10.21 per unit', 'Details of Product 71', 'Product 71 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 71', 4.2, 19, '../assets/images/products/product2.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-02-10 13:01:04'),
('72', 'Product 72', 'product-72', 'Vegetables', 88.66, 90.11, '$44.33 per unit', 'Details of Product 72', 'Product 72 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 72', 3.0, 323, '../assets/images/products/product3.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-15 14:01:04'),
('73', 'Tomato', 'Organic Tomato', 'Vegetables', 3.50, 3.50, '$3.50 per unit', 'Details of Product 73', 'Product 73 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 73', 4.3, 373, '../assets/images/products/tomato.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-08 13:01:04'),
('74', 'Broccoli', 'Organic Broccoli', 'Vegetables', 5.00, 5.00, '$5.00 per unit', 'Details of Product 74', 'Product 74 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 74', 4.8, 318, '../assets/images/products/broccoli.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-30 13:01:04'),
('75', 'Product 75', 'product-75', 'Fresh', 96.53, 108.19, '$96.53 per unit', 'Details of Product 75', 'Product 75 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 75', 3.3, 371, '../assets/images/products/product6.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-10 13:01:04'),
('76', 'Product 76', 'product-76', 'Fruits', 53.86, 56.48, '$13.46 per unit', 'Details of Product 76', 'Product 76 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 76', 3.4, 171, '../assets/images/products/product7.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-06 13:01:04'),
('77', 'Product 77', 'product-77', 'Meat & Seafood', 54.10, 56.62, '$13.53 per unit', 'Details of Product 77', 'Product 77 is a high-quality item from the Meat & Seafood category.', 'Feature1, Feature2, Feature3 for Product 77', 4.1, 49, '../assets/images/products/product8.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-17 13:01:04'),
('78', 'Product 78', 'product-78', 'Bakery', 66.63, 73.06, '$66.63 per unit', 'Details of Product 78', 'Product 78 is a high-quality item from the Bakery category.', 'Feature1, Feature2, Feature3 for Product 78', 4.9, 300, '../assets/images/products/product9.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-04-16 14:01:04'),
('79', 'Product 79', 'product-79', 'Vegetables', 95.66, 114.71, '$23.91 per unit', 'Details of Product 79', 'Product 79 is a high-quality item from the Vegetables category.', 'Feature1, Feature2, Feature3 for Product 79', 2.3, 460, '../assets/images/products/product10.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-31 13:01:04'),
('8', 'Product 8', 'product-8', 'Dairy & Eggs', 41.83, 50.38, '$41.83 per unit', 'Details of Product 8', 'Product 8 is a high-quality item from the Dairy & Eggs category.', 'Feature1, Feature2, Feature3 for Product 8', 1.8, 235, '../assets/images/products/product9.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-29 13:01:04'),
('80', 'Product 80', 'product-80', 'Meat & Seafood', 33.08, 40.98, '$11.03 per unit', 'Details of Product 80', 'Product 80 is a high-quality item from the Meat & Seafood category.', 'Feature1, Feature2, Feature3 for Product 80', 4.2, 300, '../assets/images/products/product1.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-28 13:01:04'),
('81', 'Product 81', 'product-81', 'Dairy & Eggs', 79.57, 83.87, '$79.57 per unit', 'Details of Product 81', 'Product 81 is a high-quality item from the Dairy & Eggs category.', 'Feature1, Feature2, Feature3 for Product 81', 3.0, 349, '../assets/images/products/product2.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-30 13:01:04'),
('82', 'Product 82', 'product-82', 'Frozen', 31.18, 38.29, '$15.59 per unit', 'Details of Product 82', 'Product 82 is a high-quality item from the Frozen category.', 'Feature1, Feature2, Feature3 for Product 82', 1.8, 275, '../assets/images/products/product3.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-02-08 13:01:04'),
('83', 'Product 83', 'product-83', 'Beverages', 55.20, 57.46, '$27.6 per unit', 'Details of Product 83', 'Product 83 is a high-quality item from the Beverages category.', 'Feature1, Feature2, Feature3 for Product 83', 3.7, 213, '../assets/images/products/product4.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-27 13:01:04'),
('84', 'Product 84', 'product-84', 'Frozen', 60.20, 61.80, '$15.05 per unit', 'Details of Product 84', 'Product 84 is a high-quality item from the Frozen category.', 'Feature1, Feature2, Feature3 for Product 84', 3.6, 362, '../assets/images/products/product5.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-06 13:01:04'),
('85', 'Product 85', 'product-85', 'Dairy & Eggs', 54.26, 57.58, '$54.26 per unit', 'Details of Product 85', 'Product 85 is a high-quality item from the Dairy & Eggs category.', 'Feature1, Feature2, Feature3 for Product 85', 3.6, 167, '../assets/images/products/product6.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-07 13:01:04'),
('86', 'Product 86', 'product-86', 'Bakery', 63.98, 76.53, '$12.8 per unit', 'Details of Product 86', 'Product 86 is a high-quality item from the Bakery category.', 'Feature1, Feature2, Feature3 for Product 86', 2.8, 170, '../assets/images/products/product7.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-25 13:01:04'),
('87', 'Cheese', 'Organic Cheese', 'Dairy & Eggs', 7.80, 7.80, '$7.80 per unit', 'Details of Product 87', 'Product 87 is a high-quality item from the Dairy & Eggs category.', 'Feature1, Feature2, Feature3 for Product 87', 4.8, 349, '../assets/images/products/cheese.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-17 13:01:04'),
('88', 'Product 88', 'product-88', 'Dairy & Eggs', 60.45, 64.97, '$20.15 per unit', 'Details of Product 88', 'Product 88 is a high-quality item from the Dairy & Eggs category.', 'Feature1, Feature2, Feature3 for Product 88', 1.5, 393, '../assets/images/products/product9.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-24 13:01:04'),
('89', 'Product 89', 'product-89', 'Fresh', 36.28, 48.40, '$9.07 per unit', 'Details of Product 89', 'Product 89 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 89', 4.4, 445, '../assets/images/products/product10.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-17 13:01:04'),
('9', 'Product 9', 'product-9', 'Fruits', 96.29, 97.78, '$24.07 per unit', 'Details of Product 9', 'Product 9 is a high-quality item from the Fruits category.', 'Feature1, Feature2, Feature3 for Product 9', 4.7, 454, '../assets/images/products/product10.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-31 13:01:04'),
('90', 'Product 90', 'product-90', 'Frozen', 78.09, 90.47, '$26.03 per unit', 'Details of Product 90', 'Product 90 is a high-quality item from the Frozen category.', 'Feature1, Feature2, Feature3 for Product 90', 3.0, 130, '../assets/images/products/product1.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-21 13:01:04'),
('91', 'Product 91', 'product-91', 'Bakery', 31.47, 47.43, '$6.29 per unit', 'Details of Product 91', 'Product 91 is a high-quality item from the Bakery category.', 'Feature1, Feature2, Feature3 for Product 91', 1.9, 384, '../assets/images/products/product2.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-24 13:01:04'),
('92', 'Product 92', 'product-92', 'Fresh', 35.57, 52.62, '$8.89 per unit', 'Details of Product 92', 'Product 92 is a high-quality item from the Fresh category.', 'Feature1, Feature2, Feature3 for Product 92', 2.4, 113, '../assets/images/products/product3.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-02-24 13:01:04'),
('93', 'Product 93', 'product-93', 'Home', 49.02, 63.26, '$49.02 per unit', 'Details of Product 93', 'Product 93 is a high-quality item from the Home category.', 'Feature1, Feature2, Feature3 for Product 93', 2.0, 474, '../assets/images/products/product4.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-28 13:01:04'),
('94', 'Product 94', 'product-94', 'Dairy & Eggs', 55.26, 70.71, '$13.81 per unit', 'Details of Product 94', 'Product 94 is a high-quality item from the Dairy & Eggs category.', 'Feature1, Feature2, Feature3 for Product 94', 4.0, 2, '../assets/images/products/product5.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-01-08 13:01:04'),
('95', 'Product 95', 'product-95', 'Bakery', 8.74, 20.52, '$2.91 per unit', 'Details of Product 95', 'Product 95 is a high-quality item from the Bakery category.', 'Feature1, Feature2, Feature3 for Product 95', 3.3, 491, '../assets/images/products/product6.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-12-19 13:01:04'),
('96', 'Product 96', 'product-96', 'Pet Food', 5.50, 14.33, '$5.5 per unit', 'Details of Product 96', 'Product 96 is a high-quality item from the Pet Food category.', 'Feature1, Feature2, Feature3 for Product 96', 2.4, 154, '../assets/images/products/product7.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-11-28 13:01:04'),
('97', 'Beef Steak', 'Organic Beef Steak', 'Meat & Seafood', 25.00, 25.00, '$25.00 per unit', 'Details of Product 97', 'Product 97 is a high-quality item from the Meat & Seafood category.', 'Feature1, Feature2, Feature3 for Product 97', 3.4, 31, '../assets/images/products/beef_steak.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-02-10 13:01:04'),
('98', 'Product 98', 'product-98', 'Meat & Seafood', 56.05, 59.66, '$28.02 per unit', 'Details of Product 98', 'Product 98 is a high-quality item from the Meat & Seafood category.', 'Feature1, Feature2, Feature3 for Product 98', 3.7, 319, '../assets/images/products/product9.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2025-03-30 13:01:04'),
('99', 'Product 99', 'product-99', 'Bakery', 40.57, 46.47, '$8.11 per unit', 'Details of Product 99', 'Product 99 is a high-quality item from the Bakery category.', 'Feature1, Feature2, Feature3 for Product 99', 3.6, 267, '../assets/images/products/product10.jpg', '../assets/images/products/gallery1.jpg,../assets/images/products/gallery2.jpg,../assets/images/products/gallery3.jpg', '2024-10-30 13:01:04');

-- --------------------------------------------------------

--
-- Table structure for table `product_tags`
--

CREATE TABLE `product_tags` (
  `product_id` varchar(10) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_tags`
--

INSERT INTO `product_tags` (`product_id`, `tag_id`) VALUES
('1', 4),
('10', 6),
('100', 3),
('101', 6),
('102', 10),
('103', 17),
('104', 15),
('105', 20),
('106', 2),
('107', 14),
('108', 12),
('109', 16),
('11', 17),
('110', 2),
('111', 14),
('112', 15),
('113', 20),
('114', 18),
('115', 11),
('116', 17),
('117', 4),
('118', 14),
('119', 2),
('12', 15),
('120', 20),
('121', 1),
('122', 12),
('123', 12),
('124', 15),
('125', 20),
('126', 4),
('127', 3),
('128', 7),
('129', 5),
('13', 2),
('130', 18),
('131', 9),
('132', 9),
('133', 7),
('134', 10),
('135', 5),
('136', 6),
('137', 9),
('138', 17),
('139', 5),
('14', 15),
('140', 15),
('141', 1),
('142', 2),
('143', 12),
('144', 19),
('145', 16),
('146', 13),
('147', 17),
('148', 12),
('149', 6),
('15', 4),
('150', 8),
('151', 2),
('152', 12),
('153', 11),
('154', 6),
('155', 4),
('156', 7),
('157', 9),
('158', 5),
('16', 6),
('17', 8),
('18', 9),
('19', 6),
('2', 11),
('20', 14),
('21', 7),
('22', 13),
('23', 5),
('24', 20),
('25', 8),
('26', 6),
('27', 7),
('28', 14),
('29', 10),
('3', 2),
('30', 6),
('31', 3),
('32', 12),
('33', 15),
('34', 16),
('35', 13),
('36', 6),
('37', 9),
('38', 17),
('39', 11),
('4', 6),
('40', 15),
('41', 12),
('42', 17),
('43', 4),
('44', 15),
('45', 15),
('46', 3),
('47', 6),
('48', 7),
('49', 9),
('5', 8),
('50', 9),
('51', 4),
('52', 2),
('53', 6),
('54', 13),
('55', 9),
('56', 5),
('57', 14),
('58', 19),
('59', 14),
('6', 20),
('60', 12),
('61', 11),
('62', 11),
('63', 5),
('64', 16),
('65', 9),
('66', 8),
('67', 12),
('68', 1),
('69', 18),
('7', 6),
('70', 10),
('71', 19),
('72', 11),
('73', 14),
('74', 14),
('75', 17),
('76', 2),
('77', 11),
('78', 17),
('79', 2),
('8', 17),
('80', 8),
('81', 20),
('82', 3),
('83', 20),
('84', 5),
('85', 10),
('86', 13),
('87', 14),
('88', 1),
('89', 10),
('9', 13),
('90', 20),
('91', 4),
('92', 1),
('93', 20),
('94', 2),
('95', 15),
('96', 16),
('97', 14),
('98', 15),
('99', 17);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_name`) VALUES
(16, 'Baby Products'),
(9, 'Bakery'),
(3, 'Beverages'),
(8, 'Dairy & Eggs'),
(1, 'Fresh'),
(2, 'Frozen'),
(6, 'Fruits'),
(14, 'Gluten-Free'),
(4, 'Home'),
(17, 'Household Essentials'),
(19, 'International Foods'),
(15, 'Low Sugar'),
(10, 'Meat & Seafood'),
(20, 'On Sale'),
(12, 'Organic'),
(13, 'Pantry'),
(18, 'Personal Care'),
(5, 'Pet Food'),
(11, 'Snacks'),
(7, 'Vegetables');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `first_name`, `last_name`, `email`, `phone`, `password`, `created_at`) VALUES
(2, 'Chloe Wang', 'Chloe', 'Wang', 'wk@gmail.com', '123456', '$2y$10$A5RMsc3VBvxmH9bAgZw6/uL4BL7Ujvc9xmrCsngzHsdPQTLnwOkmO', '2025-04-17 20:43:00'),
(3, 'kunwang036', 'kun', 'wang', 'kun.wang-6@student.uts.edu.au', '123456', '$2y$10$RNmLiO48P77qcMi5dX2OX.Tdrg6d3kF9mFYOFsvSJvwBU.PDa1D42', '2025-04-18 01:22:10'),
(4, '25', 'sdhsd', '25', 'zczxczxc@sdfksjdf.com', 'dss', '$2y$10$2ixKRPtCzXqwiDDZOd5FyO3F7N3Lpd.P0y62UuyUbIWSnf/fYCYj6', '2025-04-18 02:41:07'),
(22, 'Chloe', 'sdhsd', '25', 'zcz@sdfksjdf.com', 'dss', '$2y$10$761AFH7Z5uNZliePW3Jzh.7Gy1b9VB/UZhHPg3VLKWMwmEFd.3lW.', '2025-04-18 03:28:53'),
(25, 'xudog', 'xu', 'dog', 'xd@gmail.com', '123456', '$2y$10$YF/HcdzgP35aO5j.5LdDzuOifGcynUep3drumZgt0np2y5cBT24qS', '2025-04-18 04:24:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deliverinfo`
--
ALTER TABLE `deliverinfo`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_orders_user` (`user_id`),
  ADD KEY `fk_orders_delivery` (`delivery_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `fk_order_items_order` (`order_id`),
  ADD KEY `fk_order_items_product` (`product_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD PRIMARY KEY (`product_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `name` (`tag_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deliverinfo`
--
ALTER TABLE `deliverinfo`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deliverinfo`
--
ALTER TABLE `deliverinfo`
  ADD CONSTRAINT `deliverinfo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_delivery` FOREIGN KEY (`delivery_id`) REFERENCES `deliverinfo` (`delivery_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD CONSTRAINT `product_tags_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
