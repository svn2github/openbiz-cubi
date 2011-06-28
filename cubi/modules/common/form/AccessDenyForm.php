<?php 
class AccessDenyForm extends EasyForm
{

	
    public function setSessionVars($sessionContext)
    {
    	$current_url = $_SERVER['REQUEST_URI'];
		$sessionContext->setObjVar("SYSTEM", "LastViewedPage", $current_url);
		parent::setSessionVars($sessionContext);
    }	
}
?>