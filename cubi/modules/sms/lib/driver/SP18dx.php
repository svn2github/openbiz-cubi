<?php 
require_once 'iSMS.php';
//SP = Service Provider 18dx

class SP18dx implements iSMS
{
	protected $m_ProviderId = 1;
	
	protected function _getProviderInfo()
	{
		
	}
	
	public function send($mobile,$content)
	{
		$providerInfo = $this->_getProviderInfo();
			
	}

    public function getSenCount()
    {
    	$providerInfo = $this->_getProviderInfo();
    	
    }
}
?>