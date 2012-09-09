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
 * @version   $Id: SmsService.php 3506 2012-06-05  fsliit@gmail.com $
 */
/**
 * User sms service 
 */
class SmsService extends MetaObject
{
	
	const DISPATCH_BY_PRIORITY	=1;
	const DISPATCH_BY_BALANCE	=2;
	const DISPATCH_ROUND_ROBIN	=3;
	
	protected $m_SmsProviderDO='sms.provider.do.ProviderDO';
	protected $m_SmsQueueDO='sms.queue.do.QueueDO';
	protected $m_PreferenceDO='myaccount.do.PreferenceDO';

	protected $m_SmsPreference;
	
	public function __construct()  
    {
		
    } 
    
    /**
     * 
     * public interface for SMS service, 
     * the consumer module could call this function to send out messages
     * 
     * @param $mobile
     * @param $content
     * @param datetime $schdule -- the message will be send on schduled time
     * @param bool $delay    -- if delay is force , then the message will not go into queue , 
     * 							instead of call driverr to send it directly  
     * @param integer $providerId -- if its not null, then used specified provider to send this message
     */
    public function SendSMS($mobile,	$content,	$schdule=null,
    						$delay=true,	$providerCode=null)
    {
		if(!$this->validateMobile($mobile))
		{
			return false;
		}
		if($providerCode)
		{			
			$ProviderObj=$this->_loadProviderDriver($providerCode);
		}
		else
		{
			$ProviderObj=$this->_getProvider();
		}
		
		//加上短信签名		
		$content.=$this->_getContentSignature();				
		
		if($delay==true)
		{
			$result=$this->_addSmsQueueInfo($mobile,$content,$schdule,$providerCode);
		}
		else
		{
			$result=$ProviderObj->send($mobile,$content,$schdule); 
		}
		return $result;
    }
    
    
    /**
     * 
     * this function will update all registered SMS providers message counter,
     * total sent message and remaining message quota will be updated in system.
     */
    public function UpdateProviderCounter()
    {
		 foreach(BizSystem::getObject($this->m_SmsProviderDO)->directFetch("[status]=1") as $providerRec)
		 {	
			$this->getMsgBalance($providerRec['type']); 
		 }
    	return true;
    }
    
    
    
    
	/**
	 * 发送队列中的短信;
	 */
	public function SendSmsFromQueue($SmsQueue=null,$limit=10){
		$SmsProviderDO = BizSystem::getObject($this->m_SmsProviderDO);
		$Provider=$this->_getProvider();
		$return=false;
		if(!$SmsQueue)
		{   
			//获取接收短信的号码
			$SmsQueueArr=$this->_getSmsQueue($limit);
		}
		else
		{
			$SmsQueueArr=$SmsQueue;
		}
		$sms_count = count($SmsQueueArr);
		if(!$sms_count)
		{
			return false;
		}
		$sms_ids = array();
		for ($i=0; $i < $sms_count; $i++)
		{
			$sms_ids[] = $SmsQueueArr[$i]['Id'];
		}

		for ($i=0; $i < $sms_count; $i ++)
		{
			$schedule=null;
			if($SmsQueueArr[$i]['schedule'])
			{
				$schedule=$SmsQueueArr[$i]['schedule'];
			}	
		
		  //设置队列号码为正在发送状态			
		  $this->_updateSmsQueueStatus('batch_sending',$SmsQueueArr[$i]['Id']);		 
		  $recInfo= $Provider->send($SmsQueueArr[$i]['mobile'], $SmsQueueArr[$i]['content'],$schedule); 
		   if($recInfo)
		   { 
				$this->_updateSmsQueueStatus('sent',$SmsQueueArr[$i]['Id']);
				$this->_updateSmsTaskStatus('sent',$SmsQueueArr[$i]['tasklist_id']);
				$return=true;
		   }
		   else
		   {	
				$this->_updateSmsQueueStatus('failed',$SmsQueueArr[$i]['Id']);
				$return=false;
		   }
		}
		return $return;
	}
	/**
	 * 获取短信签名;
	 */
	protected function _getContentSignature()
	{
		$prefInfo = $this->_getSmsPreference();
		$sign= $prefInfo['content_sign']?' - '.$prefInfo['content_sign']:'';
		return $sign;
	}
	
	/**
	 * 更新任务的发送状态;
	 */
	protected function _updateSmsTaskStatus($action,$id)
	{	
		
		return null;
	}
	/**
	 * 更新队列中的发送状态;
	 */
	protected function _updateSmsQueueStatus($action,$id)
	{
		switch($action)
		{
			case 'pending':
				$return=BizSystem::getObject($this->m_SmsQueueDO)->updateRecords("[status]='pending'","[Id]={$id}");
				 break;
			case 'sending':
				$return=BizSystem::getObject($this->m_SmsQueueDO)->updateRecords("[status]='sending'","[Id]={$id}");
				 break;
			case 'sent':
				$return=BizSystem::getObject($this->m_SmsQueueDO)->updateRecords("[status]='sent'","[Id]={$id}");
				 break;
			case 'batch_sending':	 			    
				$return=BizSystem::getObject($this->m_SmsQueueDO)->updateRecords("[status]='sending'","[Id] ".BizSystem::getService("sms.lib.SmsUtilService")->db_create_in($sms_ids));
				 break;
		}
		return $return;
	}
	/**
	 * 短信添加到队列中;
	 */
	protected function _addSmsQueueInfo($mobile,$content,$defer)
	{
		$SmsQueueDO = BizSystem::getObject($this->m_SmsQueueDO);
		if(!$this->validateMobile($mobile))
		{
			return false;
		}
		
		$data=array(
				'mobile'=>$mobile,
				'content'=>$content,
				'schedule'=>$defer,
				);
		return $SmsQueueDO->insertRecord($data);
	}
	/**
	 * 获取接收的短信的号码;
	 */
	protected function _getSmsQueue($limit=1)
	{
		$SmsQueueDO = BizSystem::getObject($this->m_SmsQueueDO);
		$SmsQueueArr=$SmsQueueDO->directFetch("[status]='pending' AND [mobile] IS NOT NULL",$limit,0,"[Id] ASC");
		 if($SmsQueueArr)
		 {
			$SmsQueueArr=$SmsQueueArr->toArray();
		 }	
		 return $SmsQueueArr;
	}
	
/**
 * 获取SMS设置信息;
 */
	protected  function _getSmsPreference(){

		if($this->m_SmsPreference)
		{
			return $this->m_SmsPreference;
		}
		
		$PreferenceDO = BizSystem::getObject($this->m_PreferenceDO);
		$PreferenceArr=$PreferenceDO->directFetch("[section]='SMS'");
		 if($PreferenceArr)
		 {
			$SmsPreference=$PreferenceArr->toArray();
		 }
		 
		 foreach($SmsPreference as $info)
		 {
			$SmsPreferenceInfo[$info['name']]=$info['value'];
		 }
		 $this->m_SmsPreference = $SmsPreferenceInfo;
		 return $SmsPreferenceInfo;
		
		
	} 
/**
 * 根据设置获取短信服务商信息;
 */
	protected function _getProvider(){

		$SmsProviderDO = BizSystem::getObject($this->m_SmsProviderDO);
		$SmsPreference=$this->_getSmsPreference();
		switch($SmsPreference['dispatch'])
		{
			case self::DISPATCH_BY_PRIORITY:
				 $SmsProviderInfo=$SmsProviderDO->fetchOne('[msg_balance]>0 AND [status]=1','[priority] DESC');
				 break;
			case self::DISPATCH_BY_BALANCE:
				 $SmsProviderInfo=$SmsProviderDO->fetchOne('[msg_balance]>0 AND [status]=1','[msg_balance] DESC,[msg_sent_count] ASC');
				 break;
			case self::DISPATCH_ROUND_ROBIN:
				 $SmsProviderInfo=$SmsProviderDO->fetchOne('[msg_balance]>0 AND [status]=1','[msg_last_sendtime] DESC');
				 break;
			default:
			 	 $SmsProviderInfo=$SmsProviderDO->fetchOne('[msg_balance]>0 AND [status]=1','[create_time] DESC');
		}
		if(!$SmsProviderInfo)
		{
			BizSystem::getService(LOG_SERVICE)->log(LOG_ERR,"SMS","No available provider found");
			return false;
		}
		$SmsProviderArr['type']=$SmsProviderInfo['type'];
		$SmsProviderArr['driver']=$SmsProviderInfo['driver'];
	
		$obj=$this->_loadProviderDriver($SmsProviderArr['type'],$SmsProviderArr['driver']);	
		if(!is_object($obj))
		{
			BizSystem::getService(LOG_SERVICE)->log(LOG_ERR,"SMS","Cannot load provider driver :".$SmsProviderArr['driver']);			
			return false;
		}		
		return $obj;
	}
/**
 * 加载短信驱动类
 */
	protected function _loadProviderDriver($providerCode,$driver=null)
	{		
		if(!$providerCode)
		{
			return false;
		}
		if($driver)
		{
			$FileName=str_replace('.','/', $driver);
		}
		else
		{
			$SmsProviderDO = BizSystem::getObject($this->m_SmsProviderDO);
			$ProvidersInfo =$SmsProviderDO->fetchOne
			("[status]=1 AND [type]='{$providerCode}'");
			if(!$ProvidersInfo)
			{
				BizSystem::getService(LOG_SERVICE)->log(LOG_ERR,"SMS","No available provider found");				
				return false;
			}
			$FileName=str_replace('.','/', $ProvidersInfo['driver']);
			$driver=$ProvidersInfo['driver'];
		}
		
		$driverrFile=MODULE_PATH.'/'.$FileName.'.php';
		if(!file_exists($driverrFile))
		{
			BizSystem::getService(LOG_SERVICE)->log(LOG_ERR,"SMS","Cannot load provider driver :".$ProvidersInfo['driver']);			
			return false;
		}
		else
		{
			require_once($driverrFile);
		}
		$ClassName=explode('.',$driver);
		//获取需要实例的类名
		$ClassName=$ClassName[count($ClassName)-1];
		$provderClass = new $ClassName;
		return $provderClass;
	}
	/**
	 * 获取帐号可用短信数量
	 */
	public function getMsgBalance($providerCode)
	{ 
		$obj=$this->_loadProviderDriver($providerCode);
		return $obj->getMsgBalance();
	}
	
	/**
	 * 验证手机号码
	 */
	public function  validateMobile($mobile)
	{
		$return=true;
		preg_match('/1\d{10}/',$mobile,$validate);
		if(!$validate)
		{
			$return=false;
		}
		return $return;
	}
}


?>