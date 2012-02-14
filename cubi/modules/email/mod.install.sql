/*Table structure for table `email_log` */

DROP TABLE IF EXISTS `email_log`;

CREATE TABLE `email_log` (
  `id` int(11) NOT NULL auto_increment,
  `result` varchar(255) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `recipients` text NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `result` (`result`),
  KEY `sender` (`sender`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `email_log` */

/*Table structure for table `email_queue` */

DROP TABLE IF EXISTS `email_queue`;

CREATE TABLE `email_queue` (
  `id` int(11) NOT NULL auto_increment,
  `sender` varchar(255) NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `status` enum('pending','sending','sent') NOT NULL,
  `create_time` datetime NOT NULL,
  `sent_time` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `flag` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `email_queue` */

/* Insert Cronjob Task*/
INSERT INTO `cronjob` ( `name`, `minute`, `hour`, `day`, `month`, `weekday`, `command`, `sendmail`, `max_run`, `num_run`, `description`, `status`, `last_exec`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
( 'Sending Email Job', '*', '*', '*', '*', '*', '{APP_HOME}/bin/cronjob/run_svc.php  userEmailService sendEmailFromQueue', '', 1, 0, 'System Email Queue Service', 1, 1296586403, 1, '2011-02-01 10:24:31', 1, '2011-02-01 10:51:04');

