-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 16, 2024 at 01:29 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sogo`
--

-- --------------------------------------------------------

--
-- Table structure for table `dealer_products`
--

DROP TABLE IF EXISTS `dealer_products`;
CREATE TABLE IF NOT EXISTS `dealer_products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `dealer_id` bigint UNSIGNED NOT NULL,
  `inverter_id` bigint UNSIGNED NOT NULL,
  `deliverynote_id` bigint UNSIGNED NOT NULL,
  `serial_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dealer_products_dealer_id_foreign` (`dealer_id`),
  KEY `dealer_products_inverter_id_foreign` (`inverter_id`),
  KEY `dealer_products_deliverynote_id_foreign` (`deliverynote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliverynotes`
--

DROP TABLE IF EXISTS `deliverynotes`;
CREATE TABLE IF NOT EXISTS `deliverynotes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `dealer_id` bigint UNSIGNED NOT NULL,
  `do_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deliverynotes_user_id_foreign` (`user_id`),
  KEY `deliverynotes_dealer_id_foreign` (`dealer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inverters`
--

DROP TABLE IF EXISTS `inverters`;
CREATE TABLE IF NOT EXISTS `inverters` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `inverter_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `technical_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED NOT NULL,
  `inverter_packaging` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_of_pieces` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modal_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_warranty` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_warranty` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warranty_lag` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_catalog` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_manual` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `troubleshoot_guide` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inverter_image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_quantity` int NOT NULL DEFAULT '0',
  `sold_quantity` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inverters_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inverters`
--

INSERT INTO `inverters` (`id`, `inverter_name`, `technical_notes`, `user_id`, `inverter_packaging`, `no_of_pieces`, `brand`, `category`, `modal_number`, `product_warranty`, `service_warranty`, `warranty_lag`, `product_catalog`, `product_manual`, `troubleshoot_guide`, `inverter_image`, `total_quantity`, `sold_quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SUNON PRO 3.5kW Hybrid Inverter', NULL, 1, '1', '1', 'SAKO', '1', 'SUNON PRO 3.5kW', '2', '3', '3', 'SUNON_PRO_3.5kW,5.5kW_1720445113.pdf', 'SUNON_PRO_3.5_-_5.5kW_1720445113.pdf', NULL, 'SUNON_PRO_3.5kW_1720445113.png', 0, 0, 'active', '2024-07-08 13:25:13', '2024-07-30 07:37:46'),
(2, 'SUNON PRO 5.5', NULL, 2, '1', '1', 'SAKO', '1', 'SUNON PRO 5.5', '2', '3', '3', 'SUNON_PRO_3.5kW,5.5kW_1720447798.pdf', 'SUNON_PRO_3.5_-_5.5kW_1720447798.pdf', NULL, 'WhatsApp_Image_2024-07-08_at_7.06.22_PM_1720447798.jpeg', 0, 0, 'active', '2024-07-08 14:09:58', '2024-07-08 14:09:58'),
(3, 'SUNON IV 4.2kW', NULL, 2, '1', '1', 'SAKO', '1', 'SUNON IV 4.2', '2', '3', '3', 'SUNON_IV_4.2kVA,6.2kVA_1720448095.pdf', 'SUNON_IV_4.2KVA-6.2KVA_user_manual_2023_1720448095.pdf', NULL, 'WhatsApp_Image_2024-07-08_at_7.06.22_PM_(1)_1720448095.jpeg', 0, 0, 'active', '2024-07-08 14:14:55', '2024-07-08 14:14:55'),
(4, 'SUNON IV 6.2KVA', NULL, 2, '1', '1', 'SAKO', '1', 'SUNON IV 6.2KVA', '2', '3', '3', 'SUNON_IV_4.2kVA,6.2kVA_1720448285.pdf', 'SUNON_IV_4.2KVA-6.2KVA_user_manual_2023_1720448285.pdf', NULL, 'WhatsApp_Image_2024-07-08_at_7.06.22_PM_(1)_1720448285.jpeg', 0, 0, 'active', '2024-07-08 14:18:05', '2024-07-08 14:18:05'),
(5, 'SUNPOLO 6KW - Version 1 (Pre 2024)', NULL, 2, '1', '1', 'SAKO', '2', 'SUNPOLO 6KW (v1)', '2', '3', '3', 'SUNPOLO_6kW_1720449270.pdf', 'SUNPOLO_6kW_(OCR)_1720449270.pdf', NULL, 'WhatsApp_Image_2024-07-08_at_7.06.22_PM_(2)_1720449270.jpeg', 1, 0, 'active', '2024-07-08 14:34:30', '2024-07-20 10:05:30'),
(6, 'E-SUN 1KVA-2KVA 12VDC Off Grid Inverter', NULL, 2, '1', '1', 'SAKO', '1', 'E-SUN 2KVA', '2', '3', '3', 'E-Sun_1.2kVA,2kVA,3kVA_1720510860.pdf', 'E-SUN_1KVA-3KVA_user_manual_2023_1720510860.pdf', NULL, 'E-SUN_2KVA_-_PIC_1720510860.PNG', 0, 0, 'active', '2024-07-09 07:41:00', '2024-07-20 10:05:56'),
(7, 'E-SUN 3KVA 24VDC Off Grid Inverter', NULL, 2, '1', '1', 'SAKO', '1', 'E-SUN 3KVA', '2', '3', '3', 'E-Sun_1.2kVA,2kVA,3kVA_1720511157.pdf', 'E-SUN_1KVA-3KVA_user_manual_2023_1720511157.pdf', NULL, 'E-SUN_2KVA_-_PIC_1720511157.PNG', 0, 0, 'active', '2024-07-09 07:45:57', '2024-07-20 10:06:14'),
(8, 'SUNPOLO 8KW Hybrid Solar Inverter (8.2kW)', NULL, 2, '1', '1', 'SAKO', '2', 'SUNPOLO 8KW (v3)', '2', '3', '3', 'SUNPOLO_8kW,11kW_1720511422.pdf', 'SUNPOLO_8kW_1720511422.pdf', NULL, 'SUNPOLO_8KW_-_PIC_1720511422.PNG', 0, 0, 'active', '2024-07-09 07:50:22', '2024-07-20 10:06:35'),
(9, 'SUNPOLO 11KW Hybrid Inverter', NULL, 2, '1', '1', 'SAKO', '2', 'SUNPOLO 11KW', '2', '3', '3', 'SUNPOLO_8kW,11kW_1720513468.pdf', 'SUNPOLO_11KVA_11KW_48VDC_user_manual_2023_1720513468.pdf', NULL, 'SUNPOLO_11KW_-_PIC_1720513468.PNG', 0, 0, 'active', '2024-07-09 08:24:28', '2024-07-09 08:24:28'),
(11, 'ffereerer', NULL, 1, '2', NULL, 'Test Brand', '1', '4343434', '2', '3', '1', 'Token_Tax_240712_113713_1722935350.pdf', 'Token_Tax_240712_113713_1722935350.pdf', NULL, '1643445698513_1722935350.jpg', 90, 0, 'active', '2024-08-06 04:09:10', '2024-08-06 04:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `inverter_inventories`
--

DROP TABLE IF EXISTS `inverter_inventories`;
CREATE TABLE IF NOT EXISTS `inverter_inventories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `inverter_id` bigint UNSIGNED NOT NULL,
  `model_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unique_sku` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `container` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_receipt` date DEFAULT NULL,
  `date_of_entry` date DEFAULT NULL,
  `csv_key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_assigned` bigint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inverter_inventories_user_id_foreign` (`user_id`),
  KEY `inverter_inventories_inverter_id_foreign` (`inverter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inverter_inventories`
--

INSERT INTO `inverter_inventories` (`id`, `user_id`, `inverter_id`, `model_number`, `serial_number`, `unique_sku`, `order_number`, `container`, `date_of_receipt`, `date_of_entry`, `csv_key`, `is_assigned`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 'SUNPOLO 6kW', 'SOGO2305263700660', 'SOGO2305263700660', '1', NULL, '1970-01-01', '2024-07-19', 'pRhOKF', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_05_04_093844_create_inverters_table', 1),
(6, '2024_05_06_065243_create_inverter_inventories_table', 1),
(7, '2024_05_08_132032_create_spare_parts_table', 1),
(8, '2024_05_08_132348_create_spare_part_models_table', 1),
(10, '2024_05_11_120512_create_spare_part_invoices_table', 1),
(11, '2024_05_11_120654_create_spare_part_invoice_items_table', 1),
(12, '2024_05_16_064404_create_product_categories_table', 1),
(13, '2024_05_16_064553_create_spare_part_categories_table', 1),
(14, '2024_05_16_143529_create_deliverynotes_table', 1),
(15, '2024_05_20_084809_create_dealer_products_table', 1),
(16, '2024_05_20_103558_create_repair_tickets_table', 1),
(17, '2024_05_20_103629_create_repair_spare_parts_table', 1),
(18, '2024_05_21_084343_create_sc_spare_part_qties_table', 1),
(19, '2024_05_31_133802_create_spare_part_requests_table', 1),
(20, '2024_07_11_153907_add_purchase_price_to_spare_parts_table', 2),
(21, '2024_07_11_154347_create_spare_parts_inventory_details_table', 2),
(22, '2024_07_16_071200_add_plugin_location_to_spare_part_models_table', 2),
(23, '2024_05_10_092541_create_spare_part_inventories_table', 3),
(24, '2024_07_30_113645_add_unit_to_spare_parts_table', 4),
(25, '2024_08_06_090334_add_status_to_inverters_table', 5),
(26, '2024_08_06_104010_add_status_to_spare_parts_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('firstsc@yopmail.com', '$2y$10$Rv1o2f4nEU1QSLz5p.hPGeTpipS5vv/yG0lZ8MeJpwM4FREdHzQKW', '2024-07-10 16:32:27');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

DROP TABLE IF EXISTS `product_categories`;
CREATE TABLE IF NOT EXISTS `product_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Off-Grid Solar Inverter', '2024-07-08 13:21:13', NULL),
(2, 'Hybrid Solar Inverter', '2024-07-08 13:21:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `repair_spare_parts`
--

DROP TABLE IF EXISTS `repair_spare_parts`;
CREATE TABLE IF NOT EXISTS `repair_spare_parts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `repair_id` bigint UNSIGNED NOT NULL,
  `sparepart_id` bigint UNSIGNED NOT NULL,
  `current_stock` int NOT NULL DEFAULT '0',
  `stock_needed` int NOT NULL DEFAULT '0',
  `any_comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `repair_spare_parts_repair_id_foreign` (`repair_id`),
  KEY `repair_spare_parts_sparepart_id_foreign` (`sparepart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `repair_tickets`
--

DROP TABLE IF EXISTS `repair_tickets`;
CREATE TABLE IF NOT EXISTS `repair_tickets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `inverter_id` bigint UNSIGNED NOT NULL,
  `service_center_id` bigint UNSIGNED NOT NULL,
  `dealer_id` bigint UNSIGNED NOT NULL,
  `serial_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fault_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fault_video` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','completed','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `explain_more` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `repair_request_date` date DEFAULT NULL,
  `repair_complete_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `repair_tickets_user_id_foreign` (`user_id`),
  KEY `repair_tickets_inverter_id_foreign` (`inverter_id`),
  KEY `repair_tickets_service_center_id_foreign` (`service_center_id`),
  KEY `repair_tickets_dealer_id_foreign` (`dealer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sc_spare_part_qties`
--

DROP TABLE IF EXISTS `sc_spare_part_qties`;
CREATE TABLE IF NOT EXISTS `sc_spare_part_qties` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sparepart_id` bigint UNSIGNED NOT NULL,
  `service_center_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sc_spare_part_qties_sparepart_id_foreign` (`sparepart_id`),
  KEY `sc_spare_part_qties_service_center_id_foreign` (`service_center_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sc_spare_part_qties`
--

INSERT INTO `sc_spare_part_qties` (`id`, `sparepart_id`, `service_center_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `spare_parts`
--

DROP TABLE IF EXISTS `spare_parts`;
CREATE TABLE IF NOT EXISTS `spare_parts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `factory_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `part_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voltage_rating` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ampeare_rating` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_price` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_unit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pieces` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `part_image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `technical_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total_quantity` int NOT NULL DEFAULT '0',
  `sold_quantity` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `purchase_price` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spare_parts_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spare_parts`
--

INSERT INTO `spare_parts` (`id`, `user_id`, `name`, `factory_code`, `part_type`, `voltage_rating`, `ampeare_rating`, `sale_price`, `base_unit`, `pieces`, `part_image`, `technical_notes`, `total_quantity`, `sold_quantity`, `status`, `created_at`, `updated_at`, `purchase_price`, `unit`) VALUES
(1, 1, 'SUNON PRO 3.5 kW Main Board', '802-011352-001', '7', NULL, NULL, '0', NULL, '1', '', 'Main PCB Board', 0, 0, 'inactive', '2024-07-08 13:30:28', '2024-08-06 06:17:06', NULL, '1'),
(2, 2, 'E-Sun 2kVA Main Board + MPPT Solar Controller', '802-029202-002', '8', NULL, NULL, '4000', NULL, '1', '', 'E-Sun 2kVA Main Board + MPPT Solar Controller', 0, 1, 'active', '2024-07-09 06:44:53', '2024-08-05 06:28:15', '100', NULL),
(3, 2, 'SUNON PRO 5.5KW', '802-011552-001', '7', NULL, NULL, '0', NULL, '1', '', 'SUNON PRO 5.5KW', 0, 0, 'active', '2024-07-09 06:49:38', '2024-07-09 06:49:38', NULL, NULL),
(4, 2, 'SUNON IV 4.2 kVA Main Board + MPPT Solar Controller', '802-058422-001', '8', NULL, NULL, '0', NULL, '0', '', 'SUNON IV 4.2 kVA', 0, 0, 'active', '2024-07-09 06:51:56', '2024-07-09 06:51:56', NULL, NULL),
(5, 2, 'SUNON IV 6.2 kVA Main Board + MPPT Solar Controller', '802-058622-001', '8', NULL, NULL, '0', NULL, '0', '', 'SUNON IV 6.2 kVA', 0, 0, 'active', '2024-07-09 06:53:54', '2024-07-09 06:53:54', NULL, NULL),
(6, 2, 'SUNPOLO 6 kW (New) Main Board', '802-014602-001', '7', NULL, NULL, '0', NULL, '0', '', 'SUNPOLO 6 kW (New)', 0, 0, 'active', '2024-07-09 07:00:38', '2024-07-09 07:00:38', NULL, NULL),
(7, 2, 'SUNON PRO 3.5 kW | SUNON PRO 5.5 kW MPPT Solar Controller', '802-011352-007', '9', NULL, NULL, '0', NULL, '18', '', 'SUNON PRO 3.5 kW | SUNON PRO 5.5 kW', 0, 0, 'active', '2024-07-09 07:04:59', '2024-07-09 07:04:59', NULL, NULL),
(8, 2, 'SUNPOLO 6kW (New) MPPT Solar Controller', '802-014602-003', '9', NULL, NULL, '0', NULL, '0', '', 'SUNPOLO 6kW (New)', 100, 0, 'active', '2024-07-09 07:19:40', '2024-07-09 07:19:40', '9000', NULL),
(9, 2, 'SUNPOLO 11kW MPPT Solar Controller', '802-058113-003', '9', NULL, NULL, '0', NULL, '0', 'MPPT_-_11KW_1720514195.png', 'SUNPOLO 11KW', 0, 0, 'active', '2024-07-09 08:36:35', '2024-07-19 07:58:24', NULL, NULL),
(10, 2, 'SUNPOLO 8KW (v2)', '802-058802-003', '9', NULL, NULL, '0', NULL, '0', '', 'SUNPOLO 8KW (v2)', 0, 0, 'active', '2024-07-09 08:48:42', '2024-07-09 08:48:42', NULL, NULL),
(11, 2, 'SUN 8KVA 8000W 48VDC PCBA VER2.00', '802-058802-001', '7', NULL, NULL, '0', NULL, '0', '', 'SUNPOLO 8KW (v2)', 0, 0, 'active', '2024-07-09 09:17:45', '2024-07-19 07:53:53', NULL, NULL),
(12, 2, 'SUNPOLO 8KW (v3)- MPPT Solar Controller -', '802-058113-003', '9', NULL, NULL, '0', NULL, '0', '', 'SUNPOLO 8KW (v3)', 0, 0, 'active', '2024-07-09 09:21:04', '2024-07-19 07:59:03', NULL, NULL),
(13, 2, 'SUNON IV/ SUNPOLO 11KW', '802-058113-001', '7', NULL, NULL, '0', NULL, '0', '', 'SUNON IV/ SUNPOLO 11KW', 0, 0, 'active', '2024-07-09 09:33:47', '2024-07-09 09:33:47', NULL, NULL),
(14, 2, 'E-Sun 3kVA Main Board + MPPT', '802-029302-003', '8', NULL, NULL, '0', NULL, '0', '', 'E-Sun 3kVA 24VDC', 0, 0, 'active', '2024-07-09 09:39:56', '2024-07-09 09:39:56', NULL, NULL),
(15, 2, 'E-Sun 2kVA | E-Sun 3kVA Control Board', '802-029302-002', '6', NULL, NULL, '0', NULL, '8', '', 'E-Sun 2kVA | E-Sun 3kVA', 0, 0, 'active', '2024-07-09 10:28:11', '2024-07-09 10:28:11', NULL, NULL),
(16, 2, 'E-Sun 2kVA | E-Sun 3kVA | SUNON PRO 3.5 kW | SUNON PRO 5.5kW Communication Board', '802-007302-004', '5', NULL, NULL, '0', NULL, '22', '', 'E-Sun 2kVA | E-Sun 3kVA | SUNON PRO 3.5 kW | SUNON PRO 5.5kW', 1, 0, 'active', '2024-07-09 10:32:23', '2024-07-09 10:32:23', '100', NULL),
(17, 2, 'HYG025N06LS1P', '108-000203-066', '2', NULL, NULL, '0', NULL, '263', '', 'Main Board', 8, 0, 'active', '2024-07-09 10:40:24', '2024-07-09 10:40:24', '100', NULL),
(18, 2, 'CRG40T60AK3HD', '109-000102-021', '1', NULL, NULL, '0', NULL, '2530', '', 'Main Board', 0, 0, 'active', '2024-07-09 10:45:41', '2024-07-09 10:45:41', NULL, NULL),
(19, 2, 'TT040U120EQ', '109-000102-029', '1', NULL, NULL, '0', NULL, '2027', '', 'Main Board', 10, 0, 'active', '2024-07-09 10:55:11', '2024-07-09 10:55:11', '100', NULL),
(20, 2, '3-Pin Fan', '129-021015-001', '3', NULL, NULL, '0', NULL, '0', '', 'E-Sun 1KVA-2kVA', 0, 0, 'active', '2024-07-09 11:05:59', '2024-07-09 11:05:59', NULL, NULL),
(21, 2, '4-Pin Fan', '129-021015-002', '3', NULL, NULL, '0', NULL, '95', '', 'E-Sun 1KVA-2KVA', 0, 0, 'active', '2024-07-09 11:09:59', '2024-07-09 11:09:59', NULL, NULL),
(22, 2, 'NCEP02T10T', '108-000206-014', '2', NULL, NULL, '0', NULL, '2500', '', 'Main Board', 0, 0, 'active', '2024-07-09 13:03:31', '2024-07-09 13:03:31', NULL, NULL),
(23, 2, 'CRG75T60AK3HD', '109-000102-019', '1', NULL, NULL, '0', NULL, '4544', '', 'Main Board', 0, 0, 'active', '2024-07-09 13:14:00', '2024-07-09 13:14:00', NULL, NULL),
(24, 2, 'Transformer', '113-105800-004', '4', NULL, NULL, '0', NULL, '2', '', 'Main Board', 0, 0, 'active', '2024-07-09 13:46:21', '2024-07-09 13:46:21', NULL, NULL),
(25, 2, 'PCBA Parallel Communication Board', '802-006502-010', '5', NULL, NULL, '0', NULL, '3', '', 'SUNSEE 5KVA 4000W 48VDC', 0, 0, 'active', '2024-07-09 13:56:18', '2024-07-09 13:56:18', NULL, NULL),
(26, 2, 'Chopper', '113-101400-004', '4', NULL, NULL, '0', NULL, '1', '', 'MAIN BORAD', 0, 0, 'active', '2024-07-09 14:02:41', '2024-07-09 14:02:41', NULL, NULL),
(27, 2, 'IRF840', '108-000203-004', '2', NULL, NULL, '0', NULL, '1', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-09 14:12:06', '2024-07-19 07:46:55', NULL, NULL),
(28, 2, 'HY3215 120A 150V TO-247', '108-000206-015', '2', NULL, NULL, '0', NULL, '800', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 05:41:31', '2024-07-10 05:41:31', NULL, NULL),
(29, 2, 'CRG75T60AK3HD 75A 650V TO-247', '109-000102-019', '1', NULL, NULL, '0', NULL, '4544', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 05:45:31', '2024-07-10 05:45:31', NULL, NULL),
(30, 2, 'SUNPOLO48VDC8038 DZ08038B12HH 12V 0.9A', '129-021015-012', '3', NULL, NULL, '0', NULL, '36', '', 'INVERTER', 0, 0, 'active', '2024-07-10 05:51:27', '2024-07-10 05:51:27', NULL, NULL),
(31, 2, 'SUN 11KVA 48VDC PCBA VER2.0', '802-058113-002', '6', NULL, NULL, '0', NULL, '20', '', 'PCBA', 0, 0, 'active', '2024-07-10 05:55:03', '2024-07-10 05:55:03', NULL, NULL),
(32, 2, 'SUN 11KVA 48VDC PCBA VER2.0', '802-058113-004', '5', NULL, NULL, '0', NULL, '0', '', 'INVERTER', 0, 0, 'active', '2024-07-10 06:08:21', '2024-07-10 06:08:21', NULL, NULL),
(33, 2, '48VDC 9225 12VH 1.05A XHB2.54-4P', '129-021019-001', '3', NULL, NULL, '0', NULL, '0', '', 'INVERTER', 0, 0, 'active', '2024-07-10 06:13:41', '2024-07-10 06:13:41', NULL, NULL),
(34, 2, 'CHOPPER', '113-102900-006', '4', NULL, NULL, '0', NULL, '8', '', NULL, 0, 0, 'active', '2024-07-10 06:29:51', '2024-07-10 06:29:51', NULL, NULL),
(35, 2, 'CHOPPER', '113-102900-007', '4', NULL, NULL, '0', NULL, '9', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 06:34:30', '2024-07-10 06:34:30', NULL, NULL),
(36, 2, 'JCS640SH', '108-000107-016', '2', NULL, NULL, '0', NULL, '0', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 06:41:59', '2024-07-10 06:41:59', NULL, NULL),
(37, 2, 'CRST040N10N', '108-000203-037', '2', NULL, NULL, '0', NULL, '1295', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 06:46:12', '2024-07-10 06:46:12', NULL, NULL),
(38, 2, 'SUNON-E 3KVA 2400W 24VDC', '113-102900-003', '4', NULL, NULL, '0', NULL, '6', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 06:52:38', '2024-07-10 06:52:38', NULL, NULL),
(39, 2, 'SUNON-E 3KVA 2400W  24VDC EE28 6+6', '113-102900-002', '4', NULL, NULL, '0', NULL, '6', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 06:55:36', '2024-07-10 06:55:36', NULL, NULL),
(40, 2, 'SUNON PRO 3.5 kW | SUNON PRO 5.5 kW PCBA VER2.1', '802-011352-002', '6', NULL, NULL, '0', NULL, '11', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 07:02:01', '2024-07-10 07:02:01', NULL, NULL),
(41, 2, 'HGP028NE6A 181A 65V TO-247', '108-000203-076', '2', NULL, NULL, '0', NULL, '2000', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 07:05:50', '2024-07-10 07:05:50', NULL, NULL),
(42, 2, 'TT075N065EQ 75A 650V TO-220', '109-000102-025', '1', NULL, NULL, '0', NULL, '596', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 07:17:35', '2024-07-10 07:17:35', NULL, NULL),
(43, 2, 'RU6199R 200A 60V TO-220', '108-000203-054', '2', NULL, NULL, '0', NULL, '2778', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 07:24:35', '2024-07-10 07:24:35', NULL, NULL),
(44, 2, 'SUNON 3KVA-5KVA EE28 6+6', '113-100700-005', '4', NULL, NULL, '0', NULL, '189', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 07:27:17', '2024-07-10 07:27:17', NULL, NULL),
(45, 2, 'SUNON PRO 3.5KVA 3500W 24V EE55*25', '113-101100-002', '4', NULL, NULL, '0', NULL, '30', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 07:29:46', '2024-07-10 07:29:46', NULL, NULL),
(46, 2, 'SUNON 3KVA-5KVA EE30', '113-100700-003', '4', NULL, NULL, '0', NULL, '131', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 07:31:31', '2024-07-10 07:31:31', NULL, NULL),
(47, 2, 'JCS6N90CA', '108-000203-002', '2', NULL, NULL, '0', NULL, '837', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 07:33:45', '2024-07-10 07:33:45', NULL, NULL),
(48, 2, 'HGP042N10S 161A', '108-000203-077', '2', NULL, NULL, '0', NULL, '0', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 07:53:27', '2024-07-10 07:53:27', NULL, NULL),
(49, 2, 'SUNON 3KVA-5KVA', '113-100700-005', '4', NULL, NULL, '0', NULL, '189', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 08:05:42', '2024-07-10 08:05:42', NULL, NULL),
(50, 2, 'SUNON PRO 5.5KVA 5500W', '113-101100-003', '4', NULL, NULL, '0', NULL, '22', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 08:08:39', '2024-07-10 08:08:39', NULL, NULL),
(51, 2, 'SUNON IV 4.2 kVA | SUNON IV 6.2 kVA Control Board', '802-058422-002', '6', NULL, NULL, '0', NULL, '33', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 08:31:46', '2024-07-10 08:31:46', NULL, NULL),
(52, 2, 'SUNON IV 4.2 kVA | SUNON IV 6.2 kVA PLUS 3KVA-5KVA', '802-008302-001', '5', NULL, NULL, '0', NULL, '52', '', 'IVERTER', 0, 0, 'active', '2024-07-10 08:33:46', '2024-07-10 08:33:46', NULL, NULL),
(53, 2, 'SUNSEE 3KVA 12V 0.55A', '129-021015-003', '3', NULL, NULL, '0', NULL, '1', '', 'INVERTER', 0, 0, 'active', '2024-07-10 08:36:31', '2024-07-10 08:36:31', NULL, NULL),
(54, 2, 'SUNON IV 3.6KVA 3600W 24VDC', '113-105800-002', '4', NULL, NULL, '0', NULL, '3', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 08:39:09', '2024-07-10 08:39:09', NULL, NULL),
(55, 2, 'CHOPPER', '113-100700-007', '4', NULL, NULL, '0', NULL, '4', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 08:44:41', '2024-07-10 08:44:41', NULL, NULL),
(56, 2, 'SUNON IV 4kVA Main Board + MPPT Solar Controller', '802-058362-001', '8', NULL, NULL, '0', NULL, '7', '', 'INVERTER SUNON IV 4K INVERTER', 0, 0, 'active', '2024-07-10 08:51:57', '2024-07-10 08:51:57', NULL, NULL),
(57, 2, 'SUNON IV 4 kVA | SUNON IV 6 kVA Control Board', '802-058362-002', '6', NULL, NULL, '0', NULL, '12', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 08:54:25', '2024-07-10 08:54:25', NULL, NULL),
(58, 2, 'SUNON IV 6 kVA Main Board + MPPT Solar Controller', '802-058562-001', '8', NULL, NULL, '0', NULL, '1', '', 'INVERTER SUNON IV 6KVA', 0, 0, 'active', '2024-07-10 08:58:38', '2024-07-10 08:58:38', NULL, NULL),
(59, 2, 'SUNPOLO 6kW (New) Control Board', '802-014602-002', '6', NULL, NULL, '0', NULL, '30', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 09:03:46', '2024-07-10 09:03:46', NULL, NULL),
(60, 2, 'SUNPOLO 6 kW (New) Communication Board', '802-014602-004', '5', NULL, NULL, '0', NULL, '42', '', 'IVERTER', 0, 0, 'active', '2024-07-10 09:06:19', '2024-07-10 09:06:19', NULL, NULL),
(61, 2, 'SUNPOLO 8KW 48VDC CONTROL PANEL.', '802-014802-019', '6', NULL, NULL, '0', NULL, '0', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 09:13:41', '2024-07-10 09:13:41', NULL, NULL),
(62, 2, 'SUNPOLO 8kW (New) Control Board', '802-014822-001', '6', NULL, NULL, '0', NULL, '3', '', 'MAIN BOARD', 0, 0, 'active', '2024-07-10 09:18:26', '2024-07-10 09:18:26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `spare_parts_inventory_details`
--

DROP TABLE IF EXISTS `spare_parts_inventory_details`;
CREATE TABLE IF NOT EXISTS `spare_parts_inventory_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `principle_invoice_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `principle_invoice_date` date DEFAULT NULL,
  `grn` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receiving_invoice_date` date DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spare_parts_inventory_details_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spare_parts_inventory_details`
--

INSERT INTO `spare_parts_inventory_details` (`id`, `principle_invoice_no`, `principle_invoice_date`, `grn`, `receiving_invoice_date`, `remarks`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '-', '2019-07-22', 'X0Tkk4', '2024-07-22', NULL, 'completed', 2, '2024-07-22 10:51:39', '2024-07-22 10:51:39'),
(2, '-', '2024-07-07', 'Cu0n7g', '2024-07-22', NULL, 'completed', 2, '2024-07-22 10:56:57', '2024-07-22 10:56:57'),
(3, '-', '2024-07-21', 'KNdgEn', '2024-07-22', NULL, 'completed', 2, '2024-07-22 11:34:37', '2024-07-22 11:34:37'),
(4, '-', '2024-07-21', 'Go3sfS', '2024-07-22', NULL, 'completed', 2, '2024-07-22 11:35:17', '2024-07-22 11:35:17'),
(5, '3345', '2024-08-23', 'SK240005', '2024-08-02', 'testing 12222', 'completed', 2, '2024-08-02 05:51:29', '2024-08-02 05:53:21');

-- --------------------------------------------------------

--
-- Table structure for table `spare_part_categories`
--

DROP TABLE IF EXISTS `spare_part_categories`;
CREATE TABLE IF NOT EXISTS `spare_part_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `spare_part_categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spare_part_categories`
--

INSERT INTO `spare_part_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'IGBT', '2024-07-08 13:26:09', '2024-07-25 15:40:41'),
(2, 'MOSFET', '2024-07-08 13:26:15', NULL),
(3, 'Fan', '2024-07-08 13:26:22', '2024-07-08 13:27:10'),
(4, 'Transformer', '2024-07-08 13:26:28', '2024-07-08 13:27:22'),
(5, 'Communication Board', '2024-07-08 13:26:37', '2024-07-08 13:27:36'),
(6, 'Control Board', '2024-07-08 13:26:46', '2024-07-08 13:27:52'),
(7, 'Main Board', '2024-07-08 13:27:02', NULL),
(8, 'Main Board + MPPT Solar Controller', '2024-07-08 13:28:08', '2024-07-08 13:28:20'),
(9, 'MPPT Solar Controller', '2024-07-08 13:28:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `spare_part_inventories`
--

DROP TABLE IF EXISTS `spare_part_inventories`;
CREATE TABLE IF NOT EXISTS `spare_part_inventories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `factory_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `sparepart_id` bigint UNSIGNED NOT NULL,
  `spare_part_inventory_detail_id` bigint UNSIGNED NOT NULL,
  `repair_date` date DEFAULT NULL,
  `csv_key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty_required` int NOT NULL DEFAULT '0',
  `part_purchase_price` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spare_part_inventories_user_id_foreign` (`user_id`),
  KEY `spare_part_inventories_sparepart_id_foreign` (`sparepart_id`),
  KEY `spare_part_inventories_spare_part_inventory_detail_id_foreign` (`spare_part_inventory_detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spare_part_inventories`
--

INSERT INTO `spare_part_inventories` (`id`, `factory_code`, `user_id`, `sparepart_id`, `spare_part_inventory_detail_id`, `repair_date`, `csv_key`, `order_number`, `serial_number`, `qty_required`, `part_purchase_price`, `created_at`, `updated_at`) VALUES
(1, '802-029202-002', 2, 2, 1, '2024-07-22', 'X0Tkk4', '7458', '4O1AOt', 1, '100', '2024-07-22 10:51:39', '2024-07-22 10:51:39'),
(2, '802-007302-004', 2, 16, 2, '2024-07-22', 'Cu0n7g', '7315', 'gH3HB1', 1, '100', '2024-07-22 10:56:57', '2024-07-22 10:56:57'),
(3, '109-000102-029', 2, 19, 3, '2024-07-22', 'KNdgEn', '128', '9IRs5Z', 10, '100', '2024-07-22 11:34:37', '2024-07-22 11:34:37'),
(4, '108-000203-066', 2, 17, 4, '2024-07-22', 'Go3sfS', '1585', 'hIVbTI', 8, '100', '2024-07-22 11:35:17', '2024-07-22 11:35:17'),
(5, '802-014602-003', 2, 8, 5, '2024-08-02', 'SK240005', '3080', '8O5BVh', 100, '9000', '2024-08-02 05:51:29', '2024-08-02 05:51:29');

-- --------------------------------------------------------

--
-- Table structure for table `spare_part_invoices`
--

DROP TABLE IF EXISTS `spare_part_invoices`;
CREATE TABLE IF NOT EXISTS `spare_part_invoices` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foc` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_center_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `total_amount` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `tax_adjustment` double DEFAULT NULL,
  `foc_status` enum('NON-FOC','FOC Approval Pending','FOC Approved') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('invoice issued','out for delivery','delivered') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `courier_service` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_receipt` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `spare_part_invoices_uuid_unique` (`uuid`),
  KEY `spare_part_invoices_service_center_id_foreign` (`service_center_id`),
  KEY `spare_part_invoices_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spare_part_invoices`
--

INSERT INTO `spare_part_invoices` (`id`, `uuid`, `foc`, `service_center_id`, `user_id`, `total_amount`, `discount`, `tax_adjustment`, `foc_status`, `status`, `courier_service`, `invoice_receipt`, `tracking_id`, `created_at`, `updated_at`) VALUES
(1, '307655fc-cd5b-4f9b-b909-8e82b507b3dc', 'no', 4, 1, 3900, 100, 0, 'NON-FOC', 'invoice issued', NULL, NULL, NULL, '2024-08-05 06:45:56', '2024-08-05 06:45:56');

-- --------------------------------------------------------

--
-- Table structure for table `spare_part_invoice_items`
--

DROP TABLE IF EXISTS `spare_part_invoice_items`;
CREATE TABLE IF NOT EXISTS `spare_part_invoice_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint UNSIGNED NOT NULL,
  `sparepart_id` bigint UNSIGNED NOT NULL,
  `service_center_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `sale_price` double DEFAULT NULL,
  `item_tax` double DEFAULT NULL,
  `item_discount` double DEFAULT NULL,
  `item_total` double DEFAULT NULL,
  `is_sold` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spare_part_invoice_items_invoice_id_foreign` (`invoice_id`),
  KEY `spare_part_invoice_items_sparepart_id_foreign` (`sparepart_id`),
  KEY `spare_part_invoice_items_service_center_id_foreign` (`service_center_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spare_part_invoice_items`
--

INSERT INTO `spare_part_invoice_items` (`id`, `invoice_id`, `sparepart_id`, `service_center_id`, `quantity`, `sale_price`, `item_tax`, `item_discount`, `item_total`, `is_sold`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 4, 1, 4000, 0, 0, 4000, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `spare_part_models`
--

DROP TABLE IF EXISTS `spare_part_models`;
CREATE TABLE IF NOT EXISTS `spare_part_models` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sparepart_id` bigint UNSIGNED NOT NULL,
  `inverter_id` bigint UNSIGNED NOT NULL,
  `dosage` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `plugin_location` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spare_part_models_sparepart_id_foreign` (`sparepart_id`),
  KEY `spare_part_models_inverter_id_foreign` (`inverter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spare_part_models`
--

INSERT INTO `spare_part_models` (`id`, `sparepart_id`, `inverter_id`, `dosage`, `created_at`, `updated_at`, `plugin_location`) VALUES
(2, 2, 1, '1', NULL, NULL, NULL),
(3, 3, 2, '1', NULL, NULL, NULL),
(4, 4, 3, '1', NULL, NULL, NULL),
(5, 5, 4, '1', NULL, NULL, NULL),
(6, 6, 5, '1', NULL, NULL, NULL),
(7, 7, 1, '1', NULL, NULL, NULL),
(8, 8, 5, '1', NULL, NULL, NULL),
(9, 9, 9, '1', NULL, NULL, NULL),
(10, 10, 8, '1', NULL, NULL, NULL),
(11, 11, 8, '1', NULL, NULL, NULL),
(12, 12, 8, '1', NULL, NULL, NULL),
(13, 13, 9, '1', NULL, NULL, NULL),
(14, 14, 7, '1', NULL, NULL, NULL),
(15, 15, 6, '1', NULL, NULL, NULL),
(16, 16, 6, '1', NULL, NULL, NULL),
(17, 17, 6, '8', NULL, NULL, NULL),
(18, 18, 6, '9', NULL, NULL, NULL),
(19, 19, 6, '4', NULL, NULL, NULL),
(20, 20, 6, '1', NULL, NULL, NULL),
(21, 21, 6, '1', NULL, NULL, NULL),
(22, 22, 8, '12', NULL, NULL, NULL),
(23, 23, 8, '18', NULL, NULL, NULL),
(24, 24, 8, '2', NULL, NULL, NULL),
(25, 25, 8, '1', NULL, NULL, NULL),
(26, 26, 8, '1', NULL, NULL, NULL),
(27, 27, 8, '1', NULL, NULL, NULL),
(28, 28, 9, '12', NULL, NULL, NULL),
(29, 29, 9, '18', NULL, NULL, NULL),
(30, 30, 9, '1', NULL, NULL, NULL),
(31, 31, 9, '1', NULL, NULL, NULL),
(32, 32, 9, '1', NULL, NULL, NULL),
(33, 33, 8, '2', NULL, NULL, NULL),
(34, 34, 6, '1', NULL, NULL, NULL),
(35, 35, 6, '1', NULL, NULL, NULL),
(36, 36, 6, '2', NULL, NULL, NULL),
(37, 37, 7, '8', NULL, NULL, NULL),
(38, 38, 7, '1', NULL, NULL, NULL),
(39, 39, 7, '1', NULL, NULL, NULL),
(40, 40, 1, '1', NULL, NULL, NULL),
(41, 41, 1, '16', NULL, NULL, NULL),
(42, 42, 1, '9', NULL, NULL, NULL),
(43, 43, 1, '16', NULL, NULL, NULL),
(44, 44, 1, '1', NULL, NULL, NULL),
(45, 45, 1, '1', NULL, NULL, NULL),
(46, 46, 1, '1', NULL, NULL, NULL),
(47, 47, 1, '1', NULL, NULL, NULL),
(48, 48, 2, '16', NULL, NULL, NULL),
(49, 49, 2, '1', NULL, NULL, NULL),
(50, 50, 2, '1', NULL, NULL, NULL),
(51, 51, 3, '1', NULL, NULL, NULL),
(52, 52, 3, '1', NULL, NULL, NULL),
(53, 53, 3, '1', NULL, NULL, NULL),
(54, 54, 3, '1', NULL, NULL, NULL),
(55, 55, 4, '1', NULL, NULL, NULL),
(56, 56, 3, '1', NULL, NULL, NULL),
(57, 57, 3, '1', NULL, NULL, NULL),
(58, 58, 4, '1', NULL, NULL, NULL),
(59, 59, 5, '1', NULL, NULL, NULL),
(60, 60, 5, '1', NULL, NULL, NULL),
(61, 61, 8, '1', NULL, NULL, NULL),
(62, 62, 8, '1', NULL, NULL, NULL),
(63, 1, 1, '1', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `spare_part_requests`
--

DROP TABLE IF EXISTS `spare_part_requests`;
CREATE TABLE IF NOT EXISTS `spare_part_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sparepart_id` bigint UNSIGNED NOT NULL,
  `service_center_id` bigint UNSIGNED NOT NULL,
  `required_quantity` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spare_part_requests_sparepart_id_foreign` (`sparepart_id`),
  KEY `spare_part_requests_service_center_id_foreign` (`service_center_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `profile_pic` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phoneno_1` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phoneno_2` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `billing_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shipping_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `working_hours` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `monday_timing` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tuesday_timing` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wednesday_timing` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thursday_timing` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `friday_timing` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saturday_timing` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sunday_timing` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','deleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_uuid_unique` (`uuid`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `name`, `email`, `email_verified_at`, `password`, `role_id`, `profile_pic`, `phoneno_1`, `phoneno_2`, `address`, `billing_address`, `shipping_address`, `working_hours`, `monday_timing`, `tuesday_timing`, `wednesday_timing`, `thursday_timing`, `friday_timing`, `saturday_timing`, `sunday_timing`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '8cc61657-3947-41e8-a844-6b6502ff7d36', 'Super Admin', 'superadmin@yopmail.com', NULL, '$2y$10$nL4w6PY4RPC5Xr7igEFS6.5GHbymhRHFU0eIf7DzMAF5mkO8Uk5/O', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2024-07-05 06:11:53', '2024-07-05 06:11:53'),
(2, 'e18151f2-9e2a-4b85-a864-ad20df22d67d', 'First Admin', 'firstadmin@yopmail.com', NULL, '$2y$10$VE1QWZ0Ak0PW7EDe0LREX.xcaGR5orrarmig4WjScoGGFuH4K6vz.', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2024-07-05 06:11:53', '2024-07-05 06:11:53'),
(3, '6b9b13e9-1b4a-4f96-b220-2ce0ecc21c80', 'First Dealer', 'firstdealer@yopmail.com', NULL, '$2y$10$fbQJQzx9RH3pqyLBdgs62ujVIjH7716lwiyK/AybXr7W7XYYY2o3S', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2024-07-05 06:11:53', '2024-07-05 06:11:53'),
(4, '6ef3c44a-e99e-472d-9024-d35880d49229', 'First Service User', 'firstsc@yopmail.com', NULL, '$2y$10$c.hwZ3LpetdKFi1Wg7vuzu7Ui0ImCrKeD7YCO/WFEL9TcxBqpP1NG', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2024-07-05 06:11:54', '2024-07-05 06:11:54');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dealer_products`
--
ALTER TABLE `dealer_products`
  ADD CONSTRAINT `dealer_products_dealer_id_foreign` FOREIGN KEY (`dealer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `dealer_products_deliverynote_id_foreign` FOREIGN KEY (`deliverynote_id`) REFERENCES `deliverynotes` (`id`),
  ADD CONSTRAINT `dealer_products_inverter_id_foreign` FOREIGN KEY (`inverter_id`) REFERENCES `inverters` (`id`);

--
-- Constraints for table `deliverynotes`
--
ALTER TABLE `deliverynotes`
  ADD CONSTRAINT `deliverynotes_dealer_id_foreign` FOREIGN KEY (`dealer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `deliverynotes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `inverters`
--
ALTER TABLE `inverters`
  ADD CONSTRAINT `inverters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `inverter_inventories`
--
ALTER TABLE `inverter_inventories`
  ADD CONSTRAINT `inverter_inventories_inverter_id_foreign` FOREIGN KEY (`inverter_id`) REFERENCES `inverters` (`id`),
  ADD CONSTRAINT `inverter_inventories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `repair_spare_parts`
--
ALTER TABLE `repair_spare_parts`
  ADD CONSTRAINT `repair_spare_parts_repair_id_foreign` FOREIGN KEY (`repair_id`) REFERENCES `repair_tickets` (`id`),
  ADD CONSTRAINT `repair_spare_parts_sparepart_id_foreign` FOREIGN KEY (`sparepart_id`) REFERENCES `spare_parts` (`id`);

--
-- Constraints for table `repair_tickets`
--
ALTER TABLE `repair_tickets`
  ADD CONSTRAINT `repair_tickets_dealer_id_foreign` FOREIGN KEY (`dealer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `repair_tickets_inverter_id_foreign` FOREIGN KEY (`inverter_id`) REFERENCES `inverters` (`id`),
  ADD CONSTRAINT `repair_tickets_service_center_id_foreign` FOREIGN KEY (`service_center_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `repair_tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sc_spare_part_qties`
--
ALTER TABLE `sc_spare_part_qties`
  ADD CONSTRAINT `sc_spare_part_qties_service_center_id_foreign` FOREIGN KEY (`service_center_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `sc_spare_part_qties_sparepart_id_foreign` FOREIGN KEY (`sparepart_id`) REFERENCES `spare_parts` (`id`);

--
-- Constraints for table `spare_parts`
--
ALTER TABLE `spare_parts`
  ADD CONSTRAINT `spare_parts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `spare_parts_inventory_details`
--
ALTER TABLE `spare_parts_inventory_details`
  ADD CONSTRAINT `spare_parts_inventory_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `spare_part_inventories`
--
ALTER TABLE `spare_part_inventories`
  ADD CONSTRAINT `spare_part_inventories_spare_part_inventory_detail_id_foreign` FOREIGN KEY (`spare_part_inventory_detail_id`) REFERENCES `spare_parts_inventory_details` (`id`),
  ADD CONSTRAINT `spare_part_inventories_sparepart_id_foreign` FOREIGN KEY (`sparepart_id`) REFERENCES `spare_parts` (`id`),
  ADD CONSTRAINT `spare_part_inventories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `spare_part_invoices`
--
ALTER TABLE `spare_part_invoices`
  ADD CONSTRAINT `spare_part_invoices_service_center_id_foreign` FOREIGN KEY (`service_center_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `spare_part_invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `spare_part_invoice_items`
--
ALTER TABLE `spare_part_invoice_items`
  ADD CONSTRAINT `spare_part_invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `spare_part_invoices` (`id`),
  ADD CONSTRAINT `spare_part_invoice_items_service_center_id_foreign` FOREIGN KEY (`service_center_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `spare_part_invoice_items_sparepart_id_foreign` FOREIGN KEY (`sparepart_id`) REFERENCES `spare_parts` (`id`);

--
-- Constraints for table `spare_part_models`
--
ALTER TABLE `spare_part_models`
  ADD CONSTRAINT `spare_part_models_inverter_id_foreign` FOREIGN KEY (`inverter_id`) REFERENCES `inverters` (`id`),
  ADD CONSTRAINT `spare_part_models_sparepart_id_foreign` FOREIGN KEY (`sparepart_id`) REFERENCES `spare_parts` (`id`);

--
-- Constraints for table `spare_part_requests`
--
ALTER TABLE `spare_part_requests`
  ADD CONSTRAINT `spare_part_requests_service_center_id_foreign` FOREIGN KEY (`service_center_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `spare_part_requests_sparepart_id_foreign` FOREIGN KEY (`sparepart_id`) REFERENCES `spare_parts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
