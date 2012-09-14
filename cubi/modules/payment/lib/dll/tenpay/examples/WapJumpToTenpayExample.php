<?php
require_once ("../classes/WapJumpToTenpayRequest.class.php");

/**
 * 商户回跳财付通接口示例, 用户
 * 
 * @author marcyli
 * @date 2011-05-11
 * @php5
 * @version 1.0
 */

// 签名密钥: 开发者注册时由财付通分配
$secretKey = '64507558218450442324574381315452';
// 创建支付请求对象
$req = new WapJumpToTenpayRequest($secretKey);
// 设置在沙箱中运行，正式环境请设置为false

$req->setInSandBox(true);
// 设置财付通appid: 财付通app注册时，由财付通分配
$req->setAppid('0000000201');

// *************************以下业务参数名称参考开放平台sdk文档-JAVA****************************
// 财付通分配的合作方标志，可以是商户号、财付通账户
$req->setParameter('chnid', '2000000501');
// 财付通登录成功之后跳转URL
$req->setParameter('redirecturl','http://172.25.38.238:9088/sdktest/WapLoginServlet');
// 财付通登录成功后,财付通下发的request_token, 参数若无登录态时, 此字段填固定值：NO_LOGIN
$req->setParameter('request_token',$_GET['request_token']);

// 打印财付通登录URL
//echo $req->getURL();
header('text/vnd.wap.wml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">
<wml>
<card title="登录">
<p><a href="<?echo $req->getURL();?>">跳转</a>
</p>
</card>
</wml>