-- MySQL dump 10.16  Distrib 10.1.16-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: map
-- ------------------------------------------------------
-- Server version	10.1.16-MariaDB

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
-- Table structure for table `Pass Rate`
--

DROP TABLE IF EXISTS `Pass Rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pass Rate` (
  `hc-key` char(5) DEFAULT NULL,
  `value` decimal(24,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pass Rate`
--

LOCK TABLES `Pass Rate` WRITE;
/*!40000 ALTER TABLE `Pass Rate` DISABLE KEYS */;
INSERT INTO `Pass Rate` VALUES ('tz-as',0.6273),('tz-ds',0.5797),('tz-do',0.5467),('tz-ge',0.6501),('tz-ir',0.6787),('tz-kr',0.6430),('tz-ka',0.6094),('tz-km',0.6644),('tz-kl',0.6131),('tz-li',0.4672),('tz-my',0.6042),('tz-ma',0.5516),('tz-mb',0.6258),('tz-mo',0.5217),('tz-mt',0.5583),('tz-mw',0.6212),('tz-nj',0.6692),('tz-pw',0.6528),('tz-rk',0.6689),('tz-rv',0.6809),('tz-sh',0.6275),('tz-si',0.6341),('tz-sd',0.6262),('tz-tb',0.6208),('tz-tn',0.5372);
/*!40000 ALTER TABLE `Pass Rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pass Rate - Boys`
--

DROP TABLE IF EXISTS `Pass Rate - Boys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pass Rate - Boys` (
  `hc-key` char(5) DEFAULT NULL,
  `value` decimal(24,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pass Rate - Boys`
--

LOCK TABLES `Pass Rate - Boys` WRITE;
/*!40000 ALTER TABLE `Pass Rate - Boys` DISABLE KEYS */;
INSERT INTO `Pass Rate - Boys` VALUES ('tz-as',0.6554),('tz-ds',0.5691),('tz-do',0.5591),('tz-ge',0.7116),('tz-ir',0.7143),('tz-kr',0.6918),('tz-ka',0.6707),('tz-km',0.7078),('tz-kl',0.6196),('tz-li',0.5690),('tz-my',0.6671),('tz-ma',0.5955),('tz-mb',0.6571),('tz-mo',0.5379),('tz-mt',0.6286),('tz-mw',0.6544),('tz-nj',0.7108),('tz-pw',0.6792),('tz-rk',0.7034),('tz-rv',0.7002),('tz-sh',0.6828),('tz-si',0.7073),('tz-sd',0.6533),('tz-tb',0.6692),('tz-tn',0.5741);
/*!40000 ALTER TABLE `Pass Rate - Boys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pass Rate - Girls`
--

DROP TABLE IF EXISTS `Pass Rate - Girls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pass Rate - Girls` (
  `hc-key` char(5) DEFAULT NULL,
  `value` decimal(24,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pass Rate - Girls`
--

LOCK TABLES `Pass Rate - Girls` WRITE;
/*!40000 ALTER TABLE `Pass Rate - Girls` DISABLE KEYS */;
INSERT INTO `Pass Rate - Girls` VALUES ('tz-as',0.6041),('tz-ds',0.5893),('tz-do',0.5348),('tz-ge',0.5713),('tz-ir',0.6495),('tz-kr',0.5993),('tz-ka',0.5319),('tz-km',0.6048),('tz-kl',0.6080),('tz-li',0.3527),('tz-my',0.5579),('tz-ma',0.4911),('tz-mb',0.5970),('tz-mo',0.5048),('tz-mt',0.4827),('tz-mw',0.5845),('tz-nj',0.6386),('tz-pw',0.6258),('tz-rk',0.6224),('tz-rv',0.6626),('tz-sh',0.5609),('tz-si',0.5379),('tz-sd',0.6031),('tz-tb',0.5652),('tz-tn',0.5054);
/*!40000 ALTER TABLE `Pass Rate - Girls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Top 3 Divisions Rate`
--

DROP TABLE IF EXISTS `Top 3 Divisions Rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Top 3 Divisions Rate` (
  `hc-key` char(5) DEFAULT NULL,
  `value` decimal(24,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Top 3 Divisions Rate`
--

LOCK TABLES `Top 3 Divisions Rate` WRITE;
/*!40000 ALTER TABLE `Top 3 Divisions Rate` DISABLE KEYS */;
INSERT INTO `Top 3 Divisions Rate` VALUES ('tz-as',0.2521),('tz-ds',0.2262),('tz-do',0.1709),('tz-ge',0.2269),('tz-ir',0.2459),('tz-kr',0.2450),('tz-ka',0.1795),('tz-km',0.2631),('tz-kl',0.2405),('tz-li',0.1169),('tz-my',0.2132),('tz-ma',0.1902),('tz-mb',0.2320),('tz-mo',0.1957),('tz-mt',0.1606),('tz-mw',0.2482),('tz-nj',0.2311),('tz-pw',0.2965),('tz-rk',0.2394),('tz-rv',0.2285),('tz-sh',0.2432),('tz-si',0.2147),('tz-sd',0.2035),('tz-tb',0.2197),('tz-tn',0.1590);
/*!40000 ALTER TABLE `Top 3 Divisions Rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Top 3 Divisions Rate - Boys`
--

DROP TABLE IF EXISTS `Top 3 Divisions Rate - Boys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Top 3 Divisions Rate - Boys` (
  `hc-key` char(5) DEFAULT NULL,
  `value` decimal(24,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Top 3 Divisions Rate - Boys`
--

LOCK TABLES `Top 3 Divisions Rate - Boys` WRITE;
/*!40000 ALTER TABLE `Top 3 Divisions Rate - Boys` DISABLE KEYS */;
INSERT INTO `Top 3 Divisions Rate - Boys` VALUES ('tz-as',0.2993),('tz-ds',0.2539),('tz-do',0.1980),('tz-ge',0.3087),('tz-ir',0.3024),('tz-kr',0.3106),('tz-ka',0.2513),('tz-km',0.3248),('tz-kl',0.2632),('tz-li',0.1782),('tz-my',0.2939),('tz-ma',0.2354),('tz-mb',0.2903),('tz-mo',0.2280),('tz-mt',0.2282),('tz-mw',0.3078),('tz-nj',0.3006),('tz-pw',0.3372),('tz-rk',0.3042),('tz-rv',0.2695),('tz-sh',0.3208),('tz-si',0.3016),('tz-sd',0.2525),('tz-tb',0.2724),('tz-tn',0.1919);
/*!40000 ALTER TABLE `Top 3 Divisions Rate - Boys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Top 3 Divisions Rate - Girls`
--

DROP TABLE IF EXISTS `Top 3 Divisions Rate - Girls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Top 3 Divisions Rate - Girls` (
  `hc-key` char(5) DEFAULT NULL,
  `value` decimal(24,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Top 3 Divisions Rate - Girls`
--

LOCK TABLES `Top 3 Divisions Rate - Girls` WRITE;
/*!40000 ALTER TABLE `Top 3 Divisions Rate - Girls` DISABLE KEYS */;
INSERT INTO `Top 3 Divisions Rate - Girls` VALUES ('tz-as',0.2131),('tz-ds',0.2013),('tz-do',0.1450),('tz-ge',0.1223),('tz-ir',0.1994),('tz-kr',0.1862),('tz-ka',0.0888),('tz-km',0.1785),('tz-kl',0.2227),('tz-li',0.0480),('tz-my',0.1538),('tz-ma',0.1278),('tz-mb',0.1785),('tz-mo',0.1619),('tz-mt',0.0879),('tz-mw',0.1824),('tz-nj',0.1800),('tz-pw',0.2550),('tz-rk',0.1523),('tz-rv',0.1896),('tz-sh',0.1497),('tz-si',0.1005),('tz-sd',0.1617),('tz-tb',0.1594),('tz-tn',0.1306);
/*!40000 ALTER TABLE `Top 3 Divisions Rate - Girls` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-31 13:15:23
