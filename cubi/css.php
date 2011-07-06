<?php
// url format. http://host/css.php?f=css/a.css,themes/default/css/b.css&min=1
// e.g. http://host/css.php?f=themes/default/css/system_backend.css
// 
// include app.inc
include_once "bin/app_init.php";

// include minify index
include "bin/min/index.php";

?>