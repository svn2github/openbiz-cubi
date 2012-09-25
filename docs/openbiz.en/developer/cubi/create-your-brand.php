<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Create Your Brand - Openbiz Cubi Platform - <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../../general/js/general.js" type="text/javascript"  ></script>


<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<link href="style/general.css" rel="stylesheet" type="text/css" />
<link href="style/license.css" rel="stylesheet" type="text/css" />
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
		<div id="cubi-license-banner-wrapper" >
			<div id="cubi-banner" class="banner" >
				<div class="desc">
					<h1 style="height:auto;"><a href="cubi/"><img src="image/license/banner-title.png" title="Openbiz Cubi Platform"/></a></h1>
					<div style="padding-left:5px;">
					<h2 >Use Cubi to build your brand</h2>
					<p>Openbiz Cubi business friendly license <br/>allows to build your branded applications</p>
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
		<h2>Business-Friendly Opensource License</h2>
		<p>
		The goal of the platform is to enable your application on top of itself. Openbiz Cubi is released with BSD opensource license. It allows you to build and pulish your own branded applications freely without worrying about legal issues. 
		</p>
		
		<div class="page-splitter"></div>
		<h2>User Your Own Logo</h2>
		<p>Simply click mouse to change logos and names to your own text</p>
		<table class="replace-logo" style="padding:0px;padding-bottom:15px;" cellspacing="0">
			<tr >
				<td>
					<p>Change Login Logo <br/>
					<img src="image/license/replace-logo-step-1.png" /></p>
					
					<p>Change Application Logo <br/>
					<img src="image/license/replace-logo-step-2.png" /></p>
					
					<p>Change Application Name <br/>
					<img src="image/license/replace-logo-step-3.png" /></p>
					
				</td>
			</tr>			
		</table>
		
		<div class="page-splitter"></div>
		
		<h2>Set Your Own Theme</h2>
		<p>You can rename the application by simple mouse clicks</p>
		<img src="image/license/custom-theme.png" style="padding-bottom:15px;"/>
		<p>You can pick the theme fit for your applications. For example, you can change the color to red, change the position of menu, or make any layout change.</p>
		
		<div class="page-splitter"></div>
		<h2>Code Custom Theme</h2>
		<p>Openbiz Cubi theme is based on standard Smarty or PHP tempalte, you can create your own theme by modifying default theme as long as your know HTML and Smarty.</p>
		<table class="custom-theme" style="padding:0px;padding-bottom:15px;padding-top:10px;" cellspacing="0">
			<tr >
				<td>
					<img src="image/license/custom-step-1-title.png" style="display: block;padding-bottom:10px;" />
					<img src="image/license/custom-step-1.png" style="border:3px solid #cccccc;" />
				</td>
				<td>
					<img src="image/license/custom-step-2-title.png"  style="display: block;padding-bottom:10px;"/>
					<img src="image/license/custom-step-2.png" style="border:3px solid #cccccc;"/>
				</td>
				<td>
					<img src="image/license/custom-step-3-title.png"  style="display: block;padding-bottom:10px;" />
					<img src="image/license/custom-step-3.png" style="border:3px solid #cccccc;"/>
				</td>
			</tr>			
		</table>
		
		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >Download</a></td>
					<td><p>
						Download Openbiz Cubi today to build your branded applications.<br/>
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