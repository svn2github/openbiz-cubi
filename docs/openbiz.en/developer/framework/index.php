<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>底层框架概述 － Openbiz Framework － <?php echo SITE_NAME;?></title>
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
					<h2>企业应用系统动力之源</h2>
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
				Openbiz Framework是为搭建企业应用而设计的PHP的基于面向对象的快速开发框架。它可以帮助专业软件开发人员和技术咨询专家来构建用于网络上的企业级应用。<br/>
				由于企业级应用的高复杂性，系统开发通常会需要巨大投资和冗长的时间去进行工程计划，系统设计，原型设计，组件编码，功能测试，产品部署以及维护。<br/>
				Openbiz Framework的设计目标是节省构建复杂应用系统的开发投入和缩短开发时间。借助于Openbiz的帮助，应用程序的开发将基于完善的MVC架构建立，以<br/>
				Metadata驱动为核心描述业务逻辑，支持多种ORM逻辑，并且有Openbiz Appbuilder作为图形化集成开发环境的快速开发平台。
			</p>
		</div>		
		<div class="page-splitter"></div>
		<h2>优势特性</h2>
		<div>
			<h4>Metadata 驱动</h4>
			<p>				
				Openbiz Framework是以元数据(Metadata)驱动的框架。这意味着Openbiz对象（Objects）的创立是基于Metadata的描述文件。构建一个系统对象意味着设计和编写<br/>
				XML格式的Metadata文件。因此，基于Openbiz的应用软件包是完全可客户定制化的，而且是极其容易开发和维护的。
			</p>
			<h4>MVC架构</h4>
			<p>								
				Openbiz Framework内部集成了MVC（模型－视图－控制器）的设计模式。这使得基于Openbiz的应用非常容易来开发和管理，因为表述层的程序与商业数据和逻辑<br/>
				清楚地分离开来。
			</p>
			<h4>ORM（对象关系映射）</h4>
			<p>				
				Openbiz Framework的内核实现了高级ORM对象关系映射功能。Openbiz以BizDataObj数据对象来表述数据库表格和它们之间的逻辑关系。<br/>
				Openbiz支持的映射包括一对多，多对一，一对一、多对多和自我相关的对象逻辑关系，并且支持与标准结构化查询语言（SQL）相似的查询语言。
			</p>
			<h4>可扩展性系统服务</h4>
			<p>								
				Openbiz Framework允许开发人员通过实现插入式服务的方式编写自己的特殊逻辑。Openbiz服务对象同样是基于元数据驱动的对象。<br/>
				Openbiz Framework自身已经包含了很多功能实用的高级框架。例如：缓存管理服务，访问控制服务、电子邮件服务 和 数据查询服务等。
			</p>
			<h4>开放的许可协议</h4>
			<p>								
				Openbiz Framework 底层基于自由开放的BSD License 发布。您可以放心大胆的基于Openbiz Framework来构建您的商业应用软件，而无需担心版权问题。
			</p>
			<h4>成熟稳定且完善</h4>
			<p>												
				Openbiz Framework 创始于2003年，历经十余年发展完善，基于Openbiz框架的解决方案曾服务于三星电子、中国移动、工商银行、福田汽车众多国际品牌。<br/>
				可以轻松应对各种客户的制定需求的。
			</p>
		</div>
		<div class="page-splitter"></div>
		<h2>投资回报</h2>
		<div>
			<h4>更低成本</h4>
			<p>								
				由于Openbiz的免费许可证和短时的开发过程，你将花极少的费用在购买软件和雇佣咨询公司上，而且得到更好的产品。
			</p>
			<h4>迅速部署</h4>
			<p>								
				基于Openbiz的应用是完全可重配置的，这样它能够迅速因需求而变化。你将可以轻松满足用户不断变化的应用需求。
			</p>
			<h4>低维护费用</h4>
			<p>				
				管理Openbiz的Metadata比起管理混杂的程序源代码要简单得多。
			</p>
		</div>
		<div class="page-splitter"></div>
		<div class="testimonials">
			<h2>用户体验</h2>
			<p>
				基于Cubi实现了一套淘宝的会员信息管理和KPI统计分析（目前已发布在淘宝服务市场），在过程中感觉整个系统的开发我更多时间花在系统的需求整理和规则,<br/>
				其它如的新增、修改、删除等功能Cubi都已经帮我实现好了，并且模块之间都能够无缝对接无缝集成，相信在Cubi的不断完善下软件开发将不只是开发者的专属，开发软件将变的更轻松。<br/>
				－冯圣龙，中国
			</p>
			<p>
				我们正在想办法来代替公司以有的过时的用Visual Basic编写的程序。Openbiz是我们发现的最好的开发框架。<br/>
				－Andrew,美国
			</p>
			<p>
				我们花了两个月来研究不同的应用框架，Openbiz是唯一的系统，它能创建Web应用而不需要了解PHP编程。<br/>
				－Nik，保加利亚
			</p>
			<p>
				我高兴地给出A+，因为我对Openbiz的问题得到了迅速而且完美的解答。Openbiz Framework的确厉害！<br/>
				－Douglas，法国
			</p>
		</div>		
		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >免费获取</a></td>
					<td>
						<p>
							Openbiz Framework是面向对象的开源PHP框架<br/>
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