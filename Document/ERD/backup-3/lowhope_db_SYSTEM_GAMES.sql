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
-- Table structure for table `SYSTEM_GAMES`
--

DROP TABLE IF EXISTS `SYSTEM_GAMES`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SYSTEM_GAMES` (
  `GAME_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `CONTENT` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `START_DATE` datetime NOT NULL,
  `END_DATE` datetime NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `POINT_TO_BET` double NOT NULL,
  `RESULT` double DEFAULT NULL,
  `CUR_TYPE_ID` int(11) NOT NULL,
  PRIMARY KEY (`GAME_ID`),
  KEY `SYSTEM_GAMES_ibfk_1` (`CUR_TYPE_ID`),
  CONSTRAINT `SYSTEM_GAMES_ibfk_1` FOREIGN KEY (`CUR_TYPE_ID`) REFERENCES `CURRENCY_TYPE` (`TYPE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SYSTEM_GAMES`
--

LOCK TABLES `SYSTEM_GAMES` WRITE;
/*!40000 ALTER TABLE `SYSTEM_GAMES` DISABLE KEYS */;
INSERT INTO `SYSTEM_GAMES` (`GAME_ID`, `TITLE`, `CONTENT`, `START_DATE`, `END_DATE`, `ACTIVE`, `POINT_TO_BET`, `RESULT`, `CUR_TYPE_ID`) VALUES (72,'Có ngon vào thử','Giá bitcoin ngày 12-12-2017 vào lúc 00:00:00','2017-12-05 12:40:34','2017-12-07 00:00:00',0,100,12629.81,1),(77,'Có ngon vào thử','Giá bitcoin ngày 14-12-2017 vào lúc 00:00:00','2017-12-07 22:22:02','2017-12-17 00:21:00',0,100,18723.38,1),(80,'Có ngon vào thử','Giá bitcoin ngày 24-12-2017 vào lúc 00:00:00','2017-12-17 00:21:03','2017-12-19 14:30:00',0,100,18836.53,1),(81,'Có ngon vào thử','Giá bitcoin ngày 26-12-2017 vào lúc 00:00:00','2017-12-19 14:30:02','2017-12-19 17:01:00',0,100,18545.67,1),(82,'Có ngon vào thử','Giá bitcoin ngày 26-12-2017 vào lúc 00:00:00','2017-12-19 17:01:02','2017-12-21 18:10:00',0,100,16731.56,1),(83,'Có ngon vào thử','Giá bitcoin ngày 28-12-2017 vào lúc 00:00:00','2017-12-21 18:10:03','2017-12-28 00:00:00',1,100,NULL,1);
/*!40000 ALTER TABLE `SYSTEM_GAMES` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-21 23:11:46
