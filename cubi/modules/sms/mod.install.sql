
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
(2, 'sms.lib.driver.SPc123', '创明短信', '', '', 'c123', 'http://www.c123.com', '上海创明网络科技有限公司是一家专注企业短信、移动商务、无线广告业务的公司', 0, 0, '2012-09-06 09:58:29', 50, 0, 1, '2012-09-06 10:59:11', 1, '0000-00-00 00:00:00');

INSERT INTO `sms_provider` (`id`, `driver`, `name`, `username`, `password`, `type`, `site_url`, `description`, `msg_sent_count`, `msg_balance`, `msg_last_sendtime`, `priority`, `status`, `update_by`, `update_time`, `create_by`, `create_time`) VALUES
(3, 'sms.lib.driver.SPemay', '亿美软通', '', '', 'emay', 'http://www.emay.cn', '北京亿美软通科技有限公司（ Beijing Emay Softcom Technology Ltd.）是国际数据集团风险投资（IDG资本）在华注资的高科技企业、全球最大的信用局和数据营销公司Experian（益百利）的中国战略合作伙伴，是具备国际水准的移动商务平台技术和应用方案提供商。', 0, 0,'0000-00-00 00:00:00', 50, 0, 1, '2012-09-08 17:06:57', 1, '0000-00-00 00:00:00'),
(4, 'sms.lib.driver.SPc8686', '八优信息', '', '', 'c8686', 'http://www.c8686.com/', '上海八优信息科技有限公司是一家SP增值、软件开发、技术咨询和网站建设为主要业务的企业。', 0, 0,'0000-00-00 00:00:00', 50, 0, 1, '2012-09-08 17:06:57', 1, '0000-00-00 00:00:00'),
(5, 'sms.lib.driver.SPtclk', '同创凌凯', '', '', 'tclk', 'http://www.bjtclk.com/', '北京同创凌凯信息技术有限公司是以移动商务产品的研发、营销、短信中心平台运营为一体的信息技术科技公司', 0, 0,'0000-00-00 00:00:00', 50, 0, 1, '2012-09-08 17:06:57', 1, '0000-00-00 00:00:00');


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

INSERT INTO `cronjob` ( `name`, `minute`, `hour`, `day`, `month`, `weekday`, `command`, `sendmail`, `max_run`, `num_run`, `description`, `status`, `last_exec`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
( 'Sending SMS Job', '*', '*', '*', '*', '*', '{APP_HOME}/bin/cronjob/run_svc.php  sms.lib.SmsService SendSmsFromQueue', '', 1, 0, 'System SMS Queue Service', 1, 1296586403, 1, '2011-02-01 10:24:31', 1, '2011-02-01 10:51:04');
