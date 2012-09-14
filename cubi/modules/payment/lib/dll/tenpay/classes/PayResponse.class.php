<?php
//---------------------------------------------------------
//֧���ص���Ӧ
//---------------------------------------------------------

require_once ("common/CommonResponse.class.php");
class PayResponse extends CommonResponse{
	//֪ͨID
	var $NOTIFYID = "notify_id";
	
	/**
	 * �����request��respone�Լ�secretKey
	 */ 
	function PayResponse($secretKey) {
		try {
			unset($this->parameters);
			$this->secretKey = $secretKey;
			/* GET */
			foreach($_GET as $k => $v) {
				$this->setParameter($k, $v);
			}
			/* POST */
			foreach($_POST as $k => $v) {
				$this->setParameter($k, $v);
			}
			$this->CommonResponse($this->parameters,$this->secretKey, false);
		}catch (SDKRuntimeException $e)
		{
			die($e->errorMessage());
		}
        $this->NOTIFYID = $this->getParameter("notify_id");
		unset($this->parameters);
	}
	/**
	 * ��֪�Ƹ�ͨ�ص�����ɹ�
	 */
	function acknowledgeSuccess(){
		echo "success";
		return true;
	}
	
	/**
	 * ��ȡ֪ͨ��ѯID
	 * 
	 * @return ֪ͨ��ѯID
	 */
	function getNotifyId(){
		return $this->NOTIFYID;
	}
	
}


?>