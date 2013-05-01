<?php
$cubiPath = dirname(dirname(dirname(dirname(__FILE__))));
// defined Zend framework library home as ZEND_FRWK_HOME
define('ZEND_FRWK_HOME', $cubiPath."/openbiz/others/");
// add zend framework to include path
set_include_path(get_include_path() . PATH_SEPARATOR . ZEND_FRWK_HOME);

require_once 'Zend/Http/Client.php';

define('REST_URL_QUERY', 'http://localhost/gcubi/cubi/rest.php/contact/contacts/q');
define('REST_URL_GET', 'http://localhost/gcubi/cubi/rest.php/contact/contacts');
define('REST_URL_POST', 'http://localhost/gcubi/cubi/rest.php/contact/contacts');
define('REST_URL_PUT', 'http://localhost/gcubi/cubi/rest.php/contact/contacts');
define('REST_URL_DELETE', 'http://localhost/gcubi/cubi/rest.php/contact/contacts');

class ContactRestTest
{
	public function testQuery($queryFields, $format='xml')
	{
		$client = new Zend_Http_Client(REST_URL_QUERY.'?format='.$format);
		$client->setParameterGet(queryFields);
		$response = $client->request('GET');
		print $response->getBody();
	}
	
	public function testGet($id, $format='xml')
	{
		$client = new Zend_Http_Client(REST_URL_GET.'/'.$id.'?format='.$format);
		$response = $client->request('GET');
		print $response->getBody();
	}
	
	public function testPost($record, $format='xml')
	{
		$client = new Zend_Http_Client(REST_URL_POST.'?format='.$format);
		$client->setRawData(json_encode($record));
		$response = $client->request('POST');
		print $response->getBody();
	}
	
	public function testPut($record, $id, $format='xml')
	{
		$client = new Zend_Http_Client(REST_URL_PUT.'/'.$id.'?format='.$format);
		$client->setRawData(json_encode($record));
		$response = $client->request('PUT');
		print $response->getBody();
	}
	
	public function testDelete($id, $format='xml')
	{
		$client = new Zend_Http_Client(REST_URL_DELETE.'/'.$id.'?format='.$format);
		$response = $client->request('DELETE');
		print $response->getBody();
	}
}

$restTest = new ContactRestTest();
$searchFields = array('first_name'=>'john');
$restTest->testQuery($searchFields,'xml');
$restTest->testQuery($searchFields,'json');

$restTest->testGet(1,'xml');
$restTest->testGet(1,'json');

$contactRec = array('email'=>'test@gmail.com','first_name'=>'John','last_name'=>'Smith','company'=>'ibm');
$restTest->testPost($contactRec);
$restTest->testPost($contactRec,'json');

$contactRec = array('email'=>'test@gmail.com','first_name'=>'Steve','last_name'=>'Johnson','company'=>'ibm');
$restTest->testPut($contactRec, 10);
$restTest->testPut($contactRec, 11, 'json');

$restTest->testDelete(10);
$restTest->testDelete(11,'json');
?>