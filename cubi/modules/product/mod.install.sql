
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