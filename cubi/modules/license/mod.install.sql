DROP TABLE  IF EXISTS `lic_actcode`;
CREATE TABLE `lic_actcode` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `activation_code` VARCHAR(64) NOT NULL,
  `sku` VARCHAR(64) NOT NULL,
  `policy_id` INT(11) NOT NULL, 
  `start_time` DATETIME DEFAULT NULL,
  `end_time` DATETIME DEFAULT NULL,
  `status` INT(2) DEFAULT '1',
  `max_use` INT(11) DEFAULT '1',
  `cur_use` INT(11) DEFAULT '0',
  `description` VARCHAR(255) DEFAULT '',
  `create_by` INT(11) DEFAULT '1',
  `create_time` DATETIME DEFAULT NULL,
  `update_by` INT(11) DEFAULT '1',
  `update_time` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `activation_code` (`activation_code`),
  KEY `sku` (`sku`),
  KEY `policy_id` (`policy_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `license`;
CREATE TABLE `license` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `sku` VARCHAR(64) NOT NULL,
  `contact_id` INT(11)  NOT NULL,
  `policy_id` INT(11)  NOT NULL,
  `activation_code` VARCHAR(64) NOT NULL,
  `status` INT(2) DEFAULT 1,
  `description` VARCHAR(255) DEFAULT '',
  `start_time` DATETIME DEFAULT NULL,
  `end_time` DATETIME DEFAULT NULL,
  `max_use` INT(11) DEFAULT 1,
  `cur_use` INT(11) DEFAULT 0,
  `create_by` INT(11) DEFAULT '1',
  `create_time` DATETIME DEFAULT NULL,
  `update_by` INT(11) DEFAULT '1',
  `update_time` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY (`activation_code`),
  KEY (`sku`),
  KEY (`contact_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lic_policy`;
CREATE TABLE `lic_policy` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64) NOT NULL,
  `time_limit` INT(11) NOT NULL DEFAULT 0,
  `user_limit` INT(11) NOT NULL DEFAULT 0,
  `server_limit` INT(11) NOT NULL DEFAULT 0,
  `domain_limit` INT(11) NOT NULL DEFAULT 0,
  `create_by` INT(11) DEFAULT '1',
  `create_time` DATETIME DEFAULT NULL,
  `update_by` INT(11) DEFAULT '1',
  `update_time` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;  

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64) NOT NULL,
  `sku` VARCHAR(64) NOT NULL,
  `status` INT(2) DEFAULT 1,
  `description` VARCHAR(255) DEFAULT '',
  `create_by` INT(11) DEFAULT '1',
  `create_time` DATETIME DEFAULT NULL,
  `update_by` INT(11) DEFAULT '1',
  `update_time` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY (`sku`),
  KEY (`name`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;  
