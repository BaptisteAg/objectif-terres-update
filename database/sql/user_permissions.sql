-- MySQL dump 10.16  Distrib 10.2.29-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: objectifterres
-- ------------------------------------------------------
-- Server version	10.2.29-MariaDB-1:10.2.29+maria~bionic-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `user_permissions`
--

TRUNCATE TABLE user_permissions;

DELETE FROM `user_permissions` WHERE `id`=1;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (1, 90, 1, '2020-08-26 10:50:27', '2020-08-26 10:50:27');
DELETE FROM `user_permissions` WHERE `id`=28;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (28, 114, 1, '2020-10-13 10:02:44', '2020-10-13 10:02:45');
DELETE FROM `user_permissions` WHERE `id`=3;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (3, 89, 1, '2020-09-14 14:34:03', '2020-09-14 14:34:03');
DELETE FROM `user_permissions` WHERE `id`=5;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (5, 57, 1, '2020-09-15 13:45:25', '2020-09-15 13:45:25');
DELETE FROM `user_permissions` WHERE `id`=6;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (6, 56, 1, '2020-09-15 13:47:49', '2020-09-15 13:47:49');
DELETE FROM `user_permissions` WHERE `id`=7;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (7, 52, 1, '2020-09-15 13:48:07', '2020-09-15 13:48:07');
DELETE FROM `user_permissions` WHERE `id`=8;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (8, 60, 1, '2020-09-15 13:49:31', '2020-09-15 13:49:31');
DELETE FROM `user_permissions` WHERE `id`=16;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (16, 64, 1, '2020-09-22 15:07:02', '2020-09-22 15:07:02');
DELETE FROM `user_permissions` WHERE `id`=17;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (17, 50, 1, '2020-09-23 18:18:34', '2020-09-23 18:18:34');
DELETE FROM `user_permissions` WHERE `id`=19;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (19, 54, 1, '2020-09-23 18:29:55', '2020-09-23 18:29:55');
DELETE FROM `user_permissions` WHERE `id`=20;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (20, 104, 1, '2020-09-23 18:33:38', '2020-09-23 18:33:38');
DELETE FROM `user_permissions` WHERE `id`=21;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (21, 53, 1, '2020-09-23 18:34:03', '2020-09-23 18:34:03');
DELETE FROM `user_permissions` WHERE `id`=22;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (22, 58, 1, '2020-09-23 18:34:43', '2020-09-23 18:34:43');
DELETE FROM `user_permissions` WHERE `id`=23;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (23, 63, 1, '2020-09-23 18:36:23', '2020-09-23 18:36:23');
DELETE FROM `user_permissions` WHERE `id`=24;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (24, 109, 1, '2020-09-24 10:06:18', '2020-09-24 10:06:18');
DELETE FROM `user_permissions` WHERE `id`=25;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (25, 108, 1, '2020-09-24 10:07:32', '2020-09-24 10:07:32');
DELETE FROM `user_permissions` WHERE `id`=26;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (26, 98, 1, '2020-09-24 10:16:07', '2020-09-24 10:16:07');
DELETE FROM `user_permissions` WHERE `id`=27;
INSERT INTO `user_permissions` (`id`, `user_id`, `permission`, `created_at`, `updated_at`) VALUES (27, 62, 1, '2020-09-24 13:50:13', '2020-09-24 13:50:13');




/*!40000 ALTER TABLE `user_permissions` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-12 17:04:57
