DROP TABLE IF EXISTS `sms_provider`;
DROP TABLE IF EXISTS `sms_log`;
DROP TABLE IF EXISTS `sms_queue`;
DELETE FROM `cronjob` WHERE `name`='Sending SMS Job';