
--
-- Table structure `report_db`
--

DROP TABLE IF EXISTS `report_db`;
CREATE TABLE IF NOT EXISTS `report_db` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `server` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `port` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `driver` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `db_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` text COLLATE utf8_unicode_ci,
  `charset` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_by` int(11) NOT NULL DEFAULT '1',
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL DEFAULT '1',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

/*Data for the table `report_db` */

-- --------------------------------------------------------

--
-- Table structure `report_do`
--

DROP TABLE IF EXISTS `report_do`;
CREATE TABLE IF NOT EXISTS `report_do` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `table` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `db_id` int(11) NOT NULL,
  `search_rule` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_rule` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_by` int(11) NOT NULL DEFAULT '1',
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL DEFAULT '1',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci  ;

/*Data for the table `report_do` */

-- --------------------------------------------------------

--
-- Table structure `report_do_field`
--

DROP TABLE IF EXISTS `report_do_field`;
CREATE TABLE IF NOT EXISTS `report_do_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `do_id` int(11) NOT NULL,
  `column` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sql_expr` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `format` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_by` int(11) NOT NULL DEFAULT '1',
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL DEFAULT '1',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci  ;

/*Data for the table `report_do_field` */

-- --------------------------------------------------------

--
-- Table structure `report_folder`
--

DROP TABLE IF EXISTS `report_folder`;
CREATE TABLE IF NOT EXISTS `report_folder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `owner_id` int(11) default 0,
  `group_id` INT(11) default '1',
  `group_perm` INT(11) default '1',
  `other_perm` INT(11) default '1' ,
  `create_by` int(11) NOT NULL DEFAULT '1',
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL DEFAULT '1',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci  ;

ALTER TABLE `report_folder` ADD `sortorder` INT NOT NULL DEFAULT 10 AFTER `description` ;

/*Data for the table `report_folder` */

insert  into `report_folder`(`id`,`parent_id`,`name`,`description`,`sortorder`) values (1,NULL,'root','root node',10),(2,1,'sponsor',NULL,50);

-- --------------------------------------------------------

--
-- Table structure `report_form`
--

DROP TABLE IF EXISTS `report_form`;
CREATE TABLE IF NOT EXISTS `report_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `do_id` int(11) NOT NULL,
  `view_id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('table','chart') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'table' COMMENT 'Can be table or chart',
  `subtype` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `width` int(4) DEFAULT '500',
  `height` int(4) DEFAULT '300',
  `attrs` text COLLATE utf8_unicode_ci,
  `fix_searchrule` TEXT NOT NULL,
  `default_searchrule` text COLLATE utf8_unicode_ci,
  `sort_order` int(2) DEFAULT NULL,
  `create_by` int(11) NOT NULL DEFAULT '1',
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL DEFAULT '1',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci  ;

/*Data for the table `report_form` */

-- --------------------------------------------------------

--
-- Table structure `report_form_element`
--

DROP TABLE IF EXISTS `report_form_element`;
CREATE TABLE IF NOT EXISTS `report_form_element` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `form_id` int(11) NOT NULL,
  `field_id` int(11) DEFAULT NULL,
  `label` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ColumnText' COMMENT 'Can be chart elements',
  `attrs` text COLLATE utf8_unicode_ci,
  `style` text COLLATE utf8_unicode_ci,
  `sort_order` int(11) NOT NULL,
  `create_by` int(11) NOT NULL DEFAULT '1',
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL DEFAULT '1',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci  ;

ALTER TABLE `report_form_element` ADD `select_from` TEXT COLLATE utf8_unicode_ci AFTER `style` ;

/*Data for the table `report_form_element` */

-- --------------------------------------------------------

--
-- Table structure `report_view`
--

DROP TABLE IF EXISTS `report_view`;
CREATE TABLE IF NOT EXISTS `report_view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folder_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default_db_id` int(11) DEFAULT NULL,
  `default_do_id` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '10',
  `owner_id` int(11) default 0,
  `group_id` INT(11) default '1',
  `group_perm` INT(11) default '1',
  `other_perm` INT(11) default '1' ,
  `create_by` int(11) NOT NULL DEFAULT '1',
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL DEFAULT '1',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci  ;

/*Data for the table `report_view` */

/*Table structure for table `report_color` */

DROP TABLE IF EXISTS `report_color`;
CREATE TABLE IF NOT EXISTS `report_color` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(2) DEFAULT NULL,
  `create_by` int(11) NOT NULL DEFAULT '1',
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL DEFAULT '1',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*Data for the table `report_color` */

insert  into `report_color`(`id`,`name`,`color_code`,`sort_order`,`create_by`,`create_time`,`update_by`,`update_time`) values (1,'red','ff0000',10,1,'2010-10-25 23:27:36',1,'2010-10-25 23:27:36'),(2,'blue','000dff',50,1,'2010-10-25 23:27:55',1,'2010-10-25 23:27:55');

