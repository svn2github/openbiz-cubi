<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>可扩展系统服务 － Openbiz Framework － <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../../general/js/general.js" type="text/javascript"  ></script>


<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<link href="style/general.css" rel="stylesheet" type="text/css" />
<link href="style/plugin-service.css" rel="stylesheet" type="text/css" />
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
		<div id="framework-plugin-banner-wrapper" >
			<div id="framework-banner" class="banner" >
				<div class="desc">
					<h1 style="height:auto; padding-top:45px;"><a href="../framework.php"><img src="image/pluginservice/banner-title.png" title="Openbiz Framework"/></a></h1>
					<h2>确保无限的可扩展性</h2>
					<p style="padding-bottom:12px;padding-top:4px;">
						丰富的可扩展服务<br/>
						帮您快速解决更多应用问题
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
		<h2>Openbiz系统可扩展服务</h2>
		<p>Openbiz 允许开发人员通过实现插入式服务的方式编写自己的特殊逻辑。Openbiz服务对象同样是基于元数据驱动的对象。</p>
		<table class="present-features" cellspacing="0">
		<tr>
			<td>				
				<img src="image/pluginservice/icon-key.png" />
			</td>
			<td class="desc">
				<h4>访问控制服务</h4>
				<p>该服务可以帮助您实现基于固定角色的简单的用户访问权限控制。适合于简单应用。</p>
			</td>
			<td>
				<img src="image/pluginservice/icon-lock.png" />
			</td>
			<td class="desc">
				<h4>数据权限服务</h4>
				<p>该服务可以为数据可视性分离以及高级数据共享服务生成底层附加SQL查询规则。</p>
			</td>
		</tr>			
		<tr>
			<td>
				<img src="image/pluginservice/icon-tool.png" />
			</td>
			<td class="desc">
				<h4>系统工具服务</h4>
				<p>该服务帮您完成一些周边逻辑的常用函数。例如，字节显示转换、获取当前应用短URL等杂项工具</p>
			</td>
			<td>
				<img src="image/pluginservice/icon-cash.png" />
			</td>
			<td class="desc">
				<h4>货币服务</h4>
				<p>通常用于订单结算系统等应用。该服务提供底层货币汇率转换 和 本地化的显示逻辑。</p>
			</td>
		</tr>		
		<tr>
			<td>
				<img src="image/pluginservice/icon-firewall.png" />
			</td>
			<td class="desc">
				<h4>安全过滤服务</h4>
				<p>该服务可以根据其配置文件来实现网络数据包过滤。可以依赖该服务对敏感和危险信息进行屏蔽。</p>
			</td>
			<td>
				<img src="image/pluginservice/icon-cache.png" />
			</td>
			<td class="desc">
				<h4>系统缓存服务</h4>
				<p>该服务主要用于缓存系统级对象和数据为整体性能优化而设计。开发人员也可以通过调用其API实现应用层数据缓存</p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="image/pluginservice/icon-archive.png" />
			</td>
			<td class="desc">
				<h4>用户档案服务</h4>
				<p>该服务可以通过统一的方式快速创建和访问用户的详细资料。便于用户信息管理</p>
			</td>
			<td>
				<img src="image/pluginservice/icon-id.png" />
			</td>
			<td class="desc">
				<h4>身份审核服务</h4>
				<p>该服务是用户身份审核的抽象层，用于身份的审核验证环节，负责与用户数据库连接，类似于Unix的PAM将底层验证逻辑与上层应用分离。</p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="image/pluginservice/icon-system.png" />
			</td>
			<td class="desc">
				<h4>系统首选项服务</h4>
				<p>该服务可以允许您和用户设置或快速访问自定义的系统级或用户级配置参数。</p>
			</td>
			<td>
				<img src="image/pluginservice/icon-mail.png" />
			</td>
			<td class="desc">
				<h4>电子邮件服务</h4>
				<p>该服务封装了与SMTP服务器通讯的底层协议，提供简单友好调用接口给开发人员用户创建集成电子邮件通知特性的应用。</p>
			</td>
		</tr>
		<tr>
			<td>
				<img src="image/pluginservice/icon-favour.png" />
			</td>
			<td class="desc">
				<h4>系统日志服务</h4>
				<p>通过该服务的API借口可以方便的记录触发系统日志，并对日志信息的显示做了有好的多语言化处理</p>
			</td>
			<td>
				<img src="image/pluginservice/icon-list.png" />
			</td>
			<td class="desc">
				<h4>数值列表服务</h4>
				<p>该服务用于以本地化的方式数组将程序内预定义的数据字典元数据转换为便于程序调用的数组。</p>
			</td>
		</tr>				
		</table>
		<div class="page-splitter"></div>			
		<h2>创建你自己的扩展服务</h2>
		<p>
			服务代码存放在 bin/service 目录下，其元数据描述文件存放在 /metadata/service 目录下。
			服务元数据可以指定服务名称，实现的类名如同其它对象的元数据配置一样。服务对象元数据没有一个固定的格式，
			因此不同的系统服务可以有各自不同的元数据配置格式。
			Openbiz服务通常是有两部分组成：
		</p>
		<ul class="three-se">
			<li>服务的元数据</li>
  			<li>服务的实现类</li>
		</ul>
		<p>
			您可以简单的通过复制一个现有服务的元数据文件service_name.xml 和程序文件 service_name.php。再此之上编写您自己的Openbiz服务。
		</p>
		
		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >免费获取</a></td>
					<td>
						<p>
							Openbiz Framework丰富的可扩展服务，帮您快速解决更多应用问题<br/>
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