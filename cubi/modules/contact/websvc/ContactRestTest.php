<?php
$cubiPath = dirname(dirname(dirname(dirname(__FILE__))));
// defined Zend framework library home as ZEND_FRWK_HOME
define('ZEND_FRWK_HOME', $cubiPath."/openbiz/others/");
// add zend framework to include path
set_include_path(get_include_path() . PATH_SEPARATOR . ZEND_FRWK_HOME);

require_once 'Zend/Http/Client.php';

define('REST_URL_GET', 'http://localhost/gcubi/cubi/rest.php/contact/contacts');
define('REST_URL_POST', 'http://localhost/gcubi/cubi/rest.php/contact/contacts');
define('REST_URL_PUT', 'http://localhost/gcubi/cubi/rest.php/contact/contacts');

class ContactRestTest
{
	public function testGet($id)
	{
		$client = new Zend_Http_Client(REST_URL_GET.'/'.$id);
		$response = $client->request('GET');
		print_r($response);
	}
	
	public function testPost($record)
	{
		$client = new Zend_Http_Client(REST_URL_POST);
		$client->setRawData(json_encode($record));
		$response = $client->request('POST');
		print_r($response);
	}
	
	public function testPut($record, $id)
	{
		$client = new Zend_Http_Client(REST_URL_PUT.'/'.$id);
		$client->setRawData(json_encode($record));
		$response = $client->request('PUT');
		print_r($response);
	}
}

$restTest = new ContactRestTest();
//$restTest->testGet(1);

$contactRec = array('email'=>'test@gmail.com','first_name'=>'John','last_name'=>'Smith','company'=>'ibm');
//$restTest->testPost($contactRec);

$contactRec = array('email'=>'test@gmail.com','first_name'=>'Steve','last_name'=>'Johnson','company'=>'ibm');
$restTest->testPut($contactRec, 9);
?>