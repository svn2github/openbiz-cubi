<?php

require_once ('../classes/WapPayRequest.class.php');

/**
 * ����֧������ʾ��,��������֧������
 * 
 * @author marcyli
 * @date 2011-05-11
 * @php5
 * @version 1.0
 */

// ǩ����Կ: ������ע��ʱ�ɲƸ�ͨ����
$secretKey = '28361125644222151345528281136580';
// ����֧���������
$req = new WapPayRequest($secretKey);
$microBlogRequest = new MicroBlogSendRequest($secretKey);
// ������ɳ�������У���ʽ����������Ϊfalse
$microBlogRequest->setInSandBox(true);
$microBlogRequest->setParameter("content", "��ͼƬ΢������");
$microBlogRequest->setParameter("input_charset", "gb2312");
$microBlogRequest->setParameter("picUrl", "https://img.tenpay.com/v2.0/img/index_iphone.jpg");
$microBlogRequest->setAppid("0000000994");
echo $microBlogRequest->toHTML();
?>
