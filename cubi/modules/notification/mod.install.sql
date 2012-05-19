DROP TABLE IF EXISTS `notification`; 
CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `goto_url` varchar(255) NOT NULL DEFAULT '',
  `read_state` int(11) NOT NULL,
  `read_access` varchar(255) NOT NULL DEFAULT '',
  `update_access` varchar(255) NOT NULL DEFAULT '',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `notification_checker`; 
CREATE TABLE IF NOT EXISTS `notification_checker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checker` varchar(255) NOT NULL DEFAULT '',
  `last_checktime` datetime NOT NULL,  
  PRIMARY KEY (`id`),
  KEY `checker` (`checker`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;