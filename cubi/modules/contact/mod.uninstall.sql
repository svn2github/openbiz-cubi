DROP TABLE IF EXISTS `contact`;

DROP TABLE IF EXISTS `contact_type`;

/* below for uninstall help tutorial */
DELETE FROM `help_tutorial_user` WHERE `tutorial_id`=(SELECT `id` FROM `help_tutorial` WHERE `url_match`='/contact/contact_list');
DELETE FROM `help_tutorial` WHERE `url_match`='/contact/contact_list';
