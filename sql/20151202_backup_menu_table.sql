-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 02, 2015 at 04:06 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `workbench_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--
-- Creation: Dec 01, 2015 at 11:57 AM
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `parent` int(3) NOT NULL,
  `order` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `label`, `description`, `link`, `parent`, `order`) VALUES
(1, 'home', 'main page', 'menu', 0, 1),
(2, 'forecast', 'weather forecast', 'forecast', 0, 2),
(3, 'calendar', 'calendar page', 'calendar', 6, 1),
(4, 'todo', 'task page', 'todo', 6, 2),
(5, 'events', 'main events page', 'events', 6, 3),
(6, 'sheduler', 'main shedule page', 'sheduler', 0, 3),
(7, 'finance', 'expance menager', 'finance', 0, 4),
(8, 'expenses', 'expance subpage', 'expences', 7, 1),
(9, 'income', 'income menager', 'income', 7, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
