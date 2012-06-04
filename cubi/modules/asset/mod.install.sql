
DROP TABLE IF EXISTS `asset`;
CREATE TABLE IF NOT EXISTS `asset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL COMMENT 'Barcode',
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Asset Manage' AUTO_INCREMENT=2 ;



INSERT INTO `asset` (`id`, `type_id`, `name`, `barcode`, `description`, `owner_id`, `group_id`, `group_perm`, `other_perm`, `update_by`, `update_time`, `create_by`, `create_time`) VALUES
(1, 1, 'FreeBSD and OpenBSD Security', '1234567890123', 'Mastering FreeBSD and OpenBSD Security', 1, 1, 1, 0, 1, '2012-06-04 16:48:27', 1, '2012-06-04 16:42:34');


DROP TABLE IF EXISTS `asset_related`;
CREATE TABLE IF NOT EXISTS `asset_related` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0',
  `related_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `related_id` (`related_id`),
  KEY `asset_id` (`asset_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `asset_type`;
CREATE TABLE IF NOT EXISTS `asset_type` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;


INSERT INTO `asset_type` (`id`, `name`, `description`, `color`, `sortorder`, `group_id`, `group_perm`, `other_perm`, `create_by`, `create_time`, `update_by`, `update_time`) VALUES
(1, 'Book', 'Reference Books', 'ffc2c2', 50, 1, 1, 1, 1, '2012-06-04 16:41:16', 1, '2012-06-04 18:21:00'),
(2, 'Equipment', 'Computer Equipments', 'c9e1ff', 50, 1, 1, 1, 1, '2012-06-04 18:18:05', 1, '2012-06-04 18:18:05'),
(3, 'Office Suplies', 'Likes Pencil , Papers etc.', 'd0ffc4', 50, 1, 1, 1, 1, '2012-06-04 18:19:45', 1, '2012-06-04 18:19:45'),
(4, 'Facilities', 'Like Table, Chairs', 'fcffad', 50, 1, 1, 1, 1, '2012-06-04 18:20:48', 1, '2012-06-04 18:20:48'),
(5, 'Miscellaneous', 'Other Staff', 'bbdafc', 50, 1, 1, 1, 1, '2012-06-04 18:24:58', 1, '2012-06-04 18:24:58');