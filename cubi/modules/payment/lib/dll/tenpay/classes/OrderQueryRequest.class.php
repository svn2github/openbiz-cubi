<?php
//---------------------------------------------------------
//������ѯ����
//---------------------------------------------------------


require_once ("common/RetXmlRequest.class.php");
require_once ("OrderQueryResponse.class.php");
class OrderQueryRequest extends RetXmlRequest{
	
	/**
	 * ���췽��
	 * 
	 * @param secretKey
	 */
	function OrderQueryRequest($secretKey) {
		parent::RetXmlRequest($secretKey);
	}
	
	function send(){
		$respone = new OrderQueryResponse($this->retXmlHttpCall($this->NORMALQUERY_OPPOSITE_ADDRESS),$this->getSecretKey());
		return $respone;
	}
	
}


?>