DROP TABLE IF EXISTS `backup_device`;
CREATE TABLE IF NOT EXISTS `backup_device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,  
  `sortorder` int(11) NOT NULL,
  `system` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `backup_device` VALUES (1,'Cubi Storage','{APP_FILE_PATH}/backup','Openbiz Cubi in system default backup files storage area.',50,1,1,1,'2011-04-16 12:44:45',1,'2011-04-16 05:06:37');