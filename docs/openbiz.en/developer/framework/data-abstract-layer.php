<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>数据抽象层 － Openbiz Framework － <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../../general/js/general.js" type="text/javascript"  ></script>

<!-- code prettify -->
<script src="../../general/js/codeprettify/prettify.js" type="text/javascript"  ></script>
<link href="../../general/js/codeprettify/prettify.css" rel="stylesheet" type="text/css" />

<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<link href="style/general.css" rel="stylesheet" type="text/css" />
<link href="style/data-abstract-layer.css" rel="stylesheet" type="text/css" />
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
		<div id="framework-dalayer-banner-wrapper" >
			<div id="framework-banner" class="banner" >
				<div class="desc">
					<h1 style="height:auto; padding-top:45px;"><a href="../framework.php"><img src="image/dalayer/banner-title.png" title="Openbiz Framework"/></a></h1>
					<h2>Handle data business logic</h2>
					<p style="padding-bottom:12px;padding-top:4px;">
						Map database table to object<br/>
						with XML metadata
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
			<h2>Data Abstraction</h2>
			<p>
				Openbiz DO can connect to all types of relational database supported by Zend_DB who provides the database abstraction layer on top of PDO and native database client. Developer can use Openbiz DO API for most database operations as well as Zend_DB API for advanced functions.
			</p>
			<p>
To connect to different types of database, user just needs to specify the database connection in Config.xml under your application root folder. Openbiz DO will invoke the correct drivers to connect database server. Openbiz is currently support MySQL, MSSQL, Oracle, PgSQL, Sqlite and etc.
</p>
<p>
Each Openbiz DO can have its own Database reference. This features enable the multiple databases connections in one application or even in one web page.
			</p>			
		</div>		
		<div class="page-splitter"></div>
		<div class="dalayer-list" style="padding-top: 10px;padding-bottom:10px;">
			<h2>ORM (Object-Relational-Mapping)</h2>
			<p>
				Openbiz implements necessary object/relational mapping (ORM) features to allow DO representing the data and relationships of database tables. Openbiz's Data layer core class is called "BizDataObj". This class defines the mapping between database tables and objects. The class can generate SQL from its metadata to conduct CRUD on database tables. The following table list the features of Openbiz ORM.
			</p>
			<h4>Flexible mapping</h4>
			<ul class="three-se">				
			     <li>Support table to object mapping. Table-per-class, N tables to 1 class</li>
			     <li>Support relationship mapping. Many to one, one to many, many to many, one to one</li>			
			</ul>
			<h4>Query facilities</h4>
			<ul class="three-se">
			     <li>Support SQL like query language</li>
			     <li>Support SQL functions and operators</li>
			     <li>Support SQL aggregate functions</li>
			     <li>Support group by, having and order by</li>
     		</ul>
			<h4>Metadata facilities</h4>
			<ul class="three-se">
		     	<li>Openbiz uses XML metadata describe the mapping</li>
		    </ul>
		</div>
		<div class="page-splitter"></div>
		<h2>Data Object API</h2>
			<p>
				Openbiz DO provides intuitive high level API for CURD operations. In order to assist developers to avoid hand coding SQL statements, Openbiz suggests using its Query Language. Please find more details in Data Object API from
			</p>
			<a href="http://code.google.com/p/openbiz-cubi/wiki/OpenbizFrameworkDataObject" target="_blank" style="padding-bottom:20px;display:block;">http://code.google.com/p/openbiz-cubi/wiki/OpenbizFrameworkDataObject</a>			
		<div class="page-splitter"></div>

		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >Download</a></td>
					<td>
						<p>
							Download Openbiz Framework today to create your business logic in Data Objects.
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