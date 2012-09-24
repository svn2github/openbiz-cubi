<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>面向元数据编程 － Openbiz Framework － <?php echo SITE_NAME;?></title>
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
					<h2>只需描述业务逻辑和映射关系就够了！</h2>
					<p style="padding-bottom:12px;padding-top:4px;">
						让开发人员从繁重的代码劳动中解脱出来<br/>
						将精力更有效集中于思考核心业务逻辑
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
			<h2>为何要面向元数据</h2>
			<p>
				Openbiz框架的设计目标是使设计，开发和维护网络应用程序变的快捷和方便。Openbiz架构的主要创新是其基于元数据的设计。<br/>
				这意味着Openbiz对象是基于元数据文件中的描述的而创建的。对于Openbiz来说在大多数时间构建一个应用程序就相当于设置和开发他的元数据文件。<br/>
				由于XML语言的自我解释这一特性，使得Openbiz的应用程序十分易于维护，与此同时Openbiz是如同XML语言一样也一个具有丰富可扩展的框架。
			</p>
		</div>		
		<div class="page-splitter"></div>
		<div style="padding-top: 10px;padding-bottom:10px;padding-right:20px">
			<h2>面向元数据编程</h2>
			<img src="image/mo/pic-metadata.png" title="Openbiz Framework" style="padding-top: 2px;padding-bottom:10px;float:right;padding-left:20px"/>
			<p>
				Openbiz的核心理念在于他的基于元数据驱动的机制。什么是元数据呢？从字面上来解释，元数据是一个描述数据的数据组件。
				它是“关于数据的数据”。在Openbiz中元数据文件扮演着Openbiz类的配置文件。所有Openbiz核心类都是一般类。
				它们由不同的元数据重新赋予了不通的意义，它们分别代表着不同的事务与关系。
				例如：当StudentDO.xml关联到BizDataObj类时，这个BizDataObj实例就是一个“学生”对象，但当SchoolDO.xml 关联到BizDataObj类时，那么这个BizDataObj实例就成为了一个“学校”对象。
			</p>			
			<p>
				正因为Openbiz的类是被元数据所描述的，编写元数据文件就如同实现了一个类，
				因此，应用程序的开发工作大多数时候就转变成了编写元数据文件的工作，替代了传统意义上的编程。通过元数据的方式来描述应用程序将会使其具有更清晰的逻辑和设计。				
			</p>
			<table class="mo-code">
				<tr>
					<th>元数据可以实现什么</th>
					<th>元数据可以实现什么</th>
				</tr>
				<tr>
					<td> 描述对象的属性</td>
					<td rowspan="2">逻辑与功能。这部分应当在真正的程序代码中得以实现。“Class”属性可以使一个元数据绑定到任意一个自定义的对象上，从而实现特殊的逻辑与功能。</td></tr>
			    <tr>
			    	<td> 描述对象间的关系</td>
			    </tr>
			    <tr>
			    	<td> 描述表现层对象的渲染（显示）方法</td>
			    	<td rowspan="2"> 页面或者控件的布局。Openbiz的“TemplateFile”属性可以给一个页面或表单指定自定义的位web模板。</td>
			    </tr>
		    	<tr>
		    		<td>描述数据的有效性校验方法</td>
		    	</tr>
		     	<tr>
		     		<td>描述用户在页面上的交互行为</td>
		     	</tr>					
			</table>
		</div>
		<div class="page-splitter"></div>
		<h2>元数据的“包”管理</h2>						
			<p>
				优秀应用程序设计通常是模块化的。Openbiz推荐程序开发人员在 cubi/modules/ 这样的目录结构中创建自己的元数据。这也正是Openbiz Cubi遵循的标准。<br/>
				Openbiz源数据文件可以被组织为模块名和子目录名，这就像在Java中实现的包的概念。<br/>
				例如：PackageX.PackageY.metaA 这个命名和在 modules/PackageX/PackageY 目录中的metaA.xml是同一个概念。
			</p>
		<div class="page-splitter"></div>
		<div style="padding-bottom: 20px;">
			<h2>元数据与控制反转(IoC)的关系</h2>
			<p>
				了解 Java Spring 框架的读者应该对“控制反转”（Invese of Control，即IoC）的概念不陌生。<br/>
				IoC的基本概念是：不创建对象，但是描述创建它们的方式。在代码中不直接与对象和服务连接，<br/>
				但在配置文件中描述哪一个组件需要哪一项服务。容器负责将这些联系在一起。<br/>
				Openbiz框架可以被看作 IoC 的一个实现。框架本身是 IoC 容器，而其元数据则是对象的配置文件。<br/>
				以之前提到的范例，UserNewForm.xml 描述创建“用户”Form 对象的方式。其中的BizDataObj=“system.do.UserDO” 属性指定了该 Form 对象所需要的数据对象。
				Openbiz框架在运行时通过对象工厂将 UserNewForm 和 UserDO 的对象实例初始化，并把 UserDO 对象实例“注入”给 UserDO 对象。<br/>
				Openbiz框架实现了 IoC 容器之外的更多的功能。Openbiz将商业应用中最常用的类抽象出来作为框架的核心对象。
			</p>		
		</div>
		<div class="page-splitter"></div>
		<h2>元数据范例</h2>
		<p>
			让我们来看两个简单的元数据范例。UserDO.xml 代表了一个用户信息对象，<br/>
			UserNewForm.xml代表了一个创建该用户信息对象的表单，两段XML元数据的含义是可以实现自我解释的。
		</p>
		<img src="image/mo/pic-example.png" title="Openbiz Framework Code" style="padding-bottom:20px;padding-top:20px;" />
		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >免费获取</a></td>
					<td>
						<p>
							Openbiz Framework让开发人员从繁重的代码劳动中解脱出来，只需描述业务逻辑和映射关系就够了！<br/>
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