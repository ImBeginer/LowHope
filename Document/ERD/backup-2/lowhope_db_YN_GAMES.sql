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
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `YN_GAMES`
--

LOCK TABLES `YN_GAMES` WRITE;
/*!40000 ALTER TABLE `YN_GAMES` DISABLE KEYS */;
INSERT INTO `YN_GAMES` (`GAME_ID`, `OWNER_ID`, `CUR_TYPE_ID`, `TITLE`, `CONTENT`, `START_DATE`, `END_DATE`, `POINT_TO_BET`, `PRICE_BET`, `RESULT`, `PLAYER_COUNT`, `ACTIVE`, `TOTAL_AMOUNT`) VALUES (71,4,1,'test game',NULL,'2017-12-05 22:58:35','2017-12-05 23:20:00',0,11345.56,11707.7,1,0,10),(72,1,1,'Chơi game vui vẻ cùng CongLDSE03929',NULL,'2017-12-06 12:10:37','2017-12-06 16:30:00',0,11345.45,12566.84,1,0,10),(73,4,1,'Bitcoin ngày 6/12/2017',NULL,'2017-12-06 12:12:26','2017-12-06 16:45:00',0,11654.78,12540.64,1,0,10),(74,20,1,'Làm 1 game góp vui',NULL,'2017-12-06 12:15:58','2017-12-06 17:10:00',0,11567.78,12585.8,2,0,20),(75,1,1,'Nhanh tay kiếm point nào',NULL,'2017-12-06 12:20:08','2017-12-06 16:35:00',0,11456.45,12574.91,0,0,0),(76,20,1,'Xem ai giỏi nào',NULL,'2017-12-06 12:22:11','2017-12-06 16:45:00',0,1123.49,12540.64,0,0,0),(77,40,1,'xịt pẹ vào đây bố mày chấp cả server',NULL,'2017-12-08 13:58:34','2017-12-08 14:00:00',0,11568.76,15983.01,0,0,0),(78,22,1,'game\'s fpt',NULL,'2017-12-09 03:33:51','2017-12-09 03:35:00',0,10000,15246.42,1,0,10),(79,23,1,'pla\'game',NULL,'2017-12-09 04:03:53','2017-12-09 04:06:00',0,15000,15226.32,1,0,10),(80,4,1,'Unitest_Tạo game Yes/No',NULL,'2017-12-25 23:20:00','2017-12-19 22:58:35',0,16000,NULL,0,1,0),(83,39,1,'ádádasd',NULL,'2017-12-11 19:35:06','2017-12-12 02:22:00',0,1,NULL,0,1,0);
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

-- Dump completed on 2017-12-11 21:20:50
