-- MySQL dump 10.10
--
-- Host: localhost    Database: itorrent
-- ------------------------------------------------------
-- Server version	5.0.22-Debian_0ubuntu6.06.3-log

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
-- Dumping data for table `jump_page`
--


/*!40000 ALTER TABLE `jump_page` DISABLE KEYS */;
LOCK TABLES `jump_page` WRITE;
INSERT INTO `jump_page` (`jump_page_id`, `page_title`, `page_html_title`, `page_slug`, `access_level`, `restricted_permission_api_name`, `php_script`, `active`) VALUES (1,'Torrents','Torrents','torrents','user','','torrents/list.php','Y'),(2,'Authenticate','Authenticate','login','public','','user/login.php','Y'),(3,'Reset Password','Reset Password','reset-password','public','','user/forgot_password.php','Y'),(4,'Logout','Logout','logoff','public','','user/logout.php','Y'),(5,'Create User','Create User','create-user','restricted','manage-users','user/create.php','Y'),(6,'Start/Stop Torrent','Start/Stop Torrent','toggle-status','restricted','manage-torrents','torrents/toggle_status.php','Y'),(7,'Remove Torrent','Remove Torrent','remove-torrent','restricted','manage-torrents','torrents/remove.php','Y'),(8,'Stop All Torrents','Stop All Torrents','stop-all-torrents','restricted','manage-torrents','torrents/stop_all.php','Y'),(9,'rTorrent Settings','rTorrent Settings','client-settings','restricted','set-rate-limits','settings/configure.php','Y');
UNLOCK TABLES;
/*!40000 ALTER TABLE `jump_page` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

