<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Plugin Service - Openbiz Framework - <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../../general/js/general.js" type="text/javascript"  ></script>


<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<link href="style/general.css" rel="stylesheet" type="text/css" />
<link href="style/plugin-service.css" rel="stylesheet" type="text/css" />
<script src="js/navigation.js" type="text/javascript" ></script>

<?php require_once(SITE_ROOT_PATH.'/general/_include/_site-analytics.php'); ?>
</head>

<body>
<div align="center" id="site-page-wrapper">
	<!-- site header START -->
	<?php require_once(SITE_ROOT_PATH.'/general/_include/_site-header.php'); ?>
	<!-- site header END -->  

	<!-- site secondary navigation START -->
	<?php require_once(SITE_ROOT_PATH.'/developer/framework/_include/_framework-navigation.php'); ?>
	<!-- site secondary navigation END -->
	
	<div id="framework-intro-banner-wrapper" >
		<div id="framework-plugin-banner-wrapper" >
			<div id="framework-banner" class="banner" >
				<div class="desc">
					<h1 style="height:auto; padding-top:45px;"><a href="../framework.php"><img src="image/pluginservice/banner-title.png" title="Openbiz Framework"/></a></h1>
					<h2>Ensure full extendability</h2>
					<p style="padding-bottom:12px;padding-top:4px;">
						Rich extendable services<br/>
						help your implement complicated logic
					</p>									
						<p style="width:100px;padding-top:15px;">
							<a class="blue-button-go" href="#" >Download</a>
						</p>
				</div>
			</div>
		</div>	
	</div>
	
	<div class="content">
		<div class="page-splitter"></div>	
		<h2>Openbiz Pluign Service</h2>
		<p>Openbiz allows developers to write plugin services to implementate their own logic. Similar with other Openbiz objects, a plugin service is also defined by XML metadata. Some services are listed below.</p>
		<table class="present-features" cellspacing="0">	
		<tr>
			<td>
				<img src="image/pluginservice/icon-firewall.png" />
			</td>
			<td class="desc">
				<h4>Security service</h4>
				<p>This service can filter out unsecured requests. It is like a soft firewall for your application</p>
			</td>
			<td>
				<img src="image/pluginservice/icon-cache.png" />
			</td>
			<td class="desc">
				<h4>Cache Service</h4>
				<p>This service provides API for developers to implement data cache. It also supports different cache storage options.</p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="image/pluginservice/icon-archive.png" />
			</td>
			<td class="desc">
				<h4>User Profile service</h4>
				<p>This service is to pull current logged-in user's profile that is a key data used by many other components. </p>
			</td>
			<td>
				<img src="image/pluginservice/icon-id.png" />
			</td>
			<td class="desc">
				<h4>User Authentication service</h4>
				<p>This service usually is used to authenticate user to enter an application. Developers can extend it to link database or LDAP server.</p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="image/pluginservice/icon-system.png" />
			</td>
			<td class="desc">
				<h4>System Preference service</h4>
				<p>This service allows administrator to set system preferences</p>
			</td>
			<td>
				<img src="image/pluginservice/icon-mail.png" />
			</td>
			<td class="desc">
				<h4>Email service</h4>
				<p>This service can be configured to use SMTP or sendmail protocol. </p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="image/pluginservice/icon-favour.png" />
			</td>
			<td class="desc">
				<h4>Event Log service</h4>
				<p>This service provide API to log user activities. It also can be linked to a Form element event handler. </p>
			</td>
			<td>
				<img src="image/pluginservice/icon-list.png" />
			</td>
			<td class="desc">
				<h4>List of Value service</h4>
				<p>This service provides program readable array from data list defined in XML elements</p>
			</td>
		</tr>
		<tr>
			<td>				
				<img src="image/pluginservice/icon-key.png" />
			</td>
			<td class="desc">
				<h4>Access Service</h4>
				<p>Access service provides a simple way to set access permission to views based on user roles. It works well for small application.</p>
			</td>
			<td>
				<img src="image/pluginservice/icon-lock.png" />
			</td>
			<td class="desc">
				<h4>Data Visibility service</h4>
				<p>This service is used to generate data query rules based on the user group</p>
			</td>
		</tr>			
		</table>
		<div class="page-splitter"></div>			
		<h2>Create your own service</h2>
		<p>
			Creating a plugin service is same as creating an Openbiz object. You can just create it in a sub directory under "modules" directory. Unlike other Metadata based objects, a plugin service does not have fixed metadata schema. Openbiz service is usually defined by 2 files.
		</p>
		<ul class="three-se">
			<li>Service Metadata file</li>
  			<li>Service implementation class file</li>
		</ul>
		<p>
			Developers can copy an existing service metadata file service_name.xml and class file service_name.php. Then start editing the metadata as well as the class code.
		</p>
		
		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >Download</a></td>
					<td>
						<p>
							Download Openbiz framework today to build your own services.
						</p>
					</td>
				</tr>
			</table>
		</div>		
		<!-- 页面底部的购买区域 结束 -->
	</div>	
    <!-- site footer START -->
	<?php require_once(SITE_ROOT_PATH.'/general/_include/_site-footer.php'); ?>
	<!-- site footer END -->    
</div> 
</body>
</html>