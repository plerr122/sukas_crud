-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for seblak
DROP DATABASE IF EXISTS `seblak`;
CREATE DATABASE IF NOT EXISTS `seblak` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `seblak`;

-- Dumping structure for table seblak.detail_transaksi
DROP TABLE IF EXISTS `detail_transaksi`;
CREATE TABLE IF NOT EXISTS `detail_transaksi` (
  `detail_id` int NOT NULL AUTO_INCREMENT,
  `transaksi_id` int DEFAULT NULL,
  `item_id` int DEFAULT NULL,
  `jumlah` int DEFAULT '1',
  `subtotal` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`detail_id`),
  KEY `transaksi_id` (`transaksi_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`transaksi_id`),
  CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu_items` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seblak.detail_transaksi: ~0 rows (approximately)
DELETE FROM `detail_transaksi`;

-- Dumping structure for table seblak.menu_items
DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE IF NOT EXISTS `menu_items` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `nama_item` varchar(100) NOT NULL,
  `kategori` enum('bahan utama','topping','level pedas','tambahan') NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int DEFAULT '0',
  `aktif` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seblak.menu_items: ~3 rows (approximately)
DELETE FROM `menu_items`;
INSERT INTO `menu_items` (`item_id`, `nama_item`, `kategori`, `harga`, `stok`, `aktif`) VALUES
	(1, 'arsila', 'bahan utama', 100.00, 30, 1),
	(2, 'ohim', 'tambahan', 1.00, 10000000, 1),
	(3, 'alip', 'level pedas', 10000.00, 90, 1);

-- Dumping structure for table seblak.transaksi
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE IF NOT EXISTS `transaksi` (
  `transaksi_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_harga` decimal(10,2) DEFAULT '0.00',
  `status` enum('pending','selesai','batal') DEFAULT 'pending',
  PRIMARY KEY (`transaksi_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seblak.transaksi: ~0 rows (approximately)
DELETE FROM `transaksi`;

-- Dumping structure for table seblak.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `role` enum('admin','pelanggan') DEFAULT 'pelanggan',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table seblak.users: ~3 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`user_id`, `username`, `password`, `nama_lengkap`, `role`, `created_at`) VALUES
	(1, 'ohimjeletot', '$2y$10$5JFX5ZLL34eLvM.tNj5nw.rRHXFPmhB24l715edZ6tUUAEXbBvEv.', 'Admin System', 'admin', '2025-11-18 02:17:40'),
	(2, 'ningsih', '$2y$10$G32XeJ1Ci.xdw4gDWrV1m.9C5YzvA/4urDy6/4P7G/DERu.Q88aGi', 'ningsih', 'pelanggan', '2025-11-19 04:24:35'),
	(3, 'faruq', '$2y$10$N8/xCDCnIsuVlYR9Ppk/Bu7Uf/LDLLyl7GkYAMEK2rXMKvzmA0m86', 'faruq', 'pelanggan', '2025-11-19 04:25:13');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
