/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50516
 Source Host           : localhost
 Source Database       : webroute

 Target Server Type    : MySQL
 Target Server Version : 50516
 File Encoding         : utf-8

 Date: 10/01/2011 11:18:27 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `config`
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `key` varchar(20) COLLATE utf8_bin NOT NULL,
  `value` varchar(70) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
--  Records of `config`
-- ----------------------------
BEGIN;
INSERT INTO `config` VALUES ('1', 'user_change_pass', '0'), ('2', 'ppp_network', '192.168.100.'), ('4', 'rej_error_log', '/var/log/rejik/error.log'), ('5', 'rej_change_log', '/var/log/rejik/redirector.log'), ('6', 'rej_make-cache', '/usr/sbin/make-cache'), ('7', 'rej_allow_urls', '/etc/squid/banlist/allow_urls/urls'), ('8', 'rej_ban_pref', '/etc/squid/banlist/'), ('9', 'rej_ban_url', 'http://127.0.0.1/ban/'), ('10', 'rej_redir_conf', '/etc/squid/redirector.conf');
COMMIT;

-- ----------------------------
--  Table structure for `conn_speed`
-- ----------------------------
DROP TABLE IF EXISTS `conn_speed`;
CREATE TABLE `conn_speed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(30) COLLATE utf8_bin NOT NULL,
  `ip` varchar(20) COLLATE utf8_bin NOT NULL,
  `speed` int(11) NOT NULL DEFAULT '0',
  `w_speed` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
--  Records of `conn_speed`
-- ----------------------------
BEGIN;
INSERT INTO `conn_speed` VALUES ('1', 'admin', '192.168.100.2', '0', 'unlim');
COMMIT;

-- ----------------------------
--  Table structure for `ip`
-- ----------------------------
DROP TABLE IF EXISTS `ip`;
CREATE TABLE `ip` (
  `src_ip` int(20) unsigned DEFAULT NULL,
  `dst_ip` int(20) unsigned DEFAULT NULL,
  `packets` int(20) unsigned DEFAULT NULL,
  `bytes` int(30) unsigned DEFAULT NULL,
  `src_port` int(5) unsigned DEFAULT NULL,
  `dst_port` int(5) unsigned DEFAULT NULL,
  `proto` int(5) unsigned DEFAULT NULL,
  `iface` char(6) COLLATE utf8_bin DEFAULT NULL,
  `stime` int(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
--  Table structure for `rej_abs_exc`
-- ----------------------------
DROP TABLE IF EXISTS `rej_abs_exc`;
CREATE TABLE `rej_abs_exc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_ip` int(11) NOT NULL,
  `login` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
--  Records of `rej_abs_exc`
-- ----------------------------
BEGIN;
INSERT INTO `rej_abs_exc` VALUES ('10', '2', 'admin');
COMMIT;

-- ----------------------------
--  Table structure for `rej_categories`
-- ----------------------------
DROP TABLE IF EXISTS `rej_categories`;
CREATE TABLE `rej_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `description` varchar(500) COLLATE utf8_bin NOT NULL,
  `enabled` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
--  Records of `rej_categories`
-- ----------------------------
BEGIN;
INSERT INTO `rej_categories` VALUES ('1', 'porno', 'Сайты или разделы сайтов, содержащие изображения порнографического и эротического характера.  К этой категории так же относятся: Сайты связанные с секс услугами (проституция, эротический массаж и т.д.); Сайты эскорт агентств; Сайты секс-шопов;', '1'), ('2', 'baner', 'Реклама в сети интернет.', '1'), ('3', 'chats', 'Чаты, в которых можно общаться через интернет используя веб-браузер, либо специальное клиент-серверное приложение.', '1'), ('4', 'audio-video', 'Звуковые и видео файлы, сайты, содержащие каталоги аудио и видео материалов и/или занимающиеся распространением аудио/видео материалов.', '1'), ('5', 'avto-moto', 'Сайты об автомобилях и мотоциклах, в том числе сайты производителей, новости, обзоры и форумы.', '1'), ('6', 'dating', 'Сайты знакомств. Главный критерий сайта, для попадания в эту категорию - база пользователей, желающих познакомиться, с возможностью поиска по ней и возможностью добавить себя в неё. ', '1'), ('7', 'extremism_rf', 'Сайты, входящие в Федеральный список экстремистских материалов. ', '1'), ('8', 'icq', 'Сервера в интернете, позволяющие общаться при помощи программ обмена сообщениями (ICQ, IRC, AIM, Skype, Yahoo, Jabber, Gadu-Gadu и др.).', '1'), ('9', 'online-games', 'Сервера в интернете, при помощи которых можно играть в игры, используя веб-браузер, либо специальное клиент-серверное приложение.', '1'), ('10', 'phishing', 'Сайты, копирующие оригинальный сайт, с целью получения пользовательских данных оригинального сайта, например логина и пароля.', '1'), ('11', 'photogallery', 'Различные сетевые фотогалереи и фотосайты. ', '1'), ('12', 'socnet', 'Сайты социальных сетей. Например: vkontakte и odnoklassniki.', '1'), ('13', 'spyware', 'Сайты и сервера, содержащиеся в коде spyware софта, используемые этим софтом для передачи пользовательских данных или занимающиеся распространение такого софта.', '1'), ('14', 'torrents', 'Сайты, содержащие торрент файлы или ссылки на них, а так же сервера, обеспечивающие передачу данный по протоколу BitTorrent.', '1'), ('15', 'virus-detect', 'Урлы, содержавшиеся в теле вирусов. Часто в теле вирусов находятся вполне нормальные сайты, когда-то взломанные сайты или сайты, позволяющие сохранить у себя файл, содержащий вирус, например, подделанный под картинку.', '1'), ('19', 'quick_ban', 'Категория предназначенная для самостоятельного блокирования сайтов.', '1'), ('16', 'warez', 'В данную категорию попадают сайты предлагающие скачать \"пиратское\" , нелицензионное програмное обеспечение.', '1'), ('17', 'web-mail', 'Сайты, позволяющие принимать/отправлять почту через веб-интерфейс.', '1'), ('18', 'web-proxy', 'Cлужба в компьютерных сетях, позволяющая клиентам выполнять косвенные запросы к другим сетевым службам через веб-интерфейс. Например чтобы попасть на запрещенный сайт.', '1');
COMMIT;

-- ----------------------------
--  Table structure for `rej_exc`
-- ----------------------------
DROP TABLE IF EXISTS `rej_exc`;
CREATE TABLE `rej_exc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(30) COLLATE utf8_bin NOT NULL,
  `user_ip` int(11) NOT NULL,
  `user_name` varchar(70) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
--  Table structure for `site_allow`
-- ----------------------------
DROP TABLE IF EXISTS `site_allow`;
CREATE TABLE `site_allow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site` varchar(70) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
--  Table structure for `site_deny`
-- ----------------------------
DROP TABLE IF EXISTS `site_deny`;
CREATE TABLE `site_deny` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site` varchar(70) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
--  Table structure for `speed`
-- ----------------------------
DROP TABLE IF EXISTS `speed`;
CREATE TABLE `speed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `w_speed` varchar(20) COLLATE utf8_bin NOT NULL,
  `speed` int(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
--  Records of `speed`
-- ----------------------------
BEGIN;
INSERT INTO `speed` VALUES ('1', '128Kb/s', '166'), ('2', '256Kb/s', '332'), ('3', '512Kb/s', '665'), ('4', '1Mb/s', '1331'), ('5', '1.5Mb/s', '1996'), ('6', '2Mb/s', '2662'), ('7', '2.5Mb/s', '3328'), ('8', '3Mb/s', '3993'), ('9', '4Mb/s', '5324'), ('10', '5Mb/s', '6656'), ('11', '6Mb/s', '7987'), ('12', '7Mb/s', '9318'), ('13', '8Mb/s', '10649'), ('14', '9Mb/s', '11980'), ('15', '10Mb/s', '13312'), ('16', '15Mb/s', '19968'), ('17', '20Mb/s', '26624'), ('28', 'unlim', '0');
COMMIT;

-- ----------------------------
--  Table structure for `traf`
-- ----------------------------
DROP TABLE IF EXISTS `traf`;
CREATE TABLE `traf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) COLLATE utf8_bin NOT NULL,
  `ip` varchar(20) COLLATE utf8_bin NOT NULL,
  `login` varchar(30) COLLATE utf8_bin NOT NULL,
  `in` bigint(100) unsigned NOT NULL,
  `out` bigint(100) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `login` varchar(32) COLLATE utf8_bin NOT NULL,
  `password` varchar(64) COLLATE utf8_bin NOT NULL,
  `ip` int(15) NOT NULL,
  `role` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', 'admin', 'admin', '2', 'admin');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
