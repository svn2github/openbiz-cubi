<?php include_once '../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Openbiz Framework － <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../general/js/general.js" type="text/javascript"  ></script>


<link href="general/style/general.css" rel="stylesheet" type="text/css" />
<link href="general/style/framework.css" rel="stylesheet" type="text/css" />
<script src="general/js/navigation.js" type="text/javascript" ></script>
<?php require_once(SITE_ROOT_PATH.'/general/_include/_site-analytics.php'); ?>
</head>

<body>
<div align="center" id="site-page-wrapper">
	<!-- site header START -->
	<?php require_once(SITE_ROOT_PATH.'/general/_include/_site-header.php'); ?>
	<!-- site header END -->  

	<!-- site secondary navigation START -->
	<?php require_once(SITE_ROOT_PATH.'/developer/general/_include/_developer-navigation.php'); ?>
	<!-- site secondary navigation END -->
	
	<div id="developer-framework-banner-wrapper"  >
		<div id="framework-banner-wrapper" style="height:358px;background-position:center -5px;">
			<div id="framework-banner" class="banner" >				
				<div class="desc" style="padding-top:80px;float:none;padding-left:500px;">
					<h1 style="height:auto;"><a href="framework"><img src="framework/image/banner-title.png" title="Openbiz framework"/></a></h1>
					<p>
						The Engine of Enterprise Applications<br/>
						Build applications on XML Metadata<br/>
						Pure OOP Opensource Web Framework
					</p>
					<p class="buttons">
						<a class="blue-button-go" href="#" >Download</a>
						<a class="gray-button" href="framework" >Know more</a>
					</p>
				</div>
				
				<table class="features">
						<tr>
							<td >
								<a href="framework/metadata-oriented.php" title="Openbiz Framework - Metadata">
								<img src="framework/image/icon-metadata.png" /><br/>Metadata
								</a>
							</td>
							<td >
								<a href="framework/architecture.php" title="Openbiz Framework - MVC">
								<img src="framework/image/icon-mvc.png" /><br/>MVC
								</a>
							</td>						
							<td>
								<a href="framework/data-abstract-layer.php" title="Openbiz Framework - ORM">
								<img src="framework/image/icon-orm.png" /><br/>ORM
								</a>
							</td>
							<td>
								<a href="framework/plugin-service.php" title="Openbiz Framework - Plugin">
								<img src="framework/image/icon-plugin.png" /><br/>Plugin
								</a>
							</td>
							<td>
								<a href="framework/index.php" title="Openbiz Framework - Opensource">
								<img src="framework/image/icon-opensource.png" /><br/>Opensource
								</a>
							</td>
							<td style="text-align: left;">
							 <p style="line-height:20px;padding-top:12px;">
							 Openbiz Framework is designed for enterprise applications<br/>PHP Object-Oriented Multi-layer application framework.<br/>
							 It helps software professionals to fast develop web applications.
							 </p>
							</td>
						</tr>
				</table>
			</div>
		</div>	
	</div>
	
	<div class="content">
			<table class="intro-table framework-intro" style="margin-bottom: 10px;">
				<tr>					
					<td>
						<div class="content-block" style="width: 310px;height:130px;">
						<a class="learn-more" href="framework/">Know more</a>						
						<h3  style="margin-bottom:10px;">Document</h3>
						<table class="features">
						<tr>
							<td>
								<img src="framework/image/banner-framework-book.png" height="90px;" title="Openbiz medal"/>
							</td>
							<td>
								<p>
									<a href="http://tinyurl.com/openbiz3-googledoc" target="_blank">Openbiz Developer Guide<br/></a> 
									<a href="http://docs.openbiz.cn" target="_blank">Openbiz 企业应用开发手册<br/></a> 
									<a href="http://code.google.com/p/openbiz-cubi/" target="_blank">Openbiz Cubi Google Project</a>
								</p>
							</td>
						</tr>
						</table>
						</div>
					</td>
					<td>
						<div class="content-block" style="width: 510px;height:130px;">
						<a class="learn-more" href="cubi/">Know more</a>						
						<h3  style="margin-bottom:10px;">Learn Openbiz Cubi</h3>
						<table class="features">
						<tr>
							<td>
								<img src="cubi/image/product-pic-small.png" title="Openbiz Cubi" style="width:60px"/>
							</td>
							<td>
								<p>
									Openbiz Cubi is the application platform built on top of Openbiz Framework. It provides a rich collection of common components and handy tools that fully demonstrates the power of the framework. With Openbz Cubi platform, developers can create applications with much higher productivity.
								</p>
							</td>
						</tr>
						</table>
						</div>
					</td>
				</tr>							
			</table>	
	</div>
    <!-- site footer START -->
	<?php require_once(SITE_ROOT_PATH.'/general/_include/_site-footer.php'); ?>
	<!-- site footer END -->    
</div> 
</body>
</html>