/*Table structure of table `package_local` */

DROP TABLE IF EXISTS `package_local`;

CREATE TABLE `package_local` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `type` varchar(64) NOT NULL,
  `category` varchar(255) NOT NULL,
  `version` varchar(64) NOT NULL,
  `pltfm_ver` varchar(64) NOT NULL,
  `author` varchar(128) NOT NULL,
  `file` varchar(255) NOT NULL,
  `description` text,
  `status` int(2) DEFAULT NULL,
  `release_time` datetime DEFAULT NULL,
  `repository` text,
  `inst_time` datetime DEFAULT NULL,
  `inst_version` varchar(64) DEFAULT NULL,
  `inst_state` varchar(128) DEFAULT NULL,
  `inst_log` text,
  `inst_filesize` int(11) DEFAULT '0',
  `inst_download` int(11) DEFAULT '0',
  `create_by` int(11) DEFAULT '1',
  `create_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT '1',
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `package_id` (`package_id`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
