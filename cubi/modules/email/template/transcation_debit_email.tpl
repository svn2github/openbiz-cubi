<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body style="background-color:#eeeeee;">
<div align="center">
<div style="width:600px;height:600px;border:none;">
	<table cellspacing="0" width="600" height="600" style="width:600px;height:600px;border:3px solid #DDDDDD;background-color:#ffffff;">
	<tr><td valign="top"><img width="600" height="178" alt="Openbiz 客户服务中心" src="{$refer_url}/images/email_background_store_header.png" border="0" style="width:600px;height:178px;border:none;"/></td></tr>
	<tr><td valign="top">
	<div style="padding-left:60px;">
		<h1 style="font-size:24px; padding:0px; margin:0px;color:#333333;">财务帐户充值确认通知</h1>
		<p style="font-size:14px; padding:0px; margin:0px;padding-top:30px;line-height:22px;color:#333333;padding-right:60px;">
		亲爱的 {$display_name} ，<br/>您在客户服务中心刚刚进行了帐户充值，该笔交易详细信息如下：<br/>
		<br/>
		<table>
			<tr>
				<td style="padding-right:10px;">交易流水号</td>
				<td>{$code}</td>
			</tr>
			<tr>
				<td>账户名称</td>
				<td>{$account_name}</td>
			</tr>
			<tr>
				<td>充值详情</td>
				<td>{$comment}</td>
			</tr>
			<tr>
				<td>充值金额</td>
				<td style="color:#ff0000;">{$debit_display}</td>
			</tr>
			<tr>
				<td>充值时间</td>
				<td>{$create_time}</td>
			</tr>
			<tr>
				<td>操作人员</td>
				<td>{$create_by_display}</td>
			</tr>
		</table>
		
		<br/>
	 	您可以通过登陆 <a style="color:#02a5ea;"  href="{$refer_url}">Openbiz 客户服务中心</a> 来查询您财务帐户信息。<br/>
	 	如果您在产品使用中遇到问题，欢迎您 <a style="color:#02a5ea;"  href="http://www.openbiz.cn/about/contact.php">联系我们</a> 寻求支持。<br/>
		
		<br/>顺祝商祺<br/>
		{$action_timestamp}
		</p>
		<p style="font-size:14px; text-align:right;padding-right:50px;padding-top:20px;color:#333333;line-height:22px;">Openbiz 客户服务中心<br/><a style="color:#02a5ea;" href="{$refer_url}">{$refer_url}</a></p>
	</div>
	</td></tr>
	<tr><td width="600" height="152"  style="width:600px;height:152px;background-image: url({$refer_url}/images/email_background_footer.jpg);background-repeat:no-repeat;background-position: bottom center;"><img width="600" height="152" alt="Openbiz Email Footer" src="{$refer_url}/images/email_background_footer.jpg" border="0" style="width:600px;height:152px;border:none;"/></td></tr>
	</table>
	</div>
</div>	
</body>