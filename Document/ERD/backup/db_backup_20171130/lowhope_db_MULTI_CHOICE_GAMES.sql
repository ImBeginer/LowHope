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
-- Table structure for table `MULTI_CHOICE_GAMES`
--

DROP TABLE IF EXISTS `MULTI_CHOICE_GAMES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MULTI_CHOICE_GAMES` (
  `GAME_ID` int(11) NOT NULL AUTO_INCREMENT,
  `OWNER_ID` int(11) DEFAULT NULL,
  `CUR_TYPE_ID` int(11) DEFAULT NULL,
  `TITLE` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `CONTENT` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `START_DATE` datetime NOT NULL,
  `END_DATE` datetime NOT NULL,
  `POINT_TO_BET` double NOT NULL,
  `PRICE_BELOW` double DEFAULT NULL,
  `PRICE_ABOVE` double DEFAULT NULL,
  `RESULT` double DEFAULT NULL,
  `PLAYER_COUNT` int(2) NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `TOTAL_AMOUNT` double NOT NULL,
  PRIMARY KEY (`GAME_ID`),
  KEY `OWNER_ID` (`OWNER_ID`),
  KEY `CUR_TYPE_ID` (`CUR_TYPE_ID`),
  CONSTRAINT `MULTI_CHOICE_GAMES_ibfk_1` FOREIGN KEY (`OWNER_ID`) REFERENCES `USERS` (`USER_ID`),
  CONSTRAINT `MULTI_CHOICE_GAMES_ibfk_2` FOREIGN KEY (`CUR_TYPE_ID`) REFERENCES `CURRENCY_TYPE` (`TYPE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `MULTI_CHOICE_GAMES`
--

LOCK TABLES `MULTI_CHOICE_GAMES` WRITE;
/*!40000 ALTER TABLE `MULTI_CHOICE_GAMES` DISABLE KEYS */;
INSERT INTO `MULTI_CHOICE_GAMES` (`GAME_ID`, `OWNER_ID`, `CUR_TYPE_ID`, `TITLE`, `CONTENT`, `START_DATE`, `END_DATE`, `POINT_TO_BET`, `PRICE_BELOW`, `PRICE_ABOVE`, `RESULT`, `PLAYER_COUNT`, `ACTIVE`, `TOTAL_AMOUNT`) VALUES (22,22,1,'fpt 1:13',NULL,'2017-11-30 01:09:59','2017-11-30 01:13:00',0,5000,10000,10719.21,2,0,20),(23,24,1,'thu nguye 01:19',NULL,'2017-11-30 01:17:49','2017-11-30 01:19:00',0,5000,10000,10647.8,2,0,20),(24,24,1,'tn 1:24',NULL,'2017-11-30 01:21:19','2017-11-30 01:24:00',0,5000,10000,10625.68,2,0,20),(25,24,1,'tn 1:30',NULL,'2017-11-30 01:29:12','2017-11-30 10:30:00',0,5000,10000,10548.82,3,0,30),(26,1,1,'congld game multiple',NULL,'2017-11-30 16:08:11','2017-11-30 16:10:00',0,6789,9876,10265.63,2,0,20),(27,4,1,'cong cong multiple',NULL,'2017-11-30 16:36:32','2017-11-30 16:41:00',0,7890,9879,10145.7,2,0,20),(28,1,1,'congld multi game',NULL,'2017-11-30 20:03:45','2017-11-30 20:04:00',0,6789,9857.6,9790.23,0,0,0),(29,20,1,'ldc game multiple',NULL,'2017-11-30 20:14:29','2017-11-30 20:20:00',0,5678.9,9876.55,9743.73,2,0,20),(30,1,1,'testss',NULL,'2017-11-30 23:37:04','2017-11-30 23:40:00',0,6789.56,7896.9,9323.16,2,0,20);
/*!40000 ALTER TABLE `MULTI_CHOICE_GAMES` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-30 23:57:20