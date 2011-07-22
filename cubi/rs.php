<?php
// url format. http://host/css.php?f=css/a.css,themes/default/css/b.css&min=1
// e.g. http://host/css.php?f=themes/default/css/system_backend.css
// 
// include app.inc
//include_once "bin/app_init.php";
define('APP_HOME',dirname(__FILE__));
define('RESOURCE_PATH', APP_HOME.DIRECTORY_SEPARATOR."resources");
define('CACHE_DATA_PATH', APP_HOME.DIRECTORY_SEPARATOR."files".DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR."data");

$file = $_GET['f'];
// get extention of given file
$list = explode('.',$file);
$ext = $list[count($list)-1];
if ($ext == 'jpg' || $ext == 'gif' || $ext == 'png' || $ext == 'swf') {
    include "img.php";
}
else {
    // include minify index
    include "bin/min/index.php";
}
?>