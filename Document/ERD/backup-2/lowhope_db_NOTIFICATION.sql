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
-- Table structure for table `NOTIFICATION`
--

DROP TABLE IF EXISTS `NOTIFICATION`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `NOTIFICATION` (
  `NOTICE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(255) CHARACTER SET utf8 NOT NULL,
  `CONTENT` text CHARACTER SET utf8 NOT NULL,
  `CREATE_DATE` datetime DEFAULT NULL,
  PRIMARY KEY (`NOTICE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `NOTIFICATION`
--

LOCK TABLES `NOTIFICATION` WRITE;
/*!40000 ALTER TABLE `NOTIFICATION` DISABLE KEYS */;
INSERT INTO `NOTIFICATION` (`NOTICE_ID`, `TITLE`, `CONTENT`, `CREATE_DATE`) VALUES (1,'Chúc mừng Quán Quân','Chúc mừng bạn! Bạn đã là người chơi xuất sắc nhất trong thể loại game truyền thống! Bạn là người dự đoán đúng (hoặc gần đúng) giá nhất!Phần thưởng đã được cập nhật vào trong tài khoản của bạn!','2017-12-11 21:10:33'),(2,'Chúc mừng Á Quân','Chúc mừng bạn! Bạn đã đạt vị trí thứ hai trong thể loại game truyền thống! Bạn là một trong ba người dự đoán đúng (hoặc gần đúng) giá và nhanh nhất! Phần thưởng đã được cập nhật vào trong tài khoản của bạn!','2017-11-21 15:36:12'),(3,'Chúc mừng Quý Quân','Chúc mừng bạn! Bạn đã đạt vị trí thứ ba trong thể loại game truyền thống! Bạn là một trong ba người dự đoán đúng (hoặc gần đúng) giá và nhanh nhất! Phần thưởng đã được cập nhật vào trong tài khoản của bạn!','2017-11-21 15:36:12'),(4,'GAME HỆ THỐNG','Hệ thống xin thông báo, Game cũ đã kết thúc! Game mới đã ở. Nhanh tay tham gia để nhận nhiều phần quà hấp dẫn.cs','2017-12-08 00:00:00'),(5,'CHIẾN THẮNG','Chúc mừng bạn đã chiến thằng trong REPLACE.','2017-11-24 12:20:17'),(6,'THUA CUỘC','Chúng tôi rất tiếc bạn đã không phải là người thằng cuộc trong REPLACE.','2017-11-24 12:21:02'),(7,'KẾT THÚC GAME','ENDGAME bạn tạo đã kết thúc.','2017-11-24 12:21:40'),(10,'DS','A','2017-12-07 23:42:43');
/*!40000 ALTER TABLE `NOTIFICATION` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-11 21:20:25
