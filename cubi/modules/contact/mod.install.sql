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
(1, 'System', 'Admin', 'System, Admin', 'N/A', '', '', 'J', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, 50, 1, 1, 0, NULL, NULL, '', NULL, 1, 1, 1, 0, 1, '2010-05-24 08:00:01', 1, '2012-02-05 11:08:49');


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
(1, 'Colleague', 'Our company colleague''s contacts', '66c2ff', 45, 1, 1, 1, 1, 1, '2010-05-23 01:09:06', 1, '2012-02-05 10:59:07'),
(2, 'Potential Client', 'Potential clients, People interested buy not start using our product yet.', 'b8ff7d', 45, 1, 1, 1, 1, 1, '2010-05-23 01:23:04', 1, '2012-02-05 11:02:01'),
(3, 'Provider', 'All kind of providers. Like product hardware provider, printing service providers etc.', '7fff7f', 50, 1, 1, 1, 1, 1, '2010-05-23 01:34:12', 1, '2012-02-05 11:03:38'),
(4, 'Existing Client', 'Client who already started using our products.', 'ffd042', 45, 1, 1, 1, 1, 1, '2010-05-23 01:34:39', 1, '2012-02-05 11:02:29'),
(5, 'Government', 'Government department managers contacts', 'fa8282', 50, 1, 1, 1, 1, 1, '2011-12-02 23:11:18', 1, '2012-02-05 10:58:44'),
(6, 'Misc', 'Miscellaneous, Other type of contacts', 'd1d1d1', 50, 1, 1, 1, 1, 1, '2012-02-05 10:56:40', 1, '2012-02-05 10:58:39');


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
  `foreign_key` varchar(255) default '',
  `source` varchar(255) default '',
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=Memory  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

update `contact` set `group_id`=1,`group_perm`=1,`other_perm`=0;
update `contact_type` set `group_id`=1,`group_perm`=1,`other_perm`=0;
update `contact` set `owner_id`=`create_by`;
