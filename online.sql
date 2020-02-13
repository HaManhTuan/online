-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 13, 2020 at 05:41 PM
-- Server version: 5.7.28-0ubuntu0.19.04.2
-- PHP Version: 7.2.24-0ubuntu0.19.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_name` longtext NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` float NOT NULL,
  `user_email` longtext,
  `session_id` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `url` longtext NOT NULL,
  `status` longtext NOT NULL,
  `status_cate` longtext NOT NULL,
  `parent_id` int(11) NOT NULL,
  `arrange` longtext,
  `description` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `url`, `status`, `status_cate`, `parent_id`, `arrange`, `description`, `created_at`, `updated_at`) VALUES
(7, 'Quần áo bé trai', 'quan-ao-be-trai', '1', '1', 0, '0', 'Quần áo bé trai đẹp. Chất lượng', '2019-12-20 00:31:05', '2019-12-29 20:00:52'),
(8, 'Áo sơ mi bé trai', 'ao-so-mi-be-trai', '1', '1', 7, '1', 'Áo sơ mi bé trai', '2019-12-20 00:31:31', '2019-12-29 20:01:02'),
(9, 'Quần áo bé gái', 'quan-ao-be-gai', '1', '1', 0, '2', 'Quần áo bé gái', '2019-12-20 00:32:43', '2019-12-29 20:01:08'),
(10, 'Váy đầm công chúa', 'vay-dam-cong-chua', '1', '1', 9, '3', 'Váy đầm công chúa', '2019-12-20 00:33:12', '2019-12-29 20:01:14'),
(11, 'Đồ sơ sinh', 'do-so-sinh', '1', '1', 0, '4', 'Đồ sơ sinh', '2019-12-20 00:33:42', '2019-12-29 20:01:21'),
(12, 'Phụ kiện sơ sinh cho bé', 'phu-kien-so-sinh-cho-be', '1', '1', 11, '5', 'Phụ kiện sơ sinh cho bé', '2019-12-20 00:34:48', '2019-12-29 20:01:27');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `id` int(11) NOT NULL,
  `coupon_code` longtext NOT NULL,
  `amount` int(11) NOT NULL,
  `amount_type` longtext NOT NULL,
  `expiry_date` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`id`, `coupon_code`, `amount`, `amount_type`, `expiry_date`, `created_at`, `updated_at`) VALUES
(1, '123', 10, 'Persentage', '11-02-2020', '2020-02-08 15:24:26', '2020-02-10 08:47:36');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `email` longtext NOT NULL,
  `phone` varchar(11) NOT NULL,
  `password` longtext NOT NULL,
  `address` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `password`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Hà Mạnh Tuấn', 'tuanhanb98@gmail.com', '0979587821', '$2y$10$AjhI7KlY7XoynAJ4mCxEceVBLnJN4RxRWhRAov2SuO71m6NX0/e92', 'Hà Nội', '2020-02-08 10:56:20', '2020-02-11 08:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `id` int(11) NOT NULL,
  `discount1` longtext NOT NULL,
  `discount2` longtext NOT NULL,
  `discount3` longtext NOT NULL,
  `status` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`id`, `discount1`, `discount2`, `discount3`, `status`) VALUES
(1, 'Free Shipping & Returns', '20% Discount for all dresses', '20% Discount for students', '0');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `image` longtext NOT NULL,
  `name` longtext NOT NULL,
  `h6` longtext,
  `h2` longtext,
  `button` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `image`, `name`, `h6`, `h2`, `button`) VALUES
(1, 'zcB0_index1.jpeg', 'Slide số 1', NULL, NULL, NULL),
(2, 'M3gi_bg-2.jpg', '2', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` longtext NOT NULL,
  `size` longtext NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`id`, `order_id`, `customer_id`, `product_id`, `product_name`, `size`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 8, 'Chân Váy Thun Bé Gái Nhiều Họa Tiết Xinh Xắn', '5', 29000, 1, '2020-02-12 14:29:36', '2020-02-12 14:29:36'),
(2, 3, 1, 9, 'Áo dài Tết cao cấp', '1', 254000, 1, '2020-02-12 14:29:36', '2020-02-12 14:29:36');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `email` longtext NOT NULL,
  `total_price` double NOT NULL,
  `name` longtext NOT NULL,
  `phone` longtext NOT NULL,
  `note` longtext,
  `order_status` int(11) NOT NULL DEFAULT '1',
  `address` longtext NOT NULL,
  `coupon_code` longtext,
  `coupon_amount` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `email`, `total_price`, `name`, `phone`, `note`, `order_status`, `address`, `coupon_code`, `coupon_amount`, `created_at`, `updated_at`) VALUES
(3, 1, 'tuanhanb98@gmail.com', 283000, 'Hà Mạnh Tuấn', '0979587821', NULL, 4, 'Hà Nội', NULL, NULL, '2020-02-12 14:29:36', '2020-02-12 14:48:42');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` longtext NOT NULL,
  `category_id` int(11) NOT NULL,
  `url` longtext NOT NULL,
  `description` longtext NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `status` longtext NOT NULL,
  `image` longtext NOT NULL,
  `count_view` int(11) DEFAULT NULL,
  `price` double NOT NULL,
  `promotional_price` double NOT NULL,
  `sale` double DEFAULT NULL,
  `color` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `buy_count` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `url`, `description`, `author_id`, `status`, `image`, `count_view`, `price`, `promotional_price`, `sale`, `color`, `count`, `buy_count`, `created_at`, `updated_at`) VALUES
(8, 'Chân Váy Thun Bé Gái Nhiều Họa Tiết Xinh Xắn', 8, 'chan-vay-thun-be-gai-nhieu-hoa-tiet-xinh-xan', '<p>Ok</p>', NULL, '1', 'HVxf_ao-thun-tay-ngan-the-thao-mau-tron-cho-be-trai-3-6-tuoi_(1).JPG', NULL, 69000, 29000, 58, 1, 10, NULL, '2020-01-13 16:13:34', '2020-02-04 10:07:52'),
(9, 'Áo dài Tết cao cấp', 10, 'ao-dai-tet-cao-cap', '<p>OK</p>', NULL, '1', 'Xgj5_set-bo-cho-be-gai-ao-thun-co-yem-phoi-chan-vay-xoe-cham-bi-xinh-xan-1-11-tuoi_(2).JPG', NULL, 254000, 0, 99.9, 1, 0, NULL, '2020-01-14 15:04:34', '2020-02-04 10:03:04'),
(10, 'Hường', 12, 'huong', '<p>123</p>', NULL, '1', 'TAMT_ao-thun-cho-be-trai-co-so-mi-mau-tron-don-gian-2-12-tuoi-vi_(7).JPG', NULL, 123, 123, 0, 2, 0, NULL, '2020-01-17 14:54:27', '2020-02-04 10:10:16'),
(11, '1', 10, '1', '<p>123</p>', NULL, '1', 'cufc_ao-thun-cho-be-trai-co-so-mi-mau-tron-don-gian-2-12-tuoi-vi.JPG', NULL, 100000, 0, 99.9, 7, 10, NULL, '2020-02-04 10:27:26', '2020-02-04 10:27:26'),
(12, '2', 12, '2', '<p>123</p>', NULL, '1', 'EEVf_ao-thun-cho-be-trai-co-so-mi-mau-tron-don-gian-2-12-tuoi-vi.JPG', NULL, 100000, 0, 99.9, 6, 10, NULL, '2020-02-04 10:28:13', '2020-02-04 10:28:13'),
(13, '3', 12, '3', '<p>123</p>', NULL, '1', 'ube1_ao-thun-cho-be-trai-co-so-mi-mau-tron-don-gian-2-12-tuoi-vi.JPG', NULL, 120000, 0, 99.9, 5, 1, NULL, '2020-02-04 10:29:07', '2020-02-04 10:29:07');

-- --------------------------------------------------------

--
-- Table structure for table `product_attr`
--

CREATE TABLE `product_attr` (
  `id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_attr`
--

INSERT INTO `product_attr` (`id`, `size_id`, `stock`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 8, '2020-02-01 04:44:26', '2020-02-04 08:56:50'),
(5, 5, 10, 8, '2020-02-01 04:44:26', '2020-02-12 14:55:35'),
(6, 1, 10, 9, '2020-02-01 05:12:55', '2020-02-12 14:55:38'),
(7, 2, 10, 9, '2020-02-01 05:12:55', '2020-02-04 09:21:43'),
(8, 3, 10, 9, '2020-02-01 05:12:55', '2020-02-04 09:21:45'),
(9, 4, 0, 9, '2020-02-01 05:12:55', '2020-02-01 05:12:55'),
(10, 5, 0, 9, '2020-02-01 05:12:55', '2020-02-01 05:12:55');

-- --------------------------------------------------------

--
-- Table structure for table `product_color`
--

CREATE TABLE `product_color` (
  `id` int(11) NOT NULL,
  `color` longtext NOT NULL,
  `class` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_color`
--

INSERT INTO `product_color` (`id`, `color`, `class`) VALUES
(1, 'Vàng', '#FFD700'),
(2, 'Cam', '#FF4500'),
(3, 'Nâu', '#A0522D'),
(4, 'Xanh', '#32CD32'),
(5, 'Hồng', '#FF69B4'),
(6, 'Xanh Dương', '#87CEFA'),
(7, 'Đen', '#000000');

-- --------------------------------------------------------

--
-- Table structure for table `product_img`
--

CREATE TABLE `product_img` (
  `id` int(11) NOT NULL,
  `img` longtext NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_img`
--

INSERT INTO `product_img` (`id`, `img`, `product_id`, `created_at`, `updated_at`) VALUES
(11, '36132.JPG', 9, '2020-02-04 03:03:15', '2020-02-04 03:03:15'),
(12, '67663.JPG', 9, '2020-02-04 03:03:15', '2020-02-04 03:03:15'),
(13, '77267.JPG', 9, '2020-02-04 03:03:15', '2020-02-04 03:03:15'),
(14, '73052.JPG', 8, '2020-02-04 03:08:21', '2020-02-04 03:08:21'),
(15, '67342.JPG', 8, '2020-02-04 03:08:21', '2020-02-04 03:08:21'),
(16, '35771.JPG', 8, '2020-02-04 03:08:21', '2020-02-04 03:08:21'),
(17, '21919.JPG', 10, '2020-02-04 03:10:33', '2020-02-04 03:10:33'),
(18, '60563.JPG', 10, '2020-02-04 03:10:33', '2020-02-04 03:10:33'),
(19, '99642.JPG', 10, '2020-02-04 03:10:33', '2020-02-04 03:10:33'),
(20, '29161.JPG', 11, '2020-02-04 03:27:40', '2020-02-04 03:27:40'),
(21, '13697.JPG', 11, '2020-02-04 03:27:40', '2020-02-04 03:27:40'),
(22, '88309.JPG', 11, '2020-02-04 03:27:40', '2020-02-04 03:27:40'),
(23, '86040.JPG', 12, '2020-02-04 03:28:29', '2020-02-04 03:28:29'),
(24, '30399.JPG', 12, '2020-02-04 03:28:29', '2020-02-04 03:28:29'),
(25, '61389.JPG', 12, '2020-02-04 03:28:29', '2020-02-04 03:28:29'),
(26, '98479.JPG', 13, '2020-02-04 03:29:21', '2020-02-04 03:29:21'),
(27, '49672.JPG', 13, '2020-02-04 03:29:21', '2020-02-04 03:29:21'),
(28, '11969.JPG', 13, '2020-02-04 03:29:21', '2020-02-04 03:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `id` int(11) NOT NULL,
  `size` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`id`, `size`, `created_at`, `updated_at`) VALUES
(1, 'M', '2020-01-30 16:02:43', '2020-01-30 16:02:43'),
(2, 'S', '2020-01-30 16:02:43', '2020-01-30 16:02:43'),
(3, 'XS', '2020-01-30 16:02:43', '2020-01-30 16:02:43'),
(4, 'L', '2020-01-30 16:02:43', '2020-01-30 16:02:43'),
(5, 'XL', '2020-01-30 16:02:43', '2020-01-30 16:02:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin` int(11) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `admin`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Hà Mạnh Tuấn', 'tuanhanb98@gmail.com', 1, NULL, '$2y$10$HHt5F1wtoD7hFXrWD4ZNoOmu0hdRqk26hfGYUMxNPHWkjinkj3ICu', NULL, NULL, '2020-02-01 08:04:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_attr`
--
ALTER TABLE `product_attr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_color`
--
ALTER TABLE `product_color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_img`
--
ALTER TABLE `product_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `orderdetail`
--
ALTER TABLE `orderdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `product_attr`
--
ALTER TABLE `product_attr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `product_color`
--
ALTER TABLE `product_color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `product_img`
--
ALTER TABLE `product_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
