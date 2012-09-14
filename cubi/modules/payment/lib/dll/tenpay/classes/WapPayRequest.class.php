<?php

require_once ('common/CommonRequest.class.php');
require_once ('common/CommonResponse.class.php');
require_once('common/util/XmlParseUtil.php');
require_once('common/util/HttpClientUtil.php');
require_once('WapPayInitResponse.class.php');
require_once('common/SDKRuntimeException.class.php');
//require_once('common/util/XmlParseUtil.php');
/**
 * Wap֧���������<br/>
 * �������ò�������֧������url
 * 
 * @author reymondtu
 * @date 2010-12-06
 * @since jdk1.5
 * @version 1.1.0
 */
class WapPayRequest extends CommonRequest {

	/**
	 * ���췽��
	 * 
	 * @param secretKey
	 *            ����KEY
	 */
	function WapPayRequest($secretKey) {
		parent::__construct($secretKey);
	}

	/**
	 * ����֧����ת����
	 * 
	 * @return Wap֧������URL
	 * @throws Exception Wap֧�����������쳣, Wap֧�����ĳ�ʼ�������쳣
	 */
	function getURL(){
		$paraString = parent::genParaStr();
		$domain = parent::getDomain();
		$url = $domain . parent::$this->WAP_PAY_OPPOSITE_ADDRESS . '?' . $paraString;
		try {
			$http	= new HttpClientUtil();
			$util	= new XmlParseUtil();
			$str = $http->httpClientCall($url,"utf-8");
			$wapPayInitResponse = new WapPayInitResponse(
				$util->openapiXmlToMap($str,"utf-8"),
				parent::getSecretKey()
				);
		} catch (SDKRuntimeException $e){
			die($e->errorMessage());
			throw new SDKRuntimeException('Wap֧�����������쳣.'. $e->getMessage(), e);
		}
		if ($wapPayInitResponse && $wapPayInitResponse->isRetCodeOK()) {
			return $wapPayInitResponse->getURL();
		} else {
			throw new SDKRuntimeException('Wap֧�����ĳ�ʼ�������쳣.'.$wapPayInitResponse->getMessage());
		}
	}

	function send(){
		return null;
	}
	
	var $serialVersionUID = 6463049083989401969;

}