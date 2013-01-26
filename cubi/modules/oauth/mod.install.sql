/*
	保存第三方平台注册的KEY和密匙
*/
DROP TABLE IF EXISTS `oauth_provider`;
CREATE TABLE IF NOT EXISTS `oauth_provider` (
  `id` int(11) unsigned NOT NULL auto_increment,  
  `type` varchar(255)  ,
  `site_url` varchar(255)  ,
  `key` varchar(255) ,
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
 (`id`, `type`,`site_url`, `key`, `value`, `status`, `create_by`,  `update_by`) 
 VALUES
(1, 'sina', 'http://open.weibo.com/', '', '', 0, 1, 1),
(2, 'qq', 'http://dev.t.qq.com/','', '', 0, 1, 1),
(3, 'alipay', 'https://b.alipay.com/','', '', 0, 1, 1),
(4, 'google', 'https://code.google.com/apis/console/','', '', 0, 1, 1),
(5, 'facebook', 'https://developers.facebook.com/apps','', '', 0, 1, 1),
(6, 'qzone', 'http://connect.qq.com',  '', '', 0, 1, 1),
(7, 'twitter', 'http://api.twitter.com',  '', '', 0, 1, 1),
(8, 'alitao', 'https://open.taobao.com/','', '', 0, 1, 1),
(9, 'baiduapp', 'http://developer.baidu.com','', '', 0, 1, 1)