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
