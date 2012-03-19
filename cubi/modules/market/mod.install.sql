DROP TABLE IF EXISTS `market_repository`;
CREATE TABLE IF NOT EXISTS `market_repository` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repository_uri` varchar(255) NOT NULL,
  `repository_uid` varchar(255) NOT NULL,
  `status` int(2) NOT NULL,
  `sort_order` INT NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `repository_uid` (`repository_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `market_installed`;
CREATE TABLE IF NOT EXISTS `market_installed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repository_uid` varchar(255) NOT NULL,
  `app_id` int(11) NOT NULL,
  `version` varchar(255) NOT NULL,
  `install_time` datetime NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `repository_uid` (`repository_uid`,`app_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;