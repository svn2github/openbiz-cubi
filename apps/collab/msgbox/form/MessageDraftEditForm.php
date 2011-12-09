<?php 
include_once dirname(__FILE__).'/MessageComposeForm.php';
class MessageDraftEditForm extends MessageComposeForm
{
	public function fetchData()
	{
		$_GET["F"]='RPCInvoke';
		return parent::fetchData();
	}	
}
?>