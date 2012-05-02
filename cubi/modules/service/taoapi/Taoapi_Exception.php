<?php
/**
 * 淘宝错误处理类
 *
 * @category Taoapi
 * @package Taoapi_Exception
 * @copyright Copyright (c) 2008-2009 PHPDIY (http://www.taoapi.com)
 * @license    http://www.taoapi.com
 * @version    Id: Taoapi  2009-12-22  12:30:51 旺旺:浪子Arvin QQ:8769852
 */
class Taoapi_Exception
{
    private $_ErrorInfo;

    public function __construct ($error, $paramArr = null, $closeerror = false,$Errorlog = false)
    {
        return $this->ViewError($error, $paramArr, $closeerror,$Errorlog);
    }

    public function getErrorInfo()
    {
        return $this->_ErrorInfo;
    }

    private function ErrorInfo ($errorcode)
    {
 		$errorinfo[3]=array('en'=>'Upload Fail','cn'=>'图片上传失败');
		$errorinfo[4]=array('en'=>'User Call Limited','cn'=>'用户调用次数超限');
		$errorinfo[5]=array('en'=>'Session Call Limited','cn'=>'会话调用次数超限');
		$errorinfo[6]=array('en'=>'Partner Call Limited','cn'=>'合作伙伴调用次数超限');
		$errorinfo[7]=array('en'=>'App Call Limited','cn'=>'应用调用次数超限');
		$errorinfo[8]=array('en'=>'App Call Exceeds Limited Frequency','cn'=>'应用调用频率超限');
		$errorinfo[9]=array('en'=>'Http Action Not Allowed','cn'=>'HTTP方法被禁止（请用大写的POST或GET）');
		$errorinfo[10]=array('en'=>'Service Currently Unavailable','cn'=>'服务不可用');
		$errorinfo[11]=array('en'=>'Insufficient ISV Permissions','cn'=>'开发者权限不足');
		$errorinfo[12]=array('en'=>'Insufficient User Permissions','cn'=>'用户权限不足');
		$errorinfo[13]=array('en'=>'Insufficient Partner Permissions','cn'=>'合作伙伴权限不足');
		$errorinfo[15]=array('en'=>'Remote Service Error','cn'=>'远程服务出错');
		$errorinfo[21]=array('en'=>'Missing Method','cn'=>'缺少方法名参数');
		$errorinfo[22]=array('en'=>'Invalid Method','cn'=>'不存在的方法名');
		$errorinfo[23]=array('en'=>'Invalid Format','cn'=>'非法数据格式');
		$errorinfo[24]=array('en'=>'Missing Signature','cn'=>'缺少签名参数');
		$errorinfo[25]=array('en'=>'Invalid Signature','cn'=>'非法签名');
		$errorinfo[26]=array('en'=>'Missing Session','cn'=>'缺少SessionKey参数');
		$errorinfo[27]=array('en'=>'Invalid Session','cn'=>'无效的SessionKey参数');
		$errorinfo[28]=array('en'=>'Missing App Key','cn'=>'缺少AppKey参数');
		$errorinfo[29]=array('en'=>'Invalid App Key','cn'=>'非法的AppKe参数');
		$errorinfo[30]=array('en'=>'Missing Timestamp','cn'=>'缺少时间戳参数');
		$errorinfo[31]=array('en'=>'Invalid Timestamp','cn'=>'非法的时间戳参数');
		$errorinfo[32]=array('en'=>'Missing Version','cn'=>'缺少版本参数');
		$errorinfo[33]=array('en'=>'Invalid Version','cn'=>'非法的版本参数');
		$errorinfo[34]=array('en'=>'Unsupported Version','cn'=>'不支持的版本号');
		$errorinfo[40]=array('en'=>'Missing Required Arguments','cn'=>'缺少必选参数');
		$errorinfo[41]=array('en'=>'Invalid Arguments','cn'=>'非法的参数');
		$errorinfo[42]=array('en'=>'Forbidden Request','cn'=>'请求被禁止');
		$errorinfo[43]=array('en'=>'Parameter Error','cn'=>'参数错误');

		$errorinfo[501]=array('en'=>'Your Statement is Not Indexable','cn'=>'语句不可索引');
		$errorinfo[502]=array('en'=>'Data Service Unavailable','cn'=>'数据服务不可用');
		$errorinfo[503]=array('en'=>'Error While Parsing TBQL Statement','cn'=>'无法解释TBQL语句');
		$errorinfo[504]=array('en'=>'Need Binding User','cn'=>'需要绑定用户昵称');
		$errorinfo[505]=array('en'=>'Missing Parameters','cn'=>'缺少参数');
		$errorinfo[506]=array('en'=>'Parameters Error','cn'=>'参数错误');
		$errorinfo[507]=array('en'=>'Parameters Format Error','cn'=>'参数格式错误');
		$errorinfo[508]=array('en'=>'No Permission Get Information','cn'=>'获取信息权限不足');
		$errorinfo[550]=array('en'=>'User Service Unavailable','cn'=>'用户服务不可用');
		$errorinfo[551]=array('en'=>'Item Service Unavailable','cn'=>'商品服务不可用');
		$errorinfo[552]=array('en'=>'Item Image Service Unavailable','cn'=>'商品图片服务不可用');
		$errorinfo[553]=array('en'=>'Item Simple Update Service Unavailable','cn'=>'商品更新服务不可用');
		$errorinfo[554]=array('en'=>'Item Delete Failure','cn'=>'商品删除失败');
		$errorinfo[555]=array('en'=>'No Picture Service for User','cn'=>'用户没有订购图片服务');
		$errorinfo[556]=array('en'=>'Picture URL is Error','cn'=>'图片URL错误');
		$errorinfo[557]=array('en'=>'Item Media Service Unavailable','cn'=>'商品视频服务不可用');
		$errorinfo[560]=array('en'=>'Trade Service Unavailable','cn'=>'交易服务不可用');
		$errorinfo[561]=array('en'=>'Trade TC Service Unavailable','cn'=>'交易服务不可用');
		$errorinfo[562]=array('en'=>'Trade not Exists','cn'=>'交易不存在');
		$errorinfo[563]=array('en'=>'Trade is Invalid','cn'=>'非法交易');
		$errorinfo[564]=array('en'=>'No Permission Add or Update Trade Memo','cn'=>'没有权限添加或更新交易备注');
		$errorinfo[565]=array('en'=>'Trade Memo Too Long','cn'=>'交易备注超出长度限制');
		$errorinfo[566]=array('en'=>'Trade Memo Already Exists','cn'=>'交易备注已经存在');
		$errorinfo[567]=array('en'=>'No Permission Add or Update Trade','cn'=>'没有权限添加或更新交易信息');
		$errorinfo[568]=array('en'=>'No Detail Order','cn'=>'交易没有子订单');
		$errorinfo[569]=array('en'=>'Close Trade Error','cn'=>'交易关闭错误');
		$errorinfo[570]=array('en'=>'Shipping Service Unavailable','cn'=>'物流服务不可用');
		$errorinfo[571]=array('en'=>'Invalid Post Fee','cn'=>'非法的邮费');
		$errorinfo[572]=array('en'=>'Invalid Division Code','cn'=>'非法的物流公司编号');
		$errorinfo[580]=array('en'=>'Rate Service Unavailable','cn'=>'评价服务不可用');
		$errorinfo[581]=array('en'=>'Rate Service Add Error','cn'=>'添加评价服务错误');
		$errorinfo[582]=array('en'=>'Rate Service List Error','cn'=>'获取评价服务错误');
		$errorinfo[590]=array('en'=>'Shop Service Unavailable','cn'=>'店铺服务不可用');
		$errorinfo[591]=array('en'=>'Shop Showcase Remain Count Unavailable','cn'=>'店铺剩余橱窗推荐服务不可用');
		$errorinfo[592]=array('en'=>'Shop Seller Category Service Unavailable','cn'=>'卖家自定义类目服务不可用');
		$errorinfo[594]=array('en'=>'Shop Seller Category Insert Error','cn'=>'卖家自定义类目添加错误');
		$errorinfo[595]=array('en'=>'Shop Seller Category Update Error','cn'=>'卖家自定义类目更新错误');
		$errorinfo[596]=array('en'=>'No Shop for This User','cn'=>'用户没有店铺');
		$errorinfo[597]=array('en'=>'Shop Seller Parent Category Error','cn'=>'卖家自定义父类目错误');
		$errorinfo[540]=array('en'=>'Trade Stat Service Unavailable','cn'=>'交易统计服务不可用');
		$errorinfo[541]=array('en'=>'Category Stat Service Unavailable','cn'=>'类目统计服务不可用');
		$errorinfo[542]=array('en'=>'Item Stat Service Unavailable','cn'=>'商品统计服务不可用');
		$errorinfo[601]=array('en'=>'User not Exists','cn'=>'用户不存在');
		$errorinfo[610]=array('en'=>'Product Service Unavailable','cn'=>'产品服务不可用');
		$errorinfo[710]=array('en'=>'Taobaoke Service Unavailable','cn'=>'淘宝客服务不可用');
		$errorinfo[611]=array('en'=>'Product Number Format Exception','cn'=>'产品数据格式错误');
		$errorinfo[612]=array('en'=>'Product ID Incorrect','cn'=>'产品ID错误');
		$errorinfo[613]=array('en'=>'Product Image Delete Error','cn'=>'删除产品图片错误');
		$errorinfo[614]=array('en'=>'No Permission to Add Product','cn'=>'没有权限添加产品');
		$errorinfo[615]=array('en'=>'Delivery Address Service Unavailable','cn'=>'收货地址服务不可用');
		$errorinfo[620]=array('en'=>'Postage Service Unavailable','cn'=>'邮费服务不可用');
		$errorinfo[621]=array('en'=>'Postage Mode Type Error','cn'=>'邮费模板类型错误');
		$errorinfo[622]=array('en'=>'Missing Parameter: post, express or ems','cn'=>'缺少参数：post, express或ems');
		$errorinfo[623]=array('en'=>'Postage Mode Parameter Error','cn'=>'邮费模板参数错误');
		$errorinfo[630]=array('en'=>'Combo Service Unavailable','cn'=>'收费服务不可用');
		$errorinfo[650]=array('en'=>'Refund Service Unavailable','cn'=>'退款服务不可用');
		$errorinfo[651]=array('en'=>'Refund ID Invalid','cn'=>'非法的退款编号');
		$errorinfo[652]=array('en'=>'Refund Service Unavailable','cn'=>'退款服务不可用');
		$errorinfo[653]=array('en'=>'Refund not Exists','cn'=>'退款不存在');
		$errorinfo[654]=array('en'=>'No Permission to Get Refund','cn'=>'没有权限获取退款信息');
		$errorinfo[655]=array('en'=>'No Permission to Add Refund Message','cn'=>'没有权限添加退款留言');
		$errorinfo[656]=array('en'=>'Cannot add Refund Message for STATUS_CLOSED(4) or STATUS_SUCCESS(5)','cn'=>'无法添加退款留言');
		$errorinfo[657]=array('en'=>'Refund Message Content Too Long','cn'=>'退款留言内容太长');
		$errorinfo[658]=array('en'=>'Refund Message Content Cannot be NULL','cn'=>'退款留言内容不能为空');
		$errorinfo[659]=array('en'=>'Biz Order ID is Invalid','cn'=>'非法的交易订单（或子订单）ID');
		$errorinfo[660]=array('en'=>'Item Extra Service Unavailable','cn'=>'商品扩展服务不可用');
		$errorinfo[661]=array('en'=>'Item Extra not Exists','cn'=>'商品扩展信息不存在');
		$errorinfo[662]=array('en'=>'No Permission Update Item Extra','cn'=>'没有权限更新商品扩展信息');
		$errorinfo[663]=array('en'=>'Shipping Parameter Missing','cn'=>'缺少物流参数');
		$errorinfo[664]=array('en'=>'Shipping Parameter Error','cn'=>'物流参数错误');
		$errorinfo[670]=array('en'=>'Commission Service Unavailable','cn'=>'佣金服务不可用');
		$errorinfo[671]=array('en'=>'Commission Trade not Exists','cn'=>'佣金交易不存在');
		$errorinfo[672]=array('en'=>'Payment Service Unavailable','cn'=>'淘宝客报表服务不可用');
		$errorinfo[673]=array('en'=>'ICP Service Unavailable','cn'=>'备案服务不可用');
		$errorinfo[674]=array('en'=>'App Service Unavailable','cn'=>'应用服务不可用');
		$errorinfo[900]=array('en'=>'Remote Connection Error','cn'=>'远程连接错误');
		$errorinfo[901]=array('en'=>'Remote Service Timeout','cn'=>'远程服务超时');
		$errorinfo[902]=array('en'=>'Remote Service Error','cn'=>'远程服务错误');
		$errorinfo[100]=array('en'=>'授权码已经过期','cn'=>'授权码已经过期');
		$errorinfo[101]=array('en'=>'授权码在缓存里不存在，一般是用同样的authcode两次获取sessionkey','cn'=>'授权码在缓存里不存在，一般是用同样的authcode两次获取sessionkey');
		$errorinfo[103]=array('en'=>'appkey或者tid（插件ID）参数必须至少传入一个','cn'=>'appkey或者tid（插件ID）参数必须至少传入一个');
		$errorinfo[104]=array('en'=>'appkey或者tid对应的插件不存在','cn'=>'appkey或者tid对应的插件不存在');
		$errorinfo[105]=array('en'=>'插件的状态不对，不是上线状态或者正式环境下测试状态','cn'=>'插件的状态不对，不是上线状态或者正式环境下测试状态');
		$errorinfo[106]=array('en'=>'没权限调用此app，由于插件不是所有用户都默认安装，所以需要用户和插件进行一个订购关系。','cn'=>'没权限调用此app，由于插件不是所有用户都默认安装，所以需要用户和插件进行一个订购关系。');
		$errorinfo[108]=array('en'=>'由于app有绑定昵称，而登陆的昵称不是绑定昵称，所以没权限访问。','cn'=>'由于app有绑定昵称，而登陆的昵称不是绑定昵称，所以没权限访问。');
		$errorinfo[109]=array('en'=>'服务端在生成参数的时候出了问题（一般是tair有问题）','cn'=>'服务端在生成参数的时候出了问题（一般是tair有问题）');
		$errorinfo[110]=array('en'=>'服务端在写出参数的时候出了问题','cn'=>'服务端在写出参数的时候出了问题');
		$errorinfo[111]=array('en'=>'服务端在生成参数的时候出了问题（一般是tair有问题）','cn'=>'服务端在生成参数的时候出了问题（一般是tair有问题）');
		
        if (! array_key_exists($errorcode, $errorinfo)) {
            $errorcode = 0;
        }
        return $errorinfo[$errorcode];
    }

    public function WriteError ($error, $paramArr)
    {
        $errorpath = dirname(__FILE__) . '/api_error_log';
        if (! is_dir($errorpath)) {
            @mkdir($errorpath);
        }
        if ($fp = @fopen($errorpath . '/' . date('Y-m-d') . '.log', 'a')) {
            $errorinfotext[] = date('Y-m-d H:i:s');
            $errorinfotext[] = "Error:" . $error['msg'];
            foreach ($paramArr as $key => $value) {
                $errorinfotext[] = $key . " : " . $value;
            }
            $errorinfotext = implode("\t", $errorinfotext) . "\r\n";
            @fwrite($fp, $errorinfotext);
            fclose($fp);
        }
    }

    public function ViewError ($error, $paramArr = null, $closeerror = false,$Errorlog = false)
    {
        $debug = debug_backtrace(false);
        rsort($debug);
        if (is_array($error)) {
            if ($error['code'] < 100) {
                $errorlevel = '系统级错误 ';
            } else {
                $errorlevel = '业务级错误';
            }
			$errortitle = $this->ErrorInfo($error['code']);

            $errortitle = $errortitle ? $errortitle : array('en'=>$error['sub_code'],'cn'=>$error['sub_msg']);
            $this->_ErrorInfo = @implode("\n",$errortitle);
			$errortitle = (object)$errortitle;
			if($Errorlog)
			{
				$this->WriteError($error, $paramArr);
			}
            if($closeerror) {
                return false;
            }
            $errortitlediy = $errorlevel . ": " . $errortitle->en . " (" . $errortitle->cn . ")";
        } else {
            $errortitlediy = $error;
        }

        $view[] = "<br /><font size='1'><table dir='ltr' border='1' cellspacing='0' cellpadding='1' width=\"100%\">";

        $view[] = "<tr><th align='left' bgcolor='#f57900' colspan=\"3\"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> " . $errortitlediy . " in " . $debug[count($debug) - 2]['file'] . " on line <i>" . $debug[count($debug) - 2]['line'] . "</i></th></tr>";

        $view[] = "<tr><th align='left' bgcolor='#e9b96e' colspan='3'>调用函数</th></tr>";
        $view[] = "<tr><th align='center' bgcolor='#eeeeec' width='30'>#</th><th align='left' bgcolor='#eeeeec'>函数名</th><th align='left' bgcolor='#eeeeec'>所在文件</th></tr>";
        $mainfile = basename($debug[0]['file']);

        $view[] = "<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec'>{main}(  )</td><td bgcolor='#eeeeec'>../{$mainfile}<b>:</b>0</td></tr>";

        foreach ($debug as $key => $value) {
            $value['file'] = basename($value['file']);
            $key = $key + 2;
            $view[] = "<tr><td bgcolor='#eeeeec' align='center'>$key</td><td bgcolor='#eeeeec'>{$value['class']}{$value['type']}{$value['function']}(  )</td><td title='{$value['file']}' bgcolor='#eeeeec'>../{$value['file']}<b>:</b>{$value['line']}</td></tr>";
        }

        $view[] = '</table></font>';
        if ($paramArr) {
            $view[] = "<br /><font size='1'><table dir='ltr' border='1' cellspacing='0' cellpadding='1' width=\"100%\">";
            $view[] = "<tr><th align='left' bgcolor='#e9b96e' colspan='4' height='25px'>淘宝API 调用参数列表</th></tr>";
            $view[] = "<tr><th align='center' bgcolor='#eeeeec' width='30px'>#</th><th width='120' align='left' bgcolor='#eeeeec'>参数名称</th><th align='left' bgcolor='#eeeeec'>参数</th><th align='left' bgcolor='#eeeeec' width='50px'>长度</th></tr>";
            $i = 1;
            foreach ($paramArr as $key => $value) {
                $view[] = "<tr><td bgcolor='#eeeeec' align='center'>$i</td><td bgcolor='#eeeeec'>{$key}</td><td bgcolor='#eeeeec'>" . implode(', ', explode(',', $value)) . "</td><td bgcolor='#eeeeec'><b>" . strlen($value) . "</b></td></tr>";
                $i ++;
            }
            $view[] = "<tr><th align='left' bgcolor='#eeeeec' colspan='4' height='25px'>有任何问题请登录：<a href='http://wpa.qq.com/msgrd?V=1&amp;Uin=781902157&amp;Site=DN55&amp;Menu=yes' target='_blank'><img height='16' border='0' src='http://wpa.qq.com/pa?p=1:781902157:4' alt='QQ'>QQ781902157</a> 进行咨询!</th></tr>";
            $view[] = '</table></font>';
        }

        $this->_ErrorInfo =  implode("\n", $view);
    }
}