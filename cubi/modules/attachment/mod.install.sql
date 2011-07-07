DROP TABLE IF EXISTS `attachment`;
CREATE TABLE `attachment` (
  `id` int(11) NOT NULL auto_increment,
  `type` varchar(255) default '',
  `foreign_id` int(11) NOT NULL,
  `title` varchar(255) default '',
  `description` text NOT NULL,  
  
  `path` varchar(255) default '',
  `url` varchar(255) default '',
  `filename` varchar(255) default '',
  `filesize` int(11) default '0',
  `md5` varchar(255) default '',
  `sha256` varchar(255) default '',
  `download_count` int(11) default '0',
  
  `group_id` INT(11) default '1',
  `group_perm` INT(11) default '1',
  `other_perm` INT(11) default '1' ,
  
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `attachment_download_log`;
CREATE TABLE `attachment_download_log` (
  `id` int(11) NOT NULL auto_increment,
  `attachment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;