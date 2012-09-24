<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>快速上手指南 － Openbiz Framework － <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../../general/js/general.js" type="text/javascript"  ></script>


<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<link href="style/general.css" rel="stylesheet" type="text/css" />
<link href="style/quick-start.css" rel="stylesheet" type="text/css" />
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
		<div id="framework-quick-start-banner-wrapper" >
			<div id="framework-banner" class="banner" >
				<div class="desc">
					<h1 style="height:auto; padding-top:45px;"><a href="../framework.php"><img src="image/quickstart/banner-title.png" title="Openbiz Framework"/></a></h1>
					<h2>轻便灵活的内建描述语言</h2>
					<p style="padding-bottom:12px;padding-top:4px;">
						将Openbiz部署到现有的系统 
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
		<h2>快速本地安装指南</h2>
		<p>Openbiz 允许开发人员通过实现插入式服务的方式编写自己的特殊逻辑。Openbiz服务对象同样是基于元数据驱动的对象。</p>
		<table class="present-features" cellspacing="0">
		<tr>
			<td>				
				<img src="image/quickstart/icon-env.png" />
			</td>
			<td>
				<h3>1、准备环境</h3>
				<p>根据习用环境要求，来安装设置所需软件</p>
			</td>			
		</tr>			
		<tr>
			<td>				
				<img src="image/quickstart/icon-get.png" />
			</td>
			<td>
				<h3>2、获取Cubi</h3>
				<p>通过完成在线订单的方式获取Cubi的下载地址并注册您的OpenbizID，不必担心此过程免费。您的OpenbizID将用于您日后获取技术支持使用。</p>
			</td>			
		</tr>		
		<tr>
			<td>				
				<img src="image/quickstart/icon-modify.png" />
			</td>
			<td>
				<h3>3、修改参数</h3>
				<p>
					将Cubi源代码包内的文件 解压缩到您的Web文件夹中的openbiz文件夹。
					通过您常用的文本编辑器打开 openbiz/sys_init.php 并更具您的实际情况参考备注信息修改参数设置。
				   （如果您是使用Openbiz创建新的应用通常不需要设置）
				</p>
			</td>			
		</tr>
		<tr>
			<td>				
				<img src="image/quickstart/icon-install.png" />
			</td>
			<td>
				<h3>4、集成部署</h3>
				<p>
					创建一个helloworld.php 文件通过require_once 将刚才的openbiz/sys_init.php 包含进来。在该文件内输入如下内容：
					echo "Openbiz Framework Version: ".BizSystem::getVersion();
				</p>
			</td>		
		</tr>
		<tr>
			<td>				
				<img src="image/quickstart/icon-test.png" />
			</td>
			<td>
				<h3>5、测试 </h3>
				<p>
					打开浏览器，输入http://localhost/sample.php，
					如果您可以顺利看到Openbiz框架的版本号显示，证明您已经成功的将Openbiz部署成功。
				</p>
			</td>			
		</tr>
		<tr>
			<td>				
				<img src="image/quickstart/icon-ok.png" />
			</td>
			<td>
				<h3>6、完成！</h3>
				<p>完成了！开始Openbiz为您带来新开发体验吧。现在您可以根据教程中的范例来开始练习和学习了。</p>
			</td>			
		</tr>				
		</table>
		<div class="page-splitter"></div>			
		<h2>系统环境要求</h2>
		<table class="env-req">
			<tr>
				<td>
					<h4>支持操作系统:</h4>
					
				</td>
				<td>
					Microsoft Windows 2008,Microsoft Windows 2003,FreeBSD,Linux,Macintosh
				</td>
			</tr>
			<tr>
				<td>
					<h4>支持Web服务器:</h4>
					
				</td>
				<td>
					Apache Web Server 2.0,Microsoft IIS 5.0,Lighttpd 1.4
				</td>
			</tr>
			<tr>
				<td>
					<h4>支持数据库:</h4>
					
				</td>
				<td>
					MySQL 5.0 (推荐),Microsoft SQL Server,PostgreSQL
				</td>
			</tr>
			<tr>
				<td>
					<h4>脚本引擎:</h4>
					
				</td>
				<td>
					PHP 5.3 并启用如下扩展,mod_curl,mod_pdo,mod_pdo-mysql,mod_mcrypt 
				</td>
			</tr>
			<tr>
				<td>
					<h4>加密引擎：</h4>
					
				</td>
				<td>
					IonCube Loader
				</td>
			</tr>			
		</table>
		<div class="page-splitter"></div>			
		<h2>学习资料</h2>
		<table class="learning-files">
			<tr>
				<td>					
					<img src="image/quickstart/pic-video.png" />
				</td>
				<td>
					<h4>Windows XP 安装Openbiz Cubi 视频教程</h4>
					让我们通过短片来了解如何通过Openbiz Appbuilder来快速开发搭建企业级应用的雏形。以及它都为我们带来了哪些先进的高级特性。
					让我们通过短片来了解如何通过Openbiz Appbuilder来快速开发搭建企业级应用的雏形。
				</td>
			</tr>
			<tr>
				<td>
					<img src="image/quickstart/pic-video.png" />					
				</td>
				<td>
					<h4>Openbiz Cubi管理员视频教程</h4>
					让我们通过短片来了解如何通过Openbiz Appbuilder来快速开发搭建企业级应用的雏形。
					以及它都为我们带来了哪些先进的高级特性。让我们通过短片来了解如何通过Openbiz Appbuilder来快速开发搭建企业级应用的雏形。
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<h4>通过范例学习Openbiz Cubi应用开发</h4>
					让我们通过短片来了解如何通过Openbiz Appbuilder来快速开发搭建企业级应用的雏形。以及它都为我们带来了哪些先进的高级特性。
					让我们通过短片来了解如何通过Openbiz Appbuilder来快速开发搭建企业级应用的雏形。以及它都为我们带来了哪些先进的高级特性。
					<a href="#" target="_blank">阅读全文</a>
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<h4>Cubi快速开始构建应用程序</h4>
					让我们通过短片来了解如何通过Openbiz Appbuilder来快速开发搭建企业级应用的雏形。以及它都为我们带来了哪些先进的高级特性。
					让我们通过短片来了解如何通过Openbiz Appbuilder来快速开发搭建企业级应用的雏形。以及它都为我们带来了哪些先进的高级特性。
					<a href="#" target="_blank">阅读全文</a>
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<h4>如何撰写Cubi模块</h4>
					让我们通过短片来了解如何通过Openbiz Appbuilder来快速开发搭建企业级应用的雏形。以及它都为我们带来了哪些先进的高级特性。
					让我们通过短片来了解如何通过Openbiz Appbuilder来快速开发搭建企业级应用的雏形。以及它都为我们带来了哪些先进的高级特性。
					<a href="#" target="_blank">阅读全文</a>
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<h4>如何撰写Cubi模块</h4>
					让我们通过短片来了解如何通过Openbiz Appbuilder来快速开发搭建企业级应用的雏形。以及它都为我们带来了哪些先进的高级特性。
					让我们通过短片来了解如何通过Openbiz Appbuilder来快速开发搭建企业级应用的雏形。以及它都为我们带来了哪些先进的高级特性。
					<a href="#" target="_blank">阅读全文</a>
				</td>
			</tr>		
		</table>
		<div class="page-splitter"></div>
		<div class="other-resource">
			<h2>培训与学习资料</h2>
			<p>关于推荐的技术学习资料列表，请访问如下链接：</p>
			<ul>
				<li>Openbiz at Google Code <br/><a href="http://openbiz-cubi.googlecode.com" target="_blank">http://openbiz-cubi.googlecode.com/</a></li>
				<li>Openbiz 在线产品文档<br/><a href="http://docs.openbiz.cn" target="_blank">http://docs.openbiz.cn/</a></li>
				<li>优库视频学习资料<br/><a href="http://u.youku.com/openbiz" target="_blank">http://u.youku.com/openbiz</a></li>
				<li>土豆视频学习资料<br/><a href="http://www.tudou.com/home/Openbiz/" target="_blank">http://www.tudou.com/home/Openbiz</a></li>
				<li>Openbiz 新浪博客<br/><a href="http://blog.sina.com.cn/openbiz" target="_blank">http://blog.sina.com.cn/openbiz</a></li>
			</ul>
		</div>
		
		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >免费获取</a></td>
					<td>
						<p>
							您已经完全了解如何快速学习使用Openbiz Framework，那还等什么？<br/>
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