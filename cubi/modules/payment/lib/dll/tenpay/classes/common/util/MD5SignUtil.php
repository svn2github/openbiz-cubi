<?php
//---------------------------------------------------------
//MD5���ܴ�����
//---------------------------------------------------------


class MD5SignUtil {
	
	function sign($content, $key) {
	    try {
		    if (null == $key) {
			   throw new SDKRuntimeException("ǩ��keyΪ�գ�" . "<br>");
		    }
			if (null == $content) {
			   throw new SDKRuntimeException("���ܴ�Ϊ�գ�" . "<br>");
		    }
		    $signStr = $content . "&key=" . $key;
		
		    return md5($signStr);
		}catch (SDKRuntimeException $e)
		{
			die($e->errorMessage());
		}
	}
	
	function verifySignature($content, $sign, $md5Key) {
		$signStr = $content . "&key=" . $md5Key;
		$calculateSign = strtolower(md5($signStr));
		$tenpaySign = strtolower($sign);
		return $calculateSign == $tenpaySign;
	}
	
}


?>