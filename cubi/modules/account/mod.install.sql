-- Dumping structure for table: `account`

DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` VARCHAR( 255 ) NOT NULL,
  `description` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `employee` int(11) NOT NULL,
  `annual_revenue` float NOT NULL,
  `owner_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `group_perm` int(11) NOT NULL,
  `other_perm` int(11) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='CRM Account';


DROP TABLE IF EXISTS `account_related`;
CREATE TABLE IF NOT EXISTS `account_related` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL DEFAULT '0',
  `related_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `related_id` (`related_id`),
  KEY `account_id` (`account_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `account_type`;
CREATE TABLE IF NOT EXISTS `account_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(255) NOT NULL,
  `sortorder` int(11) NOT NULL,
  `group_id` int(11) DEFAULT '1',
  `group_perm` int(11) DEFAULT '1',
  `other_perm` int(11) DEFAULT '1',
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;


DROP TABLE IF EXISTS `account_billing_address` ;
CREATE TABLE IF NOT EXISTS `account_billing_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,  
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `zip` int(11) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `account_shipping_address` ;
CREATE TABLE IF NOT EXISTS `account_shipping_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,  
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `zip` int(11) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `account_user` ;
CREATE TABLE IF NOT EXISTS `account_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `access_level` int(10) unsigned NOT NULL DEFAULT '0',
  `default` int(10) unsigned NOT NULL DEFAULT '0',
  `status` int(10) unsigned NOT NULL DEFAULT '0',
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,  
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `account_contact` ;
CREATE TABLE IF NOT EXISTS `account_contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL DEFAULT '0',
  `contact_id` int(10) unsigned NOT NULL DEFAULT '0',
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,  
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `contact_id` (`contact_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;




DROP TABLE IF EXISTS `account_product` ;
CREATE TABLE IF NOT EXISTS `account_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



-- Dumping structure for table: `account_billing_address`

DROP TABLE IF EXISTS `account_billing_address`;
CREATE TABLE `account_billing_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `zip` int(11) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- Dumping structure for table: `account_shipping_address`

DROP TABLE IF EXISTS `account_shipping_address`;
CREATE TABLE `account_shipping_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `zip` int(11) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

