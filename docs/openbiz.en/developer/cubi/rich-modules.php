<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Rich Components － Openbiz Cubi Platform － <?php echo SITE_NAME;?></title>
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
		<h2>电子邮件集成</h2>
		<img src="image/modules/email-intergrated.png" style="padding:10px;padding-left:0px;" />
		<p  style="padding-bottom:20px;">在现代企业应用中，客户通常都会提出需要与电子邮件系统集成的需求，例如，通过电子邮件对关键事件进行通知，或者手动向指定人群批量发送系统邮件。
		Openbiz Cubi为此类应用设计了友好的用户界面，让您在开发此类应用的时候只需要将经历集中于如何触发邮件发送行为，而邮件内容模板如何让客户编辑，发件人SMTP帐号设定，邮件发送队列和发送日至这些将花掉您大部分精力而通常不容易被客户认可的事情，让Openbiz Cubi全部为您搞定就好了。
		</p>
		
		<div class="page-splitter"></div>	
		<h2>高级系统特性</h2>
		<img src="image/modules/system-mng.png" style="padding:10px;padding-left:0px;" />
		<p style="padding-bottom:20px;">Openbiz Cubi还为您考虑了更多高级系统特性，通过图形用户界面的方式来完成系统的各项设定，数据库链接池配置，<br/>
		系统备份还原，更新以及和外部系统对接的Web Service服务。
		</p>
		
		<div class="page-splitter"></div>	
		<h2>扩展特性</h2>
		<table class="module-intro－2column">
			<tr>			
				<td>
					<img src="image/modules/icon-oauth.png" style="padding:0px;" />
				</td>
				<td>
					<p style="width:330px;padding-right:50px;">
						Oauth扩展可以通过简单配置的方式，允许用户使用他们自己的社交网络帐号例如Facebook帐号，QQ空间帐号等登陆您的应用系统。而无需每次都输入密码验证身份。
					</p>
				</td>
				<td>
					<img src="image/modules/icon-help.png" style="padding:0px;" />
				</td>
				<td>
					<p>
						联机帮助模块管理用户界面左侧的帮助提示系统，您可以使用这个模块为您开发的应用作出更友好的使用帮助提示。
					</p>
				</td>				
			</tr>
			
			<tr>			
				<td>
					<img src="image/modules/icon-theme.png" style="padding:0px;" />
				</td>
				<td>
					<p style="width:330px;padding-right:30px;">
主题模块可以为系统安装、切换更多主题风格和界面，当您遇到对UI指定要求非常严格的用户时，您可以通过该模块为用户单独定制主题风格。
					</p>
				</td>
				<td>
					<img src="image/modules/icon-language.png" style="padding:0px;" />
				</td>
				<td>
					<p>
语言管理模块可以帮助您在不需要修改程序代码的情况下将您的应用系统快速翻译为多用户语言。
					</p>
				</td>				
			</tr>
			
			
			<tr>			
				<td>
					<img src="image/modules/icon-location.png" style="padding:0px;" />
				</td>
				<td>
					<p style="width:330px;padding-right:30px;">
该模块可以让您在为客户开发的应用中简单扩展地图特性。它底层调用Google 地图API，来完成丰富的用户交互，而您只许几行代码就可以为您的应用添加如此高级的特性。					</p>
				</td>
				<td>
					<img src="image/modules/icon-log.png" style="padding:0px;" />
				</td>
				<td>
					<p>
该模块帮您记录用户的关键行为，例如登陆、退出等操作。并提供友好的日志查看界面。您可以基于该模块为您的应用轻松扩展操作日志功能。					</p>
				</td>				
			</tr>
			
			
			<tr>			
				<td>
					<img src="image/modules/icon-security.png" style="padding:0px;" />
				</td>
				<td>
					<p style="width:330px;padding-right:30px;">
安全增强模块是Openbiz Cubi内建的安全及敏感信息过滤系统，可以对URL,POST,GET中的数据针对指定的关键词进行基于时间控制的过滤策略。					</p>
				</td>
				<td>
					<img src="image/modules/icon-cronjob.png" style="padding:0px;" />
				</td>
				<td>
					<p>
系统计划任务模块与操作系统底层的Cronjob对接，可以让您通过友好的用户界面的方式来管理您的应用中需要定期触发的业务逻辑，例如：每天夜间为用户生成数据报表等。					</p>
				</td>				
			</tr>
			
			
			<tr>			
				<td>
					<img src="image/modules/icon-cache.png" style="padding:0px;" />
				</td>
				<td>
					<p style="width:330px;padding-right:30px;">
系统高级缓存管理，用直观可视的方式让用户了解系统缓存的负载情况，可以允许用户手工对缓存数据进行清除操作。他让您用最直观的方式告诉您的客户，“看，它是这样工作的。”					</p>
				</td>
				<td>
				</td>
				<td>
				</td>				
			</tr>
			
		</table>
		
	<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >免费获取</a></td>
					<td><p>Openbiz Cubi具有丰富的应用模块，并其以涉及了几乎所有企业应用的周边业务逻辑，您仅需专注于核心业务逻辑即可。<br/>
						还等什么？赶快下载Openbiz Cubi，专为企业级应用开发而设计。</p>
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