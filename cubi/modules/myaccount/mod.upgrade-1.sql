DROP TABLE IF EXISTS `user_widget`;

CREATE TABLE IF NOT EXISTS `user_widget` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `widget` varchar(255) NOT NULL,
  `ordering` int(10) NOT NULL,
  `config` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `widget` (`widget`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
