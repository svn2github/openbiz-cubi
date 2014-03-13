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
(1, 'General', 'General type of events', 50, 1, '66c2ff', 1, 1, 1, 1, '2010-07-28 11:51:16', 1, '2012-02-07 15:14:31'),
(2, 'Deploy', 'Go to clients place deploy products', 50, 1, 'ffa1a1', 1, 1, 1, 1, '2010-07-29 06:49:13', 1, '2012-02-07 15:15:28'),
(3, 'Meeting', 'Meeting clients', 50, 1, 'ffc2f0', 1, 1, 1, 1, '2010-07-29 06:49:50', 1, '2012-02-07 15:14:47'),
(4, 'Presentation', 'Presentation products for clients', 50, 1, 'b2f7ca', 1, 1, 1, 1, '2012-02-07 22:53:15', 1, '2012-02-07 14:53:15'),
(5, 'Personal', 'Personal type of events, like holidays', 50, 1, 'ffec8a', 1, 1, 1, 1, '2010-07-29 06:51:10', 1, '2012-02-07 15:14:59'),
(6, 'Discuss', 'Discuss with colleagues', 50, 1, 'c5d4fa', 1, 1, 1, 1, '2012-02-07 23:31:32', 1, '2012-02-07 15:31:32');

 
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

ALTER TABLE `event` ADD `reminder_status` INT NOT NULL DEFAULT '0' AFTER `reminder`;
ALTER TABLE `event` ADD `notify_contacts_status` INT NOT NULL DEFAULT '0' AFTER `notify_contacts`;
ALTER TABLE `event` ADD `reminder_lasttime` DATETIME NOT NULL AFTER  `reminder`;
ALTER TABLE `event` ADD `notify_contacts_lasttime` DATETIME NOT NULL AFTER  `notify_contacts`;