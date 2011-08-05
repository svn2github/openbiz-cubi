<?php
include_once "../../bin/app_init.php";

/*
 * test user email service
 */

// test sample
$emailSvc = BizSystem::getService(USER_EMAIL_SERVICE);
echo $emailSvc->UserWelcomeEmail(4);


?>