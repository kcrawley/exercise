# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.32-0ubuntu0.12.04.1)
# Database: test
# Generation Time: 2013-11-07 21:16:08 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table campaign_client
# ------------------------------------------------------------

DROP TABLE IF EXISTS `campaign_client`;

CREATE TABLE `campaign_client` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table campaign_client_contact
# ------------------------------------------------------------

DROP TABLE IF EXISTS `campaign_client_contact`;

CREATE TABLE `campaign_client_contact` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_client_id` int(11) unsigned NOT NULL,
  `contact_name` varchar(100) DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`id`),
  KEY `campaign_client_id` (`campaign_client_id`),
  CONSTRAINT `campaign_client_contact_ibfk_1` FOREIGN KEY (`campaign_client_id`) REFERENCES `campaign_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table campaign_project_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `campaign_project_type`;

CREATE TABLE `campaign_project_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_client_id` int(11) unsigned NOT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`id`),
  KEY `campaign_client_id` (`campaign_client_id`),
  CONSTRAINT `campaign_project_type_ibfk_1` FOREIGN KEY (`campaign_client_id`) REFERENCES `campaign_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
