<?php
//---------------------------------------------------------
//�ջ���ַ��ѯ��Ӧ
//---------------------------------------------------------
require_once ("common/CommonResponse.class.php");
require_once ("common/util/XmlParseUtil.php");
require_once ("DeliveryAddressInfo.class.php");
class DeliveryAddressQueryRespone extends CommonResponse{
	
	// ��ַ�б�
	var $deliveryAddresss = array();
	
	/**
	 * XML���췽��
	 * 
	 * @param xml        �ջ���ַ��ѯXML
	 * @param charset    XML�ַ���
	 */
	function DeliveryAddressQueryRespone($xml, $charset) {
		$this->CommonResponse($xml, $charset, null, true, false);
		$this->parseDeliveryAddress($xml, $charset);
	}

	/**
	 * �õ��û�ID
	 * 
	 * @return  �û�ID
	 */
	function getUser_id() {
		return $this->getParameter("user_id");
	}

	/**
	 * �õ�APPID
	 * 
	 * @return  Ӧ��APPID,�û�ע��ʱ�ɲƸ�ͨͳһ����
	 */
	function getApp_id() {
		return $this->getParameter("appid");
	}

	/**
	 * �õ��ջ���ַ�б�
	 * 
	 * @return  �ջ���ַ�б�
	 */
	function getDeliveryAddresss() {
		return $this->deliveryAddresss;
	}

	function setDeliveryAddresss($deliveryAddresss) {
		$this->deliveryAddresss = $deliveryAddresss;
	}
	/**
	 * ��xml����Ϊ��ַ�б�
	 * 
	 * @param xml       ��Ҫ������XML
	 * @param charset   XML���ַ���
	 */
	function parseDeliveryAddress($xml, $charset) {
		$doc = null;
		$xmlUtil = new XmlParseUtil();
		try {
			$doc = $xmlUtil->parseDoc($xml, $charset);
		} catch (Exception $e) {
			throw new SDKRuntimeException("����xmlʧ��:" . $xml . ",". $e);
		}
		$deliveryAddressInfo = null;
		$addresss = array();
		// ��ȡ��ַ�б�
		$root = $doc->documentElement;
		foreach($root->childNodes as $node) {
			if ($node->nodeName == "addressInfos") {
				foreach($node->childNodes as $child) {
					if ($child->nodeName == "item") {
						$node = $child;
						$deliveryAddressInfo = new DeliveryAddressInfo();
						foreach($node->childNodes as $child) {
							$value= iconv("UTF-8",$charset,$child->nodeValue); //ע��Ҫת��������ģ���ΪXMLĬ��ΪUTF-8��ʽ
							$this->setAddressInfoAttr($deliveryAddressInfo,$child->nodeName,$value);
						}
						array_push($addresss,$deliveryAddressInfo);
					}
				}
			}
		}
		$this->setDeliveryAddresss($addresss);
	}
	
	/**
	 * ����XML�������,����DeliveryAddressInfo��Ӧ������
	 * 
	 * @param deliveryAddressInfo   ��Ҫ���õ�DeliveryAddressInfo����
	 * @param nodeName              XML�������
	 * @param textContent           XML����ı�
	 */
	function setAddressInfoAttr($deliveryAddressInfo, $nodeName, $textContent) {
		if(strcmp("address",$nodeName)==0) {
			$deliveryAddressInfo->setAddress($textContent);
		} 
		
		if(strcmp("mobilePhone",$nodeName)==0) {
			$deliveryAddressInfo->setMobilePhone($textContent);
		} 
		
		if(strcmp("name",$nodeName)==0) {
			$deliveryAddressInfo->setName($textContent);
		} 
		
		if(strcmp("telPhone",$nodeName)==0) {
			$deliveryAddressInfo->setTelPhone($textContent);
		} 
		
		if(strcmp("zipCode",$nodeName)==0) {
			$deliveryAddressInfo->setZipCode($textContent);
		} 
	}
}


?>