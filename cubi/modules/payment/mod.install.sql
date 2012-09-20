DROP TABLE IF EXISTS `payment_provider`;
CREATE TABLE IF NOT EXISTS `payment_provider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `require_auth` int(11) NOT NULL DEFAULT '1' ,  
  `account` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `secret` varchar(255) NOT NULL,  
  `type` varchar(255) NOT NULL,
  `site_url` varchar(255) NOT NULL,
  `description` text,  
  `priority` int(2) DEFAULT '50',
  `status` int(2) NOT NULL DEFAULT '1',
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `payment_provider` (`id`, `driver`, `require_auth`, `name`, `account`, `key`, `secret`, `type`, `site_url`, `description`, `priority`, `status`, `update_by`, `update_time`, `create_by`, `create_time`) VALUES
(1, 'payment.lib.driver.PaypalCN', 0, 'Paypal 贝宝', '', '', '', 'paypalcn', 'http://www.paypal.cn', NULL, 50, 0, 1, '2012-09-13 17:46:51', 0, '0000-00-00 00:00:00'),
(2, 'payment.lib.driver.Alipay', 1, '支付宝', '', '', '', 'alipay', 'https://b.alipay.com/', NULL, 55, 0, 1, '2012-09-16 19:07:15', 1, '0000-00-00 00:00:00'),
(3, 'payment.lib.driver.Paypal', 0, 'Paypal', '', '', '', 'paypal', 'http://www.paypal.com/', NULL, 50, 0, 1, '2012-09-14 18:10:53', 1, '0000-00-00 00:00:00'),
(4, 'payment.lib.driver.ChinaBank', 1, '网银在线', '', '', '', 'chinabank', 'http://www.chinabank.com.cn/', NULL, 50, 0, 1, '2012-09-20 12:28:03', 1, '0000-00-00 00:00:00');


DROP TABLE IF EXISTS `payment_log`;
CREATE TABLE IF NOT EXISTS `payment_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_id` int(11) NOT NULL,
  `txn_id` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,  
  `payer_email` varchar(255) NOT NULL,
  `payer_id` varchar(255) NOT NULL,
  `payment_subject` varchar(255) NOT NULL,
  `payment_amount` float NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `rawdata` longtext NOT NULL,
  `processed` int(2) NOT NULL,
  `create_time` datetime NOT NULL,  
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
