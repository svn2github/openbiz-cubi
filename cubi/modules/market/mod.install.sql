/*DROP TABLE IF EXISTS `market_repository`;*/
CREATE TABLE IF NOT EXISTS `market_repository` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repository_uri` varchar(255) NOT NULL,
  `repository_uid` varchar(255) NOT NULL,
  `repository_name` VARCHAR( 255 ) NOT NULL,
  `status` int(2) NOT NULL,
  `sort_order` INT NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `repository_uid` (`repository_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*DROP TABLE IF EXISTS `market_installed`;*/
CREATE TABLE IF NOT EXISTS `market_installed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `repository_uid` varchar(255) NOT NULL,
  `app_id` int(11) NOT NULL,
  `version` varchar(255) NOT NULL,
  `install_time` datetime NOT NULL,
  `install_state` varchar(255) NOT NULL,
  `install_download` int(11) NOT NULL,
  `install_download_filesize` int(11) NOT NULL,
  `install_progress` int(11) NOT NULL,
  `install_log` varchar(255) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `repository_uid` (`repository_uid`,`app_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `market_repository` (`repository_uri`, `repository_uid`, `repository_name`, `status`, `sort_order`, `create_by`, `create_time`) VALUES
( 'http://repos.openbiz.cn', 'repos.openbiz.cn', 'Openbiz Offical Repository - China', 1, 50, 1, '2012-03-24 19:41:28');
