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
 * @version   $Id: userSmsService.php 3506 2012-06-05  fsliit@gmail.com $
 */

/**
 * User sms service 
 */
class userSmsService extends MetaObject
{
	protected $m_SmsTasklistDO='sms.do.SmsTasklistDO';
	protected $m_SmsProviderDO='sms.do.SmsProviderDO';
	protected $m_SmsQueueDO='sms.do.SmsQueueDO';
	protected $m_PreferenceDO='myaccount.do.PreferenceDO';
	protected $m_SmsPreference=null;
    protected $m_lock_expire = 30; //锁定时间
	
	public function __construct()  
    {
		$this->m_SmsPreference=$this->getSmsPreference();
    } 
	/**
	 * 发送单条短信;
	 */
	public function SendSms($limit=1){
		$time = time();
        $lock_expiry = $time + $this->m_lock_expire;
		$TasklistDO = BizSystem::getObject($this->m_SmsTasklistDO);
		$SmsQueueDO = BizSystem::getObject($this->m_SmsQueueDO);
		$SmsProviderDO = BizSystem::getObject($this->m_SmsProviderDO);
		$Provider=$this->getProvider();
		if(!$Provider)
		{
			$eventlog 	= BizSystem::getService(EVENTLOG_SERVICE);
			$eventlog->log("SMSSEND_ERROR", 'SendSms','Unknown Provider');
			return false;
		}
		$SmsQueueArr=$SmsQueueDO->directFetch("lock_expiry < $time and status!='sent' and ifnull(mobile,'')<>''",$limit,0,"priority desc");
		 if($SmsQueueArr)
		 {
			$SmsQueueArr=$SmsQueueArr->toArray();
		
			$sms_count = count($SmsQueueArr);
            $sms_ids = array();
            $mobile = array();
            for ($i=0; $i < $sms_count; $i++)
            {
                $sms_ids[] = $SmsQueueArr[$i]['Id'];
              //  $mobile[] = $SmsQueueArr[$i]['mobile'];
            }
			//$mobile=implode(',',$mobile);
		
             //锁定
		   $SmsQueueDO->updateRecords ("lock_expiry= $lock_expiry","Id".$this->db_create_in($sms_ids));
         	
			include_once(MODULE_PATH."/sms/lib/Sms.class.php");
            for ($i=0; $i < $sms_count; $i ++)
            {
				$plantime=null;
				if($SmsQueueArr[$i]['plantime'])
				{
					$plantime=$SmsQueueArr[$i]['plantime'];
				}	
			   $content=$SmsQueueArr[$i]['content'].'【'.$this->m_SmsPreference['content_sign'].'】';
			   $recInfo=Sms::Send($Provider,$SmsQueueArr[$i]['mobile'], $content,$plantime);
               if($recInfo)
			   { 
					$time=date("Y-m-d H:i:s"); 
					$SmsQueueDO->updateRecords("status='sent',sent_time='{$time}'","Id={$SmsQueueArr[$i]['Id']}");
					$TasklistDO->updateRecords("has_sent=has_sent+1","Id={$SmsQueueArr[$i]['tasklist_id']}");
					if($recInfo['balance'])//如果接口支持返回剩余的短信数量
					{
						$SmsProviderDO->updateRecords("use_sms_count={$recInfo['balance']},send_sms_count=send_sms_count+1","type='{$Provider['type']}'");
					}
					else
					{
						$SmsProviderDO->updateRecords("use_sms_count=use_sms_count-1,send_sms_count=send_sms_count+1","type='{$Provider['type']}'");
					}
			   }
			   else
			   {
					$SmsQueueDO->updateRecords("status='sending'","Id={$SmsQueueArr[$i]['Id']}");
			   }
            }
        }
	}
	/**
	 * 批量发送短信;
	 */
	public function BatchSendSms($limit=50){
		return true;		  
	}
/**
 * 获取SMS设置信息;
 */
	public function getSmsPreference(){
		$SmsPreferenceInfo=BizSystem::sessionContext()->getVar("_SMSPREFERENCE");
		$SmsPreferenceInfo=false;
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
	public function getProvider(){
		$SmsProviderArr=BizSystem::sessionContext()->getVar("_SMSPROVIDER");
		if(!$SmsProviderArr)
		{
			$SmsProviderDO = BizSystem::getObject($this->m_SmsProviderDO);
			$SmsPreference=$this->m_SmsPreference;
			switch($SmsPreference['dispatch'])
			{
				case 1://根据优先级获取
				 $SmsProviderInfo=$SmsProviderDO->fetchOne('use_sms_count>0 and status=1','priority desc');
				 break;
				case 2://根据提供商的短信可用数量获取
				 $SmsProviderInfo=$SmsProviderDO->fetchOne('use_sms_count>0 and status=1','use_sms_count desc,send_sms_count asc');
				 break;
				default:
				 $SmsProviderInfo=$SmsProviderDO->fetchOne('use_sms_count>0 and status=1','create_time desc');
			}
			$SmsProviderArr['type']=$SmsProviderInfo['type'];
			$SmsProviderArr['username']=$SmsProviderInfo['username'];
			$SmsProviderArr['password']=$SmsProviderInfo['password'];
			BizSystem::sessionContext()->setVar("_SMSPROVIDER",$SmsProviderArr);
		}
		return $SmsProviderArr;
	}

/**
 * 创建像这样的查询: "IN('a','b')";
 *
 * @access   public
 * @param    mix      $item_list      列表数组或字符串,如果为字符串时,字符串只接受数字串
 * @param    string   $field_name     字段名称
 *
 * @return   void
 */
public function db_create_in($item_list, $field_name = '')
{
    if (empty($item_list))
    {
        return $field_name . " IN ('') ";
    }
    else
    {
        if (!is_array($item_list))
        {
            $item_list = explode(',', $item_list);
            foreach ($item_list as $k=>$v)
            {
                $item_list[$k] = intval($v);
            }
        }

        $item_list = array_unique($item_list);
        $item_list_tmp = '';
        foreach ($item_list AS $item)
        {
            if ($item !== '')
            {
                $item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
            }
        }
        if (empty($item_list_tmp))
        {
            return $field_name . " IN ('') ";
        }
        else
        {
            return $field_name . ' IN (' . $item_list_tmp . ') ';
        }
    }
}
}


?>