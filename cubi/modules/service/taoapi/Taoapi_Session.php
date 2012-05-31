<?php
/**
 * Openbiz Cubi Application Platform
 *
 * LICENSE http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 *
 * @package   cubi.service.taoapi
 * @copyright Copyright (c) 2005-2011, Openbiz Technology LLC
 * @license   http://code.google.com/p/openbiz-cubi/wiki/CubiLicense
 * @link      http://code.google.com/p/openbiz-cubi/
 * @version   $Id$
 */

/**
 * Taoapi_Session
 *
 * @category PHPDIY
 * @package Taoapi_Session
 * @copyright Copyright (c) 2008-2009 PHPDIY (http://www.taoapi.com)
 * @license    http://www.taoapi.com
 * @version    Id: Taoapi_Session  2009-7-2 Arvin 
 */
class Taoapi_Session
 {
     private $_AppkeyConfig;
     
     public function __construct()
     {
         $Taoapi_Config = Taoapi_Config::Init();
		 $Config = $Taoapi_Config->getConfig();
         $this->_AppkeyConfig['appkey'] = key($Config->AppKey);
         $this->_AppkeyConfig['appsecret'] = current($Config->AppKey);
         $this->_AppkeyConfig['Charset'] = $Config->Charset;
	   
     }
     
     public function setAppkeyConfig($appkey,$appsecret)
     {
         $this->_AppkeyConfig['appkey'] = $appkey;
         $this->_AppkeyConfig['appsecret'] = $appsecret;
     }
	 
	public function loginTaobao()
     {
         $Taoapi_Config = Taoapi_Config::Init();
         $login = $Taoapi_Config->getConfig()->Container;
         $login .= '?appkey='.$this->_AppkeyConfig['appkey'];
         header("location:$login");
         exit;
     }
     
/*      public function loginTaobao($ext_shop_title,$ext_shop_domain,$callback)
     {
         $Taoapi_Config = Taoapi_Config::Init();
         $login = $Taoapi_Config->getConfig()->Container;
        
         $param['api_key'] = $this->_AppkeyConfig['appkey'];
         $param['ext_shop_title'] = $ext_shop_title;
         $param['ext_shop_domain'] = $ext_shop_domain;
         $param['action'] = 'logon';
         $param['callback_url'] = $callback;
      
         $tmp = array();
         foreach ($param as $key => $value)
         {
             $tmp[] = $key.'='.trim($value);
         }
         $login .= '/exShop?'.implode('&',$tmp);
         
		 $login = 'http://container.open.taobao.com/container?appkey='.$param['api_key'];

         header("location:$login");
         exit;
     }
      */
     public static function checkLogin()
     {
 	    $TaobaoUser = !empty($_SESSION['taobaouser']) ? $_SESSION['taobaouser'] :false;
 	    
 	    if($TaobaoUser)
 	    {
 	        if(isset($TaobaoUser['nick']) || isset($TaobaoUser['session']) || isset($TaobaoUser['param']))
 	        {
 	            return true;
 	        }
 	    }
     }
     
     public   function loginTest($nick='',$callback='')
     {  
        $paramArr['appkey'] =$this->_AppkeyConfig['appkey'];
		$paramArr['encode']=$this->_AppkeyConfig['Charset'];
		$paramArr['url'] = $callback;
        $paramArr['zhxz'] = '1';
        $paramArr['nick'] = $nick;

        $login_url ="http://container.api.tbsandbox.com/container";
		foreach($paramArr as $key=>$value){
            $ps_s[]= $key.'='.$value;
        }
		
        $tb_url = $login_url.'?'.implode("&",$ps_s);
		// $tb_url ="http://container.api.tbsandbox.com/container?appkey=12141257";
		//die( $tb_url);
       // header("Location:".$tb_url."&act=signin");
        header("Location:".$tb_url);
		/*
        $paramArr = self::getAuthorize($nick,$callback);
         if($paramArr['authcode'])
         {
             $login = 'http://container.api.tbsandbox.com/container?authcode='.$paramArr['authcode'];
             header("location:$login");
             exit;
         }*/
     }
 
    public static function getAuthorize($nick,$callback)
    {
        $paramArr['url'] = $callback;
        $paramArr['zhxz'] = '1';
        $paramArr['nick'] = $nick;
        
        $url = "http://open.taobao.com/isv/authorize.php?appkey=$this->_AppkeyConfig['appkey']";
                
        $Phpdiy_Http_Snoopy = new Phpdiy_Http_Snoopy;
                
        $Phpdiy_Http_Snoopy->submit($url, $paramArr);
        
		$result = $Phpdiy_Http_Snoopy->results;
		        
		$rlue = '<input type="text" id="autoInput" value="[authorize]" style="';
		$rlue = preg_quote($rlue);
		$rlue = str_replace('\[authorize\]','\s*(.+?)\s*',$rlue);
		preg_match("/$rlue/is", $result, $rarr);
		
		$paramArr['authcode'] = false;
		if(!empty($rarr[1]))
		{
		    $paramArr['authcode'] = trim($rarr[1]);
		}
		$paramArr['appkey'] = $this->_AppkeyConfig['appkey'];
		
		return $paramArr;
    }
    
 	 public function RegistrSession()
 	 {
 	     $TopInfo = (object)$_GET;
 	     
 	     if(!empty($TopInfo->top_session))
 	     {
 	           if(!strcmp($TopInfo->top_sign,base64_encode(md5($this->_AppkeyConfig['appkey'].$TopInfo->top_parameters.$TopInfo->top_session.$this->_AppkeyConfig['appsecret'],true))))
 	           {
				 $TopInfo->top_parameters = mb_convert_encoding(base64_decode($TopInfo->top_parameters),'UTF-8','GBK');
				 parse_str($TopInfo->top_parameters,$TopInfo->top_parameters);

 	              $TaobaoUser['nick'] = !empty($TopInfo->nick) ? $TopInfo->nick : $TopInfo->top_parameters['visitor_nick'];
 	              $TaobaoUser['session'] = $TopInfo->top_session;
 	              $TaobaoUser['param'] = $TopInfo->top_parameters;
 	              $TaobaoUser['sign'] = $TopInfo->top_sign;
 	              $TaobaoUser['callback'] = $TopInfo->callback_url;
 	              $TaobaoUser['appkey'] = $TopInfo->top_appkey ;
 	              
 	              return $TaobaoUser;
 	          }else{
				  return false;
			  }
 	     }else{
			 return true;
		 }
 	 }
 }