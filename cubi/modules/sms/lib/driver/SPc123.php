<?php 
require_once 'iSMS.php';
//SP = Service Provider 18dx

class SPc123 implements iSMS
{
	protected $m_ProviderId = 2;
	
	protected function _getProviderInfo()
	{
		
	}
	
	public function send($mobile,$content,$delay=null)
	{
		$providerInfo = $this->_getProviderInfo();
			
	}

    public function getSenCount()
    {
    	$providerInfo = $this->_getProviderInfo();
    	
    }
}
?>