
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

insert  into `report_db`(`id`,`name`,`server`,`port`,`driver`,`db_name`,`username`,`password`,`charset`,`create_by`,`create_time`,`update_by`,`update_time`) values (1,'Sample sale db','localhost','3306','PDO_MYSQL','gcubi','root','b75282010f9549dd177a1ed7903df4ee','utf8',1,'2011-07-17 23:20:44',1,'2011-07-17 23:20:44');

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

insert  into `report_do`(`id`,`name`,`table`,`db_id`,`search_rule`,`sort_rule`,`group_by`,`create_by`,`create_time`,`update_by`,`update_time`) values (1,'Sales table','report_sample_sales',1,NULL,NULL,NULL,1,'2011-07-17 23:22:13',1,'2011-07-17 23:22:13');

-- --------------------------------------------------------

--
-- Table structure `report_do_field`
--

DROP TABLE IF EXISTS `report_do_field`;
CREATE TABLE IF NOT EXISTS `report_do_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `do_id` int(11) NOT NULL,
  `join_id` int(11) DEFAULT NULL,
  `column` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sql_expr` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `format` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_by` int(11) NOT NULL DEFAULT '1',
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL DEFAULT '1',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci  ;

/*Data for the table `report_do_field` */

insert  into `report_do_field`(`id`,`name`,`do_id`,`column`,`sql_expr`,`type`,`format`,`create_by`,`create_time`,`update_by`,`update_time`) values (1,'Id',1,'id',NULL,'Number',NULL,1,'2011-07-17 23:22:24',1,'2011-07-17 23:22:24'),(2,'Name',1,'name',NULL,'Text',NULL,1,'2011-07-17 23:22:24',1,'2011-07-17 23:22:24'),(3,'Division',1,'division',NULL,'Text',NULL,1,'2011-07-17 23:22:24',1,'2011-07-17 23:22:24'),(4,'Product',1,'product',NULL,'Text',NULL,1,'2011-07-17 23:22:24',1,'2011-07-17 23:22:24'),(5,'Year',1,'year',NULL,'Text',NULL,1,'2011-07-17 23:22:24',1,'2011-07-17 23:22:24'),(6,'Revenue',1,'revenue',NULL,'Number',NULL,1,'2011-07-17 23:22:24',1,'2011-07-17 23:22:24'),(7,'Cost',1,'cost',NULL,'Number',NULL,1,'2011-07-17 23:22:24',1,'2011-07-17 23:22:24');

-- --------------------------------------------------------

--
-- Table structure `report_do_join`
--

DROP TABLE IF EXISTS `report_do_join`;

CREATE TABLE `report_do_join` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `name` varchar(100) NOT NULL,
   `do_id` int(11) NOT NULL,
   `table` varchar(100) DEFAULT NULL,
   `column` varchar(100) DEFAULT NULL,
   `jointype` varchar(50) DEFAULT NULL,
   `columnref` varchar(100) DEFAULT NULL,
   `joinref` varchar(100) DEFAULT NULL,
   `create_by` int(11) NOT NULL DEFAULT '1',
   `create_time` datetime NOT NULL,
   `update_by` int(11) NOT NULL DEFAULT '1',
   `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 
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
  `type` varchar(50) NOT NULL DEFAULT 'table' COMMENT 'Can be table or chart',
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

insert  into `report_form`(`id`,`name`,`description`,`do_id`,`view_id`,`title`,`type`,`subtype`,`width`,`height`,`attrs`,`fix_searchrule`,`default_searchrule`,`sort_order`,`create_by`,`create_time`,`update_by`,`update_time`) values (1,NULL,NULL,1,1,'Sample Sales West Table','table','Column2D',700,300,'TemplateFile=report_table_default.tpl.html;PageSize=10;shownames=0;showValues=0;showhovercap=0;numberPrefix=;numberSuffix=;formatNumber=0;formatNumberScale=0;showPercentageValues=0;showPercentageInLabel=0;pieRadius=;pieYScale=;pieSliceDepth=;showShadow=0;animation=0;showLimits=0;rotateNames=0;showColumnShadow=0;showBarShadow=0;yAxisMinValue=;yAxisMaxValue=;showAnchors=0;anchorRadius=;showAreaBorder=0;areaAlpha=;showLegend=0;','[Division]=\'west\' and [Product]=\'HDTV\'',NULL,10,1,'2011-07-17 23:23:18',1,'2011-07-18 00:04:40'),(2,NULL,NULL,1,1,'Sample Sale West Chart','chart','MSColumn3D',700,300,'TemplateFile=report_table_default.tpl.html;PageSize=10;shownames=1;showValues=1;showhovercap=1;numberPrefix=;numberSuffix=;formatNumber=0;formatNumberScale=0;showPercentageValues=1;showPercentageInLabel=1;pieRadius=;pieYScale=;pieSliceDepth=;showShadow=1;animation=1;showLimits=1;rotateNames=1;showColumnShadow=1;showBarShadow=1;yAxisMinValue=;yAxisMaxValue=;showAnchors=1;anchorRadius=;showAreaBorder=1;areaAlpha=;showLegend=1;','[Division]=\'west\' and [Product]=\'HDTV\'',NULL,15,1,'2011-07-17 23:25:47',1,'2011-07-18 00:07:55'),(3,NULL,NULL,1,1,'Sample Sale Filter','filter','',700,300,'','',NULL,5,1,'2011-07-19 08:16:47',1,'2011-07-19 08:33:17');

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

insert  into `report_form_element`(`id`,`name`,`form_id`,`field_id`,`label`,`class`,`attrs`,`style`,`select_from`,`sort_order`,`create_by`,`create_time`,`update_by`,`update_time`) values (1,NULL,1,2,'Name','ColumnText',NULL,NULL,NULL,10,1,'2011-07-17 23:23:18',1,'2011-07-17 23:23:18'),(2,NULL,1,3,'Division','ColumnText',NULL,NULL,NULL,20,1,'2011-07-17 23:23:18',1,'2011-07-17 23:23:18'),(3,NULL,1,4,'Product','ColumnText',NULL,NULL,NULL,30,1,'2011-07-17 23:23:18',1,'2011-07-17 23:23:18'),(4,NULL,1,5,'Year','ColumnText',NULL,NULL,NULL,40,1,'2011-07-17 23:23:18',1,'2011-07-17 23:23:18'),(5,NULL,1,6,'Revenue','ColumnText',NULL,NULL,NULL,50,1,'2011-07-17 23:23:18',1,'2011-07-17 23:23:18'),(6,NULL,1,7,'Cost','ColumnText',NULL,NULL,NULL,60,1,'2011-07-17 23:23:18',1,'2011-07-17 23:23:18'),(7,NULL,2,5,'Year','report.lib.ChartCategory','width:100%;height:100%;font-weight:normal;font-style:normal;text-decoration:auto;text-align:left;font-size:12px;',NULL,NULL,10,1,'2011-07-17 23:25:47',1,'2011-07-18 00:08:01'),(8,NULL,2,6,'Revenue','report.lib.ChartData','width:100%;height:100%;font-weight:normal;font-style:normal;text-decoration:auto;text-align:left;font-size:12px;',NULL,NULL,20,1,'2011-07-17 23:25:47',1,'2011-07-17 23:35:10'),(9,NULL,2,7,'Cost','report.lib.ChartData','width:100%;height:100%;font-weight:normal;font-style:normal;text-decoration:auto;text-align:left;font-size:12px;',NULL,NULL,30,1,'2011-07-17 23:35:35',1,'2011-07-17 23:35:35'),(10,NULL,3,5,'Year','InputText','width:100%;height:100%;font-weight:normal;font-style:normal;text-decoration:auto;text-align:left;font-size:12px;',NULL,NULL,10,1,'2011-07-19 08:24:59',1,'2011-07-19 08:33:37');

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
  `group_id` INT(11) default '0',
  `create_by` int(11) NOT NULL DEFAULT '1',
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL DEFAULT '1',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci  ;

/*Data for the table `report_view` */

insert  into `report_view`(`id`,`folder_id`,`name`,`title`,`description`,`default_db_id`,`default_do_id`,`sort_order`,`owner_id`,`group_id`,`create_by`,`create_time`,`update_by`,`update_time`) values (1,0,NULL,'Sample Sales West',NULL,1,1,10,0,1,1,'2011-07-17 23:23:18',1,'2011-07-17 23:23:18');


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

-- --------------------------------------------------------

--
-- Table structure `report_map`
--

DROP TABLE IF EXISTS `report_map`;
CREATE TABLE `report_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `publish` int(2) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '10',
  `create_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `report_map` */

insert  into `report_map`(`id`,`parent_id`,`name`,`title`,`link`,`publish`,`sort_order`,`group_id`,`create_time`,`create_by`,`update_time`,`update_by`) values (1,0,'Sample Reports','Sample Reports',NULL,1,10,1,'2011-07-18 00:09:44',1,'2011-07-18 00:09:44',1),(2,1,'Custom report','Custom report','/report/report/1',1,10,1,'2011-07-18 00:10:30',1,'2011-07-18 00:12:41',1),(3,1,'Pre-built report','Pre-built report','/report/sample_sales_report',1,10,1,'2011-07-18 00:11:05',1,'2011-07-18 00:11:05',1);

-- --------------------------------------------------------

--
-- Table structure `report_sample_sales`
--

DROP TABLE IF EXISTS `report_sample_sales`;
CREATE TABLE `report_sample_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `division` varchar(32) NOT NULL,
  `product` varchar(64) NOT NULL,
  `year` varchar(10) NOT NULL,
  `revenue` float NOT NULL,
  `cost` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `report_sample_sales` */

insert into `report_sample_sales` (`id`, `name`, `division`, `product`, `year`, `revenue`, `cost`) values('1','2000 West HDTV Sales','West','HDTV','2000','568900','210290');
insert into `report_sample_sales` (`id`, `name`, `division`, `product`, `year`, `revenue`, `cost`) values('2','2000 East HDTV Sales','East','HDTV','2000','450390','190380');
insert into `report_sample_sales` (`id`, `name`, `division`, `product`, `year`, `revenue`, `cost`) values('3','2000 West SDTV Sales','West','SDTV','2000','869100','530400');
insert into `report_sample_sales` (`id`, `name`, `division`, `product`, `year`, `revenue`, `cost`) values('4','2000 East SDTV Sales','East','SDTV','2000','721100','411040');
insert into `report_sample_sales` (`id`, `name`, `division`, `product`, `year`, `revenue`, `cost`) values('5','2001 West HDTV Sales','West','HDTV','2001','668900','310290');
insert into `report_sample_sales` (`id`, `name`, `division`, `product`, `year`, `revenue`, `cost`) values('6','2001 East HDTV Sales','East','HDTV','2001','550390','290380');
insert into `report_sample_sales` (`id`, `name`, `division`, `product`, `year`, `revenue`, `cost`) values('7','2001 West SDTV Sales','West','SDTV','2001','769100','430400');
insert into `report_sample_sales` (`id`, `name`, `division`, `product`, `year`, `revenue`, `cost`) values('8','2001 East SDTV Sales','East','SDTV','2001','621100','311040');
insert into `report_sample_sales` (`id`, `name`, `division`, `product`, `year`, `revenue`, `cost`) values('9','2002 West HDTV Sales','West','HDTV','2002','768900','410290');
insert into `report_sample_sales` (`id`, `name`, `division`, `product`, `year`, `revenue`, `cost`) values('10','2002 East HDTV Sales','East','HDTV','2002','650390','390380');
insert into `report_sample_sales` (`id`, `name`, `division`, `product`, `year`, `revenue`, `cost`) values('11','2002 West SDTV Sales','West','SDTV','2002','669100','330400');
insert into `report_sample_sales` (`id`, `name`, `division`, `product`, `year`, `revenue`, `cost`) values('12','2002 East SDTV Sales','East','SDTV','2002','512200','211040');

DROP TABLE IF EXISTS `report_sample_prod`;
CREATE TABLE `report_sample_prod` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `sku` varchar(64) NOT NULL,
   `name` varchar(100) NOT NULL,
   `description` varchar(255) NOT NULL,
   PRIMARY KEY (`id`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

insert  into `report_sample_prod` (`id`, `sku`, `name`, `description`) values('1','HD-1','HDTV','High Definition Television');
insert  into `report_sample_prod` (`id`, `sku`, `name`, `description`) values('2','SD-1','SDTV','Standard Definition Television');

DROP TABLE IF EXISTS `report_sample_prod_price`;
CREATE TABLE `report_sample_prod_price` (
   `id` INT(11) NOT NULL AUTO_INCREMENT,
   `sku` VARCHAR(64) NOT NULL,
   `price` FLOAT NOT NULL,
   `currency` VARCHAR(10) NOT NULL,
   PRIMARY KEY (`id`)
 ) ENGINE=MYISAM DEFAULT CHARSET=utf8;
 
insert  into `report_sample_prod_price` (`id`, `sku`, `price`, `currency`) values('1','HD-1','1200','USD');
insert  into `report_sample_prod_price` (`id`, `sku`, `price`, `currency`) values('2','SD-1','800','USD');