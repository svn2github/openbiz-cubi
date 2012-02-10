<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body style="background-color:#eeeeee;">
<div align="center">
<div style="width:600px;height:600px;border:none;">
	<table cellspacing="0" width="600" height="600" style="width:600px;height:600px;border:3px solid #DDDDDD;background-color:#ffffff;">
	<tr><td valign="top"><img width="600" height="178" alt="Openbiz Collaboration" src="{$refer_url}/images/email_background_collab_header.jpg" border="0" style="width:600px;height:178px;border:none;"/></td></tr>
	<tr><td valign="top">
	<div style="padding-left:60px;">
		<h1 style="font-size:24px; padding:0px; margin:0px;color:#333333;">You have a planned event about to start</h1>
		<p style="font-size:14px; padding:0px; margin:0px;padding-top:30px;line-height:22px;color:#333333;">
	The event <strong style="color:#02a5ea;">{$subject}</strong> should be start on  <strong style="color:#02a5ea;">{$start_time}</strong><br/>	
	{if $location!= '' }at {$location} <br/>{/if}
	<br/>
	You can click this link to login <a style="color:#02a5ea;" href="{$refer_url}">Openbiz Collaboration</a> system.<br/>
	{$action_timestamp}
		</p>
		<p style="font-size:14px; padding-left:300px;padding-top:20px;color:#333333;">Openbiz Collaboration</p>	
	</div>
	</td></tr>
	<tr><td width="600" height="152"  style="width:600px;height:152px;background-image: url({$refer_url}/images/email_background_footer.jpg);background-repeat:no-repeat;background-position: bottom center;"><img width="600" height="152" alt="Openbiz Email Footer" src="{$refer_url}/images/email_background_footer.jpg" border="0" style="width:600px;height:152px;border:none;"/></td></tr>
	</table>
	</div>
</div>	
</body>