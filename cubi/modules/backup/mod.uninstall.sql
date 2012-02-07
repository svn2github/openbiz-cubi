DROP TABLE IF EXISTS `backup_device`;
DELETE FROM `cronjob` WHERE `name`='Weekly Backup Entire System';
DELETE FROM `cronjob` WHERE `name`='Daily Backup System DB';