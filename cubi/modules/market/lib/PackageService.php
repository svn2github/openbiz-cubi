<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.market.lib
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

include_once(MODULE_PATH."/common/lib/fileUtil.php");
include_once(MODULE_PATH."/common/lib/httpClient.php");
include_once(MODULE_PATH."/system/lib/ModuleLoader.php");

class PackageService extends MetaObject
{
	
	public function discoverFeaturedApps($uri,$formParams=array())
	{
		$params['formParams'] = $formParams;
		return $this->_remoteCall($uri,'fetchFeaturedApps',$params);
	}	
	
	public function discoverRepository($uri)
	{
		return $this->_remoteCall($uri,'fetchRepoInfo');
	}
	
	public function discoverCategory($uri)
	{
		return $this->_remoteCall($uri,'fetchCategories');
	}
	
	public function discoverApplication($uri,$cat_id,$formParams=array())
	{
		if($cat_id){			
			$params['cat_id'] = $cat_id; 
		}else{
			$params['cat_id'] = null;
		}
		$params['formParams'] = $formParams;
		return $this->_remoteCall($uri,'fetchApplications',$params);
	}	
	
	public function discoverAppInfo($uri,$app_id)
	{
		if($app_id){
			$params['app_id'] = $app_id; 
		}else{
			$params['app_id'] = null;
		}		
		return $this->_remoteCall($uri,'fetchAppInfo',$params);
	}	
	
	public function discoverAppList($uri,$appIds)
	{
		if($appIds){
			$params['app_ids'] = $appIds; 
		}else{
			$params['app_ids'] = null;
		}		
		return $this->_remoteCall($uri,'fetchAppList',$params);
	}
	
	
	public function discoverAppLatestRelease($uri,$app_id)
	{
		if($app_id){
			$params['app_id'] = $app_id; 
		}else{
			$params['app_id'] = null;
		}		
		return $this->_remoteCall($uri,'fetchAppLatestRelease',$params);
	}	
	
	public function discoverNewAppRelease($uri,$timestamp)
	{
		$params['timestamp'] = $timestamp;	
		return $this->_remoteCall($uri,'fetchNewAppRelease',$params);
	}	
	
	public function discoverAppPics($uri,$app_id)
	{
		if($app_id){
			$params['app_id'] = $app_id; 
		}else{
			$params['app_id'] = null;
		}		
		return $this->_remoteCall($uri,'fetchAppPics',$params);
	}	
	
	protected function _remoteCall($uri,$method,$params=null)
    {
        $cache_id = md5($this->m_Name.$uri. $method .serialize($params));         
        $cacheSvc = BizSystem::getService(CACHE_SERVICE,1);
        $cacheSvc->init($this->m_Name,$this->m_CacheLifeTime);        		
    	if(substr($uri,strlen($uri)-1,1)!='/'){
        	$uri .= '/';
        }
        
        $uri .= "ws.php/repository/RepositoryService";            
           
        if($cacheSvc->test($cache_id) && (int) $this->m_CacheLifeTime>0)
        {
            $resultSetArray = $cacheSvc->load($cache_id);
        }else{
        	try{        		
		        $argsJson = urlencode(json_encode($params));
		        $lang = i18n::getCurrentLangCode();
        		$query = array(	"method=$method","format=json","argsJson=$argsJson","lang=$lang");
		        
		        $httpClient = new HttpClient('POST');
		        foreach ($query as $q)
		            $httpClient->addQuery($q);
		        $headerList = array();
		        $out = $httpClient->fetchContents($uri, $headerList);		        
		        $cats = json_decode($out, true);
		        $resultSetArray = $cats['data'];
		        $cacheSvc->save($resultSetArray,$cache_id);
        	}
        	catch(Exception $e)
        	{
        		$resultSetArray = array();
        	}
        }        
        return $resultSetArray;
    }
    
 
}
?>