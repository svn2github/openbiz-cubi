<?php
header("Cache-Control: no-cache"); 
header("Pragma: no-cache");
if(is_file(dirname(__FILE__).'/files/install.lock') && filesize(dirname(__FILE__).'/files/install.lock')==1){
	include 'bin/_forward.php';	
}else{
	$script_name = $_SERVER['SCRIPT_NAME'];
	$url = str_replace("index.php","install/",$script_name);
	echo "<script>location.href='$url'</script>";
	exit;	
}
?>
