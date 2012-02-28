DROP TABLE IF EXISTS `extend_data`;
CREATE TABLE IF NOT EXISTS `extend_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `field_1` longtext NOT NULL,
  `field_2` longtext NOT NULL,
  `field_3` longtext NOT NULL,
  `field_4` longtext NOT NULL,
  `field_5` longtext NOT NULL,
  `field_6` longtext NOT NULL,
  `field_7` longtext NOT NULL,
  `field_8` longtext NOT NULL,
  `field_9` longtext NOT NULL,
  `field_10` longtext NOT NULL,
  `field_11` longtext NOT NULL,
  `field_12` longtext NOT NULL,
  `field_13` longtext NOT NULL,
  `field_14` longtext NOT NULL,
  `field_15` longtext NOT NULL,
  `field_16` longtext NOT NULL,
  `field_17` longtext NOT NULL,
  `field_18` longtext NOT NULL,
  `field_19` longtext NOT NULL,
  `field_20` longtext NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module` (`module`,`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



DROP TABLE IF EXISTS `extend_setting`;
CREATE TABLE IF NOT EXISTS `extend_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL,
  `class` varchar(255) NOT NULL,
  `field` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `options` longtext NOT NULL,
  `sortorder` int(11) NOT NULL,
  `access` varchar(255) NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module` (`module`,`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;