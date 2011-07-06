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
