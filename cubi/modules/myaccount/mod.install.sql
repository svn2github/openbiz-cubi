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
(4, 0, 'Data Sharing', 'other_perm', '0', 'DropDownList', 1, '2011-12-01 01:57:43', 1, '2011-12-01 01:57:43');


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