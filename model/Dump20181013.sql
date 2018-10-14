-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: plataforma
-- ------------------------------------------------------
-- Server version	5.7.23-0ubuntu0.16.04.1

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
-- Table structure for table `plataformafuncionalidade`
--

DROP TABLE IF EXISTS `plataformafuncionalidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plataformafuncionalidade` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plataformafuncionalidade`
--

LOCK TABLES `plataformafuncionalidade` WRITE;
/*!40000 ALTER TABLE `plataformafuncionalidade` DISABLE KEYS */;
INSERT INTO `plataformafuncionalidade` VALUES (1,'Usuario','A'),(2,'Fical','A'),(3,'Projeto','A');
/*!40000 ALTER TABLE `plataformafuncionalidade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plataformaperfilusuario`
--

DROP TABLE IF EXISTS `plataformaperfilusuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plataformaperfilusuario` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plataformaperfilusuario`
--

LOCK TABLES `plataformaperfilusuario` WRITE;
/*!40000 ALTER TABLE `plataformaperfilusuario` DISABLE KEYS */;
INSERT INTO `plataformaperfilusuario` VALUES (1,'Admin','A'),(2,'BPO','A'),(3,'Projeto','A'),(4,'BPO e Projeto','A');
/*!40000 ALTER TABLE `plataformaperfilusuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plataformapermissao`
--

DROP TABLE IF EXISTS `plataformapermissao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plataformapermissao` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_perfilusuario` int(10) NOT NULL,
  `id_funcionalidade` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_plataformapermissao_1_idx` (`id_perfilusuario`),
  KEY `fk_plataformapermissao_2_idx` (`id_funcionalidade`),
  CONSTRAINT `fk_plataformapermissao_1` FOREIGN KEY (`id_perfilusuario`) REFERENCES `plataformaperfilusuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_plataformapermissao_2` FOREIGN KEY (`id_funcionalidade`) REFERENCES `plataformafuncionalidade` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plataformapermissao`
--

LOCK TABLES `plataformapermissao` WRITE;
/*!40000 ALTER TABLE `plataformapermissao` DISABLE KEYS */;
INSERT INTO `plataformapermissao` VALUES (1,1,1),(2,1,2),(3,1,3),(4,2,2),(5,3,3),(6,4,2),(7,4,3);
/*!40000 ALTER TABLE `plataformapermissao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plataformausuario`
--

DROP TABLE IF EXISTS `plataformausuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plataformausuario` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_perfilusuario` int(10) NOT NULL,
  `id_responsabilidade` int(10) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `reset_senha` varchar(1) NOT NULL DEFAULT 'N',
  `status` varchar(1) NOT NULL DEFAULT 'A',
  `usuario` varchar(255) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `data_alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_plataformausuario_1_idx` (`id_perfilusuario`),
  CONSTRAINT `fk_plataformausuario_1` FOREIGN KEY (`id_perfilusuario`) REFERENCES `plataformaperfilusuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plataformausuario`
--

LOCK TABLES `plataformausuario` WRITE;
/*!40000 ALTER TABLE `plataformausuario` DISABLE KEYS */;
INSERT INTO `plataformausuario` VALUES (19,'Admin','admin@platform.com',1,10,'admin','N','A','Admin@hotmail.com','2018-10-10 00:00:00','2018-10-10 00:00:00');
/*!40000 ALTER TABLE `plataformausuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-13 15:56:33
