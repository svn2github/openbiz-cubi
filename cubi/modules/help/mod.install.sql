/*Table structure for table `help` */

DROP TABLE IF EXISTS `help`;
CREATE TABLE IF NOT EXISTS `help` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;


INSERT INTO `help` (`id`, `category_id`, `title`, `description`, `sort_order`, `content`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 3, 'What is Module Management?', '<p>\n	Module Management screen allows administrator to manage modules in the application</p>\n', 10, '<p>\n	Action can be done on the module management screen.</p>\n<ul>\n	<li>\n		Edit button. This is to activate or deactivate a module</li>\n	<li>\n		Delete button. This is to delete a module. When a module is deleted, its ACL settings are deleted as well.</li>\n	<li>\n		Load button. This is to load new modules added in the modules directory. The loading processor will read mod.xml, and load module and it ACL info to the system.</li>\n</ul>\n', 1, '2010-05-01 13:01:58', 1, '2010-05-01 13:06:21'),
(2, 1, 'What is User Management ?', '<p>\n	User Manage screen allows administrator to manage application users</p>\n', 10, '<p>\n	Action can be done on the user management screen</p>\n<ul>\n	<li>\n		Add button to add a new user</li>\n	<li>\n		Edit button to edit a selected user</li>\n	<li>\n		Delete button to delete a selected user</li>\n</ul>\n', 1, '2010-02-07 16:07:21', 1, '2010-05-01 12:50:12'),
(3, 2, 'What is Role Management?', '<p>\n	Role Management screen allows administrator to manage roles in the application</p>\n', 10, '<p>\n	Actions can be done on the role management screen.</p>\n<ul>\n	<li>\n		Add button</li>\n	<li>\n		Edit button</li>\n	<li>\n		Delete button. If a role is deleted, its permissions will be deleted as well.</li>\n</ul>\n', 1, '2010-02-07 17:25:46', 1, '2010-05-01 12:58:06'),
(4, 6, 'How to ceate a help tip?', '<p>\r\n	You need to go to Manage Help tips module and click Add button to create a new help tips.</p>\r\n', 10, NULL, 1, '2010-04-24 04:18:35', 1, '2010-04-24 04:19:35'),
(5, 6, 'How to map a help category to system module?', '<p>\r\n	You can mapping a help category to a module&#39;s left help panel by specified URL match. then the module will only show help tips under this category.</p>\r\n', 10, NULL, 1, '2010-04-24 04:21:54', 1, '2010-04-24 04:21:54'),
(6, 3, 'How to reload a module?', '<p>\n	A module can be reloaded to update its change</p>\n', 10, '<p>\n	On the module management screen, click the module name to drilldown the module detail form. On this form, click Reload button to update the changes into the system</p>\n', 1, '2010-05-01 13:09:09', 1, '2010-05-01 13:09:09'),
(7, 4, 'What is Event Log?', '<p>\n	Event log screen is to list all events logged by the application</p>\n', 10, '<p>\n	On the Event Log screen, clicking on the comments link to see to event log detail.</p>\n<p>\n	Clicking on the Clear button, all log records will be deleted from the log table. Be careful of using it.</p>\n', 1, '2010-05-01 13:12:11', 1, '2010-05-01 13:15:33'),
(8, 5, 'How to manage email queue?', '<p>\n	Email Queue Management screen allows user to manage queued emails</p>\n', 10, '<p>\n	Action can be done on the email queue management screen.</p>\n<ul>\n	<li>\n		Send All button. This is to send all queued email immediately</li>\n	<li>\n		Send button. This is to send the selected email immediately</li>\n	<li>\n		Delete. This is to delete the selected email from the queue</li>\n	<li>\n		Delete Sent. This is to delete all sent emails from the queue</li>\n	<li>\n		Delete All. This is to empty the email queue</li>\n</ul>\n', 1, '2010-05-01 13:17:05', 1, '2010-05-01 16:18:48'),
(9, 5, 'How to manage email log?', '<p>\n	Email Log Management screen allows user to manage email activities</p>\n', 10, '<p>\n	Clicking the Clear button will empty the email log records.</p>\n', 1, '2010-05-01 13:18:11', 1, '2010-05-01 16:19:59'),
(10, 8, 'What is theme management', '<p>\n	Theme Management allow administor to review / install or uninstall a theme for the system. </p>\n', 10, NULL, 1, '2011-12-15 19:31:11', 1, '2011-12-15 19:31:11'),
(11, 11, 'How to change default language', '<p>\n	change cubi platfrom language from user preference setting.</p>\n', 10, '<p>\n	1 click user module and select user preference setting.&nbsp;</p>\n<p>\n	2 go down the the bottom of the page click &#39;edit&#39; button.</p>\n<p>\n	3 select the language you want to used for your cubi platform from &#39;general&#39;--&gt;&#39;default language&#39; options.</p>\n<p>\n	4 go to bottom of the page click &#39;save&#39; button.</p>\n<p>\n	5 re-log into the cubi.</p>\n', 1, '2011-12-16 10:59:20', 1, '2011-12-16 16:05:57'),
(12, 10, 'What is Cronjob item', '<p>\n	Cronjob item is a...</p>\n', 10, NULL, 1, '2011-12-16 15:52:21', 1, '2011-12-16 15:52:21'),
(13, 1, 'How to add a new user?', '<p>\n	follow the user manangement module to add an new user into cubi platform.</p>\n', 10, '<p>\n	1 Click user management function add button under user module as below screen picture.</p>\n<p>\n	<img alt="" height="198" src="/cubi/files/upload/helptips/user/1.png" width="732" /></p>\n<p>\n	2 input the new user name and password and email address and set state to active then click save.</p>\n<p>\n	<img alt="" height="352" src="/cubi/files/upload/helptips/user/2.png" width="381" /></p>\n<p>\n	3 input the related user information like address, telephone and so on in the contact profile form then save.</p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/user/3.png" /></p>\n<p>\n	4 now you have add an new user into cubi platform.</p>\n', 1, '2011-12-16 17:33:15', 1, '2011-12-25 19:40:53'),
(14, 1, 'How to change user profile', '<p>\n	change or replenish user&#39;s personal information&nbsp;</p>\n', 10, '<p>\n	&nbsp;1 log into cubi</p>\n<p>\n	&nbsp;</p>\n<p>\n	2 click left navigation user module</p>\n<p>\n	<img alt="" height="126" src="/cubi/files/upload/helptips/user/4.png" width="189" /></p>\n<p>\n	3 select the user that you need to change information</p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/user/5.png" /></p>\n<p>\n	3 click profile button to change or replenish your personal information like phone number or address</p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/user/6.png" /></p>\n', 1, '2011-12-22 23:21:39', 1, '2011-12-25 19:47:18'),
(15, 2, 'What is role for?', '<p>\n	User role could be used for assign different role management in different modules.</p>\n', 10, NULL, 1, '2011-12-23 16:06:02', 1, '2011-12-23 16:06:02'),
(16, 2, 'How to create an role and set up his authority??', '<p>\n	User could split up administrator and common user with role management</p>\n', 10, '<p>\n	1 click left navigation role moudle</p>\n<p>\n	<img alt="" height="119" src="/cubi/files/upload/helptips/role/1.png" width="189" /></p>\n<p>\n	2 click add button to create an new type role you needed for your application</p>\n<p>\n	<img alt="" height="138" src="/cubi/files/upload/helptips/role/2.png" width="715" /></p>\n<p>\n	3 create an new type of role you needed</p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/role/3.png" /></p>\n<p>\n	4 back to role management page select the new role you have created and click perm for set up access permission</p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/role/4.png" /></p>\n', 1, '2011-12-23 16:51:56', 1, '2011-12-25 20:06:11'),
(17, 2, 'what is default page for?', '<p>\n	there is an option when user create an new type of role in cubi platfrom called &quot;default page&quot;</p>\n', 10, '<p>\n	1 there is an option when user create an new type of role in cubi platfrom called &quot;Default page&quot;</p>\n<p>\n	/cubi/files/upload/helptips/role/2.png<img alt="" src="/cubi/files/upload/helptips/role/5.png" /></p>\n<p>\n	2 the default page option is the first start page when user are using the role log into cubi platform.</p>\n<p>\n	&nbsp;</p>\n<p>\n	3 the default page option is part of full path of the moudle, for example: email moudle user default page should be the path &quot;/email/email_queue_list&quot; after index.php</p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/role/6.png" /></p>\n', 1, '2011-12-23 17:12:17', 1, '2011-12-25 20:07:13'),
(19, 12, 'backup Cubi system to portable hard disk', '<p>\n	user can use &quot;Device and Location&quot; funcation under backup module to backup their cubi data into their portable hard disk or the other hard disk</p>\n', 10, '<p>\n	1 click &quot;Device and Location&quot; function under Backup module</p>\n<p>\n	<img alt="" height="82" src="/cubi/files/upload/helptips/backup/5.png" width="198" /></p>\n<p>\n	2 click add button to set up an user&#39;s backup device</p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/backup/6.png" /></p>\n<p>\n	3 input the user&#39;s backup device path like: /mnt/ (the user&#39;s backup up device could be an portable hard disk or even a flahs disk that connected with cubi server, then administrator can set up the hard disk mount point usually /mnt/)</p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/backup/7.png" /></p>\n<p>\n	&nbsp;</p>\n<p>\n	4 save and then Cubi&#39;s data have been backup into user&#39;s backup device.</p>\n', 1, '2011-12-25 21:10:33', 1, '2011-12-25 21:10:33'),
(20, 12, 'why backup?', '<p>\n	Usually all the user&#39;s Cubi apply information and data have been saved into Cubi server, but for enhance system safety user&#39;s can backup Cubi date into Portable hard disk</p>\n', 10, NULL, 1, '2011-12-25 21:15:20', 1, '2011-12-25 21:15:20'),
(21, 14, 'what is group module for?', '<p>\n	group module can set up different group for user that could be used for split up user from different projects</p>\n', 10, NULL, 1, '2011-12-26 00:22:49', 1, '2011-12-26 00:22:49'),
(22, 14, 'How to create a group and set user into it', '<p>\n	this is an example of how to use group to partition users</p>\n', 10, '<p>\n	1 click &quot;Group Management&quot; function under dgroup module</p>\n<p>\n	<img alt="" height="80" src="/cubi/files/upload/helptips/group/1.png" width="190" /></p>\n<p>\n	2 click add button to create an new group</p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/group/2.png" /></p>\n<p>\n	3 input the new group name and description then save it</p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/group/3.png" /></p>\n<p>\n	4 go to the &quot;User Management&quot; function under user module</p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/group/4.png" /></p>\n<p>\n	5 select the user &quot;jack&quot; who you want to assign to the new create group &quot;project&quot; and click Detail button</p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/group/5.png" /></p>\n<p>\n	6 click add button in user group panel in the bottom of the User Detail page </p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/group/6.png" /></p>\n<p>\n	7 select the group you want the user &quot;jack&quot; belong to and check it then will automatically save the change</p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/group/7.png" /></p>\n', 1, '2011-12-26 00:34:51', 1, '2011-12-26 00:56:52'),
(23, 14, 'what is Group Data Sharing for?', '<p>\n	It is set up the default Group Data Share rule </p>\n<p>\n	Default setting is user create an new record will auto have full control and his group can read the record and others can not see it</p>\n', 10, NULL, 1, '2011-12-26 01:25:10', 1, '2011-12-26 01:25:10'),
(18, 12, 'How to Backup your Cubi system?', '<p>\n	In case user make some wrong operations we can backup Cubi system so that user can reverse Cubi system to the state of backup</p>\n', 10, '<p>\n	1 Click backup module--&gt;Manage Backup in left navigation bar</p>\n<p>\n	<img alt="" height="82" src="/cubi/files/upload/helptips/backup/1.png" width="193" /></p>\n<p>\n	&nbsp;</p>\n<p>\n	2 Click Backup button to set up a backup&nbsp;</p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/backup/2.png" /></p>\n<p>\n	3 Input the backup file name and select backup database or entire Cubi system and select a timestamp for it.</p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/backup/3.png" /></p>\n<p>\n	4 when you save your backup you could download it into your local device like portable hard disk then copy it into the other computer.</p>\n<p>\n	<img alt="" src="/cubi/files/upload/helptips/backup/4.png" /></p>\n', 1, '2011-12-25 19:24:22', 1, '2011-12-25 20:42:59');


DROP TABLE IF EXISTS `help_category`;
CREATE TABLE IF NOT EXISTS `help_category` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 导出表中的数据 `help_category`
--

INSERT INTO `help_category` (`id`, `parent_id`, `name`, `url_match`, `description`, `sort_order`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 7, 'User Management', '/system/user_list.*', '<p>\n	About how to manage users and system access.</p>\n', 5, 1, '2010-04-19 18:15:18', 1, '2011-12-16 16:04:43'),
(2, 7, 'Role Management', '/system/role_list.*', '<p>\n	About how to manage system role and permissions group.</p>\n', 20, 1, '2010-04-19 19:50:23', 1, '2010-04-21 08:10:48'),
(3, 7, 'Module Management', '/system/module_list.*', '<p>\n	About how to mount a module into Cubi system.</p>\n', 30, 1, '2010-04-21 03:35:11', 1, '2010-04-21 05:11:09'),
(4, 7, 'Event Log Management', '/system/event_log.*', '<p>About system event log/</p>\n', 40, 1, '2010-04-21 05:01:44', 1, '2010-04-21 08:09:53'),
(5, 7, 'Email Management', '/email/email_.*', '<p>\n	About how to manage system email function</p>\n', 50, 1, '2010-04-21 05:03:43', 1, '2010-05-01 13:19:08'),
(6, 7, 'Help Management', '/help/help_.*', '<p>\r\n	About how to manage the online help module of cubi system.</p>\r\n', 60, 1, '2010-04-21 05:09:50', 1, '2010-04-24 05:16:02'),
(7, 0, 'Openbiz Cubi System', '', '<p>\n	Cubi system help content.</p>\n', 10, 1, '2010-04-21 05:10:29', 1, '2011-12-25 23:39:14'),
(8, 7, 'Theme Management', '/theme/manage_theme', NULL, 60, 1, '2011-12-15 19:14:01', 1, '2011-12-15 19:14:29'),
(10, 7, 'Cronjob', '/cronjob/cronjob_list.*', NULL, 30, 1, '2011-12-16 15:50:00', 1, '2011-12-16 16:05:11'),
(11, 7, 'Preference setting', '/system/user_preference.*', NULL, 5, 1, '2011-12-16 16:04:20', 1, '2011-12-16 16:04:38'),
(12, 7, 'Backup Management', '/backup.*', '<p>\n	Backup or downlaod your Cubi system data.</p>\n', 10, 1, '2011-12-25 18:11:21', 1, '2011-12-25 20:57:35'),
(14, 7, 'Group', '/system/group_.*', '<p>\n	About split user into different groups</p>\n', 10, 1, '2011-12-25 23:20:59', 1, '2011-12-26 01:11:11');

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
