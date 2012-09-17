<?php 
require_once 'iPayment.php';
class PaymentAdapter implements iPayment
{
	protected $m_ProviderId;
	protected $m_ReturnURL = "";
	protected $m_CancelURL = "";
	protected $m_NotifyURL = "";		
	protected $m_Type = '';
		
	protected $m_ProviderDO = "payment.provider.do.ProviderDO";
	protected $m_LogDO = "payment.log.do.LogDO";
	
	protected function _getProviderInfo()
	{
		$ProviderDO = BizSystem::getObject($this->m_ProviderDO);
		$recObj=$ProviderDO->fetchOne("[Id]={$this->m_ProviderId}");
		$recArr=array();
		if($recObj)
		{
			$recArr=$recObj->toArray();
		}
		return $recArr;
	}	
	
	public function __construct()
	{
		$this->m_NotifyURL  = SITE_URL.'ws.php/payment/callback/verify/type_'.$this->m_Type.'/';
		$this->m_ReturnURL  = SITE_URL.APP_INDEX.'/payment/payment_finished/type_'.$this->m_Type.'/';
		$this->m_CancelURL  = SITE_URL.APP_INDEX.'/payment/payment_cancelled/type_'.$this->m_Type.'/';
	}
	
    public function GetPaymentURL($orderId, $amount,  $title=null,$customData=null){}

    public function ValidateNotification($txn_id=null){
    	if(!$txn_id)
    	{
    		$data = $this->GetReturnData();
    		$txn_id = $data['txn_id'];
    	}
    	$this->_log();    	
    }    
    
	public function GetReturnData(){}
	
	public function ProcessCustomTrigger($data)
	{
		//if there is no log record, then process it to make sure its only been process once
		if(!$data['custom'])
    	{
    		return;    		
    	}
    	
		$customObj = json_decode($data['custom']);
    	if(!$customObj)
    	{
    		return;
    	}
    	
    	$txn_id = $data['txn_id'];
    	if($this->CheckLogProcessed($txn_id))
    	{
    		return;
    	}
    	
    	$this->_MarkLogProcessed($txn_id);    	
    	$obj 	= $customObj->object;
    	$method = $customObj->method;
    	$result =  BizSystem::getObject($obj)->$method($data);
    	return $result; 	
	}
	
	protected function _MarkLogProcessed($txn_id)
	{
		$searchRule = "[txn_id]='$txn_id' AND [provider_id]='".$this->m_ProviderId."' ";
		$record = BizSystem::getObject($this->m_LogDO)->fetchOne($searchRule);
		if($record)
		{
			$record['processed']=1;
			$record->save();
			return true;
		}
		return false;
		
	}
	
	public function CheckLogProcessed($txn_id)
	{
		$searchRule = "[txn_id]='$txn_id' AND [provider_id]='".$this->m_ProviderId."' AND [processed]=1";
		$record = BizSystem::getObject($this->m_LogDO)->fetchOne($searchRule);
		if($record)
		{
			return $record['Id'];
		}
		else
		{
			return false;
		}
	}
	
	public function CheckLogExists($txn_id)
	{
		$searchRule = "[txn_id]='$txn_id' AND [provider_id]='".$this->m_ProviderId."' ";
		$record = BizSystem::getObject($this->m_LogDO)->fetchOne($searchRule);
		if($record)
		{
			return $record['Id'];
		}
		else
		{
			return false;
		}
	}
	
    protected  function _log()
    {
    	$logArr = $this->GetReturnData();
    	$logArr['provider_id'] 		= $this->m_ProviderId;
    	$logArr['payer_email'] 		= $logArr['buyer_account'];
    	$logArr['payer_id'] 		= $logArr['buyer_id'];
    	$logArr['payment_subject'] 	= $logArr['subject'];
    	$logArr['payment_amount'] 	= $logArr['amount'];
    	$logArr['payment_status'] 	= $logArr['status']; 
    	$logArr['rawdata'] = serialize($_REQUEST);
    	
    	if(!$this->CheckLogExists($logArr['txn_id']))
    	{
    		BizSystem::getObject($this->m_LogDO)->insertRecord($logArr);
    	} 
    	
    	if($logArr['custom'])
    	{
    		$customArr = json_decode($logArr['custom']);    		
    		if($customArr)
    		{    			    			
    			$this->ProcessCustomTrigger($logArr);
    		}
    	}    	

    	return;
    }	
    
}
?>