DROP TABLE  IF EXISTS `lic_actcode`;
CREATE TABLE `lic_actcode` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `activation_code` VARCHAR(64) NOT NULL,
  `sku` VARCHAR(64) NOT NULL,
  `policy_id` INT(11) NOT NULL, 
  `contact_id` int(11) DEFAULT NULL,
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
  `license_key` VARCHAR(128) NOT NULL,
  `sku` VARCHAR(64) NOT NULL,
  `contact_id` INT(11)  NOT NULL,
  `policy_id` INT(11)  NOT NULL,
  `activation_code` VARCHAR(64) NOT NULL,
  `status` INT(2) DEFAULT 1,
  `description` VARCHAR(255) DEFAULT '',
  `start_time` DATETIME DEFAULT NULL,
  `end_time` DATETIME DEFAULT NULL,
  `license_data` TEXT DEFAULT NULL,
  `server_domain`  VARCHAR(128) DEFAULT NULL,
  `server_ip`  VARCHAR(64) DEFAULT NULL,
  `server_data`  TEXT DEFAULT NULL,
  `create_by` INT(11) DEFAULT '1',
  `create_time` DATETIME DEFAULT NULL,
  `update_by` INT(11) DEFAULT '1',
  `update_time` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`license_key`),
  KEY (`activation_code`),
  KEY (`sku`),
  KEY (`contact_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lic_policy`;
CREATE TABLE `lic_policy` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64) NOT NULL,
  `time_limit` int(11) NOT NULL DEFAULT '0',
  `limit_server` int(2) NOT NULL DEFAULT '0',
  `limit_domain` int(2) NOT NULL DEFAULT '0',
  `limit_ip` int(2) DEFAULT '0',
  `cust_properties` varchar(255) DEFAULT NULL,
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
  `status` INT(2) DEFAULT '1',
  `description` VARCHAR(255) DEFAULT '',
  `create_by` INT(11) DEFAULT '1',
  `create_time` DATETIME DEFAULT NULL,
  `update_by` INT(11) DEFAULT '1',
  `update_time` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`sku`),
  KEY `name` (`name`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `product_attr`;
CREATE TABLE `product_attr` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `product_id` INT(11) NOT NULL,
  `name` VARCHAR(64) NOT NULL,
  `value` VARCHAR(255) NOT NULL,
  `type_id` INT(11) DEFAULT 0,
  `description` VARCHAR(255) DEFAULT '',
  `create_by` INT(11) DEFAULT '1',
  `create_time` DATETIME DEFAULT NULL,
  `update_by` INT(11) DEFAULT '1',
  `update_time` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY (`product_id`),
  KEY (`name`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;  

DROP TABLE IF EXISTS `product_attr_type`;
CREATE TABLE `product_attr_type` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `product_id` INT(11) NOT NULL,
  `name` VARCHAR(64) NOT NULL, # price, dimension, color, lang, class, 
  `value` VARCHAR(255) NOT NULL,
  `create_by` INT(11) DEFAULT '1',
  `create_time` DATETIME DEFAULT NULL,
  `update_by` INT(11) DEFAULT '1',
  `update_time` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY (`product_id`),
  KEY (`name`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8; 