/*Table structure of table `package_master` */

DROP TABLE IF EXISTS `package_master`;

CREATE TABLE `package_master` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `package_id` VARCHAR(64) NOT NULL,
  `name` VARCHAR(64) NOT NULL,
  `type` VARCHAR(64) NOT NULL,
  `cat_id` VARCHAR(64) NOT NULL,
  `version` VARCHAR(64) NOT NULL,
  `pltfm_ver` VARCHAR(64) NOT NULL,
  `author` VARCHAR(128) NOT NULL,
  `file` VARCHAR(255) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `status` INT(2) DEFAULT NULL,
  `release_time` DATETIME DEFAULT NULL,  
  `repository` TEXT DEFAULT NULL,
  `create_by` INT(11) DEFAULT '1',
  `create_time` DATETIME DEFAULT NULL,
  `update_by` INT(11) DEFAULT '1',
  `update_time` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `package_id` (`package_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;

/*Table structure of table `package_category` */

DROP TABLE IF EXISTS `package_category`;

CREATE TABLE `package_category` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `parent_id` INT(11) DEFAULT NULL,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `attrs` TEXT DEFAULT NULL,
  `publish` INT(11) DEFAULT NULL,
  `sort_order` INT(11) NOT NULL DEFAULT '10',
  `create_time` DATETIME DEFAULT NULL,
  `create_by` INT(11) DEFAULT NULL,
  `update_time` DATETIME DEFAULT NULL,
  `update_by` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;