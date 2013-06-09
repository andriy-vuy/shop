-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 20 2012 г., 13:34
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `search`
--

CREATE TABLE IF NOT EXISTS `search` (
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
  FULLTEXT KEY `IX_search` (`p_title`,`p_text`,`c_title`,`c_text`,`u_name`,`u_email`,`u_phone`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
