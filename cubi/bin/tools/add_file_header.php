<?php

if ($argc<2) {
	echo "usage: php add_file_header.php module".PHP_EOL;
	exit;
}

include_once ("../app_init.php");

$module = $argv[1];
$moduleDir = MODULE_PATH.DIRECTORY_SEPARATOR.$module;

$php_header = "/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.%PACKAGE%
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 */\n\n";

$xml_header = "<!--
  Openbiz Cubi Application Platform
  LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
  Copyright (c) 2005-2011, Openbiz Technology LLC
-->\n";

// loop module directory
$files = glob_recursive($moduleDir."/*.php");
foreach ($files as $file) {
	echo "Add php header to $file \n";
	$content = file_get_contents($file);
	if (strpos($content, " * Openbiz Cubi Application Platform") === false) {
		$new_content = preg_replace("/<\?php[ ]*(\r?\n)/", "<?php"."\n".$php_header, $content);
		file_put_contents($file, $new_content);
	}
	else {
		echo "Skipped.\n";
	}
}

$files = glob_recursive($moduleDir."/*.xml");
foreach ($files as $file) {
	echo "Add xml header to $file \n";
	$content = file_get_contents($file);
	if (strpos($content, "  Openbiz Cubi Application Platform") === false) {
		$lines = file($file);
		$new_content = "";
		for ($i=0; $i<count($lines); $i++) {
			$new_content .= $lines[$i];
			if ($i==0) {
				$new_content .= $xml_header;
			}
		}
		file_put_contents($file, $new_content);
	}
	else {
		echo "Skipped.\n";
	}
}

function glob_recursive($pattern, $flags = 0)
{
	$files = glob($pattern, $flags);
   
	foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir)
	{
		$files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
	}
   
	return $files;
}
?>