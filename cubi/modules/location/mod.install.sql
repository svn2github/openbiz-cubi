DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `id` int(11) NOT NULL auto_increment,
  `type` varchar(255) default '',
  `foreign_id` int(11) NOT NULL,
  `title` varchar(255) default '',
  `address` varchar(255) DEFAULT '',
  `description` text NOT NULL,  
  
  `longtitude` varchar(255) default '',
  `latitude` varchar(255) default '',
  
  `group_id` INT(11) default '1',
  `group_perm` INT(11) default '1',
  `other_perm` INT(11) default '1' ,
  
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
