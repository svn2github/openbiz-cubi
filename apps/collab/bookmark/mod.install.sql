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
