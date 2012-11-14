-- Dumping structure for table: `error_report`

DROP TABLE IF EXISTS `error_report`;
CREATE TABLE `error_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `error_data` longtext,
  `php_version` varchar(255) DEFAULT NULL,
  `php_extension` longtext,
  `server_info` longtext,
  `owner_id` int(11) DEFAULT '0',
  `group_id` int(11) DEFAULT '1',
  `group_perm` int(11) DEFAULT '1',
  `other_perm` int(11) DEFAULT '1',
  `status` int(2) NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Error Report Center';

-- Dumping structure for table: `error_report_type`

DROP TABLE IF EXISTS `error_report_type`;
CREATE TABLE `error_report_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(255) NOT NULL,
  `sortorder` int(11) NOT NULL,
  `group_id` int(11) DEFAULT '1',
  `group_perm` int(11) DEFAULT '1',
  `other_perm` int(11) DEFAULT '1',
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `error_report_type` (`id`, `name`, `description`, `color`, `sortorder`, `group_id`, `group_perm`, `other_perm`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'Cubi Error', 'Cubi Error', 'ffb8b8', 50, 2, 1, 1, 1, '2012-11-14 12:38:49', 1, '2012-11-14 12:38:49');

-- Dumping structure for table: `error_report_related`

DROP TABLE IF EXISTS `error_report_related`;
CREATE TABLE `error_report_related` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `error_report_id` int(10) unsigned NOT NULL DEFAULT '0',
  `related_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `related_id` (`related_id`),
  KEY `error_report_id` (`error_report_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

