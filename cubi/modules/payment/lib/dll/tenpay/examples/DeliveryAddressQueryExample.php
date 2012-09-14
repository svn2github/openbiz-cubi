<?php
//---------------------------------------------------------
//生成支付请求串示例,用于生成支付请求
//---------------------------------------------------------

require_once ("../classes/DeliveryAddressQueryRequest.class.php");
require_once ("tenpay_config.php");


/* 初始化通知验证请求 */
$DAreqHandler = new DeliveryAddressQueryRequest($key);

// 设置在沙箱中运行，正式环境请设置为false
$DAreqHandler->setInSandBox(true);
//----------------------------------------
//以下业务参数名称参考开放平台sdk文档-PHP
//----------------------------------------

// 设置财付通appid: 财付通app注册时，由财付通分配
$DAreqHandler->setAppid($appid);

// 设置用户token, 可以通过ShareLoginState类的getToken()方法获得, 具体参见ShareLoginState类getToken()方法
$DAreqHandler->setParameter("token", "F9E2B324183DDD1F65A9E0D60191BD3F1DF62A7A0B0F9B1990A7346A7A30495E3FB0148BD6E61E99658EAE042A246F08");
      
// 发送请求，并获取返回对象
$DAresponse = $DAreqHandler->send();
// 判断返回是否成功
if($DAresponse->isRetCodeOK()) {
	// 得到用户收货地址列表
	$addressInfoList = $DAresponse->getDeliveryAddresss();
	foreach($addressInfoList as $addressInfo) //循环读取每一个子节点
	{
		// 地址信息
		echo $addressInfo->getAddress(). "<br/>";
		// 手机号码
		echo $addressInfo->getMobilePhone(). "<br/>";
		// 姓名
		echo $addressInfo->getName(). "<br/>";
		// 固定电话
		echo $addressInfo->getTelPhone(). "<br/>";
		// 邮编
		echo $addressInfo->getZipCode(). "<br/>";
	}
}else{
    echo "查询用户收货地址失败." . "<br/>";
}

?>