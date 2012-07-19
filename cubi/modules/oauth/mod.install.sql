/*
	保存第三方平台注册的KEY和密匙
*/
DROP TABLE IF EXISTS `oauth_provider`;
CREATE TABLE IF NOT EXISTS `oauth_provider` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type` char(30)  ,
  `key` char(50) ,
  `value` varchar(255) NOT NULL,
  `status` int(2) NOT NULL default 0,
  `sortorder` INT NOT NULL DEFAULT '50',
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY  (`id`),
   KEY `create_by` (`create_by`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `oauth_provider`
 (`id`, `type`, `key`, `value`, `status`, `create_by`, `create_time`, `update_by`, `update_time`) 
 VALUES
(1, 'sina', '', '', 0, 1, '', 1, ''),
(2, 'qq', '', '', 0, 1, '', 1, ''),
(3, 'alipay', '', '', 0, 1, '', 1, ''),
(4, 'google', '', '', 0, 1, '', 1, ''),
(5, 'facebook', '', '', 0, 1, '', 1, '');


