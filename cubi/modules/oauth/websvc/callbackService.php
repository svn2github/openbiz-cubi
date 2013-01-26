<?php 
require_once MODULE_PATH.'/websvc/lib/WebsvcService.php';
class callbackService extends  WebsvcService
{
	protected $m_oauthProviderDo='oauth.do.OauthProviderDO';
	public function __call($method,$arguments=null)
	{		
		$type=BizSystem::ClientProxy()->getRequestParam("type");  
		
		$redirectURL=BizSystem::ClientProxy()->getRequestParam("redirect_url");
		if($redirectURL)
		{
			BizSystem::sessionContext()->setVar("oauth_redirect_url", $redirectURL);
		}
		
		$assocURL	=BizSystem::ClientProxy()->getRequestParam("assoc_url");
		if($assocURL)
		{
			BizSystem::sessionContext()->setVar("oauth_assoc_url", $assocURL);
		}
		
		// $whitelist_arr = BizSystem::getService(LOV_SERVICE)->getDictionary("oauth.lov.ProviderLOV(Provider)");
		$whitelist_arr=BizSystem::getObject($this->m_oauthProviderDo)->fetchOne("[status]=1 and [type]='{$type}'",1);
		if($whitelist_arr)
		{
			$whitelist_arr=$whitelist_arr->toArray();
		} 
		if(!$whitelist_arr && !in_array($type,$whitelist_arr)){
			throw new Exception('Unknown service');
			return;
		}
		 
		$oatuthType=MODULE_PATH."/oauth/libs/{$type}.class.php";
		if(!file_exists($oatuthType))
		{
			throw new Exception('Unknown type');
			return;
		}
		
		include_once $oatuthType;
		$obj = new $type;
		switch(strtolower($method))
		{
			case "callback":
			case "login":
				break;
			default:
				throw new Exception('Unknown service');
				break;
		}		
		return call_user_func(array($obj,$method));				
	}
}
?>