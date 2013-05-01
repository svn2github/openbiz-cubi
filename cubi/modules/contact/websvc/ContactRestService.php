<?php

include_once MODULE_PATH.'/websvc/lib/RestService.php';

class ContactRestService extends RestService
{
	protected $resourceDOMap = array('contacts'=>'contact.do.ContactDO');
}
?>