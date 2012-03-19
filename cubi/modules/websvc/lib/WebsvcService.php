<?php

include_once 'WebsvcError.php';
include_once 'WebsvcResponse.php';

class WebsvcService
{   
    public $errorCode = 0;
    public $m_WebsvcDO = "websvc.do.WebsvcDO";
    public $m_PublicMethods;
    public $m_MessageFile;
    public $m_Messages;
    public $m_RequireAuth = "N";

    function __construct(&$xmlArr)
    {      
        $this->readMetadata($xmlArr);
    }

    protected function readMetadata(&$xmlArr)
    {      
        $this->m_RequireAuth = isset($xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["REQUIREAUTH"]) ? $xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["REQUIREAUTH"] : 'N';
        $this->m_RequireAuth = strtoupper($this->m_RequireAuth);
        $this->m_PublicMethods = new MetaIterator($xmlArr["PLUGINSERVICE"]["PUBLICMETHOD"],"PublicMethod",$this);
        $this->m_MessageFile = isset($xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["MESSAGEFILE"]) ? $xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["MESSAGEFILE"] : null;
        $this->m_Messages = Resource::loadMessage($this->m_MessageFile);
    }
/*
      - authenticate($api_key, $secret)
      - checkAccess($api_key, $secret, $method)
      - invoke($method, $params)
      - printOutput($format, $response)
      - Error_Code
*/
    public function invoke()
    {
        $username = $this->getInput('username');
        $api_key = $this->getInput('api_key');
        $secret = $this->getInput('secret');
        $format = $this->getInput('format');
        
        if($this->m_RequireAuth=='Y'){
	        if ($this->authenticate($username, $api_key, $secret) == false) {
	            $this->output(null, $format);
	            return;
	        }
        }
        
        $service = $this->getInput('service');
        $method = $this->getInput('method');
        if ($this->checkAccess($username, $method) == false) {
            $this->output(null, $format);
            return;
        }
        
        // read inputs
        $args = $this->getInputArgs('args');
        
        // call function
        $response = $this->$method($args);
                
        $this->output($response, $format);
    }
    
    protected function getInput($name)
    {
        $val = isset($_POST[$name]) ? $_POST[$name] : null;
        //$val = isset($_REQUEST[$name]) ? $_REQUEST[$name] : null;
        return $val;
    }
    
    protected function getInputArgs()
    {
        if (isset($_POST['argsJson'])) {
            $argsJson = $_POST['argsJson'];
            $args = json_decode($argsJson, true);
            return $args;
        }
        // read 'arg_name' or 'argsJson'
        $args = array();
        foreach ($_POST as $name=>$val) {
            if (strpos($name, 'arg_') === 0) {
                list($arg, $key) = explode('_', $name);
                $args[$key] = $val;
            }
        }
        return $args;
    }
    
    protected function authenticate($username, $api_key, $secret=null)
    {
        $websvcDO = BizSystem::getObject($this->m_WebsvcDO);
        $searchRule = "[username]='$username' AND [api_key]='$api_key'";
        if ($secret)
            $searchRule .= " AND [secret]='$secret'";
        $record = $websvcDO->fetchOne($searchRule);
        if (!$record) {
            $this->errorCode = WebsvcError::INVALID_APIKEY;
            return false;
        }
        return true;        
    }
    
    /*
      <Service Name=...>
      <PublicMethod Name=... Access=.../>
      <PublicMethod Name=... Access=.../>
    */
    protected function checkAccess($username, $method)
    {
        // check if the method is defined in public methods
        $validMethod = false;
        foreach ($this->m_PublicMethods as $pmethod)
        {
            if ($method == $pmethod->m_Name) {
                $validMethod = true;
                break;
            }
        }
        if (!$validMethod) {
            $this->errorCode = WebsvcError::INVALID_METHOD;
            return false;
        }
        
        $access = $pmethod->m_Access;
        return $this->checkPermission($username, $access);
    }
    
    protected function checkPermission($username, $access)
    {
        if (!$access) return true;
        // check user ACL 
        // load user profile first and check profile against public method Access
        $profileSvc = BizSystem::getService(PROFILE_SERVICE);
        $profile = $profileSvc->InitProfile($username);
        //echo $access; print_r($profile); exit;
        $aclSvc = BizSystem::getService(ACL_SERVICE);
        if (!$aclSvc->checkUserPerm($profile, $access)) {
            $this->errorCode = WebsvcError::NOT_AUTH;
            return false;
        }
        return true;
    }
    
    protected function output($response=null, $format='xml')
    {
        $errMsg = WebsvcError::getErrorMessage($this->errorCode);
        $wsResp = new WebsvcResponse();
        $wsResp->setError($this->errorCode, $errMsg);
        $wsResp->setData($response);
        $wsResp->output($format);
    }
}

class PublicMethod
{
    public $m_Name;
    public $m_Access;

    /**
     * Contructor, store form info from array to variable of class
     *
     * @param array $xmlArr array of form information
     */
    public function __construct($xmlArr)
    {
        $this->m_Name = $xmlArr["ATTRIBUTES"]["NAME"];
        $this->m_Access = $xmlArr["ATTRIBUTES"]["ACCESS"];
    }
}
?>