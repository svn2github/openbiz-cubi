 
-- Dumping structure for table: `sms_provider`

DROP TABLE IF EXISTS `sms_provider`;
CREATE TABLE `sms_provider` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL  ,
  `password` varchar(255) NOT NULL  ,
  `type` varchar(255) NOT NULL  ,
  `site_url` varchar(255) NOT NULL  ,
  `description` text,
  `owner_id` int(11) default '0',
  `use_sms_count` int(11) default '0' COMMENT '可用短信条数',
  `send_sms_count` int(11) default '0' COMMENT '发送总量',
  `group_id` int(11) default '1',
  `group_perm` int(11) default '1',
  `other_perm` int(11) default '1',
  `priority` int(2) default '1',
  `status` int(2) default '1' NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='服务商';

INSERT INTO `sms_provider` (`id`,`username`, `password`, `type`, `site_url`, `description`, `owner_id`, `group_id`, `group_perm`, `other_perm`, `status`, `update_by`, `update_time`, `create_by`, `create_time`) VALUES
(1, '', '', '18dx', 'http://www.18dx.cn/','长沙八信通讯科技有限公司是一家专注于移动通讯领域的科技公司。', 1, 1, 1, 0, 1, 1, '2012-08-01 15:16:04', 1, '2012-08-01 23:10:17');
DROP TABLE IF EXISTS `sms_queue`;
CREATE TABLE IF NOT EXISTS `sms_queue` (
  `id` int(11) NOT NULL auto_increment,
  `tasklist_id` int(11) NOT NULL ,
  `mobile` varchar(11) NOT NULL,
  `content` longtext NOT NULL,
   `provider`  varchar(100) NOT NULL,
   `lock_expiry`  varchar(20) NOT NULL,
   `priority`int(10) NOT NULL,
  `status` enum('pending','sending','sent') NOT NULL,
    `plantime` datetime NOT NULL,
	`create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `sent_time` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `flag` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `sms_tasklist`;
CREATE TABLE IF NOT EXISTS `sms_tasklist` (
  `id` int(11) NOT NULL auto_increment,
  `content` varchar(250) character set utf8 NOT NULL,
  `has_sent` int(10) NOT NULL COMMENT '已发送数量',
  `sms_number` int(10) NOT NULL COMMENT '收件人数量',
  `priority`int(10) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `mobile` text NOT NULL ,
  `provider` varchar(50) NOT NULL,
  `owner_id` int(11) default '0',
  `group_id` int(11) default '1',
  `group_perm` int(11) default '1',
  `other_perm` int(11) default '1',
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `create_by` (`create_by`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1  AUTO_INCREMENT=1 ;

-- Dumping structure for table: `sms_provider_related`

DROP TABLE IF EXISTS `sms_provider_related`;
CREATE TABLE `sms_provider_related` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `sms_provider_id` int(10) unsigned NOT NULL default '0',
  `related_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `related_id` (`related_id`),
  KEY `sms_provider_id` (`sms_provider_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

