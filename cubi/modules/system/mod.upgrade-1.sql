ALTER TABLE  `role` ADD  `default` int(2) default '0' AFTER  `status`;
ALTER TABLE  `role` ADD INDEX (  `default` );
ALTER TABLE  `role` ADD INDEX (  `status` );