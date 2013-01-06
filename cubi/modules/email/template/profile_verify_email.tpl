<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body style="background-color:#eeeeee;">
<div align="center">
<div style="width:600px;height:600px;border:none;">
	<table cellspacing="0" width="600" height="600" style="width:600px;height:600px;border:3px solid #DDDDDD;background-color:#ffffff;">
	<tr><td valign="top"><img width="600" height="178" alt="Openbiz 客户服务中心" src="{$refer_url}/images/email_background_store_header.png" border="0" style="width:600px;height:178px;border:none;"/></td></tr>
	<tr><td valign="top">
	<div style="padding-left:60px;">
		<h1 style="font-size:24px; padding:0px; margin:0px;color:#333333;">您的电子邮件身份验证码</h1>
		<p style="font-size:14px; padding:0px; margin:0px;padding-top:30px;line-height:22px;color:#333333;padding-right:60px;">
		亲爱的 {$operator_name} ，<br/>您在客户服务中心的电子邮件身份验证码如下：<br/>
		<span style="font-size:30px;color:#02a5ea;display:block;padding:5px;height:40px;line-height:40px;">{$code}</span>
		
	您可以通过 <a style="color:#02a5ea;" href="{$refer_url}/index.php/mystore/email_verify/code_{$code}">点击这里</a> 来完成身份认证，或登陆 <a href="{$refer_url}">Openbiz 客户服务中心</a>将您的身份验证码手工输入到对话框中即可完成电子邮件身份验证过程。<br/>
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