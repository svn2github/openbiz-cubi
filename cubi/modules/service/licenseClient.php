<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.service
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

include_once(MODULE_PATH."/common/lib/fileUtil.php");
include_once(MODULE_PATH."/common/lib/httpClient.php");

class LicenseClient extends MetaObject
{
    protected $_installPackage = "";
    protected $_installModules = array();
    
    public $m_CacheLifeTime = null;	
    
    public $repositoryUrl; // repository url
    
    function __construct(&$xmlArr)
    {
        $this->readMetadata($xmlArr);
    } 
       	
    protected function readMetadata(&$xmlArr)
    {
        parent::readMetadata($xmlArr);
    	$this->repositoryUrl = isset($xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["REPOSITORYURL"]) ? $xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["REPOSITORYURL"] : "";
    }
    
    public function acquireLicense($activationCode, $contactEmail, $serverData)
    {
        //try to process cache service.
        $argsJson = json_encode(array("activation_code"=>$activationCode,"contact_email"=>$contactEmail,"server_data"=>$serverData));
        $query = array(	"method=acquireLicense","format=json",
                        "argsJson=$argsJson");
        $httpClient = new HttpClient('POST');
        foreach ($query as $q)
            $httpClient->addQuery($q);
        $headerList = array();
        $out = $httpClient->fetchContents($this->repositoryUrl, $headerList);
        echo $out;
        $lic = json_decode($out, true);
        $licenseArray = $lic['data'];

        return $licenseArray;
    }
}

?>