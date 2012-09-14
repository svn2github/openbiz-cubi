<?php
//---------------------------------------------------------
//¶©µ¥²éÑ¯ÏìÓ¦
//---------------------------------------------------------

require_once ("common/CommonResponse.class.php");
class OrderQueryResponse extends CommonResponse {
	
	function OrderQueryResponse($paraMap, $secretKey) {
		$this->CommonResponse($paraMap, $secretKey);
	}
	
}


?>