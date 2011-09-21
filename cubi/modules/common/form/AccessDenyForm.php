<?php 
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