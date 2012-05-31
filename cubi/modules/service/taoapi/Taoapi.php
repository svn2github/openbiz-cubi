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

//ini_set("max_execution_time", "0");
require_once 'Taoapi_Config.php';
require_once 'Taoapi_Cache.php';
require_once 'Taoapi_Exception.php';
require_once 'Taoapi_Util.php';
require_once 'Taoapi_Session.php';

/**
 * 淘宝API处理类
 *
 * @category Taoapi
 * @package Taoapi
 * @copyright Copyright (c) 2008-2009 Taoapi (http://www.Taoapi.com)
 * @license    http://www.Taoapi.com
 * @version    Id: Taoapi  2009-12-22  12:30:51 旺旺:浪子Arvin QQ:8769852
 */
class Taoapi
{
    protected $taobaoData;

    private $_userParam = array();

    private $_errorInfo;
    /**
     * @var Taoapi_Util
     */
    public static $Taoapi_Util;
    /**
     * @var Taoapi_Config
     */
    public $ApiConfig;

    /**
     * @var Taoapi_Cache
     */
    public $Cache;

	private $_ArrayModeData;

    public function __construct ()
    {
        if (self::$Taoapi_Util == NULL) {

            self::$Taoapi_Util = new Taoapi_Util();
        }
		$Config = Taoapi_Config::Init();

		$this->ApiConfig = $Config->getConfig();
		
        $this->Cache = new Taoapi_Cache();
        $this->Cache->setClearCache($this->ApiConfig->ClearCache);
    }
    
    public function __set ($name, $value)
    {
        if ($this->taobaoData && $this->ApiConfig->AutoRestParam) {

            $this->_userParam = array();
			$this->taobaoData = null;
        }

        $this->_userParam[$name] = $value;
    }
    
	public function setUserParam($userParam)
	{
		$this->_userParam = $userParam;
	}

    public function __get ($name)
    {
        if (! empty($this->_userParam[$name])) {

            return $this->_userParam[$name];
        }
    }
    public function __unset ($name)
    {
        unset($this->_userParam[$name]);
    }

    public function __isset ($name)
    {
        return isset($this->_userParam[$name]);
    }

    public function __destruct ()
    {
        $this->_userParam = array();
    }

    public function __toString ()
    {
        return $this->createStrParam($this->_userParam);
    }

    /**
     * @return Taoapi
     */
    public function setRestNumberic ($rest)
    {
        $this->ApiConfig->RestNumberic = intval($rest);

		return $this;
    }
    
    /**
     * @return Taoapi
     */
    public function setVersion ($version, $signmode = 'md5')
    {
        $this->ApiConfig->Version  = intval($version);

        $this->ApiConfig->SignMode  = $signmode;

        return $this;
    }

    /**
     * @return Taoapi
     */
    public function setCloseError()
    {
        $this->ApiConfig->CloseError  = false;

        return $this;
    }

	private function FormatUserParam($param)
	{
		if(strtoupper($this->ApiConfig->Charset) != 'UTF-8')
		{
			if(function_exists('mb_convert_encoding'))
			{
			    if(is_array($param))
			    {
			        foreach($param as $key => $value)
			        {
				        $param[$key] = @mb_convert_encoding($value,'UTF-8',$this->ApiConfig->Charset);
			        }
			    }else{
				    $param = @mb_convert_encoding($param,'UTF-8',$this->ApiConfig->Charset);
			    }
			}elseif(function_exists('iconv'))
			{
			    if(is_array($param))
			    {
			        foreach($param as $key => $value)
			        {
				        $param[$key] = @iconv($this->ApiConfig->Charset,'UTF-8',$value);
			        }
			    }else{
				    $param = @iconv($this->ApiConfig->Charset,'UTF-8',$param);
			    }
			}
		}

		return $param;
	}

	private function FormatTaobaoData($data)
	{
		if(strtoupper($this->ApiConfig->Charset) != 'UTF-8')
		{
			if(function_exists('mb_convert_encoding'))
			{
				$data = str_replace('utf-8',$this->ApiConfig->Charset,$data);
				$data = @mb_convert_encoding($data,$this->ApiConfig->Charset,'UTF-8');
			}elseif(function_exists('iconv'))
			{
				$data = str_replace('utf-8',$this->ApiConfig->Charset,$data);
				$data = @iconv('UTF-8',$this->ApiConfig->Charset,$data);
			}
		}

		return $data;
	}

    /**
     * @return Taoapi
     */
    public function Send ($mode = 'GET', $format = 'xml')
    {
        $imagesArray = $this->_ArrayModeData = array();

		$tempParam = $this->_userParam;

        foreach ($tempParam as $key => $value) 
		{
            if (is_array($value)) {
                    if (! empty($value['image'])) {
                        $imagesArray = $value;
                    }
                    unset($tempParam[$key]);
            }elseif(trim($value) == '')
            {
                unset($tempParam[$key]);
            }else{
				$tempParam[$key] = $this->FormatUserParam($value);
			}
        }
        if (! isset($tempParam['api_key'])) {

            $systemdefault['api_key'] = key($this->ApiConfig->AppKey);
            $systemdefault['format'] = strtolower($format);
            $systemdefault['v'] = strpos($this->ApiConfig->Version,'.') ? $this->ApiConfig->Version : $this->ApiConfig->Version.'.0';
			if($this->ApiConfig->Version == 2)
			{
				$systemdefault['sign_method'] = strtolower($this->ApiConfig->SignMode);
			}
            $systemdefault['timestamp'] = date('Y-m-d H:i:s');

			$tempParam = array_merge($tempParam,$systemdefault);
			$this->_userParam = array_merge($this->_userParam,$systemdefault);
        }

        $cacheid = $tempParam;

        unset($cacheid['timestamp']);

        $cacheid = md5($this->createStrParam($cacheid));

        $method = ! empty($tempParam['method']) ? $tempParam['method'] : '';

        $this->Cache->setMethod($method);

        if (! $this->taobaoData = $this->Cache->getCacheData($cacheid)) {

            $mode = strtoupper($mode);

            $ReadMode = array_key_exists($mode, $this->ApiConfig->PostMode) ? $this->ApiConfig->PostMode[$mode] : $this->ApiConfig->PostMode['GET'];

            if ($ReadMode == 'postImageSend') {
                $this->taobaoData = $this->$ReadMode($tempParam, $imagesArray);
            } else {
                $this->taobaoData = $this->$ReadMode($tempParam);
            }

            $error = $this->getArrayData($this->taobaoData);

			$this->ApiCallLog();
			
            if (isset($error['code'])) {

				if(in_array($error['code'],array(4,5,6,7,8,25)))
				{
					$this->_systemParam['apicount'] = empty($this->_systemParam['apicount']) ? 1 : $this->_systemParam['apicount'] + 1;
					if($this->_systemParam['apicount'] < count($this->ApiConfig->AppKey))
					{
						next($this->ApiConfig->AppKey);
						$this->_userParam['api_key'] = key($this->ApiConfig->AppKey);
						return $this->Send($mode, $format);
					}
				}

				if($this->ApiConfig->RestNumberic && empty($this->_systemParam['apicount'])) {

                    $this->ApiConfig->RestNumberic = $this->ApiConfig->RestNumberic - 1;

                    return $this->Send($mode, $format);
                } else {
                    $tempParam['sign'] = $this->_systemParam['sign'];

                    $this->_errorInfo = new Taoapi_Exception($error, $tempParam, $this->ApiConfig->CloseError,$this->ApiConfig->Errorlog);

					if(!$this->ApiConfig->CloseError)
					{
						echo $this->FormatTaobaoData($this->_errorInfo->getErrorInfo());
					}
                }
            } else { 
                $this->Cache->saveCacheData($cacheid, $this->taobaoData);
            }
        }
        return $this;
    }

	public function ApiCallLog ()
    {
		if($this->ApiConfig->ApiLog)
		{
			$apilogpath = dirname(__FILE__) . '/api_call_log';
			if (! is_dir($apilogpath)) {
				@mkdir($apilogpath);
			}
			if ($fp = @fopen($apilogpath . '/' .key($this->ApiConfig->AppKey).'_'. date('Y-m-d') . '.log', 'a')) {
				$logparam = $this->_userParam;
				unset($logparam['fields']);
				@fwrite($fp, implode("\t", $logparam) . "\r\n");
				fclose($fp);
			}
		}
    }

    public function getXmlData ()
    { 
        if (empty($this->taobaoData)) {
            return false;
        }		
        return $this->FormatTaobaoData($this->taobaoData);
    }

    public function getJsonData ()
    {
        if (empty($this->taobaoData)) {
            return false;
        }
        if (substr($this->taobaoData, 0, 1) != '{') {

            if ($this->_userParam['format'] == 'xml') {
				$Charset = $this->ApiConfig->Charset;
				$this->ApiConfig->Charset = "UTF-8";
                $Data = $this->getArrayData($this->taobaoData);
				$this->ApiConfig->Charset = $Charset;
            }

            $Data = json_encode($Data);
            if (strpos($_SERVER['SERVER_SIGNATURE'], "Win32") > 0) {
                $Data = preg_replace("#\\\u([0-9a-f][0-9a-f])([0-9a-f][0-9a-f])#ie", "iconv('UCS-2','UTF-8',pack('H4', '\\1\\2'))", $Data);
            } else {
                $Data = preg_replace("#\\\u([0-9a-f][0-9a-f])([0-9a-f][0-9a-f])#ie", "iconv('UCS-2','UTF-8',pack('H4', '\\2\\1'))", $Data);
            }
			$Data = $this->FormatTaobaoData($Data);

        } else {
            $Data = $this->taobaoData;
        }
        return $Data;
    }

    public function getArrayData ()
    {
        if (empty($this->taobaoData)) {
            return false;
        }

		if(!empty($this->_ArrayModeData[$this->ApiConfig->Charset]))
		{
			return $this->_ArrayModeData[$this->ApiConfig->Charset];
		}

        if ($this->_userParam['format'] == 'json') {

            $json = json_decode($this->taobaoData, true);
            return isset($json['rsp']) ? $json['rsp'] : $json;
        } elseif ($this->_userParam['format'] == 'xml') {

            $xmlCode = simplexml_load_string($this->taobaoData, 'SimpleXMLElement', LIBXML_NOCDATA);
			
			$taobaoData = $this->get_object_vars_final($xmlCode);

			if(strtoupper($this->ApiConfig->Charset) != 'UTF-8')
			{
				$taobaoData = $this->get_object_vars_final_coding($taobaoData);
			}

			$this->_ArrayModeData[$this->ApiConfig->Charset] = $taobaoData;

            return $taobaoData;

        } else {
            return false;
        }
    }

    /**
     * 返回错误提示信息
     *
     * @return array
     */
    public function getErrorInfo ()
    {
        if ($this->_errorInfo) {
            if (is_object($this->_errorInfo)) {

                return $this->FormatTaobaoData($this->_errorInfo->getErrorInfo());
            } else {
                return $this->FormatTaobaoData($this->_errorInfo);
            }
        }
    }
    /**
     * 返回提交参数
     *
     * @return array
     */
    public function getParam ()
    {
        return $this->_userParam;
    }

    private function JoinSign($paramArr)
    {
       $sign = '';
       foreach ($paramArr as $key => $val) {
               if(is_array($val))
               {
                   $sign .= $this->JoinSign($val);
                   
               }elseif ($key != '' && $val != '') {
                    $sign .= $key . $val;
                }
        }
        
        return $sign;
    }
    public function SignVersion2 ($paramArr)
    {
        if (strtolower($this->ApiConfig->SignMode) == 'hmac') {
            ksort($paramArr);
            $sign = $this->JoinSign($paramArr);
            $sign = strtoupper(bin2hex(mhash(MHASH_MD5, $sign,current($this->ApiConfig->AppKey))));
			

        } else {
            ksort($paramArr);
            $sign = $this->JoinSign($paramArr);
            $sign  = strtoupper(md5(current($this->ApiConfig->AppKey) . $sign . current($this->ApiConfig->AppKey)));
        }

        return $sign;
    }

    public function SignVersion1 ($paramArr)
    {
            $sign = current($this->ApiConfig->AppKey);
            ksort($paramArr);
            $sign .= $this->JoinSign($paramArr);
            $sign = strtoupper(md5($sign));

        return $sign;
    }

    public function createSign ($paramArr)
    {
		$Version = 'SignVersion'.intval($this->ApiConfig->Version);

		if(method_exists($this,$Version))
		{
			$sign = $this->{$Version}($paramArr);
		}

		$this->_systemParam['sign'] = $sign;
        return $sign;
    }

    static public function createStrParam ($paramArr)
    {
        $strParam = array();
        foreach ($paramArr as $key => $val) {
            if ($key != '' && $val != '') {
                $strParam []= $key . '=' . urlencode($val);
            }
        }
        return implode('&',$strParam);
    }

    private $_systemParam;

    public function getSend ($paramArr)
    {
        //组织参数
        $this->_systemParam['sign'] = $this->createSign($paramArr);
        $paramArr['sign'] = $this->_systemParam['sign'];
        $strParam = $this->createStrParam($paramArr);
        $this->_systemParam['url'] = $this->ApiConfig->Url . '?' . $strParam;
        //访问服务
        self::$Taoapi_Util->fetch($this->_systemParam['url']);
        $result = self::$Taoapi_Util->results;
        //返回结果
        return $result;
    }

    /**
     * 以POST方式访问api服务
     * @param $paramArr：api参数数组
     * @return $result
     */
    public function postSend ($paramArr)
    {
        //组织参数，Taoapi_Util类在执行submit函数时，它自动会将参数做urlencode编码，所以这里没有像以get方式访问服务那样对参数数组做urlencode编码
        $this->_systemParam['sign'] = $this->createSign($paramArr);
        $paramArr['sign'] = $this->_systemParam['sign'];
        $this->_systemParam['url'] = array($this->ApiConfig->Url , $paramArr);
        //访问服务
        self::$Taoapi_Util->submit($this->ApiConfig->Url, $paramArr);
        $result = self::$Taoapi_Util->results;
        //返回结果
        return $result;
    }
    /**
     * 以POST方式访问api服务，带图片
     * @param $paramArr：api参数数组
     * @param $imageArr：图片的服务器端地址，如array('image' => '/tmp/cs.jpg')形式
     * @return $result
     */
    public function postImageSend ($paramArr, $imageArr)
    {
        //组织参数
        $this->_systemParam['sign'] = $this->createSign($paramArr);
        $paramArr['sign'] = $this->_systemParam['sign'];
        //访问服务
        self::$Taoapi_Util->_submit_type = "multipart/form-data";
        $this->_systemParam['url'] = array($this->ApiConfig->Url , $paramArr , $imageArr);
        self::$Taoapi_Util->submit($this->ApiConfig->Url, $paramArr, $imageArr);
        $result = self::$Taoapi_Util->results;
        //返回结果
        return $result;
    }

    private function get_object_vars_final ($obj)
    {
        if (is_object($obj)) {
            $obj = get_object_vars($obj);
        }

        if (is_array($obj)) {
            foreach ($obj as $key => $value) {
                $obj[$key] = $this->get_object_vars_final($value);
            }
        }
        return $obj;
    }

    private function get_object_vars_final_coding ($obj)
    {
		foreach($obj as $key => $value)
		{
			if(is_array($value))
			{
				$obj[$key] = $this->get_object_vars_final_coding($value);
			}else{
				$obj[$key] = $this->FormatTaobaoData($value);
			}
		}
        return $obj;
    }

	public function getUrl()
	{
		return !empty($this->_systemParam['url']) ? $this->_systemParam['url'] :'';
	}
	public function getSign()
	{
		return !empty($this->_systemParam['sign']) ? $this->_systemParam['sign'] :'';
	}

	
}