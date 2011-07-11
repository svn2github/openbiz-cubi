/*Table structure for table `trac_attachment` */

DROP TABLE IF EXISTS `trac_attachment`;

CREATE TABLE `trac_attachment` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` varchar(30) default NULL,
  `filename` varchar(50) NOT NULL,
  `type` varchar(30) default NULL,
  `size` int(11) default NULL,
  `time` datetime default NULL,
  `description` varchar(255) default NULL,
  `author_id` int(11) default NULL,
  `ipnr` varchar(30) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `trac_comments` */

DROP TABLE IF EXISTS `trac_comments`;

CREATE TABLE `trac_comments` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL,
  `create_time` datetime default NULL,
  `author_id` int(11) default NULL,
  `comments` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `trac_component` */

DROP TABLE IF EXISTS `trac_component`;

CREATE TABLE `trac_component` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) NOT NULL default '',
  `product_id` int(11) NOT NULL,
  `owner_id` int(11) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `trac_enum` */

DROP TABLE IF EXISTS `trac_enum`;

CREATE TABLE `trac_enum` (
  `id` int(11) NOT NULL auto_increment,
  `type` varchar(30) default NULL,
  `name` varchar(50) default NULL,
  `value` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `trac_milestone` */

DROP TABLE IF EXISTS `trac_milestone`;

CREATE TABLE `trac_milestone` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) NOT NULL default '',
  `due` datetime default NULL,
  `completed` datetime default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `trac_product` */

DROP TABLE IF EXISTS `trac_product`;

CREATE TABLE `trac_product` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) NOT NULL default '',
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `trac_ticket` */

DROP TABLE IF EXISTS `trac_ticket`;

CREATE TABLE `trac_ticket` (
  `id` int(11) NOT NULL auto_increment,
  `type` varchar(30) default NULL,
  `time` datetime default NULL,
  `changetime` datetime default NULL,
  `product_id` int(11) default NULL,
  `component_id` int(11) default NULL,
  `severity` varchar(30) default NULL,
  `priority` varchar(30) default NULL,
  `owner_id` int(11) default NULL,
  `reporter_id` int(11) default NULL,
  `cc` varchar(255) default NULL,
  `version_id` int(11) default NULL,
  `milestone_id` int(11) default NULL,
  `status` varchar(30) default NULL,
  `resolution` varchar(30) default NULL,
  `summary` varchar(255) default NULL,
  `description` text,
  `keywords` varchar(128) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `trac_query` */

DROP TABLE IF EXISTS `trac_query`;

CREATE TABLE `trac_query` (              
  `id` int(11) NOT NULL auto_increment,  
  `name` varchar(128) NOT NULL,          
  `search_rules` text NOT NULL,          
  `owner_id` int(11) default NULL,       
  `public` int(2) default '0',           
  PRIMARY KEY  (`id`)                    
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `trac_version` */

DROP TABLE IF EXISTS `trac_version`;

CREATE TABLE `trac_version` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `update_time` datetime default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `trac_enum` */

insert  into `trac_enum`(`type`,`name`,`value`) values ('Priority','P0','1');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Priority','P1','2');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Priority','P2','3');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Priority','P3','4');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Priority','P4','5');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Severity','Low','1');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Severity','Mideum','2');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Severity','High','3');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Type','Defect','1');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Type','Feature','2');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Type','Enhancement','3');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Type','Task','4');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Status','Open','1');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Status','Accepted','2');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Status','Reopened','3');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Status','Resolved','4');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Status','Closed','5');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Resolution','Unresolved','1');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Resolution','Fixed','2');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Resolution','Won\'t Fix','3');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Resolution','Duplicated','4');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Resolution','Incomplete','5');
insert  into `trac_enum`(`type`,`name`,`value`) values ('Resolution','Cannot Reproduce','6');

