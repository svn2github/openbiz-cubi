ALTER TABLE `event_type` ADD `color` VARCHAR( 255 ) NOT NULL AFTER `description` ;
ALTER TABLE `event` ADD `foreign_key` varchar(255) default '' AFTER `sortorder` ;
ALTER TABLE `event` ADD COLUMN `source` VARCHAR(255) NULL  AFTER `foreign_key` ;
ALTER TABLE `event` ADD COLUMN `group_id` INT(11) NULL  AFTER `sortorder` , 
					  ADD COLUMN `group_perm` INT(11) NULL  AFTER `group_id` , 
					  ADD COLUMN `other_perm` INT(11) NULL  AFTER `group_perm` ;
ALTER TABLE `event_type` ADD COLUMN `group_id` INT(11) NULL  AFTER `published` , 
					  ADD COLUMN `group_perm` INT(11) NULL  AFTER `group_id` , 
					  ADD COLUMN `other_perm` INT(11) NULL  AFTER `group_perm` ;

update `event` set `group_id`=1,`group_perm`=1,`other_perm`=0;
update `event_type` set `group_id`=1,`group_perm`=1,`other_perm`=0;
