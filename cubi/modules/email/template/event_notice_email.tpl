<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body style="background-color:#eeeeee;">
<div align="center">
<div style="width:600px;height:600px;border:none;">
	<table cellspacing="0" width="600" height="600" style="width:600px;height:600px;border:3px solid #DDDDDD;background-color:#ffffff;">
	<tr><td valign="top"><img width="600" height="178" alt="Openbiz Collaboration" src="{$refer_url}/images/email_background_collab_header.jpg" border="0" style="width:600px;height:178px;border:none;"/></td></tr>
	<tr><td valign="top">
	<div style="padding-left:60px;">
		<h1 style="font-size:24px; padding:0px; margin:0px;">Would you have time for this planned event</h1>
		<p style="font-size:14px; padding:0px; margin:0px;padding-top:30px;line-height:22px;">
		Dear {$contact_display_name}:
		We have recently setup a event on {$start_time} about <strong style="color:#02a5ea;">{$subject}</strong> <br/>
		{if $location!= '' }at {$location} <br/>{/if}
		<br/>
		Hope you are still ok with the time plan, <br/>
		If anything need to change, please reply to my <a href="mailto:{{$operator_email}}">{$operator_email}</a>.		
		<br/>
		<br/>
		Best regard!<br/>
		{$operator_display_name}<br/>		
		{$action_timestamp}<br/>
		</p>
		<p style="font-size:14px; padding-left:300px;padding-top:20px;">Openbiz Collaboration</p>	
	</div>
	</td></tr>
	<tr><td valign="bottom"><img width="600" height="152" alt="Openbiz Email Footer" src="{$refer_url}/images/email_background_footer.jpg" border="0" style="width:600px;height:152px;border:none;"/></td></tr>
	</table>
	</div>
</div>	
</body>