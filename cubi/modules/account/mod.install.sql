-- Dumping structure for table: `account`

DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `employee` int(11) NOT NULL,
  `annual_revenue` float NOT NULL,
  `billing_country` varchar(255) NOT NULL,
  `billing_zip` int(11) NOT NULL,
  `billing_state` varchar(255) NOT NULL,
  `billing_city` varchar(255) NOT NULL,
  `billing_street` varchar(255) NOT NULL,
  `shipping_country` varchar(255) NOT NULL,
  `shipping_zip` int(11) NOT NULL,
  `shipping_state` varchar(255) NOT NULL,
  `shipping_city` varchar(255) NOT NULL,
  `shipping_street` varchar(255) NOT NULL,
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

-- Dumping structure for table: `account_industry`

DROP TABLE IF EXISTS `account_industry`;
CREATE TABLE `account_industry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `owner_id` int(11) DEFAULT '0',
  `group_id` int(11) DEFAULT '1',
  `group_perm` int(11) DEFAULT '1',
  `other_perm` int(11) DEFAULT '1',
  `status` int(2) NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Industry ';

