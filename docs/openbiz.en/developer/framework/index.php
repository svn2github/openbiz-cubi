<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Overview - Openbiz Framework - <?php echo SITE_NAME;?></title>
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
	<?php require_once(SITE_ROOT_PATH.'/developer/framework/_include/_framework-navigation.php'); ?>
	<!-- site secondary navigation END -->
	
	<div id="framework-intro-banner-wrapper" >
		<div id="framework-introduction-banner-wrapper" >
			<div id="framework-banner" class="banner" >
				<div class="desc">
					<h1 style="height:auto; padding-top:45px;"><a href="../framework.php"><img src="image/introduction/banner-title.png" title="Openbiz Framework"/></a></h1>
					<h2>The Engine of Enterprise Applications</h2>
					<p style="padding-bottom:12px;padding-top:4px;">
						Build applications on XML Metadata<br/>
						Pure OOP Opensource Web Framework
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
		<div>
			<h2>Framework Overview</h2>
			<p>
				Openbiz is application framework that provides an object-oriented metadata-driven platform for application developers to build web application with least possible programming code. It helps developers and IT consultants to build web based applications based on a well designed infrastructure. <br/><br/>
				Due to the complexity of enterprise applications, a development project usually means big investment. It takes long time to plan, system design, prototyping, coding, tests and deployment and maintenance. With the help of Openbiz, applications development will be built on MVC (Model-View-Controller) model, have ORM (Object-Relational-Mapping) support and all logic are declared by XML metadata.
			</p>
		</div>		
		<div class="page-splitter"></div>
		<h2>Key Features</h2>
		<div>
			<h4>Metadata driven</h4>
			<p>				
				Openbiz Framework is Metadata-driven platform. It means objects are declared by XML metadata files. Creating an object is same as writing a XML metadata file. Thus, Openbiz based applications are fully configurable and very easy to maintain.
			</p>
			<h4>MVC (Model-View-Controller)</h4>
			<p>								
				Openbiz Framework uses MVC (Model-View-Controller) design model. It makes it for coding as the business and presentation logic are fully separated. 
			</p>
			<h4> ORM (Object-Relational-Mapping)</h4>
			<p>				
				Openbiz Framework core implemented ORM (Object-Relational-Mapping)。Openbiz uses BizDataObj class to describe relationship between database tables and objects. Openbiz support mappings include one to many, many to one, one to one and many to many. It also provides a SQL-like query language.
			</p>
			<h4>Pluggable Service</h4>
			<p>								
				Openbiz Framework allows developers to implement their business logic in plug-in services. Openbiz Service objects are also based on XML metadata. Openbiz Framework has already provided some common services such as cache service, access service, email service and data query service.
			</p>
			<h4>Open License</h4>
			<p>								
				Openbiz Framework is released with BSD License. You are free to use Openbiz Framework to build your commercial or non-commercial applications.
			</p>
			<h4>Mature and Stable</h4>
			<p>												
				Openbiz Framework was started on 2003. It is a proven sofware that has been used by world-wide companies including China Mobile, Samsung Electronics, Chinese Commecial Bank, Foton Automobile, as well as many small and midsize companies. 
			</p>
		</div>
		<div class="page-splitter"></div>
		<h2>ROI (Return of Investment)</h2>
		<div>
			<h4>Low cost</h4>
			<p>								
				Due to the Openbiz opensource license and short development cycle, you are able to create great applications with much less spending on buying software and hiring consultants.
			</p>
			<h4>Fast deployment</h4>
			<p>								
				Since Openbiz based applications are fully configurable, you can adjust the implmentation easily to the fast changed requirements from your clients or end users.
			</p>
			<h4>Low maintenance effort</h4>
			<p>				
				Managing Openbiz XML Metadata is much easier than managing complicated code. Even a non-technical person to help maintaining the XML source.
			</p>
		</div>
	
		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >Download</a></td>
					<td>
						<p>
							Download Openbiz Framework today to feel the power of the well designed engine.
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