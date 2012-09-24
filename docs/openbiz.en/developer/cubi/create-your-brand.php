<?php include_once '../../config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>创建你的品牌 － Openbiz Cubi Platform － <?php echo SITE_NAME;?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link href="../../general/style/general.css" rel="stylesheet" type="text/css" />
<script src="../../general/js/jquery/jquery-1.7.2.min.js" type="text/javascript"  ></script>
<script src="../../general/js/general.js" type="text/javascript"  ></script>


<link href="../general/style/general.css" rel="stylesheet" type="text/css" />
<link href="style/general.css" rel="stylesheet" type="text/css" />
<link href="style/license.css" rel="stylesheet" type="text/css" />
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
	
	<div id="developer-banner-wrapper" >
		<div id="cubi-license-banner-wrapper" >
			<div id="cubi-banner" class="banner" >
				<div class="desc">
					<h1 style="height:auto;"><a href="cubi/"><img src="image/license/banner-title.png" title="Openbiz Cubi Platform"/></a></h1>
					<div style="padding-left:5px;">
					<h2 >基于Cubi创建你自己的品牌</h2>
					<p>Openbiz Cubi友好开放的使用许可协议 <br/>允许您在其之上打造您的自有品牌</p>
					<p class="buttons">
						<a class="blue-button-go" href="#" >免费获取</a>
					</p>
					</div>
				</div>
			</div>
		</div>	
	</div>
	
	
	<div class="content">
		<div class="page-splitter"></div>	
		<h2>友好、开放的许可协议</h2>
		<p>
		它的设计就是为了让您可以站在我们的肩膀上前进。Openbiz Cubi的许可协议如果系统自身一样高度开放。
		它允许您可以合法的再其之上构建<br />您自己的商业应用程序甚至您的自有品牌的产品。无须担心法律许可问题。
		</p>
		
		<div class="page-splitter"></div>
		<h2>替换您自己的Logo</h2>
		<p>简单到只需要点几下鼠标，就把它变成专为您的设计的产品。</p>
		<table class="replace-logo" style="padding:0px;padding-bottom:15px;" cellspacing="0">
			<tr >
				<td>
					<img src="image/license/replace-logo-step-1.png" />
				</td>
				<td>
					<img src="image/license/replace-logo-step-2.png" />
				</td>
				<td>
					<img src="image/license/replace-logo-step-3.png" />
				</td>
			</tr>			
		</table>
		
		<div class="page-splitter"></div>
		
		<h2>设计您自己的界面主题</h2>
		<p>简单到只需要点几下鼠标，就把它变成专为您的设计的产品。</p>
		<img src="image/license/custom-theme.png" style="padding-bottom:15px;"/>
		<p>为了真正要让他从内向外的改头换面，您还可以为Openbiz Cubi来定制符合您的企业形象的主题风格。例如，把整体颜色改为红色、把左右菜单的布局换个位置，甚至让他完全变个摸样（但依然保留所有高级特性）。</p>
		
		<div class="page-splitter"></div>
		<h2>打造您自己的产品</h2>
		<p>Openbiz Cubi主题风格基于标准的Smarty模板引擎构建，修改模板只需要了解HTML和Smarty的基础语法即可上手。</p>
		<table class="custom-theme" style="padding:0px;padding-bottom:15px;padding-top:10px;" cellspacing="0">
			<tr >
				<td>
					<img src="image/license/custom-step-1-title.png" style="display: block;padding-bottom:10px;" />
					<img src="image/license/custom-step-1.png" style="border:3px solid #cccccc;" />
				</td>
				<td>
					<img src="image/license/custom-step-2-title.png"  style="display: block;padding-bottom:10px;"/>
					<img src="image/license/custom-step-2.png" style="border:3px solid #cccccc;"/>
				</td>
				<td>
					<img src="image/license/custom-step-3-title.png"  style="display: block;padding-bottom:10px;" />
					<img src="image/license/custom-step-3.png" style="border:3px solid #cccccc;"/>
				</td>
			</tr>			
		</table>
		
		<!-- 页面底部的购买区域 开始 -->
		<div class="page-splitter"></div>
		<div class="bottom-info-block">
			<table>
				<tr>
					<td><a class="blue-button-go" href="#" >免费获取</a></td>
					<td><p>
						Openbiz Cubi友好开放的使用许可协议允许您在其之上打造您的自有品牌。<br/>
						赶快下载Openbiz Cubi，专为企业级应用开发而设计。</p>
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