<?php

require_once ('../classes/WapPayRequest.class.php');

/**
 * 生成支付请求串示例,用于生成支付请求
 * 
 * @author marcyli
 * @date 2011-05-11
 * @php5
 * @version 1.0
 */

// 签名密钥: 开发者注册时由财付通分配
$secretKey = '28361125644222151345528281136580';
// 创建支付请求对象
$req = new WapPayRequest($secretKey);
$microBlogRequest = new MicroBlogSendRequest($secretKey);
// 设置在沙箱中运行，正式环境请设置为false
$microBlogRequest->setInSandBox(true);
$microBlogRequest->setParameter("content", "带图片微薄测试");
$microBlogRequest->setParameter("input_charset", "gb2312");
$microBlogRequest->setParameter("picUrl", "https://img.tenpay.com/v2.0/img/index_iphone.jpg");
$microBlogRequest->setAppid("0000000994");
echo $microBlogRequest->toHTML();
?>
