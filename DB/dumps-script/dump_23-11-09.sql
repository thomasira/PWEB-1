-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: e2395387
-- ------------------------------------------------------
-- Server version	8.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `pweb_condition`
--

DROP TABLE IF EXISTS `pweb_condition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pweb_condition` (
  `id` int NOT NULL AUTO_INCREMENT,
  `condition` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pweb_condition`
--

LOCK TABLES `pweb_condition` WRITE;
/*!40000 ALTER TABLE `pweb_condition` DISABLE KEYS */;
INSERT INTO `pweb_condition` VALUES (1,'mint'),(2,'mint-1'),(3,'mint-2'),(4,'used'),(5,'ripped');
/*!40000 ALTER TABLE `pweb_condition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pweb_enchere`
--

DROP TABLE IF EXISTS `pweb_enchere`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pweb_enchere` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_enchere` varchar(45) DEFAULT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `prix_plancher` decimal(10,2) NOT NULL,
  `coups_de_coeur` smallint NOT NULL DEFAULT '0',
  `membre_id` int NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_enchere_membre1_idx` (`membre_id`),
  CONSTRAINT `fk_enchere_membre1` FOREIGN KEY (`membre_id`) REFERENCES `pweb_membre` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pweb_enchere`
--

LOCK TABLES `pweb_enchere` WRITE;
/*!40000 ALTER TABLE `pweb_enchere` DISABLE KEYS */;
INSERT INTO `pweb_enchere` VALUES (2,'cool enchères','2023-11-02 00:00:00','2023-11-17 00:00:00',800.50,1,1,'dasd asd fad g Sdfs df'),(3,'test de datetime','2023-11-16 00:00:00','2023-11-22 20:24:00',56.50,0,2,''),(4,'','2023-11-02 00:00:00','2023-11-09 20:53:00',59.00,0,2,''),(5,'test no image','2023-11-16 10:02:00','2023-12-01 10:02:00',46.00,0,2,''),(6,'test no image again','2023-11-05 10:04:00','2023-11-17 10:04:00',65.00,0,2,''),(7,'test multiples images','2023-11-24 10:18:00','2023-11-25 10:18:00',56.00,0,1,''),(15,'test ppour john','2023-11-09 07:57:00','2023-11-10 07:57:00',245.00,1,3,'un nouveau test pour john'),(16,'deuxieme test for john','2023-11-09 08:00:00','2023-11-10 08:00:00',659.00,0,3,''),(17,'test for tom','2023-11-09 08:01:00','2023-11-10 08:01:00',95.00,0,4,''),(18,'2test for tom','2023-11-09 08:02:00','2023-11-22 08:02:00',598.00,1,4,''),(19,'canada','2023-11-09 17:45:00','2023-11-09 17:51:00',14.00,0,1,'tester recherche par nom bis');
/*!40000 ALTER TABLE `pweb_enchere` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pweb_enchere_favori`
--

DROP TABLE IF EXISTS `pweb_enchere_favori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pweb_enchere_favori` (
  `enchere_id` int NOT NULL,
  `membre_id` int NOT NULL,
  PRIMARY KEY (`enchere_id`,`membre_id`),
  KEY `fk_enchere_has_membre_membre1_idx` (`membre_id`),
  KEY `fk_enchere_has_membre_enchere1_idx` (`enchere_id`),
  CONSTRAINT `fk_enchere_has_membre_enchere1` FOREIGN KEY (`enchere_id`) REFERENCES `pweb_enchere` (`id`),
  CONSTRAINT `fk_enchere_has_membre_membre1` FOREIGN KEY (`membre_id`) REFERENCES `pweb_membre` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pweb_enchere_favori`
--

LOCK TABLES `pweb_enchere_favori` WRITE;
/*!40000 ALTER TABLE `pweb_enchere_favori` DISABLE KEYS */;
INSERT INTO `pweb_enchere_favori` VALUES (3,1),(15,1),(4,4),(15,4);
/*!40000 ALTER TABLE `pweb_enchere_favori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pweb_image`
--

DROP TABLE IF EXISTS `pweb_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pweb_image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image_link` varchar(45) NOT NULL,
  `timbre_id` int NOT NULL,
  `principale` smallint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_images_timbre1_idx` (`timbre_id`),
  CONSTRAINT `fk_images_timbre1` FOREIGN KEY (`timbre_id`) REFERENCES `pweb_timbre` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pweb_image`
--

LOCK TABLES `pweb_image` WRITE;
/*!40000 ALTER TABLE `pweb_image` DISABLE KEYS */;
INSERT INTO `pweb_image` VALUES (2,'stamp_polka.jpg',2,1),(3,'stamps2.jpg',3,1),(6,'13faaca2bf39dd0579534da0d8a7a335.webp',7,0),(7,'57da0a3a5c1e76eac72e1e11e85db94b.webp',7,1),(8,'eb115be02497f0583e6a3df8ff81646c.webp',7,0),(9,'il_600x600.3623713993_sz12.webp',7,0),(14,'CN_1909_MiNr0079_pm_B002a.webp',15,0),(15,'Stamp_China_1897_0.5c_litho.webp',15,1),(16,'u1125q4.webp',16,1),(17,'daa69c3bb90996e8bb2bfd61edbb2c83.webp',17,1),(18,'il_600x600.4790561103_4z6x.webp',17,0),(19,'handfan9-247x201.webp',18,0),(20,'il_600x600.3947207928_s8i5.webp',18,1),(21,'daa69c3bb90996e8bb2bfd61edbb2c83.webp',19,0),(22,'il_600x600.4790561103_4z6x.webp',19,1),(23,'US_C3.webp',19,0);
/*!40000 ALTER TABLE `pweb_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pweb_membre`
--

DROP TABLE IF EXISTS `pweb_membre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pweb_membre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_membre` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `privilege_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_membre_privilege1_idx` (`privilege_id`),
  CONSTRAINT `fk_membre_privilege1` FOREIGN KEY (`privilege_id`) REFERENCES `pweb_privilege` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pweb_membre`
--

LOCK TABLES `pweb_membre` WRITE;
/*!40000 ALTER TABLE `pweb_membre` DISABLE KEYS */;
INSERT INTO `pweb_membre` VALUES (1,'paul timbre','paul@paul.com','$2y$10$uPl1LQxtBYOVuaPnetfdeuqO5c6SlBkXofBKNj7KQ7g14hgSB/0nK',3),(2,'bill stamp','bill@bill.com','$2y$10$mCeI7O75zPY8ySBeoKazPuh91HnWWhnuqEBejXc4KlN.rkKQJogbm',3),(3,'john mail','john@john.com','$2y$10$uKRJOL6j2fgOkKXjh/utzeaPmk.a5BHIPt2F9rjtEAaYex1Bn2gOq',3),(4,'tom stamp','tom@tom.com','$2y$10$xbxHSzoqWjR2k55cpTVxY.k8.xWNiKxy3X9eJK1eXXfSZrmbXkMdC',3);
/*!40000 ALTER TABLE `pweb_membre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pweb_mise`
--

DROP TABLE IF EXISTS `pweb_mise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pweb_mise` (
  `membre_id` int NOT NULL,
  `enchere_id` int NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `date_mise` datetime NOT NULL,
  PRIMARY KEY (`membre_id`,`enchere_id`,`montant`),
  KEY `fk_membre_has_enchere_enchere1_idx` (`enchere_id`),
  KEY `fk_membre_has_enchere_membre1_idx` (`membre_id`),
  CONSTRAINT `fk_membre_has_enchere_enchere1` FOREIGN KEY (`enchere_id`) REFERENCES `pweb_enchere` (`id`),
  CONSTRAINT `fk_membre_has_enchere_membre1` FOREIGN KEY (`membre_id`) REFERENCES `pweb_membre` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pweb_mise`
--

LOCK TABLES `pweb_mise` WRITE;
/*!40000 ALTER TABLE `pweb_mise` DISABLE KEYS */;
INSERT INTO `pweb_mise` VALUES (1,2,801.50,'2023-11-03 01:45:30'),(1,2,802.50,'2023-11-07 01:07:27'),(1,2,812.00,'2023-11-08 08:07:01'),(1,3,986.00,'2023-11-03 01:44:33'),(1,3,987.00,'2023-11-06 10:14:59'),(1,3,988.00,'2023-11-09 12:27:59'),(1,3,990.00,'2023-11-10 12:24:30'),(1,4,60.00,'2023-11-03 01:45:35'),(1,4,61.00,'2023-11-03 01:46:53'),(1,4,62.00,'2023-11-03 01:46:56'),(1,4,63.00,'2023-11-03 01:47:00'),(1,4,64.00,'2023-11-03 01:47:14'),(1,4,65.00,'2023-11-03 01:48:13'),(1,4,90.00,'2023-11-04 01:23:19'),(1,4,91.00,'2023-11-04 01:23:24'),(1,4,92.00,'2023-11-08 08:03:18'),(1,4,93.00,'2023-11-08 08:06:19'),(1,4,94.00,'2023-11-09 12:27:55'),(1,6,66.00,'2023-11-07 08:39:41'),(1,6,67.00,'2023-11-08 08:03:13'),(1,7,57.00,'2023-11-04 03:07:00'),(1,7,58.00,'2023-11-04 03:07:04'),(1,7,61.00,'2023-11-06 10:22:12'),(1,18,599.00,'2023-11-10 12:12:03'),(2,2,803.50,'2023-11-07 09:30:09'),(2,2,810.00,'2023-11-07 09:30:14'),(2,2,811.00,'2023-11-07 09:43:29'),(2,4,89.00,'2023-11-03 01:49:10'),(2,7,62.00,'2023-11-07 09:43:42'),(4,2,813.00,'2023-11-09 03:54:13'),(4,3,989.00,'2023-11-09 02:11:35'),(4,4,95.00,'2023-11-09 01:54:29'),(4,5,47.00,'2023-11-09 02:32:08'),(4,15,246.00,'2023-11-10 01:04:14');
/*!40000 ALTER TABLE `pweb_mise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pweb_privilege`
--

DROP TABLE IF EXISTS `pweb_privilege`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pweb_privilege` (
  `id` int NOT NULL AUTO_INCREMENT,
  `privilege` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pweb_privilege`
--

LOCK TABLES `pweb_privilege` WRITE;
/*!40000 ALTER TABLE `pweb_privilege` DISABLE KEYS */;
INSERT INTO `pweb_privilege` VALUES (1,'admin'),(2,'staff'),(3,'member');
/*!40000 ALTER TABLE `pweb_privilege` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pweb_timbre`
--

DROP TABLE IF EXISTS `pweb_timbre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pweb_timbre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_timbre` varchar(45) NOT NULL,
  `date_creation` date NOT NULL,
  `pays_origine` varchar(20) NOT NULL,
  `certifie` smallint NOT NULL,
  `tirage` varchar(45) DEFAULT NULL,
  `dimensions` varchar(45) DEFAULT NULL,
  `couleur` varchar(45) DEFAULT NULL,
  `enchere_id` int NOT NULL,
  `condition_id` int DEFAULT NULL,
  `membre_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_timbre_condition_idx` (`condition_id`),
  KEY `fk_timbre_enchere1_idx` (`enchere_id`),
  KEY `fk_timbre_membre1_idx` (`membre_id`),
  CONSTRAINT `fk_timbre_condition` FOREIGN KEY (`condition_id`) REFERENCES `pweb_condition` (`id`),
  CONSTRAINT `fk_timbre_enchere1` FOREIGN KEY (`enchere_id`) REFERENCES `pweb_enchere` (`id`),
  CONSTRAINT `fk_timbre_membre1` FOREIGN KEY (`membre_id`) REFERENCES `pweb_membre` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pweb_timbre`
--

LOCK TABLES `pweb_timbre` WRITE;
/*!40000 ALTER TABLE `pweb_timbre` DISABLE KEYS */;
INSERT INTO `pweb_timbre` VALUES (2,'japan redsd','1845-03-05','canada',0,'',NULL,NULL,2,3,1),(3,'testest','2023-11-15','canada',0,'',NULL,NULL,3,3,2),(4,'fsd fsdfsdf','1987-06-01','den',0,'',NULL,NULL,4,3,2),(5,'test no image','2023-05-31','den',1,'',NULL,NULL,5,1,2),(6,'testest no image','1987-11-29','canada',0,'',NULL,NULL,6,1,2),(7,'test multiples images','2023-11-02','canada',0,'',NULL,NULL,7,2,1),(15,'test ppour john','1956-11-02','china',1,'',NULL,NULL,15,3,3),(16,'deuxieme test','1987-11-08','Belgium',1,'',NULL,NULL,16,3,3),(17,'test for tom','1865-11-21','congo',1,'',NULL,NULL,17,3,4),(18,'2test for tom','1945-01-09','sweden',1,'',NULL,'gris',18,4,4),(19,'test canada','1956-10-04','sweden',1,'',NULL,'',19,4,1);
/*!40000 ALTER TABLE `pweb_timbre` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-09 20:30:03
