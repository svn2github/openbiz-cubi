<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Rich Components - Openbiz Cubi Platform - <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../../general/js/general.js" type="text/javascript"  ></script>

<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<link href="style/general.css" rel="stylesheet" type="text/css" />
<link href="style/modules.css" rel="stylesheet" type="text/css" />
<script src="js/navigation.js" type="text/javascript" ></script>


<?php require_once(SITE_ROOT_PATH.'/general/_include/_site-analytics.php'); ?>
</head>

<body>
<div align="center" id="site-page-wrapper">
	<!-- site header START -->
	<?php require_once(SITE_ROOT_PATH.'/general/_include/_site-header.php'); ?>
	<!-- site header END -->  

	<!-- site secondary navigation START -->
	<?php require_once(SITE_ROOT_PATH.'/developer/cubi/_include/_cubi-navigation.php'); ?>
	<!-- site secondary navigation END -->
	
	<div id="developer-banner-wrapper" >
		<div id="cubi-modules-banner-wrapper" >
			<div id="cubi-banner" class="banner" >
				<div class="desc">
					<h1 style="height:auto;"><a href="cubi/"><img src="image/modules/banner-title.png" title="Openbiz Cubi Platform"/></a></h1>
					<div style="padding-left:5px;">
					<h2 >You focus on business logic</h2>
					<p>Openbiz Cubi equips your applications <br/> with almost all commonly used functions</p>
					<p class="buttons">
						<a class="blue-button-go" href="#" >Download</a>
					</p>
					</div>
				</div>
			</div>
		</div>	
	</div>
	
	
	<div class="content">
		<div class="page-splitter"></div>	
		<h2>User, Group and Permission Control</h2>
		<table class="module-intro">
			<tr>
				<td>
					<img src="image/modules/user-mng.png" style="padding:10px;padding-left:0px;" />
					
					<p>Openbiz Cubi flexible user permission management is best fit for control access for enterprise users. Openbiz Cubi user management logic is summarized in the diagram on the right. It includes user, role and group. A user can belong to more than one groups, can has multiple roles. A role can map to multiple permissions. </p>
					<ul style="padding-bottom:10px;">
						<li>User's role can define the user's permissions that tell whether the user can access certain application functions. For example, a given user can see all contacts, but not change these contacts.</li>
						<li>User's group and share capabillity can define if certain data is visible to the user. For example, a given user can read contacts, because the user's group is sale group, so he/she can only see all sales related contacts. </li>
					</ul>
				</td>
				<td>
					<img src="image/modules/user-permission.png" style="padding:0px;padding-bottom:20px;" />
				</td>
			</tr>
		</table>
		
		<div class="page-splitter"></div>	
		<h2>Application Module Management</h2>
		<table class="module-intro">
			<tr>
				<td>
					<img src="image/modules/module-mng.png" style="padding:10px;padding-left:0px;" />					
					<p>Openbiz App Market and module management enable easy extension of your applications. Your Cubi based applications can be published as packages and pushed to Openbiz App Market which can be hosted by your server. Such clean separation makes your release and maintenance much easier.</p>
					<p>The relationship between modules and user permissions is demonstrated in the right diagram. Each module has multiple function permission (say access contacts, manage contacts), these permissions can be mapped to different roles. And each role can link many users and a user can have many roles.</p>
				</td>
				<td>
					<img src="image/modules/module-structure.png" style="padding:0px;padding-top:20px;padding-bottom:20px;" />
				</td>
			</tr>
		</table>
		
		<div class="page-splitter"></div>	
		<h2>Email Integration</h2>
		<img src="image/modules/email-intergrated.png" style="padding:10px;padding-left:0px;" />
		<p  style="padding-bottom:20px;">In modern enterprise applications, end users usually ask for email integration. For example, notify events by email, mass sending system messages by email. Openbiz Cubi provides user-friendly interface for managing email templates, setting SMTP account and managing email queue. These functions are normally not regonizable to your clients, but they take a lot of time to implement and test if you do youself. Now Openbiz Cubi have all ready for you to use.
		</p>
		
		<div class="page-splitter"></div>	
		<h2>Advanced Features</h2>
		<img src="image/modules/system-mng.png" style="padding:10px;padding-left:0px;" />
		<p style="padding-bottom:20px;">Openbiz Cubi also provides advanced features including editing system settings, editing application database connections, system backup, system update, and web service setup. 
		</p>
		
		<div class="page-splitter"></div>	
		<h2>More Features</h2>
		<table class="module-intro－2column">
			<tr>			
				<td>
					<img src="image/modules/icon-oauth.png" style="padding:0px;" />
				</td>
				<td>
					<p style="width:330px;padding-right:50px;">	Oauth extension allows users to login the application with their social network account (facebook, QQ, ...). They don't need to enter username and password every time to enter the application.  
					</p>
				</td>
				<td>
					<img src="image/modules/icon-cache.png" style="padding:0px;" />
				</td>
				<td>
					<p style="width:330px;padding-right:30px;">
Sytem cache management gives application admin a simple view of their cache status. It also allows reset of cached data. </p>
				</td>
			</tr>
			
			<tr>			
				<td>
					<img src="image/modules/icon-theme.png" style="padding:0px;" />
				</td>
				<td>
					<p style="width:330px;padding-right:30px;">
Theme module enables chanding different look and feel for the application by switching theme. 
					</p>
				</td>
				<td>
					<img src="image/modules/icon-language.png" style="padding:0px;" />
				</td>
				<td>
					<p>
Translation module allows you to pick preferred language pack and translate system strings without code change.
					</p>
				</td>				
			</tr>
			
			
			<tr>
				<td>
					<img src="image/modules/icon-log.png" style="padding:0px;" />
				</td>
				<td>
					<p>
Event Log module helps record user key activities like login, logout and purchase. It provides application admin a view for list all event logs. Developers can use this module to log all other user activities. </p>
				</td>	
				<td>
					<img src="image/modules/icon-help.png" style="padding:0px;" />
				</td>
				<td>
					<p>
Help module sets help tips for your application. The help tips link to the current page, it answers common questions on the page.
					</p>
				</td>				
			</tr>
			
			
			<tr>			
				<td>
					<img src="image/modules/icon-security.png" style="padding:0px;" />
				</td>
				<td>
					<p style="width:330px;padding-right:30px;">
Security module blocks unsecure requests out of application. It filters IP, keyword, in user requests with given time window. It plays a role like a firewall.</p>
				</td>
				<td>
					<img src="image/modules/icon-cronjob.png" style="padding:0px;" />
				</td>
				<td>
					<p>
Cronjob module provide user-friendly pages to set recurring execution jobs. For example, a job can generate report on every day midnight. </p>
				</td>				
			</tr>
			
		</table>
		
	<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >Download</a></td>
					<td><p>Download Openbiz Cubi today to boost your application development speed.</p>
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