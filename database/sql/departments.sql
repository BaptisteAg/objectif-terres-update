--
-- Host: 127.0.0.1    Database: frenchzipcode
-- ------------------------------------------------------
-- Server version	5.7.22

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
-- Table structure for table `departments`
--
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

-- Territoires
-- 1	Alsace
-- 2	Aquitaine
-- 3	Auvergne
-- 4	Bourgogne / Franche-Comté
-- 5	 Bretagne
-- 6	 Centre
-- 7	 Champagne-Ardenne
-- 8	 Corsica
-- 9	 Hauts-de-France
-- 10	 Ile-de-France
-- 11	 Languedoc-Roussillon
-- 12	 Limousin
-- 13	 Lorraine
-- 15	 Midi-Pyrénées
-- 16	 Normandie
-- 17	 Pays de la Loire
-- 19	 Poitou-Charentes
-- 20	PACA
-- 21	Rhône-Alpes
-- 22	Niveau National


LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
REPLACE INTO `departments` (`id`,`region_code`,`code`,`name`,`slug`, `territory_id`)
VALUES
(1, '84', '01', 'Ain', 'ain', 21),
(2, '32', '02', 'Aisne', 'aisne', 9),
(3, '84', '03', 'Allier', 'allier', 3),
(4, '93', '04', 'Alpes-de-Haute-Provence', 'alpes de haute provence', 20),
(6, '93', '06', 'Alpes-Maritimes', 'alpes maritimes', 20),
(7, '84', '07', 'Ardèche', 'ardeche', 21),
(8, '44', '08', 'Ardennes', 'ardennes', 7),
(9, '76', '09', 'Ariège', 'ariege', 15),
(10, '44', '10', 'Aube', 'aube', 7),
(11, '76', '11', 'Aude', 'aude', 11),
(12, '76', '12', 'Aveyron', 'aveyron', 15),
(68, '44', '67', 'Bas-Rhin', 'bas rhin', 1),
(13, '93', '13', 'Bouches-du-Rhône', 'bouches du rhone', 20),
(14, '28', '14', 'Calvados', 'calvados', 16),
(15, '84', '15', 'Cantal', 'cantal', 3),
(16, '75', '16', 'Charente', 'charente', 19),
(17, '75', '17', 'Charente-Maritime', 'charente maritime', 19),
(18, '24', '18', 'Cher', 'cher', 6),
(19, '75', '19', 'Corrèze', 'correze', 12),
(29, '94', '2A', 'Corse-du-Sud', 'corse du sud', 8),
(20, '27', '21', 'Côte-d''Or', 'cote dor', 4),
(21, '53', '22', 'Côtes-d''Armor', 'cotes darmor', 5),
(22, '75', '23', 'Creuse', 'creuse', 12),
(80, '75', '79', 'Deux-Sèvres', 'deux sevres', 19),
(23, '75', '24', 'Dordogne', 'dordogne', 2),
(24, '27', '25', 'Doubs', 'doubs', 4),
(25, '84', '26', 'Drôme', 'drome', 21),
(92, '11', '91', 'Essonne', 'essonne', 10),
(26, '28', '27', 'Eure', 'eure', 16),
(27, '24', '28', 'Eure-et-Loir', 'eure et loir', 6),
(28, '53', '29', 'Finistère', 'finistere', 5),
(31, '76', '30', 'Gard', 'gard', 11),
(33, '76', '32', 'Gers', 'gers', 15),
(34, '75', '33', 'Gironde', 'gironde', 2),
(69, '44', '68', 'Haut-Rhin', 'haut rhin', 1),
(30, '94', '2B', 'Haute-Corse', 'haute corse', 8),
(32, '76', '31', 'Haute-Garonne', 'haute garonne', 15),
(44, '84', '43', 'Haute-Loire', 'haute loire', 3),
(53, '44', '52', 'Haute-Marne', 'haute marne', 7),
(71, '27', '70', 'Haute-Saône', 'haute saone', 4),
(75, '84', '74', 'Haute-Savoie', 'haute savoie', 21),
(88, '75', '87', 'Haute-Vienne', 'haute vienne', 12),
(5, '93', '05', 'Hautes-Alpes', 'hautes alpes', 20),
(66, '76', '65', 'Hautes-Pyrénées', 'hautes pyrenees', 15),
(93, '11', '92', 'Hauts-de-Seine', 'hauts de seine', 10),
(35, '76', '34', 'Hérault', 'herault', 11),
(36, '53', '35', 'Ille-et-Vilaine', 'ille et vilaine', 5),
(37, '24', '36', 'Indre', 'indre', 6),
(38, '24', '37', 'Indre-et-Loire', 'indre et loire', 6),
(39, '84', '38', 'Isère', 'isere', 21),
(40, '27', '39', 'Jura', 'jura', 4),
(41, '75', '40', 'Landes', 'landes', 2),
(42, '24', '41', 'Loir-et-Cher', 'loir et cher', 6),
(43, '84', '42', 'Loire', 'loire', 21),
(45, '52', '44', 'Loire-Atlantique', 'loire atlantique', 17),
(46, '24', '45', 'Loiret', 'loiret', 6),
(47, '76', '46', 'Lot', 'lot', 15),
(48, '75', '47', 'Lot-et-Garonne', 'lot et garonne', 2),
(49, '76', '48', 'Lozère', 'lozere', 11),
(50, '52', '49', 'Maine-et-Loire', 'maine et loire', 17),
(51, '28', '50', 'Manche', 'manche', 16),
(52, '44', '51', 'Marne', 'marne', 7),
(54, '52', '53', 'Mayenne', 'mayenne', 17),
(55, '44', '54', 'Meurthe-et-Moselle', 'meurthe et moselle', 13),
(56, '44', '55', 'Meuse', 'meuse', 13),
(57, '53', '56', 'Morbihan', 'morbihan', 5),
(58, '44', '57', 'Moselle', 'moselle', 13),
(59, '27', '58', 'Nièvre', 'nievre', 4),
(60, '32', '59', 'Nord', 'nord', 9),
(61, '32', '60', 'Oise', 'oise', 9),
(62, '28', '61', 'Orne', 'orne', 16),
(76, '11', '75', 'Paris', 'paris', 10),
(63, '32', '62', 'Pas-de-Calais', 'pas de calais', 9),
(64, '84', '63', 'Puy-de-Dôme', 'puy de dome', 3),
(65, '75', '64', 'Pyrénées-Atlantiques', 'pyrenees atlantiques', 2),
(67, '76', '66', 'Pyrénées-Orientales', 'pyrenees orientales', 11),
(70, '84', '69', 'Rhône', 'rhone', 21),
(72, '27', '71', 'Saône-et-Loire', 'saone et loire', 4),
(73, '52', '72', 'Sarthe', 'sarthe', 17),
(74, '84', '73', 'Savoie', 'savoie', 21),
(78, '11', '77', 'Seine-et-Marne', 'seine et marne', 10),
(77, '28', '76', 'Seine-Maritime', 'seine maritime', 16),
(94, '11', '93', 'Seine-Saint-Denis', 'seine saint denis', 10),
(81, '32', '80', 'Somme', 'somme', 9),
(82, '76', '81', 'Tarn', 'tarn', 15),
(83, '76', '82', 'Tarn-et-Garonne', 'tarn et garonne', 15),
(91, '27', '90', 'Territoire de Belfort', 'territoire de belfort', 4),
(96, '11', '95', 'Val-d''Oise', 'val doise', 10),
(95, '11', '94', 'Val-de-Marne', 'val de marne', 10),
(84, '93', '83', 'Var', 'var', 20),
(85, '93', '84', 'Vaucluse', 'vaucluse', 20),
(86, '52', '85', 'Vendée', 'vendee', 17),
(87, '75', '86', 'Vienne', 'vienne', 19),
(89, '44', '88', 'Vosges', 'vosges', 13),
(90, '27', '89', 'Yonne', 'yonne', 4),
(79, '11', '78', 'Yvelines', 'yvelines', 10),
(97,'01','971','Guadeloupe','guadeloupe', 22),
(98,'02','972','Martinique','martinique', 22),
(99,'03','973','Guyane','guyane', 22),
(100,'04','974','La Réunion','la reunion', 22),
(101,'06','976','Mayotte','mayotte', 22),
(102,'COM','975','Saint-Pierre-et-Miquelon','saint pierre et miquelon', 22),
(103,'COM','977','Saint-Barthélemy','saint barthelemy', 22),
(104,'COM','978','Saint-Martin','saint martin', 22),
(105,'COM','984','Terres australes et antarctiques françaises','terres australes et antarctiques francaises', 22),
(106,'COM','986','Wallis et Futuna','wallis et futuna', 22),
(107,'COM','987','Polynésie française','polynesie francaise', 22),
(108,'COM','988','Nouvelle-Calédonie','nouvelle caledonie', 22),
(109,'COM','989','Île de Clipperton','ile de clipperton', 22);

/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-07-05 13:51:23
