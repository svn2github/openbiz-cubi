<?php

require_once ('common/CommonRequest.class.php');
require_once ('common/CommonResponse.class.php');

/**
 * Wap�����Ƹ�ͨ<br/>
 * �������ò������ɴ��е�¼״̬�ĲƸ�ͨURL
 * 
 * @author marcyli
 * @date 2011-05-11
 * @php5
 * @version 1.0
 */
class WapJumpToTenpayRequest extends CommonRequest{
	var $serialVersionUID = 5867685410743939231;
	
	var $WAP_JUMP_TO_TENPAY_ADDRESS = 'https://wap.tenpay.com/cgi-bin/wapmainv2.0/wm_clientlogin.cgi';
	
	var $SANDBOX_WAP_JUMP_TO_TENPAY_ADDRESS = 'http://sandwap.tenpay.com/cgi-bin/wapmainv2.0/wm_clientlogin.cgi';
	
	/**
	 * ���췽��
	 * 
	 * @param secretKey
	 *            ����KEY
	 */
	function WapJumpToTenpayRequest($secretKey) {
		//super(secretKey);
		parent::__construct($secretKey);
	}
	
	/**
	 * ��ȡ������ַ
	 */
	function getDomain() {
		$domain = null;
		if (parent::isInSandBox()) {
			$domain = $this->SANDBOX_WAP_JUMP_TO_TENPAY_ADDRESS;
		} else {
			$domain = $this->WAP_JUMP_TO_TENPAY_ADDRESS;
		}
		return $domain;
	}
	
	/**
	 * �õ��ص��Ƹ�ͨURL
	 * 
	 * @param 
	 */
	function getURL() {
		$url = $this->getDomain().'?'.parent::genParaStr();
		return $url;
	}

	function  send(){
		//CommonResponse
		return null;
	}
	
}
?>