-- MySQL dump 10.16  Distrib 10.1.20-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.1.20-MariaDB

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
-- Table structure for table `RegionsToKeys`
--

DROP TABLE IF EXISTS `RegionsToKeys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RegionsToKeys` (
  `id` int(11) NOT NULL,
  `region` varchar(26) NOT NULL,
  `hc-key` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RegionsToKeys`
--

LOCK TABLES `RegionsToKeys` WRITE;
/*!40000 ALTER TABLE `RegionsToKeys` DISABLE KEYS */;
INSERT INTO `RegionsToKeys` VALUES (1,'Arusha','tz-as'),(2,'Dar es Salaam','tz-ds'),(3,'Dodoma','tz-do'),(4,'Geita','tz-ge'),(5,'Iringa','tz-ir'),(6,'Kagera','tz-kr'),(7,'Katavi','tz-ka'),(8,'Kigoma','tz-km'),(9,'Kilimanjaro','tz-kl'),(10,'Lindi','tz-li'),(11,'Manyara','tz-my'),(12,'Mara','tz-ma'),(13,'Mbeya','tz-mb'),(14,'Morogoro','tz-mo'),(15,'Mtwara','tz-mt'),(16,'Mwanza','tz-mw'),(17,'Njombe','tz-nj'),(18,'Pwani','tz-pw'),(19,'Rukwa','tz-rk'),(20,'Ruvuma','tz-rv'),(21,'Shinyanga','tz-sh'),(22,'Simiyu','tz-si'),(23,'Singida','tz-sd'),(24,'Tabora','tz-tb'),(25,'Tanga','tz-tn'),(26,'Zanzibar South and Central','tz-zs'),(27,'Zanzibar West','tz-zw'),(28,'Zanzibar North','tz-zn'),(29,'Pemba North','tz-pn'),(30,'Pemba South','tz-ps');
/*!40000 ALTER TABLE `RegionsToKeys` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-23 13:34:10
