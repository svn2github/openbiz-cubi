/*Table structure for table `cronjob` */

DROP TABLE IF EXISTS `cronjob`;

CREATE TABLE `cronjob` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `minute` varchar(255) NOT NULL default '',
  `hour` varchar(255) NOT NULL default '',
  `day` varchar(255) NOT NULL default '',
  `month` varchar(255) NOT NULL default '',
  `weekday` varchar(255) NOT NULL default '',
  `command` varchar(255) NOT NULL default '',
  `sendmail` varchar(255) default '',
  `max_run` int(2) default '1',
  `num_run` int(2) default '0',
  `description` varchar(255) default NULL,
  `status` int(1) default '1',
  `last_exec` int(11) default NULL,
  `create_by` int(11) default NULL,
  `create_time` datetime default NULL,
  `update_by` int(11) default NULL,
  `update_time` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `minute` (`minute`),
  KEY `hour` (`hour`),
  KEY `weekday` (`day`),
  KEY `month` (`month`),
  KEY `week` (`weekday`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `cronjob` */
