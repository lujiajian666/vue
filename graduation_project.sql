-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: localhost    Database: graduation_project
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.16.04.1

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
-- Current Database: `graduation_project`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `graduation_project` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `graduation_project`;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `content` text,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`article_id`),
  KEY `type` (`type`),
  CONSTRAINT `article_ibfk_1` FOREIGN KEY (`type`) REFERENCES `article_type` (`article_type_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` VALUES (2,'热点服务',1,'热点服务热点服务12',1),(4,'今日关注',3,'今日关注今日光柱',2),(7,'今日关注2   ',1,'今日关注2今日关注2   今日关注2   ',2),(9,'阿道夫',1,'俺的沙发的沙发是的发送到',6),(10,'水电费',1,'阿斯顿发送到发送到阿萨德发',2);
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_type`
--

DROP TABLE IF EXISTS `article_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_type` (
  `article_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`article_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_type`
--

LOCK TABLES `article_type` WRITE;
/*!40000 ALTER TABLE `article_type` DISABLE KEYS */;
INSERT INTO `article_type` VALUES (1,'热点服务'),(2,'今日关注'),(3,'活动新闻'),(4,'常见问题'),(5,'新手指南'),(6,'本站声明'),(7,'关于我们');
/*!40000 ALTER TABLE `article_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `authority_item`
--

DROP TABLE IF EXISTS `authority_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authority_item` (
  `controller` varchar(100) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `awaken` tinyint(4) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authority_item`
--

LOCK TABLES `authority_item` WRITE;
/*!40000 ALTER TABLE `authority_item` DISABLE KEYS */;
INSERT INTO `authority_item` VALUES ('Article','getArticle',NULL,0,'文章管理-查看'),('Article','addArticle',NULL,1,'文章管理-添加'),('Article','deleteArticle',NULL,2,'文章管理-删除'),('Article','editArticle',NULL,3,'文章管理-编辑'),('Background','addEmployee',NULL,4,'人事管理-添加'),('Background','getEmployee',NULL,5,'人事管理-查看'),('Background','deleteEmployeeById',NULL,6,'人事管理-删除'),('Background','editEmployee',NULL,7,'人事管理-编辑'),('Authority','getAuthority',NULL,8,'权限管理-基本权限查看'),('Authority','saveAuthority',NULL,9,'权限管理-基本权限修改'),('Authority','getRole',NULL,10,'权限管理-角色管理查看'),('Authority','addRole',NULL,11,'权限管理-角色管理添加'),('Authority','deleteRole',NULL,12,'权限管理-角色管理删除'),('Authority','editRole',NULL,13,'权限管理-角色管理配置'),('Vacation','applyVerify',NULL,14,'休假管理-休假申请审核'),('Department','addDepartment',NULL,15,'添加部门'),('Department','editDepartment',NULL,16,'修改部门'),('Department','deleteDepartment',NULL,17,'删除部门'),('Department','addJobTitle',NULL,18,'添加职务'),('Department','editJobTitle',NULL,19,'修改职务'),('Department','deleteJobTitle',NULL,20,'删除职位');
/*!40000 ALTER TABLE `authority_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'研发部'),(2,'后勤部'),(3,'行政部'),(4,'人事部');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `head_img` varchar(80) DEFAULT NULL,
  `time` int(11) DEFAULT '0',
  `department_id` int(11) DEFAULT NULL,
  `username` varchar(64) DEFAULT NULL,
  `password` varchar(64) NOT NULL DEFAULT 'admin',
  `role` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `username_2` (`username`),
  UNIQUE KEY `username_3` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES (11,'陆家键1',1,'',1519454329,1,'54329','admin',10),(12,'陆家键22',1,'',1520078942,1,'陆家键22','admin',7),(13,'何佩瑜1',1,'',1520078970,2,'何佩瑜1','admin',6),(14,'黄子豪1',1,'',1520078995,3,'78995','admin',0),(15,'莫晚晴',1,'',1520079131,2,'莫晚晴','admin',6),(16,'刘锡明',1,'',1520079144,3,'79144','admin',0),(17,'刘玉栋',1,'',1520079160,2,'79160','admin',6);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_title`
--

DROP TABLE IF EXISTS `job_title`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `salary` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deparment_job_title` (`department_id`),
  CONSTRAINT `deparment_job_title` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_title`
--

LOCK TABLES `job_title` WRITE;
/*!40000 ALTER TABLE `job_title` DISABLE KEYS */;
INSERT INTO `job_title` VALUES (1,'高级软件设计师',10000,1);
/*!40000 ALTER TABLE `job_title` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `detail` varchar(200) DEFAULT NULL,
  `deadline` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_employee`
--

DROP TABLE IF EXISTS `message_employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message_employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) DEFAULT NULL,
  `username` varchar(64) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_employee`
--

LOCK TABLES `message_employee` WRITE;
/*!40000 ALTER TABLE `message_employee` DISABLE KEYS */;
/*!40000 ALTER TABLE `message_employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `name` varchar(100) DEFAULT NULL,
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `detail` varchar(100) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES ('超级管理员',6,'123'),('垃圾管理员',10,'没那么厉害的管理员');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_item`
--

DROP TABLE IF EXISTS `role_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `authority_item_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_item`
--

LOCK TABLES `role_item` WRITE;
/*!40000 ALTER TABLE `role_item` DISABLE KEYS */;
INSERT INTO `role_item` VALUES (6,1,2),(7,1,13),(10,4,0),(28,10,0),(29,6,0),(30,6,1),(31,6,2),(32,6,3),(33,6,4),(34,6,5),(35,6,6),(36,6,7),(37,6,8),(38,6,9),(39,6,10),(40,6,11),(41,6,12),(42,6,13),(43,6,14);
/*!40000 ALTER TABLE `role_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vacation`
--

DROP TABLE IF EXISTS `vacation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vacation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `begin_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `status` varchar(1) DEFAULT '0',
  `username` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vacation`
--

LOCK TABLES `vacation` WRITE;
/*!40000 ALTER TABLE `vacation` DISABLE KEYS */;
INSERT INTO `vacation` VALUES (3,1517414400,1517587200,1518040039,'阿斯蒂芬','1','lujiajian'),(4,1517587200,1520092800,1518945203,'回家生孩子','2','lujiajian'),(5,1521129600,1523116800,1520134898,'阿萨德法师打发第三','2',''),(6,1521734400,1521820800,1520136061,'阿斯顿发生的发生','0','54329');
/*!40000 ALTER TABLE `vacation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workattendance`
--

DROP TABLE IF EXISTS `workattendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workattendance` (
  `begin_work` int(11) NOT NULL,
  `end_work` int(11) DEFAULT NULL,
  `today_time` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workattendance`
--

LOCK TABLES `workattendance` WRITE;
/*!40000 ALTER TABLE `workattendance` DISABLE KEYS */;
INSERT INTO `workattendance` VALUES (1519521968,1519529599,1519488000,4,'54329'),(1519610288,NULL,1519574400,5,'54329'),(1519801283,1519801287,1519747200,6,'54329'),(1520338925,1520338929,1520265600,7,'79160');
/*!40000 ALTER TABLE `workattendance` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-14  2:12:15
