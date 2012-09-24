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
						企业应用系统动力之源<br/>
						基于元数据的面向企业应用而设计的<br/>
						极致面向对象的开源PHP框架
					</p>
					<p class="buttons">
						<a class="blue-button-go" href="#" >免费获取</a>
						<a class="gray-button" href="framework" >了解详情</a>
					</p>
				</div>
				
				<table class="features">
						<tr>
							<td >
								<a href="framework/metadata-oriented.php" title="Openbiz Framework - 面向元数据">
								<img src="framework/image/icon-metadata.png" /><br/>面向元数据
								</a>
							</td>
							<td >
								<a href="framework/architecture.php" title="Openbiz Framework - MVC 架构">
								<img src="framework/image/icon-mvc.png" /><br/>MVC 架构
								</a>
							</td>						
							<td>
								<a href="framework/data-abstract-layer.php" title="Openbiz Framework - ORM 映射">
								<img src="framework/image/icon-orm.png" /><br/>ORM 映射
								</a>
							</td>
							<td>
								<a href="framework/plugin-service.php" title="Openbiz Framework - 扩展服务">
								<img src="framework/image/icon-plugin.png" /><br/>扩展服务
								</a>
							</td>
							<td>
								<a href="framework/index.php" title="Openbiz Framework - 开源免费">
								<img src="framework/image/icon-opensource.png" /><br/>开源免费
								</a>
							</td>
							<td style="text-align: left;">
							 <p style="line-height:20px;padding-top:12px;">
							 Openbiz Framework是为搭建企业应用而设计的<br/>PHP的基于面向对象的快速开发框架。<br/>
							 它可以帮助专业软件开发人员来构建用于网络上的企业级应用。
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
						<a class="learn-more" href="framework/">了解更多</a>						
						<h3  style="margin-bottom:10px;">学习资料</h3>
						<table class="features">
						<tr>
							<td>
								<img src="framework/image/banner-framework-book.png" height="90px;" title="Openbiz medal"/>
							</td>
							<td>
								<p>
									<a href="http://docs.openbiz.cn" target="_blank">Openbiz 企业应用开发手册<br/></a> 
									Openbiz 开发手册 3.0 英文<br/>
									更多免费学习资料请参考如下网址<br/>
									<a href="http://code.google.com/p/openbiz-cubi/" target="_blank">谷歌项目页</a>
								</p>
							</td>
						</tr>
						</table>
						</div>
					</td>
					<td>
						<div class="content-block" style="width: 510px;height:130px;">
						<a class="learn-more" href="framework/">了解更多</a>						
						<h3  style="margin-bottom:10px;">框架开发工程师认证</h3>
						<table class="features">
						<tr>
							<td>
								<img src="framework/image/banner-framework-medal.png" title="Openbiz medal"/>
							</td>
							<td>
								<p>
									成为Openbiz认证研发工程师，Openbiz认证是一个卓越的行业标准，并且这绝对是证明你已经精通Openbiz商业应用开发技术的最佳方式。<br/>
									拥有此项认证意味着该您可以熟练的在基于Openbiz Cubi Platform应用平台之上搭建以数据处理为核心的企业级应用程序。
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