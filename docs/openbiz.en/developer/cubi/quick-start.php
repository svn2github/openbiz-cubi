<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Quick Start - Openbiz Cubi - <?php echo SITE_NAME;?></title>
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
	<?php require_once(SITE_ROOT_PATH.'/developer/cubi/_include/_cubi-navigation.php'); ?>
	<!-- site secondary navigation END -->
	
	<div id="cubi-intro-banner-wrapper" >
		<div id="cubi-quick-start-banner-wrapper" >
			<div id="framework-banner" class="banner" >
				<div class="desc">
					<h1 style="height:auto; padding-top:45px;"><a href="../cubi.php"><img src="image/quickstart/banner-title.png" title="Openbiz Cubi"/></a></h1>
					<h2>Learn how to use Openbiz Cubi</h2>
					<p style="padding-bottom:0px;padding-top:4px;">
						Start developing your first Cubi module <br/>
						Stand on the should of a solid platform
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
		<h2>Download and Install Openbiz Cubi</h2>
		<p>Follow the easy steps to get youself start Openbiz Cubi - download, unzip, then launch installation wizard.</p>
		<table class="present-features" cellspacing="0">
		<tr>
			<td>				
				<img src="image/quickstart/icon-env.png" />
			</td>
			<td>
				<h3>1. Prepare environment</h3>
				<p>Standard LAMP (Linux, Apache, Mysql, PHP) environment or WAMP (Windows, Apache, Mysql, PHP)</p>
			</td>			
		</tr>			
		<tr>
			<td>				
				<img src="image/quickstart/icon-get.png" />
			</td>
			<td>
				<h3>2. Get Openbiz Cubi</h3>
				<p>Download release packages or pull source code from <a href="http://code.google.com/p/openbiz-cubi/" target="_blank">Google project page</a></p>
			</td>			
		</tr>		
		<tr>
			<td>				
				<img src="image/quickstart/icon-unzip.png" />
			</td>
			<td>
				<h3>3. Unzip</h3>
				<p>
					Unzip Cubi source code to your web root directory.
				</p>
			</td>			
		</tr>
		<tr>
			<td>				
				<img src="image/quickstart/icon-lock.png" />
			</td>
			<td>
				<h3>4. Set permission</h3>
				<p>
					Give write permission on cubi installed directory to the web server user.
				</p>
			</td>		
		</tr>
		<tr>
			<td>				
				<img src="image/quickstart/icon-web.png" />
			</td>
			<td>
				<h3>5. Installation wizard</h3>
				<p>
					Open a web browser, launch Cubi installation wizard with http://localhost/cubi/install. Follow the wizard to complete installation.
				</p>
			</td>			
		</tr>				
		</table>
		<div class="page-splitter"></div>			
		<h2>Environment Requirements</h2>
		<table class="env-req">
			<tr>
				<td>
					<h4>Supported Operation Systems:</h4>
					
				</td>
				<td>
					Microsoft Windows 2008, Microsoft Windows 2003, FreeBSD, Linux, Macintosh
				</td>
			</tr>
			<tr>
				<td>
					<h4>Supported Web Servers:</h4>
					
				</td>
				<td>
					Apache Web Server 2.0, Microsoft IIS 6.0, Lighttpd 1.4
				</td>
			</tr>
			<tr>
				<td>
					<h4>Supported Databases:</h4>
					
				</td>
				<td>
					MySQL 5.0 (recommended), Oracle, Microsoft SQL Server, PostgreSQL
				</td>
			</tr>
			<tr>
				<td>
					<h4>PHP Runtime:</h4>
					
				</td>
				<td>
					PHP 5.2 with extensions, mod_curl, mod_pdo, mod_pdo-mysql, mod_mcrypt 
				</td>
			</tr>
			<tr>
				<td>
					<h4>Supported PHP Encoder：</h4>
					
				</td>
				<td>
					IonCube Loader
				</td>
			</tr>			
		</table>
		<div class="page-splitter"></div>			
		<h2>Documents</h2>
		<div class="other-resource">
				<p>The links below list Openbiz Cubi online documents</p>
				<ul>
					<li>Openbiz at Google Code <br/><a href="http://openbiz-cubi.googlecode.com" target="_blank">http://openbiz-cubi.googlecode.com/</a></li>
					<li>Openbiz Facebook page<br/><a href="http://www.facebook.com/OpenbizSolution" target="_blank">http://www.facebook.com/OpenbizSolution</a></li>
					<li>Openbiz discusion group<br/><a href="http://groups.google.com/group/openbiz-cubi" target="_blank">http://groups.google.com/group/openbiz-cubi</a></li>
					<li>Openbiz Chinese documents<br/><a href="http://docs.openbiz.cn" target="_blank">http://docs.openbiz.cn/</a></li>
					<li>Openbiz video at youku<br/><a href="http://u.youku.com/openbiz" target="_blank">http://u.youku.com/openbiz</a></li>
					<li>Openbiz video at tudou<br/><a href="http://www.tudou.com/home/Openbiz/" target="_blank">http://www.tudou.com/home/Openbiz</a></li>
					
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