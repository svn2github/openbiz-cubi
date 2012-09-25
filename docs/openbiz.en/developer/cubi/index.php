<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>System Overview - Openbiz Cubi Platform - <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../../general/js/general.js" type="text/javascript"  ></script>


<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<link href="style/general.css" rel="stylesheet" type="text/css" />
<link href="style/introduction.css" rel="stylesheet" type="text/css" />
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
		<div id="cubi-introduction-banner-wrapper" >
			<div id="cubi-banner" class="banner" >
				<div class="desc">
					<h1 style="height:auto;"><a href="cubi/"><img src="image/introduction/banner-title.png" title="Openbiz Cubi Platform"/></a></h1>
					<h2 >Designed for enterprise application</h2>
					<p>Provide rich reusable components and fine-tuned UI<br/>Speed up data-drieven applications development</p>
					<p class="buttons">
						<a class="blue-button-go" href="#" >Download</a>
					</p>
				</div>
			</div>
		</div>	
	</div>
	
	
	<div class="content">
		<div class="page-splitter"></div>	
		<h2>What is Openbiz Cubi application development platform</h2>
		<p>
		Openbiz Cubi is a fast application development platform designed for business applications.
		It is built on top of the excellent Openbiz framework. It provides easy and intelligent development tools and implements almost all 		commonly used components, developers just need to work on their core business logic development. Openbiz Cubi makes application development so quick.
		</p>
		<p> 
		The latest Openbiz Cubi release includes a wide collection of user friendly UI elements.		
		</p>
		
		<div class="page-splitter"></div>
		<h2>Key Features</h2>
		<table class="features" cellspacing="0">
			<tr class="odd">
				<td>
					<img src="image/feature-icon-rapid-large.png" />
				</td>
				<td>
					<h3>Fast Application Development</h3>
					<p>All business and presentation compoenents are described by XML metadata which makes much easier to maintain applications. Cubi provide a set of tools to generate object metadata. It helps developers to create a CRUD page in several mouse clicks. Other development tools like Cubi AppBuilder provides a development workspace on your web browser. </p>
				</td>
				<td>
					<img src="image/feature-icon-clean-large.png" />
				</td>
				<td>
					<h3>Clear System Architecture</h3>
					<p>Openbiz Cubi is built on advanced object-oriented framework which uses technology including ORM, MVC, Dependency Injection, XML metadata. It has clean naming convension that is summarized from many real world application development experience. </p>
				</td>
				
			</tr>
			
			<tr>
				<td>
					<a href="rich-modules.php"><img src="image/feature-icon-module-large.png" /></a>
				</td>
				<td>
					<h3><a href="rich-modules.php">Rich Components</a></h3>
					<p>Openbiz Cubi has provided many ready-to-use components that all applications will need. For example, user-role-permission management, multi-language support, session choice, multi-level cache, and etc ...  <a href="rich-modules.php">Know more</a></p>
				</td>
				<td>
					<a href="screenshot.php"><img src="image/feature-icon-beauty-large.png" /></a>
				</td>
				<td>
					<h3><a href="screenshot.php">Cool User Interface</a></h3>
					<p>You don't have to spend much time in user interface design because Openbiz Cubi has tuned look and feel on each detail. Your Cubi based application will surely impress your clients with high product quality<a href="screenshot.php">Know more</a></p>
				</td>
				
			</tr>
			
			<tr  class="odd">
				<td>
					<img src="image/feature-icon-easy-large.png" />
				</td>
				<td>
					<h3>Easy Configurations</h3>
					<p>You don't need to do complicated code change or initiation in order to configure a Cubi function. Cubi provides user-friendly configuration pages for its system level functions. Even the application databases can be configured in a wizard by application admin. </p>
				</td>
				<td>
					<a href="create-your-brand.php"><img src="image/feature-icon-license-large.png" /></a>
				</td>
				<td>
					<h3><a href="create-your-brand.php">Business-friendly License</a></h3>
					<p>Openbiz Cubi uses BSD license. It allows you to build your own application and event sell it without worrying about legal issues. <a href="create-your-brand.php">Know more</a></p>
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