DROP TABLE IF EXISTS `work_log`;
CREATE TABLE `work_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` INT(11) default null,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `worked_hours` float(11) default '0',
  `updated_progress` int(11) default '0',

  `group_id` INT(11) default '1',
  `group_perm` INT(11) default '1',
  `other_perm` INT(11) default '1' ,

  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
