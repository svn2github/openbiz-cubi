<?php
require_once ('common/CommonRequest.class.php');
require_once ('common/CommonResponse.class.php');
require_once('common/SDKRuntimeException.class.php');
/**
 * ΢���������
 * <p>
 * ��Ҫ��������"ת��΢����ť��html�����Լ�����΢��ʱ��Ҫ���ݵĲ���"��
 * 
 * @author Tenpay
 * @date 2011-03-28
 * @since jdk1.5
 * @version 1.0
 *
 */
class MicroBlogSendRequest extends CommonRequest {
	/**
	 * 
	 */
	var $serialVersionUID = -6949609732502344014;
	/** ����΢��ȷ��ҳ��URL����  **/
	var $QQ_MICROBLOG_URL ='/gateway/microBlogSendConfirm.htm';
	
	function MicroBlogSendRequest($secretKey) {
		parent::__construct(secretKey);
	}
	
	
	/**
	 * ��������ת����΢����ť��HTML����
	 * @return html����
	 */
	function toHTML(){		
		$microBlogContent = parent::getParameter("content");
		if($microBlogContent == '' )
		throw Exception("microBlogContent����Ϊ��!");
		$stringBuilder = '<link href="https://wallet.tenpay.com/mblog/css/release_button.css" rel="stylesheet" type="text/css" />';
		$stringBuilder = '<a href="'.$this->getURL().'" target="_blank" class="release-txmblog" title="ת������Ѷ΢��"><span>ת������Ѷ΢��</span></a>';
		return $stringBuilder;
	}
	
	/**
	 * ����΢����ת��URl��ַ
	 * @return
	 */
	function getURL(){
		$fromUrl = parent::getParameter("fromUrl");
		if($fromUrl==null){			
			parent::setParameter("fromUrl", $this->getRequestURL(request));
		}
		$paraString = parent::genParaStr();
		$domain = parent::getDomain();
		return $domain.$this->QQ_MICROBLOG_URL.'?'.$paraString;
	}
	/**
	 * ����ȫ·����URL
	 * @param request
	 * @return
	 */
	function getRequestURL($request){
		if($_SERVER['HTTPS'] != '')
			$builder = 'https://'.$_SERVER['SERVER_NAME'];
		else
			$builder = 'http://'.$_SERVER['SERVER_NAME'];
		if($_SERVER["SERVER_PORT"] >0 && $_SERVER["SERVER_PORT"] !=80){
			$builder = $builder.':'.$_SERVER["SERVER_PORT"];
		}
		$builder = $_SERVER['SERVER_NAME'];
		return $builder;
	}

	/**
	 * 
	 */
	function getInputCharset() {
		return parent::getInputCharset();
	}

    
	/**
	 * ����΢����SDK���봫�����²���
	 * key=content(����΢������,����httpЭ�飬������Ϊhttp������������encoder����)
	 * key=picUrl(����ͼƬ��ȫ·��URL��ַ)
	 * key=fromUrl(�ڷ���΢�������qzoneʱ����Ҫ�õ�����Դ��ַ����)
	 */
	function setParameter($key, $value) {
		parent::setParameter($key, $value);
	}


	/* (non-Javadoc)
	 * @see com.tenpay.api.common.CommonRequest#send()
	 */
	function send(){
		throw new Exception();
	}
}
?>