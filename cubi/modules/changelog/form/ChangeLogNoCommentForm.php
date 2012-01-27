<?php 
include_once dirname(__FILE__).'/ChangeLogForm.php';
class ChangeLogNoCommentForm extends ChangeLogForm
{	
	protected function readMetadata(&$xmlArr)
    {    						
    	//load message file
    	$this->m_ChangeLogMessages = Resource::loadMessage("changelog.ini" , "changelog");		
    	parent::readMetaData($xmlArr);
    }      
}
?>