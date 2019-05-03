/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.24 : Database - zentogel_newedtion
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`zentogel_newedtion` /*!40100 DEFAULT CHARACTER SET utf8 */;

/*Table structure for table `tbl_has_permissions` */

DROP TABLE IF EXISTS `tbl_has_permissions`;

CREATE TABLE `tbl_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `rdd_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `rdd_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `tbl_permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_has_permissions` */

/*Table structure for table `tbl_has_roles` */

DROP TABLE IF EXISTS `tbl_has_roles`;

CREATE TABLE `tbl_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `rdd_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `rdd_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_has_roles` */

insert  into `tbl_has_roles`(`role_id`,`model_type`,`model_id`) values (1,'App\\Models\\BackEnd\\User',1),(1,'App\\Models\\BackEnd\\User',6),(1,'App\\Models\\BackEnd\\User',12),(1,'App\\Models\\BackEnd\\User',14),(1,'App\\Models\\BackEnd\\User',17),(1,'App\\Models\\BackEnd\\User',18),(1,'App\\Models\\BackEnd\\User',19),(2,'App\\Models\\BackEnd\\User',20),(1,'App\\Models\\BackEnd\\User',21);

/*Table structure for table `tbl_migrations` */

DROP TABLE IF EXISTS `tbl_migrations`;

CREATE TABLE `tbl_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_migrations` */

insert  into `tbl_migrations`(`id`,`migration`,`batch`) values (16,'2014_10_12_000000_create_users_table',1),(17,'2014_10_12_100000_create_password_resets_table',1),(18,'2018_10_15_034537_create_permission_tables',1);

/*Table structure for table `tbl_password_resets` */

DROP TABLE IF EXISTS `tbl_password_resets`;

CREATE TABLE `tbl_password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `rdd_password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_password_resets` */

/*Table structure for table `tbl_permissions` */

DROP TABLE IF EXISTS `tbl_permissions`;

CREATE TABLE `tbl_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_permissions` */

insert  into `tbl_permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (1,'view_users','web','2018-10-15 04:28:32','2018-10-15 04:28:32'),(2,'add_users','web','2018-10-15 04:28:32','2018-10-15 04:28:32'),(3,'edit_users','web','2018-10-15 04:28:32','2018-10-15 04:28:32'),(4,'delete_users','web','2018-10-15 04:28:32','2018-10-15 04:28:32'),(5,'view_roles','web','2018-10-15 04:28:32','2018-10-15 04:28:32'),(6,'add_roles','web','2018-10-15 04:28:32','2018-10-15 04:28:32'),(7,'edit_roles','web','2018-10-15 04:28:32','2018-10-15 04:28:32'),(8,'delete_roles','web','2018-10-15 04:28:32','2018-10-15 04:28:32'),(9,'view_posts','web','2018-10-15 04:28:32','2018-10-15 04:28:32'),(10,'add_posts','web','2018-10-15 04:28:32','2018-10-15 04:28:32'),(11,'edit_posts','web','2018-10-15 04:28:32','2018-10-15 04:28:32'),(12,'delete_posts','web','2018-10-15 04:28:32','2018-10-15 04:28:32');

/*Table structure for table `tbl_role_has_permissions` */

DROP TABLE IF EXISTS `tbl_role_has_permissions`;

CREATE TABLE `tbl_role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `rdd_role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `rdd_role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `tbl_permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rdd_role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_role_has_permissions` */

insert  into `tbl_role_has_permissions`(`permission_id`,`role_id`) values (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1);

/*Table structure for table `tbl_roles` */

DROP TABLE IF EXISTS `tbl_roles`;

CREATE TABLE `tbl_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `menu_access` mediumtext,
  `status` smallint(6) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_roles` */

insert  into `tbl_roles`(`id`,`name`,`guard_name`,`menu_access`,`status`,`created_at`,`updated_at`) values (1,'Admin','web','1,120,121,122,123,124,125,126,127,128,129,131,133,134,135,136,137,138,139,140,141,143,144,145,146',1,'2018-10-15 04:28:42','2019-03-18 07:29:37'),(2,'User','web','1,97,98,100',1,'2018-10-15 04:28:43','2019-03-19 04:50:38'),(4,'Account','web','76,58,59,71,63,75,57,70',0,'2018-10-18 06:04:46','2018-10-18 06:04:46'),(5,'testing','web','101',1,'2018-10-31 08:04:30','2018-10-31 08:04:30');

/*Table structure for table `tbl_user_menu` */

DROP TABLE IF EXISTS `tbl_user_menu`;

CREATE TABLE `tbl_user_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `ordering` int(10) DEFAULT NULL,
  `url` varchar(100) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `state` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=147 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_user_menu` */

insert  into `tbl_user_menu`(`id`,`name`,`parent_id`,`ordering`,`url`,`class_name`,`state`) values (1,'dashboard',0,1,'/dashboard','flaticon-line-graph',1),(139,'dynamicpassword',132,7,'#','',1),(138,'messagetemplate',132,6,'#','',1),(137,'setting',132,5,'#','',1),(136,'transactionlimitation',132,4,'#','',1),(135,'bonusreferalssystem',132,3,'#','',1),(134,'sitelock',132,2,'#','',1),(133,'gamesetting',132,1,'#','',1),(131,'4D',130,1,'/#','',1),(132,'systemsetting',0,4,'#','flaticon-settings-1',1),(130,'games',0,3,'/#','flaticon-imac',1),(129,'bankaccount',119,10,'#','',1),(128,'bank',119,9,'#','',1),(127,'customerservice',119,8,'#','',1),(126,'notification',119,7,'#','',1),(125,'software',119,6,'#','',1),(124,'slideshow',119,5,'#','',1),(123,'dreambook',119,4,'#','',1),(122,'post',119,3,'#','',1),(121,'product',119,2,'#','',1),(120,'category',119,1,'#','',1),(119,'catalog',0,2,'/#','flaticon-layer',1),(140,'ipblacklist',132,8,'#','',1),(141,'ipfiter',132,9,'#','',1),(142,'useraccount',0,5,'#','flaticon-users',1),(143,'rolepermission',142,1,'#','',1),(144,'rolegroup',142,2,'/rolegroup','',1),(145,'user',142,3,'/useraccount','',1),(146,'userlog',142,4,'#','',1);

/*Table structure for table `tbl_users` */

DROP TABLE IF EXISTS `tbl_users`;

CREATE TABLE `tbl_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rdd_users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values (21,'kem chanroeun','kemchanroeun@yahoo.com',NULL,'$2y$10$SsIqEqrh.qG/HXz6ekmnleANKeyoOeEF/PUy7uJdXJhqcI1.i19BK',NULL,'2019-05-02 04:18:14','2019-05-02 04:18:14');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
