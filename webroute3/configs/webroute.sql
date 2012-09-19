-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 12 2012 г., 04:55
-- Версия сервера: 5.1.61
-- Версия PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `webroute`
--

-- --------------------------------------------------------

--
-- Структура таблицы `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `key` varchar(20) COLLATE utf8_bin NOT NULL,
  `value` varchar(70) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `key` (`key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `config`
--

INSERT INTO `config` (`id`, `key`, `value`) VALUES
(1, 'user_change_pass', '0'),
(2, 'ppp_network', '192.168.100.'),
(3, 'rej_error_log', '/var/log/rejik/error.log'),
(4, 'rej_change_log', '/var/log/rejik/redirector.log'),
(5, 'rej_make-cache', '/usr/sbin/make-cache'),
(6, 'rej_allow_urls', '/etc/squid/banlist/allow_urls/urls'),
(7, 'rej_ban_pref', '/etc/squid/banlist/'),
(8, 'rej_ban_url', 'http://127.0.0.1/ban/'),
(9, 'rej_redir_conf', '/etc/squid/redirector.conf'),
(10, 'rej_ban_form', '1'),
(11, 'version', '3.2.2'),
(12, 'rej_unban_mail', 'admin@example.com'),
(13, 'rej_need_usr_mail', '0'),
(14, 'view_except_traf', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `conn_speed`
--

CREATE TABLE IF NOT EXISTS `conn_speed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(30) COLLATE utf8_bin NOT NULL,
  `ip` varchar(20) COLLATE utf8_bin NOT NULL,
  `speed` int(11) NOT NULL DEFAULT '0',
  `w_speed` varchar(20) COLLATE utf8_bin NOT NULL,
  `ospeed` int(11) NOT NULL,
  `ow_speed` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `conn_speed`
--

INSERT INTO `conn_speed` (`id`, `login`, `ip`, `speed`, `w_speed`, `ospeed`, `ow_speed`) VALUES
(1, 'admin', '192.168.100.2', 0, 'unlim', 0, 'unlim');

-- --------------------------------------------------------

--
-- Структура таблицы `ip`
--

CREATE TABLE IF NOT EXISTS `ip` (
  `SRCADDR` varchar(45) COLLATE utf8_bin NOT NULL,
  `DSTADDR` varchar(45) COLLATE utf8_bin NOT NULL,
  `DOCTETS` bigint(250) NOT NULL
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура таблицы `ip_temp`
--

CREATE TABLE IF NOT EXISTS `ip_temp` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `login` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `in` bigint(255) unsigned NOT NULL,
  `out` bigint(255) unsigned NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Структура таблицы `l7filter`
--

CREATE TABLE IF NOT EXISTS `l7filter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `user` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `proto_code` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `l7protocols`
--

CREATE TABLE IF NOT EXISTS `l7protocols` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `code` int(11) NOT NULL,
  `enabled` int(11) NOT NULL,
  `speed` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

--
-- Дамп данных таблицы `l7protocols`
--

INSERT INTO `l7protocols` (`id`, `name`, `code`, `enabled`, `speed`, `description`) VALUES
(1, 'worldofwarcraft', 3, 0, 3, 'Популярная on-line игра.'),
(2, 'subversion', 4, 0, 3, 'Система контроля версий.'),
(3, 'stun', 5, 0, 3, 'Протокол трассировки сессий для NAT.'),
(4, 'skypetoskype', 6, 0, 3, 'Звонки со скайпа на скайп.'),
(5, 'skypeout', 7, 0, 2, 'Звонки со скайпа на обычную телефонию.'),
(6, 'runesofmagic', 8, 0, 3, 'Популярная on-line игра.'),
(7, 'rdp', 9, 0, 2, 'Протокол удаленного управления.'),
(8, 'radmin', 10, 0, 3, 'Протокол удаленного управления.'),
(9, 'h323', 11, 0, 3, 'Протокол IP телефонии.'),
(10, 'ciscovpn', 12, 0, 3, ' Реализация технологии Виртуальной Частной Сети.'),
(11, 'battlefield2142', 13, 0, 3, 'Популярная on-line игра.'),
(12, 'battlefield1942', 14, 0, 3, 'Популярная on-line игра.'),
(13, 'telnet', 15, 0, 3, 'Протокол удаленного управления.'),
(14, 'teamspeak', 16, 0, 3, 'Протокол IP телефонии.'),
(15, 'ssl', 17, 0, 3, ' Криптографический протокол для установления безопасного соединения.'),
(16, 'soulseek', 18, 0, 3, ' Пиринговый протокол обмена файлами.'),
(17, 'socks', 19, 0, 2, 'Протокол взаимодействия приложений через межсетевой экран.'),
(18, 'snmp', 20, 0, 3, 'Простой протокол управления сетями.'),
(19, 'smb', 21, 0, 2, 'Протокол для удалённого доступа к файлам.'),
(20, 'sip', 22, 0, 3, 'Протокол IP телефонии.'),
(21, 'shoutcast', 23, 0, 2, 'Протокол потокового вещания аудио/видео.'),
(22, 'rtsp', 24, 0, 2, 'Потоковый протокол реального времени.'),
(23, 'quake-halflife', 25, 0, 3, 'Популярная on-line игра.'),
(24, 'openft', 26, 0, 2, 'Пиринговый протокол обмена файлами.'),
(25, 'nntp', 27, 0, 3, 'Протокол распространения групп новостей.'),
(26, 'napster', 28, 0, 3, 'Пиринговый протокол обмена файлами.'),
(27, 'msnmessenger', 29, 0, 2, 'Протокол обмена сообщениями в реальном времени.'),
(28, 'msn-filetransfer', 30, 0, 3, 'Обмен файлами через  msn messenger.'),
(29, 'mohaa', 31, 0, 3, 'Популярная on-line игра.'),
(30, 'jabber', 32, 0, 2, 'Протокол обмена сообщениями в реальном времени.'),
(31, 'halflife2-deathmatch', 33, 0, 3, 'Популярная on-line игра.'),
(32, 'gnutella', 34, 0, 2, 'Пиринговый протокол обмена файлами.'),
(33, 'fasttrack', 35, 0, 2, 'Пиринговый протокол обмена файлами.'),
(34, 'edonkey', 36, 0, 3, 'Пиринговый протокол обмена файлами.'),
(35, 'doom3', 37, 0, 3, 'Популярная on-line игра.'),
(36, 'directconnect', 38, 0, 3, 'Пиринговый протокол обмена файлами.'),
(37, 'dayofdefeat-source', 39, 0, 3, 'Популярная on-line игра.'),
(38, 'cvs', 40, 0, 3, 'Система контроля версий.'),
(39, 'counterstrike-source', 41, 0, 3, 'Популярная on-line игра.'),
(40, 'bittorrent', 42, 0, 2, 'Пиринговый протокол обмена файлами.'),
(41, 'ares', 43, 0, 3, 'Пиринговый протокол обмена файлами.'),
(42, 'aim', 44, 0, 2, 'Протокол обмена сообщениями в реальном времени.'),
(43, 'vnc', 45, 0, 3, 'Протокол удаленного управления.'),
(44, 'ssh', 46, 0, 3, 'Протокол удаленного управления.'),
(45, 'smtp', 47, 0, 3, 'Почтовый протокол.'),
(46, 'pop3', 48, 0, 3, 'Почтовый протокол.'),
(47, 'irc', 49, 0, 3, 'Протокол обмена сообщениями в реальном времени.'),
(48, 'imap', 50, 0, 3, 'Почтовый протокол.'),
(49, 'http', 51, 0, 2, 'Протокол передачи гипертекста.'),
(50, 'ftp', 52, 0, 3, 'Протокол для удалённого доступа к файлам.'),
(51, 'applejuice', 53, 0, 3, 'Пиринговый протокол обмена файлами.'),
(52, 'dns', 54, 0, 3, 'Система доменных имён.'),
(53, 'yahoo', 55, 0, 3, 'Протокол обмена сообщениями в реальном времени.'),
(54, 'x11', 56, 0, 4, 'Протокол удаленного управления.'),
(55, 'ventrilo', 57, 0, 3, 'Протокол IP телефонии.'),
(56, 'tor', 58, 0, 2, 'Протокол, позволяющий устанавливать анонимное сетевое соединение.'),
(57, 'ntp', 59, 0, 3, 'Протокол синхронизации времени.'),
(58, 'imesh', 60, 0, 2, 'Пиринговый протокол обмена файлами.'),
(59, 'battlefield2', 61, 0, 2, 'Популярная on-line игра.'),
(60, 'teamfortress2', 62, 0, 3, 'Популярная on-line игра.');

-- --------------------------------------------------------

--
-- Структура таблицы `quota`
--

CREATE TABLE IF NOT EXISTS `quota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `in_quota_d` bigint(70) unsigned NOT NULL,
  `out_quota_d` bigint(70) unsigned NOT NULL,
  `in_quota_m` bigint(20) unsigned NOT NULL,
  `out_quota_m` bigint(20) unsigned NOT NULL,
  `blocked` tinyint(1) NOT NULL,
  `reason` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `rej_abs_exc`
--

CREATE TABLE IF NOT EXISTS `rej_abs_exc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_ip` int(11) NOT NULL,
  `login` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `rej_categories`
--

CREATE TABLE IF NOT EXISTS `rej_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `description` varchar(500) COLLATE utf8_bin NOT NULL,
  `enabled` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=28 ;

--
-- Дамп данных таблицы `rej_categories`
--

INSERT INTO `rej_categories` (`id`, `name`, `description`, `enabled`) VALUES
(1, 'porno', 'Сайты или разделы сайтов, содержащие изображения порнографического и эротического характера.  К этой категории так же относятся: Сайты связанные с секс услугами (проституция, эротический массаж и т.д.); Сайты эскорт агентств; Сайты секс-шопов;', 1),
(2, 'baner', 'Реклама в сети интернет.', 1),
(3, 'chats', 'Чаты, в которых можно общаться через интернет используя веб-браузер, либо специальное клиент-серверное приложение.', 1),
(4, 'audio-video', 'Звуковые и видео файлы, сайты, содержащие каталоги аудио и видео материалов и/или занимающиеся распространением аудио/видео материалов.', 1),
(5, 'avto-moto', 'Сайты об автомобилях и мотоциклах, в том числе сайты производителей, новости, обзоры и форумы.', 1),
(6, 'dating', 'Сайты знакомств. Главный критерий сайта, для попадания в эту категорию - база пользователей, желающих познакомиться, с возможностью поиска по ней и возможностью добавить себя в неё. ', 1),
(7, 'extremism_rf', 'Сайты, входящие в Федеральный список экстремистских материалов. ', 1),
(8, 'icq', 'Сервера в интернете, позволяющие общаться при помощи программ обмена сообщениями (ICQ, IRC, AIM, Skype, Yahoo, Jabber, Gadu-Gadu и др.).', 1),
(9, 'online-games', 'Сервера в интернете, при помощи которых можно играть в игры, используя веб-браузер, либо специальное клиент-серверное приложение.', 1),
(10, 'phishing', 'Сайты, копирующие оригинальный сайт, с целью получения пользовательских данных оригинального сайта, например логина и пароля.', 1),
(11, 'photogallery', 'Различные сетевые фотогалереи и фотосайты. ', 1),
(12, 'socnet', 'Сайты социальных сетей. Например: vkontakte и odnoklassniki.', 1),
(13, 'spyware', 'Сайты и сервера, содержащиеся в коде spyware софта, используемые этим софтом для передачи пользовательских данных или занимающиеся распространение такого софта.', 1),
(14, 'torrents', 'Сайты, содержащие торрент файлы или ссылки на них, а так же сервера, обеспечивающие передачу данный по протоколу BitTorrent.', 1),
(15, 'virus-detect', 'Урлы, содержавшиеся в теле вирусов. Часто в теле вирусов находятся вполне нормальные сайты, когда-то взломанные сайты или сайты, позволяющие сохранить у себя файл, содержащий вирус, например, подделанный под картинку.', 1),
(19, 'quick_ban', 'Категория предназначенная для самостоятельного блокирования сайтов.', 1),
(16, 'warez', 'В данную категорию попадают сайты предлагающие скачать "пиратское" , нелицензионное програмное обеспечение.', 1),
(17, 'web-mail', 'Сайты, позволяющие принимать/отправлять почту через веб-интерфейс.', 0),
(18, 'web-proxy', 'Cлужба в компьютерных сетях, позволяющая клиентам выполнять косвенные запросы к другим сетевым службам через веб-интерфейс. Например чтобы попасть на запрещенный сайт.', 1),
(20, 'jobsearch', 'Сайты для поиска работы и персонала(рекрутинг).', 1),
(21, 'ip_addr', 'Категория запрещает использование ip адресов в качестве URL. Служит для того чтобы помешать пользователям обойти редиректор, введя ip адрес заблокированного сайта в адресную строку и получив тем самым к нему доступ.', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `rej_exc`
--

CREATE TABLE IF NOT EXISTS `rej_exc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(30) COLLATE utf8_bin NOT NULL,
  `user_ip` int(11) NOT NULL,
  `user_name` varchar(70) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `rej_usr_exc`
--

CREATE TABLE IF NOT EXISTS `rej_usr_exc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `site` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `action` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `report_except`
--

CREATE TABLE IF NOT EXISTS `report_except` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `sites`
--

CREATE TABLE IF NOT EXISTS `sites` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `site` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `act` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `sites`
--

INSERT INTO `sites` (`id`, `site`, `act`) VALUES
(1, '192.168.100.1', 'allow'),
(2, '127.0.0.1', 'allow');

-- --------------------------------------------------------

--
-- Структура таблицы `speed`
--

CREATE TABLE IF NOT EXISTS `speed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `w_speed` varchar(20) COLLATE utf8_bin NOT NULL,
  `speed` int(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `w_speed` (`w_speed`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=20 ;

--
-- Дамп данных таблицы `speed`
--

INSERT INTO `speed` (`id`, `w_speed`, `speed`) VALUES
(1, '64Kb/s', 67),
(2, '128Kb/s', 135),
(3, '256Kb/s', 270),
(4, '512Kb/s', 538),
(5, '1Mb/s', 1075),
(6, '1.5Mb/s', 1612),
(7, '2Mb/s', 2150),
(8, '2.5Mb/s', 2690),
(9, '3Mb/s', 3225),
(10, '4Mb/s', 4300),
(11, '5Mb/s', 5376),
(12, '6Mb/s', 6451),
(13, '7Mb/s', 7527),
(14, '8Mb/s', 8600),
(15, '9Mb/s', 9676),
(16, '10Mb/s', 10750),
(17, '15Mb/s', 16128),
(18, '20Mb/s', 21500),
(19, 'unlim', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `traf`
--

CREATE TABLE IF NOT EXISTS `traf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) COLLATE utf8_bin NOT NULL,
  `ip` varchar(20) COLLATE utf8_bin NOT NULL,
  `login` varchar(30) COLLATE utf8_bin NOT NULL,
  `in` bigint(255) unsigned NOT NULL,
  `out` bigint(255) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `login` varchar(32) COLLATE utf8_bin NOT NULL,
  `password` varchar(64) COLLATE utf8_bin NOT NULL,
  `ip` int(15) NOT NULL,
  `role` varchar(10) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `ip`, `role`) VALUES
(1, 'admin', 'admin', 2, 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
