-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 35.185.45.47    Database: lowhope_db
-- ------------------------------------------------------
-- Server version	5.6.38

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
-- Table structure for table `MULTI_CHOICE_GAME_LOGS`
--

DROP TABLE IF EXISTS `MULTI_CHOICE_GAME_LOGS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MULTI_CHOICE_GAME_LOGS` (
  `USER_ID` int(11) DEFAULT NULL,
  `GAME_ID` int(11) DEFAULT NULL,
  `PRICE_BELOW` tinyint(1) NOT NULL,
  `PRICE_BETWEEN` tinyint(1) NOT NULL,
  `PRICE_ABOVE` tinyint(1) NOT NULL,
  `ANS_TIME` datetime NOT NULL,
  `IS_WINNER` tinyint(1) DEFAULT NULL,
  KEY `USER_ID` (`USER_ID`),
  KEY `GAME_ID` (`GAME_ID`),
  CONSTRAINT `MULTI_CHOICE_GAME_LOGS_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `USERS` (`USER_ID`),
  CONSTRAINT `MULTI_CHOICE_GAME_LOGS_ibfk_2` FOREIGN KEY (`GAME_ID`) REFERENCES `MULTI_CHOICE_GAMES` (`GAME_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MULTI_CHOICE_GAME_LOGS`
--

LOCK TABLES `MULTI_CHOICE_GAME_LOGS` WRITE;
/*!40000 ALTER TABLE `MULTI_CHOICE_GAME_LOGS` DISABLE KEYS */;
INSERT INTO `MULTI_CHOICE_GAME_LOGS` (`USER_ID`, `GAME_ID`, `PRICE_BELOW`, `PRICE_BETWEEN`, `PRICE_ABOVE`, `ANS_TIME`, `IS_WINNER`) VALUES (4,35,0,0,1,'2017-12-06 12:27:23',1),(22,40,0,1,0,'2017-12-09 03:39:02',1);
/*!40000 ALTER TABLE `MULTI_CHOICE_GAME_LOGS` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-11 21:20:09