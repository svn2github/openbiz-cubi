<?php
//---------------------------------------------------------
//�Զ����쳣������
//---------------------------------------------------------


class  SDKRuntimeException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}

}

?>