<?php
//---------------------------------------------------------
//��Ӧ�����࣬������ز���������
//---------------------------------------------------------

include_once ("SDKRuntimeException.class.php");
include_once("util/CommonUtil.php");
include_once("util/MD5SignUtil.php");
include_once("util/XmlParseUtil.php");
class CommonResponse {
	var $RETCODE = "retcode";
	var $RETMSG = "retmsg";
	var $TRADE_STATE = "trade_state";
	var $TRADE_STATE_SUCCESS = "0";
	/** ��Կ */
	var $secretKey;
	var $parameters = array();
	var $hasRetcode = true;
	var $hasSign = true;
	
	function __call($method, $arguments)
	{
		if ($method=="CommonResponse") {
			if(count($arguments)==2){
				$this->CommonResponse2($arguments[0],$arguments[1]);
			}
			if(count($arguments)==3){
				$this->CommonResponse3($arguments[0],$arguments[1],$arguments[2]);
			}
			if(count($arguments)==4){
				$this->CommonResponse4($arguments[0],$arguments[1],$arguments[2],$arguments[3]);
			}
			if(count($arguments)==5){
				$this->CommonResponse5($arguments[0],$arguments[1],$arguments[2],$arguments[3],$arguments[4]);
			}
		}
	}
	
	function CommonResponse2($paraMap,$secretKey) {
		$this->CommonResponse($paraMap, $secretKey, true);
	}
	
	function CommonResponse3($paraMap, $secretKey, $hasRetcode) {
		$this->CommonResponse($paraMap, $secretKey, $hasRetcode, true);
	}
	
	function CommonResponse4($paraMap, $secretKey, $hasRetcode, $hasSign) {
		$this->hasRetcode = $hasRetcode;
		$this->hasSign = $hasSign;
		$this->secretKey = $secretKey;
		unset($this->parameters);
		$this->parameters = $paraMap;
		if ($this->checkSign()) {
			$this->verifySign();
		}
	}
	
	function CommonResponse5($xml, $charset, $secretKey,$hasRetcode, $hasSign) {
		$xmlUtil = new XmlParseUtil();
		$this->CommonResponse4($xmlUtil->openapiXmlToMap($xml, $charset), $secretKey, $hasRetcode, $hasSign);
	}
	
	protected function verifySign(){
		try {
		if (null == $this->parameters) {
			throw new SDKRuntimeException("parametersΪ��!". "<br>");
		}
		
		$sign = $this->getParameter("sign");
		if (null == $sign) {
			throw new SDKRuntimeException("signΪ��!". "<br>");
		}
		$charSet = $this->getParameter("input_charset");
		if (null == $charSet) {
			$charSet = Constants::DEFAULT_CHARSET;
		}
		$signStr = CommonUtil::formatQueryParaMap($this->parameters, false);
		if (null == $this->secretKey) {
			throw new SDKRuntimeException("ǩ��keyΪ��!". "<br>");
		}
		if(!MD5SignUtil::verifySignature($signStr,$sign,$this->secretKey)){
			throw new SDKRuntimeException("����ֵǩ����֤ʧ��!". "<br>");
		}
		return true;
		}catch (SDKRuntimeException $e)
		{
			die($e->errorMessage());
		}
	}
	/**
	 * ��ȡ��Կ
	 */
	function getSecretKey(){
		return $this->key;
	}
	/**
	 * ������Կ
	 * 
	 * @param secretKey
	 *            ��Կ
	 */
	function setSecretKey($secretKey){
		$this->key = $secretKey;
	}
	/**
	*��ȡ����ֵ
	*/
	function getParameter($parameter) {
		return $this->parameters[$parameter];
	}
	
	/**
	*���ò���ֵ
	*/
	function setParameter($parameter, $parameterValue) {
		$this->parameters[$parameter] = $parameterValue;
	}
	
	/**
	 * ����Ƿ���Ҫǩ��
	 * 
	 * @return �Ƿ�ǩ��
	 */
	function checkSign() {
		return $this->isRetCodeOK() && $this->hasSign;
	}
	/**
	 * �ӿڵ����Ƿ�ɹ�
	 */
	function isRetCodeOK(){
		$code = (bool)$this->hasRetcode;
		return "0"==$this->getRetCode() || !$code;
	}
	
	function isPayed(){
		return $this->isRetCodeOK() && $this->TRADE_STATE_SUCCESS == $this->getParameter($this->TRADE_STATE);
	}
	/**
	 * ��ȡ�ӿڷ�����
	 */
	function getRetCode(){
		return $this->getParameter($this->RETCODE);
	}
	/**
	 * ��ȡ������Ϣ
	 */
	function getPayInfo(){
	    $info = $this->getParameter($this->RETMSG);
		if(null == CommonUtil::trimString($info) && !$this->isPayed()){
		   $info = "������δ֧���ɹ�";
		}
		return $info;
	}
	
	
}


?>