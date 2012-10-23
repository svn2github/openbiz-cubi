<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.license.websvc
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id: LicenseService.php 3361 2012-05-31 06:01:42Z rockyswen@gmail.com $
 */


include_once MODULE_PATH.'/websvc/lib/WebsvcService.php';
include_once MODULE_PATH.'/license/lib/LicenseUtil.php';

class LicenseService extends WebsvcService
{
    protected $errCode;
    protected $errMessage;
    protected $licenseRequest;
    protected $matchRecord;
    const LICENSE_DO = 'license.do.LicenseDO';
	const CONTACT_DO = 'contact.do.ContactDO';
	const ACTCODE_DO = 'license.do.LicActcodeDO';
	const POLICY_DO = 'license.do.LicPolicyDO';
    
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
    
	/* args includes contact_email(or contact_id), activation_code, server_data
		1. find the contact
		2. find activation code 
		3. check if license exists per given contact and activation code
		4. create a license per given contact and activation code
	*/
	public function acquireLicense($args)
	{
		/* find the contact
		$contact_email = $args['contact_email'];
		$contactDo = BizSystem::getObject(CONTACT_DO);
		$contactRec = $contactDo->fetchOne("[email]='$contact_email'");
		// return error if no contact found
		$contactRecId = $contactRec['Id'];
		*/
		
        $activation_code = $args['activation_code'];
		$serverDomain = $args['server_domain'];
		$serverIp = $args['server_ip'];
		$serverData = $args['server_data'];
		$rawServerData = base64_decode($args['server_data']);
		
		// find activation code 
		$actcodeDo = BizSystem::getObject(self::ACTCODE_DO);
		$actcodeRec = $actcodeDo->fetchOne("[activation_code]='$activation_code' AND [status]=1");
		// return error if no actcode found
		if (!$actcodeRec) {
			$this->errorCode = WebsvcError::SERVICE_ERROR;
            $this->errMessage = "Unable to find matching activation code.";
            return null;
		}
		if (empty($actcodeRec['contact_id'])) {
			$this->errorCode = WebsvcError::SERVICE_ERROR;
            $this->errMessage = "The activation code does not have contact.";
            return null;
		}
		$contactRecId = $actcodeRec['contact_id'];
		$sku = $actcodeRec['sku'];
		
		// get policy data from the act code, verify policy with client request data
		$policyDo = BizSystem::getObject(self::POLICY_DO);
		$policyRec = $policyDo->fetchById($actcodeRec['policy_id']);
		$expireDays = $policyRec['time_limit'];
		$time_limit = $expireDays * 24*3600;
		
		// get license data object
		$licenseDo = BizSystem::getObject(self::LICENSE_DO);
		// check if license exists per given contact and activation code
		$licenseRec = $licenseDo->fetchOne("[contact_id]=$contactRecId AND [activation_code]='$activation_code'");
		// TODO: return error if existing license record expires or does not match server info
		
		// call make license command to create a new license
		$result = $this->_generateLicense($sku, $rawServerData, $expireDays);
		
		// create a license record per given contact and activation code
		if ($result && !$licenseRec) {
			$dataRecord = new DataRecord(null, $licenseDo);
			$dataRecord['contact_id'] = $contactRecId;
			$dataRecord['sku'] = $sku;
			$dataRecord['activation_code'] = $activation_code;
			$dataRecord['policy_id'] = $actcodeRec['policy_id'];
			$dataRecord['license_key'] = $sku.'-'.$activation_code.'-'.$contactRecId;
			$dataRecord['license_data'] = $result['license_content'];
			$dataRecord['start_time'] = date('y-m-d',time());	// now
			$dataRecord['end_time'] = date('y-m-d',time()+$time_limit);	// now + time limit of license policy
			$dataRecord['server_domain'] = $serverDomain;	// set server domain name if policy requires
			$dataRecord['server_ip'] = $serverIp;	// set server ip if policy requires
			$dataRecord['server_data'] = $serverData;	// set server data if policy requires
			$dataRecord->save();
		}
		return $result;
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
	
	protected function _generateLicense($sku, $serverData, $expireDays)
    {
        $now = time();
        // save the serverData to a tmp file
		if (empty($serverData)) {
			$serverDataFile = null;
		}
		else {
			$serverDataFile = LicenseUtil::serverDataPath."/sd_$now"; 
			if (file_put_contents($serverDataFile, $serverData) === false) {
				$this->errorCode = WebsvcError::SERVICE_ERROR;
				$this->errMessage = "Unable to write server data to file $serverDataFile.";
				return null;
			}
		}
        
        // decode server data to save to table
        //$clearServerData = LicenseUtil::decodeServerData($serverDataFile);
        
        $pass = LicenseUtil::getPassPhrase($sku);
        $licenseFile = LicenseUtil::licensePath."/lic_$now";
        
        // generate license file
        LicenseUtil::generateLicense($pass, $expireDays, $serverDataFile, $licenseFile);
        
        // read the license file
        if (file_exists($licenseFile)) {
            $licenseText = file_get_contents($licenseFile);
            
            $licenseFileName = LicenseUtil::getLicenseFilename($sku);
            $licenseExpireDate = date('c', time() + $expireDays*3600*24);
            
            $resultArray['license_content'] = $licenseText;
            $resultArray['license_name'] = $licenseFileName;
            $resultArray['expire_date'] = $licenseExpireDate;
        }
        else {
            $this->errorCode = WebsvcError::SERVICE_ERROR;
            $this->errMessage = "Unable to create license.";
            return null;
        }
        return $resultArray;
    }
	
	/*
    public function generateTrialLicense($args)
    {
        $key = LicenseUtil::getTrialKey();
        $package = $args['package'];
        $serverData = base64_decode($args['server_data']);
        $userInfo = $args['user_info'];
        $expireDays = LicenseUtil::getTrialDays();
        $this->licenseRequest = array('key'=>$key,'package'=>$package, 'user_info'=>$userInfo);
        
        $resultArray = $this->_generateLicense($package, $serverData, $expireDays);
        return $resultArray;
    }
    
    public function generateFullLicense($args)
    {
        $key = $args['key'];
        $package = $args['package'];
        $serverData = base64_decode($args['server_data']);
        $userInfo = $args['user_info'];
        $this->licenseRequest = array('key'=>$key,'package'=>$package, 'user_info'=>$userInfo);

        $resultArray = $this->_generateLicense($package, $serverData, null);
        return $resultArray;
    }
    
    protected function _generateLicense($package, $serverData, $expireDays)
    {
        $now = time();
        // save the serverData to a tmp file
        $serverDataFile = LicenseUtil::serverDataPath."/sd_$now"; 
        if (file_put_contents($serverDataFile, $serverData) === false) {
            $this->errorCode = WebsvcError::SERVICE_ERROR;
            $this->errMessage = "Unable to write server data to file $serverDataFile.";
            return null;
        }
        
        // decode server data to save to table
        $clearServerData = LicenseUtil::decodeServerData($serverDataFile);
        
        $key = $this->licenseRequest['key'];
        if ($key != 'TRIAL') {
            $licRecord = $this->findLicenseRecord($key, $package);
            if ($licRecord) {
                $expireDays = $licRecord['renew_days'];
                $this->matchRecord = $licRecord;
            }
            else {
                $this->errorCode = WebsvcError::SERVICE_ERROR;
                $this->errMessage = "Unable to create license - your license key is not valid.";
                return null;
            }
        }
        
        // match server data with existing user license record
        $allowLicense = $this->matchUserLicense($clearServerData);
        if ($allowLicense == -1) {
            $this->errorCode = WebsvcError::SERVICE_ERROR;
            $this->errMessage = "Unable to create license - the same server has acquired the license before.";
            return null;
        }
        
        $pass = LicenseUtil::getPassPhrase($package);
        $licenseFile = LicenseUtil::licensePath."/lic_$now";
        
        // generate license file
        LicenseUtil::generateLicense($pass, $expireDays, $serverDataFile, $licenseFile);
        
        // read the license file
        if (file_exists($licenseFile)) {
            $licenseText = file_get_contents($licenseFile);
            
            $licenseFileName = LicenseUtil::getLicenseFilename($package);
            $licenseExpireDate = date('c', time() + $expireDays*3600*24);
            
            $resultArray['license_content'] = $licenseText;
            $resultArray['license_name'] = $licenseFileName;
            $resultArray['expire_date'] = $licenseExpireDate;
            
            // save user license 
            $this->saveUserLicense($licenseExpireDate, $clearServerData);
        }
        else {
            $this->errorCode = WebsvcError::SERVICE_ERROR;
            $this->errMessage = "Unable to create license.";
            return null;
        }
        return $resultArray;
    }
    */

    /*
    protected function saveUserLicense($licenseExpireDate, $clearServerData)
    {
        $licenseDo = BizSystem::getObject(self::LICENSE_DO);
        $key = $this->licenseRequest['key'];
        $package = $this->licenseRequest['package'];
        if (!$this->matchRecord) {
            $dataRec = new DataRecord(null, $licenseDo);
        }
        else {
            $dataRec = new DataRecord($this->matchRecord, $licenseDo);
        }
        
        $dataRec['license_key'] = $key;
        $dataRec['package'] = $package;
        $dataRec['server_data'] = $clearServerData;
        $dataRec['expire_on'] = $licenseExpireDate;
        $dataRec['user_info'] = $this->licenseRequest['user_info'];
        $dataRec['cur_use'] = isset($dataRec['cur_use']) ? $dataRec['cur_use']+1 : 1;
        
        try {
            $dataRec->save();
        }
        catch (Exception $e) {
            throw new Exception("saveLocalPackgeRecord. Unable to save the record. ".$e->getMessage());
        }
        return true;
    }
*/    
    /*
     * match license request with existing license record
     * @return 
     *      0 if no existing record, 
     *      1 if find existing record and can issue new license, 
     *      -1 find existing record but cannot issue new license
     */
    /*protected function matchUserLicense($clearServerData)
    {
        $licenseDo = BizSystem::getObject(self::LICENSE_DO);
        $key = $this->licenseRequest['key'];
        $package = $this->licenseRequest['package'];
        
        $MACs = LicenseUtil::getAdapterMACs($clearServerData);
        foreach ($MACs as $mac) {
            $searchRule = "[license_key]='$key' AND [package]='$package' AND [server_data] like '%$mac%'";
            $record = $licenseDo->fetchOne($searchRule);
            if ($record) {
                $this->matchRecord = $record;
                // check usage count
                if ($record['max_use'] <= $record['cur_use'])
                    return -1;
                else
                    return 1;
            }
        }
        return 0;
    }
    
    protected function findLicenseRecord($key, $package)
    {
        $licenseDo = BizSystem::getObject(self::LICENSE_DO);
        // search by key and package first
        $searchRule = "[license_key]='$key' AND [package]='$package'";
        $record = $licenseDo->fetchOne($searchRule);
        return $record;
    }*/
}

?>