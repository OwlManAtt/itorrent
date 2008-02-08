-- MySQL dump 10.10
--
-- Host: localhost    Database: itorrent
-- ------------------------------------------------------
-- Server version	5.0.22-Debian_0ubuntu6.06.6-log

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
-- Table structure for table `jump_page`
--

DROP TABLE IF EXISTS `jump_page`;
CREATE TABLE `jump_page` (
  `jump_page_id` int(10) unsigned NOT NULL auto_increment,
  `page_title` varchar(50) NOT NULL default '',
  `page_html_title` varchar(255) NOT NULL default '',
  `page_slug` varchar(25) NOT NULL default '',
  `access_level` enum('restricted','user','public') NOT NULL default 'user',
  `restricted_permission_api_name` varchar(35) NOT NULL,
  `php_script` varchar(100) NOT NULL default '',
  `active` enum('Y','N') NOT NULL default 'Y',
  PRIMARY KEY  (`jump_page_id`),
  UNIQUE KEY `page_slug` (`page_slug`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `rss_feed`
--

DROP TABLE IF EXISTS `rss_feed`;
CREATE TABLE `rss_feed` (
  `rss_feed_id` int(11) NOT NULL auto_increment,
  `feed_title` varchar(20) NOT NULL,
  `feed_url` text NOT NULL,
  `default` enum('N','Y') NOT NULL default 'N',
  `fetch_metadata` enum('Y','N') NOT NULL default 'N',
  `metadata_expire_seconds` int(11) NOT NULL default '0',
  PRIMARY KEY  (`rss_feed_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `rss_highlight`
--

DROP TABLE IF EXISTS `rss_highlight`;
CREATE TABLE `rss_highlight` (
  `rss_highlight_id` int(11) NOT NULL auto_increment,
  `highlight_preg` text NOT NULL,
  `highlight_type` enum('important','minimize') NOT NULL,
  PRIMARY KEY  (`rss_highlight_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `staff_group`
--

DROP TABLE IF EXISTS `staff_group`;
CREATE TABLE `staff_group` (
  `staff_group_id` int(11) NOT NULL auto_increment,
  `group_name` varchar(50) NOT NULL,
  `group_descr` text NOT NULL,
  `order_by` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`staff_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `staff_group_staff_permission`
--

DROP TABLE IF EXISTS `staff_group_staff_permission`;
CREATE TABLE `staff_group_staff_permission` (
  `staff_group_staff_permission` int(11) NOT NULL auto_increment,
  `staff_group_id` int(11) NOT NULL,
  `staff_permission_id` int(11) NOT NULL,
  PRIMARY KEY  (`staff_group_staff_permission`),
  UNIQUE KEY `staff_group_id` (`staff_group_id`,`staff_permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `staff_permission`
--

DROP TABLE IF EXISTS `staff_permission`;
CREATE TABLE `staff_permission` (
  `staff_permission_id` int(11) NOT NULL auto_increment,
  `api_name` varchar(50) NOT NULL,
  `permission_name` varchar(50) NOT NULL,
  PRIMARY KEY  (`staff_permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `torrent_meta`
--

DROP TABLE IF EXISTS `torrent_meta`;
CREATE TABLE `torrent_meta` (
  `torrent_meta_id` int(10) unsigned NOT NULL auto_increment,
  `rss_feed_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `infohash` char(40) NOT NULL,
  `name` text NOT NULL,
  `size` bigint(20) NOT NULL,
  `files` int(11) NOT NULL,
  `cached_datetime` datetime NOT NULL,
  PRIMARY KEY  (`torrent_meta_id`),
  KEY `rss_feed_id` (`rss_feed_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL auto_increment,
  `user_name` varchar(25) NOT NULL,
  `password_hash` char(32) default NULL,
  `password_hash_salt` char(32) NOT NULL,
  `current_salt` char(32) NOT NULL,
  `current_salt_expiration` datetime NOT NULL,
  `last_ip_addr` varchar(16) default NULL,
  `last_activity` datetime default NULL,
  `email` text NOT NULL,
  `datetime_created` datetime default NULL,
  `password_reset_requested` datetime NOT NULL,
  `password_reset_confirm` varchar(32) NOT NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `user_staff_group`
--

DROP TABLE IF EXISTS `user_staff_group`;
CREATE TABLE `user_staff_group` (
  `user_staff_group_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `staff_group_id` int(11) NOT NULL,
  PRIMARY KEY  (`user_staff_group_id`),
  UNIQUE KEY `user_id` (`user_id`,`staff_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

