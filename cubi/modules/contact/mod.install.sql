DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT '',
  `position` varchar(255) DEFAULT '',
  `fast_index` varchar(10) DEFAULT '',
  `photo` varchar(255) DEFAULT '',
  `phone` varchar(255) DEFAULT '',
  `mobile` varchar(255) DEFAULT '',
  `fax` varchar(255) DEFAULT '',
  `zipcode` varchar(255) DEFAULT '',
  `province` varchar(255) DEFAULT '',
  `city` varchar(255) DEFAULT '',
  `street` varchar(255) DEFAULT '',
  `country` varchar(255) DEFAULT '',
  `email` varchar(255) DEFAULT '',
  `webpage` varchar(255) NOT NULL DEFAULT '',
  `qq` varchar(255) DEFAULT '',
  `icq` varchar(255) DEFAULT '',
  `skype` varchar(255) DEFAULT '',
  `yahoo` varchar(255) DEFAULT '',
  `misc` text,
  `type_id` int(11) NOT NULL,
  `sortorder` int(11) NOT NULL,
  `user_id` int(11) DEFAULT '0',
  `published` int(11) NOT NULL DEFAULT '0',
  `default` int(11) DEFAULT '0',
  `access` varchar(255) DEFAULT NULL,
  `params` text,
  `foreign_key` varchar(255) default '',
  `source` VARCHAR(255) NULL,
  `owner_id` int(11) default 0,
  `group_id` int(11) default 0,
  `group_perm` INT(11) NULL,
  `other_perm` INT(11) NULL,
    
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;


INSERT INTO `contact` (`id`, `first_name`, `last_name`, `display_name`, `company`, `department`, `position`, `fast_index`, `photo`, `phone`, `mobile`, `fax`, `zipcode`, `province`, `city`, `street`, `country`, `email`, `webpage`, `qq`, `icq`, `skype`, `yahoo`, `misc`, `type_id`, `sortorder`, `user_id`, `published`, `default`, `access`, `params`, `foreign_key`, `source`, `owner_id`, `group_id`, `group_perm`, `other_perm`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'Rocky', 'Swen', 'Rocky, Swen', 'Openbiz LLC', 'Management', 'CEO', 'J', '/files/upload/contact/20100524200309-RockySwen.jpg', '', '', '', '', 'CA', '', '', 'USA', '', '', '', '', '', '', NULL, 1, 50, 0, 1, 0, NULL, NULL, '', NULL, 1, 1, 1, 0, 1, '2010-05-24 08:00:01', 1, '2011-12-01 18:14:00'),
(2, 'Jixian', 'Wang', 'Jixian, Wang', 'Openbiz LLC', 'Management', 'CTO', 'R', '/files/upload/contact/20100524200245-skype.jpg', '+86 10 6497 9191', '+86 139 1015 4220', '+86 10 6497 9191', '100101', 'Beijing', 'Beijing', 'Chaoyang Yayuncun', 'China', 'jixian2003@qq.com', 'http://www.czm.cn/', '315824246', '', 'jixianwang', '', 'Hosting Company CEO\r\n#1 fadsf\r\nadfasdf', 1, 50, 0, 1, 0, NULL, NULL, '', NULL, 1, 1, 1, 0, 1, '2010-05-24 08:41:57', 1, '2011-12-01 18:14:00'),
(3, 'Wang', 'Ou', 'Wang, Ou', 'Openbiz LLC', 'Design Dept', 'Designer', 'W', '/files/upload/contact/20100524200233-WangOu.jpg', '+86 10 64979191', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, 50, 0, 1, 0, NULL, NULL, '', NULL, 1, 1, 1, 0, 1, '2010-05-24 08:43:41', 1, '2011-12-01 18:14:00'),
(4, 'test', 'li', 'test, li', 'jixian llc', 'sdf', 'jixian', 't', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, 50, 0, 1, 0, NULL, NULL, '', NULL, 1, 1, 1, 0, 1, '2010-06-13 10:52:00', 1, '2011-12-01 18:14:00'),
(5, 'Jixian', 'Wang', 'Jixian, Wang', 'Openbiz', 'Tech Dept', 'CTO', 'a', '', '', '', '', '', '', '', '', '', 'admin@yourcompany.com', '', '', '', '', '', NULL, 1, 50, 1, 1, 0, NULL, NULL, '', NULL, 1, 1, 1, 0, 1, '2011-12-01 22:57:24', 1, '2011-12-01 23:02:20');


DROP TABLE IF EXISTS `contact_type`;
CREATE TABLE IF NOT EXISTS `contact_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(255) NOT NULL,
  `sortorder` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `group_id` INT(11) NULL,
  `group_perm` INT(11) NULL,
  `other_perm` INT(11) NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `contact_type` (`id`, `name`, `description`, `color`, `sortorder`, `published`, `group_id`, `group_perm`, `other_perm`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'Business', 'Business Contacts', '66c2ff', 45, 1, 1, 1, 0, 1, '2010-05-23 01:09:06', 1, '2011-12-01 23:50:48'),
(2, 'Family', 'Family Contacts', 'ff7aa0', 45, 1, 1, 1, 0, 1, '2010-05-23 01:23:04', 1, '2011-12-01 23:50:39'),
(3, 'Provider', 'Business Provider Contacts', '7fff7f', 50, 1, 1, 1, 0, 1, '2010-05-23 01:34:12', 1, '2011-12-01 23:51:11'),
(4, 'Client', 'Business Client Contacts', 'ffd042', 45, 1, 1, 1, 0, 1, '2010-05-23 01:34:39', 1, '2011-12-01 23:51:01');

DROP TABLE IF EXISTS `contact_import`;
CREATE TABLE IF NOT EXISTS `contact_import` (
  `id` int(11) NOT NULL auto_increment,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `department` varchar(255) default '',
  `position` varchar(255) default '',
  `fast_index` varchar(10) default '',
  `photo` varchar(255) default '',
  `phone` varchar(255) default '',
  `mobile` varchar(255) default '',
  `fax` varchar(255) default '',
  `zipcode` varchar(255) default '',
  `province` varchar(255) default '',
  `city` varchar(255) default '',
  `street` varchar(255) default '',
  `country` varchar(255) default '',
  `email` varchar(255) default '',
  `webpage` varchar(255) NOT NULL default '',
  `qq` varchar(255) default '',
  `icq` varchar(255) default '',
  `skype` varchar(255) default '',
  `yahoo` varchar(255) default '',
  `user_id` int(11) default '0',
  `selected` int(11) default '0',
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=Memory  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

update `contact` set `group_id`=1,`group_perm`=1,`other_perm`=0;
update `contact_type` set `group_id`=1,`group_perm`=1,`other_perm`=0;
update `contact` set `owner_id`=`create_by`;