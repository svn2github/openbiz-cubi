DROP TABLE IF EXISTS `repo_install_log`;
CREATE TABLE IF NOT EXISTS `repo_install_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL,
  `release_id` int(11) NOT NULL,
  `remote_ip` varchar(255) NOT NULL,
  `remote_siteurl` varchar(255) NOT NULL,
  `remote_operator` varchar(255) NOT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `repo_application`;
CREATE TABLE IF NOT EXISTS `repo_application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `type` varchar(64) NOT NULL,
  `category_id` int(64) NOT NULL,
  `author` varchar(128) NOT NULL,
  `description` text,
  `status` int(2) DEFAULT NULL,
  `featured` int(2) DEFAULT NULL,
  `release_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT '1',
  `create_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT '1',
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `package_id` (`package_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



DROP TABLE IF EXISTS `repo_category`;
CREATE TABLE IF NOT EXISTS `repo_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `attrs` text,
  `publish` int(11) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '10',
  `create_time` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



DROP TABLE IF EXISTS `repo_release`;
CREATE TABLE IF NOT EXISTS `repo_release` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL,
  `version` varchar(255) NOT NULL,
  `pltfm_ver` varchar(64) NOT NULL,
  `description` text,
  `filename` varchar(255) DEFAULT NULL,
  `filesize` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `sha256` varchar(255) NOT NULL,
  `md5` varchar(255) NOT NULL,
  `create_by` int(11) DEFAULT '1',
  `create_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT '1',
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_id` (`app_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;