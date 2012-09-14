<?php
//---------------------------------------------------------
//֧������
//---------------------------------------------------------

require_once ("common/CommonRequest.class.php");
class PayRequest extends CommonRequest {
	
	/**
	 * secretKey
	 * @param secretKey
	 */
	function PayRequest($secretKey) {
		parent::__construct($secretKey);
	}
	
	/**
	 * ����֧����ת����
	 */
	function getURL(){
		$paraString = $this->genParaStr();
		$domain = $this->getDomain();
		return $domain . $this->PAY_OPPOSITE_ADDRESS . "?" . $paraString;
	}
	
	function send(){
		return null;
	}
	
}


?>