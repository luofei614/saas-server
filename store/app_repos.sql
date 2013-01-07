-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 01 月 07 日 17:52
-- 服务器版本: 5.5.24
-- PHP 版本: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `app_repos`
--

-- --------------------------------------------------------

--
-- 表的结构 `apps`
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
  `access` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `install_times` int(10) unsigned NOT NULL DEFAULT '0',
  `license` char(10) NOT NULL DEFAULT '''GPL''',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `apps`
--

INSERT INTO `apps` (`id`, `name`, `src`, `icon`, `cat`, `description`, `runtime`, `services`, `mem`, `disk`, `cpu`, `version`, `access`, `install_times`, `license`) VALUES
(1, 'wordpress', 'http://wordpress.org', 'http://wordpress.org/icon.png', 'blog', 'wordpress', 'PHP-5.3', 'mysql', 32, 100, 1, '5.2', 0, 0, '''GPL'''),
(2, 'drupal', 'http://drupal.org', 'http://drupal.org/icon.png', 'cms', 'drupal', 'PHP-5.3', 'mysql', 32, 100, 1, '1.0', 0, 0, '''GPL''');

-- --------------------------------------------------------

--
-- 表的结构 `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `opt` char(40) NOT NULL DEFAULT '',
  `val` varchar(4096) NOT NULL DEFAULT '',
  PRIMARY KEY (`opt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `config`
--

INSERT INTO `config` (`opt`, `val`) VALUES
('description', 'a:4:{s:5:"title";s:19:"Demo app repository";s:7:"contact";s:16:"demo@example.com";s:4:"icon";s:55:"http://sae.sina.com.cn/static/image/store/createapp.png";s:7:"src-url";s:29:"http://repos.lajipk.com/apps/";}'),
('repo-ver', '-1');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `password` char(40) NOT NULL,
  `level` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `akey` char(32) NOT NULL,
  `skey` char(40) NOT NULL,
  `telphone` char(15) NOT NULL,
  `company` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `level`, `akey`, `skey`, `telphone`, `company`) VALUES
(1, 'luofei', '123456', 0, 'aaa', 'bbb', '186123456', 'sina');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
