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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
  `date_debut` date NOT NULL,
  `date_fin` datetime NOT NULL,
  `prix_plancher` decimal(10,2) NOT NULL,
  `coups_de_coeur` smallint NOT NULL DEFAULT '0',
  `membre_id` int NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_enchere_membre1_idx` (`membre_id`),
  CONSTRAINT `fk_enchere_membre1` FOREIGN KEY (`membre_id`) REFERENCES `pweb_membre` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pweb_enchere`
--

LOCK TABLES `pweb_enchere` WRITE;
/*!40000 ALTER TABLE `pweb_enchere` DISABLE KEYS */;
INSERT INTO `pweb_enchere` VALUES (1,'nouveau test','2023-10-31','2023-11-10',26.50,0,1,'cool super cool'),(2,'cool enchère','2023-11-02','2023-11-09',800.50,0,1,'super enchèrer trop cool');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pweb_enchere_favori`
--

LOCK TABLES `pweb_enchere_favori` WRITE;
/*!40000 ALTER TABLE `pweb_enchere_favori` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pweb_image`
--

LOCK TABLES `pweb_image` WRITE;
/*!40000 ALTER TABLE `pweb_image` DISABLE KEYS */;
INSERT INTO `pweb_image` VALUES (1,'stamp_whale.jpg',1,0),(2,'stamp_polka.jpg',2,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pweb_membre`
--

LOCK TABLES `pweb_membre` WRITE;
/*!40000 ALTER TABLE `pweb_membre` DISABLE KEYS */;
INSERT INTO `pweb_membre` VALUES (1,'paul timbre','paul@paul.com','$2y$10$uPl1LQxtBYOVuaPnetfdeuqO5c6SlBkXofBKNj7KQ7g14hgSB/0nK',3),(2,'bill stamp','bill@bill.com','$2y$10$mCeI7O75zPY8ySBeoKazPuh91HnWWhnuqEBejXc4KlN.rkKQJogbm',3);
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
  `date_mise` date NOT NULL,
  PRIMARY KEY (`membre_id`,`enchere_id`),
  KEY `fk_membre_has_enchere_enchere1_idx` (`enchere_id`),
  KEY `fk_membre_has_enchere_membre1_idx` (`membre_id`),
  CONSTRAINT `fk_membre_has_enchere_enchere1` FOREIGN KEY (`enchere_id`) REFERENCES `pweb_enchere` (`id`),
  CONSTRAINT `fk_membre_has_enchere_membre1` FOREIGN KEY (`membre_id`) REFERENCES `pweb_membre` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pweb_mise`
--

LOCK TABLES `pweb_mise` WRITE;
/*!40000 ALTER TABLE `pweb_mise` DISABLE KEYS */;
INSERT INTO `pweb_mise` VALUES (1,1,45.50,'2023-10-31');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pweb_timbre`
--

LOCK TABLES `pweb_timbre` WRITE;
/*!40000 ALTER TABLE `pweb_timbre` DISABLE KEYS */;
INSERT INTO `pweb_timbre` VALUES (1,'super blue','1865-10-18','canada',1,'',NULL,1,3,1),(2,'japan red','1845-03-10','JAPAN',1,'',NULL,2,5,1);
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

-- Dump completed on 2023-11-01 18:57:19
