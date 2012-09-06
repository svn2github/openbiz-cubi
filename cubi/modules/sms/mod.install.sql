
DROP TABLE IF EXISTS `sms_log`;
CREATE TABLE IF NOT EXISTS `sms_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_id` int(11) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `content` longtext NOT NULL,
  `schedule` datetime NOT NULL,
  `sent_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `sms_provider`;
CREATE TABLE IF NOT EXISTS `sms_provider` (
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

--
-- Dumping data for table `sms_provider`
--

INSERT INTO `sms_provider` (`id`, `driver`, `name`, `username`, `password`, `type`, `site_url`, `description`, `msg_sent_count`, `msg_balance`, `msg_last_sendtime`, `priority`, `status`, `update_by`, `update_time`, `create_by`, `create_time`) VALUES
(1, 'sms.lib.driver.SP18dx', '八信科技', '', '', '18dx', 'http://www.18dx.cn/', '长沙八信通讯科技有限公司是一家专注于移动通讯领域的科技公司。', 0, 0, '2012-09-06 09:52:03', 50, 0, 1, '2012-09-06 10:55:43', 1, '2012-08-01 23:10:17'),
(2, 'sms.lib.driver.SPc123', '创明短信', '', '', 'c123', 'http://www.c123.com', '上海创明网络科技有限公司是一家专注企业短信、移动商务、无线广告业务的公司', 0, 0, '2012-09-06 09:58:29', 50, 0, 1, '2012-09-06 10:59:11', 0, '0000-00-00 00:00:00');


DROP TABLE IF EXISTS `sms_queue`;
CREATE TABLE IF NOT EXISTS `sms_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(11) NOT NULL,
  `content` longtext NOT NULL,
  `status` enum('pending','sending','sent') DEFAULT 'pending',
  `schedule` datetime NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `flag` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

