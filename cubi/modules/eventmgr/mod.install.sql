/*Table structure for table `event_observer` */

DROP TABLE `event_observer`;

CREATE TABLE `event_observer` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64) NOT NULL,
  `observer_name` VARCHAR(64) NOT NULL,
  `module` VARCHAR(64) NOT NULL,
  `event_target` VARCHAR(64) NOT NULL,
  `event_name` VARCHAR(64) NOT NULL,
  `priority` INT(11) DEFAULT '10',  
  `status` INT(2) DEFAULT '1',
  `create_by` INT(10) DEFAULT '1',
  `create_time` DATETIME DEFAULT NULL,
  `update_by` INT(10) DEFAULT '1',
  `update_time` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `event_target` (`event_target`),
  KEY `event_name` (`event_name`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;