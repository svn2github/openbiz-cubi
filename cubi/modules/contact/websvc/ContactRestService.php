<?php

include_once MODULE_PATH.'/websvc/lib/WebsvcService.php';
require_once 'Zend/Json.php';

class ContactRestService
{
    protected $errCode;
    protected $errMessage;
    
    public function foo($args)
    {
        $resultArray['foo'] = "OK";
		return $resultArray;
    }
    
    public function get($resource, $request, $response)
    {
        $resourceName = is_array($resource) ? $resource[0] : $resource;
		print ">>>>> reach ContactRestService::get(). Resource Name is $resourceName. Parameters are: ";
		print_r($request->get());
		return;
		/*
        $username = $this->getInput('username');
        $api_key = $this->getInput('api_key');
        $secret = $this->getInput('secret');
        $format = $this->getInput('format');
        if ($this->authenticate($username, $api_key, $secret) == false) {
            $this->output(null, $format);
            return;
        }
        */
        $format = $this->getInput('format');
        $service = $this->getInput('service');
        $method = $this->getInput('method');
        
        // read inputs
        $args = $this->getInputArgs('args');
        
        // call function
        $response = $this->$method($args);
                
        $this->output($response, $format);
    }

    protected function output($response=null, $format='xml')
    {
        if ($this->errMessage) {
            $errMsg = $this->errMessage;
        }
        else {
            $errMsg = WebsvcError::getErrorMessage($this->errorCode);
        }
        $wsResp = new WebsvcResponse();
        $wsResp->setError($this->errorCode, $errMsg);
        $wsResp->setData($response);
        $wsResp->output($format);
    }
}

?>