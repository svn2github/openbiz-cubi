<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Metadata Programming - Openbiz Framework - <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../../general/js/general.js" type="text/javascript"  ></script>


<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<link href="style/general.css" rel="stylesheet" type="text/css" />
<link href="style/metadata-oriented.css" rel="stylesheet" type="text/css" />
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
		<div id="framework-mo-banner-wrapper" >
			<div id="framework-banner" class="banner" >
				<div class="desc">
					<h1 style="height:auto; padding-top:45px;"><a href="../framework.php"><img src="image/mo/banner-title.png" title="Openbiz Framework"/></a></h1>
					<h2>Only Need Declare Login in XML</h2>
					<p style="padding-bottom:12px;padding-top:4px;">
						Free developers from heavy coding<br/>
						They can focus on implement core business logic
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
			<h2>Why Metadata Programming</h2>
			<p>
				The goal of Openbiz framework is to make design, development and maintenance of web applications quick and easy. The main innovation in Openbiz architecture is its metadata kernel. This means Openbiz objects are constructed based on description in their metadata files. Building an application means design and development of metadata files in most time. Due to the self-explanation nature of XML language, the application is easy to maintain. Meanwhile Openbiz is an extensible framework due to the extensible nature of XML.
			</p>
		</div>		
		<div class="page-splitter"></div>
		<div style="padding-top: 10px;padding-bottom:10px;padding-right:20px">
			<h2>Program with XML Metadata</h2>
			<img src="image/mo/pic-metadata.png" title="Openbiz Framework" style="padding-top: 2px;padding-bottom:10px;float:right;padding-left:20px"/>
			<p>
				The core concept of the Openbiz is its metadata-driven mechanism. What is metadata? From the dictionary, metadata is a component of data which describes the data. It is "data about data". Metadata files in Openbiz are actually the configuration files of Openbiz classes. All Openbiz core classes are general classes. They represent different things with association to different metadata. For example, when StudentDO.xml links to BizDataObj class, this BizDataObj instance is a student object. While when SchoolDO.xml links to BizDataObj class, then this BizDataObj instance becomes a school object. 
			</p>			
			<p>
				Because Openbiz classes are described with metadata, authoring metadata files is same as implementing a class. Thus, application development means authoring metadata files in most time, instead of traditional programming. Application described with the metadata files should have more clear logic and design.				
			</p>
			<table class="mo-code">
				<tr>
					<th>What can metadata do</th>
					<th>What cannot metadata do</th>
				</tr>
				<tr>
					<td>Describe the properties of objects</td>
					<td rowspan="2">Logic of function - this is implemented in real program classes. The "Class" attribute of a metadata can bind any custom class with the metadata.</td></tr>
			    <tr>
			    	<td>Describe relationship of objects</td>
			    </tr>
			    <tr>
			    	<td> Describe rendering behavior of objects</td>
			    	<td rowspan="2">Page or Form layout。Openbiz Form has “TemplateFile” attribute that specify template file which determines the layout.</td>
			    </tr>
		    	<tr>
		    		<td>Describe validation of the data</td>
		    	</tr>
		     	<tr>
		     		<td>Describe user interaction on a page</td>
		     	</tr>					
			</table>
		</div>
		<div class="page-splitter"></div>
		<h2>Manage metadata with package</h2>						
			<p>
				A good designed applications are usually built upon modules. Openbiz recommends developers to create their metadata under app/modules/ directory - this is what Openbiz Cubi does. Openbiz metadata files can be organized by module name and sub directory names. It is like the package concept used in Java. For example,
PackageX.PackageY.metaA.xml refers to the metaA.xml under modules/PackageA/PackageB directory. 
			</p>
		
		<div class="page-splitter"></div>
		<h2>Sample Metadata</h2>
		<p>
			Let's show two simple metadata samples - UserDO.xml represents a user data object and UserNewForm.xml represents a new event form. The the meaning the xml should be self-explained.
		</p>
		<img src="image/mo/pic-example.png" title="Openbiz Framework Code" style="padding-bottom:20px;padding-top:0px;" />
		<div class="page-splitter"></div>
		<div style="padding-bottom: 20px;">
			<h2>Metadata vs IoC (Invese of Control)</h2>
			<p>
				If you have used Java Spring framework, you would know the concept of IoC (Invese of Control)<br/>
				Dependency injection is the main method to implement Inversion of Control. The basic principle behind Dependency Injection (DI) is that objects define their dependencies (that is to say the other objects they work with) only through constructor arguments, arguments to a factory method, or properties which are set on the object instance after it has been constructed or returned from a factory method. Then, it is the job of the container to actually inject those dependencies when it creates the object.</p>
			<p>
				Openbiz framework is an implementation of IoC. The framework itself is the IoC container, and the metadata is the object configuration files. From the previous metadata samples, UserNewForm.xml describes create "user" Form object。Its BizDataObj="system.do.UserDO" attribute specifies DataObject instance of the Form.
				Openbiz framework creates UserNewForm and UserDO objects instances in its object factory, and inject UserDO object instance to UserDO object instance.</p>
			<p>
				Openbiz framework implements more functions beyond IoC container. Openbiz abstracts the most common logic as its core classes. 
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
							Download Openbiz framework today to free developers from heavy coding
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