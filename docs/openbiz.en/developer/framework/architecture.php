<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Architecture - Openbiz Framework - <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../../general/js/general.js" type="text/javascript"  ></script>


<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<link href="style/general.css" rel="stylesheet" type="text/css" />
<link href="style/architecture.css" rel="stylesheet" type="text/css" />
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
		<div id="framework-architecture-banner-wrapper" >
			<div id="framework-banner" class="banner" >
				<div class="desc">
					<h1 style="height:auto; padding-top:45px;"><a href="../framework.php"><img src="image/architecture/banner-title.png" title="Openbiz Framework"/></a></h1>
					<h2>A great application needs solid framework</h2>
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
			<h2>Achitecture Overview</h2>
			<p>
				OpenBiz is designed with multi-layer object oriented architecture. Openbiz application is modulated to 3 layers - Presentation layer, Business Logic layer and Data Integration layer. In Openbiz:
			</p>
			<ul class="subtitle">
  				<li>Presentation layer is implemented by Openbiz View and Form. Openbiz has additional javascript library that communicate with server side presentation objects.</li>
 				<li>Business Logic layer is implemented by Openbiz DO as well as Openbiz Service.</li>
 				<li>3rd party package Zend_DB handles data integration layer.</li>
			</ul>
		</div>		
		<div class="page-splitter"></div>
		<div style="padding-top: 10px;padding-bottom:10px;">
			<h2>Openbiz MVC</h2>
			<p>
				One of the key advantages of Openbiz is that it is a framework that follows the Model-View-Controller (MVC) design pattern. This makes Openbiz applications much more manageable because the presentation code (View) is cleanly separated from the application data and logic (Model). All user interactions with the application are handled by a front-end controller.
			</p>
			<img src="image/architecture/pic-mvc.png" title="Openbiz Framework" style="padding-top: 10px;padding-bottom:10px;"/>
			<p>
				Comparing Openbiz MVC with existing MVC frameworks in market such as JSF and Struts, Openbiz is more close to JSF because both are component based architecture. Openbiz's View layer comprises components of View, Form and Element. These components are accessible during request processing. 
			</p>
		</div>
		<div class="page-splitter"></div>
		<h2>Openbiz Core Objects</h2>
			<img src="image/architecture/pic-core-object.png" title="Openbiz Framework" style="padding-top: 10px;padding-bottom:10px; padding-left:20px;float:right;"/>
			<p>
				Any application can compose of two parts - back end and front end. The main business logic typically runs at back end, while the user interface is at front end. In Openbiz, back end will have Data object or Service object. The front end will have Form object and View object.
			</p>		
			<h3>Data Object</h3>
			<p>
			Data Object (aka “DO”) is an unit of data. Openbiz DO maps database tables and relationship to the object. It encapsulates CRUD (create, read, update and delete) operation in the object as well as provide interface for advanced search. A DO contains a set of Fields. In typical usage, a DO maps to database table(s), and a Field maps to a table column or a SQL expression.
			</p>
			<h3>Service</h3>
			<p>
			Service is an unit containing the implementation of business logic or a set of functions. Examples of Openbiz services are User Authentication Service and Email Service.
			</p>
			<h3>Form</h3>
			<p>			
			Form is an unit of UI block that contains a set of related elements. It can be a standard HTML form, a HTML table with toolbar and paging bar, an list of images, and so on. A Form contains a set of Elements which can be simple or advanced HTML controls. In typical usage, a Form maps to a DO, and an Element maps to a DO Field. 
			</p>
			<h3>View</h3>
			<p>
			View is an actual web page. View is the container of Forms. Considering a View (web page) is a area of floor, a Form is the individual tile.
			</p>
		<div class="page-splitter"></div>
		<div style="padding-bottom: 20px;">
			<h2>Openbiz code structure</h2>
			<p>
				Openbiz core library code structure
			</p>
			<table class="code-structure">
				<tr>
					<td>openbiz_root/</td>
				</tr>
				<tr>
					<td style="width: 100px;padding-right:100px;">--- bin/</td>
					<td>(openbiz core php source)</td>
				</tr>
				<tr>
					<td>------ data/</td>
					<td>(data layer classes)</td>
				</tr>
				<tr>
					<td>---------- private/</td>
					<td>(data layer non-public classes)</td>
				</tr>
				<tr>
					<td>------ easy/</td>
					<td>(presentation layer classes)</td>
				</tr>
				<tr>
					<td>---------- element/</td>
					<td>(html element classes)</td>
				</tr>
				<tr>
					<td>------ service/</td>
					<td>(openbiz core service classes)</td>
				</tr>
				<tr>
					<td>------ util/</td>
					<td>(utility helper classes)</td>
				</tr>
				<tr>
					<td>--- message/</td>
					<td>(openbiz message files)</td>
				</tr>
				<tr>
					<td>--- metadata/</td>
					<td>(openbiz metadata files)</td>
				</tr>
				<tr>
					<td>------ service/</td>
					<td>(openbiz service package)</td>
				</tr>
				<tr>
					<td>--- others/</td>
					<td>(third party libraries)</td>
				</tr>
				<tr>
					<td>------ Smarty/</td>
					<td>(smarty package)</td>
				</tr>
				<tr>
					<td>------ zend/</td>
					<td>(Zend framework)</td>
				</tr>					
			</table>
		</div>
		<div class="page-splitter"></div>
		<h2>Openbiz and 3rd Party Libraries</h2>
		<p>
			Openbiz tried to leverage the best 3rd party libraries on the market. The key libraries are heavily used in Openbiz include:    
		</p>
		<ul class="subtitle">
			<li> <strong>Zend Framework. Openbiz uses Zend Framework on</strong></li>
			<li class="non-background">Database interactions</li>
			<li class="non-background">Language support</li>
			<li class="non-background">Data Validation</li>
			<li class="non-background">Email service</li>
			<li class="non-background">Cache management</li>
			<li class="non-background">JSON decode and encode</li>
			<li class="non-background"> PHP template</li>
			<li><strong>Smarty template.</strong></li>
			<li class="non-background">Smarty is the main template engine used in Openbiz Form and View. For certain templates that need more complex rendering logic, Openbiz Form uses PHP template provided in Zend Framework.</li>
			<li><strong>Javascript Libraries</strong></li>
			<li class="non-background">Prototype.</li>
			<li class="non-background">Openbiz Ajax client uses Prototype library for class inheritance and Ajax communication</li>
			<li class="non-background">jQuery.</li> 
			<li class="non-background">jQuery is used in Openbiz Cubi for advanced UI elements </li>
		</ul>	
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