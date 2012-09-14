<?php
//---------------------------------------------------------
//�����ص�xml����
//---------------------------------------------------------

class XmlParseUtil{
	
	/**
	 * ����xml�ַ���ΪDocument����
	 * 
	 * @param xmlStr
	 * @param charsetName
	 * @return
	 */
	function parseDoc($xmlStr, $charsetName){
		$dom = new DOMDocument('1.0', $charsetName);
        $dom->loadXML($xmlStr);
		return $dom;
	}
	
	/**
	 * ��xml����Ϊmap
	 * 
	 * @param xml
	 * @param charset
	 * @return
	 */
	function openapiXmlToMapByDoc($doc, $charset) {
		$doc->normalize();
		$root = $doc->documentElement; //��ȡXML���ݵĸ�
		$nodeList = $root->childNodes; //���$node�������ӽڵ�
		return $this->openapiXmlToMapByNodeList($nodeList, $charset);
	}

	/**
	 * ��xml nodelist����Ϊmap
	 * 
	 * @param xml
	 * @param charset
	 * @return
	 */
	function openapiXmlToMapByNodeList($nodeList, $charset) {
		$hashMap = array();
		if(!empty($nodeList)){
			foreach($nodeList as $e) //ѭ����ȡÿһ���ӽڵ�
			{
				if($e->nodeType == XML_ELEMENT_NODE) //����ӽڵ�Ϊ�ڵ��������ú�������
				{
					$value= iconv("UTF-8",$charset,$e->nodeValue); //ע��Ҫת��������ģ���ΪXMLĬ��ΪUTF-8��ʽ
					$hashMap[$e->nodeName] = $value;
				}
			}
		}
		return $hashMap;
	}

	/**
	 * ��xml����Ϊmap
	 * 
	 * @param xml
	 * @param charset
	 * @return
	 */
	function openapiXmlToMap($xml, $charset) {
		$stringDOM = new DOMDocument();
		try{
			@$stringDOM->loadXML($xml);
			return $this->openapiXmlToMapByDoc($stringDOM, $charset);
		}
		catch(Exception $e){
			throw new SDKRuntimeException("����xmlʧ��:" . $xml . ",". $e . "<br>");
		}
	}
	
	/**
	 * �õ�Ψһ�����ı�
	 * 
	 * @param doc      XML Document
	 * @param tagName  �����
	 * @return
	 */
	function getSingleValue($doc, $tagName) {
		$tmp_tag = $doc->getElementsByTagName($TagName);
        $tmp_value = $tmp_tag -> nodeValue;
        return iconv("UTF-8","GBK",$tmp_value);
	}

	
}


?>