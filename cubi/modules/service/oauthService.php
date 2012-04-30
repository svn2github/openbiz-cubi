<?php 
class oauthService extends MetaObject
{
	/**
	 * 
	 * OAuth type 
	 * e.g.: Taobao or Facebook etc..
	 * @var string
	 */
	protected $m_Type;
		
	/**
	 * 
	 * Temperary cache provider data
	 * @var array
	 */
	protected $m_ProviderData;
		
	/**
	 * 
	 * Data Object for storage users oauth token info
	 * @var string
	 */
	protected $m_UserOAuthDO;
	
	protected $m_Providers;
	
	
    function __construct(&$xmlArr)
    {
        $this->readMetadata($xmlArr);
    } 
       	
    protected function readMetadata(&$xmlArr)
    {
        parent::readMetadata($xmlArr);    
        $this->m_UserOAuthDO 	= isset($xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["USEROAUTHDO"]) ? $xmlArr["PLUGINSERVICE"]["ATTRIBUTES"]["USEROAUTHDO"]: "system.do.UserOAuthDO";
		$this->m_Providers	 	= $this->_readProviders();        
    }	

    protected function _readProviders()
    {
    	$xmlFile = MODULE_PATH.DIRECTORY_SEPARATOR."service".DIRECTORY_SEPARATOR.'oauthService.xml';
    	$xmlArr = BizSystem::getXmlArray($xmlFile);
    	$providersArr=$xmlArr["PLUGINSERVICE"]["PROVIDERS"]['PROVIDER'];
    	foreach($providersArr as $providerInfo){
    		$this->m_Providers[$providerInfo['ATTRIBUTES']['NAME']] = $providerInfo['ATTRIBUTES'];
    	}
    	
    	return $this->m_Providers;
    }
    
	protected function _getProviderData($provider_name = null)
	{
		if($provider_name===null){
			$provider_name = $this->m_Type;
		}
		return $this->m_Providers[$provider_name];
	}    
    
	/**
	 * 
	 * Get OAuth provider data including api_key, api_secret, url etc
	 * @return array;
	 */
	public function getProviderData(){
		if(!$this->m_ProviderData){
			return $this->_getProviderData();
		}else{
			return $this->getProviderData;
		}
	}		
	
	public function getProviderList()
	{
		return $this->m_Providers;
	}
	
	/**
	 * 
	 * abstract functions need to be implement in sub class
	 * Validate if the oauth info still available 
	 * @param intger $user_id
	 * @param intger $oauth_id
	 * @return bool
	 */	
	public function validateUserOAuth($user_id,$oauth_id){}
	
	/**
	 * 
	 * avstract function to check given oauth_data is valid or not
	 * @param array oauth_data
	 * @return bool
	 */
	public function check($oauth_data){}
	
	
	public function saveUserOAuth($user_id, $oauth_data)
	{
		
	}

	public function clearUserOAuth($user_id, $oauth_id)
	{
		
	}

	public function getUserOAuthList($user_id)
	{
		
	}
	

}
?>