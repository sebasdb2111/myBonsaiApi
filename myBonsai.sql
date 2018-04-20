CREATE DATABASE  IF NOT EXISTS `myBonsai` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `myBonsai`;
-- MySQL dump 10.15  Distrib 10.0.34-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: myBonsai
-- ------------------------------------------------------
-- Server version	10.0.34-MariaDB-0ubuntu0.16.04.1

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
-- Table structure for table `bonsai`
--

DROP TABLE IF EXISTS `bonsai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bonsai` (
  `idBonsai` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) DEFAULT NULL,
  `riego` tinyint(4) NOT NULL,
  `abono` tinyint(4) NOT NULL,
  `transplante` tinyint(4) NOT NULL,
  `pulverizar` tinyint(4) NOT NULL,
  `createdAt` datetime NOT NULL,
  `imgPredefinida` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`idBonsai`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bonsai`
--

--
-- Table structure for table `log_cuidados`
--

DROP TABLE IF EXISTS `log_cuidados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_cuidados` (
  `idLogCuidados` int(11) NOT NULL AUTO_INCREMENT,
  `createdAt` datetime NOT NULL,
  `cuidado` varchar(100) NOT NULL,
  `idUserBonsai` int(11) NOT NULL,
  PRIMARY KEY (`idLogCuidados`,`idUserBonsai`),
  KEY `fk_log_cuidados_user_bonsai1_idx` (`idUserBonsai`),
  CONSTRAINT `fk_log_cuidados_user_bonsai1` FOREIGN KEY (`idUserBonsai`) REFERENCES `user_bonsai` (`idUserBonsai`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_cuidados`
--

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellidos` varchar(150) DEFAULT NULL,
  `fechaNacimiento` datetime DEFAULT NULL,
  `imgUser` varchar(250) DEFAULT NULL,
  `creacion` datetime NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

--
-- Table structure for table `user_bonsai`
--

DROP TABLE IF EXISTS `user_bonsai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_bonsai` (
  `idUserBonsai` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `idBonsai` int(11) NOT NULL,
  `alias` varchar(45) DEFAULT NULL,
  `edad` varchar(45) DEFAULT NULL,
  `fechaAdquisicion` datetime DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `imgBonsai` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`idUserBonsai`,`idUser`,`idBonsai`),
  KEY `fk_user_has_bonsai_bonsai1_idx` (`idBonsai`),
  KEY `fk_user_has_bonsai_user_idx` (`idUser`),
  CONSTRAINT `fk_user_has_bonsai_bonsai1` FOREIGN KEY (`idBonsai`) REFERENCES `bonsai` (`idBonsai`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_bonsai_user` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_bonsai`
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-18  8:34:40
