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

INSERT INTO `note_type` (`id`, `name`, `description`, `sortorder`, `published`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'Business', 'Business Contacts', 45, 1, 1, '2010-05-23 01:09:06', 1, '2010-05-23 18:47:14'),
(2, 'Family', 'Family Contacts', 45, 1, 1, '2010-05-23 01:23:04', 1, '2010-05-24 18:51:35'),
(3, 'Provider', 'Business Provider Contacts', 50, 1, 1, '2010-05-23 01:34:12', 1, '2010-05-24 02:41:09'),
(4, 'Client', 'Business Client Contacts', 45, 1, 1, '2010-05-23 01:34:39', 1, '2010-05-24 11:10:32');

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
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('1', 'Business', 'Business', '50', '1', '1', '2010-07-28 11:51:16', '1', '2010-08-01 07:22:12');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('2', 'Competition', 'Competition', '50', '1', '1', '2010-07-29 06:49:13', '1', '2010-08-01 07:22:15');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('3', 'Favorites', 'Favorites', '50', '1', '1', '2010-07-29 06:49:35', '1', '2010-08-01 07:22:11');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('4', 'Gifts', 'Gifts', '50', '1', '1', '2010-07-29 06:49:50', '1', '2010-08-01 07:22:10');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('5', 'Goals/Objectives', 'Goals/Objectives', '50', '1', '1', '2010-07-29 06:50:00', '1', '2010-07-29 06:50:00');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('6', 'Holiday', 'Holiday', '50', '1', '1', '2010-07-29 06:50:10', '1', '2010-07-29 06:50:10');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('7', 'Holiday Cards', 'Holiday Cards', '50', '1', '1', '2010-07-29 06:50:19', '1', '2010-07-29 06:50:19');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('8', 'Hot Contacts', 'Hot Contacts', '50', '1', '1', '2010-07-29 06:50:27', '1', '2010-07-29 06:50:27');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('9', 'Ideas', 'Ideas', '50', '1', '1', '2010-07-29 06:50:35', '1', '2010-07-29 06:50:35');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('10', 'International', 'International', '50', '1', '1', '2010-07-29 06:50:45', '1', '2010-07-29 06:50:45');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('11', 'Key Customer', 'Key Customer', '50', '1', '1', '2010-07-29 06:50:54', '1', '2010-07-29 06:50:54');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('12', 'Miscellaneous', 'Miscellaneous', '50', '1', '1', '2010-07-29 06:51:02', '1', '2010-07-29 06:51:02');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('13', 'Personal', 'Personal', '50', '1', '1', '2010-07-29 06:51:10', '1', '2010-07-29 06:51:10');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('14', 'Phone Calls', 'Phone Calls', '50', '1', '1', '2010-07-29 06:51:18', '1', '2010-07-29 06:51:18');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('15', 'Status', 'Status', '50', '1', '1', '2010-07-29 06:51:26', '1', '2010-07-29 06:51:26');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('16', 'Strategies', 'Strategies', '50', '1', '1', '2010-07-29 06:51:33', '1', '2010-07-29 06:51:33');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('17', 'Suppliers', 'Suppliers', '50', '1', '1', '2010-07-29 06:51:41', '1', '2010-07-29 06:51:41');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('18', 'Time & Expenses', 'Time & Expenses', '50', '1', '1', '2010-07-29 06:51:50', '1', '2010-07-29 06:51:50');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('19', 'VIP', 'VIP', '50', '1', '1', '2010-07-29 06:52:00', '1', '2010-07-29 06:52:00');
INSERT INTO `event_type` (id,name,description,sortorder,published,create_by,create_time,update_by,update_time) VALUES ('20', 'Waiting', 'Waiting', '50', '1', '1', '2010-07-29 06:52:08', '1', '2010-07-29 06:52:08');

 
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

INSERT INTO `bookmark_type` (`id`, `name`, `description`, `sortorder`, `published`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'Business', 'Business Bookmarks', 45, 1, 1, '2010-05-23 01:09:06', 1, '2010-05-23 18:47:14'),
(2, 'Family', 'Family Bookmarks', 45, 1, 1, '2010-05-23 01:23:04', 1, '2010-05-24 18:51:35'),
(3, 'Provider', 'Business Provider Bookmarks', 50, 1, 1, '2010-05-23 01:34:12', 1, '2010-05-24 02:41:09'),
(4, 'Client', 'Business Client Bookmarks', 45, 1, 1, '2010-05-23 01:34:39', 1, '2010-05-24 11:10:32');

DROP TABLE IF EXISTS `bookmark`;
CREATE TABLE `bookmark` (
  `id` int(11) NOT NULL auto_increment,
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

INSERT INTO `announcement_type` (`id`, `name`, `description`, `sortorder`, `published`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'Business', 'Business Announcements', 45, 1, 1, '2010-05-23 01:09:06', 1, '2010-05-23 18:47:14'),
(2, 'Family', 'Family Announcements', 45, 1, 1, '2010-05-23 01:23:04', 1, '2010-05-24 18:51:35'),
(3, 'Provider', 'Business Provider Announcements', 50, 1, 1, '2010-05-23 01:34:12', 1, '2010-05-24 02:41:09'),
(4, 'Client', 'Business Client Announcements', 45, 1, 1, '2010-05-23 01:34:39', 1, '2010-05-24 11:10:32');

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

INSERT INTO `document_type` (`id`, `name`, `description`, `sortorder`, `published`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'Business', 'Business Documents', 45, 1, 1, '2010-05-23 01:09:06', 1, '2010-05-23 18:47:14'),
(2, 'Family', 'Family Documents', 45, 1, 1, '2010-05-23 01:23:04', 1, '2010-05-24 18:51:35'),
(3, 'Provider', 'Business Provider Documents', 50, 1, 1, '2010-05-23 01:34:12', 1, '2010-05-24 02:41:09'),
(4, 'Client', 'Business Client Documents', 45, 1, 1, '2010-05-23 01:34:39', 1, '2010-05-24 11:10:32');

DROP TABLE IF EXISTS `document`;
CREATE TABLE `document` (
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

/*
MySQL Data Transfer
Source Host: localhost
Source Database: cubi
Target Host: localhost
Target Database: cubi
Date: 2010-8-16 11:51:10
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for messeage
-- ----------------------------
DROP TABLE IF EXISTS `messeage`;
CREATE TABLE `messeage` (
  `id` int(11) NOT NULL auto_increment,
  `subject` varchar(255) NOT NULL,
  `content` varchar(255) default '',
  `from_userid` int(11) default '0',
  `to_userid` int(11) default '0',
  `cc` varchar(64) default '',
  `annex` varchar(255) default NULL,
  `status` enum('0','1','2','3') NOT NULL default '0',
  `is_read` int(11) default '0',
  `datetime` datetime NOT NULL,
  `sortorder` int(11) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
