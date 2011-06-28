DROP TABLE IF EXISTS `widget`;

CREATE TABLE `widget` (                                 
  `name` varchar(100) NOT NULL default '',      
  `module` varchar(100) default NULL,           
  `title` varchar(100) default NULL,                      
  `description` varchar(255) default NULL,
  `configable` tinyint(1) NOT NULL default '0', 
  `published` tinyint(1) NOT NULL default '1', 
  `ordering` INT NOT NULL DEFAULT '10' , 
  `create_by` int(10) default 1,
  `create_time` datetime default NULL,
  `update_by` int(10) default 1,
  `update_time` datetime default NULL,
  PRIMARY KEY  (`name`)                         
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

