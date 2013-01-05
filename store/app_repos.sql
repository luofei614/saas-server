-- phpMyAdmin SQL Dump
-- version 3.5.0
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2013 at 12:36 PM
-- Server version: 5.5.28-0ubuntu0.12.10.2
-- PHP Version: 5.4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `app_repos`
--

-- --------------------------------------------------------

--
-- Table structure for table `apps`
--

CREATE TABLE IF NOT EXISTS `apps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `src` varchar(150) NOT NULL DEFAULT '' COMMENT 'URL of the app package',
  `icon` varchar(100) NOT NULL DEFAULT '' COMMENT 'URL of the app icon',
  `cat` varchar(80) NOT NULL DEFAULT '',
  `description` varchar(2048) NOT NULL DEFAULT '',
  `runtime` enum('PHP-5.3','JAVA') NOT NULL DEFAULT 'PHP-5.3',
  `services` varchar(50) NOT NULL DEFAULT '',
  `mem` int(10) unsigned NOT NULL DEFAULT '32' COMMENT 'Minimum memory needed to run this app. In MB.',
  `disk` int(10) unsigned NOT NULL DEFAULT '100' COMMENT 'Minimum disk space needed to run this app. In MB.',
  `cpu` int(11) NOT NULL DEFAULT '1',
  `version` char(15) NOT NULL,
  `access` enum('PUBLIC','PRIVATE') NOT NULL DEFAULT 'PUBLIC',
  `install_times` int(10) unsigned NOT NULL DEFAULT '0',
  `liscense` char(10) NOT NULL DEFAULT '''GPL''',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `opt` char(40) NOT NULL DEFAULT '',
  `val` varchar(4096) NOT NULL DEFAULT '',
  PRIMARY KEY (`opt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`opt`, `val`) VALUES
('description', 'a:4:{s:5:"title";s:19:"Demo app repository";s:7:"contact";s:16:"demo@example.com";s:4:"icon";s:55:"http://sae.sina.com.cn/static/image/store/createapp.png";s:7:"src-url";s:29:"http://repos.lajipk.com/apps/";}');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `password` char(40) NOT NULL,
  `akey` char(32) NOT NULL,
  `skey` char(40) NOT NULL,
  `telphone` char(15) NOT NULL,
  `company` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
