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
  `milestone` int(11) NOT NULL,
  `progress` int(11) NOT NULL,

  `start_time` datetime NOT NULL,
  `finish_time` datetime NOT NULL,
  `actual_finish_time` datetime NOT NULL,

  `reminder` int(2) default 1,
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
CREATE TABLE `task_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(255) NOT NULL,
  `sortorder` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `group_id` INT(11) default '1',
  `group_perm` INT(11) default '1',
  `other_perm` INT(11) default '1' ,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO `task_type` (`id`, `name`, `description`, `sortorder`, `published`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'Business', 'Business Contacts', 45, 1, 1, '2010-05-23 01:09:06', 1, '2010-05-23 18:47:14'),
(2, 'Family', 'Family Contacts', 45, 1, 1, '2010-05-23 01:23:04', 1, '2010-05-24 18:51:35'),
(3, 'Provider', 'Business Provider Contacts', 50, 1, 1, '2010-05-23 01:34:12', 1, '2010-05-24 02:41:09'),
(4, 'Client', 'Business Client Contacts', 45, 1, 1, '2010-05-23 01:34:39', 1, '2010-05-24 11:10:32');


DROP TABLE IF EXISTS `task_contact`;
CREATE TABLE `task_contact` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `task_id` int(10) unsigned NOT NULL default '0',
  `contact_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `task_id` (`task_id`),
  KEY `contact_id` (`contact_id`)
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

