<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.common.form
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

class AccessDenyForm extends EasyForm
{
    public function setSessionVars($sessionContext)
    {
    	$current_url = getUrlAddress();
		$sessionContext->setObjVar("SYSTEM", "LastViewedPage", $current_url);
		parent::setSessionVars($sessionContext);
    }
}

function getUrlAddress()
{
    /*** check for https is on or not ***/
    $url = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
    /*** return the full address ***/
    return $url .'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}
?>