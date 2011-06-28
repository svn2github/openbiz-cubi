ALTER TABLE `group` ADD `status` INT( 2 ) NULL AFTER `default` ,
ADD `create_by` INT NULL default 1 AFTER `status` ,
ADD `create_time` DATETIME NULL AFTER `create_by` ,
ADD `update_by` INT NULL default 1 AFTER `create_time` ,
ADD `update_time` DATETIME NULL AFTER `update_by` ;


ALTER TABLE `role` ADD `create_by` INT NULL default 1 AFTER `startpage` ,
ADD `create_time` DATETIME NOT NULL AFTER `create_by` ,
ADD `update_by` INT NULL default 1 AFTER `create_time` ,
ADD `update_time` DATETIME NOT NULL AFTER `update_by` ;

