-- Dumping structure for table: `accounting_book`

DROP TABLE IF EXISTS `accounting_book`;
CREATE TABLE `accounting_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `parent_id` int(11) DEFAULT NULL COMMENT 'Parent Account Book',
  `owner_id` int(11) DEFAULT '0',
  `group_id` int(11) DEFAULT '1',
  `group_perm` int(11) DEFAULT '1',
  `other_perm` int(11) DEFAULT '1',
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Account books';

-- Dumping structure for table: `accounting_book_type`

DROP TABLE IF EXISTS `accounting_book_type`;
CREATE TABLE `accounting_book_type` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping structure for table: `accounting_record`

DROP TABLE IF EXISTS `accounting_record`;
CREATE TABLE `accounting_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `credit` float DEFAULT NULL COMMENT 'Credit',
  `debit` float DEFAULT NULL COMMENT 'Debit',
  `trans_id` varchar(255) NOT NULL COMMENT 'Unique Transcation ID',
  `trans_date` datetime NOT NULL COMMENT 'Transcation Date',
  `trans_type` varchar(255) DEFAULT NULL COMMENT 'credit(out) / debit (in)',
  `trans_proof` varchar(255) DEFAULT NULL COMMENT 'Proof for this transcation',
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Account records';

-- Dumping structure for table: `accounting_record_type`

DROP TABLE IF EXISTS `accounting_record_type`;
CREATE TABLE `accounting_record_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(255) NOT NULL,
  `sortorder` int(11) NOT NULL,
  `create_by` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



ALTER TABLE `accounting_record` ADD `accountbook_id` int(11) NULL COMMENT 'FK for Account Book' AFTER `id`
