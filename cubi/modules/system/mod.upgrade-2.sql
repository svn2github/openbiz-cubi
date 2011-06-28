ALTER TABLE  `user` ADD `corp_id` int(10) default NULL AFTER `status`;
ALTER TABLE  `group` ADD `default` int(2) default 0 AFTER `description`;