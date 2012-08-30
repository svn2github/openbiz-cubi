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
	 * 发送单条短信;
	 */
	public function SendSms($SmsQueue=null,$limit=10){
		$time = time();
		$TasklistDO = BizSystem::getObject($this->m_SmsTasklistDO);
		$SmsQueueDO = BizSystem::getObject($this->m_SmsQueueDO);
		$SmsProviderDO = BizSystem::getObject($this->m_SmsProviderDO);
		$Provider=$this->_getProvider();
		$ProviderType=BizSystem::sessionContext()->getVar("_SMSPROVIDER");
	
		if(!$Provider)
		{
			$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
			$eventlog->log("SMSSEND_ERROR", 'SendSms','Unknown Provider');
			return false;
		}
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
		require_once MODULE_PATH.'/sms/lib/utilService.php';
		$sms_ids = array();
		//$mobile = array();
		$util=new utilService();
		for ($i=0; $i < $sms_count; $i++)
		{
			$sms_ids[] = $SmsQueueArr[$i]['Id'];
		  //  $mobile[] = $SmsQueueArr[$i]['mobile'];
		}

		for ($i=0; $i < $sms_count; $i ++)
		{
			$plantime=null;
			if($SmsQueueArr[$i]['plantime'])
			{
				$plantime=$SmsQueueArr[$i]['plantime'];
			}	  
		  $content=$SmsQueueArr[$i]['content'].' sign:'.$this->_getContentSignature();
		  //设置队列号码为正在发送状态
		  $SmsQueueDO->updateRecords("status='sending'","Id {$util->db_create_in($sms_ids)}");	
		  $recInfo= $Provider->send($SmsQueueArr[$i]['mobile'], $content);
		   if($recInfo)
		   { 
				$time=date("Y-m-d H:i:s"); 
				$SmsQueueDO->updateRecords("status='sent',sent_time='{$time}'","Id={$SmsQueueArr[$i]['Id']}");
				$TasklistDO->updateRecords("has_sent=has_sent+1","Id={$SmsQueueArr[$i]['tasklist_id']}");
				if($recInfo['balance'])//如果接口支持返回剩余的短信数量
				{
					$SmsProviderDO->updateRecords("use_sms_count={$recInfo['balance']},send_sms_count=send_sms_count+1","type='{$ProviderType['type']}'");
				}
				else
				{
					$SmsProviderDO->updateRecords("use_sms_count=use_sms_count-1,send_sms_count=send_sms_count+1","type='{$ProviderType['type']}'");
				}
				return true;
		   }
		   else
		   {
				$SmsQueueDO->updateRecords("status='pending'","Id={$SmsQueueArr[$i]['Id']}");
				return false;
		   }
		}
        
	}
	/**
	 * 批量发送短信;
	 */
	public function BatchSendSms($limit=50){
		return true;		  
	}
	
	protected function _getContentSignature()
	{
		$prefInfo = $this->_getSmsPreference();
		return $prefInfo['content_sign'];
	}
	/**
	 * 获取接收的短信的号码;
	 */
	protected function _getSmsQueue($limit=1)
	{
		$SmsQueueDO = BizSystem::getObject($this->m_SmsQueueDO);
		$SmsQueueArr=$SmsQueueDO->directFetch("status='pending' and ifnull(mobile,'')<>''",$limit,0,"priority desc");
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
			$PreferenceArr=$PreferenceDO->directFetch("section='Sms'");
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
		if(!$SmsProviderArr)
		{
			$SmsProviderDO = BizSystem::getObject($this->m_SmsProviderDO);
			$SmsPreference=$this->m_SmsPreference;
			switch($SmsPreference['dispatch'])
			{
				case 1://根据优先级获取
				 $SmsProviderInfo=$SmsProviderDO->fetchOne('[use_sms_count]>0 and [status]=1','priority desc');
				 break;
				case 2://根据提供商的短信可用数量获取
				 $SmsProviderInfo=$SmsProviderDO->fetchOne('[use_sms_count]>0 and [status]=1','use_sms_count desc,send_sms_count asc');
				 break;
				default:
				 $SmsProviderInfo=$SmsProviderDO->fetchOne('[use_sms_count]>0 and [status]=1','create_time desc');
			}
			$SmsProviderArr['type']=$SmsProviderInfo['type'];
			BizSystem::sessionContext()->setVar("_SMSPROVIDER",$SmsProviderArr);
		}
		
		$providerType = $SmsProviderArr['type'];
		$installedProviders = BizSystem::getService(LOV_SERVICE)->getDict("sms.lov.ProviderLOV(ProviderDrvier)");
		$ClassFile=$installedProviders[$providerType];
		$ClassName=explode('.',$ClassFile);
		//获取需要实例的类名
		$ClassName=$ClassName[count($ClassName)-1];
		$this->_loadProviderDriver($installedProviders[$providerType]);		
		$provderClass = new $ClassName;
		return $provderClass;
	}
/**
 * 加载短信驱动类
 */
	protected function _loadProviderDriver($providerClass)
	{
		$ClassName=str_replace('.','/', $providerClass);
		$driverFile=MODULE_PATH.'/'.$ClassName.'.php';
		if(!file_exists($driverFile))
		{
			$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
			$eventlog->log("SMSSEND_ERROR", '_loadProviderDriver','Unknown driverFile');
			return false;
		}
		require_once($driverFile);
	}
}


?>