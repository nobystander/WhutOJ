-- MySQL dump 10.13  Distrib 5.5.47, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: oj
-- ------------------------------------------------------
-- Server version	5.5.47-0ubuntu0.14.04.1

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
-- Table structure for table `oj_language`
--

DROP TABLE IF EXISTS `oj_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oj_language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(20) NOT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oj_language`
--

LOCK TABLES `oj_language` WRITE;
/*!40000 ALTER TABLE `oj_language` DISABLE KEYS */;
INSERT INTO `oj_language` VALUES (1,'c'),(2,'cpp'),(3,'java');
/*!40000 ALTER TABLE `oj_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oj_problem`
--

DROP TABLE IF EXISTS `oj_problem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oj_problem` (
  `problem_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `source` varchar(64) NOT NULL,
  `add_time` date NOT NULL,
  `time_limit` int(11) NOT NULL,
  `memory_limit` int(11) NOT NULL,
  `special_judge` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`problem_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1003 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oj_problem`
--

LOCK TABLES `oj_problem` WRITE;
/*!40000 ALTER TABLE `oj_problem` DISABLE KEYS */;
INSERT INTO `oj_problem` VALUES (1000,'A+B','--','2016-03-19',1,64,0),(1001,'EASY PROBLEM 1','--','2016-03-19',1,64,0),(1002,'EASY PROBLEM 2','--','2016-03-19',2,64,0);
/*!40000 ALTER TABLE `oj_problem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oj_result`
--

DROP TABLE IF EXISTS `oj_result`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oj_result` (
  `result_id` int(11) NOT NULL,
  `result` varchar(20) NOT NULL,
  PRIMARY KEY (`result_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oj_result`
--

LOCK TABLES `oj_result` WRITE;
/*!40000 ALTER TABLE `oj_result` DISABLE KEYS */;
INSERT INTO `oj_result` VALUES (-1,'System Error'),(0,'Pending'),(1,'Running & judging'),(2,'Compile Error'),(3,'Accepted'),(4,'Runtime Error'),(5,'Wrong Answer'),(6,'Time Limit Exceeded'),(7,'Memory Limit Exceede'),(8,'Output Limit Exceede'),(9,'Presentation Error');
/*!40000 ALTER TABLE `oj_result` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oj_submit`
--

DROP TABLE IF EXISTS `oj_submit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oj_submit` (
  `run_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `result` int(11) NOT NULL DEFAULT '0',
  `language` int(11) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `memory` int(11) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `submit_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`run_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oj_submit`
--

LOCK TABLES `oj_submit` WRITE;
/*!40000 ALTER TABLE `oj_submit` DISABLE KEYS */;
INSERT INTO `oj_submit` VALUES (1,1,1002,2,2,0,0,621,1458361315),(2,1,1002,2,2,0,0,621,1458361884),(3,1,1002,2,2,0,0,621,1458361932),(4,1,1002,2,2,0,0,621,1458361944),(5,1,1002,3,2,1276,11424,1709,1458362368),(6,1,1002,6,2,910,10896,1709,1458369663),(7,1,1002,3,2,1223,11424,1709,1458370145);
/*!40000 ALTER TABLE `oj_submit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oj_user`
--

DROP TABLE IF EXISTS `oj_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oj_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(64) NOT NULL,
  `school` varchar(64) NOT NULL,
  `hashstr` varchar(64) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oj_user`
--

LOCK TABLES `oj_user` WRITE;
/*!40000 ALTER TABLE `oj_user` DISABLE KEYS */;
INSERT INTO `oj_user` VALUES (1,'Wumpus','06b3e18deab1e5e3365853925f7559ede5838421','ss@126.com','WWW','a739934d72c499735838a56a38229f10ffa6a12b',0,'asd&#229;&#149;&#138;&#229;&#155;&#155;&#229;&#164;&#167;&#229;&#178;&#129;');
/*!40000 ALTER TABLE `oj_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-03-19 15:41:10
