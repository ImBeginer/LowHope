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
-- Table structure for table `USERS`
--

DROP TABLE IF EXISTS `USERS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `USERS` (
  `USER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ROLE_ID` int(11) DEFAULT NULL,
  `USER_CIF` varchar(50) DEFAULT NULL,
  `USER_NAME` varchar(100) CHARACTER SET utf8 NOT NULL,
  `PASSWORD` varchar(100) DEFAULT NULL,
  `USER_POINT` int(11) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `PHONE_NUMBER` varchar(30) DEFAULT NULL,
  `ADDRESS` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `AVATAR` text,
  `CREATE_DATE` date NOT NULL,
  `ATTENDANCE` tinyint(1) NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  PRIMARY KEY (`USER_ID`),
  KEY `ROLE_ID` (`ROLE_ID`),
  CONSTRAINT `USERS_ibfk_1` FOREIGN KEY (`ROLE_ID`) REFERENCES `ROLE` (`ROLE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `USERS`
--

LOCK TABLES `USERS` WRITE;
/*!40000 ALTER TABLE `USERS` DISABLE KEYS */;
INSERT INTO `USERS` (`USER_ID`, `ROLE_ID`, `USER_CIF`, `USER_NAME`, `PASSWORD`, `USER_POINT`, `EMAIL`, `PHONE_NUMBER`, `ADDRESS`, `AVATAR`, `CREATE_DATE`, `ATTENDANCE`, `ACTIVE`) VALUES (1,3,'114359317688861576124','CongLDSE03929',NULL,4200,'congldse03929@fpt.edu.vn','0986966861','Hải Dương','https://lh3.googleusercontent.com/-_QHUNrtjLbs/AAAAAAAAAAI/AAAAAAAAAh8/mSStBOaGfOs/photo.jpg','2017-11-12',1,1),(3,1,'1098039550331795','hotaru','547aa4bf1e8d815db6e4bdc75d476918',500,'tranhongquan.94@gmail.com','+84962575594','Thanh Miện - Hải Dương','https://scontent.xx.fbcdn.net/v/t1.0-1/p80x80/15726732_916265071842578_2731474273544155584_n.jpg?oh=e513031c58dfa2a1998def147e50a78f&oe=5AD41C6E','2017-11-12',0,1),(4,3,'108396582926044150378','Công Công',NULL,5030,'duycong2509@gmail.com','123123123','Hà Nội','https://lh4.googleusercontent.com/-XV8A1MRfGeY/AAAAAAAAAAI/AAAAAAAAABU/hSrPvIUes0k/photo.jpg','2017-11-12',1,1),(20,3,'1591830150906934','Lê Duy Công',NULL,5400,'congld2509@gmail.com','0986966861','Hai Duong','https://scontent.xx.fbcdn.net/v/t1.0-1/p50x50/17458050_1396503147106303_3059226764174188167_n.jpg?oh=664e29498fe6528d6a7781ae522036ad&oe=5AC98E3D','2017-11-29',1,1),(22,3,'112340433852071088459','phong fpt',NULL,500,'phongnhse03697@fpt.edu.vn','098765432','hoa lac',NULL,'2017-11-29',0,1),(23,3,'111726941461632888843','phong pla',NULL,500,'nguyenphongpla@gmail.com','098765432','hoa lac',NULL,'2017-11-29',0,1),(24,3,'107844689885626102172','thu nguyen',NULL,500,'thunguyencscd@gmail.com','0987654123','hoa lac',NULL,'2017-11-29',0,1),(25,3,NULL,'Unknow','123a123@A',500,'ldc@gmail.com',NULL,NULL,NULL,'2017-11-29',0,1),(26,3,NULL,'aaaaaa','f83e69e4170a786e44e3d32a2479cce9',500,'abc@gmail.com','0987654321','hanhhanhhanh',NULL,'2017-11-29',0,1),(27,3,'100743252540981298526','Việt Trần',NULL,500,'viettase1990@gmail.com','0986966861','Hà Nam','https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg','2017-11-30',0,1),(32,2,'14513215641564','Quản lý 1','547aa4bf1e8d815db6e4bdc75d476918',0,'test1@gmail.com','0962575594','Ha noi - viet nam','https://lh5.googleusercontent.com/-SD49dKJuMz0/AAAAAAAAAAI/AAAAAAAAAEA/Ra7MmYsDMrA/photo.jpg','2017-12-04',0,1),(33,2,'14513215641567','Quản lý 2','547aa4bf1e8d815db6e4bdc75d476918',0,'test2@gmail.com','0962575594','Ha noi - viet nam','https://lh5.googleusercontent.com/-SD49dKJuMz0/AAAAAAAAAAI/AAAAAAAAAEA/Ra7MmYsDMrA/photo.jpg','2017-12-04',0,0),(39,3,'103641299398588211042','Vinh Vạm Vỡ','bb2aac0b7ff288f3d4b040f24d501821',999580,'vinhnguyenvan1995@gmail.com','01659053380','Tân Mai, Hoàng Mai','https://lh4.googleusercontent.com/-kmLfsuRi_hk/AAAAAAAAAAI/AAAAAAAACSo/x5CSDkwYhkM/photo.jpg','2017-12-07',1,1),(40,3,'116563553084733484864','Firefly',NULL,540,'quanthse03733@fpt.edu.vn','0962575594','Hai Duong','https://lh5.googleusercontent.com/-SD49dKJuMz0/AAAAAAAAAAI/AAAAAAAAAEA/Ra7MmYsDMrA/photo.jpg','2017-12-08',1,1),(41,3,NULL,'Unknow','ec686b184e93d9a76213a03ee37c133e',500,'adasd@gmail.com',NULL,NULL,NULL,'2017-12-09',0,1),(42,3,NULL,'Jame Tung','78455acdeb75071ae34ab55ebddae88a',4830,'thanhtung24fpt@gmail.com','0123456789','Phu Ly, Ha Nam','https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg','2017-12-11',0,1),(43,3,'116592023066977586020','Vinh Vui Vẻ',NULL,510,'laonhaovuathoi@gmail.com','01659053380','Tân Mai, Hoàng Mai','https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg','2017-12-11',1,1),(44,3,NULL,'Unknow','123a123@A',500,'tungntse03924@fpt.edu.vn',NULL,NULL,NULL,'2017-12-11',0,1),(46,3,'472491846485624','Golden James',NULL,490,'vinhnguyenudemy@gmail.com','0165984535','American Tho ','https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg','2017-12-12',0,1),(48,3,NULL,'Unknow','123a123@A',500,'unit_test_add_user_1@gmail.com',NULL,NULL,NULL,'2017-12-12',0,1),(49,3,'103576854745902169339','Đom đóm cô đơn',NULL,520,'t1nh4nhv4nth3th0i@gmail.com','0962575594','Hải Dương','https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg','2017-12-16',0,1),(50,3,'106860998062801027230','Vũ Hoàng Thiện',NULL,420,'thienvhse03939@fpt.edu.vn','123456789','32 Liễu Giai, Hà Nội.','https://lh4.googleusercontent.com/-BZ0idIIrUEg/AAAAAAAAAAI/AAAAAAAAAEw/KthbB9YIBbM/photo.jpg','2017-12-21',1,1),(51,3,NULL,'Unknow','eb2fb0d7ecc8f1b0c3783f3fe28d5bde',470,'congld@gmail.com',NULL,NULL,NULL,'2017-12-21',1,1),(52,3,NULL,'test user','eb2fb0d7ecc8f1b0c3783f3fe28d5bde',520,'ldc123@gmail.com','0123456789','Hà Nội Nhé',NULL,'2017-12-21',1,1);
/*!40000 ALTER TABLE `USERS` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-21 23:11:40
