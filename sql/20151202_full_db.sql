-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2015 at 08:57 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `workbench_db`
--
CREATE DATABASE IF NOT EXISTS `workbench_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `workbench_db`;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--
-- Creation: Oct 19, 2015 at 05:53 AM
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `demo`
--
-- Creation: Nov 25, 2015 at 11:58 AM
--

CREATE TABLE IF NOT EXISTS `demo` (
  `demo_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `ip_adress` varchar(15) NOT NULL,
  PRIMARY KEY (`demo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `demo`
--

INSERT INTO `demo` (`demo_id`, `email`, `password`, `phone`, `ip_adress`) VALUES
(1, 'demo@demo.com', '123', '0642222111', '129.0.0.2'),
(2, 'cak.noris@cak.com', '111', '001', '127.0.0.2'),
(3, 'noris@noris.com', '123445666', '382991122332', '192.168.1.1'),
(4, 'norims@noris.com', '123445667', '382991122332', '192.168.1.2'),
(5, 'kures@noris.com', '123445668', '382991122337', '192.168.1.3'),
(7, 'novis@novis.com', '123445007', '3829555550322', '192.168.1.7'),
(10, 'novis@novis.com', '12344343465', '3829555550322', '192.168.1.15'),
(11, 'novis1@novis.com', '12344343465', '3829555550322', '192.168.1.15'),
(12, 'novis2@novis.com', '12344343465', '3829555550322', '192.168.1.15'),
(13, 'novis45@novis.com', '12344343465', '3829555550322', '192.168.1.15'),
(14, 'novis145@novis.com', '12344343465', '3829555550322', '192.168.1.15'),
(15, 'novis325@novis.com', '12344343465', '3829555550322', '192.168.1.15'),
(16, 'novi325@novis.com', '12344343465', '3829555550322', '192.168.1.15'),
(17, 'novi35@novis.com', '$2y$10$S6tzCYES/4v6DkuIKujY9OKmnZQdQWxgLIHvomiFvPTE6UgvkfFGK', '3829555550322', '192.168.1.15');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--
-- Creation: Oct 19, 2015 at 07:07 AM
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'moderators', 'App servising'),
(3, 'workers', 'Employees'),
(4, 'members', 'Registered users');

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--
-- Creation: Nov 23, 2015 at 10:01 PM
--

CREATE TABLE IF NOT EXISTS `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, '123456', 1, 0, 0, NULL, 20151123);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--
-- Creation: Oct 19, 2015 at 07:07 AM
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--
-- Creation: Nov 28, 2015 at 06:18 PM
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `parent` int(3) NOT NULL,
  `order` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `label`, `description`, `link`, `parent`, `order`) VALUES
(1, 'home', 'main dashboard page', '/menu', 0, 1),
(2, 'todo', 'my todo tasks', '/todo', 0, 2),
(3, 'calendar', 'view calendar', '/calendar', 0, 3),
(4, 'finance', 'menage your funds', '/finance', 0, 4),
(5, 'some child 1', 'dummy child 1', '/dummy1', 2, 1),
(6, 'some child 2', 'dummy child 2', '/dummy2', 2, 2),
(7, 'some grandchild', 'dummy grandchild 1', '/dummy3', 5, 1),
(8, 'some grandcild 2', 'dummy grandchild 2', '/dummy4', 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--
-- Creation: Nov 25, 2015 at 11:58 AM
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(20151128185600);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Oct 19, 2015 at 07:07 AM
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, 'Y3xl9thLOn0MQ/ruq/rQPe', 1268889823, 1448818363, 1, 'Admin', 'istrator', 'ADMIN', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--
-- Creation: Oct 19, 2015 at 07:07 AM
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
