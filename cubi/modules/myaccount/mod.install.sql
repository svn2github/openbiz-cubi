/*Data for the table `preference` */

DROP TABLE IF EXISTS `preference`;
CREATE TABLE IF NOT EXISTS `preference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `section` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text,
  `type` varchar(255) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `preference` (`id`, `user_id`, `section`, `name`, `value`, `type`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 0, 'General', 'group_data_share', '1', 'Radio', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43'),
(2, 0, 'Data Sharing', 'owner_perm', '3', 'DropDownList', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43'),
(3, 0, 'Data Sharing', 'group_perm', '1', 'DropDownList', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43'),
(4, 0, 'Data Sharing', 'other_perm', '0', 'DropDownList', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43'),
(5, 0, 'General', 'siteurl', 'http://dev.openbiz.cn/cubi', 'InputText', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43'),
(6, 0, 'General', 'language', 'en_US', 'myaccount.form.LanguageSelector', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43'),
(7, 0, 'General', 'theme', 'default', 'myaccount.form.ThemeSelector', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43'),
(8, 0, 'General', 'appbuilder', '1', 'DropDownList', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43'),
(9, 0, 'Timezone', 'continent', 'Asia', 'myaccount.form.ContinentSelector', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43'),
(10, 0, 'Timezone', 'timezone', 'Asia/Chongqing', 'myaccount.form.TimezoneSelector', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43'),
(11, 0, 'Login', 'smartcard_auth', '0', 'DropDownList', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43'),
(12, 0, 'Login', 'anti_spam', '0', 'DropDownList', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43'),
(13, 0, 'Login', 'language_selector', '1', 'DropDownList', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43'),
(14, 0, 'Login', 'theme_selector', '0', 'DropDownList', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43'),
(15, 0, 'Login', 'keep_cookies', '1', 'DropDownList', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43'),
(16, 0, 'Register', 'open_register', '1', 'DropDownList', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43'),
(17, 0, 'Register', 'find_password', '1', 'DropDownList', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43');

/*schema for the table `user_widget` */

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

/*Data for the table `user_widget` */

insert  into `user_widget`(`id`,`user_id`,`widget`,`ordering`,`config`,`status`,`create_by`,`create_time`,`update_by`,`update_time`) values (1,1,'myaccount.widget.DashboardForm',10,'',1,1,'2011-07-23 16:05:55',1,'2011-07-23 16:05:55');