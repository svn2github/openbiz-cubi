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
 * @version   $Id: Sms.class.php 3371 2012-08-30 06:17:21Z fsliit@gmail.com $
 */
include_once(MODULE_PATH."/sms/lib/Sms.interface.php");
class Sms  extends EasyForm
{
	//发送短信
	public Static function Send($Provider,$mobile,$content,$time=null)
	{
		 switch ($Provider['type'])
		 {
			case '18dx':
				$obj=new ProviderA();
				$recInfo=$obj->send($Provider,$mobile,$content);
				break;
			case 'c123':
				$obj=new ProviderB();
				$recInfo=$obj->send($Provider,$mobile,$content);
				break;
			default :
				$recInfo='Unknown Provider';
		 }
		 return $recInfo;
	}	
	//获取剩余短信条数
	public Static function getSentMessageCount($type,$Provider)
	{
		 switch ($type)
		 {
			case '18dx':
				$obj=new ProviderA();
				$recInfo=$obj->getSentMessageCount($Provider);
				break;
			case 'c123':
				$obj=new ProviderB();
				$recInfo=$obj->getSentMessageCount($Provider);
				break;
			default :
				$recInfo='Unknown Provider';
		 }
		return $recInfo;
	} 
}
?>