<?php 
class ContactGrabberService
{
	public function __construct()
	{
		require_once 'Zend/Loader.php';
	    Zend_Loader::loadClass('Zend_Gdata');
	    Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
	    Zend_Loader::loadClass('Zend_Http_Client');
	    Zend_Loader::loadClass('Zend_Gdata_Query');
	    Zend_Loader::loadClass('Zend_Gdata_Feed');
	}
	
	public static function ValidateCredential($credential, $provider){
		$dataSource = BizSystem::GetObject($provider);
		$result = $dataSource->ValidateCredential($credential);
		return $result;
	}
	
	public static function FetchContacts($credential, $provider)
	{
		$dataSource = BizSystem::GetObject($provider);
		$result = $dataSource->FetchContacts($credential);
		$svcobj=BizSystem::getService("service.chineseService");
		
		for($i=0;$i<count($result);$i++)
		{	        
	        if($svcobj->isChinese($result[$i]['display_name']))
	        {
	        	$fast_index = $svcobj->Chinese2Pinyin($result[$i]['display_name']);
	        }
	        else
	        {
	        	$fast_index = $result[$i]['display_name'];
	        }
	        $result[$i]['fast_index']= substr($fast_index,0,1); 
		}
		return $result;
	}
}
?>