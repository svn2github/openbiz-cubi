/*Table structure for table `help` */

DROP TABLE IF EXISTS `help`;

CREATE TABLE `help` (
  `id` int(11) NOT NULL auto_increment,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) NOT NULL default '10',
  `content` longtext,
  `create_by` int(11) default NULL,
  `create_time` datetime default NULL,
  `update_by` int(11) default NULL,
  `update_time` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `create_by` (`create_by`),
  KEY `update_by` (`update_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `help` */

insert  into `help`(`id`,`category_id`,`title`,`description`,`sort_order`,`content`,`create_by`,`create_time`,`update_by`,`update_time`) values (1,3,'What is Module Management?','<p>\n	Module Management screen allows administrator to manage modules in the application</p>\n',10,'<p>\n	Action can be done on the module management screen.</p>\n<ul>\n	<li>\n		Edit button. This is to activate or deactivate a module</li>\n	<li>\n		Delete button. This is to delete a module. When a module is deleted, its ACL settings are deleted as well.</li>\n	<li>\n		Load button. This is to load new modules added in the modules directory. The loading processor will read mod.xml, and load module and it ACL info to the system.</li>\n</ul>\n',1,'2010-05-01 13:01:58',1,'2010-05-01 13:06:21');
insert  into `help`(`id`,`category_id`,`title`,`description`,`sort_order`,`content`,`create_by`,`create_time`,`update_by`,`update_time`) values (2,1,'What is User Management ?','<p>\n	User Manage screen allows administrator to manage application users</p>\n',10,'<p>\n	Action can be done on the user management screen</p>\n<ul>\n	<li>\n		Add button to add a new user</li>\n	<li>\n		Edit button to edit a selected user</li>\n	<li>\n		Delete button to delete a selected user</li>\n</ul>\n',1,'2010-02-07 16:07:21',1,'2010-05-01 12:50:12');
insert  into `help`(`id`,`category_id`,`title`,`description`,`sort_order`,`content`,`create_by`,`create_time`,`update_by`,`update_time`) values (3,2,'What is Role Management?','<p>\n	Role Management screen allows administrator to manage roles in the application</p>\n',10,'<p>\n	Actions can be done on the role management screen.</p>\n<ul>\n	<li>\n		Add button</li>\n	<li>\n		Edit button</li>\n	<li>\n		Delete button. If a role is deleted, its permissions will be deleted as well.</li>\n</ul>\n',1,'2010-02-07 17:25:46',1,'2010-05-01 12:58:06');
insert  into `help`(`id`,`category_id`,`title`,`description`,`sort_order`,`content`,`create_by`,`create_time`,`update_by`,`update_time`) values (4,6,'How to ceate a help tip?','<p>\r\n	You need to go to Manage Help tips module and click Add button to create a new help tips.</p>\r\n',10,NULL,1,'2010-04-24 04:18:35',1,'2010-04-24 04:19:35');
insert  into `help`(`id`,`category_id`,`title`,`description`,`sort_order`,`content`,`create_by`,`create_time`,`update_by`,`update_time`) values (5,6,'How to map a help category to system module?','<p>\r\n	You can mapping a help category to a module&#39;s left help panel by specified URL match. then the module will only show help tips under this category.</p>\r\n',10,NULL,1,'2010-04-24 04:21:54',1,'2010-04-24 04:21:54');
insert  into `help`(`id`,`category_id`,`title`,`description`,`sort_order`,`content`,`create_by`,`create_time`,`update_by`,`update_time`) values (6,3,'How to reload a module?','<p>\n	A module can be reloaded to update its change</p>\n',10,'<p>\n	On the module management screen, click the module name to drilldown the module detail form. On this form, click Reload button to update the changes into the system</p>\n',1,'2010-05-01 13:09:09',1,'2010-05-01 13:09:09');
insert  into `help`(`id`,`category_id`,`title`,`description`,`sort_order`,`content`,`create_by`,`create_time`,`update_by`,`update_time`) values (7,4,'What is Event Log?','<p>\n	Event log screen is to list all events logged by the application</p>\n',10,'<p>\n	On the Event Log screen, clicking on the comments link to see to event log detail.</p>\n<p>\n	Clicking on the Clear button, all log records will be deleted from the log table. Be careful of using it.</p>\n',1,'2010-05-01 13:12:11',1,'2010-05-01 13:15:33');
insert  into `help`(`id`,`category_id`,`title`,`description`,`sort_order`,`content`,`create_by`,`create_time`,`update_by`,`update_time`) values (8,5,'How to manage email queue?','<p>\n	Email Queue Management screen allows user to manage queued emails</p>\n',10,'<p>\n	Action can be done on the email queue management screen.</p>\n<ul>\n	<li>\n		Send All button. This is to send all queued email immediately</li>\n	<li>\n		Send button. This is to send the selected email immediately</li>\n	<li>\n		Delete. This is to delete the selected email from the queue</li>\n	<li>\n		Delete Sent. This is to delete all sent emails from the queue</li>\n	<li>\n		Delete All. This is to empty the email queue</li>\n</ul>\n',1,'2010-05-01 13:17:05',1,'2010-05-01 16:18:48');
insert  into `help`(`id`,`category_id`,`title`,`description`,`sort_order`,`content`,`create_by`,`create_time`,`update_by`,`update_time`) values (9,5,'How to manage email log?','<p>\n	Email Log Management screen allows user to manage email activities</p>\n',10,'<p>\n	Clicking the Clear button will empty the email log records.</p>\n',1,'2010-05-01 13:18:11',1,'2010-05-01 16:19:59');

/*Table structure for table `help_category` */

DROP TABLE IF EXISTS `help_category`;

CREATE TABLE `help_category` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) default '0',
  `name` varchar(255) NOT NULL,
  `url_match` varchar(255) default NULL,
  `description` text,
  `sort_order` int(11) NOT NULL default '10',
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `help_category` */

insert  into `help_category`(`id`,`parent_id`,`name`,`url_match`,`description`,`sort_order`,`create_by`,`create_time`,`update_by`,`update_time`) values (1,7,'User Management','/system/user_list.*','<p>\n	About how to manage users and system access.</p>\n',10,1,'2010-04-19 18:15:18',1,'2010-04-22 01:37:29');
insert  into `help_category`(`id`,`parent_id`,`name`,`url_match`,`description`,`sort_order`,`create_by`,`create_time`,`update_by`,`update_time`) values (2,7,'Role Management','/system/role_list.*','<p>\n	About how to manage system role and permissions group.</p>\n',20,1,'2010-04-19 19:50:23',1,'2010-04-21 08:10:48');
insert  into `help_category`(`id`,`parent_id`,`name`,`url_match`,`description`,`sort_order`,`create_by`,`create_time`,`update_by`,`update_time`) values (3,7,'Module Management','/system/module_list.*','<p>\n	About how to mount a module into Cubi system.</p>\n',30,1,'2010-04-21 03:35:11',1,'2010-04-21 05:11:09');
insert  into `help_category`(`id`,`parent_id`,`name`,`url_match`,`description`,`sort_order`,`create_by`,`create_time`,`update_by`,`update_time`) values (4,7,'Event Log Management','/system/event_log.*','<p>About system event log/</p>\n',40,1,'2010-04-21 05:01:44',1,'2010-04-21 08:09:53');
insert  into `help_category`(`id`,`parent_id`,`name`,`url_match`,`description`,`sort_order`,`create_by`,`create_time`,`update_by`,`update_time`) values (5,7,'Email Management','/email/email_.*','<p>\n	About how to manage system email function</p>\n',50,1,'2010-04-21 05:03:43',1,'2010-05-01 13:19:08');
insert  into `help_category`(`id`,`parent_id`,`name`,`url_match`,`description`,`sort_order`,`create_by`,`create_time`,`update_by`,`update_time`) values (6,7,'Help Management','/help/help_.*','<p>\r\n	About how to manage the online help module of cubi system.</p>\r\n',60,1,'2010-04-21 05:09:50',1,'2010-04-24 05:16:02');
insert  into `help_category`(`id`,`parent_id`,`name`,`url_match`,`description`,`sort_order`,`create_by`,`create_time`,`update_by`,`update_time`) values (7,0,'System Admin',NULL,'<p>\n	Cubi system help content.</p>\n',10,1,'2010-04-21 05:10:29',1,'2010-04-21 05:11:54');

/*Table structure for table `help_category_mapping` */

DROP TABLE IF EXISTS `help_category_mapping`;

CREATE TABLE `help_category_mapping` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `url` (`url`),
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `help_category_mapping` */
