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
 * @version   $Id: oauthService.php 3371 2012-05-31 06:17:21Z rockyswen@gmail.com $
 */
 
class SmsService 
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
	
	public function SendSms($limit=50){
		$time = time();
        $lock_expiry = $time + $this->m_lock_expire;
		$TasklistDO = BizSystem::getObject($this->m_SmsTasklistDO);
		$SmsQueueDO = BizSystem::getObject($this->m_SmsQueueDO);
		$SmsQueueArr=$SmsQueueDO->directFetch("lock_expiry < $time and status!='sent'",$limit,0,"priority desc");
		
		 if($SmsQueueArr)
		 {
			$SmsQueueArr=$SmsQueueArr->toArray();
		
			$sms_count = count($SmsQueueArr);
            $sms_ids = array();
            $mobile = array();
            for ($i=0; $i < $sms_count; $i++)
            {
                $sms_ids[] = $SmsQueueArr[$i]['Id'];
                $mobile[] = $SmsQueueArr[$i]['Id'];
            }
             //锁定
			// $SmsQueueDO->updateRecords ("lock_expiry= $lock_expiry","Id".db_create_in($sms_ids));
         	dump( $SmsQueueDO);
			include_once(MODULE_PATH."/sms/lib/sms.class.php");
			
            for ($i=0; $i < $sms_count; $i ++)
            {
                 return;
            }
        }		 
		 
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
		$SmsProviderDO = BizSystem::getObject($this->m_SmsProviderDO);
		$SmsPreference=$this->m_SmsPreference;
	
		//$SmsProviderDO->fetchOne()
	}
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
function db_create_in($item_list, $field_name = '')
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
?>