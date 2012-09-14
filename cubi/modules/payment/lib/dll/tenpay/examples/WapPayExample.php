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
// 设置在沙箱中运行，正式环境请设置为false
$req->setInSandBox(true);
// 设置财付通appid: 财付通app注册时，由财付通分配
$req->setAppid('0000000994');

// *************************以下业务参数名称参考开放平台sdk文档-JAVA****************************
// 设置订单总金额，单位为分
$req->setParameter('total_fee', '1');

// 设置商品名称:商品描述，会显示在财付通支付页面上
$req->setParameter('body', 'test测试物品');

// 设置通知url：接收财付通后台通知的URL，用户在财付通完成支付后，财付通会回调此URL，向财付通APP反馈支付结果。
// 此URL可能会被多次回调，请正确处理，避免业务逻辑被多次触发。需给绝对路径，例如：http://wap.isv.com/notify.asp
$req->setParameter('notify_url', 'http://localhost/sdktest/NotifyServlet');

// 设置商户系统订单号：财付通APP系统内部的订单号,32个字符内、可包含字母,确保在财付通APP系统唯一
//app订单号根据需要自定义生成规则，本例使用uuid来生成
$req->setParameter('out_trade_no', '12345678901234567890');

// 设置返回url：用户完成支付后跳转的URL，财付通APP应在此页面上给出提示信息，引导用户完成支付后的操作。
// 财付通APP不应在此页面内做发货等业务操作，避免用户反复刷新页面导致多次触发业务逻辑造成不必要的损失。
// 需给绝对路径，例如：http://wap.isv.com/after_pay.asp，通过该路径直接将支付结果以Get的方式返回
$req->setParameter('return_url', 'http://localhost/sdktest/ReturnServlet');
// 设置用户客户端ip:用户IP，指用户浏览器端IP，不是财付通APP服务器IP
$req->setParameter('spbill_create_ip', $_SERVER['REMOTE_ADDR']);

// 设置request_token
$req->setParameter('request_token', $_GET['request_token']);
// *************************************end**************************************************

// 复制打印连接到浏览器打开
/*try {
	echo $req->getURL();
} catch (Exception $e) {
	//处理异常
	echo $e;
}*/
header('text/vnd.wap.wml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">
<wml>
<card title="支付">
<p><a href="<?echo $req->getURL();?>">支付</a>
</p>
</card>
</wml>