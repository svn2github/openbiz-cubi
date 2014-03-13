/*
MySQL Data Transfer
Source Host: localhost
Source Database: cubi
Target Host: localhost
Target Database: cubi
Date: 2010-8-16 11:51:26
*/
DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) default '',
  `description` text NOT NULL,
  `status` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `severity` INT NOT NULL DEFAULT '2' ,
  `milestone` int(11) NOT NULL,
  `progress` int(11) NOT NULL,

  `start_time` datetime NOT NULL,
  `finish_time` datetime NOT NULL,
  `actual_finish_time` datetime NOT NULL,

  `reminder` int(2) default 0,
  `reminder_time` int(2) default 15,
  `reminder_method_sms` int(2) default 15,
  `reminder_method_email` int(2) default 15,
  `reminder_method_systray` int(2) default 15,

  `total_workhour` float(11) NOT NULL,
  `actual_workhour` float(11) NOT NULL,

  `budget_cost` float(11) NOT NULL,
  `actual_cost` float(11) NOT NULL,

  `project_id` int(11) default 0,
  `parent_task_id` int(11) default 0,
  `dependency_task_id` int(11) default 0,
  `type_id` int(11) NOT NULL,
  `owner_id` int(11) default 0,
  `group_id` INT(11) default '1',
  `group_perm` INT(11) default '1',
  `other_perm` INT(11) default '1' ,
  `sortorder` int(11) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `task_type`;
CREATE TABLE IF NOT EXISTS `task_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(255) NOT NULL,
  `sortorder` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `group_id` int(11) DEFAULT '1',
  `group_perm` int(11) DEFAULT '1',
  `other_perm` int(11) DEFAULT '1',
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `task_type` (`id`, `name`, `description`, `color`, `sortorder`, `published`, `group_id`, `group_perm`, `other_perm`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'General', 'General office releated tasks', '66c2ff', 45, 1, 1, 1, 1, 1, '2010-05-23 01:09:06', 1, '2012-01-23 22:34:22'),
(2, 'Enhancement', 'Feature enhancement related releated tasks', '7fff6b', 45, 1, 1, 1, 1, 1, '2010-05-23 01:23:04', 1, '2012-01-23 22:35:57'),
(3, 'New Feature', 'New feature releated tasks', 'ffea5e', 50, 1, 1, 1, 1, 1, '2010-05-23 01:34:12', 1, '2012-01-23 22:36:56'),
(4, 'Bug Fix', 'Bug fix releated tasks', 'ff8f8f', 45, 1, 1, 1, 1, 1, '2010-05-23 01:34:39', 1, '2012-01-23 22:39:40'),
(5, 'Quality Check', 'Quality Check related tasks', 'faaff1', 50, 1, 1, 1, 1, 1, '2012-01-23 22:38:08', 1, '2012-01-23 22:39:52'),
(6, 'Requirement', 'Requirement Collection related tasks', 'd7ffc7', 50, 1, 1, 1, 1, 1, '2012-01-23 22:41:09', 1, '2012-01-23 22:41:35');


DROP TABLE IF EXISTS `task_contact`;
CREATE TABLE `task_contact` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `task_id` int(10) unsigned NOT NULL default '0',
  `contact_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `task_id` (`task_id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `task_document`;
CREATE TABLE `task_document` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `task_id` int(10) unsigned NOT NULL default '0',
  `document_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `task_id` (`task_id`),
  KEY `document_id` (`document_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `task_event`;
CREATE TABLE `task_event` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `task_id` int(10) unsigned NOT NULL default '0',
  `event_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `task_id` (`task_id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `work_log`;
CREATE TABLE `work_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` INT(11) default null,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `worked_hours` float(11) default '0',
  `updated_progress` int(11) default '0',

  `group_id` INT(11) default '1',
  `group_perm` INT(11) default '1',
  `other_perm` INT(11) default '1' ,

  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `work_log_event`;
CREATE TABLE `work_log_event` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `worklog_id` int(10) unsigned NOT NULL default '0',
  `event_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `worklog_id` (`worklog_id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `work_log_document`;
CREATE TABLE `work_log_document` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `worklog_id` int(10) unsigned NOT NULL default '0',
  `document_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `worklog_id` (`worklog_id`),
  KEY `document_id` (`document_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*
table structure changes for support task and events email reminder feature 
*/
ALTER TABLE `task` ADD `reminder_status` INT NOT NULL DEFAULT '0' AFTER `reminder`;

/*
tables for project management
*/

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `project_type`;
CREATE TABLE IF NOT EXISTS `project_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(255) NOT NULL,
  `sortorder` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `group_id` int(11) DEFAULT '1',
  `group_perm` int(11) DEFAULT '1',
  `other_perm` int(11) DEFAULT '1',
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `project_type` (`id`, `name`, `description`, `color`, `sortorder`, `published`, `group_id`, `group_perm`, `other_perm`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'General', 'General Type of Projects', '66c2ff', 45, 1, 1, 1, 1, 1, '2010-05-23 01:09:06', 1, '2012-01-20 15:59:14'),
(2, 'Marketing', 'Marketing and Tradeshows', 'ff7aa0', 45, 1, 1, 1, 1, 1, '2010-05-23 01:23:04', 1, '2012-01-24 01:16:40'),
(3, 'Product', 'Proudct Launch', '7fff7f', 50, 1, 1, 1, 1, 1, '2010-05-23 01:34:12', 1, '2012-01-24 01:17:29'),
(4, 'Press', 'Press Release', 'ffd042', 45, 1, 1, 1, 1, 1, '2010-05-23 01:34:39', 1, '2012-01-24 01:17:05'),
(5, 'Design', 'Design projects like sales brochure', 'ebc9ff', 50, 1, 1, 1, 1, 1, '2012-01-24 01:19:15', 1, '2012-01-24 01:20:52');

DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
`id` int(11) NOT NULL auto_increment,
`name` VARCHAR( 255 ) NOT NULL ,
`description` TEXT NOT NULL ,
`start_time` DATETIME NOT NULL ,
`type_id` INT NOT NULL DEFAULT '1',
`budget_cost` float(11) NOT NULL,
`status` int(11) NOT NULL,
`priority` int(11) NOT NULL,
`condition` INT NULL DEFAULT '0' ,
`sortorder` int(11) NOT NULL,
`owner_id` int(11) default 0,
`group_id` INT(11) default '1',
`group_perm` INT(11) default '1',
`other_perm` INT(11) default '1' ,
`create_by` INT NOT NULL ,
`create_time` DATETIME NOT NULL ,
`update_by` INT NOT NULL ,
`update_time` DATETIME NOT NULL ,
PRIMARY KEY ( `id` ) ,
INDEX ( `name` , `type_id` )
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `project_contact`;
CREATE TABLE `project_contact` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `contact_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `project_event`;
CREATE TABLE `project_event` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `event_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `project_template`;
CREATE TABLE `project_template` (
`id` int(10) unsigned NOT NULL auto_increment,
`name` VARCHAR( 255 ) NOT NULL ,
`description` TEXT NOT NULL ,
`type_id` int(11) NOT NULL,
`sortorder` int(11) NOT NULL,
`group_id` INT(11) default '1',
`group_perm` INT(11) default '1',
`other_perm` INT(11) default '1' ,
`create_by` INT NOT NULL ,
`create_time` DATETIME NOT NULL ,
`update_by` INT NOT NULL ,
`update_time` DATETIME NOT NULL ,
PRIMARY KEY ( `id` ) ,
INDEX ( `name` , `type_id` )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci ;

DROP TABLE IF EXISTS `project_task_template`;
CREATE TABLE `project_task_template` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) default '',
  `description` text NOT NULL,
  `priority` int(11) NOT NULL,
  `severity` INT NOT NULL DEFAULT '2',
  `milestone` int(11) NOT NULL,
  `start_date` int(11) NOT NULL,
  `during_days` int(11) NOT NULL,
  `budget_cost` float(11) NOT NULL,
  `project_id` int(11) default 0,
  `parent_task_id` int(11) default 0,
  `dependency_task_id` int(11) default 0,
  `type_id` int(11) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;   

/*
table for task billing
*/

DROP TABLE IF EXISTS `task_budget`;
CREATE TABLE `task_budget` (
  `id` int(11) NOT NULL auto_increment,
  `type` varchar(255) default '',
  `foreign_id` int(11) NOT NULL,
  `title` varchar(255) default '',
  `description` text NOT NULL,  
  `credit` float(11) NOT NULL,
  `debit` float(11) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `project_document`;
CREATE TABLE `project_document` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `document_id` int(10) unsigned NOT NULL default '0',   
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`),
  KEY `document_id` (`document_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `project_event`;
CREATE TABLE `project_event` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `event_id` int(10) unsigned NOT NULL default '0',   
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;