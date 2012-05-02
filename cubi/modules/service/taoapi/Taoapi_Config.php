<?php
/**
 * 全局设置参数设置
 *
 * @category Taoapi
 * @package Taoapi_Config
 * @copyright Copyright (c) 2008-2010 Taoapi (http://www.Taoapi.com)
 * @license    http://www.Taoapi.com
 * @version    Id: Taoapi_Config  2010-02-22 15:36:47 Arvin 
 */
class Taoapi_Config
{
    //存放全局参数
    private $_Config;
  
    /**
     * @var  Taoapi_Config
     */
    private static $_init;
    
    private function __construct()
    {
		$this->_Config = require_once dirname(__FILE__).'/Taoapi_Config.inc.php';

		$this->setTestMode($this->_Config['TestMode']);
		$this->_Config['PostMode'] = array('GET' => 'getSend' , 'POST' => 'postSend' , 'POSTIMG' => 'postImageSend');
    }

    /**
     * @return Taoapi_Config
     */
    public static function Init ()
    {
        if (! self::$_init) {
            self::$_init = new Taoapi_Config();
        }
        return self::$_init;
    }

    /**
	 * 设置数据环境: true 测试环境 false 正式环境
	 * @param bool $test
     * @return Taoapi_Config
     */
    public function setTestMode ($test = true)
    {
 		if($test)
 		{
 		    $this->_Config['Container'] = 'http://container.api.tbsandbox.com/container';
 			$this->_Config['Url'] = 'http://gw.api.tbsandbox.com/router/rest';
 			$this->_Config['Stream'] = 'http://stream.sandbox.api.taobao.com/stream';
 		}else{
 			$this->_Config['Url'] = 'http://gw.api.taobao.com/router/rest';
 		    $this->_Config['Container'] = 'http://container.open.taobao.com/container';
 		    $this->_Config['Stream'] = 'http://stream.api.taobao.com/stream';
 		}
        return $this;
    }
 
    
    /**
     * 设置获取数据的编码. 支持UTF-8 GBK GB2312 
     * 需要 iconv或mb_convert_encoding 函数支持
     * UTF-8 不可写成UTF8
     * @param string $Charset
     * @return Taoapi_Config
     */
	public function setCharset($Charset)
	{
 		$this->_Config['Charset'] = $Charset;

        return $this;
	}
    
    /**
     * 设置appKey
     * 
     * @param int $key
     * @return Taoapi_Config
     */
    public function setAppKey ($key)
    {
        if(is_array($key))
        {
            $this->_Config['AppKey'] = $key;
        }else{
            $this->_Config['AppKey'][$key] = 0;
        }

        return $this;
    }

    /**
     * 设置appSecret
     * 
     * @param string $Secret
     * @return Taoapi_Config
     */
    public function setAppSecret ($Secret)
    {
		$key = array_search('0',$this->_Config['AppKey']);

		if($key)
		{
			$this->_Config['AppKey'][$key] = $Secret;
		}

        return $this;
    }
    
    /**
     * 当appKey不只一个时,API次数超限后自动启用下一个APPKEY
     * 
     * @param bool $Secret
     * @return Taoapi_Config
     */
    public function setAppKeyAuto ($AppKeyAuto)
    {
        $this->_Config['AppKeyAuto'] = (bool)$AppKeyAuto;

        return $this;
    }    
	
    /**
     * 设置API版本,1 表示1.0 2表示2.0 
     * 设置sign加密方式,支持 md5 和 hmac
     * 
     * @param int $version
     * @param string $signmode
     * @return Taoapi_Config
     */
    public function setVersion ($version,$signmode = 'md5')
    {
        $this->_Config['Version'] = intval($version);
        $this->_Config['SignMode'] = $signmode;

        return $this;
    }
    
    /**
     * 设置sign加密方式,支持 md5 和 hmac
     * 
     * @param string $signmode
     * @return Taoapi_Config
     */
    public function setSignMode ($signmode = 'md5')
    {
        $this->_Config['SignMode'] = $signmode;

        return $this;
    }

    /**
     * 显示或关闭错语提示
     * 
     * @param bool $CloseError
     * @return Taoapi_Config
     */
    public function setCloseError($CloseError = true)
    {
        $this->_Config['CloseError'] = (bool)$CloseError;

        return $this;
    }

    /**
     * 开启或关闭API调用日志功能,
     * 开启后可以查看到每天APPKEY调用的次数以及调用的API
     * 
     * @param bool $Log
     * @return Taoapi_Config
     */
    public function setApiLog($Log)
    {
        $this->_Config['ApiLog'] = (bool)$Log;

        return $this;
    }

    /**
     * 开启或关闭错误日志功能
     * 
     * @param bool $Errorlog
     * @return Taoapi_Config
     */
    public function setErrorlog($Errorlog)
    {
        $this->_Config['Errorlog'] = $Errorlog;

        return $this;
    }

    /**
     * 设置API读取失败时重试的次数,
     * 可以提高API的稳定性,推荐为3次
     * 
     * @param int $RestNumberic
     * @return Taoapi_Config
     */
    public function setRestNumberic($RestNumberic)
    {
        $this->_Config['RestNumberic'] = intval($RestNumberic);;

        return $this;
    }

    /**
     * 设置数据缓存的时间,
     * 单位:小时;0表示不缓存
     * 
     * @param int $cache
     * @return Taoapi_Config
     */
    public function setCache($cache = 0)
    {
        $this->_Config['Cache'] = intval($cache);

        return $this;
    }

    /**
     * 设置缓存保存的目录
     * 
     * @param string $CachePath
     * @return Taoapi_Config
     */
    public function setCachePath($CachePath)
    {
 		  $this->_Config['CachePath'] = $CachePath;

        return $this;
    }    

    /**
     * 返回全局配置参数
     * 
     * @return object
     */
    public function getConfig()
    {
        return (object)$this->_Config;
    }
}