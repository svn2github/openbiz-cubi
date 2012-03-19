<?php

include_once MODULE_PATH.'/websvc/lib/WebsvcService.php';

class PackageListService extends WebsvcService
{
    protected $packageMasterDO = "packagemstr.master.do.PackageMasterDO";
    protected $packageCategoryDO = "packagemstr.category.do.PackageCategoryDO";
    
    public function foo($args)
    {
        return 'ok';
    }
    
    public function invoke()
    {
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
    
    public function search($args)
    {
        $searchRule = $args['searchrule'];
        $limit = $args['limit'];
        $packageMasterDO = BizSystem::getObject($this->packageMasterDO);
        $dataSet = $packageMasterDO->directFetch($searchRule,$limit);
        $resultArray = $dataSet->toArray();
        return $resultArray;
    }
    
    public function list_categories($args)
    {
        $searchRule = $args['searchrule'];
        $limit = $args['limit'];
        $packageCategoryDO = BizSystem::getObject($this->packageCategoryDO);
        $dataSet = $packageCategoryDO->directFetch($searchRule,$limit);
        $resultArray = $dataSet->toArray();
        return $resultArray;
    }
    
    public function fetchRepoInfo()
    {
    	$dataObj = BizSystem::getObject("myaccount.do.PreferenceDO");
    	$searchRule = "[user_id]='0' AND [name] LIKE 'repo_%'";   
        $resultRecords = $dataObj->directfetch($searchRule);
        $prefRecord = array();
        foreach($resultRecords as $record){
        	$prefRecord["_".$record['name']] = $record["value"];
        }
        return $prefRecord;
    }
}
?>