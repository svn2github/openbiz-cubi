/*Table structure of table `websvc` */

DROP TABLE IF EXISTS `websvc`;

CREATE TABLE `websvc` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` VARCHAR(64) NOT NULL,
  `api_key` VARCHAR(255) DEFAULT NULL,
  `secret` VARCHAR(255) DEFAULT NULL,
  `status` INT(2) DEFAULT NULL,
  `description` VARCHAR(255) DEFAULT NULL,
  `create_by` INT(11) DEFAULT '1',
  `create_time` DATETIME DEFAULT NULL,
  `update_by` INT(11) DEFAULT '1',
  `update_time` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;