/*Table structure for table `module` */

DROP TABLE IF EXISTS `module_changelog`;

CREATE TABLE `module_changelog` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `module` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `description` varchar(255) default NULL,
  `status` varchar(255) default NULL,
  `type` varchar(255) default NULL,
  `version` varchar(64) default NULL,
  `publish_date` varchar(64) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;