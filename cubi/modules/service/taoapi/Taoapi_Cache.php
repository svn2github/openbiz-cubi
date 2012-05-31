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
 * Api Cache System
 * 
 * @author Taoapi.com
 *
 */
class Taoapi_Cache
{
    //缓存路径
    private $_CachePath;

    //缓存时间
    private $_cachetime =  0;

    //API名称
    private $_method = "";

    //是否自动清除缓存
    private $_ClearCache = 0;
    
    public function __construct()
    {
        $Taoapi_Config = Taoapi_Config::Init();
        $this->setCacheTime($Taoapi_Config->getConfig()->Cache);
        $this->setCachePath($Taoapi_Config->getConfig()->CachePath);
    }

    public function setMethod ($method)
    {
        $this->_method = $method;
    }

    /**
     * @return Taoapi_Cache
     */
    public function setCacheTime ($time)
    {
        $this->_cachetime = intval($time);
        return $this;
    }

    /**
     * @return Taoapi_Cache
     */
    public function setClearCache ($param)
    {
        $this->_ClearCache = $param;

        return $this;
    }

    /**
     * @return Taoapi_Cache
     */
    public function setCachePath ($CachePath)
    {
        $this->_CachePath = substr($CachePath, - 1, 1) == '/' ? $CachePath : $CachePath . '/';
        return $this;
    }

    public function saveCacheData ($id, $result)
    {
        $idkey = substr($id,0,2);
        
        if ($this->_cachetime) {
            if (! is_dir($this->_CachePath)) {
                mkdir($this->_CachePath);
            }
            if (! is_dir($this->_CachePath . $this->_method)) {
                mkdir($this->_CachePath . $this->_method);
            }
            if (! is_dir($this->_CachePath . $this->_method.'/'.$idkey)) {
                mkdir($this->_CachePath . $this->_method.'/'.$idkey);
            }
            $filepath = $this->_CachePath . $this->_method.'/'.$idkey;
            if (is_dir($filepath)) {
                $filename = $filepath . '/' . $id . '.cache';
                @file_put_contents($filename, $result);
            }
        }
    }

	private function checkClearTime()
	{
		$CacheParam = explode(" ",$this->_ClearCache);

		if(!$this->_ClearCache || count($CacheParam) !== 4)
		{
			return false;
		}

		if($CacheParam[3] != "*")
		{
			$CacheParam[3] = explode(",",$CacheParam[3]);

			if(!in_array(date('m'),$CacheParam[3]))
			{
				return false;
			}
		}

		if($CacheParam[2] != "*")
		{
			$CacheParam[2] = explode(",",$CacheParam[2]);

			if(!in_array(date('d'),$CacheParam[2]))
			{
				return false;
			}
		}
		if($CacheParam[1] != "*")
		{
			$CacheParam[1] = explode(",",$CacheParam[1]);

			if(!in_array(date('H'),$CacheParam[1]))
			{
				return false;
			}
		}

		if($CacheParam[0] != "*")
		{
			$CacheParam[0] = explode(",",$CacheParam[0]);

			if(!in_array(date('i'),$CacheParam[0]))
			{
				return false;
			}
		}

		$cachetag = $this->_CachePath."autoclear.tag";

         if (file_exists($cachetag)) {
                $filetime = date('U', filemtime($cachetag));

				if(date("d") == date("d",$filetime))
				{
					return false;
				 }
		}
		file_put_contents($cachetag,date("Y-m-d H:i:s"));

		return true;
	}

	public function autoClearCache($path ='')
	{
		$path = $path ? $path : $this->_CachePath;

		if(empty($path))
		{
			return false;
		}

		if($this->_cachetime)
		{
			if(!is_dir($path))
			{
				return false;
			}
			
			if($fdir = opendir($path))
			{
				$old_cwd = getcwd();
				chdir($path);
				$path = getcwd().'/';
				while(($file = readdir($fdir)) !== false)
				{
					if(in_array($file,array('.','..')))
					{
						continue;
					}

					if(is_dir($path.$file))
					{
						$this->autoClearCache($path.'/'.$file.'/'); 
					}else{
						if(strpos($file,".cache") !== false)
						{
							$filetime = date('U', filemtime($path.$file));
							$cachetime = $this->_cachetime * 60 * 60;
							if ($this->_cachetime != 0 && (time() - $filetime) > $cachetime) {
									@unlink($path.$file);
							}
						}
					}
				}				
				closedir($fdir);
				chdir($old_cwd);
			}
		}

	}

    public function clearCache ($id = null)
    {
        if ($id) {
            $filename = $this->_CachePath . $this->_method . '/' . $id . '.cache';
            unlink($filename);
        } else {
            $dir = $this->_CachePath . $this->_method . '/';
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {
                    while (($file = readdir($dh)) !== false) {
                        if (is_dir($dir . $file)) {
                            continue;
                        }
						if(strpos($file,".cache") !== false)
						{
							unlink($dir . $file);
						}
                    }
                    closedir($dh);
                }
            }
        }
    }
    public function getCacheData ($id)
    {
		if($this->checkClearTime())
		{
			$this->autoClearCache();
		}

        $idkey = substr($id,0,2);
        $filename = $this->_CachePath . $this->_method . '/' . $idkey .'/'. $id . '.cache';
		
        if ($this->_cachetime) {
            if (file_exists($filename)) {
                $filetime = date('U', filemtime($filename));
                $cachetime = $this->_cachetime * 60 * 60;
                if ($this->_cachetime != 0 && (time() - $filetime) > $cachetime) {
                    return false;
                }
				
                return @file_get_contents($filename);
            }
        }
        return false;
    }
}