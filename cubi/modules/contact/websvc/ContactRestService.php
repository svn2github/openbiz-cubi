<?php

//include_once MODULE_PATH.'/websvc/lib/WebsvcService.php';
//require_once 'Zend/Json.php';
include_once MODULE_PATH.'/websvc/lib/Array2Xml.php';

class ContactRestService
{
    protected $errCode;
    protected $errMessage;
	protected $resourceDOMap = array('contacts'=>'contact.do.ContactDO');
    
    public function getDOName($resource)
    {
		return $this->resourceDOMap[$resource];
    }
    
    public function get($resource, $id, $request, $response)
    {
        //print ">>>>> reach ContactRestService::get(). Resource Name is $resource. id: $id";
		$DOName = $this->getDOName($resource);
		if (empty($DOName)) {
			$response->status(404);
			$response->body("Resource '$resource' is not found.");
			return;
		}
		$dataObj = BizSystem::getObject($DOName);
		$rec = $dataObj->fetchById($id);
		$format = strtolower($request->params('format'));
		
		$response->status(200);
		if ($format == 'json') {
			$response['Content-Type'] = 'application/json';
			$response->body(json_encode($rec->toArray()));
		}
		else {
			$response['Content-Type'] = "text/xml; charset=utf-8"; 
			$xml = new array2xml('Data');
			$xml->createNode($rec->toArray());
			$response->body($xml);
		}
		return;
    }
}

?>