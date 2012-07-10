-- Dumping structure for table: `accounting_book`

DROP TABLE IF EXISTS `accounting_book`;
CREATE TABLE `accounting_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
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

INSERT INTO `accounting_book` (`id`, `type_id`, `name`, `description`, `owner_id`, `group_id`, `group_perm`, `other_perm`, `update_by`, `update_time`, `create_by`, `create_time`) VALUES
(1, 1, '现金日账本', '现金日账本', 1, 1, 1, 0, 1, '2012-07-10 10:09:16', 1, '2012-07-06 11:21:06'),
(2, 1, '银行日记帐', '银行日记帐', 1, 1, 1, 0, 1, '2012-07-10 10:09:39', 1, '2012-07-06 21:40:27'),
(3, 5, '交通费账本', NULL, 1, 1, 1, 0, 1, '2012-07-10 10:24:04', 1, '2012-07-10 10:22:25'),
(4, 5, '餐饮费账本', NULL, 1, 1, 1, 0, 1, '2012-07-10 10:25:52', 1, '2012-07-10 10:23:39');


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

INSERT INTO `accounting_book_type` (`id`, `name`, `description`, `color`, `sortorder`, `group_id`, `group_perm`, `other_perm`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, '资金帐本', '主账本 记录所有现金账目', '8fd8ff', 50, 1, 1, 0, 1, '2012-07-05 19:54:41', 1, '2012-07-10 10:15:21'),
(2, '产品分账', '服务与产品类型的收入支出的分账', 'a7fc85', 50, 1, 1, 0, 1, '2012-07-10 10:14:58', 1, '2012-07-10 10:14:58'),
(3, '债权账目', '公司借出去的资金账目，记录借出和归还情况的', '99faea', 50, 1, 1, 0, 1, '2012-07-10 10:16:47', 1, '2012-07-10 10:16:47'),
(4, '资产账目', '公司购买或变卖固定资产的', 'bdbbbb', 50, 1, 1, 0, 1, '2012-07-10 10:18:06', 1, '2012-07-10 10:18:06'),
(5, '管理费用', '日常办公开销和公共支出', 'ff8787', 50, 1, 1, 0, 1, '2012-07-10 10:19:16', 1, '2012-07-10 10:19:16');

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
  `trans_date` date NOT NULL COMMENT 'Transcation Date',
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
