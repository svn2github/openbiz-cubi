DROP TABLE IF EXISTS `payment_log`;
CREATE TABLE IF NOT EXISTS `payment_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_id` int(11) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `content` longtext NOT NULL,
  `schedule` datetime NOT NULL,
  `sent_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `payment_provider`;
CREATE TABLE IF NOT EXISTS `payment_provider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `site_url` varchar(255) NOT NULL,
  `description` text,
  `msg_sent_count` int(11) DEFAULT '0' ,
  `msg_balance` int(11) DEFAULT '0' ,
  `msg_last_sendtime` datetime NOT NULL,
  `priority` int(2) DEFAULT '1',
  `status` int(2) NOT NULL DEFAULT '1',
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
