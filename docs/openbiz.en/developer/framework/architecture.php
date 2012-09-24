<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>系统技术框架 － Openbiz Framework － <?php echo SITE_NAME;?></title>
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
					<h2>先进的技术架构是构建系统的基础</h2>
					<p style="padding-bottom:12px;padding-top:4px;">
						基于元数据的面向企业应用而设计的<br/>
						极致面向对象的开源PHP框架
					</p>									
						<p style="width:100px;padding-top:15px;">
							<a class="blue-button-go" href="#" >免费获取</a>
						</p>
				</div>
			</div>
		</div>	
	</div>
	
	
	<div class="content">
		<div class="page-splitter"></div>	
		<div>
			<h2>框架介绍</h2>
			<p>
				Openbiz是一个多层结构体系。Openbiz应用程序被分为三层设计，表示层，业务逻辑层和数据抽象层，在Openbiz中：
			</p>
			<ul class="subtitle">
  				<li>表示层是由Openbiz视图和表单对象实现的。Openbiz还有额外的JavaScript库负责通过Ajax的方式与服务器后端的表示层对象通信。</li>
 				<li>商业逻辑层是由Openbiz数据对象 和 Openbiz 服务对象 实现的。</li>
 				<li>数据抽象层由Zend_DB来处理多类型关系数据库数据的操作。</li>
			</ul>
		</div>		
		<div class="page-splitter"></div>
		<div style="padding-top: 10px;padding-bottom:10px;">
			<h2>模块、视图与控制器 (MVC)</h2>
			<p>
				Openbiz的一个关键性特性就是它是一个基于模块-视图-控制器（MVC）设计模式的框架。这一特点使得基于Openbiz开发的应用程序更加便于管理。<br/>
				因为表现层（View）是与应用程序的数据和逻辑（Model）清晰的分离开的。所有用户与应用程序的交互全部由前端控制器来处理。
			</p>
			<img src="image/architecture/pic-mvc.png" title="Openbiz Framework" style="padding-top: 10px;padding-bottom:10px;"/>
			<p>
				比较Openbiz MVC和市场上主流的MVC框架例如JSF和Strusts等，Openbiz框架更加接近JSF，因为他们同样是基于对象的结构。<br/>
				Openbiz的视图层包括了视图对象，表单对象和表单控件等组件，这些对象在处理请求时都是可被访问的。
			</p>
		</div>
		<div class="page-splitter"></div>
		<h2>Openbiz 核心对象</h2>
			<img src="image/architecture/pic-core-object.png" title="Openbiz Framework" style="padding-top: 10px;padding-bottom:10px; padding-left:20px;float:right;"/>
			<p>
				任何应用都可以由两部分组成-后端和前端。通常的主要业务逻辑运行在后端，
				而用户界面在前端。在Openbiz中，后端主要为 “数据对象”或“服务对象”。前端主要有“表单对象”和“视图对象。”
      			数据对象（又名“DO”）是一个数据单元。Openbiz数据对象将数据库中的表和关系映射到系统对象中。
      			它在对象中封装了（创建，读取，更新和删除）等操作，并提供了高级搜索接口。   
			</p>			
			<p>
				一个数据对象包含了一组字段。在典型的用法中，一个数据对象映射到数据库中的表，并且每一个字段映射到数据表中的列或者SQL表达式。
				服务对象 服务对象（又名“Service”）是一个Openbiz的系统服务单元，其包含业务逻辑实现的一组函数（方法）。典型的Openbiz服务对象的范例是“用户身份验证服务” 和 “电子邮件服务”
				表单对象（又名“Form”）是用户界面区块的单元，它包含了一组相关的表单控件，他可以是一个标准的HTML表单，一个带有工具栏和导航条的HTML表格，一个图片列表等。一个表单对象包含了一组表单控件，它即可以是简单的也可以是高级的HTML控件。典型的使用方法是：一个表单对象映射到一个数据对象上，并把每一个表单对象上的表单控件分别映射到数据对象的字段上。
				视图对象（又名“View”）实际上是网页的页面别称。试图对象是表单对象的容器。你可以把视图对象（网页）想象为是地板，而表单对象就是依附在上面的瓷砖。
			</p>
		<div class="page-splitter"></div>
		<div style="padding-bottom: 20px;">
			<h2>Openbiz 代码结构</h2>
			<p>
				Openbiz 核心类库和代码结构如下
			</p>
			<table class="code-structure">
				<tr>
					<td>openbiz_root/</td>
				</tr>
				<tr>
					<td style="width: 100px;padding-right:100px;">--- bin/</td>
					<td>(openbiz 核心PHP源代码)</td>
				</tr>
				<tr>
					<td>------ data/</td>
					<td>(数据层类库)</td>
				</tr>
				<tr>
					<td>---------- private/</td>
					<td>(数据曾私有类库)</td>
				</tr>
				<tr>
					<td>------ easy/</td>
					<td>(表现层类库)</td>
				</tr>
				<tr>
					<td>---------- element/</td>
					<td>(HTML表单控件类库)</td>
				</tr>
				<tr>
					<td>------ service/</td>
					<td>(openbiz 核心服务类库)</td>
				</tr>
				<tr>
					<td>------ util/</td>
					<td>(工具类库)</td>
				</tr>
				<tr>
					<td>--- message/</td>
					<td>(openbiz字符串定义文件)</td>
				</tr>
				<tr>
					<td>--- metadata/</td>
					<td>(openbiz元数据文件夹)</td>
				</tr>
				<tr>
					<td>------ service/</td>
					<td>(openbiz服务包)</td>
				</tr>
				<tr>
					<td>--- others/</td>
					<td>(第三方类库)</td>
				</tr>
				<tr>
					<td>------ Smarty/</td>
					<td>(smarty包)</td>
				</tr>
				<tr>
					<td>------ zend/</td>
					<td>(Zend 框架)</td>
				</tr>					
			</table>
		</div>
		<div class="page-splitter"></div>
		<h2>第三方类库</h2>
		<p>
			Openbiz 尝试在系统中集成市场上最好的第三方类库，在Openbiz中大量使用的关键类库包括：    
		</p>
		<ul class="subtitle">
			<li> <strong>Zend 框架. Openbiz 在如下应用中使用了 Zend 框架</strong></li>
			<li class="non-background">数据库交互</li>
			<li class="non-background">多语言支持</li>
			<li class="non-background">数据有效性校验</li>
			<li class="non-background">电子邮件服务</li>
			<li class="non-background">高级缓存管理</li>
			<li class="non-background">JSON编码和解码</li>
			<li class="non-background"> PHP 模板</li>
			<li><strong>Smarty 模版系统.</strong></li>
			<li class="non-background">Smarty 是系统的主要模板引擎，应用于Openbiz表单对象和视图对象。</li>
			<li><strong>Javascript 类库</strong></li>
			<li class="non-background">Prototype.</li>
			<li class="non-background">Openbiz Ajax 客户端使用Prototype 库来实现类的继承和Ajax通信。</li>
			<li class="non-background">jQuery.</li> 
			<li class="non-background">jQuery 在 Openbiz Cubi 中的高级UI控件中被大量使用</li>
		</ul>	
		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >免费获取</a></td>
					<td>
						<p>
							先进的Openbiz Framework技术架构是构建系统的基础，极致面向对象的开源PHP框架<br/>
							赶快下载Openbiz Framework感受企业应用系统的动力之源。
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