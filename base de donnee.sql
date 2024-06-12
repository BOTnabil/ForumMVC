-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forummvc_v2
CREATE DATABASE IF NOT EXISTS `forummvc_v2` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forummvc_v2`;

-- Listage de la structure de table forummvc_v2. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table forummvc_v2.category : ~3 rows (environ)
REPLACE INTO `category` (`id_category`, `name`) VALUES
	(1, 'Gaming'),
	(2, 'Spooky'),
	(3, 'Pol');

-- Listage de la structure de table forummvc_v2. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `topic_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `topic_id` (`topic_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `post_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

-- Listage des données de la table forummvc_v2.post : ~7 rows (environ)
REPLACE INTO `post` (`id_post`, `text`, `creationDate`, `topic_id`, `user_id`) VALUES
	(1, 'Ratio le build magie', '2024-06-07 00:00:00', 1, 1),
	(2, 'BLM', '2024-06-07 15:58:10', 1, 2),
	(3, 'RATIO', '2024-06-10 11:43:36', 1, 1),
	(11, 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '2024-06-10 14:00:37', 1, 2),
	(12, 'test', '2024-06-10 14:33:44', 1, 2),
	(28, 'the ring', '2024-06-12 10:18:27', 19, 3),
	(29, 'eee', '2024-06-12 10:31:29', 20, 3);

-- Listage de la structure de table forummvc_v2. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int NOT NULL,
  `user_id` int NOT NULL,
  `closed` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id_topic`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `topic_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Listage des données de la table forummvc_v2.topic : ~3 rows (environ)
REPLACE INTO `topic` (`id_topic`, `title`, `creationDate`, `category_id`, `user_id`, `closed`) VALUES
	(1, 'Elden Ring', '2024-06-07 00:00:00', 1, 1, b'0'),
	(19, 'Sadako', '2024-06-12 10:18:27', 2, 3, b'0'),
	(20, 'ANARCHIE', '2024-06-12 10:31:29', 3, 3, b'0');

-- Listage de la structure de table forummvc_v2. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(25) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `role` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'user',
  `creationDate` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Listage des données de la table forummvc_v2.user : ~3 rows (environ)
REPLACE INTO `user` (`id_user`, `pseudo`, `email`, `password`, `role`, `creationDate`) VALUES
	(1, 'EikichiOkan', 'fraudeDeMarseille@monstre.fr', 'OkalageDuBrody', 'user', '2024-06-01 00:00:00'),
	(2, 'MadaBobby', 'AfghanUnleashed@patate.fr', 'Soinc', 'user', '2024-05-29 00:00:00'),
	(3, 'Coolkidnabs', 'assatour.nabil@gmail.com', '$2y$10$gVMqgbuYZq7uGQSNN9zA4e4.Xp/135bstbLvDMIP87DJR8NbmVmLu', 'ROLE_ADMIN', '2024-06-12 08:54:13');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
