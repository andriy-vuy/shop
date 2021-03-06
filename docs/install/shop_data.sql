-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 18 2012 г., 12:35
-- Версия сервера: 5.5.25a
-- Версия PHP: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `catalog`
--

CREATE TABLE IF NOT EXISTS `catalog` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_parent_id` int(11) NOT NULL DEFAULT '0',
  `c_title` varchar(255) NOT NULL,
  `c_metakeywords` varchar(255) DEFAULT NULL,
  `c_metadescription` varchar(255) DEFAULT NULL,
  `c_text` text,
  `c_created` datetime NOT NULL,
  `c_lastmodified` datetime DEFAULT NULL,
  `c_isproduct` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `catalog`
--

INSERT INTO `catalog` (`c_id`, `c_parent_id`, `c_title`, `c_metakeywords`, `c_metadescription`, `c_text`, `c_created`, `c_lastmodified`, `c_isproduct`) VALUES
(1, 0, '1', '1', '1', '1', '2012-12-18 12:32:46', '2012-12-18 12:32:46', 0),
(2, 0, '2', '2', '2', '2', '2012-12-18 12:32:53', '2012-12-18 12:32:53', 0);

--
-- Триггеры `catalog`
--
DROP TRIGGER IF EXISTS `delete_cat`;
DELIMITER //
CREATE TRIGGER `delete_cat` AFTER DELETE ON `catalog`
 FOR EACH ROW BEGIN
DELETE FROM `search` WHERE c_id = OLD.c_id;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `insert_cat`;
DELIMITER //
CREATE TRIGGER `insert_cat` AFTER INSERT ON `catalog`
 FOR EACH ROW BEGIN INSERT INTO `search` SET 
c_id = NEW.c_id,
c_title = NEW.c_title,
c_text = NEW.c_text,
p_status = 1;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `update_cat`;
DELIMITER //
CREATE TRIGGER `update_cat` AFTER UPDATE ON `catalog`
 FOR EACH ROW BEGIN 
DELETE FROM `search` WHERE c_id = NEW.c_id;
INSERT INTO `search` SET 
c_id = NEW.c_id,
c_title = NEW.c_title,
c_text = NEW.c_text,
p_status = 1;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `delivery`
--

CREATE TABLE IF NOT EXISTS `delivery` (
  `d_id` int(11) NOT NULL AUTO_INCREMENT,
  `d_name` varchar(100) NOT NULL,
  PRIMARY KEY (`d_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `delivery`
--

INSERT INTO `delivery` (`d_id`, `d_name`) VALUES
(1, 'Ð¡Ð°Ð¼Ð¾Ð²Ñ‹Ð²Ð¾Ð·');

-- --------------------------------------------------------

--
-- Структура таблицы `info`
--

CREATE TABLE IF NOT EXISTS `info` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_title` varchar(100) NOT NULL,
  `i_metakeywords` varchar(255) NOT NULL,
  `i_metadescription` varchar(255) NOT NULL,
  `i_text` text NOT NULL,
  `i_latmodified` datetime NOT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `info`
--

INSERT INTO `info` (`i_id`, `i_title`, `i_metakeywords`, `i_metadescription`, `i_text`, `i_latmodified`) VALUES
(1, 'Ð”Ð¾ÑÑ‚Ð°Ð²ÐºÐ°', 'Ð”Ð¾ÑÑ‚Ð°Ð²ÐºÐ° metakeywords', 'Ð”Ð¾ÑÑ‚Ð°Ð²ÐºÐ° metadescription', 'Ð”Ð¾ÑÑ‚Ð°Ð²ÐºÐ° text', '2012-11-23 14:00:00'),
(2, 'Ð“Ð°Ñ€Ð°Ð½Ñ‚Ð¸Ð¸', 'Ð“Ð°Ñ€Ð°Ð½Ñ‚Ð¸Ð¸ metakeywords', 'Ð“Ð°Ñ€Ð°Ð½Ñ‚Ð¸Ð¸ metadescription', 'Ð“Ð°Ñ€Ð°Ð½Ñ‚Ð¸Ð¸ text', '2012-11-23 16:00:00'),
(3, 'ÐžÐ¿Ð»Ð°Ñ‚Ð°', 'ÐžÐ¿Ð»Ð°Ñ‚Ð° metakeywords', 'ÐžÐ¿Ð»Ð°Ñ‚Ð° metadescription', 'ÐžÐ¿Ð»Ð°Ñ‚Ð° text', '2012-11-23 11:00:00'),
(4, 'ÐŸÐ¾Ð¼Ð¾Ñ‰ÑŒ', 'ÐŸÐ¾Ð¼Ð¾Ñ‰ÑŒ metakeywords', 'ÐŸÐ¾Ð¼Ð¾Ñ‰ÑŒ metadescription', 'ÐŸÐ¾Ð¼Ð¾Ñ‰ÑŒ text', '2012-11-23 11:00:00'),
(5, 'ÐšÐ¾Ð½Ñ‚Ð°ÐºÑ‚Ñ‹', 'ÐšÐ¾Ð½Ñ‚Ð°ÐºÑ‚Ñ‹ metakeywords', 'ÐšÐ¾Ð½Ñ‚Ð°ÐºÑ‚Ñ‹ metadescription', 'ÐšÐ¾Ð½Ñ‚Ð°ÐºÑ‚Ñ‹ text', '2012-11-23 11:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `markup`
--

CREATE TABLE IF NOT EXISTS `markup` (
  `t_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `tax` float(9,4) NOT NULL DEFAULT '1.0000',
  `guest` float(9,4) NOT NULL DEFAULT '1.0000',
  `user` float(9,4) NOT NULL DEFAULT '1.0000',
  `user1` float(9,4) NOT NULL DEFAULT '1.0000',
  `user2` float(9,4) NOT NULL DEFAULT '1.0000',
  `user3` float(9,4) NOT NULL DEFAULT '1.0000',
  `admin` float(9,4) NOT NULL DEFAULT '1.0000',
  PRIMARY KEY (`t_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `markup`
--

INSERT INTO `markup` (`t_id`, `name`, `tax`, `guest`, `user`, `user1`, `user2`, `user3`, `admin`) VALUES
(1, 'Ð¡Ñ‚Ð°Ð½Ð´Ð°Ñ€Ñ‚', 1.0000, 1.6000, 1.6000, 1.4000, 1.2000, 1.0000, 1.0000);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `o_id` int(11) NOT NULL AUTO_INCREMENT,
  `o_uid` int(11) DEFAULT NULL,
  `o_username` varchar(100) NOT NULL,
  `o_useremail` varchar(100) DEFAULT NULL,
  `o_userphone` varchar(20) NOT NULL,
  `o_text` text,
  `o_delivery` varchar(100) NOT NULL,
  `o_payment` varchar(100) NOT NULL,
  `o_code` varchar(100) NOT NULL,
  `o_created` datetime NOT NULL,
  PRIMARY KEY (`o_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `orders_products`
--

CREATE TABLE IF NOT EXISTS `orders_products` (
  `op_id` int(11) NOT NULL AUTO_INCREMENT,
  `op_ordersid` int(11) NOT NULL,
  `op_productid` int(11) NOT NULL,
  `op_producttitle` varchar(100) NOT NULL,
  `op_productprice` float NOT NULL,
  `op_quantity` int(11) NOT NULL,
  PRIMARY KEY (`op_id`),
  KEY `fk_orders_products_orders1_idx` (`op_ordersid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_code` varchar(20) NOT NULL,
  `p_cat_id` int(11) NOT NULL,
  `p_markup` int(11) NOT NULL,
  `p_title` varchar(100) NOT NULL,
  `p_metakeywords` varchar(255) DEFAULT NULL,
  `p_metadescription` varchar(255) DEFAULT NULL,
  `p_text` text,
  `p_price` decimal(10,2) NOT NULL,
  `p_created` datetime NOT NULL,
  `p_latmodified` datetime DEFAULT NULL,
  `p_status` tinyint(1) DEFAULT '1',
  `p_quantity` int(11) DEFAULT NULL,
  `p_ordered` int(11) DEFAULT '0',
  PRIMARY KEY (`p_id`),
  KEY `fk_products_catalog1_idx` (`p_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`p_id`, `p_code`, `p_cat_id`, `p_markup`, `p_title`, `p_metakeywords`, `p_metadescription`, `p_text`, `p_price`, `p_created`, `p_latmodified`, `p_status`, `p_quantity`, `p_ordered`) VALUES
(1, 'a00001', 2, 1, 'product1', 'www', 'www', 'www', 23.00, '2012-12-18 12:33:25', '2012-12-18 12:33:25', 1, 2, 0),
(2, 'a00002', 1, 1, 'product2', 'sss', 'sss', 'sss', 112.00, '2012-12-18 12:33:26', '2012-12-18 12:33:26', 1, 12, 0),
(3, 'a00003', 2, 1, 'product3', 'ccc', 'ccc', 'ccc', 45.00, '2012-12-18 12:33:26', '2012-12-18 12:33:26', 1, 7, 0),
(4, 'a00004', 1, 1, 'product4', 'vvv', 'vvv', 'vvv', 65.00, '2012-12-18 12:33:27', '2012-12-18 12:33:27', 1, 9, 0),
(5, 'a00005', 1, 1, 'product5', 'fff', 'fff', 'fff', 167.00, '2012-12-18 12:33:27', '2012-12-18 12:33:27', 1, 21, 0),
(6, 'a00006', 2, 1, 'product6', 'hjj', 'hjj', 'hjj', 76.00, '2012-12-18 12:33:28', '2012-12-18 12:33:28', 1, 0, 0),
(7, 'a00007', 1, 1, 'product7', 'hhh', 'hhh', 'hhh', 24.00, '2012-12-18 12:33:28', '2012-12-18 12:33:28', 1, 6, 0),
(8, 'a00008', 2, 1, 'product8', 'asd', 'asd', 'asd', 56.00, '2012-12-18 12:33:28', '2012-12-18 12:33:28', 1, 0, 0),
(9, 'a00009', 1, 1, 'product9', 'ert', 'ert', 'ert', 78.00, '2012-12-18 12:33:29', '2012-12-18 12:33:29', 1, 9, 0),
(10, 'a00010', 2, 1, 'product10', 'kjh', 'kjh', 'kjh', 23.00, '2012-12-18 12:33:29', '2012-12-18 12:33:29', 1, 4, 0);

--
-- Триггеры `products`
--
DROP TRIGGER IF EXISTS `delete_products`;
DELIMITER //
CREATE TRIGGER `delete_products` AFTER DELETE ON `products`
 FOR EACH ROW BEGIN
DELETE FROM `search` WHERE p_id = OLD.p_id;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `insert_products`;
DELIMITER //
CREATE TRIGGER `insert_products` AFTER INSERT ON `products`
 FOR EACH ROW BEGIN INSERT INTO `search` SET 
p_id = NEW.p_id,
p_title = NEW.p_title,
p_text = NEW.p_text,
p_status = NEW.p_status;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `update_products`;
DELIMITER //
CREATE TRIGGER `update_products` AFTER UPDATE ON `products`
 FOR EACH ROW BEGIN 
DELETE FROM `search` WHERE p_id = NEW.p_id;
INSERT INTO `search` SET 
p_id = NEW.p_id,
p_title = NEW.p_title,
p_text = NEW.p_text,
p_status = NEW.p_status;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `products_img`
--

CREATE TABLE IF NOT EXISTS `products_img` (
  `pi_id` int(11) NOT NULL AUTO_INCREMENT,
  `pi_pid` int(11) NOT NULL,
  `pi_img` varchar(100) NOT NULL,
  PRIMARY KEY (`pi_id`),
  KEY `fk_img_products_idx` (`pi_pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Дамп данных таблицы `products_img`
--

INSERT INTO `products_img` (`pi_id`, `pi_pid`, `pi_img`) VALUES
(1, 1, 'IMG_0242.JPG'),
(2, 1, 'IMG_0243.JPG'),
(3, 2, 'IMG_0244.JPG'),
(4, 2, 'IMG_0245.JPG'),
(5, 3, 'IMG_0246.JPG'),
(6, 3, 'IMG_0247.JPG'),
(7, 4, 'IMG_0248.JPG'),
(8, 4, 'IMG_0249.JPG'),
(9, 5, 'IMG_0250.JPG'),
(10, 5, 'IMG_0251.JPG'),
(11, 6, 'IMG_0252.JPG'),
(12, 6, 'IMG_0253.JPG'),
(13, 7, 'IMG_0255.JPG'),
(14, 7, 'IMG_0256.JPG'),
(15, 8, 'IMG_0257.JPG'),
(16, 8, 'IMG_0258.JPG'),
(17, 9, 'IMG_0259.JPG'),
(18, 9, 'IMG_0260.JPG'),
(19, 10, 'IMG_0261.JPG'),
(20, 10, 'IMG_0262.JPG');

-- --------------------------------------------------------

--
-- Структура таблицы `search`
--

CREATE TABLE IF NOT EXISTS `search` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) DEFAULT NULL,
  `p_title` varchar(100) DEFAULT NULL,
  `p_text` text,
  `p_status` tinyint(1) DEFAULT NULL,
  `c_id` int(11) DEFAULT NULL,
  `c_title` varchar(255) DEFAULT NULL,
  `c_text` text,
  `u_id` int(11) DEFAULT NULL,
  `u_name` varchar(100) DEFAULT NULL,
  `u_email` varchar(100) DEFAULT NULL,
  `u_phone` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`s_id`),
  FULLTEXT KEY `IX_search` (`p_title`,`p_text`,`c_title`,`c_text`,`u_name`,`u_email`,`u_phone`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `search`
--

INSERT INTO `search` (`s_id`, `p_id`, `p_title`, `p_text`, `p_status`, `c_id`, `c_title`, `c_text`, `u_id`, `u_name`, `u_email`, `u_phone`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'admin', 'lucky_nick@mail.ru', '0501111111'),
(2, NULL, NULL, NULL, 1, 1, '1', '1', NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, 1, 2, '2', '2', NULL, NULL, NULL, NULL),
(4, 1, 'product1', 'www', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 2, 'product2', 'sss', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 3, 'product3', 'ccc', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 4, 'product4', 'vvv', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 5, 'product5', 'fff', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 6, 'product6', 'hjj', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 7, 'product7', 'hhh', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 8, 'product8', 'asd', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 9, 'product9', 'ert', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 10, 'product10', 'kjh', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `shopping_cart`
--

CREATE TABLE IF NOT EXISTS `shopping_cart` (
  `sc_pid` int(11) NOT NULL AUTO_INCREMENT,
  `sc_user` varchar(100) NOT NULL,
  `sc_product` int(11) NOT NULL,
  `sc_quantity` int(11) NOT NULL,
  PRIMARY KEY (`sc_pid`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_name` varchar(100) NOT NULL,
  `u_email` varchar(100) NOT NULL,
  `u_phone` varchar(45) DEFAULT NULL,
  `u_password` varchar(45) NOT NULL,
  `u_role` enum('admin','user','user1','user2','user3') NOT NULL DEFAULT 'user',
  `u_created` datetime NOT NULL,
  `u_lastmodified` datetime DEFAULT NULL,
  `u_activated` tinyint(1) NOT NULL DEFAULT '0',
  `u_code` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`u_id`, `u_name`, `u_email`, `u_phone`, `u_password`, `u_role`, `u_created`, `u_lastmodified`, `u_activated`, `u_code`) VALUES
(1, 'admin', 'lucky_nick@mail.ru', '0501111111', '356a192b7913b04c54574d18c28d46e6395428ab', 'admin', '2012-09-08 13:57:27', '2012-09-08 14:06:54', 1, '504b32a7efaec');

--
-- Триггеры `users`
--
DROP TRIGGER IF EXISTS `delete_users`;
DELIMITER //
CREATE TRIGGER `delete_users` AFTER DELETE ON `users`
 FOR EACH ROW BEGIN
DELETE FROM `search` WHERE u_id = OLD.u_id;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `insert_users`;
DELIMITER //
CREATE TRIGGER `insert_users` AFTER INSERT ON `users`
 FOR EACH ROW BEGIN INSERT INTO `search` SET 
u_id = NEW.u_id,
u_name = NEW.u_name,
u_email = NEW.u_email,
u_phone = NEW.u_phone;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `update_users`;
DELIMITER //
CREATE TRIGGER `update_users` AFTER UPDATE ON `users`
 FOR EACH ROW BEGIN 
DELETE FROM `search` WHERE u_id = NEW.u_id;
INSERT INTO `search` SET 
u_id = NEW.u_id,
u_name = NEW.u_name,
u_email = NEW.u_email,
u_phone = NEW.u_phone;
END
//
DELIMITER ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders_products`
--
ALTER TABLE `orders_products`
  ADD CONSTRAINT `fk_orders_products_orders1` FOREIGN KEY (`op_ordersid`) REFERENCES `orders` (`o_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_catalog1` FOREIGN KEY (`p_cat_id`) REFERENCES `catalog` (`c_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products_img`
--
ALTER TABLE `products_img`
  ADD CONSTRAINT `fk_img_products` FOREIGN KEY (`pi_pid`) REFERENCES `products` (`p_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
