<?php
require_once ('../classes/WapLoginRequest.class.php');

/**
 * 生成Wap财付通登录URL示例, 用于在财付通登录
 * 
 * @author marcyli
 * @date 2011-05-11
 * @php5
 * @version 1.0
 */

// 签名密钥: 开发者注册时由财付通分配
$secretKey = '64507558218450442324574381315452';
// 创建支付请求对象
$req = new WapLoginRequest($secretKey);
// 设置在沙箱中运行，正式环境请设置为false
$req->setInSandBox(true);
$req->setAppid('0000000201');
// *************************以下业务参数名称参考开放平台sdk文档-JAVA****************************
// 财付通分配的合作方标志，可以是商户号、财付通账户
$req->setParameter('chnid', '2000000501');
// 财付通登录成功之后跳转URL
$req->setParameter('redirect_url', 'http://172.25.38.238:8080/sdktest/WapLoginExampleServlet');
// 财付通登录成功后,作为返回给redirect_url的参数，财付通不做任何修改
$req->setParameter('attach', 'test=123');
// 商户向财付通发起请求的时间戳
$req->setParameter('tmstamp', ''.date('Y-m-d H:i:s'));
//echo $req->getURL();
// 打印财付通登录URL 
header('text/vnd.wap.wml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">
<wml>
<card title="登录">
<p><a href="<?echo $req->getURL();?>">登录</a>
</p>
</card>
</wml>