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
-- Table structure for table `YN_GAMES`
--

DROP TABLE IF EXISTS `YN_GAMES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `YN_GAMES` (
  `GAME_ID` int(11) NOT NULL AUTO_INCREMENT,
  `OWNER_ID` int(11) DEFAULT NULL,
  `CUR_TYPE_ID` int(11) DEFAULT NULL,
  `TITLE` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `CONTENT` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `START_DATE` datetime NOT NULL,
  `END_DATE` datetime NOT NULL,
  `POINT_TO_BET` double NOT NULL,
  `PRICE_BET` double NOT NULL,
  `RESULT` double DEFAULT NULL,
  `PLAYER_COUNT` int(2) NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `TOTAL_AMOUNT` double NOT NULL,
  PRIMARY KEY (`GAME_ID`),
  KEY `OWNER_ID` (`OWNER_ID`),
  KEY `CUR_TYPE_ID` (`CUR_TYPE_ID`),
  CONSTRAINT `YN_GAMES_ibfk_1` FOREIGN KEY (`OWNER_ID`) REFERENCES `USERS` (`USER_ID`),
  CONSTRAINT `YN_GAMES_ibfk_2` FOREIGN KEY (`CUR_TYPE_ID`) REFERENCES `CURRENCY_TYPE` (`TYPE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `YN_GAMES`
--

LOCK TABLES `YN_GAMES` WRITE;
/*!40000 ALTER TABLE `YN_GAMES` DISABLE KEYS */;
INSERT INTO `YN_GAMES` (`GAME_ID`, `OWNER_ID`, `CUR_TYPE_ID`, `TITLE`, `CONTENT`, `START_DATE`, `END_DATE`, `POINT_TO_BET`, `PRICE_BET`, `RESULT`, `PLAYER_COUNT`, `ACTIVE`, `TOTAL_AMOUNT`) VALUES (38,4,1,'cong cong yn',NULL,'2017-11-29 17:04:08','2017-11-29 21:40:00',0,7000,11261.95,2,0,20),(40,24,1,'phong pla',NULL,'2017-11-29 22:05:30','2017-11-29 22:07:00',0,8000,11174.35,0,0,0),(41,23,1,'phongpla game',NULL,'2017-11-29 22:24:17','2017-11-29 22:26:00',0,8000,10791.97,1,0,10),(42,22,1,'phongfpt\'s game',NULL,'2017-11-29 22:57:08','2017-11-29 23:00:00',0,8000,10833.84,2,0,20),(43,22,1,'fpt\'s game 2',NULL,'2017-11-29 23:05:07','2017-11-29 23:07:00',0,8000,10866.26,2,0,20),(44,22,1,'fpt\'s game',NULL,'2017-11-29 23:17:48','2017-11-29 23:25:00',0,8000,10926.98,2,0,20),(45,22,1,'fpt\'s game',NULL,'2017-11-29 23:29:41','2017-11-29 23:31:00',0,8000.09,11024.8,2,0,20),(46,23,1,'pla tạo thử thách 1',NULL,'2017-11-29 23:46:00','2017-11-29 23:48:00',0,8000,11007.24,2,0,20),(47,22,1,'fpt\'12:11',NULL,'2017-11-30 00:09:06','2017-11-30 00:11:00',0,8000,10719.82,2,0,20),(48,22,1,'fpt 12:25',NULL,'2017-11-30 00:24:09','2017-11-30 00:25:00',0,8000,10799.51,2,0,20),(49,22,1,'fpt 12:36',NULL,'2017-11-30 00:34:33','2017-11-30 00:36:00',0,10000,10671.94,2,0,20),(50,22,1,'fpt 12:39',NULL,'2017-11-30 00:37:46','2017-11-30 00:39:00',0,10000,10651.63,2,0,20),(51,22,1,'fpt 12:46',NULL,'2017-11-30 00:44:50','2017-11-30 00:46:00',0,8000,10661.99,2,0,20),(52,22,1,'fpt 12:51',NULL,'2017-11-30 00:50:10','2017-11-30 07:52:00',0,5000,10510.16,2,0,20),(53,4,1,'Công Công game YN',NULL,'2017-11-30 14:30:06','2017-11-30 14:35:00',0,10445,10150.59,2,0,20),(54,27,1,'Viet Tran',NULL,'2017-11-30 15:39:55','2017-11-30 15:45:00',0,10234,10162.02,2,0,20),(55,27,1,'VietTran',NULL,'2017-11-30 15:52:06','2017-11-30 15:55:00',0,10345,10234.67,2,0,20),(56,20,1,'leduycong thu thach yn game',NULL,'2017-11-30 19:37:46','2017-11-30 19:42:00',0,10123,9941.8,2,0,20),(57,29,1,'thien vu dung sai',NULL,'2017-11-30 20:36:04','2017-11-30 20:40:00',0,9876.5,9402.51,3,0,30),(58,29,1,'Thien yes no game',NULL,'2017-11-30 22:51:40','2017-11-30 23:00:00',0,8901.56,9238.48,3,0,30),(59,4,1,'cong cong yn',NULL,'2017-11-30 23:25:26','2017-11-30 23:30:00',0,9789.56,9377.14,2,0,20);
/*!40000 ALTER TABLE `YN_GAMES` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-30 23:58:25
