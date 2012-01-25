DROP TABLE IF EXISTS `changelog`;
CREATE TABLE IF NOT EXISTS `changelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT '',
  `foreign_id` int(11) NOT NULL,
  `form` text NOT NULL,
  `data` text NOT NULL,
  `comment` text NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
