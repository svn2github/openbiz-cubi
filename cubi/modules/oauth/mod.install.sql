DROP TABLE IF EXISTS `oauth_user_token`;
CREATE TABLE IF NOT EXISTS `oauth_user_token` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL,
  `oauth_class` varchar(255) NOT NULL,
  `oauth_secret` text NOT NULL,
  `oauth_rawdata` longtext NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;
