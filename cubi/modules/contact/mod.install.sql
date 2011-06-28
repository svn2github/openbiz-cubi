
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
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;


INSERT INTO `contact` (`id`, `first_name`, `last_name`, `display_name`, `company`, `department`, `position`, `fast_index`, `photo`, `phone`, `mobile`, `fax`, `zipcode`, `province`, `city`, `street`, `country`, `email`, `webpage`, `qq`, `icq`, `skype`, `yahoo`, `misc`, `type_id`, `sortorder`, `user_id`, `published`, `default`, `access`, `params`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'Rocky', 'Swen', 'Rocky, Swen', 'Openbiz LLC', 'Management', 'CEO', 'J', '/files/upload/contact/20100524200309-RockySwen.jpg', '', '', '', '', 'CA', '', '', 'USA', '', '', '', '', '', '', NULL, 1, 50, 0, 1, 0, NULL, NULL, 1, '2010-05-24 08:00:01', 1, '2010-05-24 20:03:09'),
(2, 'Jixian', 'Wang', 'Jixian, Wang', 'Openbiz LLC', 'Management', 'CTO', 'R', '/files/upload/contact/20100524200245-skype.jpg', '+86 10 6497 9191', '+86 139 1015 4220', '+86 10 6497 9191', '100101', 'Beijing', 'Beijing', 'Chaoyang Yayuncun', 'China', 'jixian2003@qq.com', 'http://www.czm.cn/', '315824246', '', 'jixianwang', '', 'Hosting Company CEO\r\n#1 fadsf\r\nadfasdf', 1, 50, 0, 1, 0, NULL, NULL, 1, '2010-05-24 08:41:57', 1, '2010-05-24 20:02:45'),
(3, 'Wang', 'Ou', 'Wang, Ou', 'Openbiz LLC', 'Design Dept', 'Designer', 'W', '/files/upload/contact/20100524200233-WangOu.jpg', '+86 10 64979191', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, 50, 0, 1, 0, NULL, NULL, 1, '2010-05-24 08:43:41', 1, '2010-06-12 04:02:29'),
(4, 'test', 'li', 'test, li', 'jixian llc', 'sdf', 'jixian', 't', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, 50, 0, 1, 0, NULL, NULL, 1, '2010-06-13 10:52:00', 1, '2010-06-13 10:52:00');


DROP TABLE IF EXISTS `contact_type`;
CREATE TABLE IF NOT EXISTS `contact_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sortorder` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;


INSERT INTO `contact_type` (`id`, `name`, `description`, `sortorder`, `published`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'Business', 'Business Contacts', 45, 1, 1, '2010-05-23 01:09:06', 1, '2010-05-23 18:47:14'),
(2, 'Family', 'Family Contacts', 45, 1, 1, '2010-05-23 01:23:04', 1, '2010-05-24 18:51:35'),
(3, 'Provider', 'Business Provider Contacts', 50, 1, 1, '2010-05-23 01:34:12', 1, '2010-05-24 02:41:09'),
(4, 'Client', 'Business Client Contacts', 45, 1, 1, '2010-05-23 01:34:39', 1, '2010-05-24 11:10:32');
