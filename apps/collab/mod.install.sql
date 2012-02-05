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

DROP TABLE IF EXISTS `task_event`;
CREATE TABLE `task_event` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `task_id` int(10) unsigned NOT NULL default '0',
  `event_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `task_id` (`task_id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `note_type`;
CREATE TABLE `note_type` (
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

INSERT INTO `note_type` (`id`, `name`, `color`,`description`, `sortorder`, `published`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'Business', '66c2ff', 'Business Contacts', 45, 1, 1, '2010-05-23 01:09:06', 1, '2010-05-23 18:47:14'),
(2, 'Family', 'ff7aa0', 'Family Contacts', 45, 1, 1, '2010-05-23 01:23:04', 1, '2010-05-24 18:51:35'),
(3, 'Provider', '7fff7f', 'Business Provider Contacts', 50, 1, 1, '2010-05-23 01:34:12', 1, '2010-05-24 02:41:09'),
(4, 'Client', 'ffd042','Business Client Contacts', 45, 1, 1, '2010-05-23 01:34:39', 1, '2010-05-24 11:10:32');

DROP TABLE IF EXISTS `note`;
CREATE TABLE `note` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) default '',
  `description` text NOT NULL,
  `position` varchar(255) NOT NULL,
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

/*
MySQL Data Transfer
Source Host: localhost
Source Database: cubi
Target Host: localhost
Target Database: cubi
Date: 2010-8-16 11:51:26
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for tasks
-- ----------------------------
DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `id` int(11) NOT NULL auto_increment,
  `subject` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text default NULL,
  
  `all_day` int(2) default NULL,
  `start_time` datetime default NULL,
  `end_time` datetime default NULL,
    
  `type_id` int(11) default NULL,    
  `recurrence` INT( 2 ) NULL DEFAULT '0', 
  
  `reminder` int(2) default 1,
  `reminder_time` int(2) default 15,
  `reminder_method_sms` int(2) default 15,
  `reminder_method_email` int(2) default 15,
  `reminder_method_systray` int(2) default 15,
  
  `notify_contacts` int(2) default 1,
  `notify_contacts_time` int(2) default 60,
  `notify_contacts_sms` int(2) default 1,
  `notify_contacts_email` int(2) default 1,
  
  `sortorder` int(11) default NULL,
  `owner_id` int(11) default 0,
  `group_id` int(11) default 0,
  `group_perm` INT(11) NULL,
  `other_perm` INT(11) NULL,
  
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------


SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for event_type
-- ----------------------------
DROP TABLE IF EXISTS `event_type`;
CREATE TABLE `event_type` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sortorder` int(11) NOT NULL,  
  `published` int(11) NOT NULL,
  `color` VARCHAR( 255 ) default NULL,   
  `group_id` int(11) default 0,
  `group_perm` INT(11) NULL,
  `other_perm` INT(11) NULL,  
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------

INSERT INTO `event_type` (`id`, `name`, `description`, `sortorder`, `published`, `color`, `group_id`, `group_perm`, `other_perm`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'Business', 'Business', 50, 1, '66c2ff', 1, 1, 1, 1, '2010-07-28 11:51:16', 1, '2011-12-02 00:01:40'),
(2, 'Competition', 'Competition', 50, 1, 'ff5252', 1, 1, 1, 1, '2010-07-29 06:49:13', 1, '2011-12-02 00:02:23'),
(3, 'Gifts', 'Gifts', 50, 1, 'ff6bd8', 1, 1, 1, 1, '2010-07-29 06:49:50', 1, '2011-12-02 00:05:12'),
(4, 'Holiday', 'Holiday', 50, 1, '97ff6e', 1, 1, 1, 1, '2010-07-29 06:50:10', 1, '2011-12-02 00:08:13'),
(5, 'Key Customer', 'Key Customer', 50, 1, '7587ff', 1, 1, 1, 1, '2010-07-29 06:50:54', 1, '2011-12-02 00:13:14'),
(6, 'Miscellaneous', 'Miscellaneous', 50, 1, 'addeff', 1, 1, 1, 1, '2010-07-29 06:51:02', 1, '2011-12-02 00:13:25'),
(7, 'Personal', 'Personal', 50, 1, 'ffec8a', 1, 1, 1, 1, '2010-07-29 06:51:10', 1, '2011-12-02 00:12:33');

 
update `event` set `group_id`=1,`group_perm`=1,`other_perm`=0;
update `event_type` set `group_id`=1,`group_perm`=1,`other_perm`=0;


DROP TABLE IF EXISTS `event_contact`;
CREATE TABLE `event_contact` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `event_id` int(10) unsigned NOT NULL default '0',
  `contact_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `event_id` (`event_id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `bookmark_type`;
CREATE TABLE `bookmark_type` (
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


INSERT INTO `bookmark_type` (`id`, `name`, `description`, `color`, `sortorder`, `published`, `group_id`, `group_perm`, `other_perm`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'Project', 'Our product''s websites', '66c2ff', 45, 1, 1, 1, 1, 1, '2010-05-23 01:09:06', 1, '2012-02-05 12:20:01'),
(2, 'Resources', 'Useful resources like design resources, pictures, icons etc', 'ff7aa0', 45, 1, 1, 1, 1, 1, '2010-05-23 01:23:04', 1, '2012-02-05 12:18:47'),
(3, 'Utilities', 'Other utilities websites, like traffic analytisc, button generator etc.', '7fff7f', 50, 1, 1, 1, 1, 1, '2010-05-23 01:34:12', 1, '2012-02-05 12:21:42'),
(4, 'Reference', 'Reference docusments, like w3c docs, php docs etc', 'ffd042', 45, 1, 1, 1, 1, 1, '2010-05-23 01:34:39', 1, '2012-02-05 12:19:24'),
(5, 'System', 'Other system''s link. like tax reporting system. government agency website', '96f8ff', 50, 1, 1, 1, 1, 1, '2012-02-05 12:23:01', 1, '2012-02-05 12:23:15');


DROP TABLE IF EXISTS `bookmark`;
CREATE TABLE `bookmark` (
  `id` int(11) NOT NULL auto_increment,
  `icon` varchar(255) default '',
  `title` varchar(255) default '',
  `description` text NOT NULL,
  `url` varchar(255) NOT NULL,
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

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `announcement_type`;
CREATE TABLE `announcement_type` (
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

INSERT INTO `announcement_type` (`id`, `name`,`color`, `description`, `sortorder`, `published`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'Business', '6622ff','Business Announcements', 45, 1, 1, '2010-05-23 01:09:06', 1, '2010-05-23 18:47:14'),
(2, 'Family', 'ff7aa0','Family Announcements', 45, 1, 1, '2010-05-23 01:23:04', 1, '2010-05-24 18:51:35'),
(3, 'Provider', '7fff7f','Business Provider Announcements', 50, 1, 1, '2010-05-23 01:34:12', 1, '2010-05-24 02:41:09'),
(4, 'Client','ffd042', 'Business Client Announcements', 45, 1, 1, '2010-05-23 01:34:39', 1, '2010-05-24 11:10:32');

DROP TABLE IF EXISTS `announcement`;
CREATE TABLE `announcement` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) default '',
  `description` text NOT NULL,
  `content` text NOT NULL,
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


DROP TABLE IF EXISTS `announcement_read_log`;
CREATE TABLE `announcement_read_log` (
  `id` int(11) NOT NULL auto_increment,
  `announcement_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `view_count` int(11) default 0,
  `create_time` datetime NOT NULL,  
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `document_type`;
CREATE TABLE `document_type` (
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


INSERT INTO `document_type` (`id`, `name`, `description`, `color`, `sortorder`, `published`, `group_id`, `group_perm`, `other_perm`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'General', 'General type of documents', '66c2ff', 45, 1, 1, 1, 1, 1, '2010-05-23 01:09:06', 1, '2012-02-05 09:12:57'),
(2, 'Report', 'Report documents', 'ff7aa0', 45, 1, 1, 1, 1, 1, '2010-05-23 01:23:04', 1, '2012-02-05 09:12:43'),
(3, 'Policy', 'Company management policy', '7fff7f', 50, 1, 1, 1, 1, 1, '2010-05-23 01:34:12', 1, '2012-02-05 09:25:53'),
(4, 'Idea', 'Some ideas', 'ffd042', 45, 1, 1, 1, 1, 1, '2010-05-23 01:34:39', 1, '2012-02-05 09:13:57'),
(5, 'Work', 'Worklog detailed documentation', 'fca4f9', 50, 1, 1, 1, 1, 1, '2012-02-05 20:15:33', 1, '2012-02-05 12:16:11');

DROP TABLE IF EXISTS `document`;
CREATE TABLE `document` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) default '',
  `description` text NOT NULL,
  `content` longtext NOT NULL,
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


DROP TABLE IF EXISTS `document_reversion`;
CREATE TABLE `document_reversion` (
  `id` int(11) NOT NULL auto_increment,
  `document_id` int(11) NOT NULL,
  `reversion` int(11) NOT NULL,
  `title` varchar(255) default '',
  `description` text NOT NULL,
  `content` text NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*
MySQL Data Transfer
Source Host: localhost
Source Database: cubi
Target Host: localhost
Target Database: cubi
Date: 2010-8-16 11:51:10
*/

SET FOREIGN_KEY_CHECKS=0;


/*
Tables for msgbox module
*/

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `content` text,
  `send_status` ENUM( 'sent', 'draft' ) NOT NULL DEFAULT 'draft',
  `deleted_flag` INT NOT NULL DEFAULT '0',
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



DROP TABLE IF EXISTS `message_read_log`;
CREATE TABLE IF NOT EXISTS `message_read_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `view_count` int(11) NOT NULL DEFAULT '0',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `message_recipient`;
CREATE TABLE IF NOT EXISTS `message_recipient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `read_status` ENUM( 'Unread', 'Read', 'Replied' ) NOT NULL,
  `deleted_flag` INT NOT NULL DEFAULT '0',
  `importance` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `type` ENUM(  'Recipient',  'CC',  'BCC' ) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `sent_time` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `message_type`;
CREATE TABLE IF NOT EXISTS `message_type` (
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

INSERT INTO `message_type` (`id`, `name`, `description`, `color`, `sortorder`, `published`, `group_id`, `group_perm`, `other_perm`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'Business', 'Business Bookmarks', '66c2ff', 45, 1, 1, 1, 1, 1, '2010-05-23 01:09:06', 1, '2010-05-23 18:47:14'),
(2, 'Family', 'Family Bookmarks', 'ff7aa0', 45, 1, 1, 1, 1, 1, '2010-05-23 01:23:04', 1, '2010-05-24 18:51:35'),
(3, 'Provider', 'Business Provider Bookmarks', '7fff7f', 50, 1, 1, 1, 1, 1, '2010-05-23 01:34:12', 1, '2010-05-24 02:41:09'),
(4, 'Client', 'Business Client Bookmarks', 'ffd042', 45, 1, 1, 1, 1, 1, '2010-05-23 01:34:39', 1, '2010-05-24 11:10:32');

/*
table structure changes for support task and events email reminder feature 
*/
ALTER TABLE `task` ADD `reminder_status` INT NOT NULL DEFAULT '0' AFTER `reminder`;
ALTER TABLE `event` ADD `reminder_status` INT NOT NULL DEFAULT '0' AFTER `reminder`;
ALTER TABLE `event` ADD `notify_contacts_status` INT NOT NULL DEFAULT '0' AFTER `notify_contacts`;
ALTER TABLE `event` ADD `reminder_lasttime` DATETIME NOT NULL AFTER  `reminder`;
ALTER TABLE `event` ADD `notify_contacts_lasttime` DATETIME NOT NULL AFTER  `notify_contacts`;

/*
added system cronjob
*/

INSERT INTO `cronjob` ( `name`, `minute`, `hour`, `day`, `month`, `weekday`, `command`, `sendmail`, `max_run`, `num_run`, `description`, `status`, `last_exec`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
( 'Trigger Collab Reminder', '*', '*', '*', '*', '*', '{APP_HOME}/bin/cronjob/run_svc.php  collab.lib.ReminderService CheckRemind', '', 1, 0, 'Trigger Collaboration Reminder, It will generate notification emails about planned task and events.', 1, NULL, 1, '2012-01-12 18:41:03', 1, '2012-01-12 18:41:03');

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


insert  into `role`(`name`,`description`,`status`,`default`,`startpage`) values ('Collaboration Admin','Collaboration system administrator',1,0,'/collab/dashboard');
insert  into `role`(`name`,`description`,`status`,`default`,`startpage`) values ('Collaboration Member','General Collaboration system member',1,1,'/collab/dashboard');