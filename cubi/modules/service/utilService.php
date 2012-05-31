<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.service
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

class utilService
{
	public static function format_bytes($size){		
	    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
	    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
	    return round($size, 2).$units[$i];	 
	}
	
	public static function getViewURL($viewName)
	{
		$urlArr = explode(".",$viewName);
		$view = str_replace("View", "", $urlArr[2]);		
		preg_match_all("/([A-Z]{1}[a-z]+)/s",$view,$match);
		foreach($match[0] as $view_part)
		{
			$view_url .= strtolower($view_part).'_';
		}
		$view_url = substr($view_url,0,strlen($view_url)-1);
		$url = $urlArr[0].'/'.$view_url;
		return $url;
	}
}
?>