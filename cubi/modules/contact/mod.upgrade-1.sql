ALTER TABLE `contact_type` ADD `color` VARCHAR( 255 ) NOT NULL AFTER `description` ;
ALTER TABLE `contact` ADD `foreign_key` varchar(255) default '' AFTER `params` ;
ALTER TABLE `contact` ADD COLUMN `source` VARCHAR(255) NULL  AFTER `foreign_key` ;
ALTER TABLE `contact` ADD COLUMN `owner_id` int(11) default 0  AFTER `source` , 
					  ADD COLUMN `group_id` INT(11) NULL  AFTER `owner_id` , 
					  ADD COLUMN `group_perm` INT(11) NULL  AFTER `group_id` , 
					  ADD COLUMN `other_perm` INT(11) NULL  AFTER `group_perm` ;
ALTER TABLE `contact_type` ADD COLUMN `group_id` INT(11) NULL  AFTER `published` , 
					  ADD COLUMN `group_perm` INT(11) NULL  AFTER `group_id` , 
					  ADD COLUMN `other_perm` INT(11) NULL  AFTER `group_perm` ;

update `contact` set `group_id`=1,`group_perm`=1,`other_perm`=0;
update `contact_type` set `group_id`=1,`group_perm`=1,`other_perm`=0;
update `contact` set `owner_id`=`create_by`;

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
