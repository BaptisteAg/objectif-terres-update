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

DROP TABLE IF EXISTS `user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `permission` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_permissions_user_id_permission_unique` (`user_id`,`permission`),
  KEY `fk_user_id_idx` (`user_id`),
  CONSTRAINT `fk_user_id_idx` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_permissions`
--

LOCK TABLES `user_permissions` WRITE;
/*!40000 ALTER TABLE `user_permissions` DISABLE KEYS */;
INSERT INTO `user_permissions` VALUES (1,90,1,'2020-08-26 10:50:27','2020-08-26 10:50:27'),(3,89,1,'2020-09-14 14:34:03','2020-09-14 14:34:03'),(5,57,1,'2020-09-15 13:45:25','2020-09-15 13:45:25'),(6,56,1,'2020-09-15 13:47:49','2020-09-15 13:47:49'),(7,52,1,'2020-09-15 13:48:07','2020-09-15 13:48:07'),(8,60,1,'2020-09-15 13:49:31','2020-09-15 13:49:31'),(16,64,1,'2020-09-22 15:07:02','2020-09-22 15:07:02'),(17,50,1,'2020-09-23 18:18:34','2020-09-23 18:18:34'),(19,54,1,'2020-09-23 18:29:55','2020-09-23 18:29:55'),(20,104,1,'2020-09-23 18:33:38','2020-09-23 18:33:38'),(21,53,1,'2020-09-23 18:34:03','2020-09-23 18:34:03'),(22,58,1,'2020-09-23 18:34:43','2020-09-23 18:34:43'),(23,63,1,'2020-09-23 18:36:23','2020-09-23 18:36:23'),(24,109,1,'2020-09-24 10:06:18','2020-09-24 10:06:18'),(25,108,1,'2020-09-24 10:07:32','2020-09-24 10:07:32'),(26,98,1,'2020-09-24 10:16:07','2020-09-24 10:16:07'),(27,62,1,'2020-09-24 13:50:13','2020-09-24 13:50:13');
/*!40000 ALTER TABLE `user_permissions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-12 17:04:57
