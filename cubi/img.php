<?php
// url format. http://host/img.php?f=images/a.jpg&w=300&h=100
// url format. http://host/img.php?f=themes/default/images/a.jpg&w=300&h=100
// 
// include app.inc
include_once "bin/app.inc";

$MAX_AGE = 604800;  // one week cache

$file = $_GET['f'];
$filename = APP_HOME."/".$file;

// if file not found, show default image
if (!file_exists($filename)) 
    exit;


// get file info
$size = filesize($filename);
$content_type = getContentType($filename);

// prepare the http headers, content-type, size, cache options
$lastModifiedString	= gmdate('D, d M Y H:i:s', filemtime($filename)) . ' GMT';
$etag = md5($data);

doConditionalGet($etag, $lastModified, $MAX_AGE);

header("Content-type: $content_type");
header("Content-Length: $size");

// output the file
$data = file_get_contents($filename);
echo $data;
exit;

function getContentType($filename)
{
    $path_parts = pathinfo($filename);
    $ext = $path_parts['extension'];
    switch($ext){
        case 'jpeg' :
        case 'jpg'  :
            $content_type = "image/jpeg"; break;
        case 'gif' :
            $content_type = "image/gif"; break;
        case 'png' :
            $content_type = "image/png"; break;
        case 'wbmp' :
            $content_type = "image/vnd.wap.wbmp"; break;
        case 'swf' :
            $content_type = "application/x-shockwave-flash"; break;
    }
    return $content_type;
}

function doConditionalGet($etag, $lastModified, $max_age)
{
	header("Last-Modified: $lastModified");
	header("ETag: \"{$etag}\"");
    $expire = gmdate('D, d M Y H:i:s \G\M\T', time() + $max_age;
    header("Expires: $expire");
    header("Cache-Control: max-age=$max_age, must-revalidate");
		
	$if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ?
		stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) : 
		false;
	
	$if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ?
		stripslashes($_SERVER['HTTP_IF_MODIFIED_SINCE']) :
		false;
	
	if (!$if_modified_since && !$if_none_match)
		return;
	
	if ($if_none_match && $if_none_match != $etag && $if_none_match != '"' . $etag . '"')
		return; // etag is there but doesn't match
	
	if ($if_modified_since && $if_modified_since != $lastModified)
		return; // if-modified-since is there but doesn't match
	
	// Nothing has changed since their last request - serve a 304 and exit
	header('HTTP/1.1 304 Not Modified');
	exit();
} // doConditionalGet()

?>