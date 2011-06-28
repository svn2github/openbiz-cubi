<?php
function ob_scandir($dir)
{
    $retDirs = null;
    $dir0s = scandir($dir);
    foreach ($dir0s as $dir0) {
        if (( $dir0 == '.' ) || ( $dir0 == '..' ) || ( $dir0 == '.svn' )) continue;
        $retDirs[] = $dir0;
    }
    //print_r($retDirs);
    return $retDirs;
}

function recurse_copy($src,$dst) {
    if(!is_dir($src)){
		return;
	}
    $dir = opendir($src);
    @mkdir($dst, 0777, true);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' ) && ( $file != '.svn' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
} 

?>