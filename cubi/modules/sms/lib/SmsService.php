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
	protected $m_SmsTasklistDO='sms.Task.do.TaskDO';
	protected $m_SmsProviderDO='sms.provider.do.ProviderDO';
	protected $m_SmsQueueDO='sms.queue.do.QueueDO';
	protected $m_PreferenceDO='myaccount.do.PreferenceDO';

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
     * @param integer $defer -- the message will be send after $defer seconds from now 
     * @param bool $delay    -- if delay is force , then the message will not go into queue , 
     * 							instead of call driverr to send it directly  
     * @param integer $providerId -- if its not null, then used specified provider to send this message
     */
    public function SendSMS($mobile,	$content,	$defer=null,
    						$delay=true,	$providerCode=null)
    {
		if(!$this->validateMobile($mobile))
		{
			$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
			$eventlog->log("SMSSEND_ERROR", 'SendSMS','validateMobile Error');
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
			$result=$this->_addSmsQueueInfo($mobile,$content,$defer,$providerCode);
		}
		else
		{
			$result=$ProviderObj->send($mobile,$content); 
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
		
		 $SmsProviderDO = BizSystem::getObject('sms.provider.do.ProviderDO');
		 $SmsProviderList=$SmsProviderDO->directFetch("[status]=1",10,0,"[priority] DESC");
		 $return=false;
		 if($SmsProviderList)
		 {
			$SmsProviderList=$SmsProviderList->toArray();
			 foreach($SmsProviderList as $val)
			 {	
				$use_sms_count= $this->getSentCount($val['type']); 
				$use_sms_count=$use_sms_count?$use_sms_count:0;
				$SmsProvider=$SmsProviderDO->updateRecords ("[use_sms_count]=$use_sms_count","[Id]=".$val['Id']);
				if($SmsProvider && $use_sms_count)
				{
					 $return=true;
				}
			 }
		 }
    	return $return;
    }
    
    
    
    
	/**
	 * 发送队列中的短信;
	 */
	public function SendSmsFromQueue($SmsQueue=null,$limit=10){
		$SmsProviderDO = BizSystem::getObject($this->m_SmsProviderDO);
		$Provider=$this->_getProvider();
		$providerInfo=BizSystem::sessionContext()->getVar("_SMSPROVIDER");
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
			$plantime=null;
			if($SmsQueueArr[$i]['plantime'])
			{
				$plantime=$SmsQueueArr[$i]['plantime'];
			}	
		
		  //设置队列号码为正在发送状态
		  $this->_updateSmsQueueStatus('all_sending',$SmsQueueArr[$i]['Id']);
		  $recInfo= $Provider->send($SmsQueueArr[$i]['mobile'], $content); 
		   if($recInfo)
		   { 
				$this->_updateSmsQueueStatus('sent',$SmsQueueArr[$i]['Id']);
				$this->_updateSmsTaskStatus('sent',$SmsQueueArr[$i]['tasklist_id']);
				$SmsProviderDO->updateRecords("[send_sms_count]=[send_sms_count]+1","[type]='{$providerInfo['type']}'");
				$return=true;
		   }
		   else
		   {	
				$this->_updateSmsQueueStatus('pending',$SmsQueueArr[$i]['Id']);
				$return=false;
		   }
		}
		$this->getSentCount($providerInfo['type']);
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
		$SmsTaskDO = BizSystem::getObject($this->m_SmsTasklistDO);
		$return=false;
		switch($action)
		{
			case 'pending':
				$return=$SmsTaskDO->updateRecords("[status]='pending'","[Id]={$id}");
				 break;
			case 'sending':
				$return=$SmsTaskDO->updateRecords("[status]='sending'","[Id]={$id}");
				 break;
			case 'sent':
				$return=$SmsTaskDO->updateRecords("[has_sent]=[has_sent]+1,[status]='sent'","[Id]={$id}");
				 break;
		}
		return $return;
	}
	/**
	 * 更新队列中的发送状态;
	 */
	protected function _updateSmsQueueStatus($action,$id)
	{
		$SmsQueueDO = BizSystem::getObject($this->m_SmsQueueDO);
		$date=date("Y-m-d H:i:s"); 
		$return=false;
		switch($action)
		{
			case 'pending':
				$return=$SmsQueueDO->updateRecords("[status]='pending'","[Id]={$id}");
				 break;
			case 'sending':
				$return=$SmsQueueDO->updateRecords("[status]='sending'","[Id]={$id}");
				 break;
			case 'sent':
				$return=$SmsQueueDO->updateRecords("[sent_time]='{$date}',[status]='sent'","[Id]={$id}");
				 break;
			case 'all_sending':	 			    
				$return=$SmsQueueDO->updateRecords("[status]='sending'","[Id] ".BizSystem::getService("sms.lib.SmsUtilService")->db_create_in($sms_ids));
				 break;
		}
		return $return;
	}
	/**
	 * 短信添加到队列中;
	 */
	protected function _addSmsQueueInfo($mobile,$content,$defer,$providerCode)
	{
		$SmsQueueDO = BizSystem::getObject($this->m_SmsQueueDO);
		if(!$this->validateMobile($mobile))
		{
			$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
			$eventlog->log("SMSSEND_ERROR", '_addSmsQueueInfo','validateMobile Error');
			return false;
		}
		$data=array(
				'mobile'=>$mobile,
				'content'=>$content,
				'plantime'=>$defer,
				'provider'=>$providerCode
				);
		return $SmsQueueDO->insertRecord($data);
	}
	/**
	 * 获取接收的短信的号码;
	 */
	protected function _getSmsQueue($limit=1)
	{
		$SmsQueueDO = BizSystem::getObject($this->m_SmsQueueDO);
		$SmsQueueArr=$SmsQueueDO->directFetch("[status]='pending' AND [mobile] IS NOT NULL",$limit,0,"[priority] DESC");
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
		$SmsPreferenceInfo=BizSystem::sessionContext()->getVar("_SMSPREFERENCE");
		 if(!$SmsPreference)
		 {
			$PreferenceDO = BizSystem::getObject($this->m_PreferenceDO);
			$PreferenceArr=$PreferenceDO->directFetch("[section]='Sms'");
			 if($PreferenceArr)
			 {
				$SmsPreference=$PreferenceArr->toArray();
			 }
			 
			 foreach($SmsPreference as $info)
			 {
				$SmsPreferenceInfo[$info['name']]=$info['value'];
			 }
			 BizSystem::sessionContext()->setVar("_SMSPREFERENCE",$SmsPreferenceInfo);
		 }
		return $SmsPreferenceInfo;
	} 
/**
 * 根据设置获取短信服务商信息;
 */
	protected function _getProvider(){
		$SmsProviderArr=BizSystem::sessionContext()->getVar("_SMSPROVIDER");
		$SmsProviderArr=false;
		if(!$SmsProviderArr)
		{
			$SmsProviderDO = BizSystem::getObject($this->m_SmsProviderDO);
			$SmsPreference=$this->_getSmsPreference();
			switch($SmsPreference['dispatch'])
			{
				case 1://根据优先级获取
				 $SmsProviderInfo=$SmsProviderDO->fetchOne('[use_sms_count]>0 AND [status]=1','[priority] DESC');
				 break;
				case 2://根据提供商的短信可用数量获取
				 $SmsProviderInfo=$SmsProviderDO->fetchOne('[use_sms_count]>0 AND [status]=1','[use_sms_count] DESC,[send_sms_count] ASC');
				 break;
				default:
				 $SmsProviderInfo=$SmsProviderDO->fetchOne('[use_sms_count]>0 AND [status]=1','[create_time] DESC');
			}
			if(!$SmsProviderInfo)
			{
				$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
				$eventlog->log("SMSSEND_ERROR", '_getProvider','Unknown Provider');
				return false;
			}
			$SmsProviderArr['type']=$SmsProviderInfo['type'];
			$SmsProviderArr['driver']=$SmsProviderInfo['driver'];
			BizSystem::sessionContext()->setVar("_SMSPROVIDER",$SmsProviderArr);
		}
		$obj=$this->_loadProviderDriver($SmsProviderArr['type'],$SmsProviderArr['driver']);	
		if(!is_object($obj))
		{
			$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
			$eventlog->log("SMSSEND_ERROR", '_getProvider','Unknown Provider obj');
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
			("[use_sms_count]>0 AND [status]=1 AND [type]='{$providerCode}'",'[create_time] DESC');
			if(!$ProvidersInfo)
			{
				$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
				$eventlog->log("SMSSEND_ERROR", '_loadProviderDriver','Unknown driver');
				return false;
			}
			$FileName=str_replace('.','/', $ProvidersInfo['driver']);
			$driver=$ProvidersInfo['driver'];
		}

		$driverrFile=MODULE_PATH.'/'.$FileName.'.php';
		if(!file_exists($driverrFile))
		{
			$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
			$eventlog->log("SMSSEND_ERROR", '_loadProviderDriver','Unknown driverrFile');
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
	public function getSentCount($providerCode)
	{ 
		$obj=$this->_loadProviderDriver($providerCode);
		return $obj->getSentCount();
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